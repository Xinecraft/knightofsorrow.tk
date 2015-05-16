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
if(isset($_POST['submitbtn']))
{

    $username = $con->escape_string($_POST['input_username']);
    $username=preg_replace('#[^a-z0-9.@]#i','',$username);
    $password = $con->escape_string($_POST['input_password']);
    $hashpassword = hash("sha256",DB_SALT . $password);
    $email = $con->escape_string($_POST['input_email']);
    $fullname = $con->escape_string($_POST['input_fullname']);
    $dob = $con->escape_string($_POST['input_dob']);
    $gender = $con->escape_string($_POST['input_gender']);
    $about = $con->escape_string($_POST['input_about']);
    $xfire = $con->escape_string($_POST['input_xfire']);
    $gamerangerid = $con->escape_string($_POST['input_gr']);
    $facebookurl = $con->escape_string($_POST['input_facebook']);
    $ipaddr = get_client_ip();

    $ip_api = getiplocation_json($ipaddr);
    $countryiso = $ip_api->countryCode;

    $res = $con->query("SELECT id FROM user WHERE username LIKE '$username' OR email LIKE '$email' LIMIT 1;");

    if(empty($username) || empty($password) || empty($email) || empty($fullname) || empty($dob) || empty($gender) || !filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $errormsg = "<div class='alert alert-danger text-center alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Warning! </strong> Form not filled completely.</div>";
    }
    else if($res->num_rows > 0)
    {
        $errormsg = "<div class='alert alert-danger text-center alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Error!  </strong> Username or email already registered.</div>";
    }
    else
    {
        $sql = "INSERT INTO `user`(`id`, `username`, `orig_passwd`, `hash_passwd`, `email`, `dob`, `gender`, `fullname`, `about`, `country`, `last_login_ip`, `approved`, `fb_id`, `gr_id`, `xfire_id`, `registered_on`)"
        ." VALUES (NULL,'$username','$password','$hashpassword','$email','$dob','$gender','$fullname','$about','$countryiso','$ipaddr',1,'$facebookurl','$gamerangerid','$xfire',now());";
        $query = $con->query($sql);
        if($query)
        {
            $errormsg = "<div class='alert alert-success text-center alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Success! </strong>You have been registered.</div>";
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $hashpassword;
            $_SESSION['email'] = $email;
			$_SESSION['userid'] = $con->insert_id;
            header("location: ./?profile");
        }
    }
}
?>
<div id="content">
    <div class="well text-center text-success">
        <strong>Create an Account</strong>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?=$errormsg?>
            <form style="color: #000000" class="form-horizontal" role="form" action="./?register" method="post" name="register" id="registerform">

                <div class="form-group">
                    <label for="input_username" class="col-sm-3 control-label">Desired Username</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="input_username" placeholder="Enter Desired Username" name="input_username" value="<?if(isset($_POST['submitbtn']))echo $username?>" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_password" class="col-sm-3 control-label">Desired Password</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="input_password" placeholder="Enter Desired Password" name="input_password" value="<?if(isset($_POST['submitbtn']))echo $password?>" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_email" class="col-sm-3 control-label">Email Address</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" id="input_email" placeholder="Enter your Email Address" name="input_email" value="<?if(isset($_POST['submitbtn']))echo $email?>" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_fullname" class="col-sm-3 control-label">Full Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="input_fullname" placeholder="Enter your Fullname" name="input_fullname" value="<?if(isset($_POST['submitbtn']))echo $fullname?>" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_dob" class="col-sm-3 control-label">Date of Birth</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" id="input_dob" placeholder="Enter your Dob" name="input_dob" value="<?if(isset($_POST['submitbtn']))echo $dob?>" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="input_gender">Gender</label>
                    <div class="col-sm-8">
                        <select id="input_gender" name="input_gender" class="game form-control" required="required">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Others">Others</option>
                        </select>
                    </div></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="input_about">About yourself</label>
                    <div class="col-sm-8">
                        <textarea id="input_about" class="form-control" placeholder="Few line about yourself" name="input_about" rows="3"><?if(isset($_POST['submitbtn']))echo $about?></textarea>
                    </div></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="input_xfire">Xfire Username<br><small>(optional)</small></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="input_xfire" placeholder="Your Xfire Username" name="input_xfire" value="<?if(isset($_POST['submitbtn']))echo $xfire?>">
                    </div></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="input_gr">GameRanger ID<br><small>(optional)</small></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="input_gr" placeholder="Your GameRanger Id" name="input_gr" value="<?if(isset($_POST['submitbtn']))echo $gamerangerid?>">
                    </div></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="input_facebook">Facebook URL<br><small>(optional)</small></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="input_facebook" placeholder="Your Facebook ID Url (link)" name="input_facebook" value="<?if(isset($_POST['submitbtn']))echo $facebookurl?>">
                    </div></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="submitter_ip">Your IP Address</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="submitter_ip" name="submitter_email" value="<?=get_client_ip()?>" disabled>
                    </div></div>

                <div class="form-group"><label for="input_agree" class="col-sm-3 control-label"></label>
                    <div class="col-sm-8">
                        By clicking Submit you agree not to voilate our <a href="?terms">Terms &amp; Conditions</a> </div></div>
                <div class="form-group"><label for="input_button" class="col-sm-3 control-label"></label>
                    <div class="col-sm-8">
                        <button class="btn btn-success" name="submitbtn" value="submit" type="submit">Register</button>
                        <input type="reset" class="btn btn-danger inline" name="reset">
                    </div></div>
            </form>

        </div>
    </div>

</div>
<!-- / Content -->