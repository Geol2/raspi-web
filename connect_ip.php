<?php
    $ip_arr = [];

    $ip_d = 1;
    while( $ip_d <= 20 ){
        $ip_arr = $ip_d;
    }

    $json_ip_arr = json_encode($ip_arr);
    echo json_encode($json_ip_arr);
?>