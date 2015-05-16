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

/**
 * Temp For creating a Username for Session live Server chat
 */
if(isset($_POST['liveserverchatterbtn']))
{
    if(empty($_POST['serverchattername']))
        return;
    
    $chattername = $_POST['serverchattername'];
    $chattername = htmlentities($chattername);
    $_SESSION['chattername'] = $chattername;
}


function getroundtabledata() {
    global $con;
    $sql = "SELECT * FROM game ORDER BY server_time DESC LIMIT 5;";
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
        if ($suspectscore < $swatscore) {
            $swatscore = "<font color='green'><b>" . $swatscore . "</b></font>";
            $suspectscore = "<font color='#8b0000'><b>" . $suspectscore . "</b></font>";
        } elseif ($suspectscore > $swatscore) {
            $swatscore = "<font color='#8b0000'><b>" . $swatscore . "</b></font>";
            $suspectscore = "<font color='green'><b>" . $suspectscore . "</b></font>";
        }
        $mapName = getElemfromId($mapName, 'M');

        global $timezoneoffset;
        $serverTime = timeago2($serverTime - 3600);

        $roundTime = secondtoMS($roundTime);
        $roundtabledata = $roundtabledata . "<tr data-id='$roundId'><td><a class='ainorange' class='class='round$roundId'' href='./?statistics=round&detail=$roundId'>$i</a></td><td>$roundTime</td><td>$swatscore</td><td>$suspectscore</td><td>$mapName</td><td class='text-right'>$serverTime</td></tr>";
    }
    return $roundtabledata;
}

/**
 * Get the TOP 10 Players from LIST
 * @return string|void
 */
function getplayertabledata() {
    global $con;
    $sql = "SELECT p.id,p.playername,p.countryiso,p.position,p.rank,l.rankname,l.id as rankid FROM playeroverall AS p JOIN ranklist AS l ON l.id = p.rank ORDER BY position LIMIT 10";
    $query = $con->query($sql);

    if ($query->num_rows <= 0) {
        echo "No Players in DB";
        return;
    }

    $playertabledata = '';
    while ($data = $query->fetch_object()) {
        $id = $data->id;
        $countryiso = $data->countryiso;
        $name = $data->playername;
        $position = $data->position;
        $rankname = $data->rankname;
        $rankid = $data->rankid;

        $playertabledata = $playertabledata . "<tr data-id='$id'><td><b>$position</b></td><td><img data-toggle='tooltip' data-placement='top' title='" . country_code_to_country($countryiso) . "' src='images/flags/20_shiny/$countryiso.png'></td><td> <img data-toggle='tooltip' data-placement='top' title='$rankname' src='images/game/insignia/$rankid.png' height='22px'> </td><td><strong><a class='ainorange' href='./?statistics=player&detail=".urlencode($name)."'>$name</a></strong></td></tr>";
    }
    return $playertabledata;
}

/**
 * Return the Players Record Data
 */
