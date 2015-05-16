<div id="content">
<?php
if(!islogin())
{
header("Location: ./?home");
}

$username = $_SESSION['username'];
$userid = $_SESSION['userid'];
$ipaddr = get_client_ip();

// If user pinging from userprofile
if($_GET['pinguser'] == 'p')
{
if(isset($_POST['sendping']))
{
	$sender = $userid;
	$reciever = $con->escape_string($_POST['reciever']);
	$message = $con->escape_string($_POST['message']);
	
	if($reciever == $sender)
	{
			header("Location:./?pinguser=fail");
	}
	else
	{
	
	$query = $con->query("SELECT id FROM user WHERE id = '$reciever'");
	if($query->num_rows > 0)
	{
		$query = $con->query("INSERT INTO `pings`(`id`, `sender`, `reciever`, `message`, `sent_time`, `seen`, `sender_ip`) VALUES (null,'$sender','$reciever','$message',now(),0,'$ipaddr')");
		if($query)
		{
			header("Location:./?pinguser=sent");
		}
		else
		{
			header("Location:./?pinguser=fail");
		}
	}
	}
}
}

else if($_GET['pinguser'] == 'sent')
{
?>


<div class="alert alert-info alert-dismissible text-center" role="alert" style="line-height:20px">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><?=utf8_encode('×')?></span></button>
  <strong><?=$username?>,</strong> 
  Your ping sent successfully
</div>

<?php
}
else if($_GET['pinguser'] == 'fail')
{
?>


<div class="alert alert-danger alert-dismissible text-center" role="alert" style="line-height:20px">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><?=utf8_encode('×')?></span></button>
  <strong><?=$username?>,</strong> 
  Ping Not Sent!
</div>

<?php
}

else
{
$sqla = "SELECT * FROM pings WHERE reciever = '$userid' AND seen = 0 ORDER BY sent_time DESC;";
$querya = $con->query($sqla);
if($querya->num_rows <= 0)
{
	$pingdata = "<h4>No New Ping!</h4>";
}
else
{
	while($result = $querya->fetch_object())
	{
		$id = $result->id;
		$sender =  $result->sender;
		$message = $result->message;
		$sent_time = $result->sent_time;
		$query2 = $con->query("SELECT username FROM user WHERE id='$sender' LIMIT 1;");
		$data = $query2->fetch_object();
		$username = $data->username;
		$timeago = timeago($sent_time);
		
		$query = $con->query("UPDATE pings SET seen = 1, seen_time = now() WHERE id = '$id';");
		
		$pingdata = $pingdata.<<<HTML
               <div class="article row no-padding no-margin" style="border-bottom:2px dashed">
                    <h4 class=''><a style="color:#CE0000" href="./?userprofile=$username">$username</a></h4>
                    <p class='newsdate'><i class="date">$timeago</i></p>
                    <p style="color:#434343;font-size:13px" class='newssummary'>$message</p>
                </div>
HTML;
	}
}
?>
    <div class="panel panel-default padding15">
        <?=$pingdata?>
    </div>
<?php
}
?>
</div>