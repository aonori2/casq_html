<?PHP
require_once("../casq_html/db.php");
$query = "select user_id from speed_datas where advice_txt like ('%Aスキップ%' ) group by user_id";
$query = "SELECT * FROM speed_datas where trial_count=2 order by school_id,id";
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


    $nen = get_nen();
    $scn = get_school_name($user_school);
    $url = "https://casq-st.com/$user_id";
    $ln = "$user_name$user_name2,{$nen[$year]},$scn,$url\n";
    $ln = mb_convert_encoding($ln, "sjis-win", "AUTO");
    echo $ln;
}
