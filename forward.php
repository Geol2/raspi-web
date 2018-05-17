<?php
$db_host = "localhost";
$db_user = "root";
$db_passwd = "619412";
$db_name = "water_middle_server";

$conn = mysqli_connect($db_host, $db_user, $db_passwd, $db_name) or die("Connected Database Failed!!!!");
?>


<?php
// 포워딩 페이지 작성.
// 웹서버에서 버튼을 누르면 라즈베리가 받아서 유저코드의 값을 통하여 아두이노 장비로 ip주소와 cmd 값을 넘겨줘야 한다.

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
    header('Content-Type: application/json');

    //Get JSON as a string..
    $json_str = file_get_contents("php://input");

    // Get as an object..
    $json_obj = json_decode($json_str);

    $cmd = $json_obj -> {"cmd"};
    $dest = $json_obj -> {"dest"};
    $user_code = $json_obj -> {"userCode"};
    //$cmd = $_POST['cmd'];
    //$dest = $_POST['dest'];

    $key = ['cmd' => $cmd, 'dest' => $dest]; // 받아온 cmd, userCode 값을 key에 넣음.
    //echo json_encode($key);

    $query = "SELECT USER_CODE FROM Sys_info WHERE USER_CODE = 0";
    $result = mysqli_query($conn, $query) or die ("Error Database connect!!");

    while($data = mysqli_fetch_assoc($result)){

        print_r($data); // 유져코드 출력 완료. ( 배열로 출력됨. )

        /*
        if( $user_code == $data) {
            echo "success";
        }
        else {
            echo "fail";
        }
        */
    }
    ?>
