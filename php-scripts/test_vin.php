<html>
<head>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<style>
.btn{
	display:block;
	text-align: center;
	background: #c8e2b2;
	border: 1px solid #000;
	font-size: 20px;
	text-decoration: none;
	float: left;
	margin: 0 0 0 31px;
	padding: 20px;
	color:#000;
}

.btn:hover{
	opacity:0.8;
}
#options,
#allmessage,
.main-table{
	width:1000px;
	margin:0 auto;
}
.clear{
	clear:both;
}
</style>
<script>
function checkvin(vin,type){

	$.get("http://vinmd.com/php-scripts/check.php?vin="+vin+"&type="+type,function(data){
			
			if(type == "carfax"){
				$("#load_carfax").remove();
				$("#carfax").html($(data).html());
			} else if (type == "autocheck"){
				$("#load_autocheck").remove();
				$("#autocheck").html($(data).html());
			}else if (type == "copart"){
				$("#load_copart").remove();
				$("#copart").parent().html($(data).html());
			}else if (type == "manheim"){
				$("#load_manheim").remove();
				$("#manheim").parent().html($(data).text());

			}
			
			$("#allmessage").hide();
	}).fail(function(data) {
		    if(type == "carfax"){
				$("#load_carfax").remove();
				$("#carfax").parent().html(data.responseText);
				$("select[name='report_type'] option[value='1']").attr("disabled","disabled");
			} else if (type == "autocheck"){
				$("#load_autocheck").remove();
				$("#autocheck").parent().html(data.responseText);
				$("select[name='report_type'] option[value='2']").attr("disabled","disabled");
			}else if (type == "copart"){
				$("#load_copart").remove();
				$("#copart").parent().html(data.responseText);
				//$("select[name='report_type'] option[value='3']").attr("disabled","disabled");
			}else if (type == "manheim"){
				$("#manheim").parent().html(data.responseText);
				$("#load_manheim").remove();
				//$("select[name='report_type'] option[value='4']").attr("disabled","disabled");
			}
  });
}
function setcookie(name, value, expires, path, domain, secure) {	
				expires instanceof Date ? expires = expires.toGMTString() : typeof(expires) == "number" && (expires = (new Date(+(new Date) + expires * 1e3)).toGMTString());
				var r = [name + "=" + escape(value)], s, i;
				for(i in s = {expires: expires, path: path, domain: domain}){
					s[i] && r.push(i + "=" + s[i]);
				}
				return secure && r.push("secure"), document.cookie = r.join(";"), true;
			}
</script>
</head>
<body>
<?php 

		$curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, "http://cgi.autovin.de/client/checkbalance?authToken=4e9915dea86e4008968a7c24aeb00e77");
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
        $amount = curl_exec($curl_handle);
        curl_close($curl_handle);
		

		if($amount < 10){
			if(mail('vinmd1@mail.ru', 'Alert', "Please check balance acc - your amount balance = " . $amount)){
				
			}
		}

$multilang  = array('ru'=>array('head'=>"Найдена информация на транспортное средство",'error'=>"&nbsp;&nbsp;&nbsp;&nbsp;К сожалению, транспортное средство с данным VIN кодом не найдено в базе ",
									'error2'=>"&nbsp;&nbsp;К сожалению, транспортное средство с данным VIN кодом не найдено в базах CARFAX, AutoCheck.
       <br />&nbsp;&nbsp;Попробуйте  проверить введенную Вами информацию.",'report_head'=>"Отчеты и способы оплаты",'select_report'=>"Выберите тип отчета",'select_payment'=>"Выберите способ оплаты",
	   'footer'=>"Если вы не нашли для себя удобный способ оплаты, из выше перечисленных, свяжитесь с администрацией.",'attention'=>"ВНИМАНИЕ! После оплаты Вы будете перенаправлены на страницу отчёта. Пожалуйста, будьте терпеливы.",
	   'button_pay'=>"Оплатить"),'ro'=>array('head'=>"Informații găsite pe vehicul",'error'=>"&nbsp;&nbsp;&nbsp;&nbsp;Din păcate, vehiculul cu codul VIN nu este găsit în baza de date ",
									'error2'=>"&nbsp;&nbsp;Din păcate, vehiculul cu codul VIN nu este găsit la baze CARFAX, AutoCheck.
       <br />&nbsp;&nbsp;Încercați să verificați informațiile pe care le-ați introdus.",'report_head'=>"Rapoarte și Metode de plată",'select_report'=>"Selectați tipul de raport",'select_payment'=>"Selectați o metodă de plată",
	   'footer'=>"Dacă nu ați găsit o modalitate convenabilă de plată de mai sus, va rugam sa ne contactați .",'attention'=>"ATENȚIE! După plată veți fi redirecționat către pagina. Vă rugăm să aveți răbdare.",
	   'button_pay'=>"Plăti"),'en'=>array('head'=>"Information found on the vehicle",'error'=>"&nbsp;&nbsp;&nbsp;&nbsp;Once the vehicle VIN code is not found in the database ",
									'error2'=>"&nbsp;&nbsp;Unfortunately, vehicle VIN code is not found in database CARFAX, AutoCheck.
       <br />&nbsp;&nbsp;Try to check the information you entered.",'report_head'=>"Reports and Payment Methods",'select_report'=>"Select the type of report",'select_payment'=>"Select a payment method",
	   'footer'=>"If you have not found a convenient way above payment, please contact us.",'attention'=>"WARNING! After payment you will be redirected to the page. Please be patient.",
	   'button_pay'=>"Pay"));

