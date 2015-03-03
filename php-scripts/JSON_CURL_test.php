<meta http-equiv="content-type" content="text/html; charset=windows-1251">

<?php 
if (isset($_POST['go'])){ 
$vin=trim($_POST['vin']);
 $error = false;
//'1B4GP45312B619716';
$url1 ='http://cgi.autovin.de/client/checkRecords?authToken=4e9915dea86e4008968a7c24aeb00e77&vin='.$vin;
//1B4GP45312B619716
$type1='&type=carfax';
$type2='&type=autocheck';
}

?> 

<script>
function f1(){
$url2 ="http://cgi.autovin.am/client/getreport?authToken=4e9915dea86e4008968a7c24aeb00e77&vin={ Your VIN }&type={ carfax | autocheck }";


}

function text_del(){
document.getElementById('error_msg').innerHTML='';
}


function type_price(x){
document.getElementById('error_msg').innerHTML="";
	x.type.value=x.report_type.value;
	switch (x.type.value){
	case '0':
	document.getElementById('error_msg').innerHTML="Выберите тип отчета!!!";
	document.pay.report_type.focus();
	return false;
	break;
	case '1':	//carfax
	//document.pay.LMI_PAYMENT_AMOUNT.value='6.00';
	document.pay.LMI_PAYMENT_AMOUNT.value='0.05';	
	//alert('type.value='+document.pay.type.value);
	x.submit();
	break;
	case '2':	//autocheck
	//document.pay.LMI_PAYMENT_AMOUNT.value='5.00';
	document.pay.LMI_PAYMENT_AMOUNT.value='0.05';
	x.submit();
	break;
	case '3':	//copart
	//document.pay.LMI_PAYMENT_AMOUNT.value='6.00';
	document.pay.LMI_PAYMENT_AMOUNT.value='0.05';
	x.submit();
	break;
	case '4':	//manheim
	//document.pay.LMI_PAYMENT_AMOUNT.value='7.00';
	document.pay.LMI_PAYMENT_AMOUNT.value='0.05';
	x.submit();
	break;
	case '5':	//carfax_autocheck
	//document.pay.LMI_PAYMENT_AMOUNT.value='10.00';
	document.pay.LMI_PAYMENT_AMOUNT.value='0.05';
	x.submit();
	break;
	case '6':	//carfax_copart
	//document.pay.LMI_PAYMENT_AMOUNT.value='11.00';
	document.pay.LMI_PAYMENT_AMOUNT.value='0.05';
	x.submit();
	break;
	case '7':	//autocheck_copart
	//document.pay.LMI_PAYMENT_AMOUNT.value='10.00';
	document.pay.LMI_PAYMENT_AMOUNT.value='0.05';
	x.submit();
	break;
	case '8':	//carfax_autocheck_copart
	//document.pay.LMI_PAYMENT_AMOUNT.value='15.00';
	document.pay.LMI_PAYMENT_AMOUNT.value='0.05';
	x.submit();
}
//alert('type.value='+x.type.value+'\nLMI_PAYMENT_AMOUNT.value='+document.pay.LMI_PAYMENT_AMOUNT.value);


}
</script>


 


	
<?php

if (empty($vin) || strlen($vin) != 17 || !ctype_alnum($vin)) {
        $error = true;
    } else {
	//carfax
        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url1.$type1);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
        $content = curl_exec($curl_handle);
        curl_close($curl_handle);
		$data = json_decode($content);
		/*echo $data->VIN . "<br>";
		echo $data->YearMakeModel . "<br>";
		echo $data->Engine . "<br>";
		echo $data->ManufacturedIN . "<br>";
		echo $data->Records . "<br>";
		echo $data->BodyStyle . "<br>";*/

	//autocheck	
		$curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url1.$type2);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
        $content1 = curl_exec($curl_handle);
        curl_close($curl_handle);
		$data1 = json_decode($content1);
		/*echo $data1->VIN . "<br>";
		echo $data1->YearMakeModel . "<br>";
		echo $data1->Engine . "<br>";
		echo $data1->ManufacturedIN . "<br>";
		echo $data1->Records . "<br>";
		echo $data1->BodyStyle . "<br>";*/
		
}	
		?>
		
