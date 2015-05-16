<?php
/**
 * Created by PhpStorm.
 * User: Kinnngg
 * Date: 26-02-2015
 * Time: 12:36
 */
$errormsg='';

if(islogin())
{
    header("location: ./?profile");
}
if($_GET['login'] == 'logout')
{
    $_SESSION=array();
    session_destroy();
    header("location: ./?home");
}

if(isset($_POST['submitbtn']))
{
    $username = $con->escape_string($_POST['input_username']);
    $username=preg_replace('#[^a-z0-9.@]#i','',$username);
    $password = $con->escape_string($_POST['input_password']);
    $hashpassword = hash("sha256",DB_SALT . $password);
    $res = $con->query("SELECT * FROM user WHERE (username LIKE '$username' OR email LIKE '$username') AND hash_passwd LIKE '$hashpassword' LIMIT 1;");
    $ipaddr = get_client_ip();

    if(empty($username) || empty($password))
    {
        $errormsg = "<div class='alert alert-danger text-center alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Warning! </strong> Form not filled completely.</div>";
    }
    else if($res->num_rows <= 0)
    {
        $errormsg = "<div class='alert alert-danger text-center alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Error!  </strong> No User found matching.</div>";
    }
    else if($res->num_rows == 1)
    {
        $logintime = date("Y-m-d H:i:s");
        $sql = "UPDATE user SET last_login_ip='$ipaddr',last_login_time='$logintime' WHERE username LIKE '$username' LIMIT 1;";
        $query = $con->query($sql);
        if($query)
        {
            $row = $res->fetch_object();
            $_SESSION['username'] = $row->username;
			$_SESSION['userid'] = $row->id;
            $_SESSION['password'] = $row->hash_passwd;
            $_SESSION['email'] = $row->email;
            header("location: ./?profile");
        }
    }
    else
    {
        echo $con->error;
    }
}
?>
<div id="content">
    <div class="well text-center text-success">
        <strong>Login to your Account</strong>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?=$errormsg?>
            <form style="color: #000000" class="form-horizontal" role="form" action="./?login" method="post" name="login" id="loginform">

                <div class="form-group">
                    <label for="input_username" class="col-sm-3 control-label">Username</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="input_username" placeholder="Enter Username" name="input_username" value="<?if(isset($_POST['submitbtn']))echo $username?>" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_password" class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="input_password" placeholder="Enter Password" name="input_password" value="<?if(isset($_POST['submitbtn']))echo $password?>" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="submitter_ip">Your IP Address</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="submitter_ip" name="submitter_email" value="<?=get_client_ip()?>" disabled>
                    </div>
                </div>
                <div class="form-group"><label for="input_button" class="col-sm-3 control-label"></label>
                    <div class="col-sm-8">
                        <button class="btn btn-success" name="submitbtn" value="submit" type="submit">Login</button>
                        <input type="reset" class="btn btn-danger inline" name="reset">
                    </div></div>
            </form>

        </div>
    </div>

</div>
<!-- / Content -->