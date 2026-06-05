<?php
require_once("../casq_html/db.inc.php");
require_once("../casq_html/nen.php");

function gaku_nen(){
$nedo = getFiscalYearOfToday();
#echo $nedo;exit;
$nen1 = $nedo - 7;
$nen_ary[1] = ['str' => "$nen1-04-02", 'end' => ($nen1+1)."-04-01"];
$nen_ary[2] = ['str' => ($nen1-1)."-04-02", 'end' => ($nen1)."-04-01"];
$nen_ary[3] = ['str' => ($nen1-2)."-04-02", 'end' => ($nen1-1)."-04-01"];
$nen_ary[4] = ['str' => ($nen1-3)."-04-02", 'end' => ($nen1-2)."-04-01"];
$nen_ary[5] = ['str' => ($nen1-4)."-04-02", 'end' => ($nen1-3)."-04-01"];
$nen_ary[6] = ['str' => ($nen1-5)."-04-02", 'end' => ($nen1-4)."-04-01"];
$nen_ary[7] = ['str' => ($nen1-6)."-04-02", 'end' => ($nen1-5)."-04-01"];
$nen_ary[8] = ['str' => ($nen1-7)."-04-02", 'end' => ($nen1-6)."-04-01"];
$nen_ary[9] = ['str' => ($nen1-8)."-04-02", 'end' => ($nen1-7)."-04-01"];
$nen_ary[10]= ['str' => ($nen1-9)."-04-02", 'end' => ($nen1-8)."-04-01"];

$nen_ary[101] = ['str' => ($nen1+3)."-04-02", 'end' => ($nen1+4)."-04-01"];
$nen_ary[102] = ['str' => ($nen1+2)."-04-02", 'end' => ($nen1+3)."-04-01"];
$nen_ary[103] = ['str' => ($nen1+1)."-04-02", 'end' => ($nen1+2)."-04-01"];
$gaku_ary = [
        "1"  => $nen_ary[1],
        "2"  => $nen_ary[2],
        "3"  => $nen_ary[3],
        "4"  => $nen_ary[4],
        "5"  => $nen_ary[5],
        "6"  => $nen_ary[6],
        "11" => $nen_ary[7],
        "12" => $nen_ary[8],
        "13" => $nen_ary[9],
        "101"=> $nen_ary[101],
        "102"=> $nen_ary[102],
        "103"=> $nen_ary[103],
        "201"=> $nen_ary[10],
    ];

return $gaku_ary;
}

#var_dump( gaku_nen() );exit;

function passid($dbh){

for(;;){
$su1 = mt_rand(1,3);

$chars2 = '123456789';
$randomStr1 = substr(str_shuffle($chars2), 0, $su1);

// 使用する英数字を変数$charに指定
$chars1 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
// ランダムな英数字を生成（7桁）
$su2 = (10-$su1);
$randomStr2 = substr(str_shuffle($chars1), 0, $su2);

$randomStr = $randomStr1.$randomStr2;
$query = "SELECT * FROM users WHERE user_id = '$randomStr'";
$stmt = $dbh->query($query);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( !$row ) break;
}

return $randomStr;
}

