<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	header("Content-Type: application/json");

    $db_host = "localhost";
    $db_user = "root";
    $db_passwd = "619412";
    $db_name = "water_middle_server";

    $conn = mysqli_connect($db_host, $db_user, $db_passwd, $db_name) or die("Connected Failed!!!!");

    //if($method == "POST" ){

		//chmod("./var/www/html/user_code.json", 777);

		//$request_body = file_get_contents("php://input");
		//$info = json_decode(stripcslashes($request_body), true);

		//$request_body = $_POST["user_code"];
		//$info = json_decode($request_body, true);


		$user_code = $_POST['user_code'];
		$submit_ip = $_SERVER['SERVER_ADDR'];
		//$submit_ip = $_POST['submit_ip'];

		//echo $submit_ip;
        //echo $user_code;
		//file_put_contents("user_code.json", json_encode(array('user_code' => $user_code), JSON_PRETTY_PRINT) );

        $query = "INSERT INTO Sys_info VALUES ( '$user_code', '$submit_ip' )";
        $result = mysqli_query($conn, $query) or die ('Error database.');

        //$key = ['result'=>'OK'];
		//echo json_encode($key);

		mysqli_close($conn);
	//}

//	if($method == "GET"){

//	chmod("./var/www/html/inner_ip.json", 777);

//	$reauest_body = file_getcontents("php://input");
//	$info = json_decode(stripcslashes($request_body), true);

//	$ip = $_GET['ip'];
//	file_put_contents("inner_ip.json", json_encode(array('ip' => $ip), JSON_PREETY_PRINT) );

//	$key2 = ['result' => 'OK'];
//	echo json_encode($key2);
//	}
?>
