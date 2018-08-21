<?php
/**
 * Created by PhpStorm.
 * User: big94
 * Date: 2018-08-22
 * Time: 오전 7:29
 */
    require_once __DIR__ .'/config_db.php';

    $ip = $_SERVER['REMOTE_ADDR'];

    $sfcode= explode(".",$ip)[3];//$ip로부터 ip의 D class추출

    $inner_ip = $ip;
    $mode = 'Y';
    $state = 'N';
    $register = 'N';

    $query_adddevice = "INSERT INTO PRODUCT_INFO ( SF_CODE, INNER_IP, MODE, STATE, REGISTER) VALUES ('$sf_code', '$inner_ip', '$mode', '$state', '$register')";
    $conn->query($query_adddevice);

    if($conn) {
        echo "ok";
    }
    else{
        echo "false";
    }
?>