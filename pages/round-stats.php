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

$num_rec_per_page = 20;

$query = $con->query("SELECT id FROM game;");
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
<li class="previous"><a href="./?statistics=round&page=$last"><span aria-hidden="true">&larr;</span> Previous</a></li>
<li class="next"><a href="./?statistics=round&page=$next">Next <span aria-hidden="true">&rarr;</span></a></li>
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
<li class="next"><a href="./?statistics=round&page=$next">Next <span aria-hidden="true">&rarr;</span></a></li>
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
<li class="previous"><a href="./?statistics=round&page=$last"><span aria-hidden="true">&larr;</span> Previous</a></li>
<li class="next disabled"><a href="#">Next <span aria-hidden="true">&rarr;</span></a></li>
</ul>
</nav>
_HTML;

    }
}


function getroundtabledata()
{
    global $num_rec_per_page,$timezoneoffset;
    if (isset($_GET["page"]))
    { $page  = $_GET["page"]; }
    else { $page=1; };
    $start_from = ($page-1) * $num_rec_per_page;

    global $con;
    $sql = "SELECT * FROM game ORDER BY server_time DESC LIMIT $start_from,$num_rec_per_page;";
    $gamequery = $con->query($sql);


    $roundtabledata = '';
    $i = 0;
    while ($round = $gamequery->fetch_object()) {
        $i++;
        $roundId = $round->id;
        $serverTime = $round->server_time;
        $roundTime = $round->round_time;
        $mapName = $round->mapname;
        $outcome = $round->outcome;
        $playernum = $round->player_num;
        $swatscore = $round->score_swat;
        $suspectscore = $round->score_sus;
        $bvictswat = $round->vict_swat;
        $bvictsuspect = $round->vict_sus;
        if($suspectscore < $swatscore)
        {
            $swatscore = "<font color='green'><b>".$swatscore."</b></font>";
            $suspectscore = "<font color='#8b0000'><b>".$suspectscore."</b></font>";
        }
        elseif($suspectscore > $swatscore)
        {
            $swatscore = "<font color='#8b0000'><b>".$swatscore."</b></font>";
            $suspectscore=  "<font color='green'><b>".$suspectscore."</b></font>";
        }
        $mapName = getElemfromId($mapName, 'M');
        $serverTime = timeago2($serverTime-$timezoneoffset-3600);
        $roundTime = secondtoMS($roundTime);
        $roundtabledata = $roundtabledata . "<tr data-id='$roundId'><td><b><a class='round$roundId ainorange' href='./?statistics=round&detail=$roundId'>$roundId</a></b></td><td>$roundTime</td><td>$swatscore</td><td>$suspectscore</td><td>$mapName</td><td class='text-right'>$serverTime</td></tr>";
    }
    return $roundtabledata;
}
?>
<!-- Content -->

<div class="row no-margin no-padding">
    <div class="block">
        <div class="block-bot">
            <div class="head">
                <div class="head-cnt">
                    <h3>Round Reports</h3>
                    <div class="cl">&nbsp;</div>
                </div>
            </div>
            <div class="col-articles articles">
                <div class="cl">&nbsp;</div>
                <div class="" id="roundstatstable">
                    <table class="stdtable table table-striped table-hover no-margin">
                        <thead>
                        <tr>
                            <th class="col-md-1">Round</th>
                            <th class="col-md-2">Time</th>
                            <th class="col-md-1">SWAT</th>
                            <th class="col-md-1">Suspects</th>
                            <th class="col-md-3">Map</th>
                            <th class="col-md-2 text-right">Date</th>
                        </tr>
                        </thead>
                        <tbody id="roundstabledata">
                        <?=getroundtabledata()?>
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