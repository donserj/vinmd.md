<!-- success.php --> 
<html> 
<head> 
<title>Success</title> 
<meta http-equiv="content-type" content="text/html; charset=windows-1251">
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<meta name="google-translate-customization" content="7e7fec0429d67432-2d603035edf2d2eb-g0b7d70203b296997-a"></meta>
</head> 
<body> 
<p>
<?php 

	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<div id="google_translate_element"></div><script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'en,ro,ru', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<!--������ ��� ��������.
 </p--> 
<script>
    $(function(){
    
      $('#dynamic_select').bind('change', function () {
          var url = $(this).val(); 
          if (url) { 
              window.location = url; 
          }
          return false;
      });
    });
</script>
<?php

if(isset($_POST['vin'])){
	$vin=trim($_POST['vin']);
	$type=trim($_POST['type']);
}else if(isset($_GET['vin']) && isset($_GET['type'])) {
	
	$vin=trim($_GET['vin']);
	$type=trim($_GET['type']);
	
} else if(isset($_COOKIE['vinCookie']) && isset($_COOKIE['typeCookie'])){

	$url = "http://".$_SERVER['HTTP_HOST']."/php-scripts/success_wm.php?vin=".$_COOKIE['vinCookie']."&type=".$_COOKIE['typeCookie'];
	unset($_COOKIE['vinCookie']);
	unset($_COOKIE['typeCookie']);
	echo '<script>window.location = "'.$url.'";</script>';
}

error_reporting(0);


include $_SERVER['DOCUMENT_ROOT'].'/configuration.php';


$cfg = new JConfig();

$conn = @mysql_connect($host, $cfg->user, $cfg->password) or die("Could not connect to MySQL server!");

@mysql_select_db($cfg->db) or die("Could not select the database!");


$content_bd='';
$content1_bd='';

switch ($type){
	case '1':
//	echo "case 1";
	$type1='&type=carfax';
	$type2='';
	break;
    case '3':
//	echo "case 1";
	$type1='&type=copart';
	$type2='';
	break;
	case '4':
//	echo "case 1";
	$type1='&type=manheim';
	$type2='';
	break;
	case '2':
//	echo "case 2";
	$type1='&type=autocheck';
	$type2='&type=autocheck';
	break;
/*	case '3':
	$type1='&type=carfax';
	$type2='&type=autocheck';
	break;
	*/
}	


/*
1 Carfax � 5
2 Autocheck - 4.5
3 Copart � 
4 Manheim �
5 Carfax + Autocheck � 9 $</option>
6 Carfax + Copart � 11 $</option>
7 Autocheck + Copart � 10 $</option>
8 Carfax + Autocheck + Copart � 15 $</option>
*/

	$url1 = 'http://cgi.autovin.am/client/getreport?authToken=4e9915dea86e4008968a7c24aeb00e77&vin='.$vin;
	
?>

 <table width="100%">
<tr><td>

<?php
//	if ($type2) {
	//autocheck	
	
  // ���������, ���� �� ����� autocheck ��� ������ VIN � ���� ������.
  // ���� ����� ����� �� ���������, �� ���������� ������ �� ������.
  
echo '<tr><td>'; 
echo '<br clear="both" /><hr><br clear="both" /><div style="clear:both;">';
 
  $q="SELECT `vin`, `type`, `report` FROM `db_reports` WHERE vin='$vin' AND type='".$type."'";
  $res=mysql_fetch_row(mysql_query($q));

  if(!$res[0] or $res[0]=="") {
		
		if($content == false)
		$curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url1.$type1);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
        $content1 = curl_exec($curl_handle);
        curl_close($curl_handle);
		

		echo $content1;

   // ��������� ����� ��� ������� reports
  $content1_bd=mysql_real_escape_string($content1);
 
 // ������ ����� � ������� reports
  $q="insert into `db_reports` set `type`='".$type."',
  `vin`='$vin', `report`='$content1_bd'";
  	mysql_query($q);
}
else {

$content1 = $res[2];
//echo "<h1>From DataBase</h1>";
echo $content1;

}
echo '</div>';  

echo '</td></tr>';
//}	
	
/*if ($type1) {
      	//carfax
		
  // ���������, ���� �� ����� carfax ��� ������ VIN � ���� ������.
  // ���� ����� ����� �� ���������, �� ���������� ������ �� ������.

  echo '<tr><td>'; 
  echo '<hr><br clear="both" /><div style="clear:both;">';
  
  
  $q="SELECT `vin`, `type`, `report` FROM `db_reports` WHERE vin='$vin' AND type='1'";
  $res=mysql_fetch_row(mysql_query($q));
  if(!$res[0] or $res[0]=="") {
    	
        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url1.$type1);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
        $content = curl_exec($curl_handle);
        curl_close($curl_handle);

		echo $content;
   // ��������� ����� ��� ������� reports
  $content_bd=mysql_real_escape_string($content);

 // ������ ����� � ������� reports
  $q="INSERT INTO `db_reports` (`vin`, `type`, `report`) VALUES ('$vin','1','$content_bd')";
 	mysql_query($q);
  
}
else {

$content = $res[2];
//echo "<h1>From DataBase</h1>";
echo $content;
}

echo '</div>';
echo '</td></tr>';
  }
  */
  

		

 ?>
</td></tr></table>
</body> 
</html>