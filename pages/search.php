<?php
/**
 * Created by PhpStorm.
 * User: Kinnngg
 * Date: 02-03-2015
 * Time: 00:49
 */

if(!isset($_GET['search']) || $_GET['search'] == '')
    header("Location: ./?home");
$total = 0;
$totaluser = 0;
/**
 * Player Search Function
 * @return string
 */
function getsearchtable()
{
    global $con;
    global $string,$total;
    $playertabledata = '';
    $string = $con->escape_string($_GET['search']);
    $sql = "SELECT p.id,p.playername,p.countryiso,p.position,p.rank,p.scoretotal,p.pointstotal,p.timetotal,p.totalroundplayed,p.gamelast,l.rankname,l.id as rankid FROM playeroverall AS p JOIN ranklist AS l ON l.id = p.rank WHERE playername LIKE '%$string%' ORDER BY position LIMIT 10;";
    $query = $con->query($sql);
    $total = $query->num_rows;
    if($query->num_rows <= 0)
    {
        $playertabledata = '<tr><td></td><td></td><td></td><th>No  Player  Found</th><td></td><td></td><td></td><td></td></tr>';
        return $playertabledata;
    }

    /**
     *

   elseif($query->num_rows == 1)
   {
       $data=$query->fetch_object();
       $id = $data->id;
       header("Location: ./?statistics=player&detail=$id");
   }
     *
     */

    while($data=$query->fetch_object())
    {
        $id = $data->id;
        $countryiso = $data->countryiso;
        $name = $data->playername;
        $position = $data->position;
        $rankname = $data->rankname;
        $rankid = $data->rankid;
        $scoretotal = $data->scoretotal;
        $pointstotal = $data->pointstotal;
        $timetotal = $data->timetotal;
        $roundplayed = $data->totalroundplayed;
        $timeplayedinHM = formatHM($timetotal);

        // Last Seen
        $pgamelast = $data->gamelast;
        $query2 = $con->query("SELECT date_finished,server_time FROM game WHERE id='$pgamelast' LIMIT 1;");
        $result2 = $query2->fetch_object();
        $gamelast_servertime = $result2->server_time;
        $gamelast_timeago = timeago2($gamelast_servertime-3600);

        $playertabledata = $playertabledata . "<tr data-id='$id'><td><b>$position</b></td><td><img data-toggle='tooltip' data-placement='top' title='".country_code_to_country($countryiso)."' src='images/flags/20_shiny/$countryiso.png'></td><td> <img data-toggle='tooltip' data-placement='top' title='$rankname' src='images/game/insignia/$rankid.png' height='22px'> </td><td><strong><a class='ainorange' href='./?statistics=player&detail=".urlencode($name)."'>$name</a></strong></td><td>$pointstotal</td><td>$scoretotal</td><td>$timeplayedinHM</td><td class='text-right'><a class='ainorange' href='./?statistics=round&detail=$pgamelast'>$gamelast_timeago</a></td></tr>";
    }
    return $playertabledata;
}

/**
 * User search function
 * @return string Users
 */
function getusersearchtable()
{
    global $con;
    global $string,$totaluser;
    $playertabledata = '';
    $string = $con->escape_string($_GET['search']);
    $sql = "SELECT username,id,email,fullname,country,last_login_time FROM user WHERE username LIKE '%$string%' OR email LIKE '$string' OR fullname LIKE '%$string%' LIMIT 10;";
    $query = $con->query($sql);
    $totaluser = $query->num_rows;
    if($query->num_rows <= 0)
    {
        $playertabledata = '<tr><td></td><td></td><td></td><th>No  User  Found</th><td></td><td></td></tr>';
        return $playertabledata;
    }

    while($data=$query->fetch_object())
    {
        $id = $data->id;
        $countryiso = $data->country;
        $fullname = $data->fullname;
        $username = $data->username;
        $email = $data->email;
        $lastlogintime = $data->last_login_time;
        $lastlogintime = timeago($lastlogintime);
        $playertabledata = $playertabledata . "<tr data-id='$id'><td><b>$id</b></td><td><img data-toggle='tooltip' data-placement='top' title='".country_code_to_country($countryiso)."' src='images/flags/20_shiny/$countryiso.png'></td><td><strong><a class='ainorange' href='./?userprofile=$username'>$username</a></strong></td><td>$fullname</td><td class='text-right'>$lastlogintime</td></tr>";
    }
    return $playertabledata;
}

$searchresult = getsearchtable();
$usersearchresult = getusersearchtable();
?>
<div id="content">

<div class="row no-margin no-padding">
    <div class="block">
        <div class="block-bot">
            <div class="head">
                <div class="head-cnt">
                    <h3>Found <?=$total?> Players matching '<?=$string?>'</h3>
                    <div class="cl">&nbsp;</div>
                </div>
            </div>
            <div class="col-articles articles">
                <div class="cl">&nbsp;</div>
                <div class="commontable" id="playerstatstable">
                    <table class="stdtable table table-striped table-hover no-margin">
                        <thead>
                        <tr>
                            <th class="col-md-1">#</th>
                            <th class="col-md-1">Flag</th>
                            <th class="col-md-1">Rank</th>
                            <th class="col-md-3">Name</th>
                            <th class="col-md-1">Points</th>
                            <th class="col-md-1">Score</th>
                            <th class="col-md-2">Time</th>
                            <th class="col-md-3 text-right">Last Seen</th>
                        </tr>
                        </thead>
                        <tbody id="playertabledata">
                        <?=$searchresult?>
                        </tbody>
                    </table>
                </div>
                <div class="cl">&nbsp;</div>
            </div>
        </div>

    </div>

    <div class="block">
        <div class="block-bot">
            <div class="head">
                <div class="head-cnt">
                    <h3>Found <?=$totaluser?> User matching '<?=$string?>'</h3>
                    <div class="cl">&nbsp;</div>
                </div>
            </div>
            <div class="col-articles articles">
                <div class="cl">&nbsp;</div>
                <div class="commontable" id="playerstatstable">
                    <table class="stdtable table table-striped table-hover no-margin">
                        <thead>
                        <tr>
                            <th class="col-md-1">#</th>
                            <th class="col-md-1">Flag</th>
                            <th class="col-md-2">Username</th>
                            <th class="col-md-3">Full Name</th>
                            <th class="col-md-3 text-right">Last Visited</th>
                        </tr>
                        </thead>
                        <tbody id="playertabledata">
                        <?=$usersearchresult?>
                        </tbody>
                    </table>
                </div>
                <div class="cl">&nbsp;</div>
            </div>
        </div>

    </div>

</div>
    </div>
<!-- / Content -->