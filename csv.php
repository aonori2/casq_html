<?PHP
require_once("../casq_html/db.php");
$query = "select user_id from speed_datas where advice_txt like ('%Aスキップ%' ) group by user_id";
$query = "SELECT * FROM speed_datas where trial_count=2 order by school_id";
$stmt = $dbh->query($query);
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $u = get_user($row['user_id']);
    extract($u);

    #$effcUser = get_effc();
    #$ef = $user_name.$user_name2;
    #if ( in_array($ef,$effcUser) ){
    #    echo $ef.":\n";
    #    echo "https://casq-st.com/$user_id\n";
    #}


    $ln  = '';
    $nen = get_nen();
    $scn = get_school_name($user_school);
    $url = "https://casq-st.com/$user_id";
    if ( $scn == $scn_org ){
    } else {
    if ( $body ){
        #echo $body."\n";
        $shool = mb_convert_encoding($scn_org, "utf-8", "AUTO");
        file_put_contents( "/tmp/{$shool}_2026.csv", $body);
        $body = "";
    }
    $ln = "$scn\n";
    $ln .= "学年,名前,認証KEY,計測日,10m走,30m走,反応10m走,5-10-5mアジリティ走,立ち幅跳び(cm),垂直飛び(cm)\n";
    }
    $ln .= "{$nen[$year]},$user_name$user_name2,$user_id,,,,,,,\n";
    $ln = mb_convert_encoding($ln, "sjis-win", "AUTO");
    $scn_org = $scn;
    $body .= $ln;
}
