<?php
require_once("../casq_html/db.inc.php");


/*
# 小学1年生	6歳・7歳	2018年(平成30年)4月2日～2019年(平成31年/令和元年)4月1日
$nen1 = date('Y') - 7;
$nen_ary[1] = ['str' => "$nen1-04-02", 'end' => ($nen1+1)."-04-01"];
$nen_ary[2] = ['str' => ($nen1-1)."-04-02", 'end' => ($nen1)."-04-01"];
$nen_ary[3] = ['str' => ($nen1-2)."-04-02", 'end' => ($nen1-1)."-04-01"];
$nen_ary[4] = ['str' => ($nen1-3)."-04-02", 'end' => ($nen1-2)."-04-01"];
$nen_ary[5] = ['str' => ($nen1-4)."-04-02", 'end' => ($nen1-3)."-04-01"];
$nen_ary[6] = ['str' => ($nen1-5)."-04-02", 'end' => ($nen1-4)."-04-01"];
$nen_ary[7] = ['str' => ($nen1-6)."-04-02", 'end' => ($nen1-5)."-04-01"];
$nen_ary[8] = ['str' => ($nen1-7)."-04-02", 'end' => ($nen1-6)."-04-01"];
$nen_ary[9] = ['str' => ($nen1-8)."-04-02", 'end' => ($nen1-7)."-04-01"];

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
		11 => $nen_ary[7], 
		12 => $nen_ary[8],
		13 => $nen_ary[9],
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

	$query = "SELECT * FROM users WHERE user_status = 0 and user_school = 44";
	$stmt = $dbh->query($query);
	// 表示処理
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		foreach( $gaku_ary as $nen => $val ){
			echo $row['user_birthday']."\n";
			$query = "SELECT * FROM users WHERE id = {$row['id']} and user_status = 0 and user_birthday between '{$val['str']}' and '{$val['end']}' user_school = 44";
			$res = $dbh->query($query);
			if($ret = $res->fetch(PDO::FETCH_ASSOC)){
			echo $query."\n";
			}

		}
	}
*/


