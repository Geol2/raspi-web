
<?php
// 수경재배기로부터 받아온 데이터를 JSON포맷 형태로 가공하여 rabbitMQ로 전송
// AMQP를 이용하여 아두이노에서 받은 데이터를 받아 서버로 전송하는 코드.
// usercode를 전역, 글로벌 변수로 만들어 한 번만 접근할 수 있게 만들어 보자.
// sfCode를 이용하여 날짜, 시간
// 시간 관련되서 1. 날짜, 데이터 같이 보냄. 2.데이는 일단 받아서 내가 날짜데이터를 추가해서 웹서버로 전송.
// sf 8 ~ 20라인 수정 했는데 문제발생 가능성이 보일 수 있음.

    require_once __DIR__ . '/vendor/autoload.php';

    use PhpAmqpLib\Connection\AMQPStreamConnection;
    use PhpAmqpLib\Message\AMQPMessage;

    $query_user = "SELECT * FROM Sys_info"; //echo $query; echo "</br>";
    $result_user = mysqli_query($conn, $query_user) or die ("Error database.. not connect Sys_info table.");
    // true 참 0 이외의 값, false 거짓 0

    $num = mysqli_num_rows($result_user); //echo "$num";
    //Sys_info의 table 행 개수 저장.

    if( $num >= 1) {

        define("HOST", "203.250.32.43"); //수정가능성이 있음.
        define("PORT", 5672);
        define("USER", "manager");
        define("PASS", "manager");

        $db_host = "localhost";
        $db_user = "root";
        $db_passwd = "619412";
        $db_name = "water_middle_server";

        $link = mysqli_connect($db_host, $db_user, $db_passwd, $db_name);

        /* check connection */
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        $query = "SELECT * FROM Sys_info";
        $result = mysqli_query($link, $query) or ("Not select Sys_info Table");

        $row = mysqli_fetch_array($result, MYSQLI_BOTH);

        $user_code = $row['USER_CODE'];

        date_default_timezone_set('Asia/Seoul'); // 분침 -30분 문제..
        $current_time = date("Y-m-d-H-i"); //날짜 시간 추가..

        // ampq //
        $connection = new AMQPStreamConnection(HOST, PORT, USER, PASS);

        $channel = $connection->channel();

        //mysql - ampq
        $id = $user_code; //user_code 로 변경.

        $temp = ['id' => $id, 't' => $_GET['t'], 'h' => $_GET['h'], 'wt' => $_GET['wt'], 'wl' => $_GET['wl'], 'e' => $_GET['e'], 'd' => $current_time, 'ip' => $ip];
        //get arduino data..

        $query_1 = "SELECT sf_code FROM product_info WHERE INNER_IP = '$ip' "; // product_info의 INNER_IP가 $ip인 칼럼의 sf_code를 찾는다.
        $result_1 = mysqli_query($link, $query_1) or die ("Not select sf_code column");

        $data = json_encode($temp);
        echo $data;

        $msg = new AMQPMessage($data, [
            'content_type' => 'application/json',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_NON_PERSISTENT
        ]);

        $channel->basic_publish($msg, 'amq.direct', 'foo.bar');

        $channel->close();
        $connection->close();

        mysqli_free_result($result);
        mysqli_close($link);

        echo 'OK';
    }
    else {
        echo 'dont send';
    }
?>
