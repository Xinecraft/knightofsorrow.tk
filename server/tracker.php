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
ini_set('display_errors', 0);
error_reporting(E_ERROR);
include_once('../pages/magicquotesgpc.php');
include_once('../pages/ip2locationlite.class.php');
include_once('../pages/generate_option.php');
include_once('../pages/imp_func_inc.php');
global $con;

if (!$con) {
    die("404 - Tracker is not Found");
}

$array = $_POST;


/**
 *  Unique identifier for this particular data set
 */
$tag = '0';                    // Array[0]

if (array_key_exists(0, $array) && $array[0] != NULL)
    $tag = $con->escape_string($array[0]);
/**
 *  Mod version
 */
$version = '0';                    //Array[1]

if (array_key_exists(1, $array) && $array[1] != NULL)
    $version = $con->escape_string($array[1]);

/**
 *  Join port number
 */
$joinport = 0;                   //Array[2]

if (array_key_exists(2, $array) && $array[2] != NULL)
    $joinport = $con->escape_string($array[2]);

/**
 *  Server time in the format of Unix Timestamp
 * The server declares itself to be in UTC timezone, which makes this value untrustworthy
 * On the other hand this is an excellent argument value for hashing
 */
$timestamp = 0;                  //Array[3]

if (array_key_exists(3, $array) && $array[3] != NULL)
    $timestamp = $con->escape_string($array[3]);

/**
 *  Last 32 bits of an md5 encoded request signature hash
 * The original hash is a product of the following parameters:
 * `server key` + `join port` + `timestamp`
 */
$hash = '0';                       //Array[4]

if (array_key_exists(4, $array) && $array[4] != NULL)
    $hash = $con->escape_string($array[4]);

/**
 * Game title
 * 0 - SWAT4
 * 1 - SWAT4X
 */
$gamename = 0;                   //Array[5]

if (array_key_exists(5, $array) && $array[5] != NULL)
    $gamename = $con->escape_string($array[5]);

/**
 * Game version
 */
$gameversion = 0;                //Array[6]

if (array_key_exists(6, $array) && $array[6] != NULL)
    $gameversion = $con->escape_string($array[6]);

/**
 * Hostname
 */
$hostname = '0';                   //Array[7]

if (array_key_exists(7, $array) && $array[7] != NULL)
    $hostname = $con->escape_string($array[7]);

/**
 * Gametype
 *  '0': 'Barricaded Suspects',
  '1': 'VIP Escort',
  '2': 'Rapid Deployment',
  '3': 'CO-OP',
  '4': 'Smash And Grab',
 */
$gametype = 0;                   //Array[8]

if (array_key_exists(8, $array) && $array[8] != NULL)
    $gametype = $con->escape_string($array[8]);


/**
 * Map
 *
 * '0': 'A-Bomb Nightclub',
  '1': 'Brewer County Courthouse',
  '2': 'Children of Taronne Tenement',
  '3': 'DuPlessis Diamond Center',
  '4': 'Enverstar Power Plant',
  '5': 'Fairfax Residence',
  '6': 'Food Wall Restaurant',
  '7': 'Meat Barn Restaurant',
  '8': 'Mt. Threshold Research Center',
  '9': 'Northside Vending',
  '10': 'Old Granite Hotel',
  '11': 'Qwik Fuel Convenience Store',
  '12': 'Red Library Offices',
  '13': 'Riverside Training Facility',
  '14': 'St. Michael\'s Medical Center',
  '15': 'The Wolcott Projects',
  '16': 'Victory Imports Auto Center',
  '17': '-EXP- Department of Agriculture',
  '18': '-EXP- Drug Lab',
  '19': '-EXP- Fresnal St. Station',
  '20': '-EXP- FunTime Amusements',
  '21': '-EXP- Sellers Street Auditorium',
  '22': '-EXP- Sisters of Mercy Hostel',
  '23': '-EXP- Stetchkov Warehouse',
 */
$map = 0;                        //Array[9]

if (array_key_exists(9, $array) && $array[9] != NULL)
    $map = $con->escape_string($array[9]);

/**
 * Is server is pasword protected
 * type bool
 * 0 - no
 * 1 - yes
 */
