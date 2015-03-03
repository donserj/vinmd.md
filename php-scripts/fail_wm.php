<!-- fail.php --> 
<?php 

$vin=trim($_POST['vin']);



?> 

<html> 
<head> 
<title>Fail</title> 
<meta http-equiv="content-type" content="text/html; charset=windows-1251">

</head> 
<body> 
<h2>Платеж не был выполнен, поэтому Вы не получили отчет по запрошенному Вами VIN-коду: <?php echo $vin ?>. Возможно, Вы отказались от платежа или возникла другая ошибка.</h2> 
</body> 
</html>