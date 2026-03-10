<?php
$f = file_get_contents("./no_school.txt");
foreach( explode("\n", $f) as $line ){
    list($a,$b,$c ) = explode(",", $line);
#echo $a.$b.$c."\n";
    $a = trim($a); $b = trim($b); $c = trim($c);
    $ary[$b.",".$c] = $a;
}

$f = file_get_contents("./mt_no.txt");
foreach( explode("\n", $f) as $line ){
    list($a,$b ) = explode(",", $line);
    $a = trim($a,'"'); $b = trim($b,'"');
    if ( $a ){
#echo $a.$b."\n";
    $ary2[$b] = $a;
    }
}
#var_dump( $ary2 ); exit;

$f = file_get_contents("./2026member.txt");
foreach( explode("\n", $f) as $line ){
    list($a,$b,$c ) = explode(",", $line);
    $lns = [];
    if ( $a ){
    if ( strstr($c,";") ){
        $ccc = explode(";", $c);
        $l = array_key_last($ccc);
        foreach( $ccc as $k => $v ){
            if ( $k ){
                if ( $k == $l ){
                $ln =  $b.",\"".$v."";
                } else {
                $ln =  $b.",\"".$v."\"";
                }
            } else {
                if ( $k == $l ){
                    $ln =  $b.",".$v."\"";
                } else {
                    $ln =  $b.",".$v."\"";
                }
            }
        $lns[] = $ln;
        }
    } else {
        $ln =  $b.",".$c."";
        $lns[] = $ln;
    }

    $kk = [];
    foreach( $lns as $ln ){
        if ( $ary[$ln] ){
            #echo "KEY:".$ary[$ln]."\n"; echo $c."\n";
            if ( strstr($c,"キャスク") ){
                #echo "キャスク".trim(array_shift(explode("(",$b)),'"')."\n";
                $z = "キャスク".trim(array_shift(explode("(",$b)),'"');
                $code1 = "h_studio_code=".$ary2[$z] ?? "";
            } else {
                #echo "サッカースクール".trim(array_shift(explode("(",$b)),'"')."\n";
                $z = "サッカースクール".trim(array_shift(explode("(",$b)),'"');
                $code2 = "h_studio_code=".$ary2[$z] ?? "";
            }
            $code = $code2 ?? $code1;
            $kk[] = "s_mt".$ary[$ln]."=".$ary[$ln];
        } else {
            echo "N G:".$ln."\n";
        }
    }
    if ( count($kk)<5 )
    echo $a.":https://casq-efss.hacomono.jp/home?$code&".join("&",$kk)."\n";

    }
}
$a = '"小林優太","浦和校(ｷｬｽｸ/ｴｸｾﾚﾝﾄﾌｨｰﾄ)","選抜5-6年(金);キャスク4-5年(水)"';
