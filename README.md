#기본 공유기 접속 루트
```
203.250.35.169/login.php
```

# RaspberryPi 3  B Model AP Mode

reference :
https://www.raspberrypi.org/documentation/configuration/wireless/access-point.md

dnsmasq와 hostapd

```dnsmasq``` : 1000클라이언트 이하의 로컬 네트워크에서 활용할 수 있는 간단한 DHCP/DNS 서버.


```DHCP```는 컴퓨터 사고 랜선 꼽으면 그냥 아무 설정 안했는데 자동으로 그냥 인터넷 연결도 되고 편하게 사용할 수 있다.
그렇게 해주는 설정이 바로 DHCP설정이라고 한다.



DHCP를 통한 IP주소 할당은 흔히 '임대'라는 개념을 가지고 있어서 IP주소를 임대기간을 명시하여 그 기간 동안에만 단말이
IP주소를 사용할수 있다고 하고 더 사용하고자 하면 기간연장을 서버에 요청하고 필요없으면 반납절차를 수행하게 된다고 한다.

```DNS```는 흔히 naver.com이나 google.co.kr 같은 도메인 네임을 뜻한다.



```
hostapd is a user space daemon for wireless access point and authentication servers. There are three implementations: Jouni Malinen's hostapd, OpenBSD's hostapd and Devicescape's hostapd.


Contents  [hide] 
```

AP와 인증 서버를 위한 사용자 공간 데몬이라고 한다. 데몬은 흔히 백그라운도 프로세스라고 불린다.

그냥 무선 네트워크 인터페이스는 AP모드로 전환하여 서비스를 하게 해주는 패키지라고 생각하면 될 것 같다.

라즈베리파이는 독립형 와이파이 ap로 사용할 수 있다. 

라즈베리파이 3, 제로W 에 무선요소가 내장되었거나 AP를 지원하는 USB 동글이 탑제된 라즈베리도 가능하다.

라즈베리3 장비에서 테스트를 한 문서이고 USB동글을 이용하게 된다면 조금 설정을 바꿔야 하는 부분이 필요하다.

만약 USB 무선동글을 이용하여 문제가 발생이되면, 동글의 상태를 체크하길 바란다.

추가적으로 라즈베리파이 기본 AP의 네트워크 설정에 관한 정보는 이 섹션을 참고한다.

```
sudo apt-get update  
sudo apt-get upgrade

sudo apt-get install dnsmasq hostapd
```

```
sudo systemctl stop dnsmasq  
sudo systemctl stop hostapd
```

# Configuring a static IP - 고정 IP 설정.

라즈베리파이는 무선포트 연결을 위해 고정 아이피 필요하다.

192.168.x.x의 주소를 무선 네트워크 주소를 사용한다.

라즈베리파이 주소는 192.168.4.1이고 wlan0이라는 이름을 사용한다.

고정 IP주소를 사용하고 dhcp 설정 파일을 편집을 한다.

```
sudo nano /etc/dhcpcd.conf
```

다음으로 파일의 마지막 줄에 아래의 글을 추가로 적고 저장 후 종료한다.

```
interface wlan0
    static ip_address=192.168.4.1/24
```

그리고 dhcp 데몬을 재시작하고 새로운 wlan0설정이 되었는지 확인한다.

```
sudo systemctl restart dhcpcd
```
#Configuring the DHCP server (dnsmasq)
 
DHCP 서비스는 dnsmasq로부터 제공된다.

결과적으로 설정파일은 많은 정보가 필요하지는 않고 쉬운 편이다.

설정 파일을 이름을 재설정 하고, 새로운 것을 하나 만든다.

```
sudo mv /etc/dnsmasq.conf /etc/dnsmasq.conf.orig 
```
```
sudo nano /etc/dnsmasq.conf
```

Type or copy the following information into the dnsmasq configuration file and save it:
dnsmasq 설정파일에서 다음과 같은 타입과 정보들을 저장한다.

```
interface=wlan0      # Use the require wireless interface - usually wlan0
  
dhcp-range=192.168.4.2,192.168.4.20,255.255.255.0,24h
```

wlan0을 따라, 192.168.4.2에서 192.168.4.20 사이의 IP주소들을 제공할 것이고 24시간동안 제공할 것이다.
만약 DHCP 서비스를 다른 네트워크 장비들에게 제공하고 싶다면, 섹션을 추가하고 주소의 범위와 함께 인터페이스 설정을 만들어주면 된다.
dnsmasq의 많은 옵션이 있고, 더 자세한 사항은 dnsmasq 문서를 참고하면 된다.

