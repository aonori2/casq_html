<?php
require_once("../casq_html/db.inc.php");

try{

$aa = file_get_contents("./casq-efss_query_ML010_2026-05-28_19_34_48.csv");

/****************************************************************/

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

function user_birth($year){
    switch( $year ){
        case "1":
        case "2":
        case "3":
        case "4":
        case "5":
        case "6":
        case "11":
        case "12":
        case "13":
        case "101":
        case "102":
        case "103":
        case "104":
        break;
    }
}

function user($aa,$dbh){
	$ary = [];
	foreach( explode("\n",$aa) as $val ){
		$ln = explode(",", $val);
		$ln[0] = trim($ln[0],'"');
        if ( !is_numeric($ln[0]) ) continue;
		if ( trim($ln[6]) ){
		$nam1 = trim($ln[3],'"');
		$nam2 = trim($ln[4],'"');
        $query = "SELECT * FROM users WHERE user_name = '$nam1' AND user_name2 = '$nam2'";
		$stmt = $dbh->query($query);
		if( !$row = $stmt->rowCount() ){
		$nam6 = trim($ln[6],'"');
		$nam7 = trim($ln[7],'"');
		$nam12 = trim($ln[12],'"');
        $nam12 = date('Y-m-d', strtotime($nam12));
#echo $nam6."\n";
#echo $nam7."\n";
        } else {
            continue;
        }

        $pass = passid($dbh);

		$users[] = [
			'user_name' => $nam1,
			'user_name2' => $nam2,
			'user_id' => $pass,
			'user_kana' => $nam6,
			'user_kana2' => $nam7,
			'user_birthday' => $nam12,
		];
		}
	}
	foreach( $users as $v ){
		extract($v);
        $user_name = mb_convert_encoding($user_name, "UTF-8", "AUTO");
        $user_name2 = mb_convert_encoding($user_name2, "UTF-8", "AUTO");
        $user_kana = mb_convert_encoding($user_kana, "UTF-8", "AUTO");
        $user_kana2 = mb_convert_encoding($user_kana2, "UTF-8", "AUTO");
		$sql = "INSERT INTO users (user_id,user_birthday,user_name,user_name2,user_kana,user_kana2) values ('{$user_id}','{$user_birthday}','{$user_name}','{$user_name2}','{$user_kana}','{$user_kana2}' ) ON DUPLICATE KEY UPDATE user_id = '{$user_id}' ;";
#echo $sql."\n";
		$dbh->query($sql);
        #sleep(1);
	}
}
/****************************************************************
#var_dump( $users );exit;
	$aa = file_get_contents("./urawa.csv");
	$aa = file_get_contents("./school/oomiya_member20250328141925.csv");
	$aa = file_get_contents("./school/kawaguchi_member20250328154616.csv");
		$scid = 1; $sccd = "s1836kwche";
		$scid = 2; $sccd = "s1836wncuo";
		$scid = 3; $sccd = "s1836armnz";

*/


/***************************************************************************/

function group($aa,$scid,$sccd,$dbh){
	$ary = [];
	foreach( explode("\n",$aa) as $val ){
#var_dump($val);continue;

		$ln = explode(",", $val);
		if ( is_numeric($ln[0]) ){
		$id = $ln[7];
		$nm = $ln[8];
		$id = trim($id,'"');
		$ids = (explode("#",$id));
			array_shift($ids);
		
		$nm = trim($nm,'"');
		$nms = (explode(")",$nm));

			#echo $id."\n";
			foreach( $ids as $k => $vv ){
				$nam = $nms[$k].")";
				$id = (int)$vv;
				$vv  = "#$vv";
				if ( !isset($ary[$id]) ){
				$ary[$id] = [
					"id" => $id,
					"school_id" => $scid,
					"school_cd" => $sccd,
					"group_id"  => $vv,
					"group_name" => $nam ];
				#$dbh->query($sql);
				}
				ksort($ary);
			}
		}
	}
	#var_dump($ary);
	foreach( $ary as $v ){
	$id = $v['id'];
	$sccd = $v['school_cd'];
	$vv = $v['group_id'];
	$nam = $v['group_name'];
    $nam = mb_convert_encoding($nam, "UTF-8", "AUTO");
	$sql = "INSERT INTO group_lists (school_id,school_cd,group_id,group_name) values ($scid,'{$sccd}','{$vv}','キャスク{$nam}' ) ON DUPLICATE KEY UPDATE   school_id = school_id ;";
    #echo $sql."\n";
	$dbh->query($sql);
	}
}

#$ret = passid($dbh);
#echo "[$ret] pass end.\n";exit;

#exit;
#group($aa,$scid,$sccd,$dbh);
#echo "group end.\n";
#exit;
#sleep(2);
user($aa,$dbh);
echo "user end.\n";

require_once("./nen.php");
exit;
/***************************************************************************
*/
/*
	$aa = file_get_contents("./sc.txt");
	foreach( explode("\n",$aa) as $val ){
		$val = trim($val);
		if ( $val ){
		$list = explode(" ",$val);
		$sql = "INSERT INTO school_lists (id,school_cd,school_name) values ($list[0],'{$list[3]}','{$list[2]}');";
		#echo $sql."\n";
		}
		$dbh->query($sql);
	}
*/

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

