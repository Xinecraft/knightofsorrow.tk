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

ob_start();
require_once('../conf.php');
ini_set('display_errors', 1);
error_reporting(E_ERROR);
include_once('../pages/magicquotesgpc.php');
include_once('../pages/ip2locationlite.class.php');
include_once('../pages/generate_option.php');
include_once('../pages/imp_func_inc.php');
global $con;

$secretKey = "SecretX";

$data = $_GET['data'];

$data = $con->escape_string($data);

$data = explode("$$", $data);

$playerName = $data[0];
$playerIp = $data[1];
$bOffline = $data[2];
$key = $data[3];



if ($data == NULL || empty($data)) {
    exit();
}
if ($secretKey != $key && $bOffline == "no") {

    $playerGeo = getiplocation_json($playerIp);
    $playerCountryName = $playerGeo->countryName;
	printf("[c=FFFF00][b][u]%s[\\u][\\b][\\c] is from [b][c=FF7453]%s[\\c][\\b]", $playerName, $playerCountryName);
	exit();
        
}
elseif($secretKey == $key)
{

$sql = "SELECT id FROM game ORDER BY id DESC LIMIT 1;";
$query=$con->query($sql);
$result = $query->fetch_object();
$lastgame_id = $result->id;
$lastgame_id_minus100 = $lastgame_id-100;



/**
 * If the Searched Name is Not Present in Server :
 *
 */
$cnt=0;
if ($bOffline == "yes")
{
	// If player queried for top 10 players list
	if(strtolower($playerName) == "top 10")
	{
		$sql = "SELECT position,playername FROM playeroverall ORDER BY position LIMIT 10;";
		$query = $con->query($sql);
		$top10data = "[b][c=FF6200][u]Top 10 Players[\\u][\\c][\\b]\n";
		while($result = $query->fetch_object())
		{
			if($cnt%2 == 0)
			$top10data = $top10data."   [b][c=FFFFFF]#".$result->position."[\\c] [c=FFFF00]".$result->playername."[\\c][\\b]   -- ";
			else
			$top10data = $top10data."   [b][c=FFFFFF]#".$result->position."[\\c] [c=FFFF00]".$result->playername."[\\c][\\b]\n";
		$cnt++;
		}
		echo $top10data;
	}
	else if(strtolower($playerName) == "top 10 kdr" || strtolower($playerName) == "top 10 kd" || strtolower($playerName) == "top 10 kdratio")
	{
	$sql = "SELECT p.id,p.playername,p.countryiso,p.rank,p.killdeathratio,l.rankname,l.id as rankid FROM playeroverall AS p JOIN ranklist AS l ON l.id = p.rank WHERE killstotal > 300 AND gamelast >= $lastgame_id_minus100 ORDER BY killdeathratio DESC,killstotal DESC LIMIT 10";
    $query = $con->query($sql);
	
    $playertabledata = '';
    $i=0;
	$playertabledata = "[b][c=FF6200][u]Top 10 Kill/Death Ratio[\\u][\\c][\\b]\n";
    while($data=$query->fetch_object())
    {
        $i++;
        $id = $data->id;
        $name = $data->playername;
        $kdratio = $data->killdeathratio;
		
		if($cnt%2 == 0)
        $playertabledata = $playertabledata . "[b][c=FFFFFF]#".$i."[\\c] [c=FFFF00]".$name."[\\c] : [c=FF7453]".$kdratio."[\\c]   --   ";
		else
		$playertabledata = $playertabledata . "[b][c=FFFFFF]#".$i."[\\c] [c=FFFF00]".$name."[\\c] : [c=FF7453]".$kdratio."[\\c]\n";
    $cnt++;
	}
    echo $playertabledata;
	}
	else if(strtolower($playerName) == "top 10 aaratio" || strtolower($playerName) == "top 10 aar" || strtolower($playerName) == "top 10 aa")
	{
	$sql = "SELECT p.id,p.playername,p.countryiso,p.rank,p.aaratio,l.rankname,l.id as rankid FROM playeroverall AS p JOIN ranklist AS l ON l.id = p.rank WHERE arreststotal > 100 AND gamelast >= $lastgame_id_minus100 ORDER BY aaratio DESC,arreststotal DESC LIMIT 10";
    $query = $con->query($sql);
	
    $playertabledata = '';
    $i=0;
	$playertabledata = "[b][c=FF6200][u]Top 10 Arrest/Arrested Ratio[\\u][\\c][\\b]\n";
    while($data=$query->fetch_object())
    {
        $i++;
        $id = $data->id;
        $name = $data->playername;
        $aaratio = $data->aaratio;
		
		if($cnt%2 == 0)
        $playertabledata = $playertabledata . "[b][c=FFFFFF]#".$i."[\\c] [c=FFFF00]".$name."[\\c] : [c=FF7453]".$aaratio."[\\c]  --  ";
		else
		$playertabledata = $playertabledata . "[b][c=FFFFFF]#".$i."[\\c] [c=FFFF00]".$name."[\\c] : [c=FF7453]".$aaratio."[\\c]\n";
	$cnt++;
	}
    echo $playertabledata;
	}
	
	//If top 10 Rating
	else if(strtolower($playerName) == "top 10 rating" || strtolower($playerName) == "top 10 r" || strtolower($playerName) == "top 10 rate" || strtolower($playerName) == "top 10 skill" || strtolower($playerName) == "top 10 pro")
	{
	$sql = "SELECT p.id,p.playername,p.rating,p.countryiso,p.rank,p.aaratio,l.rankname,l.id as rankid FROM playeroverall AS p JOIN ranklist AS l ON l.id = p.rank WHERE gamelast >= $lastgame_id_minus100 ORDER BY rating DESC,scoretotal DESC LIMIT 10";
	$query = $con->query($sql);
	
    $playertabledata = '';
    $i=0;
	$playertabledata = "[b][c=FF6200][u]Top 10 Rating[\\u][\\c][\\b]\n";
    while($data=$query->fetch_object())
    {
        $i++;
        $id = $data->id;
        $name = $data->playername;
        $rating = $data->rating;
		
		if($cnt%2 == 0)
        $playertabledata = $playertabledata . "[b][c=FFFFFF]#".$i."[\\c] [c=FFFF00]".$name."[\\c] : [c=FF7453]".$rating."[\\c]  --  ";
		else
		$playertabledata = $playertabledata . "[b][c=FFFFFF]#".$i."[\\c] [c=FFFF00]".$name."[\\c] : [c=FF7453]".$rating."[\\c]\n";
	$cnt++;
	}
    echo $playertabledata;
	}
	
	// If search for playername
	else
	{
    //$sql = "SELECT p.id as id,,p.name as name,f.country as country,SUM(p.score) as score,sum(p.time) as time,MAX(p.score) as bestscore,a.profile as aliasprofile,f.game_last as game_last FROM player p JOIN alias as a ON p.alias=a.id JOIN profile as f ON f.id=a.profile WHERE p.name LIKE '%$playerName%' GROUP BY p.name";
    $sql = "SELECT p.id as id,p.profile as profileid,p.playername as name,p.countryiso as country,p.scoretotal as score,p.timetotal as time,p.highestscore as bestscore,a.profile as aliasprofile,p.gamefirst as game_first,p.gamelast as game_last,r.rankname,p.rank,p.position FROM playeroverall p JOIN alias a ON p.alias = a.id JOIN ranklist as r ON p.rank=r.id WHERE p.playername LIKE '%$playerName%'";
    $query = $con->query($sql);

    /**
     * No Player matched with the provided query string
     */
    if ($query->num_rows <= 0) {
        printf("No Players found with name [b]'%s'[\\b]",$playerName);
    }

    /**
     * Only one (1) player found with the query string
     */
    else if ($query->num_rows == 1) {
        $player = $query->fetch_object();
        $iplayerid = $player->profileid;
        $gameLast = $player->game_last;
        $iplayerName = $player->name;
        $iplayerCountry = country_code_to_country($player->country);
        $totalscore = $player->score;
        $totalsec = $player->time;
        $bestscore = $player->bestscore;
        $rankid = $player->rank;
        $rankname = $player->rankname;
        $position = $player->position;
        $totalmin = $totalsec / 60;
        $scorepermin = $totalscore / $totalmin;
        $lastseen = $con->query("SELECT date_finished,server_time FROM game WHERE id='$gameLast' LIMIT 1;");
        $lastseen = $lastseen->fetch_object();
        $lastseen = $lastseen->server_time;

        printf("[c=FFFF00][b][u]%s[\\u][\\b][\\c] is from [b][c=FF7453]%s[\\c][\\b]\n", $iplayerName, $iplayerCountry);
        printf("[b][c=FFFF00][u]%s[\\u][\\c][\\b]'s Position: [c=FF7453][b][u]#%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Score: [c=FF7453][b][u]%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Rank: [c=FF7453][b][u]%s[\\u][\\b][\\c]\n", $iplayerName, $position,$totalscore,$rankname);
        printf("Score Per Min: [c=FF7453][b][u]%.2f points[\\u][\\b][\\c] [c=00FF00]-[\\c] Highest Score: [c=FF7453][b][u]%d[\\u][\\b][\\c]\n", $scorepermin, $bestscore);
        printf("Time Played: [c=FF7453][b][u]%s[\\u][\\b][\\c] [c=00ff00]-[\\c] Last Seen: [c=FF7453][b][u]%s[\\u][\\b][\\c]", formatHM($totalsec), timeago2($lastseen-3600));
        //printf("Nice to see Him online\\n here at for his dsd\\n");
        $alias = $con->query("SELECT name FROM alias WHERE profile='$iplayerid' AND name NOT LIKE '$iplayerName' LIMIT 3");
        if ($alias->num_rows > 0) {
            while ($row = $alias->fetch_object()) {
                $aliasname = $aliasname."[c=ffff00]". $row->name . "[\\c][c=00ff00] - [\\c]";
            }
            $aliasname = substr($aliasname, 0, -17);
            printf("\nAlso known as: [b]%s[\\b]", $aliasname);
        }
    }


    /**
     * More than one player found with that query String
     * But Still the name provided matches the Exact one amoung many so display the Exact matching Playername
     */
    else
    {
        //$sql = "SELECT P.id,A.name,A.profile,P.country,P.game_last FROM alias A,profile P WHERE A.name LIKE '$playerName' AND A.profile=P.id;";
        $sql = "SELECT p.id as id,p.profile as profileid,p.playername as name,p.countryiso as country,p.scoretotal as score,p.timetotal as time,p.highestscore as bestscore,a.profile as aliasprofile,p.gamefirst as game_first,p.gamelast as game_last,r.rankname,p.rank,p.position FROM playeroverall p JOIN alias a ON p.alias = a.id JOIN ranklist as r ON p.rank=r.id WHERE p.playername LIKE '$playerName'";
        $query = $con->query($sql);
        if($query->num_rows == 1)
        {
            $player = $query->fetch_object();
            $iplayerid = $player->profileid;
            $gameLast = $player->game_last;
            $iplayerName = $player->name;
            $iplayerCountry = country_code_to_country($player->country);
            $totalscore = $player->score;
            $totalsec = $player->time;
            $bestscore = $player->bestscore;
            $rankid = $player->rank;
            $rankname = $player->rankname;
            $position = $player->position;
            $totalmin = $totalsec / 60;
            $scorepermin = $totalscore / $totalmin;
            $lastseen = $con->query("SELECT date_finished,server_time FROM game WHERE id='$gameLast' LIMIT 1;");
            $lastseen = $lastseen->fetch_object();
            $lastseen = $lastseen->server_time;

            printf("[c=FFFF00][b][u]%s[\\u][\\b][\\c] is from [b][c=FF7453]%s[\\c][\\b]\n", $iplayerName, $iplayerCountry);
            printf("[b][c=FFFF00][u]%s[\\u][\\c][\\b]'s Position: [c=FF7453][b][u]#%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Score: [c=FF7453][b][u]%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Rank: [c=FF7453][b][u]%s[\\u][\\b][\\c]\n", $iplayerName, $position,$totalscore,$rankname);
            printf("Score Per Min: [c=FF7453][b][u]%.2f points[\\u][\\b][\\c] [c=00FF00]-[\\c] Highest Score: [c=FF7453][b][u]%d[\\u][\\b][\\c]\n", $scorepermin, $bestscore);
            printf("Time Played: [c=FF7453][b][u]%s[\\u][\\b][\\c] [c=00ff00]-[\\c] Last Seen: [c=FF7453][b][u]%s[\\u][\\b][\\c]", formatHM($totalsec), timeago2($lastseen-3600));
            //printf("Nice to see Him online\\n here at for his dsd\\n");
            $alias = $con->query("SELECT name FROM alias WHERE profile='$iplayerid' AND name NOT LIKE '$iplayerName' LIMIT 3");
            if ($alias->num_rows > 0) {
                while ($row = $alias->fetch_object()) {
                    $aliasname = $aliasname."[c=ffff00]". $row->name . "[\\c][c=00ff00] - [\\c]";
                }
                $aliasname = substr($aliasname, 0, -17);
                printf("\nAlso known as: [b]%s[\\b]", $aliasname);
            }
        }

        /**
         * Display the list of Matching Player limit by X
         */
        else {
            $sql = "SELECT p.id as id,p.profile as profileid,p.playername as name,p.countryiso as country,p.scoretotal as score,p.timetotal as time,p.highestscore as bestscore,a.profile as aliasprofile,p.gamefirst as game_first,p.gamelast as game_last,r.rankname,p.rank,p.position FROM playeroverall p JOIN alias a ON p.alias = a.id JOIN ranklist as r ON p.rank=r.id WHERE p.playername LIKE '%$playerName%';";
            $query = $con->query($sql);
            while ($player = $query->fetch_object()) {
                // If the limit exceed 4 players then only show 4
                if ($i == 5)
                    break;
                $playerlist = $playerlist ."[c=FFFF00]". $player->name . "[\\c][c=00ff00] - [\\c]";
                $i++;
            }
            $numberofmatch = $query->num_rows;
            $playerlist = substr($playerlist, 0, -17);
            printf("Found [b]%s[\\b] players matching [b]%s[\\b]: [b]%s[\\b]", $numberofmatch, $playerName, $playerlist);
        }
		}
    }
}


/**
 * If player name queried for is already present in Server
 * i.e, the player name queried for is Live in server....
 */
else if ($bOffline == "no") {
    $playerGeo = getiplocation_json($playerIp);
    $playerCountryName = $playerGeo->countryName;
    //$profile = $con->query("SELECT P.id,A.name,A.profile,P.country,P.game_last FROM alias A,profile P WHERE A.name LIKE '$playerName' AND A.profile=P.id;");
    $profile = $con->query("SELECT p.id as id,p.profile as profileid,p.playername as name,p.countryiso as country,p.scoretotal as score,p.timetotal as time,p.highestscore as bestscore,a.profile as aliasprofile,p.gamefirst as game_first,p.gamelast as game_last,r.rankname,p.rank,p.position FROM playeroverall p JOIN alias a ON p.alias = a.id JOIN ranklist as r ON p.rank=r.id WHERE p.playername LIKE '$playerName';");
    /**
     * Check if this player has played in server or not.
     * DO this if Player is new to server.
     */

    if ($profile->num_rows <= 0)
    {
        printf("[c=FFFF00][b][u]%s[\\u][\\b][\\c] is from [b][c=FF7453]%s[\\c][\\b]", $playerName, $playerCountryName);
        //printf("[c=FFFFFF][b]%s[\\b][\\c] is seen here for the first time.\n", $playerName);
    }
    /**
     * Check if this player has played before or not
     * Do this if player is old mate :)
     */ else {

        $player = $profile->fetch_object();
        $iplayerid = $player->profileid;
        $gameLast = $player->game_last;
        $iplayerName = $player->name;
        $iplayerCountry = country_code_to_country($player->country);
        $totalscore = $player->score;
        $totalsec = $player->time;
        $bestscore = $player->bestscore;
        $rankid = $player->rank;
        $rankname = $player->rankname;
        $position = $player->position;
        $totalmin = $totalsec / 60;
        $scorepermin = $totalscore / $totalmin;
        $lastseen = "Online";


        printf("[c=FFFF00][b][u]%s[\\u][\\b][\\c] is from [b][c=FF7453]%s[\\c][\\b]\n", $iplayerName, $playerCountryName);
        printf("[b][c=FFFF00][u]%s[\\u][\\c][\\b]'s Position: [c=FF7453][b][u]#%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Score: [c=FF7453][b][u]%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Rank: [c=FF7453][b][u]%s[\\u][\\b][\\c]\n", $iplayerName, $position,$totalscore,$rankname);
        printf("Score Per Min: [c=FF7453][b][u]%.2f points[\\u][\\b][\\c] [c=00FF00]-[\\c] Highest Score: [c=FF7453][b][u]%d[\\u][\\b][\\c]\n", $scorepermin, $bestscore);
        printf("Time Played: [c=FF7453][b][u]%s[\\u][\\b][\\c] [c=00ff00]-[\\c] Last Seen: [c=00FF00][b][u]%s[\\u][\\b][\\c]", formatHM($totalsec), $lastseen);

        $alias = $con->query("SELECT name FROM alias WHERE profile='$iplayerid' AND name NOT LIKE '$iplayerName' LIMIT 3");
        if ($alias->num_rows > 0) {
            while ($row = $alias->fetch_object()) {
                $aliasname = $aliasname ."[c=FFFF00]". $row->name . "[\\c][c=00ff00] - [\\c]";
            }
            $aliasname = substr($aliasname, 0, -17);
            printf("\nAlso known as: [b]%s[\\b]", $aliasname);
        }
    }
}


/**
 * Send this for the Player Joining the server if whois on join is enabled in Server
 */
elseif($bOffline == "justjoined"){
    $playerGeo = getiplocation_json($playerIp);
    $playerCountryName = $playerGeo->countryName;
    //$profile = $con->query("SELECT P.id,A.name,A.profile,P.country,P.game_last FROM alias A,profile P WHERE A.name LIKE '$playerName' AND A.profile=P.id;");
    $profile = $con->query("SELECT p.id as id,p.profile as profileid,p.playername as name,p.countryiso as country,p.scoretotal as score,p.timetotal as time,p.highestscore as bestscore,a.profile as aliasprofile,p.gamefirst as game_first,p.gamelast as game_last,r.rankname,p.rank,p.position FROM playeroverall p JOIN alias a ON p.alias = a.id JOIN ranklist as r ON p.rank=r.id WHERE p.playername LIKE '$playerName';");
    /**
     * Check if this player has played in server or not.
     * DO this if Player is new to server.
     */

    if ($profile->num_rows <= 0)
    {
        printf("[c=FFFF00][b][u]%s[\\u][\\b][\\c] is coming from [b][c=FF7453]%s[\\c][\\b]", $playerName, $playerCountryName);
        //printf("[c=FFFFFF][b]%s[\\b][\\c] is seen here for the first time.\n", $playerName);
    }
    /**
     * Check if this player has played before or not
     * Do this if player is old mate :)
     */ else {

        $player = $profile->fetch_object();
        $iplayerid = $player->profileid;
        $gameLast = $player->game_last;
        $iplayerName = $player->name;
        $iplayerCountry = country_code_to_country($player->country);
        $totalscore = $player->score;
        $totalsec = $player->time;
        $bestscore = $player->bestscore;
        $rankid = $player->rank;
        $rankname = $player->rankname;
        $position = $player->position;
        $totalmin = $totalsec / 60;
        $scorepermin = $totalscore / $totalmin;
		$lastseen = $con->query("SELECT date_finished,server_time FROM game WHERE id='$gameLast' LIMIT 1;");
        $lastseen = $lastseen->fetch_object();
        $lastseen = $lastseen->server_time;


        printf("[c=FFFF00][b][u]%s[\\u][\\b][\\c] is coming from [b][c=FF7453]%s[\\c][\\b]\n", $iplayerName, $playerCountryName);
        printf("[b][c=FFFF00][u]%s[\\u][\\c][\\b]'s Position: [c=FF7453][b][u]#%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Score: [c=FF7453][b][u]%d[\\u][\\b][\\c] [c=00FF00]-[\\c] Rank: [c=FF7453][b][u]%s[\\u][\\b][\\c]\n", $iplayerName, $position,$totalscore,$rankname);
        printf("Score Per Min: [c=FF7453][b][u]%.2f points[\\u][\\b][\\c] [c=00FF00]-[\\c] Highest Score: [c=FF7453][b][u]%d[\\u][\\b][\\c]\n", $scorepermin, $bestscore);
        printf("Time Played: [c=FF7453][b][u]%s[\\u][\\b][\\c] [c=00ff00]-[\\c] Last Seen: [c=FF7453][b][u]%s[\\u][\\b][\\c]", formatHM($totalsec), timeago2($lastseen-3600));

        $alias = $con->query("SELECT name FROM alias WHERE profile='$iplayerid' AND name NOT LIKE '$iplayerName' LIMIT 3");
        if ($alias->num_rows > 0) {
            while ($row = $alias->fetch_object()) {
                $aliasname = $aliasname ."[c=FFFF00]". $row->name . "[\\c][c=00ff00] - [\\c]";
            }
            $aliasname = substr($aliasname, 0, -17);
            printf("\nAlso known as: [b]%s[\\b]", $aliasname);
        }
    }
}
}
?>