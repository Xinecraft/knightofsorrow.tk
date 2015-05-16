<?php
/**
 * Created by PhpStorm.
 * User: Kinnngg
 * Date: 27-02-2015
 * Time: 20:59
 */

require_once('../conf.php');
ini_set('display_errors', 1);
error_reporting(E_ERROR);
include_once('magicquotesgpc.php');
include_once('ip2locationlite.class.php');
include_once('generate_option.php');
include_once('imp_func_inc.php');
global $con;

$playerid = $con->escape_string($_GET['playerid']);

$sql = "SELECT p.*,po.id as poid FROM player p,playeroverall po WHERE p.id='$playerid' AND p.alias=po.alias LIMIT 1;";

$query = $con->query($sql);

if($query->num_rows <= 0)
{
    echo "No Data with this Id";
    return;
}
else
{
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

    $scorepermin = round($totalscore / $timeplayed * 60 , 2);
    $timeplayed = secondtoMS($timeplayed);
    $countryname = country_code_to_country($result->country);
    $countryiso = $result->country;
    echo <<<_HTML
<!-- Player Individual Data Starts -->
<div class="panel panel-primary col-md-12 no-padding">
    <!-- Default panel contents -->
    <div class="panel-heading"><a class='ahrefwhite' href='./?statistics=player&detail=$result->name'><b>$result->name</a></b><img class='right' title='$countryname' src='images/flags/20/$countryiso.png'></div>

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