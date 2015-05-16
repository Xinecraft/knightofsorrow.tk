<?php
/**
 * Created by PhpStorm.
 * User: Kinnngg
 * Date: 11-03-2015
 * Time: 19:05
 */
$username = '';

if(isset($_GET['userprofile']))
    $username = $_GET['userprofile'];

if(empty($username) || $username == '' || !isset($_GET['userprofile']))
{
    $username = $_SESSION['username'];
}
$username = $con->escape_string($username);
$sql = "SELECT * FROM user WHERE username LIKE '$username' LIMIT 1;";
$query = $con->query($sql);
if($query->num_rows <= 0)
{
    echo <<<_HTML
<div id="content">
    <div class="row no-margin no-padding">
        <div class="panel padding10 userprofilecont">
          <h2 class='font-dsdigital'>No User Found</h2>
        </div>
    </div>
</div>
_HTML;
    return;
}
$result = $query->fetch_object();
$username = $result->username;
$userid= $result->id;
$fullname = $result->fullname;
$dob = $result->dob;
$gender = $result->gender;
$email = $result->email;
$countryiso = $result->country;
$about = $result->about;
$adminrole = $result->admin_role;
$lastlogintime = $result->last_login_time;
$gr_id = $result->gr_id;
$fb_id = $result->fb_id;
$xfire_id = $result->xfire_id;
$registeron = $result->registered_on;
$linked_profile_id = $result->linked_profile_id;
$linked_playeroverall_name = $result->linked_playeroverall_name;

$lastseen = timeago($lastlogintime);
$joinedon = timeago(($registeron));

if($lastseen == "Just Now")
	$lastseen =  "<font color='green'><b>Online</b></font>";

$age = getAge($dob);
$dob = strtotime($dob);
$dob = date('M dS, Y',$dob);

if($gr_id == '' || $gr_id == NULL || empty($gr_id))
{
    $gr_id = "<i>Not Specified</i>";
}
if($xfire_id == '' || $xfire_id == NULL || empty($xfire_id))
{
    $xfire_id_url = "<i>Not Specified</i>";
    $userprofilepic = "<img class='img-thumbnail' src='images/css/profilepic.jpg'>";
}
else
{
    if(isImage2("http://screenshot.xfire.com/avatar/160/$xfire_id.jpg"))
    {
        $xfire_id_url = "<a class='ainorange' href='http://www.xfire.com/profile/$xfire_id' target='_blank'>$xfire_id</a>";
        $userprofilepic = "<img class='img-thumbnail' src='http://screenshot.xfire.com/avatar/160/$xfire_id.jpg'>";
    }
    else
    {
        $xfire_id_url = "<a class='ainorange' href='http://www.xfire.com/profile/$xfire_id' target='_blank'>$xfire_id</a>";
        $userprofilepic = "<img class='img-thumbnail' src='images/css/profilepic.jpg'>";
    }
}
if($fb_id == '' || $fb_id == NULL || empty($fb_id))
{
    $fb_id = "<i>Not Specified</i>";
}
else
{
    $fb_id = "<a href='$fb_id' target='_blank' class='ainorange'>Click Here</a>";
}
if($about == '' || $about == NULL || empty($about))
{
    $about = "<i>Not Specified</i>";
}

switch($adminrole)
{
    case 0:
        $userclass = "User";
        break;
    case 1:
        $userclass = "|KoS| Member";
        break;
    case 2:
        $userclass = "Administrator";
        break;
    case 3:
        $userclass = "Super Administrator";
        break;
    default:
        $userclass = "User";
        break;
}

/**
 * Players link of User Profile
 */