function getplayerrecorddata() {
    global $con;

    /**
     * 1
     * Total Score
     */
    $query = $con->query("SELECT * FROM playeroverall ORDER BY scoretotal DESC LIMIT 1;");
    if ($query->num_rows <= 0) {
        
    }
    $result = $query->fetch_object();
    $topscore_name = $result->playername;
    $topscore_score = $result->scoretotal;
    $topscore_id = $result->id;

    /**
     * 2
     * Highest Score in one Round
     */
    $query = $con->query("SELECT * FROM playeroverall ORDER BY highestscore DESC LIMIT 1;");
    if ($query->num_rows <= 0) {
        
    }
    $result = $query->fetch_object();
    $highscore_name = $result->playername;
    $highscore_score = $result->highestscore;
    $highscore_id = $result->id;

    /**
     * 3
     * Most Arrests
     */
    $query = $con->query("SELECT * FROM playeroverall ORDER BY arreststotal DESC LIMIT 1;");
    if ($query->num_rows <= 0) {
        
    }
    $result = $query->fetch_object();
    $arrests_name = $result->playername;
    $arrests_total = $result->arreststotal;
    $arrests_id = $result->id;

    /**
     * 4
     * Most Arrested
     */
    $query = $con->query("SELECT * FROM playeroverall ORDER BY arrestedtotal DESC LIMIT 1;");
    if ($query->num_rows <= 0) {
        
    }
    $result = $query->fetch_object();
    $arrested_name = $result->playername;
    $arrested_total = $result->arrestedtotal;
    $arrested_id = $result->id;

    /**
     * 5
     * Best Score Per Min
     */
    $query = $con->query("SELECT * FROM playeroverall ORDER BY scorepermin DESC LIMIT 1;");
    if ($query->num_rows <= 0) {
        
    }
    $result = $query->fetch_object();
    $scorepermin_name = $result->playername;
    $scorepermin_score = $result->scorepermin;
    $scorepermin_id = $result->id;

    /**
     * 6
     * Best Arrest Streak
     */
    $query = $con->query("SELECT * FROM playeroverall ORDER BY bestarreststreak DESC LIMIT 1;");
    if ($query->num_rows <= 0) {
        
    }
    $result = $query->fetch_object();
    $bestarreststreak_name = $result->playername;
    $bestarreststreak_total = $result->bestarreststreak;
    $bestarreststreak_id = $result->id;

    /**
     * 7
     * Best Kill Streak
     */
    $query = $con->query("SELECT * FROM playeroverall ORDER BY bestkillstreak DESC LIMIT 1;");
    if ($query->num_rows <= 0) {
        
    }
    $result = $query->fetch_object();
    $bestkillstreak_name = $result->playername;
    $bestkillstreak_total = $result->bestkillstreak;
    $bestkillstreak_id = $result->id;

    /**
     * 8
     * Best Death Streak

      $query = $con->query("SELECT * FROM playeroverall HAVING bestkillstreak = MAX(bestdeathstreak) LIMIT 1;");
      $result = $query->fetch_object();
      $bestdeathstreak_name = $result->playername;
      $bestdeathstreak_total = $result->bestdeathstreak;
     * /

      /**
     * 9
     * Most Time Played
     */
    //$query = $con->query("SELECT * FROM playeroverall HAVING timetotal = MAX(timetotal) LIMIT 1;");
    $query = $con->query("SELECT * FROM playeroverall ORDER BY timetotal DESC LIMIT 1;");
    if ($query->num_rows <= 0) {
        
    }
    $result = $query->fetch_object();
    $timetotal_name = $result->playername;
    $timetotal_sec = $result->timetotal;
    $timetotal_id = $result->id;
    $timetotal_hm = formatHM($timetotal_sec);

    /**
     * 10
     * Most Kills
     */
    $query = $con->query("SELECT * FROM playeroverall ORDER BY killstotal DESC LIMIT 1;");
    if ($query->num_rows <= 0) {
        
    }
    $result = $query->fetch_object();
    $kills_name = $result->playername;
    $kills_id = $result->id;
    $kills_total = $result->killstotal;

    /**
     * 11
     * Most Deaths
     */
    $query = $con->query("SELECT * FROM playeroverall ORDER BY deathstotal DESC LIMIT 1;");
    if ($query->num_rows <= 0) {
        
    }
    $result = $query->fetch_object();
    $deaths_name = $result->playername;
    $deaths_id = $result->id;
    $deaths_total = $result->deathstotal;

    /**
     * 12
     * Most TeamKills
     */
    $query = $con->query("SELECT * FROM playeroverall ORDER BY teamkillstotal DESC LIMIT 1;");
    if ($query->num_rows <= 0) {
        
    }
    $result = $query->fetch_object();
    $teamkills_name = $result->playername;
    $teamkills_total = $result->teamkillstotal;
    $teamkills_id = $result->id;

    /**
     * Best Score Percentile
     */
    $query = $con->query("SELECT * FROM playeroverall ORDER BY scorepercentile DESC LIMIT 1;");
    if ($query->num_rows <= 0) {
        
    }
    $result = $query->fetch_object();
    $scoreper_name = $result->playername;
    $scoreper_per = $result->scorepercentile;
    $scoreper_id = $result->id;

    $data = <<<_HTML
<table class="table borderless playerrecordtable">
                                    <tbody><tr>
                                        <td class="col-1">
                                            <div class="player-records-icon totalscore"></div>
                                        </td>
                                        <td class="col-2">
                                            Total Score
                                        </td>
                                        <td class="col-3">
                                            <a class='ainorange' href="./?statistics=player&detail=$topscore_name">$topscore_name</a>
                                            <span class="small">($topscore_score)</span>
                                        </td>
                                        <td class="col-4">
                                            <div class="player-records-icon arrests"></div>
                                        </td>
                                        <td class="col-5">
                                            Arrests
                                        </td>
                                        <td class="col-6"><a class='ainorange' href="./?statistics=player&detail=$arrests_name">$arrests_name</a>
                                            <span class="small">($arrests_total)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-1">
                                            <div class="player-records-icon highscore"></div>
                                        </td>
                                        <td class="col-2">
                                            High Score
                                        </td>
                                        <td class="col-3">
                                            <a class='ainorange' href="./?statistics=player&detail=$highscore_name">$highscore_name</a>
                                            <span class="small">($highscore_score)</span>
                                        </td>
                                        <td class="col-4">
                                            <div class="player-records-icon arrested"></div>
                                        </td>
                                        <td class="col-5">
                                            Arrested
                                        </td>
                                        <td class="col-6"><a class='ainorange' href="./?statistics=player&detail=$arrested_name">$arrested_name</a>
                                            <span class="small">($arrested_total)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-1">
                                            <div class="player-records-icon totalscore"></div>
                                        </td>
                                        <td class="col-2">
                                            Score/Min
                                        </td>
                                        <td class="col-3">
                                            <a class='ainorange' href="./?statistics=player&detail=$scorepermin_name">$scorepermin_name</a>
                                            <span class="small">($scorepermin_score)</span>
                                        </td>
                                        <td class="col-4">
                                            <div class="player-records-icon arreststreak"></div>
                                        </td>
                                        <td class="col-5">
                                            Arrest Streak
                                        </td>
                                        <td class="col-6"><a class='ainorange' href="./?statistics=player&detail=$bestarreststreak_name">$bestarreststreak_name</a>
                                            <span class="small">($bestarreststreak_total)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-1">
                                            <div class="player-records-icon time"></div>
                                        </td>
                                        <td class="col-2">
                                            Time Played
                                        </td>
                                        <td class="col-3">
                                            <a class='ainorange' href="./?statistics=player&detail=$timetotal_name">$timetotal_name</a>
                                            <span class="small">($timetotal_hm)</span>
                                        </td>
                                        <td class="col-4">
                                            <div class="player-records-icon kills"></div>
                                        </td>
                                        <td class="col-5">Kills</td>
                                        <td class="col-6"><a class='ainorange' href="./?statistics=player&detail=$kills_name">$kills_name</a>
                                            <span class="small">($kills_total)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-1">
                                            <div class="player-records-icon ping"></div>
                                        </td>
                                        <td class="col-2">
                                            Score Percentile
                                        </td>
                                        <td class="col-3">
                                            <a class='ainorange' href="./?statistics=player&detail=$scoreper_name">$scoreper_name</a>
                                            <span class="small">($scoreper_per%)</span>
                                        </td>
                                        <td class="col-4">
                                            <div class="player-records-icon deaths"></div>
                                        </td>
                                        <td class="col-5">
                                            Deaths
                                        </td>
                                        <td class="col-6"><a class='ainorange' href="./?statistics=player&detail=$deaths_name">$deaths_name</a>
                                            <span class="small">($deaths_total)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-1">
                                            <div class="player-records-icon teamkills"></div>
                                        </td>
                                        <td class="col-2">
                                            Team Kills
                                        </td>
                                        <td class="col-3">
                                            <a class='ainorange' href="./?statistics=player&detail=$teamkills_name">$teamkills_name</a>
                                            <span class="small">($teamkills_total)</span>
                                        </td>
                                        <td class="col-4">
                                            <div class="player-records-icon killstreak"></div>
                                        </td>
                                        <td class="col-5">
                                            Kill Streak
                                        </td>
                                        <td class="col-6"><a class='ainorange' href="./?statistics=player&detail=$bestkillstreak_name">$bestkillstreak_name</a>
                                            <span class="small">($bestkillstreak_total)</span>
                                        </td>
                                    </tr>
                                    </tbody></table>

_HTML;

    return $data;
}

