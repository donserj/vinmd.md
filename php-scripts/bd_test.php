<?php
// Соединяемся с БД
		$host= "localhost"; 
		$user="viteg_vinmd";
		$pass="G9xwJBn5";
		$dbname="viteg_vinmd";

		$conn = mysql_connect($host, $user, $pass) or die("Could not connect to MySQL server!");
		mysql_select_db($dbname) or die("Could not select the database!");
echo "<BR>".mysql_errno().": ".mysql_error()."<BR>"; 
		
// Если это форма предварительного запроса, то идем дальше...

  // 1) Проверяем, есть ли товар с таким id в базе данных.
  // Если такой товар не обнаружен, то выводим ошибку и прерываем работу скрипта.
$type='11';
 
  $q="SELECT `id`, `type`, `cost1` FROM `db_types` WHERE id='$type'"; 
 //$q="SELECT `id`, `type` FROM `db_types`";
  $res=mysql_fetch_row(mysql_query($q));
  if(!$res[0] or $res[0]=="") {
    echo "ERR: НЕТ ТАКОГО ТОВАРА";
    exit;
  }
  else {
  echo "ЕСТЬ ТАКОЙ ТОВАР";
  }
?>