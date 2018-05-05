<?php
    require_once __DIR__ . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPStreamConnection;
    use PhpAmqpLib\Message\AMQPMessage;

    define("HOST", "203.250.32.180");
    define("PORT", 5672);
    define("USER", "manager");
    define("PASS", "manager");

    $db_host = "localhost";
    $db_user = "root";
    $db_passwd = "619412";
    $db_name = "water_middle_server";

    $conn = mysqli_connect($db_host, $db_user, $db_passwd, $db_name) or die("Connected Failed!!!!");

    $query = "SELECT * FROM Sys_info";
    while( $row = mysqli_fetch_array($query, MYSQLI_NUM) ) { //MYSQPLI_BOTH
        $user_code = $row['USER_CODE'];
        echo '$user_code';
    }

    $connection = new AMQPStreamConnection(HOST, PORT, USER, PASS);

    $channel = $connection->channel();

    $id = 0; //user_code 로 변경해야 함..

    $temp = ['id'=> $id, 'temp'=> $_GET['data']]; //get
    $data = json_encode($temp);

    $msg = new AMQPMessage( $data, [
            'content_type' => 'application/json',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_NON_PERSISTENT
    ]);

    $channel->basic_publish( $msg, 'amq.direct', 'foo.bar');

    $channel->close();
    $connection->close();

    echo 'OK';
?>
