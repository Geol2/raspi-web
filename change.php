<?php
    require_once __DIR__ . '/path_ip_class.php';

    $db_host = "localhost";
    $db_user = "root";
    $db_passwd = "619412";
    $db_name = "water_middle_server";
    $conn = mysqli_connect($db_host, $db_user, $db_passwd, $db_name) or die("Not connect DB");

    $a = $_GET['a'];
    $b = $_GET['b'];
    //a는 바뀐 이후, b는 바뀌기 이전.

    $data_a = json_encode($a);
    $data_b = json_encode($b);

    $ip_url_settings = Settings::getInstance('php.ini');
    $ip_setting = $ip_url_settings->ip;

    $ip_a = '192.168.4.'.$a;
    $ip_b = '192.168.4.'.$b;
    /*
    echo $ip_a; echo ' ';
    echo $ip_b;
    */

    $query_update_dclass = "UPDATE PRODUCT_INFO SET INNER_IP = '$ip_a', SF_CODE = '$a' WHERE INNER_IP = '$ip_b'";
    $result_update_dclass = mysqli_query($conn, $query_update_dclass) or die('Error database Update.');

    $query_apcode = "SELECT AP_CODE FROM SYS_INFO";
    $result_apcode = mysqli_query($conn, $query_apcode) or die('Error database AP_CODE');

    $query_stamp = "SELECT STAMP FROM PRODUCT_INFO WHERE SF_CODE = '$a'";
    $result_stamp = mysqli_query($conn, $query_stamp) or die('Error database STAMP');

    $row_stamp = mysqli_fetch_array($result_stamp, MYSQLI_ASSOC);
    $stamp = $row_stamp['STAMP'];
    //echo $stamp;

    $row_apcode = mysqli_fetch_array($result_apcode, MYSQLI_ASSOC);
    $apcode = $row_apcode['AP_CODE'];
    //echo $apcode;

    $fields = array(
                'after' => $a,
                'befor' => $b,
		'stamp' => $stamp,
		'apCode' => $apcode
    );
    $url = $ip_setting.':9001/device/change';

    $c = curl_init($url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_POST, true);
    curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($fields));

    print curl_exec($c);

    curl_close($c);

    mysqli_close($conn);
?>
