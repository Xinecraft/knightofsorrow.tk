<?php
/*
 * The MIT License
 *
 * Copyright 2015 Kinnngg.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */



$query = $con->query("SELECT id FROM playeroverall;");
$totalplayers = $query->num_rows;

$num_rec_per_page = 20;
$total_pages = ceil($totalplayers / $num_rec_per_page);

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

    //Dont show pager is only one page of result
    if($total_pages == 1)
        return;


    if( $page > 1 && $page < $total_pages )
    {
        $last = $page - 1;
        $next = $page + 1;
        echo <<<_HTML
<nav>
<ul class="pager">
<li class="previous"><a href="./?statistics=player&page=$last"><span aria-hidden="true">&larr;</span> Previous</a></li>
<li class="next"><a href="./?statistics=player&page=$next">Next <span aria-hidden="true">&rarr;</span></a></li>
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
<li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> Previous</a></li>
<li class="next"><a href="./?statistics=player&page=$next">Next <span aria-hidden="true">&rarr;</span></a></li>
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
<li class="previous"><a href="./?statistics=player&page=$last"><span aria-hidden="true">&larr;</span> Previous</a></li>
<li class="next disabled"><a href="#">Next <span aria-hidden="true">&rarr;</span></a></li>
</ul>
</nav>
_HTML;

    }
}


function getplayertabledata()
{
    global $num_rec_per_page;
    if (isset($_GET["page"]))
    { $page  = $_GET["page"]; }
    else { $page=1; };
    $start_from = ($page-1) * $num_rec_per_page;

    global $con;
    $sql = "SELECT p.id,p.playername,p.countryiso,p.position,p.gamelast,p.rank,p.scoretotal,p.pointstotal,p.timetotal,p.totalroundplayed,l.rankname,l.id as rankid FROM playeroverall AS p JOIN ranklist AS l ON l.id = p.rank ORDER BY position LIMIT $start_from,$num_rec_per_page;";
    $query = $con->query($sql);

    if($query->num_rows <= 0)
    {
        echo "No Players in DB";
        return;
    }

    $playertabledata = '';
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

        // Last Seen
        $pgamelast = $data->gamelast;
        $query2 = $con->query("SELECT date_finished,server_time FROM game WHERE id='$pgamelast' LIMIT 1;");
        $result2 = $query2->fetch_object();
        $gamelast_servertime = $result2->server_time;
        $gamelast_timeago = timeago2($gamelast_servertime-3600);


        $timeplayedinHM = formatHM($timetotal);

        $playertabledata = $playertabledata . "<tr data-id='$id'><td class='textgreen'><b>$position</b></td><td><img data-toggle='tooltip' data-placement='top' title='".country_code_to_country($countryiso)."' src='images/flags/20_shiny/$countryiso.png'></td><td> <img data-toggle='tooltip' data-placement='top' title='$rankname' src='images/game/insignia/$rankid.png' height='22px'> </td><td><strong><a class='ainorange' href='./?statistics=player&detail=".urlencode($name)."'>$name</a></strong></td><td>$pointstotal</td><td>$scoretotal</td><td>$timeplayedinHM</td><td class='text-right'><a class='ainorangenobold' href='./?statistics=round&detail=$pgamelast'>$gamelast_timeago</a></td></tr>";
    }
    return $playertabledata;
}

?>
<!-- Content -->

<div class="row no-margin no-padding">
    <div class="block">
        <div class="block-bot">
            <div class="head">
                <div class="head-cnt">
                    <h3>Top Players (<?=$totalplayers?>)</h3>
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
                        <?=getplayertabledata()?>
                        </tbody>
                    </table>
                    <?=getpager()?>
                </div>
                <div class="cl">&nbsp;</div>
            </div>
        </div>

    </div>

</div>
<!-- / Content -->