//G9xwJBn5
require  $_SERVER['DOCUMENT_ROOT'].'/configuration.php';

$nominal = '0';//'13.9539';

$curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://www.bnm.md/md/official_exchange_rates?get_xml=1&date='.date('d.m.Y'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    $rate = curl_exec($curl);
    curl_close($curl);
//var_dump($rate);
	$response = simplexml_load_string($rate);
	
	foreach($response->Valute as $valute){
		if($valute->NumCode == 840){
			$nominal = $valute->Value;
			break;
		}
	}
	



$cfg = new JConfig();

		$conn = @mysql_connect($host, $cfg->user, $cfg->password) or die("Could not connect to MySQL server!");

		@mysql_select_db($cfg->db) or die("Could not select the database!");
  
  $q="SELECT MAX(`id`) FROM `db_orders`";
  $res=mysql_fetch_row(mysql_query($q));

  if(!$res[0] or $res[0]=="") {
    $PAYMENT_NO=1;
  }
  else {
  $PAYMENT_NO=$res[0]+1;
  }
  mysql_close( );


if (isset($_POST['go'])){ 
$vin=trim($_POST['vin']);
 $error = false;
//'1B4GP45312B619716';
$url1 ='http://cgi.autovin.de/client/checkRecords?authToken=4e9915dea86e4008968a7c24aeb00e77&vin='.$vin;
//1B4GP45312B619716
$type1='&type=carfax';
$type2='&type=autocheck';
$type3='&type=copart';
$type4='&type=manheim';

}else if(isset($_POST['payment']) && $_POST['payment'] != "webmoney"){

	
	$report_type = array('1'=>'CarF','2'=>'AutoCh','3'=>"Copart",'4'=>"Manheim",'5'=>'CarF + AutoCH');

	$vin=trim($_POST['vin']);
//$_POST['LMI_PAYMENT_AMOUNT']
	$succes_url = "http://".$_SERVER['HTTP_HOST']."/php-scripts/success_wm.php";
	$fail_url = 'http://'.$_SERVER['HTTP_HOST'].'/php-scripts/fail_wm.php';
	 $reques_bpay = '<payment> 
					<type>1.2</type> 
					<merchantid>vinmd_com1402402868</merchantid> 
					<amount>'.$_POST['LMI_PAYMENT_AMOUNT'].'</amount> 
					<description>Отчет '.$report_type[$_POST['report_type']].'</description> 
					<method>'.$_POST['payment'].'</method> 
					<order_id>'.$PAYMENT_NO.'</order_id> 
					<success_url>'.$succes_url.'</success_url> 
					<fail_url>'.$fail_url.'</fail_url> 
					<callback_url>CALLBACK_URL</callback_url> 
					<lang></lang> 
					<advanced1></advanced1> 
					<advanced2></advanced2> 
					<istest>0</istest> 
					<getUrl>200</getUrl> 
					</payment>';

	$fields['data'] =  base64_encode($reques_bpay);
	$fields['key'] =  md5(md5($reques_bpay).md5('FCFqpcm0JfV'));
	
		
	$post = http_build_query($fields);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://www.bpay.md/user-api/payment1');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    $out = curl_exec($curl);
    curl_close($curl);

	$response = simplexml_load_string($out);
	//var_dump($response);
	if(isset($response->url)){
		//header('Location:'.$response->url);
		
		$url = parse_url($response->url);
		
		$new_url = 'https://'.$url['host'] . '/'.$_COOKIE['jfcookie']['lang'].''.$url['path'];
		
		echo '<script>
		setcookie("vinCookie", "'.$vin.'");
		setcookie("typeCookie", "'.$_POST['report_type'].'");
		window.location = "'.$new_url.'";</script>';
		
	}else {
		$error = true;
		$payment_error = "200";
	}
		
}

