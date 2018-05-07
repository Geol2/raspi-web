<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
    header('Content-Type: application/json');

    //Get JSON as a string..
    $json_str = file_get_contents("php://input");

    // Get as an object..
    $json_obj = json_decode($json_str);

    $cmd = $json_obj->{"cmd"};
    $dest = $json_obj->{"dest"};
    $user_code = $json_obj->{"userCode"};
    //$cmd = $_POST['cmd'];
    //$dest = $_POST['dest'];

    //$key = ['cmd' => $cmd, 'dest' => $dest];

    //echo json_encode($key);
?>
    <script type="text/javascript">
        xhr=new XMLHttpRequest();
        xhr.onreadystatechange=finish;
        function send_cmd(cmd){
            xhr.open("GET", "http://192.168.4.11?cmd="+cmd, true);
            xhr.send();
            if(cmd == '3'){
                document.getElementById("manual_btn").style.visibility = "visible";
            }
            else if(cmd == '2'){
                document.getElementById("manual_btn").style.visibility = "hidden";
            }
        }
        function finish(){
            if(xhr.readyState==4&&xhr.status==200){
                var dom=document.getElementById('text');
                dom.innerHTML=xhr.responseText;
            }
        }
    </script>

  <?php

?>