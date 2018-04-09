<!DOCTYPE html>
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width">
    <title>send</title>
</head>

<body>
<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
define('HOST','192.168.0.23');
define('PORT',5672);
define('USER','guest');
define('PASS','guest');
//try
//{
//   $param1 = $_POST['param1'];

//    if(!$param1) {
//        throw new exception("No value param1.");
//    }

//    $result['success'] = true;
//}
//catch(exception $e)
//{

//      $result['success'] = false;
//      $result['msg'] = $e->getMessage();
//      $result['code'] = $e->getCode();

//}
//finally
//{

//echo json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

$connection = new AMQPConnection(HOST, PORT, USER, PASS);
$channel = $connection->channel();

$channel->queue_declare('myQueue', false, true, false, false);
$channel->exchange_declare('amq.direct', 'direct', true, true, false);
$channel->queue_bind('myQueue','amq.direct');

$temp = ['id'=>'0', 'temp'=> '10'];
$data = json_encode($temp);

$msg = new AMQPMessage($data, array('content_type' => 'application/json'));
$channel->basic_publish($msg,'amq.direct');

$channel->close();
$connection->close();

//}
?>
</body>
</html>