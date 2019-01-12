<?php
//미들서버 등록 코드 파일.

    require_once __DIR__ . '/path_ip_class.php';

    $ip_url_settings = Settings::getInstance('php.ini');
    $ip_setting = $ip_url_settings->ip;

    //if($ip_setting == $_SERVER['REMOTE_ADDR']) {

        header("Access-Control-Allow-Origin: *"); //CORS 에러 잡기.
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header("Content-Type: application/json");

        $db_host = "localhost";
        $db_user = "root";
        $db_passwd = "619412";
        $db_name = "water_middle_server";
        $conn = mysqli_connect($db_host, $db_user, $db_passwd, $db_name) or die("Connected Failed!!!!");
        # Get JSON as a string
        $json_str = file_get_contents('php://input');
        # Get as an object
        $json_obj = json_decode($json_str);
        $ap_code = $json_obj->{"ap_code"};
        $public_ip = $json_obj->{"public_ip"};
        $query = "INSERT INTO SYS_INFO (AP_CODE, PUBLIC_IP ) VALUES ( $ap_code, '$public_ip')";
        $result = mysqli_query($conn, $query) or die ('Error database.');
        $key = ['result' => 'OK'];
        echo json_encode($key);
        //Sys_info 의 user_code와 ouer_ip를 받아서 DB에 저장.
        mysqli_close($conn);
    //}
    //else {
    //    echo "<script>location.replace('/error.php');</script>";
    //    exit();
    //}
?>


