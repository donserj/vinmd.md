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
    <p style="color: #cd2626;">&nbsp;&nbsp;К сожалению, транспортное средство с данным VIN кодом не найдено в базах CARFAX, AutoCheck.
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
<?php 
//carfax	
if ($data->VIN): ?>
        <table class="main-table" style="width:100%;"><tbody><tr><td>
            <p><br><img src="/images/carfax.gif" alt="CARFAX" style="float: left; margin: 10px 6px 10px 0px;"><br></p>
            <p class="head1">Найдена информация на транспортное средство</p><br>
        </td></tr></tbody></table>
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

		
<?php 
//autocheck
if ($data1->VIN): ?>
		
        <table style="width:100%;"><tbody><tr><td>
            <p><br><img src="/images/autocheck.gif" alt="autocheck" style="float: left; margin: 10px 6px 10px 0px;"><br></p>
            <p class="head1">Найдена информация на транспортное средство</p><br>
        </td></tr></tbody></table>
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
	
    <?php if (empty($data->VIN) && empty($data1->VIN)): ?>
        <p style="color: #cd2626;">&nbsp;&nbsp;К сожалению, транспортное средство с данным VIN кодом не найдено в базах CARFAX, AutoCheck.
       <br />&nbsp;&nbsp;Попробуйте проверить введенную Вами информацию.</p>
   
	<?php else: ?>	
<!--h2 style="text-align:center">Продукты и способы оплаты</h2-->

   <?php endif; ?>
	
	
<?php endif; ?>
	
	
		