if (empty($vin) || strlen($vin) != 17 || !ctype_alnum($vin)) {
        $error = true;
    } else {
	?>
	<script>
	checkvin('<?=$vin?>','carfax');
	checkvin('<?=$vin?>','autocheck');
	checkvin('<?=$vin?>','copart');
	checkvin('<?=$vin?>','manheim');
	</script>
<?php
	   		
		
}	
		?>
		
<?php if ($error): ?>
	    <?php 
			if($payment_error){
				echo '<p style="color: #cd2626;text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;Попробуйте повторить действие чуть позже</p>';
			} else {
				echo ' <p style="color: #cd2626;text-align:center;">&nbsp;&nbsp;К сожалению, транспортное средство с данным VIN кодом не найдено в базах CARFAX, AutoCheck.
						<br />&nbsp;&nbsp;Попробуйте проверить введенную Вами информацию.</p>';
			}
		?>
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
	console.log(document.getElementById('payment').value)
	if(!(document.getElementById('payment').value == "webmoney"))
		document.pay.LMI_PAYMENT_AMOUNT.value= parseFloat('4.50') * parseFloat('<?=$nominal?>');
	else 
		document.pay.LMI_PAYMENT_AMOUNT.value= parseFloat('4.50');
	//document.pay.LMI_PAYMENT_AMOUNT.value='0.05';	
	//alert('type.value='+document.pay.type.value);
	x.submit();
	break;
	case '2':	//autocheck
	if(!(document.getElementById('payment').value == "webmoney"))
		document.pay.LMI_PAYMENT_AMOUNT.value=parseFloat('4.00') * parseFloat('<?=$nominal?>');
	else 
		document.pay.LMI_PAYMENT_AMOUNT.value= parseFloat('4.00');	
	//document.pay.LMI_PAYMENT_AMOUNT.value='0.05';
	x.submit();
	break;
	case '3':	//copart
	if(!(document.getElementById('payment').value == "webmoney"))
		document.pay.LMI_PAYMENT_AMOUNT.value=parseFloat('6.00') * parseFloat('<?=$nominal?>');
	else 
		document.pay.LMI_PAYMENT_AMOUNT.value= parseFloat('6.00');		
	//document.pay.LMI_PAYMENT_AMOUNT.value='0.05';
	x.submit();
	break;
	case '4':	//manheim
	if(!(document.getElementById('payment').value == "webmoney"))
		document.pay.LMI_PAYMENT_AMOUNT.value=parseFloat('7.00') * parseFloat('<?=$nominal?>');
	else 
		document.pay.LMI_PAYMENT_AMOUNT.value= parseFloat('7.00');			
	//document.pay.LMI_PAYMENT_AMOUNT.value='0.05';
	x.submit();
	break;
	case '5':	//carfax_autocheck
	if(!(document.getElementById('payment').value == "webmoney"))
		document.pay.LMI_PAYMENT_AMOUNT.value=parseFloat('8.00') * parseFloat('<?=$nominal?>');
	else 
		document.pay.LMI_PAYMENT_AMOUNT.value= parseFloat('8.00');		
	//document.pay.LMI_PAYMENT_AMOUNT.value='0.05';
	x.submit();
	break;
	case '6':	//carfax_copart
	if(!(document.getElementById('payment').value == "webmoney"))
		ocument.pay.LMI_PAYMENT_AMOUNT.value=parseFloat('10.00') * parseFloat('<?=$nominal?>');
	else 
		document.pay.LMI_PAYMENT_AMOUNT.value= parseFloat('10.00');		
	//document.pay.LMI_PAYMENT_AMOUNT.value='0.05';
	x.submit();
	break;
	case '7':	//autocheck_copart
	if(!(document.getElementById('payment').value == "webmoney"))
		document.pay.LMI_PAYMENT_AMOUNT.value=parseFloat('10.00') * parseFloat('<?=$nominal?>');
	else 
		document.pay.LMI_PAYMENT_AMOUNT.value= parseFloat('10.00');			
	//document.pay.LMI_PAYMENT_AMOUNT.value='0.05';
	x.submit();
	break;
	case '8':	//carfax_autocheck_copart
	if(!(document.getElementById('payment').value == "webmoney"))
		document.pay.LMI_PAYMENT_AMOUNT.value=parseFloat('14.00') * parseFloat('<?=$nominal?>');
	else 
		document.pay.LMI_PAYMENT_AMOUNT.value= parseFloat('14.00');			
	//document.pay.LMI_PAYMENT_AMOUNT.value='0.05';
	x.submit();
}


}

