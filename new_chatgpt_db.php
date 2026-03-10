<?php
set_time_limit(0);
ini_set("memory_limit", "-1");
date_default_timezone_set('Asia/Tokyo'); //日本のタイムゾーンに設定
include_once('./db.inc.php');
$trial_count = 2;

$now  = date('Y-m-d H:i:s');
#$query = "SELECT u.id,u.shool_id,s.casq_10m FROM users u inner join speed_datas s on u.id = s.user_id where s.trial_count = 1 limit 1";
$query = "SELECT * FROM  speed_datas where trial_count=1 and user_id = 18 order by modified asc limit 0,100";
$query = "select * from speed_datas where advice_txt like ('%Aスキップ%') or advice_txt like ('%Bスキップ%' ) or advice_txt like ( '%ドラル%' ) or advice_txt like ('%B-Skip%' ) group by user_id";
$query = "select * from speed_datas where  char_length(advice_txt) < 10  group by user_id";
$query = "select * from speed_datas where  char_length(question_txt) < 10  group by user_id";
$query = "select * from speed_datas where user_id = 1";
$query = "SELECT * FROM  speed_datas where trial_count=2 order by modified asc";
$query = "SELECT * FROM  speed_datas where trial_count=2 and user_id = 707 order by modified asc limit 0,100";
$query = "SELECT * FROM  speed_datas where trial_count=2 and user_id = 12068 order by modified asc limit 0,100";
$query = "SELECT * FROM  speed_datas where trial_count=2 and char_length(advice_txt) < 10 and user_id IN ( 7315, 7369, 7300, 7366, 7400, 7284, 9552, 7357, 7377, 7383, 7306, 7285, 7301, 7353, 7311)";
$query = "select * from speed_datas where trial_count = 2 and char_length(question_txt) < 10 order by modified asc limit 0,2800";
$query = "SELECT * FROM  speed_datas where trial_count=2 and user_id = 12957 order by modified asc limit 0,100";
$query = "SELECT * FROM  speed_datas where trial_count=2 and user_id = 13278 order by modified asc limit 0,100";
$stmt = $dbh->query($query);
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

    $users['id'] = $row['user_id'];
    $users['user_id'] = $row['user_id'];
    $users['year'] = $row['year'];
    $users['user_school'] = $row['school_id'];

    $sql = "select count(user_id) cnt from speed_datas where user_id = {$users['id']} group by user_id";
    $ret = $dbh->query($sql);
    $res = $ret->fetch(PDO::FETCH_ASSOC);

    if ( $res['cnt'] > 1 ){
    list($user_rank,$gpt,$user_rank2,$best_time,$avg_ary) = get_rank( $users );
    $req_question2 = get_data( $users,$user_rank[($trial_count-1)] );
    $req_question1 = "前回の測定値は、".strstr($req_question2,"私",true);

    list($user_rank,$gpt,$user_rank2,$best_time,$avg_ary) = get_rank( $users );
    $req_question2 = get_data( $users,$user_rank[$trial_count] );
    $req_question2 =  $req_question1." 今回は、".$req_question2;
    #echo $req_question2;exit;
    } else {

    list($user_rank,$gpt,$user_rank2,$best_time,$avg_ary) = get_rank( $users );
    $req_question2 = get_data( $users,$user_rank[$trial_count] );
    }
#echo $req_question2;exit;
    
    list($req_question2,$question_txt) = chatgpt_api( $req_question2 );
#echo $question_txt;
#echo $req_question2;exit;
#continue;

    if ( strlen($req_question2)>500 ){
    $sql2 = "update speed_datas set advice_txt= '$req_question2', question_txt= '$question_txt',  modified='$now' WHERE user_id = {$users['id']} and trial_count=$trial_count";
#echo $sql2;exit;
    $dbh->query($sql2);
    $u =  get_user($users['id']);
    echo "END. {$users['id']}:: {$u['user_id']}\n";
    } else {
    echo "NG END. {$users['id']}\n";
    }

    for($i=0;$i>100;++$i){
        print("o");
        sleep(1);
    }
    echo "o\n";
}


function get_no1($param=null){
    global $dbh;
$col = $param[3];
switch($col){
    case 1: $col = 'casq_10m'; $sot = "asc"; break;
    case 2: $col = 'casq_30m'; $sot = "asc"; break;
    case 3: $col = 'casq_10m_act'; $sot = "asc"; break;
    case 4: $col = 'casq_5m_10m_5m'; $sot = "asc"; break;
    case 5: $col = 'standing_jump'; $sot = "desc"; break;
    case 6: $col = 'vertical_jump'; $sot = "desc"; break;
}
$user_id = $param[2];
$sql = "select (select user_id from users where id = speed_datas.user_id) id from speed_datas where year = $user_id and $col != 0 order by $col $sot limit 1";
$stmt = $dbh->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
return $row['id'];
}

