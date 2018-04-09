<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
define('HOST', '192.168.0.23');
define('PORT', 5672);
define('USER', 'guest');
define('PASS', 'guest');

$connection = new AMQPStreamConnection(HOST, PORT, USER, PASS);
$channel = $connection->channel();

//$channel->queue_declare('myQueue', false, false, false, false);
//$channel->exchange_declare('amq.direct', 'direct');

//$temp = ['id'=>'0', 'temp'=> '10'];
//$data = json_encode($temp);

//$msg = new AMQPMessage($data, array('content_type' => 'application/json'));
//$channel->basic_publish($msg,'amq.direct','foo.bar');

//$channel->close();
//$connection->close();
?>