// DBへ接続
try{

# cut -d"," -f4,5,7,8,15,16,18 urawa.csv | head
# 受講者姓,受講者名,認証KEY,グループID,カナ（姓）,カナ（名）,生年月日
# "柏淵","陽斗","946NUB9YL5","#0014","カシワブチ","ハルト","2016/07/01"
# "吉井","湊大","966SMMJS32","#0014","ヨシイ","ソウタ","2016/10/13"

/*
	$scid = 6; $sccd = "s1836qjicw";
	$scid = 8; $sccd = "s2036hzmrm";
	$scid = 9; $sccd = "s2036eqkyg";
	$scid =10; $sccd = "s2036ybogw";
	$scid =12; $sccd = "s2036iseve"; // | 12 | s2036iseve | 川越校(ｷｬｽｸ)
	$scid =13; $sccd = "s2036xfspz"; // | 13 | s2036xfspz | 与野校(ｷｬｽｸ)
	$scid =14; $sccd = "s2036sqlmw"; // | 14 | s2036sqlmw | 鴻巣校(ｷｬｽｸ)
	$scid =15; $sccd = "s2036lbtvt"; // | 15 | s2036lbtvt | 坂戸校(ｷｬｽｸ)
	$scid =16; $sccd = "s2036ymuci"; // | 16 | s2036ymuci | 三郷吉川校(ｷｬｽｸ)
	$scid =17; $sccd = "s2036uiszd"; // | 17 | s2036uiszd | 朝霞校(ｷｬｽｸ)
	$scid =18; $sccd = "s2036xepmp"; // | 18 | s2036xepmp | 東陽町校(ｷｬｽｸ)
	$scid =19; $sccd = "s2036mqgwc"; // | 19 | s2036mqgwc | 町田校(ｷｬｽｸ)
	$scid =20; $sccd = "s2036vrcxq"; // | 20 | s2036vrcxq | 西東京校(ｷｬｽｸ)
	$scid =21; $sccd = "s2036lkpjw"; // | 21 | s2036lkpjw | 多摩センター校(ｷｬｽｸ)
	$scid =22; $sccd = "s2036coyjx"; // | 22 | s2036coyjx | 蒲田校(ｷｬｽｸ)
	$scid =23; $sccd = "s2036hwodm"; // | 23 | s2036hwodm | 国分寺校(ｷｬｽｸ)
	$scid =25; $sccd = "s2036subbu"; // | 25 | s2036subbu | 白金校(ｷｬｽｸ)
	$scid =26; $sccd = "s2036vyrvl"; // | 26 | s2036vyrvl | 川崎校(ｷｬｽｸ)
	$scid =27; $sccd = "s2036dahis"; // | 27 | s2036dahis | 横浜校(ｷｬｽｸ)
	$scid =28; $sccd = "s2036mboap"; // | 28 | s2036mboap | 新百合ヶ丘校(ｷｬｽｸ)
	$scid =29; $sccd = "s2036hwewf"; // | 29 | s2036hwewf | 柏校(ｷｬｽｸ/ｴｸｾﾚﾝﾄﾌｨｰﾄ)
	$scid =30; $sccd = "s2036blstd"; // | 30 | s2036blstd | 市川校(ｷｬｽｸ)
	$scid =32; $sccd = "s2036sooyv"; // | 32 | s2036sooyv | 岡山校(ｷｬｽｸ)
	$scid =33; $sccd = "s2036zchlf"; // | 33 | s2036zchlf | イオンモール木更津校(ｷｬｽｸ)
	$scid =34; $sccd = "s2036mhzet"; // | 34 | s2036mhzet | 印旛校(ｷｬｽｸ)
	$scid =35; $sccd = "s2036rhyym"; // | 35 | s2036rhyym | 上田校(ｷｬｽｸ)
	$scid =36; $sccd = "s2036oapyo"; // | 36 | s2036oapyo | 諏訪校(ｷｬｽｸ)
	$scid =37; $sccd = "s2036cctkg"; // | 37 | s2036cctkg | 宮城長町校(ｷｬｽｸ)
	$scid =38; $sccd = "s2036eaqit"; // | 38 | s2036eaqit | 宮城鶴巻校(ｷｬｽｸ)
	$scid =39; $sccd = "s2036skhej"; // | 39 | s2036skhej | 宮城富谷校(ｷｬｽｸ)
	$scid =40; $sccd = "s2036nbqfb"; // | 40 | s2036nbqfb | 高崎校(ｷｬｽｸ)
	$scid =41; $sccd = "s2036gmfot"; // | 41 | s2036gmfot | 博多校(ｷｬｽｸ)
	$scid =42; $sccd = "s2036lalig"; // | 42 | s2036lalig | 福岡東校(ｷｬｽｸ)
	$scid =43; $sccd = "s2037ykyyj"; // | 43 | s2037ykyyj | 福岡西校(ｷｬｽｸ)
	$scid =44; $sccd = "s1937vweyl"; // | 44 | s1937vweyl | 大阪天下茶屋校(ｷｬｽｸ)
	$scid =32; $sccd = "s2036sooyv"; // | 32 | s2036sooyv | 岡山校(ｷｬｽｸ)
*/
	$aa = file_get_contents("../school/s2036fcnxg_member20250821155623.csv"); $scid =24; $sccd = "s2036fcnxg"; // | 24 | s2036fcnxg | 八王子校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036uiszd_member20250821102459.csv"); $scid =17; $sccd = "s2036uiszd"; // | 17 | s2036uiszd | 朝霞校(ｷｬｽｸ) 
	$aa = file_get_contents("../school/s1836armnz_member20250821093804-2.csv"); $scid = 3; $sccd = "s1836armnz";
	$aa = file_get_contents("../school/1_member20250821053628.csv"); $scid = 1; $sccd = "s1836kwche";
	$aa = file_get_contents("../school/2_member20250821091635.csv"); $scid = 2; $sccd = "s1836wncuo";
	$aa = file_get_contents("../school/s2036blstd_member20250821161501.csv"); $scid =30; $sccd = "s2036blstd"; // | 30 | s2036blstd | 市川校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036hwewf_member20250821162221.csv"); $scid =29; $sccd = "s2036hwewf"; // | 29 | s2036hwewf | 柏校(ｷｬｽｸ/ｴｸｾﾚﾝﾄﾌｨｰﾄ)
	$aa = file_get_contents("../school/s2036vyrvl_member20250821162917.csv"); $scid =26; $sccd = "s2036vyrvl"; // | 26 | s2036vyrvl | 川崎校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036nbnie_member20250821163632.csv"); $scid =31; $sccd = "s2036nbnie"; // | 31 | s2036nbnie | 幕張校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036hzmrm_member20250821164323.csv"); $scid = 8; $sccd = "s2036hzmrm";
	$aa = file_get_contents("../school/s2036skhej_member20250821172626.csv"); $scid =39; $sccd = "s2036skhej"; // | 39 | s2036skhej | 宮城富谷校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036vrcxq_member20250821173517.csv"); $scid =20; $sccd = "s2036vrcxq"; // | 20 | s2036vrcxq | 西東京校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036lbtvt_member20250821174030.csv"); $scid =15; $sccd = "s2036lbtvt"; // | 15 | s2036lbtvt | 坂戸校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036mboap_member20250821175849.csv"); $scid =28; $sccd = "s2036mboap"; // | 28 | s2036mboap | 新百合ヶ丘校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036subbu_member20250821180345.csv"); $scid =25; $sccd = "s2036subbu"; // | 25 | s2036subbu | 白金校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036nbqfb_member20250821180710.csv"); $scid =40; $sccd = "s2036nbqfb"; // | 40 | s2036nbqfb | 高崎校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036lkpjw_member20250821181339.csv"); $scid =21; $sccd = "s2036lkpjw"; // | 21 | s2036lkpjw | 多摩センター校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s1937vweyl_member20250821184027.csv"); $scid =44; $sccd = "s1937vweyl"; // | 44 | s1937vweyl | 大阪天下茶屋校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036xepmp_member20250821184452.csv"); $scid =18; $sccd = "s2036xepmp"; // | 18 | s2036xepmp | 東陽町校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036dahis_member20250821185624.csv"); $scid =27; $sccd = "s2036dahis"; // | 27 | s2036dahis | 横浜校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036xfspz_member20250821200502.csv"); $scid =13; $sccd = "s2036xfspz"; // | 13 | s2036xfspz | 与野校(ｷｬｽｸ)

	$aa = file_get_contents("../school/35_member20250930144054.csv"); $scid =35; $sccd = "s2036rhyym"; // | 35 | s2036rhyym | 上田校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s1836ngrkt_member20250930150446.csv"); $scid = 5; $sccd = "s1836ngrkt"; // | 5 | s1836ngrkt | 所沢校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036lalig_member20251001094509.csv"); $scid =42; $sccd = "s2036lalig"; // | 42 | s2036lalig | 福岡東校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2037ykyyj_member20251001100154.csv"); $scid =43; $sccd = "s2037ykyyj"; // | 43 | s2037ykyyj | 福岡西校(ｷｬｽｸ) 
	$aa = file_get_contents("../school/s2036gmfot_member20251001102458.csv"); $scid =41; $sccd = "s2036gmfot"; // | 41 | s2036gmfot | 博多校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036ybogw_member20251001103654.csv"); $scid =10; $sccd = "s2036ybogw"; // | 10 | s2036ybogw | 日高校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036mhzet_member20251001104442.csv"); $scid =34; $sccd = "s2036mhzet"; // | 34 | s2036mhzet | 印旛校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036eqkyg_member20251001105026.csv"); $scid = 9; $sccd = "s2036eqkyg"; // |  9 | s2036eqkyg | 入間校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036iseve_member20251001110359.csv"); $scid =12; $sccd = "s2036iseve"; // | 12 | s2036iseve | 川越校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s1836armnz_member20251001111048.csv"); $scid = 3; $sccd = "s1836armnz"; // |  3 | s1836armnz | 川口校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036vyrvl_member20251001112447.csv"); $scid =26; $sccd = "s2036vyrvl"; // | 26 | s2036vyrvl | 川崎校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036zchlf_member20251001113956.csv"); $scid =33; $sccd = "s2036zchlf"; // | 33 | s2036zchlf | 木更津校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036hwodm_member20251001114541.csv"); $scid =23; $sccd = "s2036hwodm"; // | 23 | s2036hwodm | 国分寺校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s1836kwche_member20251001115630.csv"); $scid = 1; $sccd = "s1836kwche"; // |  1 | s1836kwche | 浦和校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036sqlmw_member20251001120517.csv"); $scid =14; $sccd = "s2036sqlmw"; // | 14 | s2036sqlmw | 鴻巣校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036mqgwc_member20251001121039.csv"); $scid =19; $sccd = "s2036mqgwc"; // | 19 | s2036mqgwc | 町田校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036ymuci_member20251001121949.csv"); $scid =16; $sccd = "s2036ymuci"; // | 16 | s2036ymuci | 三郷吉川校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036cctkg_member20251001123854.csv"); $scid =37; $sccd = "s2036cctkg"; // | 37 | s2036cctkg | 宮城長町校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036eaqit_member20251001124422.csv"); $scid =38; $sccd = "s2036eaqit"; // | 38 | s2036eaqit | 宮城鶴巻校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036sooyv_member20251001125800.csv"); $scid =32; $sccd = "s2036sooyv"; // | 32 | s2036sooyv | 岡山校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036lbtvt_member20251001145152.csv"); $scid =15; $sccd = "s2036lbtvt"; // | 15 | s2036lbtvt | 坂戸校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036oapyo_member20251001145729.csv"); $scid =36; $sccd = "s2036oapyo"; // | 36 | s2036oapyo | 諏訪校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s1836ngrkt_member20251001150039.csv"); $scid = 5; $sccd = "s1836ngrkt"; // | 5 | s1836ngrkt | 所沢校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036rhyym_member20251001152324.csv"); $scid =35; $sccd = "s2036rhyym"; // | 35 | s2036rhyym | 上田校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s1836qjicw_member20251001153541.csv"); $scid = 6; $sccd = "s1836qjicw"; // |  6 | s1836qjicw | 平塚校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036aaogi_member20251001094045.csv"); $scid = 7; $sccd = "s2036aaogi"; // | 7 | s2036aaogi | ふじみ野校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036coyjx_member20251001230729.csv"); $scid =22; $sccd = "s2036coyjx"; // | 22 | s2036coyjx | 蒲田校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036hwewf_member20251001231806.csv"); $scid =29; $sccd = "s2036hwewf"; // | 29 | s2036hwewf | 柏校(ｷｬｽｸ/ｴｸｾﾚﾝﾄﾌｨｰﾄ) 
	$aa = file_get_contents("../school/s1937weoxi_member20251002150913.csv"); $scid =46; $sccd = "s1937weoxi"; // | 46 | s1937weoxi | モラージュ柏校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036hzmrm_member20251007151523.csv"); $scid = 8; $sccd = "s2036hzmrm"; // |  8 | s2036hzmrm | 南浦和校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036uiszd_member20251010140945.csv"); $scid =17; $sccd = "s2036uiszd"; // | 17 | s2036uiszd | 朝霞校(ｷｬｽｸ) 

	$aa = file_get_contents("../school/s2036dahis_member20260224211144.csv"); $scid =27; $sccd = "s2036dahis"; // | 27 | s2036dahis | 横浜校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s1836qjicw_member20260224212438.csv"); $scid = 6; $sccd = "s1836qjicw"; // |  6 | s1836qjicw | 平塚校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036blstd_member20260224213333.csv"); $scid =30; $sccd = "s2036blstd"; // | 30 | s2036blstd | 市川校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036coyjx_member20260224214640.csv"); $scid =22; $sccd = "s2036coyjx"; // | 22 | s2036coyjx | 蒲田校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s1836armnz_member20260224215551.csv"); $scid = 3; $sccd = "s1836armnz"; // |  3 | s1836armnz | 川口校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036vyrvl_member20260224221431.csv"); $scid =26; $sccd = "s2036vyrvl"; // | 26 | s2036vyrvl | 川崎校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036hwodm_member20260224230406.csv"); $scid =23; $sccd = "s2036hwodm"; // | 23 | s2036hwodm | 国分寺校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036mqgwc_member20260225005147.csv"); $scid =19; $sccd = "s2036mqgwc"; // | 19 | s2036mqgwc | 町田校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036hzmrm_member20260225011523.csv"); $scid = 8; $sccd = "s2036hzmrm"; // |  8 | s2036hzmrm | 南浦和校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s1937weoxi_member20260225130405.csv"); $scid =46; $sccd = "s1937weoxi"; // | 46 | s1937weoxi | モラージュ柏校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036hwewf_member20260225131115.csv"); $scid =29; $sccd = "s2036hwewf"; // | 29 | s2036hwewf | 柏校(ｷｬｽｸ/ｴｸｾﾚﾝﾄﾌｨｰﾄ)
	$aa = file_get_contents("../school/s2036vrcxq_member20260225134859.csv"); $scid =20; $sccd = "s2036vrcxq"; // | 20 | s2036vrcxq | 西東京校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s1836wncuo_member20260225140024.csv"); $scid = 2; $sccd = "s1836wncuo"; // |  2 | s1836wncuo | 大宮校(ｷｬｽｸ/ｴｸｾﾚﾝﾄﾌｨｰﾄ)
	$aa = file_get_contents("../school/s2036mboap_member20260225141243.csv"); $scid =28; $sccd = "s2036mboap"; // | 28 | s2036mboap | 新百合ヶ丘校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036lkpjw_member20260225142523.csv"); $scid =21; $sccd = "s2036lkpjw"; // | 21 | s2036lkpjw | 多摩センター校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036subbu_member20260225143201.csv"); $scid =25; $sccd = "s2036subbu"; // | 25 | s2036subbu | 白金校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s1937vweyl_member20260225144029.csv"); $scid =44; $sccd = "s1937vweyl"; // | 44 | s1937vweyl | 大阪天下茶屋校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s2036xepmp_member20260225145348.csv"); $scid =18; $sccd = "s2036xepmp"; // | 18 | s2036xepmp | 東陽町校(ｷｬｽｸ)
	$aa = file_get_contents("../school/s1836kwche_member20260225145926.csv"); $scid = 1; $sccd = "s1836kwche"; // | 01 | s1836kwche | 浦和校(ｷｬｽｸ/ｴｸｾﾚﾝﾄﾌｨｰﾄ)
	$aa = file_get_contents("../school/s2036xfspz_member20260226123638.csv"); $scid =13; $sccd = "s2036xfspz"; // | 13 | s2036xfspz | 与野校(ｷｬｽｸ)
	$aa = file_get_contents("../school/0228/s1836ngrkt_tokorozawa_member20260228083837.csv"); $scid = 5; $sccd = "s1836ngrkt"; // | 5 | s1836ngrkt | 所沢校(ｷｬｽｸ)
    $aa = file_get_contents("../school/0228/s2036aaogi_fujimino_member20260228084303.csv"); $scid = 7; $sccd = "s2036aaogi"; // | 7 | s2036aaogi | ふじみ野校(ｷｬｽｸ)
    $aa = file_get_contents("../school/0228/s2036cctkg_miyaginaga_member20260228081501.csv"); $scid =37; $sccd = "s2036cctkg"; // | 37 | s2036cctkg | 宮城長町校(ｷｬｽｸ)
    $aa = file_get_contents("../school/0228/s2036eqkyg_iruma_member20260228084358.csv"); $scid = 9; $sccd = "s2036eqkyg"; // |  9 | s2036eqkyg | 入間校(ｷｬｽｸ)
    $aa = file_get_contents("../school/0228/s2036fcnxg_hachioji_member20260228082237.csv"); $scid =24; $sccd = "s2036fcnxg"; // | 24 | s2036fcnxg | 八王子校(ｷｬｽｸ)
    $aa = file_get_contents("../school/0228/s2036gmfot_hakata_member20260228081757.csv"); $scid =41; $sccd = "s2036gmfot"; // | 41 | s2036gmfot | 博多校(ｷｬｽｸ)
    $aa = file_get_contents("../school/0228/s2036hwewf_kashiwa_member20260228081910.csv"); $scid =29; $sccd = "s2036hwewf"; // | 29 | s2036hwewf | 柏校(ｷｬｽｸ/ｴｸｾﾚﾝﾄﾌｨｰﾄ)
    $aa = file_get_contents("../school/0228/s2036iseve_kawagoe_member20260228084146.csv"); $scid =12; $sccd = "s2036iseve"; // | 12 | s2036iseve | 川越校(ｷｬｽｸ)
    $aa = file_get_contents("../school/0228/s2036lalig_fukuokahigashi_member20260228081655.csv"); $scid =42; $sccd = "s2036lalig"; // | 42 | s2036lalig | 福岡東校(ｷｬｽｸ)
    $aa = file_get_contents("../school/0228/s2036lbtvt_sakado_member20260228082345.csv"); $scid =15; $sccd = "s2036lbtvt"; // | 15 | s2036lbtvt | 坂戸校(ｷｬｽｸ)
    $aa = file_get_contents("../school/0228/s2036nbqfb_takasaki_member20260228083938.csv"); $scid =40; $sccd = "s2036nbqfb"; // | 40 | s2036nbqfb | 高崎校(ｷｬｽｸ)
    $aa = file_get_contents("../school/0228/s2036oapyo_suwa_member20260228080955.csv"); $scid =36; $sccd = "s2036oapyo"; // | 36 | s2036oapyo | 諏訪校(ｷｬｽｸ)
    $aa = file_get_contents("../school/0228/s2036rhyym_ueda_member20260228081158.csv"); $scid =35; $sccd = "s2036rhyym"; // | 35 | s2036rhyym | 上田校(ｷｬｽｸ)
    $aa = file_get_contents("../school/0228/s2036skhej_miyagitomi_member20260228081405.csv"); $scid =39; $sccd = "s2036skhej"; // | 39 | s2036skhej | 宮城富谷校(ｷｬｽｸ)
    $aa = file_get_contents("../school/0228/s2036sooyv_okayama_member20260228081303.csv"); $scid =32; $sccd = "s2036sooyv"; // | 32 | s2036sooyv | 岡山校(ｷｬｽｸ)
    $aa = file_get_contents("../school/0228/s2036sqlmw_konosu_member20260228082519.csv"); $scid =14; $sccd = "s2036sqlmw"; // | 14 | s2036sqlmw | 鴻巣校(ｷｬｽｸ)
    $aa = file_get_contents("../school/0228/s2036uiszd_asaka_member20260228082020.csv"); $scid =17; $sccd = "s2036uiszd"; // | 17 | s2036uiszd | 朝霞校(ｷｬｽｸ) 
    $aa = file_get_contents("../school/0228/s2036ybo_hidaka_gwmember20260228084046.csv"); $scid =10; $sccd = "s2036ybogw"; // | 10 | s2036ybogw | 日高校(ｷｬｽｸ)
    $aa = file_get_contents("../school/0228/s2037ykyyj_fukuokanishi_member20260228081605.csv"); $scid =43; $sccd = "s2037ykyyj"; // | 43 | s2037ykyyj | 福岡西校(ｷｬｽｸ) 
    $aa = file_get_contents("../school/0228/s2036zchlf_kisarazu_member20260228085114.csv"); $scid =33; $sccd = "s2036zchlf"; // | 33 | s2036zchlf | 木更津校(ｷｬｽｸ)
    $aa = file_get_contents("../school/0228/s2036mhzet_inba_member20260228084459.csv"); $scid =34; $sccd = "s2036mhzet"; // | 34 | s2036mhzet | 印旛校(ｷｬｽｸ)
    $aa = file_get_contents("../school/0228/s2036eaqit_member20260303154746.csv"); $scid =38; $sccd = "s2036eaqit"; // | 38 | s2036eaqit | 宮城鶴巻校(ｷｬｽｸ)
    $aa = file_get_contents("../school/0228/s2036nbnie_member20260310220756.csv"); $scid =31; $sccd = "s2036nbnie"; // | 31 | s2036nbnie | 幕張校(ｷｬｽｸ)


/****************************************************************/

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

#exit;
group($aa,$scid,$sccd,$dbh);
echo "group end.\n";
#exit;
sleep(2);
user($aa,$scid,$sccd,$dbh);
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

