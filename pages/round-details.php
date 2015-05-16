<?php
/**
 * Created by PhpStorm.
 * User: Kinnngg
 * Date: 23-02-2015
 * Time: 01:24
 *
 */
if(!isset($_GET['detail']) || $_GET['detail']=='')
    header("Location: ./?statistics");

$roundId = $con->escape_string($_GET['detail']);

$sql = "SELECT * FROM game WHERE id=$roundId LIMIT 1";
$query = $con->query($sql);
if($query->num_rows <= 0)
{
    echo("<h4 class='well'>No Round Data Found</h4>");
    return;
}
global $timezoneoffset;
$round = $query->fetch_object();
$tag = $round->tag;
$server_time = $round->server_time;
$round_time = $round->round_time;
$game_type = $round->gametype;
$outcome = $round->outcome;
$mapname = $round->mapname;
$player_num = $round->player_num;
$swat_score = $round->score_swat;
$suspects_score = $round->score_sus;
$date_finished = $round->date_finished;
$server_timeago = timeago2($server_time-$timezoneoffset-3600);


if($outcome == 2)
{
    $colorcodesus = "greenyellow";
    $colorcodeswat = "red";
}
else if($outcome == 1)
{
    $colorcodesus = "red";
    $colorcodeswat = "greenyellow";
}
else
{
    $colorcodesus = "white";
    $colorcodeswat = "white";
}
$secMS = secondtoMS($round_time);

$roundMin = round($round_time/60);
$roundSec = round($round_time%60);

$playersql = "SELECT * FROM `player` WHERE game=$roundId ORDER BY score DESC;";
$players = $con->query($playersql);

$suspects_table = "";
$swat_table = "";
$i = 1;
while($player = $players->fetch_object())
{
    // If player is SWAT
    if($player->team == 0)
    {
        $swat_table = $swat_table."<tr class='getindistats' data-id='$player->id'><th scope='row'>$i</th><td>
        <img data-toggle='tooltip' data-placement='top' title='".country_code_to_country($player->country)."' src='images/flags/20_shiny/$player->country.png'></td><td>[]</td><td>$player->name</td><td class='text-right'>$player->score</td></tr>";
    }
    else
    {
        $suspects_table = $suspects_table."<tr class='getindistats' data-id='$player->id'><th scope='row'>$i</th><td>
        <img data-toggle='tooltip' data-placement='top' title='".country_code_to_country($player->country)."' src='images/flags/20_shiny/$player->country.png'></td><td>[]</td><td>$player->name</td><td class='text-right'>$player->score</td></tr>";
    }
    $i++;
}


/**
 * Getting the ROUND Stats Data
 */

// Most Kills
$sql = "SELECT p.*,po.id as poid FROM player p,playeroverall po WHERE game='$roundId' AND p.alias=po.alias ORDER BY kills DESC LIMIT 1";
$query = $con->query($sql);
$object = $query->fetch_object();
$mostkills = $object->kills;
$mostkillername = $object->name;
$playerteam = $object->team;
$playerloadout = $object->loadout;
$mostkillerpoid = $object->poid;


$sql = "SELECT head,body FROM loadout WHERE id='$playerloadout' LIMIT 1;";
$query = $con->query($sql);
$object = $query->fetch_object();
$body = $object->body;
$head = $object->head;
$killeravatarimg = $playerteam."_".$body."_".$head.".jpg";

if($playerteam == 1)
{
    $mostkillcolor = "#ff0000";
}
else if($playerteam == 0)
{
    $mostkillcolor = "#0000ff";
}
else
{
    $mostkillcolor = "#00ff00";
}

// Most Arrests
$sql = "SELECT p.*,po.id as poid FROM player p,playeroverall po WHERE game='$roundId' AND p.alias=po.alias ORDER BY arrests DESC LIMIT 1;";
$query = $con->query($sql);
$object = $query->fetch_object();
$mostarrests = $object->arrests;
$mostarrestsname = $object->name;
$playerteam = $object->team;
$playerloadout = $object->loadout;
$mostarrestspoid = $object->poid;

$sql = "SELECT head,body FROM loadout WHERE id='$playerloadout' LIMIT 1;";
$query = $con->query($sql);
$object = $query->fetch_object();
$body = $object->body;
$head = $object->head;
$arresteravatarimg = $playerteam."_".$body."_".$head.".jpg";

if($playerteam == 1)
{
    $mostarrestscolor = "#ff0000";
}
else if($playerteam == 0)
{
    $mostarrestscolor = "#0000ff";
}
else
{
    $mostarrestscolor = "#00ff00";
}

