<?php
require_once("../casq_html/db.inc.php");

function getFiscalYearOfToday($start_date='04/01'){
  $today = date('Y/m/d');
  $start_year = date('Y').'/'.$start_date;// 2015/04/01 or 2016/04/01
  if(strtotime($today) >= strtotime($start_year)){
    // e.g. 2015.4.1 ~ 2015.12.31 => 2015
    $year = date('Y');
  }else{
    // e.g. 2016.01.01 ~ 2016.03.31 => 2015
    $year = date('Y') - 1;
  }
  return $year;
}

# 小学1年生	6歳・7歳	2018年(平成30年)4月2日～2019年(平成31年/令和元年)4月1日
$nedo = getFiscalYearOfToday();
#echo $nedo;exit;
$nen1 = $nedo - 7;
$nen_ary[1] = ['str' => "$nen1-04-02", 'end' => ($nen1+1)."-04-01"];
$nen_ary[2] = ['str' => ($nen1-1)."-04-02", 'end' => ($nen1)."-04-01"];
$nen_ary[3] = ['str' => ($nen1-2)."-04-02", 'end' => ($nen1-1)."-04-01"];
$nen_ary[4] = ['str' => ($nen1-3)."-04-02", 'end' => ($nen1-2)."-04-01"];
$nen_ary[5] = ['str' => ($nen1-4)."-04-02", 'end' => ($nen1-3)."-04-01"];
$nen_ary[6] = ['str' => ($nen1-5)."-04-02", 'end' => ($nen1-4)."-04-01"];
$nen_ary[11]= ['str' => ($nen1-6)."-04-02", 'end' => ($nen1-5)."-04-01"];
$nen_ary[12]= ['str' => ($nen1-7)."-04-02", 'end' => ($nen1-6)."-04-01"];
$nen_ary[13]= ['str' => ($nen1-8)."-04-02", 'end' => ($nen1-7)."-04-01"];

$nen_ary[101] = ['str' => ($nen1+3)."-04-02", 'end' => ($nen1+4)."-04-01"];
$nen_ary[102] = ['str' => ($nen1+2)."-04-02", 'end' => ($nen1+3)."-04-01"];
$nen_ary[103] = ['str' => ($nen1+1)."-04-02", 'end' => ($nen1+2)."-04-01"];
$gaku_ary = [
		1  => $nen_ary[1], 
		2  => $nen_ary[2], 
		3  => $nen_ary[3], 
		4  => $nen_ary[4], 
		5  => $nen_ary[5], 
		6  => $nen_ary[6], 
		11 => $nen_ary[11], 
		12 => $nen_ary[12],
		13 => $nen_ary[13],
		101=> $nen_ary[101], 
		102=> $nen_ary[102], 
		103=> $nen_ary[103], 
	];

$name_ary = [
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
	$query = "SELECT * FROM users order by modified asc limit 2000";
	$stmt = $dbh->query($query);
    $i=0;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        ++$i;

        foreach( $nen_ary as $year => $val ){
            if ( $val['str'] <= $row['user_birthday'] && $val['end'] >= $row['user_birthday'] ){
                if ( $year != $row['year'] ){
                    echo "[{$row['id']}]".$year."|".$row['year']."::".$row['user_birthday']."\n";sleep(1);
                } else {
                    echo "OK.($i)[{$row['year']}::$year]\n";
                    #echo "[{$row['id']}]".$year."|".$row['year']."::".$row['user_birthday']."\n";sleep(1);
                }
            }
        }

    }




exit;
	$query = "SELECT * FROM speed_datas WHERE this_year = $nedo AND trial_count = 1 order by modified asc";// limit 1000,100";
	$stmt = $dbh->query($query);
    $i=0;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        ++$i;

	    $query = "SELECT * FROM users WHERE id = {$row['user_id']}";
	    $res = $dbh->query($query);
		if($ret = $res->fetch(PDO::FETCH_ASSOC)){

            if ( $row['year'] != $ret['year'] ){
			    $query = "UPDATE users SET year = {$row['year']} WHERE id = {$row['id']}";
                $new = $nen_ary[$row['year']]['str'];
                echo $row['year']."::".$ret['user_name'].$ret['user_name2']."\n";
                echo $new."::".$ret['user_birthday']."\n";
                sleep(1);
            } else {
                echo "OK.($i)[{$ret['id']}]\n";
            }
			#$dbh->query($query);
		}
	}

