<?php
/**
 * Created by PhpStorm.
 * User: Kinnngg
 * Date: 26-02-2015
 * Time: 12:36
 */

/*
 * Include the Plugin(function container) that Query Server
 * @function getserverdetail(ip,qport);
 * @return json
 */
include_once("serverquery_inc.php");

$errormsg='';
if(isset($_POST['submitbtn']))
{

    $serverip = $con->escape_string($_POST['server_ip']);
    $serverjoinport = $con->escape_string($_POST['server_joinport']);
    $servergs2 = $con->escape_string($_POST['server_gs2']);
    $serverdesc = $con->escape_string($_POST['server_desc']);

    $submitterip = get_client_ip();
    $submitteremail = $con->escape_string($_POST['submitter_email']);

    if(empty($serverip) || empty($servergs2) || empty($serverjoinport) || empty($submitteremail))
    {
        $errormsg = "<div class='alert alert-danger text-center alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Error! </strong> Form not filled completely.</div>";
    }
    else
    {
        $queryport =  $servergs2 ;
        //Query Server to get server name:
        $serverdata = json_decode(getserverdetail($serverip,$queryport));
        if($serverdata->hostname == "__offline__")
        {
            $errormsg = "<div class='alert alert-danger text-center alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Error! </strong>Server: <strong>$serverip:$serverjoinport</strong> is either offline or cant be queried with port: $queryport </div>";

        }
        else {
            $hostname = $serverdata->hostname;
            $hostname = $con->escape_string($hostname);

            $server_c = getiplocation_json($serverip);
            $server_countryiso = $server_c->countryCode;

            //Check if the Server already Exist in Database
            $checkdb = $con->query("SELECT id FROM server WHERE ip LIKE '$serverip' AND (port = '$serverjoinport' OR port_gs2 = '$servergs2');");
            if($checkdb->num_rows > 0)
            {
                $errormsg = "<div class='alert alert-warning text-center alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Notice! </strong>Server: <strong>$hostname</strong> already present in our Database.</div>";
            }

            else {
                $sql = "INSERT INTO `server`(`id`, `ip`, `port`, `hostname`, `port_gs1`, `port_gs2`, `country`, `description`, `adder_email`, `adder_ip`)"
                    . " VALUES (NULL,'$serverip','$serverjoinport','$hostname',NULL,'$servergs2','$server_countryiso','$serverdesc','$submitteremail','$submitterip');";
                $query = $con->query($sql);
                if ($query) {
                    $errormsg = "<div class='alert alert-success text-center alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Success! </strong>Server: <strong>$hostname</strong> successfully added to our Database. <strong>Status:</strong> Approved</div>";
                }
            }
        }
    }
}
?>
<div id="content">
    <div class="well text-center text-success">
        <strong>Add Server to our Database</strong>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?=$errormsg?>
            <form class="form-horizontal" role="form" action="./?registerserver" method="post" name="registerclan" id="registerclanform">

                <div class="form-group">
                    <label for="input_serverip" class="col-sm-3 control-label">Server IP Address</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="input_serverip" placeholder="Enter IP Address of Server without port" name="server_ip" value="<?if(isset($_POST['submitbtn']))echo $serverip?>" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_joinport" class="col-sm-3 control-label">Server Join Port</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="input_joinport" placeholder="Enter Server Join Port" name="server_joinport" value="<?if(isset($_POST['submitbtn']))echo $serverjoinport?>" required="required">
                    </div>
                </div>
                <div class="form-group" data-toggle="tooltip" data-placement="right" title="The port to query for data. By Default: JoinPort+1. Refer: Swat4DedicatedServer.ini">
                    <label for="input_gs2" class="col-sm-3 control-label">Server Query Port</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="input_gs2" placeholder="Enter Server Query Port" name="server_gs2" value="<?if(isset($_POST['submitbtn']))echo $servergs2?>" required="required">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="input_desc">About</label>
                    <div class="col-sm-8">
                        <textarea id="input_desc" class="form-control" placeholder="Little Description about this Server." name="server_desc" rows="4"><?if(isset($_POST['submitbtn']))echo $_POST['server_desc']?></textarea>
                    </div></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="submitter_email">Your Email</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="submitter_email" placeholder="Your Email Address" name="submitter_email" value="<?if(isset($_POST['submitbtn']))echo $submitteremail?>" required="required">
                    </div></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="submitter_ip">Your IP Address</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="submitter_ip" name="submitter_email" value="<?=get_client_ip()?>" disabled>
                    </div></div>

                <div class="form-group"><label for="input_agree" class="col-sm-3 control-label"></label>
                    <div class="col-sm-8">
                        By clicking Submit you agree that the Server details is 100% true and validated.</div></div>
                <div class="form-group"><label for="input_button" class="col-sm-3 control-label"></label>
                    <div class="col-sm-8">
                        <button class="btn btn-success" name="submitbtn" value="submit" type="submit">Submit</button>
                        <input type="reset" class="btn btn-danger inline" name="reset">
                    </div></div>
            </form>

        </div>
    </div>

</div>
<!-- / Content -->