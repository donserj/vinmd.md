<?php
$multilang  = array('ru'=>array('head'=>"Найдена информация на транспортное средство",'error'=>"К сожалению, транспортное средство с данным VIN кодом не найдено в базе ",
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
$url1 ='http://cgi.autovin.de/client/checkRecords?authToken=4e9915dea86e4008968a7c24aeb00e77&vin='.$_GET['vin'];
//1B4GP45312B619716
$type1='&type='.$_GET['type'];
$type2='&type=autocheck';
$type3='&type=copart';
$type4='&type=manheim';

if(isset($_GET['type'])){
	
		$curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url1.$type1);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
        $content = curl_exec($curl_handle);
        curl_close($curl_handle);
		$data1 = json_decode($content);
		
		if($_GET['type'] == "autocheck" || $_GET['type'] == "carfax"  ) {
			  $type = ($_GET['type'] == "autocheck" ) ? "AutoCheck" : "CARFAX";
			  $type = ($_GET['type'] == "copart" ) ? "Copart" : $type;
			  $type = ($_GET['type'] == "manheim" ) ? "Manheim" : $type;
			  if (empty($data1->VIN)){
					header("HTTP/1.0 404 Not Found");
					echo ' <p style="color: #cd2626;text-align: left;">'.$multilang[$_COOKIE['jfcookie']['lang']]['error']. $type .'.';
			  } else if($_GET['type'] == "carfax" || $_GET['type'] == "autocheck" ) {
		
		?>
       
    
		<tbody>
        <tr><td>VIN</td><td><?php echo $data1->VIN ?></td></tr>
                                <tr><td>Year/Make</td><td><?php echo $data1->YearMakeModel ?></td></tr>
                                <tr><td>Body</td><td><?php echo $data1->BodyStyle ?></td></tr>
                                <tr><td>Engine</td><td><?php echo $data1->Engine ?></td></tr>
                                <tr><td>Country of assembly</td><td><?php echo $data1->ManufacturedIN ?></td></tr>
                                <tr><td>Records found</td><td><?php echo $data1->Records ?></td></tr>
                            </tbody>
	<?php	
		}
	   } else if(!$data1->Available){
				header("HTTP/1.0 404 Not Found");
				echo ' <p style="color: #cd2626;text-align: left;">'.$multilang[$_COOKIE['jfcookie']['lang']]['error']. $type .'.';
			
	   }else if($data1->Available) {
			echo '<p style="text-align: left;">'.$multilang[$_COOKIE['jfcookie']['lang']]['head'].'</p>';
	   } 

	}
?>	
		