/**
 * Function Return
 * Top 10 Scorer
 */
function getscorer()
{
    global $con;
    $sql = "SELECT p.id,p.playername,p.countryiso,p.rank,p.scoretotal,l.rankname,l.id as rankid FROM playeroverall AS p JOIN ranklist AS l ON l.id = p.rank ORDER BY scoretotal DESC LIMIT 10";
    $query = $con->query($sql);

    if($query->num_rows <= 0)
    {
        echo "No Players in DB";
        return;
    }

    $playertabledata = '';
    $i=0;
    while($data=$query->fetch_object())
    {
        $i++;
        $id = $data->id;
        $countryiso = $data->countryiso;
        $name = $data->playername;
        $rankname = $data->rankname;
        $rankid = $data->rankid;
        $scoretotal = $data->scoretotal;

        $playertabledata = $playertabledata . "<tr data-id='$id'><td><b>$i</b></td><td><img data-toggle='tooltip' data-placement='top' title='".country_code_to_country($countryiso)."' src='images/flags/20_shiny/$countryiso.png'></td><td> <img data-toggle='tooltip' data-placement='top' title='$rankname' src='images/game/insignia/$rankid.png' height='22px'> </td><td><strong><a class='ainorange' href='./?statistics=player&detail=".urlencode($name)."'>$name</a></strong></td><td class='text-right'>$scoretotal</td></tr>";
    }
    return $playertabledata;
}

