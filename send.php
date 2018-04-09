<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width">
        <title>send</title>
    </head>

    <body>
        <?php
        require_once __DIR__ . '/library/vendor/autoload.php';
        use PhpAmqpLib\Connection\AMQPStreamConnection;
        use PhpAmqpLib\Message\AMQPMessage;

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

               $connection = new AMQPStreamConnection('192.168.0.23', 5672, 'guest', 'guest');
               $channel = $connection->channel();

               $channel->queue_declare('myQueue', direct, false, false, false);


               $temp = ['id'=>'0', 'temp'=> '10'];
               $data = json_encode($temp);

               $msg = new AMQPMessage($data, array('delivery_mode' => 2));
               $channel->basic_publish($msg, '', 'myQueue');

               $channel->close();
               $connection->close();

            //}
        ?>
    </body>
</html>