<?php if ($error): ?>
    <p style="color: #cd2626;text-align:center;">&nbsp;&nbsp;К сожалению, транспортное средство с данным VIN кодом не найдено в базах CARFAX, AutoCheck.
       <br />&nbsp;&nbsp;Попробуйте проверить введенную Вами информацию.</p>
<?php else: ?>	
	 <style>
      .vin-table {
        border-collapse: collapse;
        margin:0 auto;
        background-color: #eeeed1;
      }
      .vin-table td{
        margin:0;
        padding:3px 3px 3px 7px;
        width: 280px;
        border: 1px solid #000;
      }
	  .head1{
	    font-size: 115%;
		/*font-weight: bold;*/
	  }
    </style>

<table class="main-table" style="width:100%;"><tbody><tr><td>
<?php 
//carfax
?>	
        <table class="main-table" style="width:100%;"><tbody><tr><td>
            <p><br><img src="/images/carfax.gif" alt="CARFAX" style="float: left; margin: 10px 6px 10px 0px;"></p><br clear="left" />
<?php 			
if ($data->VIN): ?>			
            <p class="head1">Найдена информация на транспортное средство</p><br>
            <table style="width:100%;"><tbody>
            <tr>
                <td>
                    <div style="width:100%;">
                            <table class="vin-table"><tbody>
                                <tr><td>VIN</td><td><?php echo $data->VIN ?></td></tr>
                                <tr><td>Year/Make</td><td><?php echo $data->YearMakeModel ?></td></tr>
                                <tr><td>Body</td><td><?php echo $data->BodyStyle ?></td></tr>
                                <tr><td>Engine</td><td><?php echo $data->Engine ?></td></tr>
                                <tr><td>Country of assembly</td><td><?php echo $data->ManufacturedIN ?></td></tr>
                                <tr><td>Records found</td><td><?php echo $data->Records ?></td></tr>
                            </tbody></table>
                    </div>
                </td>
            </tr>
        </tbody></table>	
    <?php endif; ?>
	
 <?php if (empty($data->VIN)) : ?>
        <p style="color: #cd2626;">&nbsp;&nbsp;&nbsp;&nbsp;К сожалению, транспортное средство с данным VIN кодом не найдено в базе CARFAX.
       <?php endif; ?>

		
	</td>
            </tr>
        </tbody></table>		

		

</td>
<td>
		
<?php 
//autocheck
?>

		
        <table class="main-table" style="width:100%;"><tbody><tr><td>
            <p><br><img src="/images/autocheck.gif" alt="autocheck" style="float: left; margin: 10px 6px 10px 0px;"></p><br clear="left" />

<?php
if ($data1->VIN): ?>

            <p class="head1">Найдена информация на транспортное средство</p><br>
			<table style="width:100%;"><tbody>
            <tr>
                <td>
            <div style="width:100%;">
                            <table class="vin-table"><tbody>
                                <tr><td>VIN</td><td><?php echo $data1->VIN ?></td></tr>
                                <tr><td>Year/Make</td><td><?php echo $data1->YearMakeModel ?></td></tr>
                                <tr><td>Body</td><td><?php echo $data1->BodyStyle ?></td></tr>
                                <tr><td>Engine</td><td><?php echo $data1->Engine ?></td></tr>
                                <tr><td>Country of assembly</td><td><?php echo $data1->ManufacturedIN ?></td></tr>
                                <tr><td>Records found</td><td><?php echo $data1->Records ?></td></tr>
                            </tbody></table>
                    </div>
                </td>
            </tr>
        </tbody></table>	
    <?php endif; ?>
	
<?php if (empty($data1->VIN)) : ?>
        <p style="color: #cd2626;">&nbsp;&nbsp;&nbsp;&nbsp;К сожалению, транспортное средство с данным VIN кодом не найдено в базе AutoCheck.
       <?php endif; ?>

            </td>
	        </tr>
        </tbody></table>
           

 </td>
            </tr>
        </tbody></table>
		
    <?php if (empty($data->VIN) && empty($data1->VIN)): ?>
        <p style="color: #cd2626;text-align:center;">&nbsp;&nbsp;К сожалению, транспортное средство с данным VIN кодом не найдено в базах CARFAX, AutoCheck.
       <br />&nbsp;&nbsp;Попробуйте <!--a href="http://vinmd.com/ru/proverit-avto">вернуться</a> и--> проверить введенную Вами информацию.</p>
   
	<?php else: ?>	
	<div style="text-align:left;">
