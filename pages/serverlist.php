<?php
/**
 * Created by PhpStorm.
 * User: Kinnngg
 * Date: 03-03-2015
 * Time: 00:58
 */
include_once("serverquery_inc.php");

/**
 * Paging System
 */
$num_rec_per_page = 20;
$query = $con->query("SELECT id FROM server;");
$total_records = $query->num_rows;
$total_pages = ceil($total_records / $num_rec_per_page);
function getpager()
{
    if(!isset($_GET['page']))
    {
        $page=1;
    }
    else {
        $page = $_GET["page"];
    }
    global $total_pages;

    if($total_pages == 1)
        return;


    if( $page > 1 && $page < $total_pages )
    {
        $last = $page - 1;
        $next = $page + 1;
        echo <<<_HTML
<nav>
<ul class="pager">
<li class="previous"><a href="./?servers&page=$last"><span aria-hidden="true">&larr;</span> Previous</a></li>
<li class="next"><a href="./?servers&page=$next">Next <span aria-hidden="true">&rarr;</span></a></li>
</ul>
</nav>
_HTML;
    }
    else if( $page == 1 )
    {
        $next = $page+1;
        echo <<<_HTML
<nav>
<ul class="pager">
<li class="previous disabled"><a><span aria-hidden="true">&larr;</span> Previous</a></li>
<li class="next"><a href="./?servers&page=$next">Next <span aria-hidden="true">&rarr;</span></a></li>
</ul>
</nav>
_HTML;
    }
    else if( $page >= 2 )
    {
        $last = $page - 1;
        echo <<<_HTML
<nav>
<ul class="pager">
<li class="previous"><a href="./?servers&page=$last"><span aria-hidden="true">&larr;</span> Previous</a></li>
<li class="next disabled"><a>Next <span aria-hidden="true">&rarr;</span></a></li>
</ul>
</nav>
_HTML;

    }
}

if (isset($_GET["page"]))
{ $page  = $_GET["page"]; }
else { $page=1; };
$start_from = ($page-1) * $num_rec_per_page;
//Paging Ends

$sql = "SELECT * FROM server ORDER BY rank LIMIT $start_from,$num_rec_per_page;";
$query = $con->query($sql);

if($query->num_rows <= 0)
{
    echo <<<_HTML
<div id="content" class="well">
<h2 class="no-margin font-dsdigital">No Server found</h2><br>
<a class="btn btn-block btn-default" href="./?registerserver">Add a Server</a>
</div>
_HTML;
    return;
}

$servertabledata = '';
while($server=$query->fetch_object())
{
    $id = $server->id;
    $servername = $server->hostname;
    $country = $server->country;
    $serverip = $server->ip;
    $joinport = $server->port;
    $gs1port = $server->port_gs1;
    $gs2port = $server->port_gs2;
    $desc = $server->description;
    $rank = $server->rank;
    $queryport = $gs1port==0 ? $gs2port : $gs1port;

    $serverlivedata = json_decode(getserverdetail($serverip,$queryport));
    $hostname = $serverlivedata->hostname;

    if($hostname != "__offline__") {
        $version = $serverlivedata->patch;
        $map = $serverlivedata->map;
        $gametype = $serverlivedata->gametype;
        $playercurr = $serverlivedata->players_current;
        $playermax = $serverlivedata->players_max;
        $players = $playercurr . "/" . $playermax;

        $servertabledata = $servertabledata . <<<_HTML
<tr data-id="$id">
            <td><b>$id</b></td>
            <td><a class='no-style' href='./?server=$id'>$hostname</a></td>
            <td> $players </td>
            <td>$gametype</td>
            <td>$map</td>
            <td>$serverip:$joinport</td>
            <td class="text-right">$version</td>
        </tr>
_HTML;
    }
}


?>

<div id="content">

    <p class="text-center">
    <a class="btn btn-warning" href="./?registerserver">Add a new server</a>
    </p>
<div class="panel panel-default col-md-12 no-padding" style="font-family: 'Play', sans-serif  !important">
    <!-- Default panel contents -->
    <div class="panel-heading"><b>SWAT4 SERVERS</b></div>
    <!-- Table -->
    <table class="table serverlistable">
        <thead>
        <tr style="color: #dd5000">
            <th >#</th>
            <th class="col-md-4">SERVER NAME</th>
            <th class="col-md-1">PLAYER</th>
            <th class="col-md-3">GAME TYPE</th>
            <th class="col-md-3">MAP</th>
            <th class="col-md-1">IP</th>
            <th class="col-md-1 text-right">VER</th>
        </tr>
        </thead>
        <tbody class="">
        <?=$servertabledata?>
        </tbody>
    </table>
    <?=getpager()?>
</div>

    </div>