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

$query = $con->query("SELECT DISTINCT countryiso FROM playeroverall;");
$totalcountries = $query->num_rows;

function getcountrytabledata()
{
    global $con;
    $sql = "SELECT id,countryiso,sum(scoretotal) as totalscore,count(playername) totalplayers,SUM(timetotal) as totaltime FROM `playeroverall` GROUP BY countryiso ORDER BY sum(scoretotal) DESC;";
    $query = $con->query($sql);

    if($query->num_rows <= 0)
    {
        echo "No Country in DB";
        return;
    }

    $countrytabledata = '';
    $i = 0;
    while($data=$query->fetch_object())
    {
        $i++;
        $id = $data->id;
        $countryiso = $data->countryiso;
        $countryname=country_code_to_country($countryiso);
        $totalplayers = $data->totalplayers;
        $totalscore = $data->totalscore;
        $totaltime = $data->totaltime;

        $totaltimeinHM = formatHM($totaltime);

        $countrytabledata = $countrytabledata . "<tr data-id='$id'><td><b>$i</b></td><td><img data-toggle='tooltip' data-placement='top' title='$countryname' src='images/flags/20_shiny/$countryiso.png'></td><td><strong><a href='./?statistics=country&detail=$id'>$countryname</a></strong></td><td>$totalplayers</td><td>$totalscore</td><td class='text-right'>$totaltimeinHM</td></tr>";
    }
    return $countrytabledata;
}
?>
<!-- Content -->

<div class="row no-margin no-padding">
    <div class="block">
        <div class="block-bot">
            <div class="head">
                <div class="head-cnt">
                    <h3>Total Countries (<?=$totalcountries?>)</h3>
                    <div class="cl">&nbsp;</div>
                </div>
            </div>
            <div class="col-articles articles">
                <div class="cl">&nbsp;</div>
                <div class="commontable" id="countrystatstable">
                    <table class="stdtable table table-striped table-hover no-margin">
                        <thead>
                        <tr>
                            <th class="col-md-1">#</th>
                            <th class="col-md-1">Flag</th>
                            <th class="col-md-4">Name</th>
                            <th class="col-md-2">Total Players</th>
                            <th class="col-md-2">Total Score</th>
                            <th class="col-md-3 text-right">Time Played</th>
                        </tr>
                        </thead>
                        <tbody id="playertabledata">
                        <?=getcountrytabledata()?>
                        </tbody>
                    </table>
                </div>
                <div class="cl">&nbsp;</div>
            </div>
        </div>

    </div>

</div>
<!-- / Content -->