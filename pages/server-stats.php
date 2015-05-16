<!--
function getscorer()
{
global $con;
$sql = "SELECT p.id,p.playername,p.countryiso,p.position,p.rank,p.scoretotal,p.pointstotal,p.timetotal,p.totalroundplayed,l.rankname,l.id as rankid FROM playeroverall AS p JOIN ranklist AS l ON l.id = p.rank ORDER BY scoretotal DESC LIMIT 10";
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

$timeplayedinHM = formatHM($timetotal);

$playertabledata = $playertabledata . "<tr data-id='$id'><td><b>$position</b></td><td><img data-toggle='tooltip' data-placement='top' title='".country_code_to_country($countryiso)."' src='images/flags/20_shiny/$countryiso.png'></td><td> <img data-toggle='tooltip' data-placement='top' title='$rankname' src='images/game/insignia/$rankid.png' height='22px'> </td><td><strong><a class="ainorange" href='./?statistics=player&detail=$id'>$name</a></strong></td><td class='text-right'>$scoretotal</td></tr>";
}
return $playertabledata;
}
-->

<?php
/**
 * Created by PhpStorm.
 * User: Kinnngg
 * Date: 01-03-2015
 * Time: 05:02
 *
 */

/**
 * Server Common Statistics
 */
$sql = "SELECT count(*) AS playertotal,SUM(scoretotal) AS scoretotal,SUM(killstotal) AS killstotal,SUM(arreststotal) AS arreststotal,SUM(pointstotal) as pointstotal FROM playeroverall;";
$query=$con->query($sql);
$result = $query->fetch_object();

$scoretotal = $result->scoretotal;
$playertotal = $result->playertotal;
$killstotal = $result->killstotal;
$arreststotal = $result->arreststotal;
$pointstotal = $result->pointstotal;

$sql = "SELECT COUNT(*) AS roundtotal,SUM(round_time) AS timetotal FROM game;";
$query=$con->query($sql);
$result = $query->fetch_object();
$roundtotal = $result->roundtotal;
$timetotal  = $result->timetotal;
$timetotal = formatHM($timetotal);

$sql = "SELECT id FROM game ORDER BY id DESC LIMIT 1;";
$query=$con->query($sql);
$result = $query->fetch_object();
$lastgame_id = $result->id;
$lastgame_id_minus100 = $lastgame_id-100;

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

/**
 * Function
 * Top 10 Points
 */
function getpointers()
{
    global $con;
    $sql = "SELECT p.id,p.playername,p.countryiso,p.rank,p.pointstotal,l.rankname,l.id as rankid FROM playeroverall AS p JOIN ranklist AS l ON l.id = p.rank ORDER BY pointstotal DESC,scoretotal DESC LIMIT 10";
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
        $pointstotal = $data->pointstotal;

        $playertabledata = $playertabledata . "<tr data-id='$id'><td><b>$i</b></td><td><img data-toggle='tooltip' data-placement='top' title='".country_code_to_country($countryiso)."' src='images/flags/20_shiny/$countryiso.png'></td><td> <img data-toggle='tooltip' data-placement='top' title='$rankname' src='images/game/insignia/$rankid.png' height='22px'> </td><td><strong><a class='ainorange' href='./?statistics=player&detail=".urlencode($name)."'>$name</a></strong></td><td class='text-right'>$pointstotal</td></tr>";
    }
    return $playertabledata;
}

/**
 * Function
 * Top 10 Killers
 */
function getkillers()
{
    global $con;
    $sql = "SELECT p.id,p.playername,p.countryiso,p.rank,p.killstotal,l.rankname,l.id as rankid FROM playeroverall AS p JOIN ranklist AS l ON l.id = p.rank ORDER BY killstotal DESC,scoretotal DESC LIMIT 10";
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
        $killstotal = $data->killstotal;

        $playertabledata = $playertabledata . "<tr data-id='$id'><td><b>$i</b></td><td><img data-toggle='tooltip' data-placement='top' title='".country_code_to_country($countryiso)."' src='images/flags/20_shiny/$countryiso.png'></td><td> <img data-toggle='tooltip' data-placement='top' title='$rankname' src='images/game/insignia/$rankid.png' height='22px'> </td><td><strong><a class='ainorange' href='./?statistics=player&detail=".urlencode($name)."'>$name</a></strong></td><td class='text-right'>$killstotal</td></tr>";
    }
    return $playertabledata;
}

/**
 * Function
 * Top 10 Arresters
 */
