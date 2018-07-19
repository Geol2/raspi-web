<?php
/**
 * Created by PhpStorm.
 * User: big94
 * Date: 2018-07-20
 * Time: 오전 2:20
 */

session_start();
$res = session_destroy();
if($res){
    header('Location : ./login.html');
}
?>