<?php
/**
 * Created by PhpStorm.
 * User: Kinnngg
 * Date: 05-03-2015
 * Time: 01:07
 */
if(!islogin())
{
header("Location: ./?home");
}
$username = $con->escape_string($username);
$sql = "SELECT * FROM user WHERE username LIKE '$username' LIMIT 1;";
$query = $con->query($sql);
$result = $query->fetch_object();
$adminrole = $result->admin_role;

if($adminrole <= 1 && $username != $_SESSION['username'])
{
	header("Location:./?home");
}
?>
<div class="cont">

<div class="alert alert-info alert-dismissible" role="alert" style="line-height:20px">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
  <strong>Dear Admin,</strong> 
		You WebAdmin login is same as your Profile Login details. Use your profile username and password to login to Webadmin.
</div>

    <IFRAME id="frame1" src="http://www.knightofsorrow.tk:10490" scrolling="auto" width="895px" height="800px">
    </IFRAME>
</div>