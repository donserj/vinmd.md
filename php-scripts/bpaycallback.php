<?php
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
?>