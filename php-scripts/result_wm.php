<!-- result.php --> 
<html> 
<head> 
<title>result</title> 
<meta http-equiv="content-type" content="text/html; charset=windows-1251">

</head> 
<body> 
<?php
// ����������� � ��
		$host= "localhost"; 
		$user="viteg_vinmd";
		$pass="G9xwJBn5";
		$dbname="viteg_vinmd";

//��������� � ���������� $PREREQUEST �������� $_POST['LMI_PREREQUEST']	
$PREREQUEST="";	
if (isset($_POST['LMI_PREREQUEST'])){
$PREREQUEST=$_POST['LMI_PREREQUEST'];
}
		
		$conn = @mysql_connect($host, $user, $pass) or die("Could not connect to MySQL server!");
		@mysql_select_db($dbname) or die("Could not select the database!");
//echo mysql_errno().": ".mysql_error()."<BR>"; 
		
// ���� ��� ����� ���������������� �������, �� ���� ������...
IF($PREREQUEST==1) {
  // 1) ���������, ���� �� ����� � ����� id � ���� ������.
  // ���� ����� ����� �� ���������, �� ������� ������ � ��������� ������ �������.
  
  //`cost1` ���� �������� �� `cost` � ������� ������!!!!!!!!!!!
  //� �������� ������ �������� ��� ���� ������� ���� `cost1`=0.05
 
$type=$_POST['type'];
 
  $q="SELECT `id`, `type`, `cost` FROM `db_types` WHERE id='$type'";
  $res=mysql_fetch_row(mysql_query($q));
  if(!$res[0] or $res[0]=="") {
    echo "ERR: NET TAKOGO TIPA OTCHETA";
    exit;
  }
  // 2) ���������, �� ��������� �� ������� �����.
  // C��������� ��������� ������ � ���� ������ � ��� ������, ��� �������� ��� ���������.
  // ���� ����� �� ���������, �� ������� ������ � ��������� ������ �������.
  if(trim($res[2])!=trim($_POST['LMI_PAYMENT_AMOUNT'])) {
    echo "ERR: NEVERNAIA SUMMA ".$_POST['LMI_PAYMENT_AMOUNT'];
    exit;
  }
  // 3) ���������, �� ��������� �� ������� ��������.
  // C��������� ��� ��������� ������� � ��� ���������, ������� ������� ��� ���������.
  // ���� �������� �� ���������, �� ������� ������ � ��������� ������ �������.
  if(trim($_POST['LMI_PAYEE_PURSE'])!="Z207306436347") {
    echo "ERR: NEVERNYI KOSHELEK POKUPATELIA ".$_POST['LMI_PAYEE_PURSE'];
    exit;
  }
  // 4) ���������, ������ �� ������������ ���� email.
  // ���� �������� $email ������, �� ������� ������ � ��������� ������ �������.
 /* if(!trim($_POST['email']) or trim($_POST['email'])=="") {
    echo "ERR: �� ������ EMAIL";
    exit;
  }*/
  // ���� ������ �� �������� � �� ����� �� ����� �����, �� ������� YES
//mysql_close( ); 
 echo "YES";

 }

// ���� ��� LMI_PREREQUEST, ������������� ��� ����� ���������� � �������...
ELSE {
 // ������ �������� $secret_key.
  // ��� ������ ��������� � Secret Key, ��������� ���� � ���������� ��������.
  $secret_key="V1234567887654321D";
  // ��������� ������ ����������
  $common_string = $_POST['LMI_PAYEE_PURSE'].$_POST['LMI_PAYMENT_AMOUNT'].$_POST['LMI_PAYMENT_NO'].
     $_POST['LMI_MODE'].$_POST['LMI_SYS_INVS_NO'].$_POST['LMI_SYS_TRANS_NO'].
     $_POST['LMI_SYS_TRANS_DATE'].$secret_key.$_POST['LMI_PAYER_PURSE'].$_POST['LMI_PAYER_WM'];
  // ������� ���������� ������ � MD5 � ��������� �� � ������� �������
  $hash = strtoupper(md5($common_string));
  // ��������� ������ �������, ���� ����������� ����� �� ���������
  if($hash!=$_POST['LMI_HASH']) exit;



  // �������� �� ���� ������ ������ �����, ���������� ��� � ���������� $content;
 // ... Success.php
  
  


  // ������ ������� � ������� orders
  $LMI_PAYMENT_NO=$_POST['LMI_PAYMENT_NO'];
  $LMI_SYS_TRANS_DATE=$_POST['LMI_SYS_TRANS_DATE'];
  $LMI_PAYER_PURSE=$_POST['LMI_PAYER_PURSE'];
  $type=$_POST['type'];
  $vin=$_POST['vin'];
  $LMI_PAYMENT_AMOUNT=$_POST['LMI_PAYMENT_AMOUNT'];
  $LMI_SYS_TRANS_NO=$_POST['LMI_SYS_TRANS_NO'];
  
  $q="insert into `db_orders` set `id`='$LMI_PAYMENT_NO', `date`='$LMI_SYS_TRANS_DATE', `payer_purse`='$LMI_PAYER_PURSE', `type`='$type',
  `vin`='$vin', `payment`='$LMI_PAYMENT_AMOUNT', `trans_no`='$LMI_SYS_TRANS_NO'";
  
	//trans_no - ���������� ����� ������� � ������� WebMoney Transfer
	//payer_purse - ������� ���������� (LMI_PAYER_PURSE);
	//������� �������� ???
	//payment - ����� �������
	//, `email`='$_POST['email']' - ����� ���� ���� � ����������...

 

	mysql_query($q);
  // ���������� ����������� �� email �������� � ���������� � ������� � ���� ������
  
/*  $text="VIN: ".$_POST['vin']."/nType of report: ".$_POST['type']."/nPAYMENT AMOUNT: ".$_POST['LMI_PAYMENT_AMOUNT']."/nWM SYSTEM TRANSFER NUMBER: ".$_POST['LMI_SYS_TRANS_NO']."/nVINMD ORDER NUMBER: ".$_POST['LMI_PAYMENT_NO']."/nWM SYSTEM TRANSFER DATE: ".$_POST['LMI_SYS_TRANS_DATE'];
   mail("adam-iug@mail.ru", "vinmd - transfer", $text,
   "From: robot@vinmd.com\r\nContent-Type: text/plain; charset=\"utf-8\"");  */
  //$text="��� �����: ".$tovar;
  //mail($_POST['email'], convert_cyr_string("��� �����",w,k), convert_cyr_string($text,w,k),
  // "From: robot@site.ru\r\nContent-Type: text/plain; charset=\"utf-8\"");
}

//mysql_close( );
?>
</body> 
</html>