$passworded = 0;                 //Array[10]

if (array_key_exists(10, $array) && $array[10] != NULL)
    $passworded = $con->escape_string($array[10]);


/**
 * Total number of players in Server
 * @type integer
 */
$player_num = 0;                 //Array[11]

if (array_key_exists(11, $array) && $array[11] != NULL)
    $player_num = $con->escape_string($array[11]);


/**
 * Max player limit of server
 * @type int
 */
$player_max = 0;                 //Array[12]

if (array_key_exists(12, $array) && $array[12] != NULL)
    $player_max = $con->escape_string($array[12]);


/**
 * Current Round Index
 * @type int
 */
$round_num = 0;                  //Array[13]

if (array_key_exists(13, $array) && $array[13] != NULL)
    $round_num = $con->escape_string($array[13]);


/**
 * Rounds per map
 * @type int
 */
$round_max = 0;                  //Array[14]

if (array_key_exists(14, $array) && $array[14] != NULL)
    $round_max = $con->escape_string($array[14]);

/**
 * Time elapsed since the round start in sec
 */
$time_absolute = 0;              //Array[15]

if (array_key_exists(15, $array) && $array[15] != NULL)
    $time_absolute = $con->escape_string($array[15]);


/**
 * Time the game has actually span in sec
 * @note usutally same a above
 */
$time = 0;                       //Array[16]

if (array_key_exists(16, $array) && $array[16] != NULL)
    $time = $con->escape_string($array[16]);


/**
 * Round time limit
 */
$time_limit = 0;                  //Array[17]

if (array_key_exists(17, $array) && $array[17] != NULL)
    $time_limit = $con->escape_string($array[17]);


/**
 * Number of SWAT victories
 */
$vict_swat = 0;                  //Array[18]

if (array_key_exists(18, $array) && $array[18] != NULL)
    $vict_swat = $con->escape_string($array[18]);


/**
 * Number of Suspects victories
 */
$vict_sus = 0;                    //Array[19]

if (array_key_exists(19, $array) && $array[19] != NULL)
    $vict_sus = $con->escape_string($array[19]);


/**
 * SWAT score
 */
$score_swat = 0;                  //Array[20]

if (array_key_exists(20, $array) && $array[20] != NULL)
    $score_swat = $con->escape_string($array[20]);


/**
 * Suspects score
 */
$score_sus = 0;                  //Array[21]

if (array_key_exists(21, $array) && $array[21] != NULL)
    $score_sus = $con->escape_string($array[21]);


/**
 * Round outcome
 *
  '0' : 'none',
  '1' : 'swat_bs',            # SWAT victory in Barricaded Suspects
  '2' : 'sus_bs',             # Suspects victory in Barricaded Suspects
  '3' : 'swat_rd',            # SWAT victory in Rapid Deployment (all bombs have been exploded)
  '4' : 'sus_rd',             # Suspects victory in Rapid Deployment (all bombs have been deactivated)
  '5' : 'tie',                # A tie
  '6' : 'swat_vip_escape',    # SWAT victory in VIP Escort - The VIP has escaped
  '7' : 'sus_vip_good_kill',  # Suspects victory in VIP Escort - Suspects have executed the VIP
  '8' : 'swat_vip_bad_kill',  # SWAT victory in VIP Escort - Suspects have killed the VIP
  '9' : 'sus_vip_bad_kill',   # Suspects victory in VIP Escort - SWAT have killed the VIP
  '10': 'coop_completed',     # COOP objectives have been completed
  '11': 'coop_failed',        # COOP objectives have been failed
  '12': 'swat_sg',            # SWAT victory in Smash and Grab
  '13': 'sus_sg',             # Suspects victory in Smash and Grab
 */
$outcome = 0;                    //Array[22]

if (array_key_exists(22, $array) && $array[22] != NULL)
    $outcome = $con->escape_string($array[22]);


/**
 * Number of bombs defused
 */
$bombs_defused = 0;                  //Array[23]

if (array_key_exists(23, $array) && $array[23] != NULL)
    $bombs_defused = $con->escape_string($array[23]);


/**
 *  Total number of points(bomb)
 */
$bombs_total = 0;                    //Array[24]

