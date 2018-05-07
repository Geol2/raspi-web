<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
    header('Content-Type: application/json');

    //Get JSON as a string..
    $json_str = file_get_contents("php://input");

    // Get as an object..
    $decoded = json_decode($json_str, true);

    $cmd = $json_obj->{"cmd"};
    $dest = $json_obj->{"dest"};
    //$cmd = $_POST['cmd'];
    //$dest = $_POST['dest'];

    $key = ['cmd' => $cmd, 'dest' => $dest];

    $key1 = ['result'=>'OK'];
    echo json_encode($key1);

    ?>
