<?php
include '../conf.php';
global $con;
if ($_SESSION["username"]) 
{
$username = $_SESSION['username'];
$logintime = date("Y-m-d H:i:s");
$sql = "UPDATE user SET last_login_time=NOW() WHERE username LIKE '$username' LIMIT 1;";
$query = $con->query($sql);
}
?>