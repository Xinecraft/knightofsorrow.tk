<?php
/**
 * Created by PhpStorm.
 * User: Kinnngg
 * Date: 01-03-2015
 * Time: 07:26
 */

if(!isset($_GET['detail']) || $_GET['detail'] == '' )
{
    header("location:./?statistics=player");
}

$playerid = $con->escape_string($_GET['detail']);

$sql = "SELECT p.*,l.rankname,l.id as rankid,l.rankpoints FROM playeroverall AS p JOIN ranklist AS l ON l.id = p.rank WHERE p.playername LIKE '$playerid' LIMIT 1;";
$query = $con->query($sql);
if($query->num_rows <= 0)
{
    echo "<div class='well'><h3 class='font-dsdigital'>No Player found with Name '$playerid'</h3></div>";
}
else
{
    $player = $query->fetch_object();
    $pid = $player->id;
    $pname = $player->playername;
    $palias = $player->alias;
    $pprofile = $player->profile;
    $pcountryiso = $player->countryiso;
    $pisadmin = $player->admin;
    $pscoretotal = $player->scoretotal;
    $phighestscore = $player->highestscore;
    $ptimetotal = $player->timetotal;
    $pkillstotal = $player->killstotal;
    $pteamkillstotal = $player->teamkillstotal;
    $pdeathstotal = $player->deathstotal;
    $psuicidestotal = $player->suicidestotal;
    $parreststotal = $player->arreststotal;
    $parrestedtotal = $player->arrestedtotal;
    $pbestkillstreak = $player->bestkillstreak;
    $pbestarreststreak = $player->bestarreststreak;
    $pbestdeathstreak = $player->bestdeathstreak;
    $ppointstotal = $player->pointstotal;
    $ptotalroundplayed = $player->totalroundplayed;
    $pposition = $player->position;
    $plastloadout = $player->lastloadout;
    $plastteam = $player->lastteam;
    $pgamefirst = $player->gamefirst;
    $pgamelast = $player->gamelast;
    $pkdratio = $player->killdeathratio;
    $paaratio = $player->aaratio;
    $pscorepermin = $player->scorepermin;
    $pscorepercentile = $player->scorepercentile;
    $prating = $player->rating;
    $playeridlist = $player->player_ids;

    $pcountryname = country_code_to_country($pcountryiso);
    $pscoreperround = round($pscoretotal / $ptotalroundplayed,2);
    $rankid = $player->rankid;
    $rankname = $player->rankname;
    $rankpoints = $player->rankpoints;
    $timeplayedinHM = formatHM($ptimetotal);

    /**
     * LoadOut
     */
    $sql = "SELECT * FROM loadout WHERE id='$plastloadout' LIMIT 1;";
    $query = $con->query($sql);
    if($query-> num_rows <= 0)
    {
        $primaryweapon = 0;
        $primaryweaponammo = 0;
        $secondaryweapon = 0;
        $secondaryweaponammo = 0;
        $equipment1 = 0;
        $equipment2 = 0;
        $equipment3 = 0;
        $equipment4 = 0;
        $equipment5 = 0;
        $breacher = 0;
        $headload = 0;
        $bodyarmor = 0;

        $primaryweapon_name = GetElemfromId($primaryweapon,'W');
        $primaryweaponammo_name = GetElemfromId($primaryweaponammo,'A');
        $secondaryweapon_name = GetElemfromId($secondaryweapon,'W');
        $secondaryweaponammo_name = GetElemfromId($secondaryweaponammo,'A');
        $equipment1_name = GetElemfromId($equipment1,'W');
        $equipment2_name = GetElemfromId($equipment2,'W');
        $equipment3_name = GetElemfromId($equipment3,'W');
        $equipment4_name = GetElemfromId($equipment4,'W');
        $equipment5_name = GetElemfromId($equipment5,'W');
        $breacher_name = GetElemfromId($breacher,'W');
        $headload_name = GetElemfromId($headload,'W');
        $bodyarmor_name = GetElemfromId($bodyarmor,'W');
    }
    else
    {
        $loadout = $query->fetch_object();
        $primaryweapon = $loadout->primary_weapon;
        $primaryweaponammo = $loadout->primary_ammo;
        $secondaryweapon = $loadout->secondary_weapon;
        $secondaryweaponammo = $loadout->secondary_ammo;
        $equipment1 = $loadout->equip_one;
        $equipment2 = $loadout->equip_two;
        $equipment3 = $loadout->equip_three;
        $equipment4 = $loadout->equip_four;
        $equipment5 = $loadout->equip_five;
        $breacher = $loadout->breacher;
        $headload = $loadout->head;
        $bodyarmor = $loadout->body;

        $primaryweapon_name = GetElemfromId($primaryweapon,'W');
        $primaryweaponammo_name = GetElemfromId($primaryweaponammo,'A');
        $secondaryweapon_name = GetElemfromId($secondaryweapon,'W');
        $secondaryweaponammo_name = GetElemfromId($secondaryweaponammo,'A');
        $equipment1_name = GetElemfromId($equipment1,'W');
        $equipment2_name = GetElemfromId($equipment2,'W');
        $equipment3_name = GetElemfromId($equipment3,'W');
        $equipment4_name = GetElemfromId($equipment4,'W');
        $equipment5_name = GetElemfromId($equipment5,'W');
        $breacher_name = GetElemfromId($breacher,'W');
        $headload_name = GetElemfromId($headload,'W');
        $bodyarmor_name = GetElemfromId($bodyarmor,'W');
    }

    // Load the TOP char Image using this
    $teambodyhead = $plastteam.'_'.$bodyarmor.'_'.$headload;


    $rankrowdata = "";
    $sql = "SELECT * FROM ranklist WHERE id > -1 ORDER BY id;";
    $query = $con->query($sql);
    while($ranklist = $query->fetch_object())
    {
        $ranklist_name = $ranklist->rankname;
        $ranklist_points = $ranklist->rankpoints;
        $ranklist_id = $ranklist->id;
        $ranklist_desc = $ranklist->desc;

        if($ranklist_id == $rankid)
        {
            $rankrowdata = $rankrowdata.<<<_HTML
            <div class="colm-2 no-padding">
                <img data-toggle="tooltip" data-html="true" data-original-title="$ranklist_name <br>Points: $ranklist_desc" class="img-thumbnail"
                     src="images/game/insignia/$ranklist_id.png" width="50px" style="height: 50px;border:1px solid rgb(255, 94, 0);">
                <p class="text-center" style="color: rgb(255, 94, 0);margin-top: 5px;"><strong>$ranklist_name</strong></p>
            </div>
_HTML;
        }
        else
        {
            $rankrowdata = $rankrowdata.<<<_HTML
            <div class="colm-1 no-padding">
                <img data-toggle="tooltip" data-html="true" data-original-title="$ranklist_name <br>Points: $ranklist_desc" class="img-thumbnail"
                     src="images/game/insignia/$ranklist_id.png" width="40px" style="height: 40px;">
            </div>
_HTML;
        }
    }

    /**
     * Last Seen ans First Seen
     */
    global $timezoneoffset;
    $query = $con->query("SELECT date_finished,server_time FROM game WHERE id='$pgamefirst' LIMIT 1;");
    $result = $query->fetch_object();
    $gamefirst_time = $result->date_finished;
    $gamefirst_servertime = $result->server_time;
    $gamefirst_timeago = timeago2($gamefirst_servertime-$timezoneoffset-3600);

    $query = $con->query("SELECT date_finished,server_time FROM game WHERE id='$pgamelast' LIMIT 1;");
    $result = $query->fetch_object();
    $gamelast_time = $result->date_finished;
    $gamelast_servertime = $result->server_time;
    $gamelast_timeago = timeago2($gamelast_servertime-$timezoneoffset-3600);


    $aliasnames = "";
    $alias = $con->query("SELECT name FROM alias WHERE profile='$pprofile' AND name NOT LIKE '$pname' LIMIT 5");
    if ($alias->num_rows > 0) {
        $aliasnames = "<strong>Aka</strong> ";
        while ($row = $alias->fetch_object()) {
            $aliasnames = $aliasnames."<a href='./?statistics=player&detail=".$row->name."'>".$row->name."</a> ,";
        }
        $aliasnames =  substr($aliasnames,0,-1);
    }


    /**
     * Weapons and Equipments data
     */
    $sql = "SELECT name,SUM(time) AS timeused,SUM(shots) AS shotsfired,SUM(hits) AS shotshit,SUM(teamhits) AS teamhits,SUM(kills) AS kills,SUM(teamkills) AS teamkills,MAX(distance) AS longestkill,(AVG(hits) / AVG(shots)*100) AS accuracy FROM weapon WHERE player IN ($playeridlist) AND name NOT IN(27,28,29,31,32,33) GROUP BY name ORDER BY kills DESC,timeused DESC;";
    $query = $con->query($sql);
    if($query->num_rows <= 0)
    {
    }
    $primaryweapontabledata = "";
    $secondaryweapontabledata = "";
    $tacticalweapontabledata = "";
    $breachingweapontabledata = "";

    $count = 0;
    $weaponsoverallaccuracy = 0;
    $weaponoverallammofired = 0;
    $weaponsoveralllongestkill = 0;
    while($weapon  = $query->fetch_object()) {
        $count++;
        $weaponname = $weapon->name;
        $weapontimeused = $weapon->timeused;
        $weaponshotsfired = $weapon->shotsfired;
        $weaponshotshit = $weapon->shotshit;
        $weaponteamhit = $weapon->teamhits;
        $weaponkills = $weapon->kills;
        $weaponteamkills = $weapon->teamkills;
        $weaponlongestkill = $weapon->longestkill;
        $weaponaccuracy = $weapon->accuracy;
        $weaponaccuracy = $weaponaccuracy == null ? 0 : $weaponaccuracy;
        $weaponfriendlyname = GetElemfromId($weaponname, 'W');
        $weapontimeusedinHM = formatHM($weapontimeused);
        $weaponaccuracy = round($weaponaccuracy, 2);

        $weaponkillspermin = $weapontimeused == 0 ? 0 : round($weaponkills / ($weapontimeused/60),2);
        $weaponshotspermin = $weapontimeused == 0 ? 0 : round($weaponshotsfired / ($weapontimeused/60),2);
        $weaponsoverallaccuracy = $weaponsoverallaccuracy + $weaponaccuracy;

        $weaponoverallammofired = $weaponoverallammofired + $weaponshotsfired;
        $weaponsoveralllongestkill = $weaponlongestkill >= $weaponsoveralllongestkill ? $weaponlongestkill : $weaponsoveralllongestkill;

        // Primary Weapon Table
        if (in_array($weaponname,array(1,2,4,5,6,7,8,9,10,11,12)))
        {
            $primaryweapontabledata = $primaryweapontabledata . <<<_HTML
<tr>
<th class="col-md-2"><img class="weapontableimg" src="images/game/weapons/64/item$weaponname.jpg">
<p class='no-margin padding5'>$weaponfriendlyname</p></th>
<th class="col-md-1">$weaponkills</th>
<th class="col-md-1">$weapontimeusedinHM</th>
<th class="col-md-1">$weaponkillspermin</th>
<th class="col-md-1">$weaponaccuracy%</th>
</tr>
_HTML;
        }
        // Secondary Weapon Table
        elseif(in_array($weaponname,array(13,14,15,16,17)))
        {
            $secondaryweapontabledata = $secondaryweapontabledata . <<<_HTML
<tr>
<th class="col-md-2"><img class="weapontableimg" src="images/game/weapons/64/item$weaponname.jpg">
<p class='no-margin padding5'>$weaponfriendlyname</p></th>
<th class="col-md-1">$weaponkills</th>
<th class="col-md-1">$weapontimeusedinHM</th>
<th class="col-md-1">$weaponkillspermin</th>
<th class="col-md-1">$weaponaccuracy%</th>
</tr>
_HTML;
        }

        // Tactical Equipments Table.
        elseif(in_array($weaponname,array(18,23,24,45,25,26)))
        {
            $tacticalweapontabledata = $tacticalweapontabledata . <<<_HTML
<tr>
<th class="col-md-2"><img class="weapontableimg" src="images/game/weapons/64/item$weaponname.jpg">
<p class='no-margin padding5'>$weaponfriendlyname</p></th>
<th class="col-md-1">$weaponshotsfired</th>
<th class="col-md-1">$weapontimeusedinHM</th>
<th class="col-md-1">$weaponshotspermin</th>
<th class="col-md-1">$weaponaccuracy%</th>
_HTML;
        }

        // Breaching Weapons Table Data
        elseif(in_array($weaponname,array(3,30)))
        {
            $breachingweapontabledata = $breachingweapontabledata . <<<_HTML
<tr>
<th class="col-md-2"><img class="weapontableimg" src="images/game/weapons/64/item$weaponname.jpg">
<p class='no-margin padding5'>$weaponfriendlyname</p></th>
<th class="col-md-1">$weaponkills</th>
<th class="col-md-1">$weapontimeusedinHM</th>
<th class="col-md-1">$weaponkillspermin</th>
<th class="col-md-1">$weaponaccuracy%</th>
_HTML;
        }
    }
	
//Checking IF this Player has a linked Profile or Not :)
$sq = "SELECT id,xfire_id,username FROM user WHERE linked_playeroverall_name LIKE '$playerid' LIMIT 1;";
$quer = $con->query($sq);
if($quer->num_rows <= 0)
{
	$linkedprofile = NULL;
}
else
{
	$resul = $quer->fetch_object();
	$profileUsername = $resul->username;
	$xfire_id = $resul->xfire_id;
	if($xfire_id == '' || $xfire_id == NULL || empty($xfire_id))
	{
		$linkedprofile = "<a href='./?userprofile=$profileUsername'><img data-toggle='tooltip' data-placement='top' title='Belongs to $profileUsername' class='img-thumbnail' src='images/css/profilepic.jpg' style='width:60px;height:60px'></a>";
	}
else
{
    if(isImage2("http://screenshot.xfire.com/avatar/160/$xfire_id.jpg"))
    {
		$linkedprofile = "<a href='./?userprofile=$profileUsername'><img data-toggle='tooltip' data-placement='top' title='Belongs to $profileUsername' class='img-thumbnail' src='http://screenshot.xfire.com/avatar/160/$xfire_id.jpg' style='width:60px;height:60px'></a>";
    }
    else
    {
        $linkedprofile = "<a href='./?userprofile=$profileUsername'><img data-toggle='tooltip' data-placement='top' title='Belongs to $profileUsername' class='img-thumbnail' src='images/css/profilepic.jpg' style='width:60px;height:60px'></a>";
    }
}
}
    ?>
    <!-- ROW CONTENTS 1 (Name,Country) -->
    <div class="well well-sm row no-margin">
        <div class="col-md-10 margin10">
				<div class="col-md-4 no-padding">
		   <img class="left img-thumbnail" src="images/game/chars/50/<?=$teambodyhead?>.jpg"
                 style="margin-right: 10px">
			<?=$linkedprofile?>
			</div>
			<div class="col-md-8 no-padding">
            <h3 class="no-margin text-center" style="color: #dd5000;font-family: fantasy"><?=$pname?></h3>

            <p class="text-center" style="margin-top: 10px;color: #204d74"><i><?=$aliasnames?></i></p>
			</div>
        </div>
        <img data-toggle="tooltip" data-placement="right" title="<?=$pcountryname?>" src="images/flags_new/flags-iso/shiny/64/<?=$pcountryiso?>.png">
    </div>
    <!-- / ROW CONTENTS 1 ENDS -->

    <!-- ROW CONTENTS 2 (Stats,Loadout,Rank,Gauge)-->
    <div class="well" style="margin-top: 10px !important;">


        <!-- RANK List -->
        <div class="row no-margin border-bottom-dashed">
            <?=$rankrowdata?>
        </div>


        <div class="row no-margin">
            <div class="col-md-5 padding10" style="background-color: #ffffff;margin-top: 5px;border: 1px solid">

                <!-- LoadOut -->
                <h5 class="no-margin"
                    style="border-bottom: 2px dashed gray;margin-bottom: 10px !important;color: #2D2D2D;font-weight: bold;">
                    Favorite Loadout</h5>

                <div class="col-md-12 no-padding" style="border: 1px solid;margin-bottom: 10px !important;">
                    <img data-toggle="tooltip" title="<?=$primaryweaponammo_name?>" class="" src="images/game/weapons/128/item<?=$primaryweapon?>.jpg"
                         style="width: 100%;height: 117px">

                    <p class="text-center" style="color: #204d74;margin-top: 5px;"><strong><?=$primaryweapon_name?></strong></p>
                </div>
                <div class="col-md-12 no-padding" style="border: 1px solid;margin-bottom: 10px !important;">
                    <img data-toggle="tooltip" title="<?=$secondaryweaponammo_name?>" class="" src="images/game/weapons/128/item<?=$secondaryweapon?>.jpg"
                         style="width: 100%;height: 117px">

                    <p class="text-center" style="color: #204d74;margin-top: 5px;"><strong><?=$secondaryweapon_name?></strong></p>
                </div>

                <div class="col-md-12 no-padding" style="border: 1px solid;margin-bottom: 10px !important;">
                    <div class="col-md-4 no-padding"><img data-toggle="tooltip" title="<?=$equipment1_name?>" class=""
                                                          src="images/game/weapons/64/item<?=$equipment1?>.jpg"
                                                          style="width: 100%;"></div>
                    <div class="col-md-4 no-padding"><img data-toggle="tooltip" class="" title="<?=$equipment2_name?>"
                                                          src="images/game/weapons/64/item<?=$equipment2?>.jpg"
                                                          style="width: 100%;"></div>
                    <div class="col-md-4 no-padding"><img data-toggle="tooltip" class="" title="<?=$equipment3_name?>"
                                                          src="images/game/weapons/64/item<?=$equipment3?>.jpg"
                                                          style="width: 100%;"></div>
                    <div class="col-md-4 no-padding"><img data-toggle="tooltip" class="" title="<?=$equipment4_name?>"
                                                          src="images/game/weapons/64/item<?=$equipment4?>.jpg"
                                                          style="width: 100%;"></div>
                    <div class="col-md-4 no-padding"><img data-toggle="tooltip" class="" title="<?=$equipment5_name?>"
                                                          src="images/game/weapons/64/item<?=$equipment5?>.jpg"
                                                          style="width: 100%;"></div>
                    <div class="col-md-4 no-padding"><img data-toggle="tooltip" class="" title="<?=$breacher_name?>"
                                                          src="images/game/weapons/64/item<?=$breacher?>.jpg"
                                                          style="width: 100%;"></div>
                    <p class="text-center"
                       style="color: #204d74;margin-top: 5px;width: 100%;float: left;text-align: center;"><strong>Equipments</strong>
                    </p>
                </div>

                <div class="col-md-12 no-padding" style="margin-bottom: 8px !important">
                    <div class="col-md-5 no-padding" style="border: 1px solid;"><img data-toggle="tooltip" class="" title="<?=$headload_name?>"
                                                                                     src="images/game/weapons/128/item<?=$headload?>.jpg"
                                                                                     style="width: 100%;">

                        <p class="text-center" style="color: #204d74;margin-top: 5px;"><strong><?=$headload_name?></strong></p></div>
                    <div class="col-md-5 right no-padding" style="border: 1px solid"><img data-toggle="tooltip" class="" title="<?=$bodyarmor_name?>"
                                                                                          src="images/game/weapons/128/item<?=$bodyarmor?>.jpg"
                                                                                          style="width: 100%;">

                        <p class="text-center" style="color: #204d74;margin-top: 5px;"><strong><?=$bodyarmor_name?></strong></p>
                    </div>
                </div>

            </div>


            <!--/LoadOut Ends-->

            <!-- General Statistics -->
            <div class="col-md-7 right padding10"
                 style="width: 57% !important;background-color: #ffffff;margin-top: 5px;border: 1px solid;">
                <h5 class="no-margin"
                    style="border-bottom: 2px dashed gray;margin-bottom: 10px !important;color: #2D2D2D;font-weight: bold;">
                    General Statistics</h5>

                <table class="table table-striped table-condensed borderless no-margin">
                    <tbody>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Position
                        </td>
                        <td class="col-6 text-right" style="color:#058700"><strong><?=$pposition?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-1">
                        </td>
                        <td class="col-2">
                            Score Earned
                        </td>
                        <td class="col-3 text-right">
                            <strong><?=$pscoretotal?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Total Points
                        </td>
                        <td class="col-6 text-right"><strong><?=$ppointstotal?></strong>
                        </td>
                    </tr>
					
					<tr>
                        <td class="col-1">
                        </td>
                        <td class="col-2">
                            Rating (0-10)
                        </td>
                        <td class="col-3 text-right">
                            <strong><?=$prating?></strong>
                        </td>
                    </tr>

                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Rank
                        </td>
                        <td class="col-6 text-right"><strong><?=$rankname?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Games Played
                        </td>
                        <td class="col-6 text-right"><strong><?=$ptotalroundplayed?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-1">
                        </td>
                        <td class="col-2">
                            Time Played
                        </td>
                        <td class="col-3 text-right">
                            <strong><?=$timeplayedinHM?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-1">
                        </td>
                        <td class="col-2">
                            Score / Round
                        </td>
                        <td class="col-3 text-right">
                            <strong><?=$pscoreperround?></strong>
                        </td>
                    </tr>
					
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Kills
                        </td>
                        <td class="col-6 text-right"><strong><?=$pkillstotal?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Deaths
                        </td>
                        <td class="col-6 text-right"><strong><?=$pdeathstotal?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Arrests
                        </td>
                        <td class="col-6 text-right"><strong><?=$parreststotal?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Times Arrested
                        </td>
                        <td class="col-6 text-right"><strong><?=$parrestedtotal?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Team Kills
                        </td>
                        <td class="col-6 text-right"><strong><?=$pteamkillstotal?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Highest Score
                        </td>
                        <td class="col-6 text-right"><strong><?=$phighestscore?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Best Kill Streak
                        </td>
                        <td class="col-6 text-right"><strong><?=$pbestkillstreak?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Best Arrest Streak
                        </td>
                        <td class="col-6 text-right"><strong><?=$pbestarreststreak?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Best Death Streak
                        </td>
                        <td class="col-6 text-right"><strong><?=$pbestdeathstreak?></strong>
                        </td>
                    </tr>

                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Ammo Fired
                        </td>
                        <td class="col-6 text-right"><strong><?=$weaponoverallammofired?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Accuracy
                        </td>
                        <td class="col-6 text-right"><strong><?=round($weaponsoverallaccuracy/$count,2)?>%</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Longest Kill
                        </td>
                        <td class="col-6 text-right"><strong><?=round($weaponsoveralllongestkill/100,2)?>m</strong>
                        </td>
                    </tr>

                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            First Seen
                        </td>
                        <td class="col-6 text-right"><strong><a class="ainorange" href="./?statistics=round&detail=<?=$pgamefirst?>"><?=$gamefirst_timeago?></a></strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4">
                        </td>
                        <td class="col-5">
                            Last Seen
                        </td>
                        <td class="col-6 text-right"><strong><a class="ainorange" href="./?statistics=round&detail=<?=$pgamelast?>"><?=$gamelast_timeago?></a></strong>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <!-- / General Stats Ends -->



            <!-- Gauge Statistics -->
            <div class="col-md-7 right padding10" style="width: 57% !important;background-color: #ffffff;margin-top: 5px;border: 1px solid;">
                <div class="col-md-4 no-margin no-padding">
                    <p class="no-margin text-center gaugeheading">Score / Min</p>
                    <canvas id="gauge-spm" style="width: 10em" data-spm="<?=$pscorepermin?>"></canvas>
                    <h4 class="font-dsdigital no-margin text-center"><?=$pscorepermin?></h4>
                </div>
                <div class="col-md-4 no-margin no-padding">
                    <p class="no-margin text-center gaugeheading">Kill / Death</p>
                    <canvas id="gauge-kdr" style="width: 10em" data-kdr="<?=$pkdratio?>"></canvas>
                    <h4 class="font-dsdigital no-margin text-center"><?=$pkdratio?></h4>
                </div>

                <div class="col-md-4 no-margin no-padding">
                    <p class="no-margin text-center gaugeheading">Arrest / Arrested</p>
                    <canvas id="gauge-aar" style="width: 10em" data-aar="<?=$paaratio?>"></canvas>
                    <h4 class="font-dsdigital no-margin text-center"><?=$paaratio?></h4>
                </div>
            </div>
            <!-- / Gauge Stats Ends -->

        </div>

    </div>
    <!-- / ROW CONTENTS 2 ENDS -->

    <!-- ROW CONTENTS 3 STARTS (Weapons,Equpiments) -->
    <div class="well" style="margin-top: -10px !important;">

        <h5 style="padding-bottom: 5px;border-bottom: 2px dashed gray;color: #050505"><strong>Weapons & Equipments</strong></h5>
        <!--Tab Starts-->
        <div role="tabpanel" style="margin-top: 10px">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a class="ainorange" href="#primaryweapon" aria-controls="primaryweapon" role="tab" data-toggle="tab">Primary Weapon</a></li>
                <li role="presentation"><a class="ainorange" href="#secondaryweapon" aria-controls="secondaryweapon" role="tab" data-toggle="tab">Secondary Weapon</a></li>
                <li role="presentation"><a class="ainorange" href="#tactical" aria-controls="tactical" role="tab" data-toggle="tab">Tactical</a></li>
                <li role="presentation"><a class="ainorange" href="#breaching" aria-controls="breaching" role="tab" data-toggle="tab">Breaching</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content" style="background-color: #ffffff;border-left: 1px solid #ddd;border-bottom: 1px solid #ddd;border-right: 1px solid #ddd;">
                <div role="tabpanel" class="tab-pane active" id="primaryweapon">
                    <table class="table table-bordered commontable weapontable">
                        <tr>
                            <td>Weapon</td>
                            <td>Kills</td>
                            <td>Time Used</td>
                            <td>Kills / Min</td>
                            <td class="text-right">Accuracy</td>
                        </tr>
                        <?=$primaryweapontabledata?>
                    </table>
                </div>

                <div role="tabpanel" class="tab-pane" id="secondaryweapon">
                    <table class="table table-bordered commontable weapontable">
                        <tr>
                            <td>Weapon</td>
                            <td>Kills</td>
                            <td>Time Used</td>
                            <td>Kills / Min</td>
                            <td class="text-right">Accuracy</td>
                        </tr>
                        <?=$secondaryweapontabledata?>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane" id="tactical">
                    <table class="table table-bordered commontable weapontable">
                        <tr>
                            <td>Weapon</td>
                            <td>Stuns</td>
                            <td>Time Used</td>
                            <td>Stuns / Min</td>
                            <td class="text-right">Accuracy</td>
                        </tr>
                        <?=$tacticalweapontabledata?>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane" id="breaching">
                    <table class="table table-bordered commontable weapontable">
                        <tr>
                            <td>Weapon</td>
                            <td>Kills</td>
                            <td>Time Used</td>
                            <td>Kills / Min</td>
                            <td class="text-right">Accuracy</td>
                        </tr>
                        <?=$breachingweapontabledata?>
                    </table>
                </div>
            </div>

        </div>
        <!--/Tab Ends-->
    </div>
<?php
}
?>