function get_nen($param=null){
    global $dbh;
$query = "SELECT * FROM school_lists";
$stmt = $dbh->query($query);
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    foreach( $row as $key => $val ){
        $school_ary[$row['id']] = array_shift(explode("(",$row['school_name']));
    }
}

if ( $param == 4 ){
return  [
                1  => '一年级小学生',
                2  => '二年级小学生',
                3  => '三年级小学生',
                4  => '四年级小学生',
                5  => '五年级小学生',
                6  => '六年级小学生',
                11 => '初一',
                12 => '初二',
                13 => '初三',
                101=> '年少',
                102=> '年中',
                103=> '年長',
        ];
} else {
return  [
                1  => '小学1年生',
                2  => '小学2年生',
                3  => '小学3年生',
                4  => '小学4年生',
                5  => '小学5年生',
                6  => '小学6年生',
                11 => '中学1年生',
                12 => '中学2年生',
                13 => '中学3年生',
                101=> '年少',
                102=> '年中',
                103=> '年長',
        ];
}
}

function get_user($user_id){
    global $dbh;
// DBへ接続
try{

    if ( is_numeric($user_id) ){
	$query = "SELECT * FROM users WHERE id = '$user_id';";
    } else {
	$query = "SELECT * FROM users WHERE user_id = '$user_id';";
    }
	#$query = "SELECT * FROM users WHERE 1;";
	#echo $query;exit;
	$stmt = $dbh->query($query);

    // 表示処理
    if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	#var_dump( $row );
        #echo $row["user_name"];
	return $row;
    } else {
	return false;
    }

}catch(PDOException $e){
    print("データベースの接続に失敗しました".$e->getMessage());
    die();
}
}

function get_rank($users, $columns_ary = []){
    global $dbh;

    if ( empty($users) ){
        return false;
    }

    $user_id = $users['id'];
    $year = $users['year'];

    #try{
    #}catch(PDOException $e){
    #    return false;
    #}

    $sql = "SELECT * FROM speed_datas WHERE user_id = $user_id";
    $stmt = $dbh->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        if ( $year <> $row['year'] ){
            $year = $row['year'];
        }
        $user_trial[$row['trial_count']] = $row['trial_count'];
    }

    if ( is_null($year) ){
        return false;
    }

    // select * from (SELECT trial_count,user_id,standing_jump,RANK() OVER (PARTITION BY trial_count ORDER BY standing_jump DESC) as rank from speed_datas Where year=4) a where user_id in( 2063, 710 );
    list($data,$best) = get_best($users);
    $uid = $data['user_id'] ?? 0;
    $other = get_user(@$data['user_id']);
    $nen_ary = get_nen();
    $snm = get_school_name($other['user_school'])."({$nen_ary[$year]})";
    $effcUser = get_effc();
    $ef = @$other['user_name'].@$other['user_name2'];
    if ( in_array($ef,$effcUser) ){
        $ok_flag = $ef;
    } else {
        $ok_flag = false;
    }

    $ssql = [ "",  " AND school_id = {$users['user_school']} "];
    foreach( $ssql as $ii => $sql1 ){

    $user_rank = $speed_datas = $datas = [];
    $columns = [ "casq_10m",  "casq_30m",  "casq_10m_act",  "casq_5m_10m_5m",  "standing_jump", "vertical_jump" ]; 
    foreach( $columns as $col ){
        if ( $col == "standing_jump" || $col == "vertical_jump" ){
            $dec = "DESC";
        } else {
            $dec = "ASC";
        }
	    $query = "SELECT speed_date,trial_count,user_id,cast( format($col,2) as decimal(5,2) ) as $col ,RANK() OVER (PARTITION BY trial_count ORDER BY $col $dec) as rank from speed_datas WHERE $col > 0 AND year = $year $sql1";
        #echo $query."\n";
	    $stmt = $dbh->query($query);
        $all_count = $stmt->rowCount();
/*
        $rows = $stmt->fetchall(PDO::FETCH_ASSOC);
        $count= count($rows);
        foreach( $rows as $val ){
            if ( $val['user_id'] == $user_id ){
                $rank = $val['rank'];
                break;
            }
        }
*/
        #$point  = number_format((1-(((int)$rank - 1)/$count))*100);

#点数=(1−N順位−1​)×100

        // 表示処理
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $i = $row['trial_count'];
            if ( empty($user_trial[$i]) ) continue;
            $speed_datas[$i][$col][$row['user_id']] = $row;
            $datas[$i] = $i;
            if ( $row['user_id'] == $user_id ){
                $date[$i] = $row['speed_date'];
                $$col[$i] = $row[$col];
            }
            foreach( $columns_ary as $c => $vv ){
                if ( $c == $col && $vv == number_format($row[$col],2) ){
                    $column_rank[$c]['rank']['user_id'] = $row['user_id'];
                }
            }
        }

        #var_dump( $column_ary[$col]['rank'] );
        #echo $col."<BR>";
        #var_dump( $speed_datas[$i][$col][12068]['rank'] );
        #$all_count[$col] = count($speed_datas[$col]);
        #$column_ary['casq_10m']['rank'] = 788;

        #$all_count = count($speed_datas[$i][$col]);
        #$uid = $column_rank[$col]['rank']['user_id'];


        foreach( $datas as $v ){
            if ( $col == "standing_jump" || $col == "vertical_jump" ){
                $$col[$v] = number_format($$col[$v]);
            }
            $speed_datas[$v][$col][$user_id]['rank'] = ($speed_datas[$v][$col][$user_id]['rank']==NULL) ? $all_count : $speed_datas[$v][$col][$user_id]['rank'] ;
            $point  = number_format((1-(((int)$speed_datas[$v][$col][$user_id]['rank'] - 1)/count($speed_datas[$v][$col])))*100);
            $apoint  = number_format((1-(((int)@$speed_datas[$v][$col][$uid]['rank'] - 1)/count(@$speed_datas[$v][$col])))*100);

            $sql = "select advice_txt from speed_datas where user_id = {$users['id']} and trial_count=$v";
            $stmt2 = $dbh->query($sql);
            $rows = $stmt2->fetch(PDO::FETCH_ASSOC);
            if ( $point < 0 ){
                $point = 0;
            }
            if ( empty($point) ){
                $point = 0;
            }

            $user_rank[$v][$col] = [ 'date'=>$date[$v], 'nam'=> $snm, 'avg' => $apoint, 'rank' => $speed_datas[$v][$col][$user_id]['rank'], 'count' => ($all_count) ? $all_count : $old_all_count, 'point' => $point, 'time'=> $$col[$v], 'rank-time' => $data[$col], 'effc' => $ok_flag ];
            $gpt[$v] = $rows['advice_txt'];
        }

        $sql = "select format(avg($col),2) avg from speed_datas where year = $year $sql1";
        $stmt2 = $dbh->query($sql);
        $rows = $stmt2->fetch(PDO::FETCH_ASSOC);
        if ( $col == "standing_jump" || $col == "vertical_jump" ){
        $avg_ary[$ii][$col] = number_format($rows['avg']);
        } else {
        $avg_ary[$ii][$col] = $rows['avg'];
        }
        #echo $sql."\n";
        $old_all_count = $all_count;
    }
        $return_data[] = [$user_rank, $gpt];
    }

    $user_rank = $return_data[0][0];
    #$gpt       = $return_data[0][1];
    $user_rank2 = $return_data[1][0];
    #var_dump($avg_ary);
    #$school_flag = 2;
    #list($rank2,) =  get_rank( $users,[], $school_flag);
    #var_dump($user_rank);
    #var_dump($query);

    return [$user_rank, $gpt, $user_rank2, $best, $avg_ary];

}


