<?php
require_once("../casq_html/db.inc.php");

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

	#$aa = file_get_contents("./CASQ_DATA/0930/ueda.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/ef-tokorozawa.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/fukuoka-higashi.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/fukuoka-nishi.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/hakata-getu.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/hataka-kin.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/hidaka.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/inbata.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/iruma.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/kawagoe.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/kawaguchi-sui.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/kawasaki-kin.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/kisarazu.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/kokubunji.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/kounosu.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/machida.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/misato-yoshikawa.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/miyagi-nagamachi.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/miyagi-turu.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/molaju-kashiwa.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/okayama.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/sakado.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/suwa.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/tokorozawa.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/ueda.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/fujimino.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/kamata.csv");
	#$aa = file_get_contents("./CASQ_DATA/0930/kashiwa.csv");
	#$aa = file_get_contents("./CASQ_DATA/nishitokyo.csv");
	#$aa = file_get_contents("./CASQ_DATA/hiratuka2.csv");
	#$aa = file_get_contents("./CASQ_DATA/minamiurawa2.csv");
	#$aa = file_get_contents("./CASQ_DATA/urawa_s1836kwche.csv");
	#$aa = file_get_contents("./CASQ_DATA/yoshihara.csv");
	#$aa = file_get_contents("./CASQ_DATA/wada.csv");
	#$aa = file_get_contents("./CASQ_DATA/s2036lkpjw_tama2.csv");
	#$aa = file_get_contents("./CASQ_DATA/sasahara.csv");
	#$aa = file_get_contents("./CASQ_DATA/machida2.csv");
	#$aa = file_get_contents("./CASQ_DATA/kawasaki2.csv");
	#$aa = file_get_contents("./CASQ_DATA/nishikawa.csv");
	#$aa = file_get_contents("./CASQ_DATA/noguchi.csv");

	$aa = file_get_contents("./CASQ_DATA/1206/hiratsuka_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/ichikawa_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/kawaguchi_getu_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/kawaguchi_sui_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/kawasaki_22.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/kawasaki_kin_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/kokubunji_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/machida_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/minamiurawa_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/misato_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/moraju_kashiwa_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/nishitokyo_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/oomiya_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/shinyuri_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/team_tokorozawa_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/tengachaya_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/toyocho_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/shirogane_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/urawa_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/yokohama_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/yono_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/kamata_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/tama_center_2.csv");
	$aa = file_get_contents("./CASQ_DATA/0228/asaka_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/suwa_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/ueda_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/okayama_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/kashiwa_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/takasaki_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/tokorozawa_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/hidaka_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/kawagoe_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/fujimino_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/iruma_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/kisaraze_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/konosu_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/inba_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/miyagituru_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/fukuokahigashi_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/fukuokanishi_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/hachioji_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/hakata_get_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/hakata_kin_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/miyaginaga_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/miyagitomi_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/sakado_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/kamata_22.txt");
	$aa = file_get_contents("./CASQ_DATA/wada.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/makuhari_2.csv");


    foreach( explode("\n",$aa) as $val ){
        $val = explode(",", $val);
        $val[1] = trim($val[1]); $val[2] = trim($val[2]); $val[3] = trim($val[3]);
        $val[4] = trim($val[4]); $val[5] = trim($val[5]); $val[6] = trim($val[6]);
        $val[7] = trim($val[7]); $val[8] = trim($val[8]); $val[9] = trim($val[9]);
        if ( is_numeric($val[0]) && is_numeric($val[4]) ){
        $val[3] = str_replace('日', '', $val[3]);  // "日"を空文字に置換する
        $val[3] = str_replace('年', '-', $val[3]); // "年"を"-"に置換する
        $val[3] = str_replace('月', '-', $val[3]); // "月"を"-"に置換する
        $val[3] = str_replace('/', '-', $val[3]); // "/"を"-"に置換する
        if ( strlen($val[3]) <7 ){
            if ( empty($val[3]) ){
                $val[3] = date('Y-m-d');
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

        #$query = "Select id From speed_datas Where user_id = '$val[2]' and year = $year";
        #$stmt = $dbh->query($query);
        #$row = $stmt->fetch(PDO::FETCH_ASSOC);
        #if ( $row['user_id'] ){
        #    $trial_count = (count($row['id'])+1);
        #} else {
        #    $trial_count = 1;
        #}
        $trial_count = 2;

        #var_dump($val);
        $val[4] = $val[4] ? $val[4] : 0;
        $val[5] = $val[5] ? $val[5] : 0;
        $val[6] = $val[6] ? $val[6] : 0;
        $val[7] = $val[7] ? $val[7] : 0;
        $val[8] = $val[8] ? $val[8] : 0;
        $val[9] = $val[9] ? $val[9] : 0;
        $sql = "INSERT INTO speed_datas (user_id,speed_date,casq_10m,casq_30m,casq_10m_act,casq_5m_10m_5m,standing_jump,vertical_jump,tmp_user_id,trial_count,year,school_id) values ($user_id, '{$val[3]}', $val[4], $val[5], $val[6], $val[7], $val[8], $val[9], '$tmp_user_id',$trial_count,$year,$school) ON DUPLICATE KEY UPDATE created = created, speed_date = '{$val[3]}'";
        echo "OK:($user_id)\n";
        if ( $argv[1] == "test" ){
        } else {
            #echo $sql."\n";
		    $dbh->query($sql);
        }
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

