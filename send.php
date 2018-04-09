<?php
    require_once __DIR__ . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPStreamConnection;
    use PhpAmqpLib\Message\AMQPMessage;

    //header('Access-Control-Allow-Origin: *');
    //header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
    //header('Content-Type: application/json');

    define("HOST", "203.250.32.171");
    define("PORT", 5672);
    define("USER", "manager");
    define("PASS", "manager");

    $connection = new AMQPStreamConnection(HOST, PORT, USER, PASS);

    $channel = $connection->channel();


    //$channel->queue_declare('myQueue', false, false, false, false);
    //$channel->exchange_declare('amq.direct', 'direct');

    $id = 0;
    $temp = 10;

    $temp = ['id'=> $id, 'temp'=> $temp];
    $data = json_encode($temp);

    $msg = new AMQPMessage( $data, array( 'content_type' => 'text/json', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_NON_PERSISTENT) );
    $channel->basic_publish( $msg, 'amq.direct', 'foo.bar');

    $channel->close();
    $connection->close();

    echo 'OK';
?>

<!DOCTYPE html>
<html>

    <head>

    </head>

    <body>
        <?php
            static $com = 0;
            $com++;
            echo $com;
        ?>
    </body>
</html>
