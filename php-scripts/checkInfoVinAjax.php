<?php

function check($function, $VIN){

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

//----------------------primim info despre toate,salvam in var, apoi inkidem load si afisam-------------------
if(isset($_POST['vin'])) {
ini_set("display_errors", 1);
    $checkDamagesForVin = json_decode(check("checkDamagesForVin", $_POST['vin']),true);

    $checkVinHistory = json_decode(check("checkVinHistory", $_POST['vin']), true);

    $checkVinDecoder = json_decode(check("checkVinDecoder", $_POST['vin']), true);

    $checkDataForVinNl = json_decode(check("checkDataForVinNl", $_POST['vin']), true);

    $checkVinPhotos = json_decode(check("checkVinPhotos", $_POST['vin']), true);

    //var_dump($checkVinDecoder['checkVinDecoder']);

    $html = "
<table id='check_vin_table' >
    <tr>
        <td style='text-align: center'><b> Information decoded from VIN</b> </td>
        <td style='text-align: center'> <b>Information about vehicle History</b> </td>
    </tr>
    <tr>";
    if($checkVinDecoder['checkVinDecoder']['status'] == "OK"){
        $html .= "<td style='padding: 10px 0px 10px 0px;text-align: center;'>Information found on the vehicle</td>";
    }else{
        $html .= "<td style='padding: 10px 0px 10px 0px;text-align: center;'>Information not found on the vehicle</td>";
    }

    if($checkVinHistory['checkVinHistory']['status'] == "OK"){
        $html .= "<td style='padding: 10px 0px 10px 0px;text-align: center;'>Information found on the vehicle</td>";
    }else{
        $html .= "<td style='padding: 10px 0px 10px 0px;text-align: center;'>Information not found on the vehicle</td>";
    }
$html .= "</tr>";
    if($checkVinDecoder['checkVinDecoder']['status'] == "OK"){
        $checkVinDecoder['disabled'] = "";
        $checkVinDecoder['checked'] = "checked";
        $checkVinDecoder['amount'] = 2;
        $html .= "<tr>
                    <td>
                        <table class='res'>
                            <tr>
                                <td>Model year</td>
                                <td>".$checkVinDecoder['checkVinDecoder']['data']['model_year']."</td>
                            </tr>
                            <tr>
                                <td>Make</td>
                                <td>".$checkVinDecoder['checkVinDecoder']['data']['make']."</td>
                            </tr>
                            <tr>
                                <td>Model</td>
                                <td>".$checkVinDecoder['checkVinDecoder']['data']['model']."</td>
                            </tr>
                            <tr>
                                <td>Bodystyle</td>
                                <td>".$checkVinDecoder['checkVinDecoder']['data']['bodystyle']."</td>
                            </tr>
                            <tr>
                                <td>Number of doors</td>
                                <td>".$checkVinDecoder['checkVinDecoder']['data']['number_of_doors']."</td>
                            </tr>
                            <tr>
                                <td>Seats</td>
                                <td>".$checkVinDecoder['checkVinDecoder']['data']['seats']."</td>
                            </tr>
                            <tr>
                                <td>Vehicle class</td>
                                <td>".$checkVinDecoder['checkVinDecoder']['data']['vehicle_class']."</td>
                            </tr>
                            <tr>
                                <td>Vehicle type</td>
                                <td>".$checkVinDecoder['checkVinDecoder']['data']['vehicle_type']."</td>
                            </tr>
                            <tr>
                                <td>Assembly plant</td>
                                <td>".$checkVinDecoder['checkVinDecoder']['data']['assembly_plant']."</td>
                            </tr>
                            <tr><td colspan='2' style='text-align:center;'>Manufacturer</td></tr>
                            <tr>
                                <td>Count</td>
                                <td>".$checkVinDecoder['checkVinDecoder']['manufacturer']['count']."</td>
                            </tr>
                            <tr>
                                <td>Date from</td>
                                <td>".$checkVinDecoder['checkVinDecoder']['manufacturer']['date_from']."</td>
                            </tr>
                            <tr>
                                <td>Date to</td>
                                <td>".$checkVinDecoder['checkVinDecoder']['manufacturer']['date_to']."</td>
                            </tr>
                        </table>
                    </td>
                  </tr>";
    }else{
        $checkVinDecoder['disabled'] = "disabled";
        $checkVinDecoder['checked'] = "";
        $checkVinDecoder['amount'] = 0;
        $html .= "<tr><td></td></tr>";
    }

    if($checkVinHistory['checkVinHistory']['status'] == "OK"){
        $checkVinHistory['disabled'] = "";
        $checkVinHistory['checked'] = "checked";
        $checkVinHistory['amount'] = 2.50;
        $html .= "<tr>
                    <td>
                        <table class='res'>
                            <tr>
                                <td colspan='2'>Internet</td>
                            </tr>
                            <tr>
                                <td> Count </td>
                                <td>".$checkVinHistory['checkVinHistory']['internet']['count']."</td>
                            </tr>
                            <tr>
                                <td> Date from</td>
                                <td>".$checkVinHistory['checkVinHistory']['internet']['date_from']."</td>
                            </tr>
                            <tr>
                                <td> Date to </td>
                                <td>".$checkVinHistory['checkVinHistory']['internet']['date_to']."</td>
                            </tr>
                            <tr>
                                <td> Odometer Count </td>
                                <td>".$checkVinHistory['checkVinHistory']['internet']['odometer_count']."</td>
                            </tr>
                            <tr>
                                <td> Odometer date from </td>
                                <td>".$checkVinHistory['checkVinHistory']['internet']['odometer_date_from']."</td>
                            </tr>
                            <tr>
                                <td> Odometer date to </td>
                                <td>".$checkVinHistory['checkVinHistory']['internet']['odometer_date_to']."</td>
                            </tr>
                            <tr>
                                <td> All count </td>
                                <td>".$checkVinHistory['checkVinHistory']['internet']['all_count']."</td>
                            </tr>
                            <tr>
                                <td> All date from </td>
                                <td>".$checkVinHistory['checkVinHistory']['internet']['all_date_from']."</td>
                            </tr>
                            <tr>
                                <td> All date to </td>
                                <td>".$checkVinHistory['checkVinHistory']['internet']['all_date_to']."</td>
                            </tr>
                            <tr>
                                <td colspan='2'> Inspections </td>
                            </tr>
                            <tr>
                                <td> Count </td>
                                <td>".$checkVinHistory['checkVinHistory']['inspections']['count']."</td>
                            </tr>
                            <tr>
                                <td> Date from </td>
                                <td>".$checkVinHistory['checkVinHistory']['inspections']['date_from']."</td>
                            </tr>
                            <tr>
                                <td>Date to</td>
                                <td>".$checkVinHistory['checkVinHistory']['inspections']['date_to']."</td>
                            </tr>
                        </table>
                    </td>
                  </tr>";
    }else{
        $checkVinHistory['disabled'] = "disabled";
        $checkVinHistory['checked'] = "";
        $checkVinHistory['amount'] = 0;
        $html .= "<tr><td></td></tr>";
    }

    $html .= "<tr>
        <td style='text-align: center'> <br><b>Information about vehicle Damages</b> </td>
        <td style='text-align: center'> <br><b>Vehicle photos</b> </td>
    </tr>
    <tr>";
    if($checkDamagesForVin['checkDamagesForVin']['status'] == "OK"){
        $html .= "<td style='padding: 10px 0px 10px 0px;text-align: center;'>Information found on the vehicle</td>";
    }else{
        $html .= "<td style='padding: 10px 0px 10px 0px;text-align: center'>Information not found on the vehicle</td>";
    }

    if($checkVinPhotos['checkVinPhotos']['status'] == "OK"){
        $html .= "<td style='padding: 10px 0px 10px 0px;text-align: center;'>Information found on the vehicle</td>";
    }else{
        $html .= "<td style='padding: 10px 0px 10px 0px;text-align: center;'>Information not found on the vehicle</td>";
    }
    $html .= "</tr>";

    if($checkDamagesForVin['checkDamagesForVin']['status'] == "OK"){
        $checkDamagesForVin['disabled'] = "";
        $checkDamagesForVin['checked'] = "checked";
        $checkDamagesForVin['amount'] = 9;
        $html .= "<tr>
                    <td>
                        <table class='res'>
                            <tr>
                                <td>Count</td>
                                <td>".$checkDamagesForVin['checkDamagesForVin']['count']."</td>
                            </tr>
                            <tr>
                                <td>Date from</td>
                                <td>".$checkDamagesForVin['checkDamagesForVin']['date_from']."</td>
                            </tr>
                            <tr>
                                <td>Date to</td>
                                <td>".$checkDamagesForVin['checkDamagesForVin']['date_to']."</td>
                            </tr>
                        </table>
                    </td>
                  </tr>";
    }else{
        $checkDamagesForVin['disabled'] = "disabled";
        $checkDamagesForVin['checked'] = "";
        $checkDamagesForVin['amount'] = 0;
        $html .= "<tr><td></td></tr>";
    }

    if($checkVinPhotos['checkVinPhotos']['status'] == "OK"){
        $checkVinPhotos['disabled'] = "";
        $checkVinPhotos['checked'] = "checked";
        $checkVinPhotos['amount'] = 3;
        $html .= "<tr>
                    <td>
                        <table class='res'>
                            <tr>
                                <td> Count </td>
                                <td>".$checkVinPhotos['checkVinPhotos']['count']."</td>
                            </tr>
                            <tr>
                                <td> Date from</td>
                                <td>".$checkVinPhotos['checkVinPhotos']['date_from']."</td>
                            </tr>
                            <tr>
                                <td> Date to </td>
                                <td>".$checkVinPhotos['checkVinPhotos']['date_to']."</td>
                            </tr>
                            <tr>
                                <td> Sources </td>
                                <td>".$checkVinPhotos['checkVinPhotos']['sources']."</td>
                            </tr>
                        </table>
                    </td>
                  </tr>";
    }else{
        $checkVinPhotos['disabled'] = "disabled";
        $checkVinPhotos['checked'] = "";
        $checkVinPhotos['amount'] = 0;
        $html .= "<tr><td></td></tr>";
    }
//-----------------------------checkDataForVinNl----------------------------------------------
    $html .= "<tr>
        <td style='text-align: center'> <br><b>Information about vehicles from Netherlands</b> </td>
        <td style='text-align: center'>  </td>
    </tr>
    <tr>";
    if($checkDataForVinNl['checkDataForVinNl']['status'] == "OK"){
        $html .= "<td style='padding: 10px 0px 10px 0px;text-align: center;'>Information found on the vehicle</td>";
    }else{
        $html .= "<td style='padding: 10px 0px 10px 0px;text-align: center'>Information not found on the vehicle</td>";
    }

    $html .= "</tr>";

    if($checkDataForVinNl['checkDataForVinNl']['status'] == "OK"){
        $checkDataForVinNl['disabled'] = "";
        $checkDataForVinNl['checked'] = "checked";
        $checkDataForVinNl['amount'] = 4.90;
        $html .= "<tr>
                    <td>
                        <table class='res'>
                            <tr>
                                <td>Information status</td>
                                <td>".$checkDataForVinNl['checkDataForVinNl']['status']."</td>
                            </tr>
                        </table>
                    </td>
                    <td></td>
                  </tr>";
    }else{
        $checkDataForVinNl['disabled'] = "disabled";
        $checkDataForVinNl['checked'] = "";
        $checkDataForVinNl['amount'] = 0;
        $html .= "<tr><td></td><td></td></tr>";
    }

    $html .="</table>";

    $totalAmount = $checkDamagesForVin['amount'] + $checkVinDecoder['amount'] + $checkDataForVinNl['amount'] + $checkVinPhotos['amount'] + $checkVinHistory['amount'];
    $html .= "<form method='post' style='margin: 0px auto;width: 400px;'>
                <table id='form_table_pay'>
                <tr>
                    <td>Email</td>
                    <td><input type='text' name='email'></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Amount</td>
                    <td id='checkboxes'>
                        <input onclick='calcAmount(this);' type='checkbox' name='checkDataForVinNl' id='checkDataForVinNl' value='4.90' ".$checkDataForVinNl['disabled']." ".$checkDataForVinNl['checked'].">
                        <label for='checkDataForVinNl'> 4.90 euro - checkDataForVinNl</label><br>
                        <input onclick='calcAmount(this);' type='checkbox' name='checkDamagesForVin' id='checkDamagesForVin' value='9' ".$checkDamagesForVin['disabled']." ".$checkDamagesForVin['checked'].">
                        <label for='checkDamagesForVin'> 9 euro - checkDamagesForVin</label><br>
                        <input onclick='calcAmount(this);' type='checkbox' name='checkVinPhotos' id='checkVinPhotos' value='3' ".$checkVinPhotos['disabled']." ".$checkVinPhotos['checked'].">
                        <label for='checkVinPhotos'> 3 euro - checkVinPhotos</label><br>
                        <input onclick='calcAmount(this);' type='checkbox' name='checkVinDecoder' id='checkVinDecoder' value='2' ".$checkVinDecoder['disabled']." ".$checkVinDecoder['checked'].">
                        <label for='checkVinDecoder'> 2 euro - checkVinDecoder</label><br>
                        <input onclick='calcAmount(this);' type='checkbox' name='checkVinHistory' id='checkVinHistory' value='2.50' ".$checkVinHistory['disabled']." ".$checkVinHistory['checked'].">
                        <label for='checkVinHistory'> 2.50 euro - checkVinHistory</label><br>
                        <input id='totalAmount' type='hidden' name='amount' value='".$totalAmount."'>
                        <input type='hidden' name='vinToOrderID' value='".$_POST['vin']."'>
                        <input type='hidden' name='functionsPayed' value=''>
                    </td>
                    <td> Total: <span id='amount'>".$totalAmount." euro</span></td>
                </tr>
                <tr>
                    <td>Method pay</td>
                    <td>
                        <select name='pay_method' style='width: 172px'>
                            <option value='bpay'>Bpay</option>
                            <option value='card'>Mastercard / Visa</option>
                            <option value='yamoney'>Yandex</option>
                            <option value='w1'>WalletOne</option>
                            <option value='webmoneycat'>WebMoney</option>
                        </select>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan='2' style='text-align: center'> <input type='submit' name='pay' value='Pay'> </td>
                </tr>

                </table>
              </form>";

    echo $html;
}else{
    echo "No VIN";
}

?>