hostapd의 설정을 한다.
hostapd 설정 파일을 편집하는 것이 필요한데, 해당 파일의 위치는 /etc/hostad/hostapd.conf에 존재하며 무선 네트워크 파라미터들을 추가한다.
인스톨 후 새로운 빈 파일을 생성한다.

```
sudo nano /etc/hostapd/hostapd.conf
```

설정 파일의 정보를 추가한다.
이 설정은 7 채널을 사용하였으며 네트워크 이름과 패스워드는 임의로 설정해주면 된다.
이름과 패스워드를 노트해둔다.

```
interface=wlan0
driver=nl80211
ssid=NameOfNetwork
hw_mode=g
channel=7
wmm_enabled=0
macaddr_acl=0
auth_algs=1
ignore_broadcast_ssid=0
wpa=2
wpa_passphrase=AardvarkBadgerHedgehog
wpa_key_mgmt=WPA-PSK
wpa_pairwise=TKIP
rsn_pairwise=CCMP
```

우리는 설정파일을 찾아 설정해주고 시스템에 알려줄 필요가 있다.

```
sudo nano /etc/default/hostapd
```

Find the line with #DAEMON_CONF, and replace it with this:

```
DAEMON_CONF="/etc/hostapd/hostapd.conf"
```

서비스를 재시작 해준다.

```
sudo systemctl start hostapd

sudo systemctl start dnsmasq
```

추가적으로 라우팅과 마스크레이드 설정을 한다.

Edit ```/etc/sysctl.conf``` and uncomment this line:

```
net.ipv4.ip_forward=1
```

Add a masquerade for outbound traffic on eth0:

```
sudo iptables -t nat -A  POSTROUTING -o eth0 -j MASQUERADE
```

Save the iptables rule.

```
sudo sh -c "iptables-save > /etc/iptables.ipv4.nat"
```

Edit ```/etc/rc.local ```and add this just above "exit 0" to install these rules on boot.

```
iptables-restore < /etc/iptables.ipv4.nat
```

```
Reboot
```

이 부분에서 Reboot 후 무선장치에 SSID가 검색이 된다고 나와 있지만 전혀 나타나지 않았다.

```
sudo hostapd /etc/hostapd/hostapd.conf
```

```
sudo hostapd /etc/hostapd/hostapd.conf
```
하면 AP모드가 작동하지 않고 ERROR가 발생하게 되었다.

에러는 ```Line2 : invalid/unknown driver 'nl80211'```

라이브러리가 필요하다고 하니까 이것도 설치를 한다.


```
sudo apt-get install libssl-dev
```

nl80211 이라는 것을 아예 못찾는 것 같으니까 다운로드부터 받도록 한다.

```
git clone git://w1.fi/srv/git/hostap.git

cd hostap/hostapd
```

Or you can get a stable release (0.6.8 or later recommended)  
  by downloading the tarball from http://w1.fi/hostapd/ as follows:

http://w1.fi/hostapd/ 이 링크에 들어가면 2018.02.21. 기준으로  
가장 최근버젼인 2.6 버젼을 다운로드 받도록 한다.

```
wget http://w1.fi/releases/hostapd-x.y.z.tar.gz
tar xzvf hostapd-x.y.z.tar.gz
cd hostapd-x.y.z/hostapd
```

여기서 x.y.z.는 버젼이다. 나는 ~ hostapd-2.6.tar.gz 라고 해주었다. 상황에 따라 맞게 타이핑 쳐주자.

```
cp defconfig .config
```

```
nano .config
```

.config 파일로 들어가서 찾아준다.

```
/#CONFIG_DRIVER_NL80211=y
```

/#부분을 없앤다. 최근버젼인 2.6버젼에는 애초에 #이 없었다.  
/는 깃허브에 올릴려고 추가적으로 붙인 것이니 원래 없는 부분... 신경쓰지 말자!!

Next, compile hostapd:

```
make
```

컴파일을 해준다. 여기서 분명 안되는 것 처럼?? 나오는 걸로 알고있다. 

```../src/drivers/driver_nl080211.c:17:31: fatal error~~ ```에러가 뜨는데 딱히 신경 쓰지말자..

여기서 이제

```
sudo apt-get hostapd hostapd/hostapd.conf
```

```
sudo /usr/sbin/hostapd /etc/hostapd/hostapd.conf
```
완료되었다.

무선장치를 통하여 해당 SSID가 잘 검색이 되면서 작동하는지 확인한다.

