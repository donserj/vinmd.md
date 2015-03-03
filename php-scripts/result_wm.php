<!-- result.php --> 
<html> 
<head> 
<title>result</title> 
<meta http-equiv="content-type" content="text/html; charset=windows-1251">

</head> 
<body> 
<?php
// Соединяемся с БД
		$host= "localhost"; 
		$user="viteg_vinmd";
		$pass="G9xwJBn5";
		$dbname="viteg_vinmd";

//сохраняем в переменной $PREREQUEST значение $_POST['LMI_PREREQUEST']	
$PREREQUEST="";	
if (isset($_POST['LMI_PREREQUEST'])){
$PREREQUEST=$_POST['LMI_PREREQUEST'];
}
		
		$conn = @mysql_connect($host, $user, $pass) or die("Could not connect to MySQL server!");
		@mysql_select_db($dbname) or die("Could not select the database!");
//echo mysql_errno().": ".mysql_error()."<BR>"; 
		
// Если это форма предварительного запроса, то идем дальше...
IF($PREREQUEST==1) {
  // 1) Проверяем, есть ли товар с таким id в базе данных.
  // Если такой товар не обнаружен, то выводим ошибку и прерываем работу скрипта.
  
  //`cost1` надо заменить на `cost` в рабочем режиме!!!!!!!!!!!
  //в тестовом режиме значения для всех записей поля `cost1`=0.05
 
$type=$_POST['type'];
 
  $q="SELECT `id`, `type`, `cost` FROM `db_types` WHERE id='$type'";
  $res=mysql_fetch_row(mysql_query($q));
  if(!$res[0] or $res[0]=="") {
    echo "ERR: NET TAKOGO TIPA OTCHETA";
    exit;
  }
  // 2) Проверяем, не произошла ли подмена суммы.
  // Cравниваем стоимость товара в базе данных с той суммой, что передана нам Мерчантом.
  // Если сумма не совпадает, то выводим ошибку и прерываем работу скрипта.
  if(trim($res[2])!=trim($_POST['LMI_PAYMENT_AMOUNT'])) {
    echo "ERR: NEVERNAIA SUMMA ".$_POST['LMI_PAYMENT_AMOUNT'];
    exit;
  }
  // 3) Проверяем, не произошла ли подмена кошелька.
  // Cравниваем наш настоящий кошелек с тем кошельком, который передан нам Мерчантом.
  // Если кошельки не совпадают, то выводим ошибку и прерываем работу скрипта.
  if(trim($_POST['LMI_PAYEE_PURSE'])!="Z207306436347") {
    echo "ERR: NEVERNYI KOSHELEK POKUPATELIA ".$_POST['LMI_PAYEE_PURSE'];
    exit;
  }
  // 4) Проверяем, указал ли пользователь свой email.
  // Если параметр $email пустой, то выводим ошибку и прерываем работу скрипта.
 /* if(!trim($_POST['email']) or trim($_POST['email'])=="") {
    echo "ERR: НЕ УКАЗАН EMAIL";
    exit;
  }*/
  // Если ошибок не возникло и мы дошли до этого места, то выводим YES
//mysql_close( ); 
 echo "YES";

 }

// Если нет LMI_PREREQUEST, следовательно это форма оповещения о платеже...
ELSE {
 // Задаем значение $secret_key.
  // Оно должно совпадать с Secret Key, указанным нами в настройках кошелька.
  $secret_key="V1234567887654321D";
  // Склеиваем строку параметров
  $common_string = $_POST['LMI_PAYEE_PURSE'].$_POST['LMI_PAYMENT_AMOUNT'].$_POST['LMI_PAYMENT_NO'].
     $_POST['LMI_MODE'].$_POST['LMI_SYS_INVS_NO'].$_POST['LMI_SYS_TRANS_NO'].
     $_POST['LMI_SYS_TRANS_DATE'].$secret_key.$_POST['LMI_PAYER_PURSE'].$_POST['LMI_PAYER_WM'];
  // Шифруем полученную строку в MD5 и переводим ее в верхний регистр
  $hash = strtoupper(md5($common_string));
  // Прерываем работу скрипта, если контрольные суммы не совпадают
  if($hash!=$_POST['LMI_HASH']) exit;



  // Выбираем из базы данных нужный отчет, записываем его в переменную $content;
 // ... Success.php
  
  


  // Вносим покупку в таблицу orders
  $LMI_PAYMENT_NO=$_POST['LMI_PAYMENT_NO'];
  $LMI_SYS_TRANS_DATE=$_POST['LMI_SYS_TRANS_DATE'];
  $LMI_PAYER_PURSE=$_POST['LMI_PAYER_PURSE'];
  $type=$_POST['type'];
  $vin=$_POST['vin'];
  $LMI_PAYMENT_AMOUNT=$_POST['LMI_PAYMENT_AMOUNT'];
  $LMI_SYS_TRANS_NO=$_POST['LMI_SYS_TRANS_NO'];
  
  $q="insert into `db_orders` set `id`='$LMI_PAYMENT_NO', `date`='$LMI_SYS_TRANS_DATE', `payer_purse`='$LMI_PAYER_PURSE', `type`='$type',
  `vin`='$vin', `payment`='$LMI_PAYMENT_AMOUNT', `trans_no`='$LMI_SYS_TRANS_NO'";
  
	//trans_no - Внутренний номер платежа в системе WebMoney Transfer
	//payer_purse - Кошелек покупателя (LMI_PAYER_PURSE);
	//кошелек продавца ???
	//payment - Сумма платежа
	//, `email`='$_POST['email']' - может быть инфа о покупателе...

 

	mysql_query($q);
  // Отправляем УВЕДОМЛЕНИЕ на email продавца с сообщением о платеже и типе отчета
  
/*  $text="VIN: ".$_POST['vin']."/nType of report: ".$_POST['type']."/nPAYMENT AMOUNT: ".$_POST['LMI_PAYMENT_AMOUNT']."/nWM SYSTEM TRANSFER NUMBER: ".$_POST['LMI_SYS_TRANS_NO']."/nVINMD ORDER NUMBER: ".$_POST['LMI_PAYMENT_NO']."/nWM SYSTEM TRANSFER DATE: ".$_POST['LMI_SYS_TRANS_DATE'];
   mail("adam-iug@mail.ru", "vinmd - transfer", $text,
   "From: robot@vinmd.com\r\nContent-Type: text/plain; charset=\"utf-8\"");  */
  //$text="Ваш товар: ".$tovar;
  //mail($_POST['email'], convert_cyr_string("Ваш товар",w,k), convert_cyr_string($text,w,k),
  // "From: robot@site.ru\r\nContent-Type: text/plain; charset=\"utf-8\"");
}

//mysql_close( );
?>
</body> 
</html>


