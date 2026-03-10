<?php
include_once('db.inc.php');

// DBへ接続
try{

# cut -d"," -f4,5,7,8,15,16,18 urawa.csv | head
# 受講者姓,受講者名,認証KEY,グループID,カナ（姓）,カナ（名）,生年月日
# "柏淵","陽斗","946NUB9YL5","#0014","カシワブチ","ハルト","2016/07/01"
# "吉井","湊大","966SMMJS32","#0014","ヨシイ","ソウタ","2016/10/13"
#番号,名前,認証KEY,計測日,10m走,30m走,反応10m走,5-10-5mアジリティ走,立ち幅跳び(cm),垂直飛び(cm)
#id	user_id	casq_5m	casq_20m	casq_5_10_5m	standing_jump	vertical_jump	advice_txt	height	weight	speed_date	created	modified	

/*
  [0]=> string(1) "1"
  [1]=> string(12) "苗  辰一"
  [2]=> string(10) "21XNFYB84D"
  [3]=> string(10) "2025-06-18"
  [4]=> string(4) "2.42"
  [5]=> string(4) "6.17"
  [6]=> string(4) "3.18"
  [7]=> string(4) "7.27"
  [8]=> string(3) "138"
  [9]=> string(3) "20"
*/

	#$aa = file_get_contents("./CASQ_DATA/oomiya.csv");
	#$aa = file_get_contents("./CASQ_DATA/oomiya.csv");
	#$aa = file_get_contents("./CASQ_DATA/kawaguchi.csv");
	#$aa = file_get_contents("./CASQ_DATA/asaka.csv");
	#$aa = file_get_contents("./CASQ_DATA/hachiooji.csv");
	#$aa = file_get_contents("./CASQ_DATA/ichikawa.csv");
	#$aa = file_get_contents("./CASQ_DATA/kashiwa.csv");
	#$aa = file_get_contents("./CASQ_DATA/kawasaki.csv");
	#$aa = file_get_contents("./CASQ_DATA/makuhari.csv");
	#$aa = file_get_contents("./CASQ_DATA/minamiurawa2.csv");
	#$aa = file_get_contents("./CASQ_DATA/miyagi-tomi.csv");
	#$aa = file_get_contents("./CASQ_DATA/nishitokyo.csv");
	#$aa = file_get_contents("./CASQ_DATA/sakado.csv");
	#$aa = file_get_contents("./CASQ_DATA/shinyuri.csv");
	#$aa = file_get_contents("./CASQ_DATA/shirogane.csv");
	#$aa = file_get_contents("./CASQ_DATA/takasaki.csv");
	#$aa = file_get_contents("./CASQ_DATA/tamacenter.csv");
	#$aa = file_get_contents("./CASQ_DATA/tenkachaya.csv");
	#$aa = file_get_contents("./CASQ_DATA/yokohama.csv");
	#$aa = file_get_contents("./CASQ_DATA/toyocho.csv");
	#$aa = file_get_contents("./CASQ_DATA/yono.csv");
	#$aa = file_get_contents("./CASQ_DATA/urawa.csv");
	$aa = file_get_contents("./CASQ_DATA/0930/ueda.csv");
	$aa = file_get_contents("./CASQ_DATA/0930/ef-tokorozawa.csv");

    foreach( explode("\n",$aa) as $val ){
        $val = explode(",", $val);
        if ( is_numeric($val[0]) && is_numeric($val[4]) ){
        $val[3] = str_replace('日', '', $val[3]);  // "日"を空文字に置換する
        $val[3] = str_replace('年', '-', $val[3]); // "年"を"-"に置換する
        $val[3] = str_replace('月', '-', $val[3]); // "月"を"-"に置換する
        $val[3] = str_replace('/', '-', $val[3]); // "/"を"-"に置換する
        if ( strlen($val[3]) <7 ){
            if ( empty($val[3]) ){
                $val[3] = "2025/09/30";
            } else {
                $y = date('Y')."-";
            }
        }
        $date = date('Y-m-d', strtotime($y.$val[3]));
#echo $val[3]."::".$date;exit;
        $val[3] = $date;
        $val[9] = trim($val[9]);
        #$val[3] = '2025-06-19';
        $val[2] = mb_convert_encoding($val[2], "UTF-8", "AUTO");

        $query = "SELECT * FROM users WHERE user_id = '$val[2]'";
        $stmt = $dbh->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        #var_dump($row);
        if ( isset($row['id']) ){
            $user_id = $row['id'];
            $year = $row['year'];
            $school = $row['user_school'];
            $tmp_user_id = "0";
        } else {
            $val[1] = mb_convert_encoding($val[1], "UTF-8", "AUTO");
            $user_id = 1;
            $tmp_user_id = $val[2];
            echo $val[0]."::".$val[1].":".$tmp_user_id."\n";
            continue;
        }
        #var_dump($val);
        $val[4] = $val[4] ? $val[4] : 0;
        $val[5] = $val[5] ? $val[5] : 0;
        $val[6] = $val[6] ? $val[6] : 0;
        $val[7] = $val[7] ? $val[7] : 0;
        $val[8] = $val[8] ? $val[8] : 0;
        $val[9] = $val[9] ? $val[9] : 0;
        $sql = "INSERT INTO speed_datas (user_id,speed_date,casq_10m,casq_30m,casq_10m_act,casq_5m_10m_5m,standing_jump,vertical_jump,tmp_user_id,trial_count,year,school_id) values ($user_id, '{$val[3]}', $val[4], $val[5], $val[6], $val[7], $val[8], $val[9], '$tmp_user_id',1,$year,$school) ON DUPLICATE KEY UPDATE created = created, year = $year, school_id = $school, speed_date = '{$val[3]}'";
        echo $sql."\n";
		$dbh->query($sql);
        }
    }
exit;

    // クエリの実行
    $query = "SELECT * FROM users WHERE user_status = 0";
    $stmt = $dbh->query($query);

    // 表示処理
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo $row["user_name"];
    }

}catch(PDOException $e){
    print("データベースの接続に失敗しました".$e->getMessage());
    die();
}
// 接続を閉じる
$dbh = null;