function get_graph($user_rank){
    $columns = [ "casq_10m",  "casq_30m",  "casq_10m_act",  "casq_5m_10m_5m",  "standing_jump", "vertical_jump" ]; 
    $colors = [ 1 => "red",  "orange",  "skyblue",  "gray",  "papule", "green" ]; 
    $graph1 = $graph = $avg = [];
    if ( !is_array($user_rank) ) return;
    foreach( $user_rank as $i => $val ){
        $graph['label'] = ($i).'回目測定('.date('Y/m/d', strtotime($val['casq_10m']['date'])).")";
        $graph['data'] = [ 
            $val["casq_10m"]['point'], 
            $val["casq_30m"]['point'], 
            $val["casq_10m_act"]['point'], 
            $val["casq_5m_10m_5m"]['point'], 
            $val["standing_jump"]['point'], 
            $val["vertical_jump"]['point'] 
        ];
        if ( isset($val['casq_10m']['avg']) ){
            $avg['label'] = '上位者比較:'.$val['casq_10m']['nam'];
            $avg['data'][] = $val['casq_10m']['avg'];
        }
        if ( isset($val['casq_30m']['avg']) ){
            $avg['data'][] = $val['casq_30m']['avg'];
        }
        if ( isset($val['casq_10m_act']['avg']) ){
            $avg['data'][] = $val['casq_10m_act']['avg'];
        }
        if ( isset($val['casq_5m_10m_5m']['avg']) ){
            $avg['data'][] = $val['casq_5m_10m_5m']['avg'];
        }
        if ( isset($val['standing_jump']['avg']) ){
            $avg['data'][] = $val['standing_jump']['avg'];
        }
        if ( isset($val['vertical_jump']['avg']) ){
            $avg['data'][] = $val['vertical_jump']['avg'];
            $avg['borderColor'] = "gray"; 
        }
        $graph['borderColor'] = $colors[$i]; 
        $graph1[$i] = $graph;
    }
    foreach( $graph1 as $vals ){
        $graph2 = json_encode($vals);
        $graph3[] = $graph2;
    }
    if ( $graph3 ){
    $graph3 = join(",", $graph3);
    }

    $avg   = ($avg) ? ",".json_encode($avg) : [];
    $param = explode('/', $_SERVER['REQUEST_URI'] );
    if ( $param[1] == "692CJD5UEX" && $param[2] == 4 ){
    $graph .= ',{"label":"2\u56de\u76ee\u6e2c\u5b9a(2025\/08\/19)","data":["99","97","72","95","77","79"],"borderColor":"orange"}';
    $graph .= ',{"label":"3\u56de\u76ee\u6e2c\u5b9a(2025\/09\/19)","data":["99","98","85","98","80","93"],"borderColor":"skyblue"}';
    }
    return ['g' => $graph3, 'a' => $avg];

/*
{"label":"1\u56de\u76ee\u6e2c\u5b9a(2025\/06\/19)","data":["98","96","71","92","72","76"],"borderColor":"red"},{"label":"2\u56de\u76ee\u6e2c\u5b9a(2025\/08\/19)","data":["99","97","72","95","77","79"],"borderColor":"orange"},{"label":"3\u56de\u76ee\u6e2c\u5b9a(2025\/09\/19)","data":["99","98","85","98","80","93"],"borderColor":"skyblue"},
{"label":"1\u56de\u76ee\u6e2c\u5b9a(2025\/06\/18)","data":["50","42","74","26","40","30"],"borderColor":"red"},{"label":"2\u56de\u76ee\u6e2c\u5b9a(2025\/11\/18)","data":["67","67","67","67","67","67"],"borderColor":"orange"}],

{"label":{"1":"1\u56de\u76ee\u6e2c\u5b9a(2025\/06\/18)","2":"2\u56de\u76ee\u6e2c\u5b9a(2025\/11\/18)"},"data":{"1":["50","42","74","26","40","30"],"2":["67","67","67","67","67","67"]},"borderColor":{"1":"red","2":"orange"}},


*/
    
}

