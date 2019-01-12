
<?php
// AP의 정보와, 연결된 수경재배기들의 정보들을 JSON포맷으로 제공
// Sys_info의 내용을 조회에서 공유기의 추가중복을 방지하게 하기 위해 만듦.-->

	require_once __DIR__ .'/path_ip_class.php';

	$ip_url_settings = Settings::getInstance('php.ini');
	$ip_setting = $ip_url_settings->ip;

	header("Access-Control-Allow-Origin: '$ip_setting'");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	header("Content-Type: application/json");

	$db_host = "localhost";
	$db_user = "root";
	$db_passwd = "619412";
	$db_name = "water_middle_server";

	$conn = mysqli_connect($db_host, $db_user, $db_passwd, $db_name) or die("Connected Failed!!!!");

	$return_arr = array();

	$query = "SELECT INNER_IP,STAMP FROM PRODUCT_INFO";
	$result = mysqli_query($conn, $query) or die ('Error Querying database.');
	//echo "$result";

	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$row_array['INNER_IP'] = $row['INNER_IP'];
		$row_array['STAMP'] = $row['STAMP'];

		array_push($return_arr, $row_array); //수경재배기들의 정보를 확인함.
	}

	$query_user = "SELECT * FROM SYS_INFO";
	$result_user = mysqli_query($conn, $query_user) or die('Error Queyring database.');
	//true 참 0 이외의 값 , false 거짓 0 //
	$num = mysqli_num_rows($result_user);
	// 테이블 행의 개수.
	$res = 'OK';
	if ($num >= 1) {
		$res = 'FAIL';
		$data = ['state' => $res];
	} else if ($num == 0) {
		$data = ['state' => $res, 'ssid' => 'pi3-ap', 'inner_ip' => $return_arr]; //상태와 ssid, 수경재배기 정보를 저장.
	}
	echo json_encode($data);

	mysqli_close($conn);
?>
