<?PHP
require_once("../casq_html/db.php");
#$query = "select user_id from speed_datas where advice_txt like ('%Aスキップ%' ) group by user_id";
$query = "SELECT * FROM speed_datas where trial_count=1 AND this_year = 2026  order by school_id,year desc";
$query = "SELECT * FROM speed_datas where trial_count=1 AND school_id IN(37,54) AND this_year = 2026  order by school_id desc";
$stmt = $dbh->query($query);
$body = "";
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $u = get_user($row['user_id']);
    extract($u);

/*
    $effcUser = get_effc();
    $ef = $user_name.$user_name2;
    if ( in_array($ef,$effcUser) ){
        echo $ef.":\n";
        echo "https://casq-st.com/$user_id\n";
    }
    continue;
*/

    $ef = $user_name.$user_name2;
    $url = "https://casq-st.com/$user_id";

    $ln  = '';
    $nen = get_nen();
    $scn = get_school_name($row['school_id']);
    if ( $scn == $scn_org ){
    } else {
    if ( $body ){
        $shool = mb_convert_encoding($scn_org, "utf-8", "AUTO");
        file_put_contents( "/tmp/{$sid_org}_{$shool}_2026_01.csv", $body);
        #echo "$scn_org = $scn\n";
        #echo $body."\n";
        $body = "";
    }
    #$ln = "$scn\n";
    #$ln .= "学年,名前,認証KEY,計測日,10m走,30m走,反応10m走,5-10-5mアジリティ走,立ち幅跳び(cm),垂直飛び(cm)\n";
    }
    #$ln .= "{$nen[$year]},$user_name$user_name2,$user_id,,,,,,,\n";
    $ln = "$ef\n";
    $ln .= $url."\n";
    $ln = mb_convert_encoding($ln, "sjis-win", "AUTO");
    $scn_org = $scn;
    $sid_org = $row['school_id'];
    $body .= $ln;
}
if ( $body ){
$shool = mb_convert_encoding($scn_org, "utf-8", "AUTO");
file_put_contents( "/tmp/{$sid_org}_{$shool}_2026_01.csv", $body);
}