function getarresters()
{
    global $con;
    $sql = "SELECT p.id,p.playername,p.countryiso,p.rank,p.arreststotal,l.rankname,l.id as rankid FROM playeroverall AS p JOIN ranklist AS l ON l.id = p.rank ORDER BY arreststotal DESC,arrestedtotal ASC LIMIT 10";
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
        $arreststotal = $data->arreststotal;

        $playertabledata = $playertabledata . "<tr data-id='$id'><td><b>$i</b></td><td><img data-toggle='tooltip' data-placement='top' title='".country_code_to_country($countryiso)."' src='images/flags/20_shiny/$countryiso.png'></td><td> <img data-toggle='tooltip' data-placement='top' title='$rankname' src='images/game/insignia/$rankid.png' height='22px'> </td><td><strong><a class='ainorange' href='./?statistics=player&detail=".urlencode($name)."'>$name</a></strong></td><td class='text-right'>$arreststotal</td></tr>";
    }
    return $playertabledata;
}

/**
 * Function
 * Top 10 Best KD ratio
 */
function getkdratio()
{
    global $con,$lastgame_id_minus100;
    $sql = "SELECT p.id,p.playername,p.countryiso,p.rank,p.killdeathratio,l.rankname,l.id as rankid FROM playeroverall AS p JOIN ranklist AS l ON l.id = p.rank WHERE killstotal > 300 AND gamelast >= $lastgame_id_minus100 ORDER BY killdeathratio DESC,killstotal DESC LIMIT 10";
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
        $kdratio = $data->killdeathratio;

        $playertabledata = $playertabledata . "<tr data-id='$id'><td><b>$i</b></td><td><img data-toggle='tooltip' data-placement='top' title='".country_code_to_country($countryiso)."' src='images/flags/20_shiny/$countryiso.png'></td><td> <img data-toggle='tooltip' data-placement='top' title='$rankname' src='images/game/insignia/$rankid.png' height='22px'> </td><td><strong><a class='ainorange' href='./?statistics=player&detail=".urlencode($name)."'>$name</a></strong></td><td class='text-right'>$kdratio</td></tr>";
    }
    return $playertabledata;
}

/**
 * Function
 * Top 10 A/Ar Ratio
 */
function getaaratio()
{
	global $lastgame_id_minus100;
    global $con;
    $sql = "SELECT p.id,p.playername,p.countryiso,p.rank,p.aaratio,l.rankname,l.id as rankid FROM playeroverall AS p JOIN ranklist AS l ON l.id = p.rank WHERE arreststotal > 100 AND gamelast >= $lastgame_id_minus100 ORDER BY aaratio DESC,arreststotal DESC LIMIT 10";
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
        $aaratio = $data->aaratio;

        $playertabledata = $playertabledata . "<tr data-id='$id'><td><b>$i</b></td><td><img data-toggle='tooltip' data-placement='top' title='".country_code_to_country($countryiso)."' src='images/flags/20_shiny/$countryiso.png'></td><td> <img data-toggle='tooltip' data-placement='top' title='$rankname' src='images/game/insignia/$rankid.png' height='22px'> </td><td><strong><a class='ainorange' href='./?statistics=player&detail=".urlencode($name)."'>$name</a></strong></td><td class='text-right'>$aaratio</td></tr>";
    }
    return $playertabledata;
}

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

?>

<div class="content">

<div class="row no-padding no-margin">
        <div class="block">
            <div class="block-bot">
                <div class="head">
                    <div class="head-cnt">
                        <h3>Server Statistics</h3>
                        <div class="cl">&nbsp;</div>
                    </div>
                </div>
                <div class="col-articles articles">
                    <div class="cl">&nbsp;</div>
                    <div class="padding15" style="background-color: #FFFFFF">

                        <table class="table borderless playerrecordtable no-margin">
                            <tbody><tr>
                                <td class="col-1">

                                </td>
                                <td class="col-2">
                                    Players
                                </td>
                                <td class="col-3">
                                    <strong><?=$playertotal?></strong>

                                </td>
                                <td class="col-4">

                                </td>
                                <td class="col-5">
                                    Rounds
                                </td>
                                <td class="col-6"><strong><?=$roundtotal?></strong>

                                </td>
                            </tr>
                            <tr>
                                <td class="col-1">

                                </td>
                                <td class="col-2">
                                    Score
                                </td>
                                <td class="col-3">
                                    <strong><?=$scoretotal?></strong>

                                </td>
                                <td class="col-4">

                                </td>
                                <td class="col-5">
                                    Points
                                </td>
                                <td class="col-6"><strong><?=$pointstotal?></strong>

                                </td>
                            </tr>
                            <tr>
                                <td class="col-1">

                                </td>
                                <td class="col-2">
                                    Kills
                                </td>
                                <td class="col-3">
                                    <strong><?=$killstotal?></strong>

                                </td>
                                <td class="col-4">

                                </td>
                                <td class="col-5">
                                    Arrests
                                </td>
                                <td class="col-6"><strong><?=$arreststotal?></strong>

                                </td>
                            </tr>
                            <tr>
                                <td class="col-1">

                                </td>
                                <td class="col-2">
                                    Time
                                </td>
                                <td class="col-3">
                                    <strong><?=$timetotal?></strong>

                                </td>
                                <td class="col-4">

                                </td>
                                <td class="col-5">Crashed</td>
                                <td class="col-6">
                                <strong>28</strong>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>

