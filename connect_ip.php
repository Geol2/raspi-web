<?php
    $arr_ip = array_map(function ($n) {return sprintf('192.168.4.', $n)});

    print_r($arr_ip);
?>