function get_user_year($year, $trial=1){
    global $dbh;

    if ( is_null($year) ){
        return false;
    }
    #$sql = "SELECT id FROM users Where user_status = 0 and year = $year";
    #$stmt = $dbh->query($sql);
    #$user_year = $stmt->fetchall(PDO::FETCH_COLUMN);

    $where_sql = " AND year = $year ";
    $sql = "SELECT trial_count,user_id,format(casq_10m,2) as casq_10m ,RANK() OVER (PARTITION BY trial_count ORDER BY casq_10m ASC) as rank from speed_datas where casq_10m>0 $where_sql AND trial_count = $trial";
    $stmt = $dbh->query($sql);
    $count = $stmt->rowCount();

    #var_dump($count);
    #var_dump( count($user_year) );
    $sql = "(SELECT trial_count,user_id,format(casq_10m,2) as casq_10m ,RANK() OVER (PARTITION BY trial_count ORDER BY casq_10m ASC) as rank from speed_datas where casq_10m>0 $where_sql limit 30) union (SELECT trial_count,user_id,format(casq_30m,2) as casq_30m ,RANK() OVER (PARTITION BY trial_count ORDER BY casq_30m ASC) as rank from speed_datas where casq_30m>0 $where_sql limit 30) union (SELECT trial_count,user_id,format(casq_10m_act,2) as casq_10m_act ,RANK() OVER (PARTITION BY trial_count ORDER BY casq_10m_act ASC) as rank from speed_datas where casq_10m_act>0 $where_sql limit 30) union (SELECT trial_count,user_id,format(casq_5m_10m_5m,2) as casq_5m_10m_5m ,RANK() OVER (PARTITION BY trial_count ORDER BY casq_5m_10m_5m ASC) as rank from speed_datas where casq_5m_10m_5m>0 $where_sql limit 30) union (SELECT trial_count,user_id,format(standing_jump,2) as standing_jump ,RANK() OVER (PARTITION BY trial_count ORDER BY standing_jump DESC) as rank from speed_datas where standing_jump>0 $where_sql limit 30) union (SELECT trial_count,user_id,format(vertical_jump,2) as vertical_jump ,RANK() OVER (PARTITION BY trial_count ORDER BY vertical_jump DESC) as rank from speed_datas where vertical_jump>0 $where_sql limit 30)";
    $stmt = $dbh->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
        @$user_ids[$user_id] += 1;
    }

    arsort($user_ids);
    $best_user = array_chunk($user_ids,10,1)[0];
    #var_dump( ($best_user) );
    $uid = ( array_rand($best_user) );
    #$uid = array_key_first($best_user);
    #$uid = 710;
    $query = "SELECT * FROM school_lists";
    $stmt = $dbh->query($query);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        foreach( $row as $key => $val ){
            $school_ary[$row['id']] = array_shift(explode("(",$row['school_name']));
        }
    }
    #var_dump( $school_ary );

    $sql = "SELECT * FROM speed_datas WHERE user_id = $uid";
    $stmt = $dbh->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
    }

    return [ 
        "year" => $year,
        "schoolname" => $school_ary[$school_id],
        "casq_10m" => $casq_10m,
        "casq_30m" => $casq_30m,
        "casq_10m_act" => $casq_10m_act,
        "casq_5m_10m_5m" => $casq_5m_10m_5m,
        "standing_jump" => $standing_jump,
        "vertical_jump" => $vertical_jump
    ]; 

}

