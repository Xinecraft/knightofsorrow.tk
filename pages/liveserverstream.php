<?php
/**
 * Created by PhpStorm.
 * User: Kinnngg
 * Date: 03-03-2015
 * Time: 02:42
 */
include_once("serverquery_inc.php");

if(!isset($_GET['server']) || $_GET['server']=='' || !is_numeric($_GET['server']))
{
    header("location:./?home");
}

if(isset($_GET['ajax']))
{
    require_once('../conf.php');
    ini_set('display_errors', 1);
    error_reporting(E_ERROR);
    include_once('magicquotesgpc.php');
    include_once('ip2locationlite.class.php');
    include_once('imp_func_inc.php');
    global $con;

    $serverid = $con->escape_string($_GET['server']);
    $sql = "SELECT * FROM server WHERE id='$serverid' LIMIT 1;";
    $query = $con->query($sql);

    if ($query->num_rows <= 0) {
        echo <<<_HTML
    <div id='content'>
    <h1 class='font-dsdigital'>No Server found</h1>
    </div>
_HTML;
        return;
    }

    $server = $query->fetch_object();
    $id = $server->id;
    $servername = $server->hostname;
    $country = $server->country;
    $serverip = $server->ip;
    $joinport = $server->port;
    $gs2port = $server->port_gs2;
    $desc = $server->description;
    $desc = nl2br($desc);
    $rank = $server->rank;
    $queryport = $gs2port ;

    $serverlivedata = json_decode(getserverdetail($serverip, $queryport));
    $hostname = $serverlivedata->hostname;

    if ($hostname != "__offline__") {
        $version = $serverlivedata->patch;
        $map = $serverlivedata->map;
        $gametype = $serverlivedata->gametype;
        $mod = $serverlivedata->mods == 'None' ? 'SWAT4' : 'SWAT4X';
        $playercurr = $serverlivedata->players_current;
        $playermax = $serverlivedata->players_max;
        $players = $playercurr . "/" . $playermax;
        $swatwon = $serverlivedata->swatwon == '-' ? 0 : $serverlivedata->swatwon;
        $suspectswon = $serverlivedata->suspectswon == '-' ? 0 : $serverlivedata->suspectswon;
        $roundtotal = $serverlivedata->numrounds;
        $currentround = $serverlivedata->round;
        $swatscore = $serverlivedata->swatscore == '-' ? 0 : $serverlivedata->swatscore;
        $suspectscore = $serverlivedata->suspectsscore == '-' ? 0 : $serverlivedata->suspectsscore;
        $timeleft = $serverlivedata->timeleft == '-' ? 0 : $serverlivedata->timeleft;
        $nextmap = $serverlivedata->nextmap == '-' ? null : $serverlivedata->nextmap;
        $timeleftinMS = gmdate('i:s', $timeleft);

        switch ($gametype) {
            case "Barricaded Suspects":
                $gametypetext = "The goal is to kill or arrest as many members of the opposite team as possible. Kills are worth 1 points, arrests are worth 5 points.<br><br>The first team to reach the score limit wins. If tbe time limit is reached, the team with the most points at the end of the round wins.";
                break;
            case "VIP Escort":
                $gametypetext = "One player on the SWAT team is randomly chosen to be the VIP. SWAT must escort the VIP to the escape point on the other side of the map. The suspects must capture the VIP. They must then hold him hostage for 2 minutes. SWAT player can use the toolkit to release the VIP. After the two minutes are up, the suspects must assassinate the VIP to win the game.<br><br>SWAT wins if the VIP escapes, or if the suspects kill the VIP before capturing and holding him.";
                break;
            case "Rapid Deployment":
                $gametypetext = "Three to five bombs are randomly spawned in the map. SWAT must use the toolkit to defuse all the bombs before the round ends. The suspects must defend the bombs and prevent them from being disabled. Once all of the bombs are defused SWAT wins. If the round timer expires while a bomb is still active, the suspects win.";
                break;
            case "CO-OP":
                $gametypetext = "Play single player missions with a group of up to five officers.";
                break;
            default:
                $gametypetext = "Custom Game Type.<br>Maybe due to -EXP- or Modified AMMod or MarkMod Custom Gametype.";
                break;
        }

        $playerstabledata = '';
        foreach ($serverlivedata->players as $player) {

            $playername = $player->name;
            $playerscore = $player->score;
            $playerping = $player->ping;
            $playerteam = $player->team;
            $playerkills = $player->kills == '-' ? 0 : $player->kills;
            $playerteamkills = $player->tkills == '-' ? 0 : $player->tkills;
            $playerdeaths = $player->deaths == '-' ? 0 : $player->deaths;
            $playerarrests = $player->arrests == '-' ? 0 : $player->arrests;
            $playerarrested = $player->arrested == '-' ? 0 : $player->arrested;
            //$playerip = $player->ip == '-' ? null : $player->ip;

            //$playerip = explode(":", $playerip);
            //$playerip = $playerip[0];

            $playerstabledata = $playerstabledata . <<<_HTML
        <tr data-id="$id" class="playerteamcolor$playerteam">
                        <td><b></b></td>
                        <td><a class='no-style'>$playername</a></td>
                        <td>$playerscore</td>
                        <td>$playerarrests</td>
                        <td>$playerarrested</td>
                        <td>$playerkills</td>
                        <td>$playerdeaths</td>
                        <td>$playerteamkills</td>
                        <td class="text-right">$playerping</td>
                    </tr>
_HTML;
        }

        echo <<<_HTML

    <div class="panel livestreampanel" style="background-color: #080808;color: #f7f7f7;border: 1px solid;font-family: 'Play', sans-serif">
        <h4 class="text-center">$hostname &nbsp<img title="$country" src="images/flags_new/flags-iso/shiny/32/$country.png">
        <a class="right serverconnectbtn" href="xfire:join?game=swat4&server=$serverip:$joinport">Join Server</a>
        </h4>
        <p class="text-center">$serverip:$joinport
        </p>
        <div class="row liveserverow no-margin no-padding">
            <div class="margin5" style="border-bottom: 1px solid">
                <h5 style="color: yellow" class="padding10 no-margin">
                    Map: $map<span class="right">Mode: $gametype</span></h5>
                <p class="col-md-6 padding10">$desc</p>

                <p class="col-md-6 padding10">$gametypetext</p>

                <p class="col-md-3" style="color: yellow;font-size: 14px">ROUND: $currentround/$roundtotal</p>
                <p class="col-md-6" style="color: yellow;font-size: 14px">Players: $players</p>

                <p class="col-md-6 no-margin" style="color: #0000ff">SWAT: $swatscore&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ROUND WON: $swatwon</p>
                <p class="col-md-6 no-margin" style="color: #ff0000">SUSPECTS: $suspectscore&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ROUND WON: $suspectswon</p>
            </div>


            <!-- Player table row-->
            <div class="row no-margin no-padding">
                <table class="table col-md-12 serverlistable" style="border: 1px solid;margin: 5px;width: 98.6%">
                    <thead>
                    <tr style="color: #000000;background-color: #FFFFFF">
                        <th title="Country Flag">F</th>
                        <th class="col-md-5">Player </th>
                        <th class="col-md-1" title="Score"><div class="player-records-icon totalscore"></div></th>
                        <th class="col-md-1" title="Arrests"><div class="player-records-icon arrests"></div></th>
                        <th class="col-md-1" title="Arrested"><div class="player-records-icon arrested"></div></th>
                        <th class="col-md-1" title="Kills"><div class="player-records-icon kills"></div></th>
                        <th class="col-md-1" title="Deaths"><div class="player-records-icon deaths"></div></th>
                        <th class="col-md-1" title="Team Kills"><div class="player-records-icon teamkills"></div></th>
                        <th class="col-md-1" title="Ping"><div class="right player-records-icon ping"></div></th>
                    </tr>
                    </thead>
                    <tbody class="">
                    $playerstabledata
                    </tbody>
                </table>

            </div>

            <div class="row no-margin text-center">
                <p class="no-margin">Round Time Remaining:</p>
                <p class="font-dsdigital no-margin" style="font-size:25px">$timeleftinMS</p>
                <p class="left padding5">$mod $version</p>
            </div>
        </div>

    </div>


_HTML;
    }
    else
    {
        echo <<<_HTML
    <div id='content'>
    <h1 class='font-dsdigital'>Server is Offline</h1>
    </div>
_HTML;
        return;
    }
}
else
{
?>

<div id="content" class="livestreamajax">
    <h1 class="font-dsdigital">Loading Server...</h1>
</div>

    <script src="js/jquery.min.js"></script>
    <script type="text/javascript">

        var serverid = <?=$_GET['server']?>;
        function startInterval() {

            var refreshId = setInterval(function () {
        $('.livestreamajax').load("pages/liveserverstream.php?ajax&server="+serverid);
            }, 2000);
        }
        startInterval();
    </script>
<?php
}
?>