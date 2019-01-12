<?php
    // 포워딩 페이지 작성. 전달 받은 제어코드 값을 수경재배기 장비에게 전달해주는 역할 수행
    // 웹서버에서 버튼을 누르면 라즈베리가 받아서 유저코드의 값을 통하여 아두이노 장비로 ip주소와 cmd 값을 넘겨줘야 한다.

    require_once __DIR__ .'/path_ip_class.php';

    $ip_url_settings = Settings::getInstance('php.ini');
    $ip_setting = $ip_url_settings->ip; //CORS 를 위한 ip

    header('Access-Control-Allow-Origin: '.$ip_setting.'');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
    header('Content-Type: application/json');

    $db_host = "localhost";
    $db_user = "root";
    $db_passwd = "619412";
    $db_name = "water_middle_server";

    $conn = mysqli_connect($db_host, $db_user, $db_passwd, $db_name) or die("Connected Database Failed!!!!");
    
    //Get JSON as a string..
    $json_str = file_get_contents("php://input");

    // Get as an object..
    $json_obj = json_decode($json_str);

    $cmd = $json_obj->{"cmd"};
    $dest = $json_obj->{"dest"};
    $ap_code = $json_obj->{"apCode"}; //명시적으로 줄거라서 일단 주석 침. cmd, dest도 마찬가지

    $cmd_string = "?cmd=";

    $query = "SELECT AP_CODE FROM SYS_INFO WHERE AP_CODE = '$ap_code'"; //Sys_info 테이블의 USER_CODE와 $user_code를 비교하여 맞는 USER_CODE를 받는 쿼리문.
    $result_query = mysqli_query($conn, $query) or die ("Error Database connect!!");

    while ($data = mysqli_fetch_array($result_query)) {

        $ap_code_data = $data['AP_CODE']; //user_code 값을 변수에 저장.

        if ($ap_code == $ap_code_data) { //데이터베이스의 유저코드와 서버에서 받아온 유저코드가 같으면
        
            $query_string_data = $dest."".$cmd_string."".$cmd; // 쿼리스트링을 전송하기 위한 변수를 만듬.

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $query_string_data); //접속할 url 주소와 제어 변수.
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 요청 실행. 결과값을 받을 것인가?
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // 타임아웃 설정. 최대 초 설정.
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //get 방식을 이용한다. //인증서 체크.

            $response = curl_exec($ch);

            $json_data = ['result' => $response];
            curl_close($ch);

            echo json_encode($json_data);
        } else {
            echo "Compare DB value, json_obj fail";
        }
    }
?>