if (array_key_exists(24, $array) && $array[24] != NULL)
    $bombs_total = $con->escape_string($array[24]);




/**
 * List of COOP objectives
 * @type 2D Array
 *
 *          0 - name =>
 *                      '0' : 'Arrest_Jennings',
  '1' : 'Custom_NoCiviliansInjured',
  '2' : 'Custom_NoOfficersInjured',
  '3' : 'Custom_NoOfficersKilled',
  '4' : 'Custom_NoSuspectsKilled',
  '5' : 'Custom_PlayerUninjured',
  '6' : 'Custom_Timed',
  '7' : 'Disable_Bombs',
  '8' : 'Disable_Office_Bombs',
  '9' : 'Investigate_Laundromat',
  '10': 'Neutralize_Alice',
  '11': 'Neutralize_All_Enemies',
  '12': 'Neutralize_Arias',
  '13': 'Neutralize_CultLeader',
  '14': 'Neutralize_Georgiev',
  '15': 'Neutralize_Grover',
  '16': 'Neutralize_GunBroker',
  '17': 'Neutralize_Jimenez',
  '18': 'Neutralize_Killer',
  '19': 'Neutralize_Kiril',
  '20': 'Neutralize_Koshka',
  '21': 'Neutralize_Kruse',
  '22': 'Neutralize_Norman',
  '23': 'Neutralize_TerrorLeader',
  '24': 'Neutralize_Todor',
  '25': 'Rescue_Adams',
  '26': 'Rescue_All_Hostages',
  '27': 'Rescue_Altman',
  '28': 'Rescue_Baccus',
  '29': 'Rescue_Bettencourt',
  '30': 'Rescue_Bogard',
  '31': 'Rescue_CEO',
  '32': 'Rescue_Diplomat',
  '33': 'Rescue_Fillinger',
  '34': 'Rescue_Kline',
  '35': 'Rescue_Macarthur',
  '36': 'Rescue_Rosenstein',
  '37': 'Rescue_Sterling',
  '38': 'Rescue_Victims',
  '39': 'Rescue_Walsh',
  '40': 'Rescue_Wilkins',
  '41': 'Rescue_Winston',
  '42': 'Secure_Briefcase',
  '43': 'Secure_Weapon'
 *      1 - status =>
  '0': 'progress',
  '1': 'completed',
  '2': 'failed'
 */
$coop_objectives = Array();                //Array[25]
$coop_objectives_name = 0;
$coop_objectives_status = 0;


if (array_key_exists(25, $array) && $array[25] != NULL) {
    $coop_objectives = $array[25];
    $coop_objectives_name = $con->escape_string($coop_objectives[0]);
    $coop_objectives_status = $con->escape_string($coop_objectives[1]);
}

/**
 * List of COOP procedures
 * @type 2D Array
 *
 *          0 - name =>
  '0' : 'bonus_suspect_incapped',
  '1' : 'bonus_suspect_arrested',
  '2' : 'bonus_mission_completed',
  '3' : 'penalty_officer_unevacuated',
  '4' : 'bonus_suspect_killed',
  '5' : 'bonus_all_hostages_uninjured',
  '6' : 'penalty_hostage_incapped',
  '7' : 'penalty_hostage_killed',
  '8' : 'penalty_officer_incapped',
  '9' : 'penalty_officer_injured',
  '10': 'bonus_officer_alive',
  '11': 'bonus_all_suspects_alive',
  '12': 'penalty_deadly_force',
  '13': 'penalty_force',
  '14': 'bonus_officer_uninjured',
  '15': 'penalty_evidence_destroyed',
  '16': 'penalty_suspect_escaped',
  '17': 'bonus_character_reported',
  '18': 'bonus_evidence_secured'
 *          1 - status  //Int
 *          2 - score   //Int
 *
 */
$coop_procedures = Array();               //Array[26]
$coop_procedures_name = 0;
$coop_procedures_status=0;
$coop_procedures_score = 0;

if (array_key_exists(26, $array) && $array[26] != NULL) {
    $coop_procedures = $array[26];
    $coop_procedures_name = $con->escape_string($coop_procedures[0]);
    $coop_procedures_status = $con->escape_string($coop_procedures[1]);
    $coop_procedures_score = $con->escape_string($coop_procedures[2]);
}