function type_method(x){

	switch (x){
	case 'webmoney':
	var form = document.getElementById('pay');
	form.setAttribute("action", "https://merchant.webmoney.ru/lmi/payment.asp");
	return false;
	break;
	
	default:
	var form = document.getElementById('pay');
	form.setAttribute("action", "");
	return false;
	break;
	
	x.submit();
}

}

</script>
<table class="main-table"><tbody><tr><td>
<?php 
//carfax
?>	
        <table class="main-table" style="width:100%;"><tbody><tr><td>
            <p><br><img src="/images/carfax.gif" alt="CARFAX" style="float: left; margin: 10px 6px 10px 0px;"></p><br clear="left" />
		
            <p class="head1"><?=$multilang[$_COOKIE['jfcookie']['lang']]['head']?></p><br>
            <table style="width:100%; "><tbody>
            <tr>
                <td>
                    <div style="width:100%;text-align:center;">
                            <table class="vin-table" id="carfax"><tbody>
                              <img id="load_carfax" src="http://vinmd.com/php-scripts/712.GIF" width="50">
							  </tbody>
							  </table>
                    </div>
                </td>
            </tr>
        </tbody></table>	

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

            <p class="head1"><?=$multilang[$_COOKIE['jfcookie']['lang']]['head']?></p><br>
			<table style="width:100%;"><tbody>
            <tr>
                <td>
            <div style="width:100%;text-align:center;">
						
                            <table class="vin-table" id="autocheck">
									<img id="load_autocheck" src="http://vinmd.com/php-scripts/712.GIF" width="50">
							</table>
                    </div>
                </td>
            </tr>
        </tbody></table>	

            </td>
	        </tr>
        </tbody></table>
           

 </td>
            </tr>
		
		<tr>
			<td>
			
		    <table class="main-table" style="width:100%;"><tbody><tr><td>
            <p><br><img src="/images/copart.png" alt="copart" style="float: left; margin: 10px 6px 10px 0px;height:50px;"></p><br clear="left" />

			<table style="width:100%;"><tbody>
            <tr>
                <td>
            <div style="width:100%;">
						
                            <table class="vin-table" id="copart">
									<img id="load_copart" src="http://vinmd.com/php-scripts/712.GIF" width="50">
							</table>
                    </div>
                </td>
            </tr>
        </tbody></table>	

            </td>
	        </tr>
        </tbody></table>
			</td>
			<td>
			<table class="main-table" style="width:100%;"><tbody><tr><td>
            <p><br><img src="/images/manheim.gif" alt="manheim" style="float: left; margin: 10px 6px 10px 0px; height:50px;"></p><br clear="left" />

			<table style="width:100%;"><tbody>
            <tr>
                <td>
            <div style="width:100%;">
						
                            <table class="vin-table" id="manheim">
									<img id="load_manheim" src="http://vinmd.com/php-scripts/712.GIF" width="50">
							</table>
                    </div>
                </td>
            </tr>
        </tbody></table>	

            </td>
	        </tr>
        </tbody></table>
			</td>
		</tr>	
				
        </tbody>
		
		</table>
		<div class="clear"></div>
		
        <p id="allmessage" style="color: #cd2626;text-align:center; display:none;"><?=$multilang[$_COOKIE['jfcookie']['lang']]['error2']?> </p>

