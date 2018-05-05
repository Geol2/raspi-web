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

    $link = mysqli_connect($db_host, $db_user, $db_passwd, $db_name);

    /* check connection */
    if ( mysqli_connect_errno() ) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    $query = "SELECT * FROM Sys_info";
    $result = mysqli_query($link, $query);

    $row = mysqli_fetch_array($result, MYSQLI_BOTH);

    $user_code = $row['USER_CODE'];

    printf ("%s \n", $user_code);

    // ampq //
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

    mysqli_free_result($result);

    mysqli_close($link);

    echo 'OK';
?>
