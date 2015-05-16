<?php
/**
 * Created by PhpStorm.
 * User: Kinnngg
 * Date: 28-02-2015
 * Time: 14:38
 */

require_once('../conf.php');
ini_set('display_errors', 1);
error_reporting(E_ERROR);
include_once('magicquotesgpc.php');
include_once('ip2locationlite.class.php');
include_once('generate_option.php');
include_once('imp_func_inc.php');
global $con;

//TRUNCATE THE playeroverall TABLE;
$q = $con->query("TRUNCATE playeroverall");

$sql = "SELECT SUM(score) AS scoretotal FROM player;";
$query = $con->query($sql);
$row = $query->fetch_object();
$scoreall = $row->scoretotal;


$sql = "SELECT id,country,alias,name,MAX(loadout) AS lastloadout,sum(score) AS score,MAX(score) as highestscore,sum(kills) AS kills,sum(deaths) AS deaths,sum(arrests) AS arrests,sum(arrested) AS arrested,sum(suicides) AS suicides,sum(teamkills) AS teamkills,sum(time) AS timeplayed,MAX(kill_streak) AS killstreak,Max(arrest_streak) AS arreststreak,Max(death_streak) AS deathstreak,COUNT(game) AS roundplayed,Max(admin) AS isadmin,GROUP_CONCAT(id) AS player_ids FROM player GROUP BY name ORDER BY sum(score) DESC,sum(kills) DESC;";
$query = $con->query($sql);

if($query->num_rows <= 0)
{
    echo "No Players in DB";
    return;
}
$playertabledata = '';
$i = 0;
while($data=$query->fetch_object()) {
    $i++;
    $id = $data->id;
    $countryiso = $data->country;
    $alias = $data->alias;
    $name = $data->name;
    $score = $data->score;
    $kills = $data->kills;
    $deaths = $data->deaths;
    $arrests = $data->arrests;
    $arrested = $data->arrested;
    $suicides = $data->suicides;
    $teamkills = $data->teamkills;
    $timeplayed = $data->timeplayed;
    $killstreak = $data->killstreak;
    $arreststreak = $data->arreststreak;
    $deathstreak = $data->deathstreak;
    $roundplayed = $data->roundplayed;
    $isadmin = $data->isadmin;
    $highestscore = $data->highestscore;
    $player_ids = $data->player_ids;
	$player_ids = trim($player_ids,',');
    //$lastloadout = $data->lastloadout;


    $getprofileid = $con->query("SELECT profile FROM alias WHERE id='$alias' LIMIT 1");
    $profileid = $getprofileid->fetch_object();
    $profileid = $profileid->profile;

    $getprofile = $con->query("SELECT * FROM profile WHERE id = '$profileid' LIMIT 1");
    $profilerow = $getprofile->fetch_object();
    $lastteam = $profilerow->team;
    $lastloadout = $profilerow->loadout;
    $gamefirst = $profilerow->game_first;
    $gamelast = $profilerow->game_last;
    $lastip = $profilerow->ip_addr;

    //Kill Death RATIO
    $kdratio = $deaths == 0 ? $kills : round($kills / $deaths, 2);
    $aaratio = $arrested == 0 ? $arrests : round($arrests / $arrested, 2);
    $scorepermin = $timeplayed == 0 ? $score : round($score / $timeplayed * 60, 2);
    $scorepercentile = ($score / $scoreall )*100;
    $scorepercentile = round($scorepercentile,2);

    // Rating is only when you play more than 20 * 60 * 60 secs => 20 hours of Play 
    //$rating = ($kdratio) * pow($scorepermin, 3);
	$rating = $kdratio + $aaratio + $scorepermin *1.3;
    $rating = $rating < 0 || $timeplayed < 20*60*60 ? 0 : round($rating, 2);

    $points = ($kills * 4) + ($arrests * 13) - ($deaths) - ($arrested*3) - ($teamkills*2);
    $points = $points < 0 ? 0 : round($points, 2);

    $ranksql = "SELECT * FROM ranklist WHERE rankpoints >= '$points' ORDER BY rankpoints LIMIT 1";
    $rankquery = $con->query($ranksql);
    $rankdata = $rankquery->fetch_object();
    $rankid = $rankdata->id;

    if($lastloadout == '' || empty($lastloadout) || $lastloadout == NULL)
    {
        $lastloadout = 0;
    }
    if($lastteam == '' || empty($lastteam) || $lastteam == NULL)
    {
        $lastteam = 0;
    }
    if($gamefirst == '' || empty($gamefirst) || $gamefirst == NULL)
    {
        $gamefirst = 0;
    }
    if($gamelast == '' || empty($gamelast) || $gamelast == NULL)
    {
        $gamelast = 0;
    }


    $position = 0;
    $wlratio = 0;
    $accuracy = 0;
    $sql = "INSERT INTO playeroverall(`id`, `playername`, `alias`, `profile`, `countryiso`, `admin`, `scoretotal`,`highestscore`, `timetotal`, `killstotal`, `teamkillstotal`, `deathstotal`, `suicidestotal`, `arreststotal`, `arrestedtotal`, `bestkillstreak`, `bestarreststreak`, `bestdeathstreak`, `pointstotal`, `totalroundplayed`, `rank`, `position`, `achievements`, `lastloadout`, `lastteam`, `gamefirst`, `gamelast`, `winlostratio`, `killdeathratio`, `aaratio`, `accuracy`, `scorepermin`,`scorepercentile`, `rating`,`player_ids`,`last_ip`) VALUES (NULL ,'$name','$alias','$profileid','$countryiso','$isadmin','$score','$highestscore','$timeplayed','$kills','$teamkills','$deaths','$suicides','$arrests','$arrested','$killstreak','$arreststreak','$deathstreak','$points','$roundplayed','$rankid','$position',NULL,'$lastloadout','$lastteam','$gamefirst','$gamelast','$wlratio','$kdratio','$aaratio','$accuracy','$scorepermin','$scorepercentile','$rating','$player_ids','$lastip')";

    $updateplayeroverall = $con->query($sql);

    if (!$updateplayeroverall) {
        die($con->error);
    } else {
        echo "Update SuccessFul<br>";
    }
}

//Update the Position ID
$sql = "SELECT id,position FROM playeroverall ORDER BY pointstotal DESC,scoretotal DESC ";
$query = $con->query($sql);
$rank=0;
while($result = $query->fetch_object())
{
    $rank++;
    $con->query("UPDATE playeroverall SET position = '$rank' WHERE id='$result->id' LIMIT 1;");
}
?>