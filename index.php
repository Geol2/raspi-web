<?php
// 아두이노에서 오는 IP를 받아서 자동으로 product_info 테이블에 장비를 추가해주는 코드. -->
// userCode를 이용하여 데이터의 내용을 URL(203.250.32.157:9001/device/sf/auto)로 전송해야함 -->
    $db_host = "localhost";
    $db_user = "root";
    $db_passwd = "619412";
    $db_name = "water_middle_server";
    $conn = mysqli_connect($db_host, $db_user, $db_passwd, $db_name) or die("Connected Database Failed!!!!");
?>

<?php
    require_once __DIR__ .'/path_ip_class.php';

    $ip_url_settings = Settings::getInstance('php.ini');
    $ip_setting = $ip_url_settings->ip;

    $ip = $_GET['ip']; //Query_string
    
    echo "QUERY_STRING_IP : ".$ip; echo "</br>";
    if( $ip ){
        $sfCode= explode(".",$ip)[3];//$ip로부터 ip의 D class추출
        $mode = 'Y'; // mode 수동'n' / 자동'y' 모드
        $state = 'N'; // 수경재배기 생육 상태. 'n' : 생육x, 'y':생육o.
        $register = 'N'; // 등록 상태
        date_default_timezone_set('Asia/Seoul');
        $stamp = strtotime('now'); //시간 넣기

        $query = "INSERT INTO PRODUCT_INFO (INNER_IP, MODE, STATE, REGISTER, SF_CODE, STAMP) VALUES ('$ip', '$mode', '$state', '$register', '$sfCode', '$stamp')";
        $result_ip = mysqli_query($conn, $query) or die ('Error database.. not connect product table.');
        echo '  Customer added.'; echo "</br>";

        $query_user = "SELECT * FROM SYS_INFO"; //echo $query; echo "</br>";
        $result_user = mysqli_query($conn, $query_user) or die ("Error database.. not connect Sys_info table.");
        // true 참 0 이외의 값, false 거짓 0
        $num = mysqli_num_rows($result_user); //echo "$num";
        //Sys_info의 table 행 개수 저장.
        if( $num >= 1) {
            $exist_query = "SELECT * FROM SYS_INFO";
            $exist_result = mysqli_query($conn, $exist_query) or die ("Error database.. not connect Sys_info 2 table.");

            $row = mysqli_fetch_array($exist_result, MYSQLI_ASSOC);
            $ap_code = $row['AP_CODE']; //ap_code를 변수에 넣음.

            $stamp_query = "SELECT STAMP FROM PRODUCT_INFO";
            $stamp_result = mysqli_query($conn, $stamp_query) or die ("Error database.. not connect Stamp_query.");

            $fields = array(
                    'sfCode' => $sfCode,
                    'ipInfo' => $ip,
                    'apCode' => $ap_code,
                    'stamp' => $stamp
            );
            $url = $ip_setting.':9001/device/add/sf/auto'; //이것도 변경 가능성이 있음. -> ip세팅 완료.!

            $c = curl_init($url);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true); // 요청 설정을 POST로 한다.
            curl_setopt($c, CURLOPT_POST, true); // 요청을 JSON으로 전달하는 헤더 설정.
            curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); //전송할 데이터를 JSON으로 가공하기.
            curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($fields));

            print curl_exec($c);
            curl_close($c);
        }
        else {
            echo "Please user_code input..";
        }
        mysqli_close($conn);
    }
    else {
        echo "Please get ip...";
    }
?>
