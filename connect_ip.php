<?php
    $arr_ip = array_map(function ($n) { return sprintf('192.168.4.%d', $n); }, range(1, 20));

    //print_r($arr_ip);

    if(in_array($_SERVER['REMOTE_ADDR'], $arr_ip)){
        echo "존재합니다.";
    } else {
        echo "존재하지 않습니다.";
    }
    //echo $_SERVER['REMOTE_ADDR'];
?>