$sql = "SELECT id FROM game ORDER BY id DESC LIMIT 1;";
$query=$con->query($sql);
$result = $query->fetch_object();
$lastgame_id = $result->id;
$lastgame_id_minus100 = $lastgame_id-100;

/*
 * Top 10 Rating 
 */
function getrating()
{
	global $lastgame_id_minus100;
    global $con;
    $sql = "SELECT p.id,p.playername,p.rating,p.countryiso,p.rank,p.aaratio,l.rankname,l.id as rankid FROM playeroverall AS p JOIN ranklist AS l ON l.id = p.rank WHERE gamelast >= $lastgame_id_minus100 ORDER BY rating DESC,scoretotal DESC LIMIT 10";
    $query = $con->query($sql);

    if($query->num_rows <= 0)
    {
        echo "No Players in DB";
        return;
    }

    $playertabledata = '';
    $i=0;
    while($data=$query->fetch_object())
    {
        $i++;
        $id = $data->id;
        $countryiso = $data->countryiso;
        $name = $data->playername;
        $rankname = $data->rankname;
        $rankid = $data->rankid;
        $rating = $data->rating;

        $playertabledata = $playertabledata . "<tr data-id='$id'><td><b>$i</b></td><td><img data-toggle='tooltip' data-placement='top' title='".country_code_to_country($countryiso)."' src='images/flags/20_shiny/$countryiso.png'></td><td> <img data-toggle='tooltip' data-placement='top' title='$rankname' src='images/game/insignia/$rankid.png' height='22px'> </td><td><strong><a class='ainorange' href='./?statistics=player&detail=".urlencode($name)."'>$name</a></strong></td><td class='text-right'>$rating</td></tr>";
    }
    return $playertabledata;
}