function get_data($users, $user_rank){
    global $dbh;

    $year = $users['year'];
    $columns = [ 'casq_10m',  'casq_30m',  'casq_10m_act',  'casq_5m_10m_5m',  'standing_jump', 'vertical_jump' ]; 
    foreach( $columns as $col ){
        if ( $col == "standing_jump" || $col == "vertical_jump" ){
            $dec = "DESC";
        } else {
            $dec = "ASC";
        }
        $sql = "select '$col',format(avg($col),2)avg  from speed_datas where year = $year and $col>0";
        $sql = "select '$col',max($col)max,min($col)min,format(avg($col),2)avg  from speed_datas where year = 4 and $col>0";
	    $sql = "SELECT trial_count,user_id,format($col,2) time,RANK() OVER (PARTITION BY trial_count ORDER BY $col $dec) as rank from speed_datas Where year={$users['year']}";
        $stmt = $dbh->query($sql);
        $row = $stmt->fetchall(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();
        $cnt = floor($count/2);
        if ( $col == "standing_jump" || $col == "vertical_jump" ){
            $row[$cnt]['time'] = number_format($row[$cnt]['time']);
        }
        $year_avg[$col] = $row[$cnt];

        if ( $col ==  'casq_10m' && isset($user_rank[$col]) ){
            $gpt1 = "10メートル走は{$user_rank[$col]['time']}秒です。平均は{$year_avg[$col]['time']}秒です。";
            $gpt1 .= "学年順位は、{$user_rank[$col]['rank']}/{$count}位です。";
        }
        if ( $col ==  'casq_30m' ){
            $gpt2 = "30メートル走は{$user_rank[$col]['time']}秒です。平均は{$year_avg[$col]['time']}秒です。";
            $gpt2 .= "学年順位は、{$user_rank[$col]['rank']}/{$count}位です。";
        }
        if ( $col ==  'casq_10m_act' ){
            $gpt3 = "10メートルリアクション走は{$user_rank[$col]['time']}秒です。平均は{$year_avg[$col]['time']}秒です。";
            $gpt3 .= "学年順位は、{$user_rank[$col]['rank']}/{$count}位です。";
        }
        if ( $col ==  'casq_5m_10m_5m' ){
            $gpt4 = "5メートル-10メートル-5メートルリアクション走は{$user_rank[$col]['time']}秒です。平均は{$year_avg[$col]['time']}秒です。";
            $gpt4 .= "学年順位は、{$user_rank[$col]['rank']}/{$count}位です。";
        }
        if ( $col ==  'standing_jump' ){
            $gpt5 = "立ち幅跳びは{$user_rank[$col]['time']}cmです。平均は{$year_avg[$col]['time']}cmです。";
            $gpt5 .= "学年順位は、{$user_rank[$col]['rank']}/{$count}位です。";
        }
        if ( $col ==  'vertical_jump' ){
            $gpt6 = "垂直跳びは{$user_rank[$col]['time']}cmです。平均は{$year_avg[$col]['time']}cmです。";
            $gpt6 .= "学年順位は、{$user_rank[$col]['rank']}/{$count}位です。";
        }
    }

    $nen = get_nen();
    $req_question = '10メートル走は5.21秒です。平均は5.59秒です。5メートルリアクション走は1.8秒です。平均は2.0秒です。5-10-5メートルのアジリティ走は8秒です。平均>は9.01秒です。私は小学5年生です。アドバイスをお願いします。最後に一言、プロアスリートになるために、喝を入れてください。';
    $req_question2 = $gpt1.$gpt2.$gpt3.$gtp4.$gpt5.$gpt6.'私は'.$nen[$year].'です。アドバイスをお願いします。最後に、プロアスリートになるための心構えを教えてください。';

    return ($req_question2);

}


function get_avg($users){
    global $dbh;

    $sql = "SELECT user_id,year FROM users Where user_status = 0 and year = 1";
    $stmt = $dbh->query($sql);
    $user_id = $users['id'];

    #$ret = get_user_year($users['year']);

    // # id user_id casq_10m casq_30m casq_10m_act casq_5_10_5m standing_jump vertical_jump advice_txt tmp_user_id height weight speed_date created modified
    $columns = [ 'casq_10m',  'casq_30m',  'casq_10m_act',  'casq_5m_10m_5m',  'standing_jump', 'vertical_jump' ]; 
    foreach( $columns as $col ){
        if ( $col == "standing_jump" || $col == "vertical_jump" ){
            $dec = "DESC";
        } else {
            $dec = "ASC";
        }
	    $query = "SELECT trial_count,user_id,$col,RANK() OVER (PARTITION BY trial_count ORDER BY $col $dec) as rank from speed_datas Where year={$users['year']}";
        #$sql = "select max($col)max,min($col)min,format(avg($col),2)avg  from speed_datas where year = 4";
        #echo $sql."\n";

	    $stmt = $dbh->query($query);
        #echo $query."\n";
        // 表示処理
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        #echo $row["user_name"];
            $i = $row['trial_count'];
            $speed_datas[$i][$col][$row['user_id']] = $row;
            $datas[$i] = $i;
        }
        #$all_count[$col] = count($speed_datas[$col]);

        foreach( $datas as $v ){
            $point  = number_format((1-(((int)$speed_datas[$v][$col][$user_id]['rank'] - 1)/count($speed_datas[$v][$col])))*100);
            $user_rank[$v][$col] = [ 'rank' => $speed_datas[$v][$col][$user_id]['rank'], 'count' => count($speed_datas[$v][$col]), 'point' => $point];
        }
    }

    return  $user_rank;
}

