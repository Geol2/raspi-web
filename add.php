
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
	$json_obj = json_decode($json_str, false); //object 로 반환.

    /*
	//명시적인 값들..
    $user_code = "1";
    $submit_ip = "203.250.32.123";

    $ip = "192.168.4.3";
    $code = "0";
    */

    // 실제로 받는 값들..
	$user_code = $json_obj->{"user_code"};
	$submit_ip = $json_obj->{"submit_ip"};
    $sf_code = $json_obj->{"sf_code"};

    $json = array(
        'user_code' => $user_code,
        'submit_ip' => $submit_ip,
        'sf_code' => array (
            'ip' => $ip,
            'code' => $code
        )
    );

    echo json_encode($json);

	$query = "INSERT INTO Sys_info (USER_CODE, OUTER_IP ) VALUES ( $user_code, '$submit_ip')";
	$result = mysqli_query($conn, $query) or die ('Error insert Sys_info table.');

    //echo json_encode($sf_key);// user_code 와 sf_code 안의 ip, code를 받아오는 부분을 출력한다. php의 배열은 동적이라 따로 정해두지 않아도 알아서 출력이 된다고 한다.

    $key = ['result'=>'OK'];
	echo json_encode( $key );
    //Sys_info 의 user_code와 ouer_ip를 받아서 DB에 저장.

    mysqli_close($conn);
?>