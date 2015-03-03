<?php

    if(isset($_GET['vin'])) {



        require $_SERVER['DOCUMENT_ROOT'] . '/configuration.php';
        $cfg = new JConfig();
        try {
            $db1 = new PDO('mysql:host=localhost;dbname=' . $cfg->db, $cfg->user, $cfg->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $db1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db1->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $db1->exec("set character_set_results='utf8'");

            $today = date("Y-m-d", time());
            $stmt = $db1->prepare("SELECT * FROM `db_orders` WHERE `vin`=:vin AND `date`=:date ORDER BY id DESC");
            $stmt->execute(array(":vin" => $_GET['vin'], ":date" => $today));
            $vinOrder = $stmt->fetch(PDO::FETCH_ASSOC);
            //var_dump($row);

        } catch (PDOException $e) {
            echo "DB error : " . $e->getMessage();
        }
        //$checkVinDecoder = json_decode(getInfoVin("checkVinDecoder", $_GET['vin']), true);
        //var_dump($checkVinDecoder);
        if($vinOrder['payed'] == 1){

            function getInfoVin($function, $VIN){

                $license = "8DT4W-WB7VH-W3TBK-Y7TJ6-PB8YD";
                $apiuid = "VINMDAPI";
                $secretkey = "X4F3W7JKL84RCS8ZX34R65GYMTR43UBF";
                $check_sum = md5($apiuid . $secretkey . $VIN);

                $url = "http://bp.vin-info.com/api2/q/" . $function . "/license:" . $license . "/apiuid:" . $apiuid . "/checksum:" . $check_sum . "/vin:" . $VIN;
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, $url);
                curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
                $res = curl_exec($curl_handle);
                curl_close($curl_handle);

                return $res;
            }
            $VIN = $_GET['vin'];
            $functions = explode(";", $vinOrder['functions']);
            $getDamagesForVin = $getDataForVinNl = $getVinDecoder = $getVinHistory = $getVinPhotos = "";
            foreach($functions as $function){

                if($function == "checkDamagesForVin"){
                    $getDamagesForVin = json_decode(getInfoVin("getDamagesForVin", $VIN), true);

                }elseif($function == "checkDataForVinNl"){

                    $getDataForVinNl = json_decode(getInfoVin("getDataForVinNl", $VIN), true);

                }elseif($function == "checkVinDecoder"){

                    $getVinDecoder = json_decode(getInfoVin("getVinDecoder", $VIN), true);

                }elseif($function == "checkVinHistory"){

                    $getVinHistory = json_decode(getInfoVin("getVinHistory", $VIN), true);

                }elseif($function == "checkVinPhotos"){

                    $getVinPhotos = json_decode(getInfoVin("getVinPhotos", $VIN), true);

                }

            }
            //var_dump($functions);

        }else{
            echo "<p>Get information by vin is not possible , because it is not payed</p>";
        }

    }else{
        echo "Incorrect VIN";
    }



?>