function get_best($users=[], $ranking=null){
    global $dbh;

    $year = $users['year'] ?? 4;

/*
    $sql = "SELECT trial_count,user_id,format(casq_10m,2) as casq_10m ,RANK() OVER (PARTITION BY trial_count ORDER BY casq_10m ASC) as rank from speed_datas where casq_10m>0  AND year = $year  limit 1";
    $stmt = $dbh->query($sql);
    $sql = "SELECT trial_count,user_id,format(casq_30m,2) as casq_30m ,RANK() OVER (PARTITION BY trial_count ORDER BY casq_30m ASC) as rank from speed_datas where casq_30m>0  AND year = $year  limit 1"; 
    $stmt = $dbh->query($sql);
    $sql = "SELECT trial_count,user_id,format(casq_10m_act,2) as casq_10m_act ,RANK() OVER (PARTITION BY trial_count ORDER BY casq_10m_act ASC) as rank from speed_datas where casq_10m_act>0  AND year = $year  limit 1"; 
    $stmt = $dbh->query($sql);
    $sql = "SELECT trial_count,user_id,format(casq_5m_10m_5m,2) as casq_5m_10m_5m ,RANK() OVER (PARTITION BY trial_count ORDER BY casq_5m_10m_5m ASC) as rank from speed_datas where casq_5m_10m_5m>0  AND year = $year  limit 1"; 
    $stmt = $dbh->query($sql);
    $sql = "SELECT trial_count,user_id,standing_jump as standing_jump ,RANK() OVER (PARTITION BY trial_count ORDER BY standing_jump DESC) as rank from speed_datas where standing_jump>0  AND year = $year  limit 1"; 
    $stmt = $dbh->query($sql);
    $sql = "SELECT trial_count,user_id,vertical_jump as vertical_jump ,RANK() OVER (PARTITION BY trial_count ORDER BY vertical_jump DESC) as rank from speed_datas where vertical_jump>0  AND year = $year  limit 1";
    $stmt = $dbh->query($sql);
*/


    $where_sql = " AND year = $year ";
    $sql = "(SELECT trial_count,user_id,format(casq_10m,2) as casq_10m ,RANK() OVER (PARTITION BY trial_count ORDER BY casq_10m ASC) as rank from speed_datas where casq_10m>0 $where_sql limit 30) union (SELECT trial_count,user_id,format(casq_30m,2) as casq_30m ,RANK() OVER (PARTITION BY trial_count ORDER BY casq_30m ASC) as rank from speed_datas where casq_30m>0 $where_sql limit 30) union (SELECT trial_count,user_id,format(casq_10m_act,2) as casq_10m_act ,RANK() OVER (PARTITION BY trial_count ORDER BY casq_10m_act ASC) as rank from speed_datas where casq_10m_act>0 $where_sql limit 30) union (SELECT trial_count,user_id,format(casq_5m_10m_5m,2) as casq_5m_10m_5m ,RANK() OVER (PARTITION BY trial_count ORDER BY casq_5m_10m_5m ASC) as rank from speed_datas where casq_5m_10m_5m>0 $where_sql limit 30) union (SELECT trial_count,user_id,standing_jump as standing_jump ,RANK() OVER (PARTITION BY trial_count ORDER BY standing_jump DESC) as rank from speed_datas where standing_jump>0 $where_sql limit 30) union (SELECT trial_count,user_id,vertical_jump as vertical_jump ,RANK() OVER (PARTITION BY trial_count ORDER BY vertical_jump DESC) as rank from speed_datas where vertical_jump>0 $where_sql limit 30)";
    $stmt = $dbh->query($sql);
    $columns = [ 'casq_10m',  'casq_30m',  'casq_10m_act',  'casq_5m_10m_5m',  'standing_jump', 'vertical_jump' ]; 
    $old = '';
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        @$user_ids[$user_id] += 1;
        #$time_ary[$user_id] = 
        foreach($columns as $val ){
            if ( $row['rank']==1 && empty($ranks[$val]) && $old <> $row['casq_10m'] ){
                $ranks[$val] = $row['casq_10m'];
                $old = $row['casq_10m'];
                break;
            }
        }
    }

    if ( $year > 11 ){
        $rnd = $ranking ?? 3;
    } else {
        $rnd = $ranking ?? 10;
    }

    arsort($user_ids);
    $best_user = array_chunk($user_ids,$rnd,1)[0];
    $uid = ( array_rand($best_user) );
    if ( $uid == $users['user_id'] ){
        $uid = ( array_rand($best_user) );
    }
    if ( $uid == $users['user_id'] ){
        $uid = ( array_rand($best_user) );
    }
    $sql = "select user_id,format(casq_10m,2) casq_10m,  format(casq_30m,2) casq_30m,  format(casq_10m_act,2) casq_10m_act,  format(casq_5m_10m_5m,2) casq_5m_10m_5m,  standing_jump, vertical_jump from speed_datas Where user_id = $uid and trial_count = $trial_count";
    $stmt = $dbh->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    #var_dump($row);

    $columns = [ 'casq_10m',  'casq_30m',  'casq_10m_act',  'casq_5m_10m_5m',  'standing_jump', 'vertical_jump' ]; 
    foreach( $columns as $col ){
        #$sql = "select '$col',max($col)max,min($col)min,format(avg($col),2)avg from speed_datas where school_id = $school_id and year = $year and $col>0 and trial_count = $trial_count";
        #$school_times[$col] = $
    }

    return [$row, $ranks];
}