<div style="text-align:left;" id="options">
<h2 ><?=$multilang[$_COOKIE['jfcookie']['lang']]['report_head']?></h2>
<form id="pay" name="pay" method="POST" action="">
<table  style1="text-align:center; margin-left:auto; margin-right:auto;" border1=1>
<tr>
<td>
<select name="report_type" onchange1="type_price(this.value);">
<option value="0" selected><?=$multilang[$_COOKIE['jfcookie']['lang']]['select_report']?></option>
<option value="1" onclick="text_del();">Carfax – 4.5 $</option>
<option value="2" onclick="text_del();">Autocheck – 4 $</option>
<option value="3" onclick="text_del();" >Copart – 6 $ (свяжитесь с администратором)</option>
<option value="4" onclick="text_del();" >Manheim – 6 $ (свяжитесь с администратором)</option>
<option value="5" onclick="text_del();" >Carfax + Autocheck – 8 $</option>
<option value="6" onclick="text_del();" DISABLED>Carfax + Copart – 10 $ (свяжитесь с администратором)</option>
<option value="7" onclick="text_del();" DISABLED>Autocheck + Copart – 10 $ (свяжитесь с администратором)</option>
<option value="8" onclick="text_del();" DISABLED>Carfax + Autocheck + Copart – 14 $ (свяжитесь с администратором)</option>
</select>
</td>
<td>
<select id="payment" name="payment" onchange="type_method(this.value);">
<option value=""><?=$multilang[$_COOKIE['jfcookie']['lang']]['select_payment']?></option>
<option value="webmoney">WebMoney</option>
<optgroup label="Bpay-Payment">
<option value="bpay">Bpay</option>
	<option value="card">Master card / Visa</option>
	<option value="yamoney">Yandex</option>
	<option value="w1">WalletOne</option>
	
  </optgroup>
</select>
</td>
<td>

<input type="hidden" name="vin" value="<?php echo $vin ?>">
<input type="hidden" name="authToken" value="4e9915dea86e4008968a7c24aeb00e77">
<input type="hidden" name="type" >
	<input name="LMI_PAYMENT_AMOUNT" value1="0.05" type="hidden" title="Сумма платежа">
	<input name="LMI_PAYMENT_DESC" value="test - VIN" type="hidden">
	<input type="hidden" name="LMI_PAYMENT_NO" value="<?php echo $PAYMENT_NO ?>" title="уникальный номер для каждого платежа - value формировать скриптом и хранить в БД как Autoincrement field!!!">
	<input name="LMI_PAYEE_PURSE" value="Z207306436347" type="hidden" title="Кошелек продавца">
	<input name="LMI_SIM_MODE" value="0" type="hidden" title="Дополнительное поле, определяющее режим тестирования. Действует только в режиме тестирования и может принимать одно из следующих значений: 0 или отсутствует - Для всех тестовых платежей сервис будет имитировать успешное выполнение; 1 - Для всех тестовых платежей сервис будет имитировать выполнение с ошибкой (платеж не выполнен); 2 - Около 80% запросов на платеж будут выполнены успешно, а 20% - не выполнены.">
	
	<input name="LMI_PAYMENT_DESC_BASE64" value="платеж по счету" type="hidden" title="Описание товара или услуги в UTF-8 и далее закодированное алгоритмом Base64. Формируется продавцом">	



<input type="button" name="oplata" value="<?=$multilang[$_COOKIE['jfcookie']['lang']]['button_pay']?>" onclick="type_price(this.form);">
<span id="error_msg" style="color: red;"></span>
</td>
</tr>
<tr>
<td colspan="3">
&nbsp;
<p style="color: red; font-size:17px;"><?=$multilang[$_COOKIE['jfcookie']['lang']]['attention']?> </p>
<!--p style="color: red;">После оплаты Вы будете перенаправлены на страницу отчета - процесс длится около 30 секунд. Чтобы вернуться на предыдущую страницу, нажмите на кнопку "Вернуться на страницу проверки автомобиля".</p--> 
</td>
</tr>
</table>
<p>




	
</p>

</form>
</div>

	
	
<?php endif; ?>
<div style="position:absolute; bottom:0px; width:98%;">
	<p style="font-size:14px; text-align:center; "><?=$multilang[$_COOKIE['jfcookie']['lang']]['footer']?></p>
</div>	
</body>
</html>
	
		