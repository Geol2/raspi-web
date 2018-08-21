<?php
    $arr_ip = array_map(function ($n) { return sprintf('192.168.4.%2d', $n); }, range(1, 20));

    print_r($arr_ip);
?>