</div>
<!--/Tab Ends-->

</div>
<div class="cl">&nbsp;</div>
</div>
</div>


    <!-- Server Top 10 Players Tables-->

    <!-- ROW START-->
    <div class="row no-margin no-padding" style="color: #000">
        <!-- PANEL STARTS-->
        <div class="panel panel-info col-md-5 no-padding" style="width: 49%; margin-right: 13px;">
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
        <div class="panel panel-danger col-md-5 no-padding" style="width: 49%">
            <!-- Default panel contents -->
            <div class="panel-heading"><b>Top 10 Points</b></div>

            <!-- Table -->
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>F</th>
                    <th>R</th>
                    <th>Name</th>
                    <th class="text-right">Points</th>
                </tr>
                </thead>
                <tbody class="">

                <?=getpointers()?>

                </tbody>
            </table>
        </div>
        <!--Panel Ends -->
    </div>
    <!--Row ENDS -->


    <!-- ROW STARTS-->
    <div class="row no-margin no-padding" style="color: #000">
        <!-- PANEL STARTS-->
        <div class="panel panel-success col-md-5 no-padding" style="width: 49%; margin-right: 13px;">
            <!-- Default panel contents -->
            <div class="panel-heading"><b>Top 10 Killers</b></div>
            <!-- Table -->
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>F</th>
                    <th>R</th>
                    <th>Name</th>
                    <th class="text-right">Kills</th>
                </tr>
                </thead>
                <tbody class="">

                <?=getkillers()?>

                </tbody>

            </table>
        </div>
        <!--Panel Ends -->

        <!-- PANEL STARTS-->
        <div class="panel panel-warning col-md-5 no-padding" style="width: 49%">
            <!-- Default panel contents -->
            <div class="panel-heading"><b>Top 10 Arresters</b></div>

            <!-- Table -->
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>F</th>
                    <th>R</th>
                    <th>Name</th>
                    <th class="text-right">Arrests</th>
                </tr>
                </thead>
                <tbody class="">

                <?=getarresters()?>

                </tbody>
            </table>
        </div>
        <!--Panel Ends -->
    </div> <!--Row ENDS -->


    <!-- ROW STARTS-->
    <div class="row no-margin no-padding" style="color: #000">
        <!-- PANEL STARTS-->
        <div class="panel panel-info col-md-5 no-padding" style="width: 49%; margin-right: 13px;">
            <!-- Default panel contents -->
            <div class="panel-heading"><b>Top 10 Kill/Death Ratio</b></div>
            <!-- Table -->
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>F</th>
                    <th>R</th>
                    <th>Name</th>
                    <th class="text-right">KD Ratio</th>
                </tr>
                </thead>
                <tbody class="">

                <?=getkdratio()?>

                </tbody>

            </table>
        </div>
        <!--Panel Ends -->

        <!-- PANEL STARTS-->
        <div class="panel panel-danger col-md-5 no-padding" style="width: 49%">
            <!-- Default panel contents -->
            <div class="panel-heading"><b>Top 10 Arrest/Arrested Ratio</b></div>

            <!-- Table -->
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>F</th>
                    <th>R</th>
                    <th>Name</th>
                    <th class="text-right">A/A</th>
                </tr>
                </thead>
                <tbody class="">

                <?=getaaratio()?>

                </tbody>
            </table>
        </div>
        <!--Panel Ends -->
		
    </div> <!--Row ENDS -->
	
	<!-- ROW STARTS-->
    <div class="row no-margin no-padding" style="color: #000">
        <!-- PANEL STARTS-->
        <div class="panel panel-info col-md-5 no-padding" style="width: 49%; margin-right: 13px;">
            <!-- Default panel contents -->
            <div class="panel-heading"><b>Top 10 Ratings</b></div>
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
<!--ROW ENDS-->


</div>