$playerrecord = getplayerrecorddata();
?>
<!-- Content -->
<div id="content">
    <div class="block serverscoreview">
        <div class="block-bot">
            <div class="block-cnt lssview">
                <div class="lssswat left">
                    <h2 class="no-margin">SWAT</h2>
                    <h1 id="lsswatscore" class="no-margin">&infin;</h1>
                    <p id="lsswatwins">0 Wins</p>
                </div>
                <div class="lsssus left">
                    <h2 class="no-margin">SUSPECT</h2>
                    <h1 class="no-margin" id="lssusscore">&infin;</h1>
                    <p id="lssuswins">0 Wins</p>
                </div>
                <div class="lssround left">
                    <h2 class="no-margin">ROUND</h2>
                    <h1 class="no-margin" id="lsround">&infin;</h1>
                    <p id="lstime">&infin; mins</p>
                </div>
                <div class="lssmap left">
                    <h2 class="no-margin">MAP</h2>
                    <h1 class="no-margin" id="lsmapname">Unknown</h1>
                    <p id="lsnextmap">Nextmap: Unknown</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row no-margin no-padding">

        <div class="col-md-5 no-padding">
            <div class="block liveplayerlist">
                <div class="block-bot">
                    <div class="head">
                        <div class="head-cnt">
                            <h3>Players Online (<span id="lplayersonline"></span>/<span id="lplayerlimit"></span>)</h3>
                            <div class="cl">&nbsp;</div>
                        </div>
                    </div>
                    <div class="col-articles articles">
                        <div class="cl">&nbsp;</div>
                        <div class="liveplayerslisttable">
                            <table class="table table-striped table-hover no-margin">
                                <thead>
                                    <tr>
                                        
                                        <th class="col-md-6">Name</th>
                                        <th class="col-md-1">Score</th>
                                        <th class="col-md-1">Ping</th>
                                    </tr>
                                </thead>
                                <tbody id="liveplayerdata">
                                    <tr>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="cl">&nbsp;</div>
                    </div>
                </div>

            </div>
            <div class="block liveplayerlist" style="font-size:11px !important">
                <div class="block-bot">
                    <div class="head">
                        <div class="head-cnt"> <a href="./?statistics=player" class="view-all ainorange">view all</a>
                            <h3>Top 10 Players </h3>
                            <div class="cl">&nbsp;</div>
                        </div>
                    </div>
                    <div class="col-articles articles">
                        <div class="cl">&nbsp;</div>
                        <div class="liveplayerslisttable">
                            <table class="table table-striped table-hover no-margin">
                                <thead>
                                    <tr>
                                        <th class="col-md-1">#</th>
                                        <th class="col-md-1">F</th>
                                        <th class="col-md-1">R</th>
                                        <th class="col-md-2">Name</th>

                                    </tr>
                                </thead>
                                <tbody id="liveplayerbody">
                                    <tr>
                                        <?= getplayertabledata() ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="cl">&nbsp;</div>
                    </div>
                </div>

            </div>
        </div>

        <div class="block col-md-6 no-padding livechatlog">
            <div class="">
                <div class="head">
                    <div class="head-cnt"> <a href="./?comingsoon" class="view-all ainorange">view all</a>
                        <h3>Server Viewer</h3>
                        <div class="cl">&nbsp;</div>
                    </div>
                </div>
                <div class="col-articles articles chatlogdata">
                    <div class="cl">&nbsp;</div>

                    <div class="cl">&nbsp;</div>
                </div>
            </div>
          
            <?php
            if(islogin())
            {
            ?>
            <form class="form form-inline margin5" name="serverchatform" id="serverchatform" method="POST" action="pages/udpserverchat.php">
            <div class="form-group">
                <input type="text" name="serverchatmsg" id="serverchatmsgg" class="form-control" placeholder="Your Message" style="width: 314px">
            </div>
            <input type="submit" class="btn btn-default" value="Chat" id="liveserverchatbtn">
        </form>
            <?php
            }
            else
            {
                echo <<<_HTML
            <h5 class="panel margin5 padding10 lorchat">Please <a class='ainorange' href="./?login">Login</a> or <a class='ainorange' href="./?register">Register</a> to Chat</h5>
_HTML;
            }
            ?>
        </div>
    </div>

    <div class="row no-padding no-margin">
        <div class="block">
            <div class="block-bot">
                <div class="head">
                    <div class="head-cnt"> <a href="./?statistics=round" class="view-all ainorange">View All</a>
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
                                <?= getroundtabledata() ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="cl">&nbsp;</div>
                </div>
            </div>

        </div>

    </div>


    <!--Top Scorer for X Elem Data>-->
    <div class="row no-padding no-margin">
        <div class="block">
            <div class="block-bot">
                <div class="head">
                    <div class="head-cnt">
                        <h3>Player Records</h3>
                        <div class="cl">&nbsp;</div>
                    </div>
                </div>
                <div class="col-articles articles">
                    <div class="cl">&nbsp;</div>
                    <div class="padding15" style="background-color: #f5f5f5">

                        <!--Tab Starts-->
                        <div role="tabpanel">

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class=""><a class='ainorange' href="#pastweek" aria-controls="pastweek" role="tab" data-toggle="tab">Past Week</a></li>
                                <li role="presentation"><a class='ainorange' href="#pastmonth" aria-controls="pastmonth" role="tab" data-toggle="tab">Past Month</a></li>
                                <li role="presentation"><a class='ainorange' href="#pastyear" aria-controls="pastyear" role="tab" data-toggle="tab">Past Year</a></li>
                                <li role="presentation" class="active"><a class='ainorange' href="#alltime" aria-controls="alltime" role="tab" data-toggle="tab">All Time</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content" style="background-color: #ffffff;border-left: 1px solid #ddd;border-bottom: 1px solid #ddd;border-right: 1px solid #ddd;">
                                <div role="tabpanel" class="tab-pane" id="pastweek"><?= $playerrecord ?></div>
                                <div role="tabpanel" class="tab-pane" id="pastmonth"><?= $playerrecord ?></div>
                                <div role="tabpanel" class="tab-pane" id="pastyear"><?= $playerrecord ?></div>
                                <div role="tabpanel" class="tab-pane active" id="alltime"><?= $playerrecord ?></div>
                            </div>

                        </div>
                        <!--/Tab Ends-->

                    </div>
                    <div class="cl">&nbsp;</div>
                </div>
            </div>
        </div>
    </div>
	
	<div class="row no-padding no-margin" style="color:black !important">
	
	
	<!-- PANEL STARTS-->
        <div class="panel panel-default col-md-5 no-padding" style="width: 49%; margin-right: 13px;">
            <!-- Default panel contents -->
            <div class="panel-heading"><b>Top 10 Scorer</b></div>
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
                <tbody class="">

                <?=getscorer()?>

                </tbody>

            </table>
        </div>
        <!--Panel Ends -->
		
	<!-- PANEL STARTS-->
        <div class="panel panel-default col-md-5 no-padding" style="width: 49%;">
            <!-- Default panel contents -->
            <div class="panel-heading"><b>Top 10 Ratings</b>&nbsp; <i>(0-10 based on 20+ hours of play)</i></div>
            <!-- Table -->
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>F</th>
                    <th>R</th>
                    <th>Name</th>
                    <th class="text-right">Rating</th>
                </tr>
                </thead>
                <tbody class="">

                <?=getrating()?>

                </tbody>

            </table>
        </div>
        <!--Panel Ends -->
	</div>


</div>
<!-- / Content -->
