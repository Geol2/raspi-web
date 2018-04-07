<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width">
        <title>send</title>
    </head>

    <body>
        <?php
            try{
                $param1 = $_POST['param1'];

                if(!$param1) {
                    throw new exception("No value param1.");
                }

                $result['success'] = true;

            } catch(exception $e) {

                $result['success'] = false;
                $result['msg'] = $e->getMessage();
                $result['code'] = $e->getCode();

            } finally {

                echo json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

            }
        ?>
    </body>
</html>
