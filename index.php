<?php
    $db_host = "localhost";
    $db_user = "root";
    $db_passwd = "619412";
    $db_name = "water_middle_server";

    $conn = mysqli_connect($db_host, $db_user, $db_passwd, $db_name) or die("Connected Failed!!!!");
?>

<!DOCTYPE html>

<html>
	<head>
		<meta name="viewport" content="width=device-width">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <title>Control</title>

        <script>
            // ajax로 값 전달
            function goActEvent() {
                $.ajax({
                    url				: 'send.php',
                    type			: 'GET',
                    success		: function(result) {

                    }
                });
            }
        </script>

    </head>

	<body>

    <?php

        echo "Hello World!!<br/>";

        $ip=$_GET['ip']; //Query_string
        $site = $_SERVER['DOCUMENT_ROOT']; //index.php road
        $self_ip = $_SERVER['SERVER_ADDR']; //my ip
        $whois_user = $_SERVER['REMOTE_ADDR']; //웹서버의 요청을 보내는 사용자ip
        $using_port = $_SERVER['SERVER_PORT']; //클라이언트 포트

        //$source =$_POST['source'];

        printf("root : %s<br/>", $site);
        printf("ip : %s<br/>",$self_ip);
        printf("user ip : %s<br/>", $whois_user);
        printf("port num : %s<br/>", $using_port);
        printf("query string ip : %s<br/>", $ip);

        if( $ip ){
            echo "get ip<br/>";
            $led = 'N';
            $state = 'N';
            $register = 'N';

            $query = "INSERT INTO product_info  VALUES ('$ip', '$led', '$state', '$register')";
            mysqli_query($conn, $query) or die ('Error database.');

            echo 'Customer added.';

            mysqli_close($conn);
        }
        else {
            echo "false";
        }
/*
        // 아랫줄부터 user_code의 존재여부를 확인 후 POST 방식으로 전송함.
        $query_user_code = "SELECT * FROM Sys_info";
        $result_user = mysqli_query($conn, $query_user_code);
        // true 참 0 이외의 값, false 거짓 0

        $num = mysqli_num_rows($result_user);
        //Sys_info의 table 행 개수 저장.

        if( $num >= 1) {
            //user_code가 존재한다면.
            $exist_query = "SELECT * FROM Sys_info";
            $result = mysqli_query($link, $exist_query);

            $row = mysqli_fetch_array($result, MYSQLI_BOTH);

            $user_code = $row['USER_CODE']; //user_code를 변수에 넣음.
            $sys_info_ip = $row['OUTER_IP']; //user_code의 ip를 변수에 넣음.

            $data = ['apInfo' => $sys_info_ip, 'ipInfo' => $ip, 'userCode' => $user_code];

        }
        else {
            echo "Please user_code input..";
        }
*/
        //chmod("./var/www/html/inner_ip.json", 777);

        //$is_file_exist = file_exists('/var/www/html/inner_ip.json');

        //	$iptables_version = shell_exec("sudo iptables --version");
        //	echo "<pre> $iptables_version </pre>";

        ///	$port_forward = exec("sudo iptables -t nat -A PREROUTING -p tcp -i eth0 --dport 9000 -j DNAT --to 192.168.4.19:80");
        //	echo "<pre> $port_forward </pre>";

        //	$port_save = shell_exec('sudo sh -c "iptables-save > /etc/tables/rules.v4"');
        //	echo "<pre> $port_save</pre>";

        //	$iptables_show = shell_exec("/etc/iptables sudo iptables -L");
        //	echo "<pre>$iptables_show</pre>";

        //	$data = shell_exec("ls");
        //	echo "<pre>$data</pre>";

        //	echo shell_exec("<pre>whoami</pre>");

        //	echo shell_exec("<pre>ls -al</pre>");
    ?>
	</body>
</html>