// Top Score
$sql = "SELECT p.*,po.id as poid FROM player p,playeroverall po WHERE game='$roundId' AND p.alias=po.alias ORDER BY score DESC LIMIT 1;";
$query = $con->query($sql);
$object = $query->fetch_object();
$topscore = $object->score;
$topscorerid = $object->id;
$topscorer = $object->name;
$playerteam = $object->team;
$playerloadout = $object->loadout;
$topscorerpoid = $object->poid;

$sql = "SELECT head,body FROM loadout WHERE id='$playerloadout' LIMIT 1;";
$query = $con->query($sql);
$object = $query->fetch_object();
$body = $object->body;
$head = $object->head;
$scorreravatarimg = $playerteam."_".$body."_".$head.".jpg";

if($playerteam == 1)
{
    $topscorercolor = "#ff0000";
}
else if($playerteam == 0)
{
    $topscorercolor = "#0000ff";
}
else
{
    $topscorercolor = "#00ff00";
}

// Score / Min
$sql = "SELECT p.*,po.id as poid,(p.score/p.time) AS scoremin FROM player p,playeroverall po WHERE game='$roundId' AND p.alias=po.alias ORDER BY (score/time) DESC LIMIT 1;";
$query = $con->query($sql);
$object = $query->fetch_object();
$bestscoremin = $object->scoremin;
$bestscoreminname = $object->name;
$playerteam = $object->team;
$playerloadout = $object->loadout;
$bestscoreminpoid = $object->poid;

$sql = "SELECT head,body FROM loadout WHERE id='$playerloadout' LIMIT 1;";
$query = $con->query($sql);
$object = $query->fetch_object();
$body = $object->body;
$head = $object->head;
$scoreminavatarimg = $playerteam."_".$body."_".$head.".jpg";

if($playerteam == 1)
{
    $bestscoremincolor = "#ff0000";
}
else if($playerteam == 0)
{
    $bestscoremincolor = "#0000ff";
}
else
{
    $bestscoremincolor = "#00ff00";
}

// BEST ARREST STREAK
$sql = "SELECT p.*,po.id as poid FROM player p,playeroverall po WHERE game='$roundId' AND p.alias=po.alias ORDER BY arrest_streak DESC LIMIT 1;";
$query = $con->query($sql);
$object = $query->fetch_object();
$bestarreststreak = $object->arrest_streak;
$bestarreststreakname = $object->name;
$playerteam = $object->team;
$playerloadout = $object->loadout;
$bestarreststreakpoid = $object->poid;

$sql = "SELECT head,body FROM loadout WHERE id='$playerloadout' LIMIT 1;";
$query = $con->query($sql);
$object = $query->fetch_object();
$body = $object->body;
$head = $object->head;
$arreststreakavatarimg = $playerteam."_".$body."_".$head.".jpg";

if($playerteam == 1)
{
    $bestarreststreakcolor = "#ff0000";
}
else if($playerteam == 0)
{
    $bestarreststreakcolor = "#0000ff";
}
else
{
    $bestarreststreakcolor = "#00ff00";
}


// BEST KILL STREAK
$sql = "SELECT p.*,po.id as poid FROM player p,playeroverall po WHERE game='$roundId' AND p.alias=po.alias ORDER BY kill_streak DESC LIMIT 1;";
$query = $con->query($sql);
$object = $query->fetch_object();
$bestkillstreak = $object->kill_streak;
$bestkillstreakname = $object->name;
$playerteam = $object->team;
$playerloadout = $object->loadout;
$bestkillstreakpoid = $object->poid;

$sql = "SELECT head,body FROM loadout WHERE id='$playerloadout' LIMIT 1;";
$query = $con->query($sql);
$object = $query->fetch_object();
$body = $object->body;
$head = $object->head;
$killstreakavatarimg = $playerteam."_".$body."_".$head.".jpg";

if($playerteam == 1)
{
    $bestkillstreakcolor = "#ff0000";
}
else if($playerteam == 0)
{
    $bestkillstreakcolor = "#0000ff";
}
else
{
    $bestkillstreakcolor = "#00ff00";
}


/**
 * User Individual Data Loading function.
 *
 */

