<?php
/**
 * Created by PhpStorm.
 * User: Kinnngg
 * Date: 26-02-2015
 * Time: 12:36
 */
$errormsg='';
if(isset($_POST['submitbtn']))
{

    $fullname = $con->escape_string($_POST['clan_fullname']);
    $shortname = $con->escape_string($_POST['clan_shortname']);
    $gametype = $con->escape_string($_POST['game_type']);
    $gamename = $con->escape_string($_POST['game']);
    $clanmotto = $con->escape_string($_POST['clan_motto']);
    $clantag = $con->escape_string($_POST['clan_tag']);
    $foundyear = $con->escape_string($_POST['clan_found_year']);
    $clanleader = $con->escape_string($_POST['clan_leader']);
    $clanwebsite = $con->escape_string($_POST['clan_website']);
    $clanserver = $con->escape_string($_POST['clan_server']);
    $clandesc = $con->escape_string($_POST['desc']);

    $submitterip = get_client_ip();
    $submitteremail = $con->escape_string($_POST['submitter_email']);

    if(empty($gamename) || empty($fullname) || empty($shortname) || empty($gametype) || empty($clantag) || empty($clanleader) || empty($clandesc) || empty($submitteremail))
    {
        $errormsg = "<div class='alert alert-danger text-center alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Warning! </strong> Form not filled completely.</div>";
    }
    else
    {
        $sql = "INSERT INTO `clans`(`id`, `clan_name`, `clan_tag`, `clan_image`, `clan_gamename`, `clan_gamemode`, `date_founded`, `current_leader`, `clan_motto`, `clan_desc`, `clan_website`, `clan_shortname`, `clan_serverip`, `submitted_by`, `submitter_ip`, `approved_by`, `approved`, `rank`)"
        ." VALUES (NULL,'$fullname','$clantag',NULL,'$gamename','$gametype','$foundyear','$clanleader','$clanmotto','$clandesc','$clanwebsite','$shortname','$clanserver','$submitteremail','$submitterip',NULL,0,NULL)";
        $query = $con->query($sql);

        if($query)
        {
            $errormsg = "<div class='alert alert-success text-center alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Success! </strong>Clan's profile successfully added to our Database. <strong>Status:</strong> Awaiting Approval</div>";
        }
    }
}
?>
<div id="content">
<div class="well text-center text-success">
    <strong>Register clan to our database</strong>
</div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?=$errormsg?>
            <form class="form-horizontal" role="form" action="./?registerclan" method="post" name="registerclan" id="registerclanform">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="game">Select Game</label>
                    <div class="col-sm-8">
                        <select id="game" name="game" class="game form-control" required="required">
                            <option value="">Select Game</option>
                            <option value="1">SWAT4 1.0</option>
                            <option value="2">SWAT4 1.1</option>
                            <option value="3">SWAT4 TSS</option>
                        </select>
                    </div></div>
                <div class="form-group">
                    <label for="input_clanname" class="col-sm-3 control-label">Clan Full Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="input_clanname" placeholder="Enter Clan full name" name="clan_fullname" value="<?if(isset($_POST['submitbtn']))echo $fullname?>" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_shortname" class="col-sm-3 control-label">Clan Short Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="input_shortname" placeholder="Enter Clan Short Name" name="clan_shortname" value="<?if(isset($_POST['submitbtn']))echo $shortname?>" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="gametype">Game Type</label>
                    <div class="col-sm-8">
                        <select id="gametype" name="game_type" class="game form-control" required="required">
                            <option value="">Select Gametype</option>
                            <option value="Barricaded Suspects">Barricaded Suspects</option>
                            <option value="VIP Escort">VIP Escort</option>
                            <option value="Rapid Deployment">Rapid Deployment</option>
                            <option value="Smash &amp; Grab">Smash &amp; Grab</option>
                            <option value="Coop">Coop</option>
                        </select>
                    </div></div>
                <div class="form-group">
                    <label for="input_motto" class="col-sm-3 control-label">Clan Slogan</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="input_motto" placeholder="Enter Clan Motto or Slogan" name="clan_motto" value="<?if(isset($_POST['submitbtn']))echo $clanmotto?>" required="required">
                    </div>
                </div>
                <div class="form-group" data-toggle="tooltip" data-placement="right" title="This is very important field. This will sort out of player of this clan using this tag. Ex: {FAB},|SRV| etc">
                    <label for="input_clantag" class="col-sm-3 control-label">Clan Tag</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="input_clantag" placeholder="Enter Clan Tag" name="clan_tag" value="<?if(isset($_POST['submitbtn']))echo $clantag?>" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_foundyear" class="col-sm-3 control-label">Founded Year</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="input_foundyear" placeholder="Year clan was founded." name="clan_found_year" value="<?if(isset($_POST['submitbtn']))echo $foundyear?>" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_clanleader" class="col-sm-3 control-label">Clan Leader</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="input_clanleader" placeholder="Current Clan Leader" name="clan_leader" value="<?if(isset($_POST['submitbtn']))echo $clanleader?>" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_website" class="col-sm-3 control-label">Clan Website</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="input_website" placeholder="Enter Clan Website URL" name="clan_website" value="<?if(isset($_POST['submitbtn']))echo $clanwebsite?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_server" class="col-sm-3 control-label">Clan Server</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="input_server" placeholder="Enter Clan Server IP:Port" name="clan_server" value="<?if(isset($_POST['submitbtn']))echo $clanserver?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="desc">Description</label>
                    <div class="col-sm-8">
                        <textarea id="desc" class="form-control" placeholder="Details of clan." name="desc" rows="4"><?if(isset($_POST['submitbtn']))echo $clandesc?></textarea>
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
                        By clicking Submit you agree not to voilate our <a href="?terms">Terms &amp; Conditions</a> and accept that the Clan details is 100% true and validated.</div></div>
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