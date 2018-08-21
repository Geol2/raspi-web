<?php
    $arr_ip = array_map(function ($n) { return sprintf('192.168.4.%d', $n); }, range(1, 20));

    print_r($arr_ip);

    echo $_SERVER['REMOTE_ADDR'];
?>