/**
 * @Table GAME
 * Putting all the Game Round Info to the Db table `game`
 */
$sql = "INSERT INTO `game` (`id`, `server`, `tag`, `server_time`, `round_time`, `gametype`,"
        . " `outcome`, `mapname`, `player_num`, `score_swat`, `score_sus`, `vict_swat`, `vict_sus`,"
        . " `rd_bombs_defused`, `rd_bomb_total`, `coop_score`, `date_finished`, `player_of_round`)"
        . " VALUES (NULL, '0', '$tag', '$timestamp', '$time', '$gametype', '$outcome', '$map', '$player_num',"
        . " '$score_swat', '$score_sus', '$vict_swat', '$vict_sus', '$bombs_defused', '$bombs_total', '0',"
        . " CURRENT_TIMESTAMP, NULL);";
if($query = $con->query($sql))
{
$game_insert_id = $con->insert_id;

/**
 * Player list
 * @type mD Array
 *  All Players are listed from 0 - $player_num-1 into inner array
 *  For Example $player[0][1] will have ID of first player
 *
 * 0    -   id          # ID of the Player
 * 1    -   ip          # IP Address of Player
 * 2    -   dropped     # Is Player dropped?
 * 3    -   admin       # Is Player a Admin?
 * 4    -   vip         # Is Player a VIP? . In VIP Mode
 * 5    -   name        # Player name
 * 6    -   team =>     # Array of Player's team
 *          0   -  swat
 *          1   -  suspect
 * 7    -   time        # Time the Player played the round
 * 8    -   score       # Total Score of the Player for the round
 * 9    -   kills       # Total Kills of the Player for the round
 * 10   -   teamkills   # Total Team Kills of the Player for the round
 * 11   -   deaths      # Total Deaths of the Player for the round
 * 12   -   suicides    # Total suicides of player for the round
 * 13   -   arrests     # Total Arrests of the Player for the round
 * 14   -   arrested    # Total Arrested action of the Player for the Round
 * 15   -   kill_streak # Best Kill Streak of the Player for that round
 * 16   -   arrest_streak   # Best Arrest Streak of the Player
 * 17   -   death_streak    # Best Death Streak of that player
 * 18   -   vip_captures    # the Player has captured VIP
 * 19   -   vip_rescues     # the Player has rescued the VIP
 * 20   -   vip_escapes     # the Player has escaped as VIP
 * 21   -   vip_kills_valid # The Player has killed VIP after time
 * 22   -   vip_kills_invalid   # The Player has Killed VIP before time
 * 23   -   rd_bombs_defused    # Number of Bomb defused by Player
 * 24   -   rd_crybaby          #
 * 25   -   sg_kills            #Smash and Grab Kills
 * 26   -   sg_escapes
 * 27   -   sg_crybaby
 * 28   -   coop_hostage_arrests# Total num of COOP hostage arrested
 * 29   -   coop_hostage_hits   # Total hostages hits in COOP mode
 * 30   -   coop_hostage_incaps # Total hostages incap by player in coop
 * 31   -   coop_hostage_kills  # Total hostages killed by player
 * 32   -   coop_enemy_arrests
 * 33   -   coop_enemy_incaps
 * 34   -   coop_enemy_kills
 * 35   -   coop_enemy_incaps_invalid
 * 36   -   coop_enemy_kills_invalid
 * 37   -   coop_toc_reports
 * 38   -   coop_status  =>
 *              '0': 'not_ready',
  '1': 'ready',
  '2': 'healthy',
  '3': 'injured',
  '4': 'incapacitated',
 * 39   -   loadout =>             # Player last Loadout of that round
 *              0   -   primary             # Primary Weapon ID
 *              1   -   primary_ammo        # Primary weapon ammo
 *              2   -   secondary           # Secondary weapon
 *              3   -   secondary_ammo      # Secondary weapon ammo
 *              4   -   equip_one           # Equipment Slot 1
 *              5   -   equip_two           # Equipment slot 2
 *              6   -   equip_three         # Equipment slot 3
 *              7   -   equip_four          # Equipment slot 4
 *              8   -   equip_five          # Equipment slot 5
 *              9   -   breacher            # Breacher
 *              10  -   body                # Body Armour
 *              11  -   head                # Head armor
 * 40   -   weapons =>          # Used Weapons for the Player in that Round
 *      All the Weapons will be stored from 0 to X as per uses and weapon details will contain in inner array
 *      Example weapns[1][0] will have second weapon name
 *
 *              0   -   name                # Weapon Name
 *              1   -   time                # Time Used
 *              2   -   shots               # Shots fired
 *              3   -   hits                # Hits
 *              4   -   teamhits            # Team Hits
 *              5   -   kills               # Total Kills
 *              6   -   teamkills           # Total TeamKills
 *              7   -   distance            # Longest Kill Distance
 */
$players = Array();                     //Array[27]

if (array_key_exists(27, $array) && $array[27] != NULL) {
    $players = $array[27];


    foreach ($players as $playernum => $playerdata) {
        /**
         * Putting Loadout Data into Loadouts
         * @table loadout
         */
        $loadout = $playerdata[39];
		

        $load_primary_weapon = 0;
        $load_primary_ammo = 0;
        $load_secodary_weapon = 0;
        $load_secodary_ammo = 0;
        $load_equip_one = 0;
        $load_equip_two = 0;
        $load_equip_three = 0;
        $load_equip_four = 0;
        $load_equip_five = 0;
        $load_breacher = 0;
        $load_body_armor = 0;
        $load_head_armor = 0;

        if (array_key_exists(0, $loadout) && $loadout[0] != NULL)
            $load_primary_weapon = $con->escape_string($loadout[0]);
        if (array_key_exists(1, $loadout) && $loadout[1] != NULL)
            $load_primary_ammo = $con->escape_string($loadout[1]);
        if (array_key_exists(2, $loadout) && $loadout[2] != NULL)
            $load_secodary_weapon = $con->escape_string($loadout[2]);
        if (array_key_exists(3, $loadout) && $loadout[3] != NULL)
            $load_secodary_ammo = $con->escape_string($loadout[3]);
        if (array_key_exists(4, $loadout) && $loadout[4] != NULL)
            $load_equip_one = $con->escape_string($loadout[4]);
        if (array_key_exists(5, $loadout) && $loadout[5] != NULL)
            $load_equip_two = $con->escape_string($loadout[5]);
        if (array_key_exists(6, $loadout) && $loadout[6] != NULL)
            $load_equip_three = $con->escape_string($loadout[6]);
        if (array_key_exists(7, $loadout) && $loadout[7] != NULL)
            $load_equip_four = $con->escape_string($loadout[7]);
        if (array_key_exists(8, $loadout) && $loadout[8] != NULL)
            $load_equip_five = $con->escape_string($loadout[8]);
        if (array_key_exists(9, $loadout) && $loadout[9] != NULL)
            $load_breacher = $con->escape_string($loadout[9]);
        if (array_key_exists(10, $loadout) && $loadout[10] != NULL)
            $load_body_armor = $con->escape_string($loadout[10]);
        if (array_key_exists(11, $loadout) && $loadout[11] != NULL)
            $load_head_armor = $con->escape_string($loadout[11]);

		// If player has not played till end of round then no loadout present
		if($load_primary_weapon==0 || $load_secodary_weapon==0 || $load_equip_one==0 || $load_equip_two==0 || $load_equip_three==0 || $load_equip_four==0 || $load_equip_five==0)
		{
			$playername = $con->escape_string($playerdata[5]);
			$playername = str_replace('(VIEW)','',$playername);
			$playername = str_replace('(SPEC)','',$playername);
			$sql = "SELECT MAX(loadout) as loadout FROM player WHERE name LIKE '$playername' LIMIT 1;";
			$query = $con->query($sql);
			// If player playing first time then this will fail
			if($query->num_rows <= 0)
			{
				$sql = "INSERT INTO `loadout` (`id`, `primary_weapon`, `primary_ammo`, `secondary_weapon`,"
                . " `secondary_ammo`, `equip_one`, `equip_two`, `equip_three`, `equip_four`, `equip_five`,"
                . " `breacher`, `head`, `body`)"
                . " VALUES (NULL, '$load_primary_weapon', '$load_primary_ammo', '$load_secodary_weapon',"
                . " '$load_secodary_ammo', '$load_equip_one', '$load_equip_two', '$load_equip_three', '$load_equip_four',"
                . " '$load_equip_five', '$load_breacher', '$load_head_armor', '$load_body_armor');";
				$query = $con->query($sql);
				$loadout_insert_id = $con->insert_id;
			}
			// If player already played and left game before this round
			else
			{
				$result = $query->fetch_object();
				$loadout_insert_id = $result->loadout;
			}
		}
		//If player has loadout and played till end of round
		else
		{
        $sql = "INSERT INTO `loadout` (`id`, `primary_weapon`, `primary_ammo`, `secondary_weapon`,"
                . " `secondary_ammo`, `equip_one`, `equip_two`, `equip_three`, `equip_four`, `equip_five`,"
                . " `breacher`, `head`, `body`)"
                . " VALUES (NULL, '$load_primary_weapon', '$load_primary_ammo', '$load_secodary_weapon',"
                . " '$load_secodary_ammo', '$load_equip_one', '$load_equip_two', '$load_equip_three', '$load_equip_four',"
                . " '$load_equip_five', '$load_breacher', '$load_head_armor', '$load_body_armor');";
        $query = $con->query($sql);
        $loadout_insert_id = $con->insert_id;
		}
		
        /**
         * Putting of all Player Data to table player
         * @table player
         */

        /**
         * Initialize all Value to ZERO
         */
        $player_id = 0;
        $player_name = '0';
        $player_ip = '0';
        $player_team = 0;
        $player_vip = 0;
        $player_admin = 0;
        $player_dropped = 0;
        $player_coop_status = 0;
        $player_score = 0;
        $player_time = 0;
        $player_kills = 0;
        $player_teamkills = 0;
        $player_deaths = 0;
        $player_suicides = 0;
        $player_arrests = 0;
        $player_arrested = 0;
        $player_killstreak = 0;
        $player_arreststreak = 0;
        $player_deathstreak = 0;
        $player_country = '_unknown';
        $player_countryname = '_unknown';
        $player_ip_trim = '0';

        if (array_key_exists(0, $playerdata) && $playerdata[0] != NULL)
            $player_id = $con->escape_string($playerdata[0]);
        if (array_key_exists(5, $playerdata) && $playerdata[5] != NULL)
            $player_name = $con->escape_string($playerdata[5]);
        if (array_key_exists(1, $playerdata) && $playerdata[1] != NULL)
            $player_ip = $con->escape_string($playerdata[1]);
        if (array_key_exists(6, $playerdata) && $playerdata[6] != NULL)
            $player_team = $con->escape_string($playerdata[6]);
        if (array_key_exists(4, $playerdata) && $playerdata[4] != NULL)
            $player_vip = $con->escape_string($playerdata[4]);
        if (array_key_exists(3, $playerdata) && $playerdata[3] != NULL)
            $player_admin = $con->escape_string($playerdata[3]);
        if (array_key_exists(2, $playerdata) && $playerdata[2] != NULL)
            $player_dropped = $con->escape_string($playerdata[2]);
        if (array_key_exists(38, $playerdata) && $playerdata[38] != NULL)
            $player_coop_status = $con->escape_string($playerdata[38]);
        if (array_key_exists(8, $playerdata) && $playerdata[8] != NULL)
            $player_score = $con->escape_string($playerdata[8]);
        if (array_key_exists(7, $playerdata) && $playerdata[7] != NULL)
            $player_time = $con->escape_string($playerdata[7]);
        if (array_key_exists(9, $playerdata) && $playerdata[9] != NULL)
            $player_kills = $con->escape_string($playerdata[9]);
        if (array_key_exists(10, $playerdata) && $playerdata[10] != NULL)
            $player_teamkills = $con->escape_string($playerdata[10]);
        if (array_key_exists(11, $playerdata) && $playerdata[11] != NULL)
            $player_deaths = $con->escape_string($playerdata[11]);
        if (array_key_exists(12, $playerdata) && $playerdata[12] != NULL)
            $player_suicides = $con->escape_string($playerdata[12]);
        if (array_key_exists(13, $playerdata) && $playerdata[13] != NULL)
            $player_arrests = $con->escape_string($playerdata[13]);
        if (array_key_exists(14, $playerdata) && $playerdata[14] != NULL)
            $player_arrested = $con->escape_string($playerdata[14]);
        if (array_key_exists(10, $playerdata) && $playerdata[10] != NULL)
            $player_teamkills = $con->escape_string($playerdata[10]);
        if (array_key_exists(15, $playerdata) && $playerdata[15] != NULL)
            $player_killstreak = $con->escape_string($playerdata[15]);
        if (array_key_exists(16, $playerdata) && $playerdata[16] != NULL)
            $player_arreststreak = $con->escape_string($playerdata[16]);
        if (array_key_exists(17, $playerdata) && $playerdata[17] != NULL)
            $player_deathstreak = $con->escape_string($playerdata[17]);

        //Replaces VIEW and SPEC from Players name
        $player_name = str_replace('(VIEW)','',$player_name);
        $player_name = str_replace('(SPEC)','',$player_name);


        $player_c = getiplocation_json($player_ip);
        $player_country = $player_c->countryCode;
        $player_countryname = $player_c->countryName;
        $player_ip_trim = substr($player_ip, 0, strrpos($player_ip, "."));

        /**
         * @table alias,profile
         *
         * Find if this player has a record in Alias table or not
         * If not then add player to alias as well as profile table
         * Also check if both alias and profile exist then just add player to db and update profile
         * If has record then update the new data into table profile if needed
         */
        $sql = "SELECT profile,id FROM alias WHERE name LIKE '$player_name' LIMIT 1;";
        $checkalias = $con->query($sql);

		if($loadout_insert_id == '' || $loadout_insert_id == 0 || empty($loadout_insert_id))
		{
			$loadout_insert_id == 0;
		}
        // If there is a name in alias table matching
        if ($checkalias->num_rows > 0) {
            // Need update only to profile table if name or ip present in alias table
            $aliasdata = $checkalias->fetch_assoc();

            $alias_profile_id = $aliasdata['profile'];
            $alias_insert_id = $aliasdata['id'];

            $sql = "UPDATE profile SET game_last='$game_insert_id',loadout='$loadout_insert_id',ip_addr='$player_ip' WHERE id='$alias_profile_id' LIMIT 1;";
            $query = $con->query($sql);
        }

        // If there is  no name matching alias table
        else {
            $checkprofile = $con->query("SELECT id,ip_addr FROM profile WHERE ip_addr LIKE '$player_ip_trim%'");
            // there is profile with this account but no alias. So add new alias for it
            if ($checkprofile->num_rows > 0) {
                $profiletdata = $checkprofile->fetch_assoc();
                $profile_id = $profiletdata['id'];
                $sql = "INSERT INTO `alias`(`id`, `profile`, `name`, `isp`, `ip_addr`) VALUES (NULL, '$profile_id','$player_name', NULL, '$player_ip');";
                $addalias = $con->query($sql);
                $alias_insert_id = $con->insert_id;

                //Also Update the profile for gamelast and loadout.
                $sql = "UPDATE profile SET game_last='$game_insert_id',loadout='$loadout_insert_id',ip_addr='$player_ip' WHERE id='$profile_id' LIMIT 1;";
                $query = $con->query($sql);
            }

            // There is neither a alias nor a profile so add both
            else {
                $aliasdata = $checkalias->fetch_assoc();
                $alias_profile_id = $aliasdata["profile"];
                $sql = "INSERT INTO `profile`(`id`, `name`, `team`, `country`,`countryCode`, `loadout`, `game_first`, `game_last`, `ip_addr`) VALUES (NULL , '$player_name', '$player_team', '$player_countryname', '$player_country', '$loadout_insert_id', '$game_insert_id', '$game_insert_id', '$player_ip');";
                $addprofile = $con->query($sql);
                $profile_insert_id = $con->insert_id;

                $sql = "INSERT INTO `alias`(`id`, `profile`, `name`, `isp`, `ip_addr`) VALUES (NULL, '$profile_insert_id','$player_name', NULL, '$player_ip');";
                $addalias = $con->query($sql);
                $alias_insert_id = $con->insert_id;
            }
        }
        // var_dump($playerdata);
        // Handle posting of all Data of Player X into Db
        $sql = "INSERT INTO `player` (`id`, `player_id`, `name`, `game`, `alias`, `loadout`, `ip`, `country`, `team`,"
                . " `vip`, `admin`, `dropped`, `coop_status`, `score`, `time`, `kills`,"
                . " `teamkills`, `deaths`, `suicides`, `arrests`, `arrested`, "
                . "`kill_streak`, `arrest_streak`, `death_streak`, `vip_captures`, `vip_rescues`, "
                . "`vip_escapes`, `vip_kills_valid`, `vip_kills_invalid`, `rd_bombs_defused`, `sg_escapes`, "
                . "`sg_kills`, `coop_hostage_arrests`, `coop_hostage_hits`, `coop_hostage_incaps`, "
                . "`coop_hostage_kills`, `coop_enemy_arrests`, `coop_enemy_incaps`, `coop_enemy_kills`, "
                . "`coop_enemy_incaps_invalid`, `coop_enemy_kills_invalid`, `coop_toc_reports`) "
                . "VALUES (NULL, '$player_id', '$player_name', '$game_insert_id', $alias_insert_id, '$loadout_insert_id',"
                . " '$player_ip', '$player_country', '$player_team', '$player_vip', '$player_admin', '$player_dropped', '$player_coop_status', "
                . " '$player_score', '$player_time', '$player_kills', '$player_teamkills', '$player_deaths', '$player_suicides',"
                . " '$player_arrests', '$player_arrested', '$player_killstreak', '$player_arreststreak', '$player_deathstreak',"
                . "NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, "
                . "NULL, NULL, NULL, NULL, NULL);";

        $query = $con->query($sql);
        $player_insert_id = $con->insert_id;


        /**
         * Handling and Putting all Weapons data to table weapon
         * @table weapon
         * playerdata[40] is an array of weapns used by player
         */
        foreach ($playerdata[40] as $weaponid => $weapondata) {

            $weapon_name = 0;
            $weapon_time = 0;           #time in secs the weapons was used
            $weapon_shots = 0;
            $weapon_hits = 0;
            $weapon_teamhits = 0;
            $weapon_kills = 0;
            $weapon_teamkills = 0;
            $weapon_distance = 0;      #longest distance kill by that weapon

            if (array_key_exists(0, $weapondata) && $weapondata[0] != NULL)
                $weapon_name = $con->escape_string($weapondata[0]);
            if (array_key_exists(1, $weapondata) && $weapondata[1] != NULL)
                $weapon_time = $con->escape_string($weapondata[1]);
            if (array_key_exists(2, $weapondata) && $weapondata[2] != NULL)
                $weapon_shots = $con->escape_string($weapondata[2]);
            if (array_key_exists(3, $weapondata) && $weapondata[3] != NULL)
                $weapon_hits = $con->escape_string($weapondata[3]);
            if (array_key_exists(4, $weapondata) && $weapondata[4] != NULL)
                $weapon_teamhits = $con->escape_string($weapondata[4]);
            if (array_key_exists(5, $weapondata) && $weapondata[5] != NULL)
                $weapon_kills = $con->escape_string($weapondata[5]);
            if (array_key_exists(6, $weapondata) && $weapondata[6] != NULL)
                $weapon_teamkills = $con->escape_string($weapondata[6]);
            if (array_key_exists(7, $weapondata) && $weapondata[7] != NULL)
                $weapon_distance = $con->escape_string($weapondata[7]);


            $sql = "INSERT INTO `weapon` (`id`, `name`, `player`, `time`, `shots`, `hits`, `teamhits`, `kills`,"
                    . " `teamkills`, `distance`)"
                    . " VALUES (NULL, '$weapon_name', '$player_insert_id', '$weapon_time', '$weapon_shots', '$weapon_hits',"
                    . " '$weapon_teamhits', '$weapon_kills', '$weapon_teamkills', '$weapon_distance');";

            $query = $con->query($sql);
        }
    }
}
}
print("1\nThe round stats has been recorded.");
?>