<h2 >Отчеты и способы оплаты</h2>
<form id="pay" name="pay" method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<table  style1="text-align:center; margin-left:auto; margin-right:auto;" border1=1>
<tr>
<td>
<select name="report_type" onchange1="type_price(this.value);">
<option value="0" selected>Выберите тип отчета</option>
<option value="1" onclick="text_del();">Carfax – 6 $</option>
<option value="2" onclick="text_del();">Autocheck – 5 $</option>
<option value="3" onclick="text_del();">Copart – 6 $</option>
<option value="4" onclick="text_del();">Manheim – 7 $</option>
<option value="5" onclick="text_del();">Carfax + Autocheck – 10 $</option>
<option value="6" onclick="text_del();">Carfax + Copart – 11 $</option>
<option value="7" onclick="text_del();">Autocheck + Copart – 10 $</option>
<option value="8" onclick="text_del();">Carfax + Autocheck + Copart – 15 $</option>
</select>
</td>
<td>
<select name="payment">
<option value="wm">WebMoney</option>
<!--<option value="bpay">Bpay</option>
<option value="card">Master card / Visa</option>
<option value="robokassa">RoboKassa</option>-->
</select>
</td>
<td>

<input type="hidden" name="vin" value="<?php echo $vin ?>">
<input type="hidden" name="authToken" value="4e9915dea86e4008968a7c24aeb00e77">
<input type="hidden" name="type" >

<?php
// Соединяемся с БД
		$host= "localhost"; 
		$user="viteg_vinmd";
		$pass="G9xwJBn5";
		$dbname="viteg_vinmd";

		$conn = @mysql_connect($host, $user, $pass) or die("Could not connect to MySQL server!");
		@mysql_select_db($dbname) or die("Could not select the database!");
//echo "<BR>".mysql_errno().": ".mysql_error()."<BR>"; 
		
  // Проверяем, какое максимальное значение id  в базе данных.
  // Увеличиваем его значение на 1 
  //(если это первая запись в БД, то присваиваем значение 1 - ЕДИНОЖДЫ!!!)
  
  $q="SELECT MAX(`id`) FROM `db_orders`";
  $res=mysql_fetch_row(mysql_query($q));
  if(!$res[0] or $res[0]=="") {
    $PAYMENT_NO=1;
  }
  else {
  $PAYMENT_NO=$res[0]+1;
  }
  mysql_close( );
?>
	<input name="LMI_PAYMENT_AMOUNT" value1="0.05" type="hidden" title="Сумма платежа">
	<input name="LMI_PAYMENT_DESC" value="test - VIN" type="hidden">
	<input type="hidden" name="LMI_PAYMENT_NO" value="<?php echo $PAYMENT_NO ?>" title="уникальный номер для каждого платежа - value формировать скриптом и хранить в БД как Autoincrement field!!!">
	<input name="LMI_PAYEE_PURSE" value="Z207306436347" type="hidden" title="Кошелек продавца">
	<input name="LMI_SIM_MODE" value="0" type="hidden" title="Дополнительное поле, определяющее режим тестирования. Действует только в режиме тестирования и может принимать одно из следующих значений: 0 или отсутствует - Для всех тестовых платежей сервис будет имитировать успешное выполнение; 1 - Для всех тестовых платежей сервис будет имитировать выполнение с ошибкой (платеж не выполнен); 2 - Около 80% запросов на платеж будут выполнены успешно, а 20% - не выполнены.">
	
	<!--input name="LMI_PAYMENT_DESC_BASE64" value="платеж по счету" type="hidden" title="Описание товара или услуги в UTF-8 и далее закодированное алгоритмом Base64. Формируется продавцом"-->	



<input type="button" name="oplata" value="Оплатить" onclick="type_price(this.form);">
<span id="error_msg" style="color: red;"></span>
</td>
</tr>
<tr>
<td colspan="3">
&nbsp;
<!--p style="color: red;">После оплаты Вы будете перенаправлены на страницу отчета - процесс длится около 30 секунд. Чтобы вернуться на предыдущую страницу, нажмите на кнопку "Вернуться на страницу проверки автомобиля".</p--> 
</td>
</tr>
</table>
<p>




	
</p>

</form>
</div>
   <?php endif; ?>
	
	
<?php endif; ?>
	
	
		