function user($aa,$scid,$sccd,$dbh){
        $ary = [];
        foreach( explode("\n",$aa) as $val ){
                $ln = explode(",", $val);
                if ( trim($ln[6]) ){
                $nam1 = trim($ln[3],'"');
                $nam2 = trim($ln[4],'"');
                if ( $nam1 == '受講者姓' ) continue;
                        $nam6 = trim($ln[6],'"');
                        $nam7 = trim($ln[7],'"');
                        $nam14 = trim($ln[14],'"');
                        $nam15 = trim($ln[15],'"');
                        $nam17 = trim($ln[17],'"');

                        $ids = (explode("#",$nam7));
                        array_shift($ids);

#var_dump( $ids );exit;
                        if ( count($ids) > 1 ){
                        foreach( $ids as $i ){
                                if ( trim($i) ){
                                #$i = (int)$i;
                                $query = "SELECT * FROM group_lists WHERE school_id = $scid and group_id = '#{$i}'";
                                $stmt = $dbh->query($query);
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                if ( false !== $res = mb_strpos($row['group_name'],'キャスク') ){
                                        #var_dump($query);
                                        #var_dump($row);exit;
                                        $nam7 = $i;
                                }
                                }
                        }
                        }
#exit;

                        $users[] = [
                                'user_name' => $nam1,
                                'user_name2' => $nam2,
                                'user_id' => $nam6,
                                'user_school' => $scid,
                                'user_kana' => $nam14,
                                'user_kana2' => $nam15,
                                'user_birthday' => $nam17,
                                'user_group' => (int)str_replace("#","",$nam7),
                        ];
#var_dump ( $nam1.$nam2.$nam6.$nam7 );
#var_dump ( $nam14.$nam15.$nam17 );
                }
        }
        foreach( $users as $v ){
                extract($v);
        $user_name = mb_convert_encoding($user_name, "UTF-8", "AUTO");
        $user_name2 = mb_convert_encoding($user_name2, "UTF-8", "AUTO");
        $user_kana = mb_convert_encoding($user_kana, "UTF-8", "AUTO");
        $user_kana2 = mb_convert_encoding($user_kana2, "UTF-8", "AUTO");
                $sql = "INSERT INTO users (user_id,user_school,user_birthday,user_group,user_name,user_name2,user_kana,user_kana2) values ('{$user_id}','{$user_school}','{$user_birthday}','{$user_group}','{$user_name}','{$user_name2}','{$user_kana}','{$user_kana2}' ) ON DUPLICATE KEY UPDATE user_id = '{$user_id}' ;";
#echo $sql."\n";
                $dbh->query($sql);
        }
}


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
	$aa = file_get_contents("./CASQ_DATA/1206/team_tokorozawa_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/tengachaya_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/toyocho_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/shirogane_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/urawa_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/yokohama_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/yono_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/kamata_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/tama_center_2.csv");
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
	$aa = file_get_contents("./CASQ_DATA/1206/kawaguchi_getu_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/kawasaki_kin_2.csv");
	$aa = file_get_contents("./CASQ_DATA/0228/asaka_2.csv");
    $aa = file_get_contents("./CASQ_DATA/0228/inba_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/kawaguchi_sui_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/machida_2.csv");
	$aa = file_get_contents("./CASQ_DATA/1206/shinyuri_2.csv");

	$aa = file_get_contents("./CASQ_DATA/20260527/END/kawaguchi_sui.csv"); $scid = 3;
	$aa = file_get_contents("./CASQ_DATA/20260527/END/tokorozawa.csv"); $scid = 5;
	$aa = file_get_contents("./CASQ_DATA/20260527/END/oomiya.csv"); $scid = 2;
	$aa = file_get_contents("./CASQ_DATA/20260527/END/iruma.csv"); $scid = 9;
	$aa = file_get_contents("./CASQ_DATA/20260527/END/yoon.csv"); $scid = 13;
	$aa = file_get_contents("./CASQ_DATA/20260527/END/kawagoe.csv"); $scid = 12;
	$aa = file_get_contents("./CASQ_DATA/20260527/END/kawaguchi.csv"); $scid = 3;

	$aa = file_get_contents("./CASQ_DATA/20260527/fujimino.csv"); $scid = 7;
	$aa = file_get_contents("./CASQ_DATA/20260527/urawa.csv"); $scid = 1;
	$aa = file_get_contents("./CASQ_DATA/20260527/tokorozawa_effc.csv"); $scid = 52;
	$aa = file_get_contents("./CASQ_DATA/20260527/minamiurawa.csv"); $scid = 8;
	$aa = file_get_contents("./CASQ_DATA/20260527/konosu.csv"); $scid = 14;
	$aa = file_get_contents("./CASQ_DATA/20260527/sakado.csv"); $scid = 15;
	$aa = file_get_contents("./CASQ_DATA/20260527/misato.csv"); $scid = 16;
	$aa = file_get_contents("./CASQ_DATA/20260527/machida.csv"); $scid = 19;
	$aa = file_get_contents("./CASQ_DATA/20260527/nishitokyo.csv"); $scid = 20;
	$aa = file_get_contents("./CASQ_DATA/20260527/tamacenter.csv"); $scid = 21;
	$aa = file_get_contents("./CASQ_DATA/20260527/kokubunji.csv"); $scid = 23;
	$aa = file_get_contents("./CASQ_DATA/20260527/hachioji.csv"); $scid = 24;
	$aa = file_get_contents("./CASQ_DATA/20260527/shirogane.csv"); $scid = 25;
	$aa = file_get_contents("./CASQ_DATA/20260527/kawasaki_ka.csv"); $scid = 26;
	$aa = file_get_contents("./CASQ_DATA/20260527/kawasaki_kin.csv"); $scid = 26;
	$aa = file_get_contents("./CASQ_DATA/20260527/shinyuri.csv"); $scid = 28;
	$aa = file_get_contents("./CASQ_DATA/20260527/kashiwa.csv"); $scid = 29;
	$aa = file_get_contents("./CASQ_DATA/20260527/moraju_kashiwa.csv");     $scid = 46;
	$aa = file_get_contents("./CASQ_DATA/20260527/ichikawa.csv");        $scid = 30;
	$aa = file_get_contents("./CASQ_DATA/20260527/makuhari.csv");        $scid = 31;
	$aa = file_get_contents("./CASQ_DATA/20260527/okayama_kin.csv");        $scid = 32;
	$aa = file_get_contents("./CASQ_DATA/20260527/okayama_getu.csv");        $scid = 32;
	$aa = file_get_contents("./CASQ_DATA/20260527/kisarazu.csv");        $scid = 33;
	$aa = file_get_contents("./CASQ_DATA/20260527/inbata.csv");        $scid = 34;
	$aa = file_get_contents("./CASQ_DATA/20260527/ueda.csv");        $scid = 35;
	$aa = file_get_contents("./CASQ_DATA/20260527/suwa.csv");        $scid = 36;
	$aa = file_get_contents("./CASQ_DATA/20260527/miyagi_tomiya.csv");        $scid = 39;
	$aa = file_get_contents("./CASQ_DATA/20260527/takasaki.csv");        $scid = 40;
	$aa = file_get_contents("./CASQ_DATA/20260527/hakata_getu.csv");        $scid = 41;
	$aa = file_get_contents("./CASQ_DATA/20260527/hakata_kin.csv");        $scid = 41;
	$aa = file_get_contents("./CASQ_DATA/20260527/fukuoka_higashi_ka.csv");        $scid = 42;
	$aa = file_get_contents("./CASQ_DATA/20260527/fukuoka_higashi_sui.csv");        $scid = 42;
	$aa = file_get_contents("./CASQ_DATA/20260527/fukuoka_nishi.csv");        $scid = 43;
	$aa = file_get_contents("./CASQ_DATA/20260527/oosakatenngajaya.csv");        $scid = 44;
	$aa = file_get_contents("./CASQ_DATA/20260527/yodogawa.csv");        $scid = 47;
	$aa = file_get_contents("./CASQ_DATA/20260527/nishikujo.csv");        $scid = 48;
	$aa = file_get_contents("./CASQ_DATA/20260527/ibaraki.csv");        $scid = 49;
	$aa = file_get_contents("./CASQ_DATA/20260527/niiza.csv");        $scid = 51;
	$aa = file_get_contents("./CASQ_DATA/20260527/nagareyama.csv");        $scid = 53;
	$aa = file_get_contents("./CASQ_DATA/20260527/toyocho.csv"); $scid = 18;
	$aa = file_get_contents("./CASQ_DATA/20260527/toyocho2.csv"); $scid = 18;
	$aa = file_get_contents("./CASQ_DATA/20260527/END/asaka.csv"); $scid = 17;
	$aa = file_get_contents("./CASQ_DATA/20260527/hiratuka2.csv"); $scid = 6;
	$aa = file_get_contents("./CASQ_DATA/20260527/ootakanomori2.csv");     $scid = 53;
	$aa = file_get_contents("./CASQ_DATA/20260527/END/isezaki.csv");     $scid = 54;
	$aa = file_get_contents("./CASQ_DATA/20260527/END/miyagi_nagamachi.csv");        $scid = 37;