function gettopscorerindidata()
{
    global $con,$topscorerid;
    $sql = "SELECT p.*,po.id as poid FROM player p,playeroverall po WHERE p.id='$topscorerid' AND p.alias=po.alias LIMIT 1;";

    $query = $con->query($sql);

    if ($query->num_rows <= 0) {
        echo "No Data with this Id";
        return;
    } else {
        $result = $query->fetch_object();
        $kills = $result->kills;
        $deaths = $result->deaths;
        $kdratio = $deaths != 0 ? round($kills / $deaths, 2):round($kills / 1, 2);
        $teamkills = $result->teamkills;
        $killstreak = $result->kill_streak;
        $arrests = $result->arrests;
        $arrested = $result->arrested;
        $arreststreak = $result->arrest_streak;
        $aaratio = $arrested !=0 ? round($arrests / $arrested, 2):round($arrests / 1, 2);
        $deathstreak = $result->death_streak;
        $timeplayed = $result->time;
        $totalscore = $result->score;
        $poid = $result->poid;

        $scorepermin = round($totalscore / $timeplayed * 60, 2);
        $timeplayed = secondtoMS($timeplayed);
        $countryname = country_code_to_country($result->country);
        $countryiso = $result->country;
        $data = <<<_HTML
<!-- Player Individual Data Starts -->
<div class="panel panel-primary col-md-12 no-padding">
    <!-- Default panel contents -->
    <div class="panel-heading"><b><a class='ahrefwhite' href='./?statistics=player&detail=$result->name'>$result->name</a></b><img class='right' title='$countryname' src='images/flags/20/$countryiso.png'></div>

    <!-- list -->
    <ul class="list-group col-md-4">
        <li class="list-group-item">
            <span class="badge">$kills</span>
            Kills
        </li>
        <li class="list-group-item">
            <span class="badge">$deaths</span>
            Deaths
        </li>
        <li class="list-group-item">
            <span class="badge">$kdratio</span>
            Kill / Death Ratio
        </li>
        <li class="list-group-item">
            <span class="badge">$teamkills</span>
            TeamKills
        </li>
        <li class="list-group-item">
            <span class="badge">$killstreak</span>
            Highest Killstreak
        </li>
    </ul>

    <ul class="list-group col-md-4">
        <li class="list-group-item">
            <span class="badge">$arrests</span>
            Arrests
        </li>
        <li class="list-group-item">
            <span class="badge">$arrested</span>
            Arrested
        </li>
        <li class="list-group-item">
            <span class="badge">$aaratio</span>
            Arrests / Arrested Ratio
        </li>
        <li class="list-group-item">
            <span class="badge">$arreststreak</span>
            Highest Arreststreak
        </li>
        <li class="list-group-item">
            <span class="badge">$deathstreak</span>
            Highest Deathstreak
        </li>
    </ul>

    <ul class="list-group col-md-4">
        <li class="list-group-item">
            <span class="badge">$timeplayed</span>
            Time Played
        </li>
        <li class="list-group-item">
            <span class="badge">$scorepermin</span>
            Score / Min
        </li>
        <li class="list-group-item">
            <span class="badge">$totalscore</span>
            Total Score
        </li>
    </ul>

</div>
_HTML;
    }
    return $data;
}

?>
<div class="jumbotron" style="background-image: url('images/game/maps/background-small/<?=$mapname?>.jpg');background-size: cover;border: 1px solid">
    <p class="text-center" style="font-size: 25px; font-family:'DS-Digital';color: #ff0000;float: left;margin-top: -40px;margin-left: -35px;"><span style="color: #ffffff">Round Time:</span> <?=$roundMin.":".$roundSec?></p>
    <h3 class="text-center" style="text-shadow: 1px 1px 1px #000;font-family: fantasy; color: rgb(254, 233, 12)"><?=GetElemfromId($mapname,'M')?></h3>
    <h2 class="left" style="margin-right: 150px;margin-top: 10px"><kbd style="color:<?=$colorcodeswat?>" class="teamscoreviewds padding10">SWAT: <?=$swat_score?></code></h2>
    <h2><kbd style="color:<?=$colorcodesus?>" class="teamscoreviewds padding10">SUSPECTS: <?=$suspects_score?></code></h2>
    <br>
</div>


