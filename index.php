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
                    url				: './send.php',
                    type			: 'POST',
                    success		: function(result) {

                    }
                });
            }
        </script>

    </head>

	<body>

    <a onclick="goActEvent()">ajax로 값을 send.php로 전달</a>


    <?php

			echo "Hello World!!<br/>";

			$ip=$_GET['ip']; //Query_string
			$site = $_SERVER['DOCUMENT_ROOT']; //index.php road
			$self_ip = $_SERVER['HTTP_X_FORWARD_FOR']; //my ip
			$whois_user = $_SERVER['REMOTE_ADDR']; //웹서버의 요청을 보내는 사용자ip
			$using_port = $_SERVER['SERVER_PORT']; //클라이언트 포트

			//$source =$_POST['source'];

			printf("root : %s<br/>", $site);
			printf("ip : %s<br/>",$self_ip);
			printf("user ip : %s<br/>", $whois_user);
			printf("port num : %s<br/>", $using_port);

			printf("query string ip : %s<br/>", $ip);

			chmod("./var/www/html/inner_ip.json", 777);

			$is_file_exist = file_exists('/var/www/html/inner_ip.json');

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