function get_school_name($school_id=null){
    global $dbh;

    $query = "SELECT * FROM school_lists";
    $stmt = $dbh->query($query);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        foreach( $row as $key => $val ){
            $school_ary[$row['id']] = array_shift(explode("(",$row['school_name']));
        }
    }

    if ( $school_id ){
        return $school_ary[$school_id];
    } else {
        return $school_ary;
    }
}

function get_advice($user_id){
    global $dbh;
    $users = get_user($user_id);
    $query = "SELECT * FROM  speed_datas where user_id = {$users['id']} order by trial_count desc";
    $stmt = $dbh->query($query);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $users['id'] = $row['user_id'];
        $users['user_id'] = $row['user_id'];
        $users['year'] = $row['year'];
        $trial_count = $row['trial_count'];

        list($user_rank,) = get_rank( $users );
        #error_log( print_r($user_rank) );
        $req_question2 = get_data( $users,array_pop($user_rank) );
        #error_log( $req_question2 );

        list($req_question2,$question_txt) = chatgpt_api( $req_question2 );

        $now  = date('Y-m-d H:i:s');
        $sql2 = "update speed_datas set advice_txt= '$req_question2', question_txt = '$question_txt',  modified='$now' WHERE user_id = {$users['id']} and trial_count=$trial_count";
        #error_log( $query );
        $dbh->query($sql2);

        #var_dump( $sql2 );
        #echo "END. {$users['id']}\n";
        return "OK_EFFC_OK";
    }

}

function chatgpt_api($req_question2){
$input_json = file_get_contents('php://input');
$post = json_decode( $input_json, true );
$req_question = $post['prompt'];

$result = array();

// APIキー
$apiKey = file_get_contents('/home/cmnfsqpx/casq_html/.apikey');
$apiKey = trim($apiKey);

//openAI APIエンドポイント
$endpoint = 'https://api.openai.com/v1/chat/completions';

#$req_question = '20メートル走は5.21秒です。平均は5.59秒です。5メートルリアクション走は1.8秒です。平均は2.0秒です。5-10-5メートルのアジリティ走は8秒です。平均は9.01秒です。私は小学5年生です。アドバイスをお願いします。最後に一言、プロアスリートになるために、喝を入れてください。';
$req_question = $req_question2;
$a = '出力には適宜、改行を入れてください。';
$b = '出力にはmarkdownで、適宜改行を入れてください。質問を促すアドバイスを入れないでください。';
$b .= '立ち幅跳びの数値が0の場合はアドバイスで触れないで下さい。測定前の数値になります。';
$b .= '垂直跳びの数値が0の場合はアドバイスで触れないで下さい。測定前の数値になります。';

#$b .= 'アドバイス内容に、スキップ系のアドバイスを入れないでください。A-Skip、B-Skip、Aスキップ、Bスキップ、A-スキップ、B-スキップが入る場合は違うトレーニング内容に変更して下さい';
#$b .= 'アドバイス内容に、AまたはBスキップの文言が入る場合は、その文言自体にgoogleで検索出来るHTMLリンクを付けてください。検索文字列は、[ABスキップ とは]にしてください。';
#$req_question .= $a;
$req_question .= $b;

$headers = array(
  'Content-Type: application/json',
  'Authorization: Bearer ' . $apiKey
);

// リクエストのペイロード
$data = array(
  //'model' => 'gpt-1o',
  //'model' => 'gpt-4o-2024-08-06',
  //'model' => 'gpt-4.5-preview',
  //'model' => 'gpt-4o-mini',
  //'model' => 'gpt-5-mini',
  //'model' => 'gpt-5-nano',
  'model' => 'gpt-4.1',
  'temperature' => 1.0,              // 応答のランダム性（0.0-1.0）
  'messages' => [
    [
    "role" => "system",
    "content" => "日本語で応答してください"
    ],
    [
    "role" => "user",
    "content" => $req_question
    ]
  ]
);

// cURLリクエストを初期化
$ch = curl_init();

// cURLオプションを設定
curl_setopt($ch, CURLOPT_URL, $endpoint);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// APIにリクエストを送信
$response = curl_exec($ch);
// cURLリクエストを閉じる
curl_close($ch);

// 応答を解析
$result = json_decode($response, true);
#$result = mb_convert_encoding($result, "UTF-8", "AUTO");

// 生成されたテキストを取得
$text = "> ".$result['choices'][0]['message']['content'];

return [$text, $req_question];
#echo $text;
#echo json_encode($text, JSON_PRETTY_PRINT);
}

