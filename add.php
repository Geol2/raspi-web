
<?php
//Sys_info 를 웹서버에서 수동으로 추가해주는 부분.
//자동으로 추가해주는 부분을 만들어 보자.
//sf_code 추가.

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	header("Content-Type: application/json");

	$db_host = "localhost";
	$db_user = "root";
	$db_passwd = "619412";
	$db_name = "water_middle_server";

	$conn = mysqli_connect($db_host, $db_user, $db_passwd, $db_name) or die("Connected Failed!!!!");
	# Get JSON as a string
	$json_str = file_get_contents('php://input');

	# Get as an object
	$json_obj = json_decode($json_str);

	$user_code = $json_obj->{"user_code"};
	$submit_ip = $json_obj->{"submit_ip"};
    $sf_code = $json_obj->{"sf_code"}; // sf_code를 받아온다.

	$query = "INSERT INTO Sys_info (USER_CODE, OUTER_IP ) VALUES ( $user_code, '$submit_ip')";
	$result = mysqli_query($conn, $query) or die ('Error database.');

	//$sf_key = ['user_code' => $user_code, 'sf_code' => [ 'ip'=> $ip ,'code'=> $code ]];
    //echo json_encode( $sf_code );

    $key = ['result'=>'OK'];
	echo json_encode( $key );
    //Sys_info 의 user_code와 ouer_ip를 받아서 DB에 저장.

    mysqli_close($conn);
?>