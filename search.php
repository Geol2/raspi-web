<?php
	$db_host = "localhost";
	$db_user = "root";
	$db_passwd = "619412";
	$db_name = "water_middle_server";

	$conn = mysqli_connect($db_host, $db_user, $db_passwd, $db_name) or die("Connected Failed!!!!");

	$return_arr = array();

	$query = "SELECT INNER_IP FROM product_info ";
	$result = mysqli_query($conn, $query) or die ('Error Querying database.');

	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$row_array['INNER_IP'] = $row['INNER_IP'];

		array_push($return_arr, $row_array);
	}
	?>


<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
	header('Content-Type: application/json');

	//$str1 = file_get_contents('/var/www/html/user_code.json');

	//$json = json_decode($str1, true);

	$query_user = "SELECT COUNT(*) FROM Sys_info ";
	$result = mysqli_query($conn, $query_user) or die ('Error Query_user Databases.');

	echo '$result';
	
	$res = 'OK';
	if( $result == 0){
		 $res = 'FAIL';
	}
	$data = ['state'=> $res ,'ssid' => 'pi3-ap' ,'inner_ip' => $return_arr ];
	echo json_encode($data);

	mysqli_close($conn);
?>
