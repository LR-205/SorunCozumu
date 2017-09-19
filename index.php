<?php
$Mysql_kullanici_adi = "root";
$Mysql_parola = "root";
$Mysql_veritabani = "pdo_firma";
$link = mysqli_connect ("localhost", $Mysql_kullanici_adi, $Mysql_parola, $Mysql_veritabani);
if (!$link){
    die("BaGlantİ Gerceklestirilemedi" .mysqli_error());
}

#---Aktif Ziyaretçi Sayısı--------------------------------------------------------------------
$ip = $_SERVER['REMOTE_ADDR'];
$past = time()-150;
mysqli_query($link, "DELETE FROM online WHERE time < ".$past);
$result = mysqli_query("SELECT time FROM online WHERE ip='".$ip."'");
$time = time();
if($row = mysqli_fetch_assoc($result)){
    mysqli_query("UPDATE online SET time='$time',ip='$ip' WHERE ip='$ip'");
}else{
    mysqli_query("INSERT INTO online (ip,time) VALUES ('$ip','$time')") or die(mysql_error());
}
$result   = mysqli_query("SELECT ip FROM online");
$aktifkac = mysqli_num_rows($result);
#---Aktif Ziyaretçi Sayısı--------------------------------------------------------------------


#---Dün Tekil Toplam Kaç Kişi Girmiş----------------------------------------------------------
$baslat = date(Y."-".m."-".d);
$year = substr($baslat, 0,4);
$month = substr($baslat, 5, 2);
$day = substr($baslat, 8, 2);
$bitis = date("Y-m-d", mktime(0, 0, 0, $month, $day-1, $year));
$sorgula = mysqli_query("select tarih from ziyaret where tarih='$bitis'");
$dunku = mysqli_num_rows($sorgula);
#---Dün Tekil Toplam Kaç Kişi Girmiş----------------------------------------------------------


#---Bugün Tekil Toplam Kaç Kişi Girmiş--------------------------------------------------------
$bugun = date("Y-m-d");
$sorgu = mysqli_query("select tarih from ziyaret where tarih='$bugun'");
$bugunku = mysqli_num_rows($sorgu);
#---Bugün Tekil Toplam Kaç Kişi Girmiş--------------------------------------------------------


#---Toplam Tekil Kaç Kişi Girmiş--------------------------------------------------------------
$ipsi  = $_SERVER['REMOTE_ADDR'];
$tarih = date("Y-m-d");

$ipkontrol = mysqli_query("select * from ziyaret where ip='$ipsi' order by id desc");
$yaz   = mysqli_fetch_assoc($ipkontrol);
$vip   = $yaz['ip'];
$vtarih= $yaz['tarih'];
$bak = mysqli_num_rows($ipkontrol);
if($bak>0){  //if-
    if($vtarih<$tarih){
        $kayit_1 = mysqli_query("insert into ziyaret (ip,tarih) values ('$ipsi','$tarih')");
    }
}//if-
else{
    $kayit_2 = mysqli_query("insert into ziyaret (ip,tarih) values ('$ipsi','$tarih')");
}
$toplamne = mysqli_query("select * from ziyaret");
$toplamziyaret  = mysqli_num_rows($toplamne);
#---Toplam Tekil Kaç Kişi Girmiş--------------------------------------------------------------
?>