<?php
/**
 * Created by PhpStorm.
 * User: Kinnngg
 * Date: 15-03-2015
 * Time: 04:09
 */
if(!islogin())
{
    header("Location:./?home");
}

$errmsg = '';

function handlelinking()
{
    global $con;
    $userip = get_client_ip();
    $sql = "SELECT * FROM playeroverall WHERE last_ip LIKE '$userip';";
    $query = $con->query($sql);
    if($query->num_rows <= 0)
    {
        return false;
    }
    $playerlistdata = "<option value=''>Select a Player</option>";
    while($result = $query->fetch_object())
    {
        $playerName = $result->playername;
        $playerID = $result->id;
        $playerlistdata = $playerlistdata."<option value='$playerName'>$playerName</option>";
    }
    return $playerlistdata;
}
$playerlist = handlelinking();
if($playerlist == False)
{
    $playerlist = "<div class='alert alert-warning text-justify alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>No Player Found! </strong>Either No Player found matching your IP Address or you have not played in Server for one round. Please play in server for 1 round and come back again.</div><select id='player' name='player' class='player form-control' required='required'><option value=''>Select a Player</option></select>";
}
else
{
    $playerlist = <<<_HTML
<div class="">
                <select id="player" name="player" class="player form-control" required="required">
                    $playerlist
                </select>
            </div>
_HTML;
}

if(isset($_POST['submitbtn']))
{
    $playerName = $_POST['player'];
    global $con;
    $userip = get_client_ip();
    $sql= "SELECT * FROM playeroverall WHERE last_ip LIKE '$userip' AND playername LIKE '$playerName' LIMIT 1;";
    $query = $con->query($sql);

    //This check if player already linked to a user
    $query2 = $con->query("SELECT * FROM user WHERE linked_playeroverall_name = '$playerName'");

    if($query->num_rows <= 0)
    {
        $errmsg = "<div class='alert alert-danger text-center alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Update Failed! </strong>Error linking player to profile! Try again.</div>";
    }
    elseif($query2->num_rows > 0)
    {
        $result2 = $query2->fetch_object();
        $username2 = $result2->username;
        $errmsg = "<div class='alert alert-danger text-center alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Update Failed! </strong>Player is already linked to this user (<b>$username2</b>). If you think its wrong please contact admin.</div>";
    }
    else
    {
        $result = $query->fetch_object();
        $playerId = $result->id;
        $playerName = $result->playername;
        $playerProfileId = $result->profile;
        $ss_username = $_SESSION['username'];

        $sql = "UPDATE user SET linked_profile_id='$playerProfileId',linked_playeroverall_name='$playerName' WHERE username LIKE '$ss_username' LIMIT 1;";
        if($con->query($sql))
        {
            $errmsg = "<div class='alert alert-success text-center alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Linking Successful! </strong>You have successfully linked this Player to your user profile.</div>";
        }
        else
        {
            $errmsg = "<div class='alert alert-danger text-center alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Linking Failed! </strong>Unknown error has occured. Please try again.</div>";
        }
    }
}
?>
<div id="content">
    <div class="panel no-margin padding10 row">
        <?=$errmsg?>
        <div class="col-md-6 linkprofilecont">
            <form class="form" action="./?linkplayerprofile" method="post" name="linkplayerform">
            <?=$playerlist?>
                <hr>
            <input type="submit" value="LINK" name="submitbtn" class="btn btn-warning btn-block">
            </form>
        </div>
        <div class="col-md-6 textdark howtojoin">
            <h3 class="textorange">How to link ?</h3>
            <ul>
                <li>Join server and play for atleast one Round.</li>
                <li>Come back to this page. (refresh if already present)</li>
                <li>Choose the username & click on the LINK button.</li>
            </ul>
        </div>
    </div>
</div>