/*
    foreach( explode("\n",$aa) as $val ){
        $val = explode(",", $val);
        $query = "SELECT * FROM users WHERE concat(user_name,user_name2) = '{$val[1]}';";
        echo $query."\n";
    }
exit;
*/

    foreach( explode("\n",$aa) as $rows ){
        $val = explode(",", $rows);
        $val[0] = trim($val[0]);
        if ( strstr($val[0],'学年') ) continue;
        if ( strstr($val[1],'名前') ) continue;
        if ( !$val[1] ) continue;

        if ( !$val[2] ){
        $query = "SELECT * FROM users WHERE concat(user_name,user_name2) = '{$val[1]}';";
        $stmt = $dbh->query($query);
        $name_to_id[$val[1]] = '';
        } else if ( $val[2] ){
        $query = "SELECT * FROM users WHERE user_id = '{$val[2]}';";
        $stmt = $dbh->query($query);
        }

        if($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
            if ( isset($name_to_id[$val[1]]) ){
                $name_to_id[$val[1]] = $rows['user_id'];
            }
            if ( !$rows['user_school'] || !$rows['year'] ){

                $nens = gaku_nen();
                $n = trim(trim($val[0],'"'));
                $n = mb_convert_encoding($val[0], "UTF-8", "AUTO");
                if ( $nens[$n]['str'] <= $rows['user_birthday'] && $nens[$n]['end'] >= $rows['user_birthday'] ){
                $query = "Update users Set year = '{$val[0]}', user_school = $scid WHERE user_id = '{$rows['user_id']}';";
                } else {
                $query = "Update users Set user_birthday = '{$nens[$n]['str']}', year = '{$val[0]}', user_school = $scid WHERE user_id = '{$rows['user_id']}';";
                }
		        $dbh->query($query);
            }
        } else {
        $query = "SELECT * FROM users WHERE concat(user_name,user_name2) = '{$val[1]}';";
        $stmt = $dbh->query($query);
        $name_to_id[$val[1]] = '';
        if($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
            if ( isset($name_to_id[$val[1]]) ){
                $name_to_id[$val[1]] = $rows['user_id'];
            }
            if ( !$rows['user_school'] || !$rows['year'] ){

                $nens = gaku_nen();
                $n = trim(trim($val[0],'"'));
                $n = mb_convert_encoding($val[0], "UTF-8", "AUTO");
                if ( $nens[$n]['str'] <= $rows['user_birthday'] && $nens[$n]['end'] >= $rows['user_birthday'] ){
                $query = "Update users Set year = '{$val[0]}', user_school = $scid WHERE user_id = '{$rows['user_id']}';";
                } else {
                $query = "Update users Set user_birthday = '{$nens[$n]['str']}', year = '{$val[0]}', user_school = $scid WHERE user_id = '{$rows['user_id']}';";
                }
                #echo $query."\n";
		        $dbh->query($query);
            }
        } else {
            echo $query."\n";exit;
        }

        }
    }

    //$date = new DateTime('2020-03-1');
    //dump($date->modify('-3 month')->format('Y')); // 2019

    /***********************************************************************************************/
    /***********************************************************************************************/
    /***********************************************************************************************/
    /***********************************************************************************************/
    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////
    $this_year = 2026;
    $trial_count = 1;
    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////
    /***********************************************************************************************/
    /***********************************************************************************************/
    /***********************************************************************************************/
    /***********************************************************************************************/

    foreach( explode("\n",$aa) as $val ){
        $val = explode(",", $val);
        $val[1] = trim($val[1]); $val[2] = trim($val[2]); $val[3] = trim($val[3]);
        $val[4] = trim($val[4]); $val[5] = trim($val[5]); $val[6] = trim($val[6]);
        $val[7] = trim($val[7]); $val[8] = trim($val[8]); $val[9] = trim($val[9]);
        if ( is_numeric($val[0]) && (is_numeric($val[4]) || is_numeric($val[5])) ){
        $val[3] = str_replace('日', '', $val[3]);  // "日"を空文字に置換する
        $val[3] = str_replace('年', '-', $val[3]); // "年"を"-"に置換する
        $val[3] = str_replace('月', '-', $val[3]); // "月"を"-"に置換する
        $val[3] = str_replace('/', '-', $val[3]); // "/"を"-"に置換する
        if ( strlen($val[3]) <7 ){
            if ( empty($val[3]) ){
                $val[3] = date('Y-m-d');
                $y = '';
            } else {
            }
        }
        $date = date('Y-m-d', strtotime($val[3]));
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
            $school = $scid ?? $row['user_school'];
            $tmp_user_id = "0";
        } else {
            $nam = $val[1];
            $query = "SELECT * FROM users WHERE user_id = '{$name_to_id[$nam]}'";
            $stmt = $dbh->query($query);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ( isset($row['id']) ){
            $user_id = $row['id'];
            $year = $row['year'];
            $school = $scid ?? $row['user_school'];
            $tmp_user_id = "0";
            #echo $query."\n";
            } else {
            $val[1] = mb_convert_encoding($val[1], "UTF-8", "AUTO");
            $user_id = 1;
            $tmp_user_id = $val[2];
            echo $query."\n";
            echo $val[0]."::".$val[1].":".$tmp_user_id."\n";
            continue;
            }
        }

        #$query = "Select id From speed_datas Where user_id = '$val[2]' and this_year = $this_year";
        #$stmt = $dbh->query($query);
        #$row = $stmt->fetch(PDO::FETCH_ASSOC);
        #if ( $row['user_id'] ){
        #    $trial_count = (count($row['id'])+1);
        #} else {
        #    $trial_count = 1;
        #}

        #var_dump($val);
        $val[4] = $val[4] ? $val[4] : 0;
        $val[5] = $val[5] ? $val[5] : 0;
        $val[6] = $val[6] ? $val[6] : 0;
        $val[7] = $val[7] ? $val[7] : 0;
        $val[8] = $val[8] ? $val[8] : 0;
        $val[9] = $val[9] ? $val[9] : 0;
        $sql = "INSERT INTO speed_datas (user_id,speed_date,casq_10m,casq_30m,casq_10m_act,casq_5m_10m_5m,standing_jump,vertical_jump,tmp_user_id,trial_count,year,school_id,this_year) values ($user_id, '{$val[3]}', $val[4], $val[5], $val[6], $val[7], $val[8], $val[9], '$tmp_user_id',$trial_count,$year,$school,$this_year) ON DUPLICATE KEY UPDATE year = $year, created = created, school_id = $school, speed_date = '{$val[3]}'";
        echo "OK:($user_id)\n";
        if ( $argv[1] == "test" ){
            echo $val[1]."\n";
            echo $sql."\n";
        } else {
		    $dbh->query($sql);
        }
        } else{
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

