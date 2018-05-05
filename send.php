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

    $mysqli = mysqli_connect($db_host, $db_user, $db_passwd, $db_name);

    /* check connection */
    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    $query = "SELECT * FROM Sys_info";
    $result = $mysqli->query($query);

    $row = $result->fetch_array(MYSQLI_BOTH);
    printf("%d", $row[0]);

    //ampq
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
