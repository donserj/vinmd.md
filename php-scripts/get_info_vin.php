<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Проверить авто,в молдове,вин-код,vin,проверить vin,фото по vin,код,авто,история автомобиля,база данных,code,расшифровка,кода,авторынок,автоаукционы,отчет сша,пробить,карфакс,авточек,манхейм,
carfax,autocheck,автобазар,информация,америка,USA,машин,бесплатно,copart,vin код,vin код автомобиля" />
    <meta name="description" content="Проверка vin-номера автомобиля. Фотографии и отчёты по VIN-коду. Информация об авто по VIN. " />
    <title>VINmd.com - проверка автомобиля по VIN коду (Europe) </title>
    <link rel="stylesheet" href="/europevin.css" type="text/css" />
    <script src="/media/system/js/jquery-1.6.4.js" type="text/javascript" language="JavaScript"></script>

    <script src="/europevin.js" type="text/javascript" language="JavaScript"></script>
</head>

<body>
<div class="container">
<?php
ini_set("display_errors", 1);
    if(isset($_POST['vin'])){
        $VIN = trim($_POST['vin']);
?>

    <div id="check_vin">
        <div id="check_vin_top">
            Check VIN
        </div>
        <div id="check_vin_bottom">
            <div id="check_vin_photo">

            </div>
            <div id="check_vin_number">
                <?php echo $VIN;?>
            </div>
            <div id="check_vin_loader">
                <img src="/images/ajax-loading-bar.gif">
            </div>
        </div>
    </div>
        <?php
            echo '<script language="JavaScript" type="text/javascript">checkVin("'.$VIN.'");</script>';
        ?>
        <div id="vin_result">

        </div>
<?php



//----------------------------------NO POST------------------------------------------------------
    }elseif(isset($_POST['pay'])){

        ini_set("display_errors",1);
        $functions = "";
        $amount = 0;
        if(isset($_POST['checkDataForVinNl'])){
            $functions .= "checkDataForVinNl;";
            $amount += $_POST['checkDataForVinNl'];
        }
        if(isset($_POST['checkDamagesForVin'])){
            $functions .= "checkDamagesForVin;";
            $amount += $_POST['checkDamagesForVin'];
        }
        if(isset($_POST['checkVinPhotos'])){
            $functions .= "checkVinPhotos;";
            $amount += $_POST['checkVinPhotos'];
        }
        if(isset($_POST['checkVinDecoder'])){
            $functions .= "checkVinDecoder;";
            $amount += $_POST['checkVinDecoder'];
        }
        if(isset($_POST['checkVinHistory'])){
            $functions .= "checkVinHistory;";
            $amount += $_POST['checkVinHistory'];
        }
//var_dump($_SERVER['HTTP_HOST']);
        require  $_SERVER['DOCUMENT_ROOT'].'/configuration.php';
        $cfg = new JConfig();
        try{
            $db1 = new PDO('mysql:host=localhost;dbname='.$cfg->db, $cfg->user, $cfg->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $db1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $db1->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $db1->exec("set character_set_results='utf8'");

            $stmt = $db1->prepare("INSERT INTO db_orders (`vin`, `type`, `date`, `payment`, `functions`)
                                    VALUES(:vin, :type, NOW(), :payment, :functions)");
            $stmt->execute(array(":vin" => $_POST['vinToOrderID'], ":type" => 0, ":payment" => $amount, ":functions" => $functions));
            //$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //var_dump($row);

        }catch (PDOException $e){
            echo "DB error : ".$e->getMessage();
        }
//var_dump($db1);

        $signature="FCFqpcm0JfV"; // подпись, полученная при регистрации мерчанта
        //$amount =  $_POST['amount'];
        $method = $_POST['pay_method'];
        $orderid = $_POST['vinToOrderID'];
        $advanced1 = $_POST['email'];
        $success_url = $_SERVER['HTTP_HOST'].'/php-scripts/success-get-evin.php?vin='.$orderid;
var_dump($success_url);
        // xml данные:
        $xmldata="<payment>
        <type>1.2</type>
        <merchantid>vinmd_com1402402868</merchantid>
        <amount>".$amount."</amount>
        <description>Pay to vinmd.com</description>
        <method>".$method."</method>
        <order_id>".$orderid."</order_id>
        <success_url>".htmlspecialchars($success_url)."</success_url>
        <fail_url>".htmlspecialchars("http://myeshop.com/pay_error.html")."</fail_url>
        <lang>en</lang>
        <advanced1>".$advanced1."</advanced1>
        <advanced2></advanced2>
        </payment>";
        // шифрум данные и подписываем их
        $data = base64_encode($xmldata);
        $sign = md5(md5($xmldata) . md5($signature));

        echo '<form method="POST" action="https://www.bpay.md/user-api/payment1">
            <input type="hidden" name="data" value="'.$data.'">
            <input type="hidden" name="key" value="'.$sign.'">
            <input type="submit" value="Transfer" >
        </form><!--script language="Javascript" type="text/javascript"></script-->';

    }else{
        echo "NO POST";
    }



?>

</div>
</body>
</html>