if($linked_playeroverall_name == NULL || $linked_playeroverall_name == '' || empty($linked_playeroverall_name))
{
    if($username == $_SESSION['username'])
    {
        $linkedPlayerName = "<a href='./?linkplayerprofile' class='ainorange'>Choose one</a>";
    }
    else
    {
        $linkedPlayerName = "<i>Not Specified</i>";
    }
    $bPlayerLinked = false;

    $linkedPosition = "<i>Not Specified</i>";
    $linkedTimePlayed = "<i>Not Specified</i>";
    $linkedLastSeen = "<i>Not Specified</i>";
}
else
{
    $sql = "SELECT * FROM playeroverall WHERE playername LIKE '$linked_playeroverall_name' LIMIT 1;";
    $query = $con->query($sql);
    if($query->num_rows <= 0)
    {
        $bPlayerLinked = false;
        $linkedPlayerName = "<a href='./?linkplayerprofile' class='ainorange'>Choose one</a>";
        $linkedPosition = "<i>Not Specified</i>";
        $linkedTimePlayed = "<i>Not Specified</i>";
        $linkedLastSeen = "<i>Not Specified</i>";
    }
    else
    {
        $result = $query->fetch_object();
        $bPlayerLinked = True;
        $linkedPlayedId = $result->id;
        $playerName = $result->playername;
        $linkedPosition = $result->position;
        $linkedTimePlayed  = $result->timetotal;
        $pgamelast = $result->gamelast;

        // Last Seen
        $query = $con->query("SELECT date_finished,server_time FROM game WHERE id='$pgamelast' LIMIT 1;");
        $result = $query->fetch_object();
        $gamelast_time = $result->date_finished;
        $gamelast_servertime = $result->server_time;
        $gamelast_timeago = timeago2($gamelast_servertime-3600);

        $linkedTimePlayed = formatHM($linkedTimePlayed);
        $linkedPosition = "<font color='green'><b>".$linkedPosition."</b></font>";

        $linkedLastSeen = $gamelast_timeago;
        $linkedPlayerName = "<a href='./?statistics=player&detail=".urlencode($playerName)."' class='ainorange'>$playerName</a>";
    }
}

?>

<div id="content">
    <div class="row no-margin no-padding">

        <div class="panel padding10 userprofilecont">
		
<?php
if($adminrole > 11 && $username == $_SESSION['username'])
{
?>		
		<div class="alert alert-info alert-dismissible" role="alert" style="line-height:20px">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
  <strong>Dear Admin,</strong> 
		You are requested not to ban any player permanently rather ban them for a specific period.<br>
		To ban with time you can do this: <br><kbd>kick ac addban/kickban [PlayerName/IP] [years:months:days:hours:minutes] [Comments]</kbd>.<br> Parts of time can be omitted.<br>
		For example: <code>kick ac addban Kinnngg 3:0:17 Mass Team Killer</code> would make the ban last for 3 days, 0 hours and 17 minutes with a comment "Mass Team Killer". <br><b>Permanent ban should be the last move :)</b>
</div>
<?php
}
?>		

<?php
if($adminrole > 1 && $username == $_SESSION['username'])
{
?>		
		<div class="alert alert-info alert-dismissible" role="alert" style="line-height:20px">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
  <strong>Dear Admin,</strong> 
  We have added a section where you can view chat history of the Server and also search.<br>
  Visit this link to search chat history. There is a button also in your user profile section to visit Chat History section.<br>
  <b><a href="./?chathistory">View Chat History</a></b>
</div>
<?php
}
?>	

            <div class="col-md-3">
                <?=$userprofilepic?>
            </div>
            <div class="col-md-9">
			
                <p class="col-md-3 user-head-label">Username:</p> <p class="col-md-8 user-head-value"><?=$username?></p>
                <p class="col-md-3 user-head-label">Class:</p> <p class="col-md-8 user-head-value"><?=$userclass?> </p>
                <p class="col-md-3 user-head-label">Joined on:</p> <p class="col-md-8 user-head-value"><?=$joinedon?> </p>
                <p class="col-md-3 user-head-label">Last seen:</p> <p class="col-md-8 user-head-value"><?=$lastseen?></p>
                <p class="col-md-3 user-head-label">Xfire:</p> <p class="col-md-8 user-head-value"><?=$xfire_id_url?></p>
            </div>