<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">

            <div class="col-md-4">
                <h5 style="color: #000000"><b>Top Score</b></h5>
                <img class="left img-thumbnail" src="images/game/chars/50/<?=$scorreravatarimg?>">
                <div class="col-md-8" style="padding-left: 0px">
                    <p><a href="./?statistics=player&detail=<?=urlencode($topscorer)?>" style="margin-left: 10px;color: <?=$topscorercolor?>"><b><?=$topscorer?></b></a></p>
                    <p class="left" style="margin-left: 10px;color: <?=$topscorercolor?>"><?=$topscore?> points</p>
                </div>
            </div>

            <div class="col-md-4">
                <h5 style="color: #000000"><b>Mass Arrester</b></h5>
                <img class="left img-thumbnail" src="images/game/chars/50/<?=$arresteravatarimg?>">
                <div class="col-md-8" style="padding-left: 0px">
                    <p><a href="./?statistics=player&detail=<?=urlencode($mostarrestsname)?>" style="margin-left: 10px;color: <?=$mostarrestscolor?>"><b><?=$mostarrestsname?></b></a></p>
                    <p class="left" style="margin-left: 10px;color: <?=$mostarrestscolor?>"><?=$mostarrests?> Arrests</p>
                </div>

            </div>

            <div class="col-md-4">
                <h5 style="color: #000000"><b>Kill Machine</b></h5>
                <img class="left img-thumbnail" src="images/game/chars/50/<?=$killeravatarimg?>">
                <div class="col-md-8" style="padding-left: 0px">
                    <p><a href="./?statistics=player&detail=<?=urlencode($mostkillername)?>" style="margin-left: 10px;color: <?=$mostkillcolor?>"><b><?=$mostkillername?></b></a></p>
                    <p class="left" style="margin-left: 10px;color: <?=$mostkillcolor?>"><?=$mostkills?> Kills</p>
                </div>
            </div>

        </div>
        <br>
        <div class="row">

            <div class="col-md-4">
                <h5 style="color: #000000"><b>Most Score / Min</b></h5>
                <img class="left img-thumbnail" src="images/game/chars/50/<?=$scoreminavatarimg?>">
                <div class="col-md-8" style="padding-left: 0px">
                    <p><a href="./?statistics=player&detail=<?=urlencode($bestscoreminname)?>" style="margin-left: 10px;color: <?=$bestscoremincolor?>"><b><?=$bestscoreminname?></b></a></p>
                    <p class="left" style="margin-left: 10px;color: <?=$bestscoremincolor?>"><?=$bestscoremin*60?> score / min</p>
                </div>
            </div>

            <div class="col-md-4">
                <h5 style="color: #000000"><b>Highest Arrest Streak</b></h5>
                <img class="left img-thumbnail" src="images/game/chars/50/<?=$arreststreakavatarimg?>">
                <div class="col-md-8" style="padding-left: 0px">
                    <p><a href="./?statistics=player&detail=<?=urlencode($bestarreststreakname)?>" style="margin-left: 10px;color: <?=$bestarreststreakcolor?>"><b><?=$bestarreststreakname?></b></a></p>
                    <p class="left" style="margin-left: 10px;color: <?=$bestarreststreakcolor?>"><?=$bestarreststreak?> arrest in a row</p>
                </div>
            </div>

            <div class="col-md-4">
                <h5 style="color: #000000"><b>Highest Kill Streak</b></h5>
                <img class="left img-thumbnail" src="images/game/chars/50/<?=$killstreakavatarimg?>">
                <div class="col-md-8" style="padding-left: 0px">
                    <p><a href="./?statistics=player&detail=<?=urlencode($bestkillstreakname)?>" style="margin-left: 10px;color: <?=$bestkillstreakcolor?>"><b><?=$bestkillstreakname?></b></a></p>
                    <p class="left" style="margin-left: 10px;color: <?=$bestkillstreakcolor?>"><?=$bestkillstreak?> Kill in a row</p>
                </div>
            </div>

        </div>


    </div>
</div>

<div class="row no-margin no-padding" style="color: #000">

    <!-- PANEL STARTS-->
    <div class="panel panel-info col-md-5 no-padding" style="width: 49%; margin-right: 13px;">
        <!-- Default panel contents -->
        <div class="panel-heading"><b>SWAT</b></div>

        <!-- Table -->
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>F</th>
                <th>R</th>
                <th>Name</th>
                <th class="text-right">Score</th>
            </tr>
            </thead>
            <tbody class="font-size-14">

            <?=$swat_table?>

            </tbody>

        </table>
    </div>
    <!--Panel Ends -->


    <!-- PANEL STARTS-->
    <div class="panel panel-danger col-md-5 no-padding" style="width: 49%">
        <!-- Default panel contents -->
        <div class="panel-heading"><b>SUSPECTS</b></div>

        <!-- Table -->
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>F</th>
                <th>R</th>
                <th>Name</th>
                <th class="text-right">Score</th>
            </tr>
            </thead>
            <tbody class="font-size-14">

            <?=$suspects_table?>

            </tbody>
        </table>
    </div>
    <!--Panel Ends -->

</div> <!--Row ENDS -->


<!-- Player Individual Data Starts -->
<div id="indiplayerstats">
    <?=gettopscorerindidata()?>
</div>