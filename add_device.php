<?php
/**
 * Created by PhpStorm.
 * User: big94
 * Date: 2018-08-22
 * Time: 오전 7:29
 */
    require_once __DIR__ .'/config_db.php';
    require_once __DIR__ .'/connect_inner_ip.php';

    $ip = $_SERVER['REMOTE_ADDR'];

    $sfcode= explode(".",$ip)[3];//$ip로부터 ip의 D class추출
    $inner_ip = $ip;
    $mode = 'Y';
    $state = 'N';
    $register = 'N';

    $query_add_device = "INSERT INTO PRODUCT_INFO ( SF_CODE, INNER_IP, MODE, STATE, REGISTER) VALUES ('$sfcode', '$inner_ip', '$mode', '$state', '$register')";
    $result = $conn->query($query_add_device);

    if($result) {
        echo "<script>location.replace('/main.php');</script>";
    }
    else{
        echo "<script>alert('추가할 수 없습니다.');</script>";
        echo "<script>location.replace('/main.php');</script>";
    }
?>