<?php
if($username != $_SESSION['username'])
{
?>
		<div class="row no-margin no-padding">
		<!-- Button trigger modal -->
<button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#pingusermodel" style="margin-top:40px !important;">
  Ping <?=$username?>
</button>
<!-- Modal -->
<div class="modal fade" id="pingusermodel" tabindex="-1" role="dialog" aria-labelledby="pingusermodel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Ping <?=$username?></h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="./?pinguser=p" name="pinguser">
          <div class="form-group">
            <label for="message-text" class="control-label">Message (160 letters only):</label>
            <textarea class="form-control" id="message-text" name="message" maxlength="160"></textarea>
			<input type="hidden" name="reciever" value="<?=$userid?>">
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Send Ping" name="sendping">
		</form>
      </div>
    </div>
  </div>
</div>
</div>
<?php
}
?>

            <div class="row no-margin no-padding" style="margin-top:100px !important;">
                <div class="well row col-md-6 padding10 no-margin userpresonalprofile">
                    <p class="no-margin no-padding perinfoheader">Personal Info</p>
                    <p class="col-md-3 user-head-label">Full Name:</p> <p class="col-md-8 user-head-value"><?=$fullname?></p>
                    <p class="col-md-3 user-head-label">Location:</p> <p class="col-md-8 user-head-value"><?=country_code_to_country($countryiso)?>&nbsp;<img src="images/flags/20_shiny/<?=$countryiso?>.png"> </p>
                    <p class="col-md-3 user-head-label">Gender:</p> <p class="col-md-8 user-head-value"><?=$gender?></p>
                    <p class="col-md-3 user-head-label">Age:</p> <p data-toggle="tooltip" title="<?=$dob?>" data-placement="left" class="col-md-8 user-head-value"><?=$age?> years old</p>
                    <p class="col-md-3 user-head-label">Fb:</p> <p class="col-md-8 user-head-value"><?=$fb_id?></p>
                    <p class="col-md-3 user-head-label">GR Id:</p> <p class="col-md-8 user-head-value"><?=$gr_id?></p>
                </div>

                <div class="well row col-md-6 right padding10 no-margin userstatstracker">
                    <?php
                    if($username == $_SESSION['username'])
                    {
                        ?>
                        <a href="./?linkplayerprofile" class="ainorange"><i class="glyphicon glyphicon-cog right"></i></a>
                    <?php
                    }
                    ?>
                    <p class="no-margin no-padding perinfoheader">Stats Tracker</p>
                    <p class="col-md-5 user-head-label">Player Name:</p> <p class="col-md-6 user-head-value"><?=$linkedPlayerName?></p>
                    <p class="col-md-5 user-head-label">Position:</p> <p class="col-md-6 user-head-value"><?=$linkedPosition?></p>
                    <p class="col-md-5 user-head-label">Time Played:</p> <p class="col-md-6 user-head-value"><?=$linkedTimePlayed?></p>
                    <p class="col-md-5 user-head-label">Last seen:</p> <p class="col-md-6 user-head-value"><?=$linkedLastSeen?></p>
                </div>
            </div>

            <div class="well row col-md-12 padding10 no-margin useraboutcont">
                <p class="no-margin no-padding perinfoheader">About me</p>
                <p class="col-md-12 user-head-value"><?=$about?></p>
            </div>
			<?php
			if($adminrole > 1 && $username == $_SESSION['username'])
			{
			?>
			<div class="well row col-md-12 padding10 no-margin useraboutcont">
                <p class="no-margin no-padding perinfoheader">Admin Functions</p>
                <a href="./?chathistory" class="btn btn-info">Chat History</a>
				<a href="./?webadmin" class="btn btn-info">Web Admin</a>
				<?php
			if($adminrole == 3 && $username == $_SESSION['username'])
			{
				echo '<a href="http://knightofsorrow.tk/monitor.php" class="btn btn-info">AntiDDOS Monitor System</a>';
			}
			?>
            </div>
			<?php
			}
			?>
			

        </div>


    </div>
</div>