function get_effc(){

    return [ '柳澤快斗', '寺島裕士', '神谷湊斗', '酒井駿希', '前田大雅', '小関結平', '中山晴翔', '福田海利', '惠美翔和', '嶋田篤人', '小野真優', '常木理翔', '舒文釗', '関井優羽斗', '稲本煌世', '床鍋友昭', '王杍瑜', '萱野雅悠', '坂田羽玖', '橋本琉生', '小松和暉', '川上真ノ介', '古川絢晴', '大串琉希有', '宇津原碧生', '松沢琥太朗', '前川原輝', '古川洸希', '菊地惟斗', '小林優太', '中谷悠真', '白珈宁', '黒川日丸', '村上結悠', '山﨑椋仁', '桜井真治', '千葉悠翔', '五十嵐翔平', '五十嵐煌', '嶋田響人', '湯本琥空', '齋藤風翔', '森川広晴', '澤井一晟', '山口颯月', '川井一成', '阿部純空', '河津圭次朗', '小林侑莉', '茂木懸太郎', '藤波怜央登', '芝崎海', '飯島理仁', '白田一葉', '渡邉隼汰', '荒木田航成', '渡部朝陽', '月井暁貴', '舟越駿', '山田凌雅', '斉藤恵士', '中久木仁飛', '中久木勇飛', '鍵本明来' ];

}
/**
(SELECT trial_count,user_id,format(casq_10m,2) as casq_10m ,RANK() OVER (PARTITION BY trial_count ORDER BY casq_10m ASC) as rank from speed_datas where casq_10m>0  AND year = 3  limit 30) union (SELECT trial_count,user_id,format(casq_30m,2) as casq_30m ,RANK() OVER (PARTITION BY trial_count ORDER BY casq_30m ASC) as rank from speed_datas where casq_30m>0  AND year = 3  limit 30) union (SELECT trial_count,user_id,format(casq_10m_act,2) as casq_10m_act ,RANK() OVER (PARTITION BY trial_count ORDER BY casq_10m_act ASC) as rank from speed_datas where casq_10m_act>0  AND year = 3  limit 30) union (SELECT trial_count,user_id,format(casq_5m_10m_5m,2) as casq_5m_10m_5m ,RANK() OVER (PARTITION BY trial_count ORDER BY casq_5m_10m_5m ASC) as rank from speed_datas where casq_5m_10m_5m>0  AND year = 3  limit 30) union (SELECT trial_count,user_id,standing_jump as standing_jump ,RANK() OVER (PARTITION BY trial_count ORDER BY standing_jump DESC) as rank from speed_datas where standing_jump>0  AND year = 3  limit 30) union (SELECT trial_count,user_id,vertical_jump as vertical_jump ,RANK() OVER (PARTITION BY trial_count ORDER BY vertical_jump DESC) as rank from speed_datas where vertical_jump>0  AND year = 3  limit 30);

select speed_datas.user_id, speed_datas.year as s_year, users.year as u_year, speed_datas.casq_10m, casq_30m from speed_datas inner join users on users.id = speed_datas.user_id and users.year <> speed_datas.year ;

MariaDB [cmnfsqpx_casq]> select id,year,user_birthday,user_name  from users where user_birthday  between '2018-04-02' and '2019-04-01' and year <> 1;
MariaDB [cmnfsqpx_casq]> select id,year,user_birthday,user_name  from users where user_birthday  between '2017-04-02' and '2018-04-01' and year <> 2;
MariaDB [cmnfsqpx_casq]> select id,year,user_birthday,user_name  from users where user_birthday  between '2016-04-02' and '2017-04-01' and year <> 3;
MariaDB [cmnfsqpx_casq]> select id,year,user_birthday,user_name  from users where user_birthday  between '2015-04-02' and '2016-04-01' and year <> 4;
MariaDB [cmnfsqpx_casq]> select id,year,user_birthday,user_name  from users where user_birthday  between '2014-04-02' and '2015-04-01' and year <> 5;
MariaDB [cmnfsqpx_casq]> select id,year,user_birthday,user_name  from users where user_birthday  between '2013-04-02' and '2014-04-01' and year <> 6;

**/
