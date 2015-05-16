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
error_reporting(E_NONE);
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
$tag = NULL;                    // Array[0]

if (array_key_exists(0, $array) && $array[0] != NULL)
    $tag = $con->escape_string($array[0]);
/**
 *  Mod version
 */
$version = NULL;                    //Array[1]

if (array_key_exists(1, $array) && $array[1] != NULL)
    $version = $con->escape_string($array[1]);

/**
 *  Join port number
 */
$joinport = NULL;                   //Array[2]

if (array_key_exists(2, $array) && $array[2] != NULL)
    $joinport = $con->escape_string($array[2]);

/**
 *  Server time in the format of Unix Timestamp
 * The server declares itself to be in UTC timezone, which makes this value untrustworthy
 * On the other hand this is an excellent argument value for hashing
 */
$timestamp = NULL;                  //Array[3]

if (array_key_exists(3, $array) && $array[3] != NULL)
    $timestamp = $con->escape_string($array[3]);

/**
 *  Last 32 bits of an md5 encoded request signature hash
 * The original hash is a product of the following parameters:
 * `server key` + `join port` + `timestamp`
 */
$hash = NULL;                       //Array[4]

if (array_key_exists(4, $array) && $array[4] != NULL)
    $hash = $con->escape_string($array[4]);

/**
 * Game title
 * 0 - SWAT4
 * 1 - SWAT4X
 */
$gamename = NULL;                   //Array[5]

if (array_key_exists(5, $array) && $array[5] != NULL)
    $gamename = $con->escape_string($array[5]);

/**
 * Game version
 */
$gameversion = NULL;                //Array[6]

if (array_key_exists(6, $array) && $array[6] != NULL)
    $gameversion = $con->escape_string($array[6]);

/**
 * Hostname
 */
$hostname = NULL;                   //Array[7]

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
$gametype = NULL;                   //Array[8]

if (array_key_exists(8, $array) && $array[8] != NULL)
    $gametype = $con->escape_string($array[8]);


/**
 * Map
 *
 *          '0': 'A-Bomb Nightclub',
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
$map = NULL;                        //Array[9]

if (array_key_exists(9, $array) && $array[9] != NULL)
    $map = $con->escape_string($array[9]);

/**
 * Is server is pasword protected
 * type bool
 * 0 - no
 * 1 - yes
 */
$passworded = NULL;                 //Array[10]

if (array_key_exists(10, $array) && $array[10] != NULL)
    $passworded = $con->escape_string($array[10]);


/**
 * Total number of players in Server
 * @type integer
 */
$player_num = NULL;                 //Array[11]

if (array_key_exists(11, $array) && $array[11] != NULL)
    $player_num = $con->escape_string($array[11]);


/**
 * Max player limit of server
 * @type int
 */
$player_max = NULL;                 //Array[12]

if (array_key_exists(12, $array) && $array[12] != NULL)
    $player_max = $con->escape_string($array[12]);


/**
 * Current Round Index
 * @type int
 */
$round_num = NULL;                  //Array[13]

if (array_key_exists(13, $array) && $array[13] != NULL)
    $round_num = $con->escape_string($array[13]);


/**
 * Rounds per map
 * @type int
 */
$round_max = NULL;                  //Array[14]

if (array_key_exists(14, $array) && $array[14] != NULL)
    $round_max = $con->escape_string($array[14]);

/**
 * Time elapsed since the round start in sec
 */
$time_absolute = NULL;              //Array[15]

if (array_key_exists(15, $array) && $array[15] != NULL)
    $time_absolute = $con->escape_string($array[15]);


/**
 * Time the game has actually span in sec
 * @note usutally same a above
 */
$time = NULL;                       //Array[16]

if (array_key_exists(16, $array) && $array[16] != NULL)
    $time = $con->escape_string($array[16]);


/**
 * Round time limit
 */
$time_limit = NULL;                  //Array[17]

if (array_key_exists(17, $array) && $array[17] != NULL)
    $time_limit = $con->escape_string($array[17]);


/**
 * Number of SWAT victories
 */
$vict_swat = NULL;                  //Array[18]

if (array_key_exists(18, $array) && $array[18] != NULL)
    $vict_swat = $con->escape_string($array[18]);


/**
 * Number of Suspects victories
 */
$vict_sus = NULL;                    //Array[19]

if (array_key_exists(19, $array) && $array[19] != NULL)
    $vict_sus = $con->escape_string($array[19]);


/**
 * SWAT score
 */
$score_swat = NULL;                  //Array[20]

if (array_key_exists(20, $array) && $array[20] != NULL)
    $score_swat = $con->escape_string($array[20]);


/**
 * Suspects score
 */
$score_sus = NULL;                  //Array[21]

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
        . " VALUES (NULL, '0', 'sadsad', '21323', '123213', '1', '2', '2', '5',"
        . " '34', '54', '1', '0', '$bombs_defused', '$bombs_total', '0',"
        . " CURRENT_TIMESTAMP, NULL);";
if($query = $con->query($sql))
{
echo "GOOG:";
echo $con->errorno;
echo $bombs_defused.":".$bombs_total;
}
else
{
echo "NOPE";
echo $con->errorno;
}
print("1\nThe round stats has been recorded.");
echo $bombs_defused.":".$bombs_total;
?>