----------------------------
![archi](https://user-images.githubusercontent.com/20119461/51072154-64e74500-169f-11e9-8ed7-ee398543d1f6.PNG)
![default](https://user-images.githubusercontent.com/20119461/51072868-ae3d9180-16ab-11e9-83bc-faed4fefbd41.png)

----------------------------

# search.php
```
역할 : 미들서버 조회 시 수행되는 관련 코드파일.
내용 : 등록된 공유기가 있는지 없는지를 판단 여부를 API로 응답하는 코드.

$query = "SELECT INNER_IP,STAMP FROM PRODUCT_INFO";
	$result = mysqli_query($conn, $query) or die ('Error Querying database.');
	//echo "$result";

	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$row_array['INNER_IP'] = $row['INNER_IP'];
		$row_array['STAMP'] = $row['STAMP'];

		array_push($return_arr, $row_array);
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
		$data = ['state' => $res, 'ssid' => 'pi3-ap', 'inner_ip' => $return_arr];
	}
	echo json_encode($data);

	mysqli_close($conn);
```
![search flow](https://user-images.githubusercontent.com/20119461/51075010-50b83d80-16c9-11e9-99f7-28f839bd9c0c.png)

# add.php
```
역할 : 미들서버 등록 코드 파일.
내용 : search.php에 의해 등록되어있지 않은 미들서버라면 등록되고 등록된 미들서버라면 등록되지 않는다.

$conn = mysqli_connect($db_host, $db_user, $db_passwd, $db_name) or die("Connected Failed!!!!");
  # Get JSON as a string
  $json_str = file_get_contents('php://input');
  # Get as an object
  $json_obj = json_decode($json_str);
  $ap_code = $json_obj->{"ap_code"};
  $public_ip = $json_obj->{"public_ip"};

  $query = "INSERT INTO SYS_INFO (AP_CODE, PUBLIC_IP ) VALUES ( $ap_code, '$public_ip')";
  $result = mysqli_query($conn, $query) or die ('Error database.');
  $key = ['result' => 'OK'];
  echo json_encode($key);

```
![add flow 2](https://user-images.githubusercontent.com/20119461/51074913-3893ee80-16c8-11e9-842c-64329f2c9e6b.png)
![add flow](https://user-images.githubusercontent.com/20119461/51075021-6ded0c00-16c9-11e9-9c75-6e77d5a9bdf5.png)

# connect_inner_ip.php
```
역할 : 미들서버에 내부에서의 접속 여부를 판단해주는 관련 코드파일.

$arr_inner_ip = array_map(function ($n) { return sprintf('192.168.4.%d', $n); }, range($first, $end));
  //print_r($arr_ip);

  if(in_array($_SERVER['REMOTE_ADDR'], $arr_inner_ip)){
      echo "내부 IP로 접속 하였습니다.<br>";
  } else {
      echo "<script> location.replace('/error.php'); </script>";
  }
```
![connect_inner_ip](https://user-images.githubusercontent.com/20119461/51072393-6dda1580-16a3-11e9-8a11-07aa8424bd4b.png)

# forward.php
```
역할 : 재배기에 제어 명령 전송관련 코드파일.
내용 : API 서버로부터 제어명령을 받아 재배기로 전달한 후, 수행 결과를 응답한다.

$json_str = file_get_contents("php://input");

        // Get as an object..
        $json_obj = json_decode($json_str);

        $cmd = $json_obj->{"cmd"};
        $dest = $json_obj->{"dest"};
        $ap_code = $json_obj->{"apCode"}; 

        $cmd_string = "?cmd=";

        
        $query = "SELECT AP_CODE FROM SYS_INFO WHERE AP_CODE = '$ap_code'";
        $result_query = mysqli_query($conn, $query) or die ("Error Database connect!!");

        while ($data = mysqli_fetch_array($result_query)) {

            $ap_code_data = $data['AP_CODE']; //user_code 값을 변수에 저장.

            if ($ap_code == $ap_code_data) { //데이터베이스의 유저코드와 서버에서 받아온 유저코드가 같으면

                $ch = curl_init();
		            curl_setopt($ch, CURLOPT_URL, $query_string_data); //접속할 url 주소.

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 요청 실행. 결과값을 받을 것인가?

                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // 타임아웃 설정. 최대 초 설정.

                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //get 방식을 이용한다. //인증서 체크.
                $response = curl_exec($ch);

                $json_data = ['result' => $response];
		            curl_close($ch);

                echo json_encode($json_data);
            }

```

![forward flow](https://user-images.githubusercontent.com/20119461/51073318-59e9e000-16b2-11e9-95ac-5e25d5a5ea68.png)

# index.php
```
역할 : 재배기와 연결 시 수행되는 관련 코드파일.
내용 : 재배기랑 AP최초 연결 시, 재배기의 데이터를 저장하며 등록된 경우 재배기의 정보를 전송.

$ip = $_GET['ip']; //Query_string, 재배기 IP를 받아옴.
    
    echo "QUERY_STRING_IP : ".$ip; echo "</br>";
    if( $ip ){
        $sfCode= explode(".",$ip)[3];//$ip로부터 ip의 D class추출
        $mode = 'Y'; // mode 수동'n' / 자동'y' 모드
        $state = 'N'; // 수경재배기 생육 상태. 'n' : 생육x, 'y':생육o.
        $register = 'N'; //등록 상태
        date_default_timezone_set('Asia/Seoul');
        $stamp = strtotime('now'); //시간 넣기

        $query = "INSERT INTO PRODUCT_INFO (INNER_IP, MODE, STATE, REGISTER, SF_CODE, STAMP) VALUES ('$ip', '$mode', '$state', '$register', '$sfCode', '$stamp')";
        $result_ip = mysqli_query($conn, $query) or die ('Error database.. not connect product table.');
        echo '  Customer added.'; echo "</br>";
        // 아랫줄부터 user_code의 존재여부를 확인 후 POST 방식으로 전송함.
        $query_user = "SELECT * FROM SYS_INFO"; //echo $query; echo "</br>";
        $result_user = mysqli_query($conn, $query_user) or die ("Error database.. not connect Sys_info table.");
        // true 참 0 이외의 값, false 거짓 0
        $num = mysqli_num_rows($result_user); //echo "$num";
        //Sys_info의 table 행 개수 저장.
        if( $num >= 1) {
            $exist_query = "SELECT * FROM SYS_INFO";
            $exist_result = mysqli_query($conn, $exist_query) or die ("Error database.. not connect Sys_info 2 table.");

            $row = mysqli_fetch_array($exist_result, MYSQLI_ASSOC);
            $ap_code = $row['AP_CODE']; //ap_code를 변수에 넣음.

            $stamp_query = "SELECT STAMP FROM PRODUCT_INFO";
            $stamp_result = mysqli_query($conn, $stamp_query) or die ("Error database.. not connect Stamp_query.");

            $fields = array(
                    'sfCode' => $sfCode,
                    'ipInfo' => $ip,
                    'apCode' => $ap_code,
                    'stamp' => $stamp
            );
            $url = $ip_setting.':9001/device/add/sf/auto'; //이것도 변경 가능성이 있음. -> ip세팅 완료.!

            $c = curl_init($url);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true); // 요청 설정을 POST로 한다.
            curl_setopt($c, CURLOPT_POST, true); // 요청을 JSON으로 전달하는 헤더 설정.
            curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); //전송할 데이터를 JSON으로 가공하기.
            curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($fields));

            print curl_exec($c);
            curl_close($c);
```
![index flow](https://user-images.githubusercontent.com/20119461/51075624-5fa2ee00-16d1-11e9-83f7-62d213b5326d.png)

# remove_pro_sys.php
```
역할 : 미들서버 제거 시 수행되는 관련 코드파일.
내용 : 미들서버 제거 요청 받았을 때 수행되는 파일이다. 모든 재배기 정보와 미들서버 정보가 없어진다.

$query_delete_pro = "DELETE FROM PRODUCT_INFO";
        $result = mysqli_query($conn, $query_delete_pro) or die ('Error Querying database.');

        $query_delete_sys = "DELETE FROM SYS_INFO";
        $result1 = mysqli_query($conn, $query_delete_sys) or die ('Error Querying database.');

        $key = ['result' => 'OK'];

        echo json_encode($key);
```
![remove_pro_sys flow](https://user-images.githubusercontent.com/20119461/51075850-8f072a00-16d4-11e9-9249-6d940992752a.png)


# remove_pro.php
```
역할 : 재배기 제거 시 수행되는 관련 코드파일.
내용 : 재배기 제거 요청을 받았을 때 수행되는 파일이다. 재배기 정보만 사라진다.
```


# send.php
```
역할 : 재배기에서 받은 데이터들을 API로 보내주는 코드파일.
```
![send](https://user-images.githubusercontent.com/20119461/51076566-7e0ee680-16dd-11e9-9a64-1711b16e60ec.PNG)


# login.php
```
역할 : 미들서버 관리자 페이지로 로그인 할 때 사용되는 코드파일.
```
![nat log](https://user-images.githubusercontent.com/20119461/51076740-db0b9c00-16df-11e9-9cb9-55cb67a05c91.jpg)

# logout.php
```
역할 : 관리자 페이지의 로그아웃.
```

# main.php
```
역할 : 관리자 페이지를 브라우저로 출력해주는 코드파일.
```
![nat info](https://user-images.githubusercontent.com/20119461/51076737-ca5b2600-16df-11e9-8244-6521bdd3e45a.jpg)

# error.php
```
역할 : 에러페이지를 출력함.
```
![nat](https://user-images.githubusercontent.com/20119461/51076750-01c9d280-16e0-11e9-9af7-7b683349e761.jpg)
