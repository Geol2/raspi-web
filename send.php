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

            try
            {
                $param1 = $_POST['param1'];

                if(!$param1) {
                    throw new exception("No value param1.");
                }

                $result['success'] = true;
            }
            catch(exception $e)
            {

                  $result['success'] = false;
                  $result['msg'] = $e->getMessage();
                  $result['code'] = $e->getCode();

           }
           finally
           {

                echo json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

                $connection = new AMQPStreamConnection('203.250.32.181', 5672, 'guest', 'guest');
                if(!$connection)
                    echo 'No Connect!';
                else
                    echo 'Connect!!';
            }
        ?>
    </body>
</html>
