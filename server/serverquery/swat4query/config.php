<?php
// ----------------- Swat 4 PHP Server Query -----------------
//       Modified heavily by Slippery Jim For Swat 4
//  Additional function coding and improvements by cert|KeeKee and Gez
//
//        Originally made by A. Joling for another game
//                Version: 1.5 - June 6 2006
// ------------------------------------------------------------
//
// Adding Your Own Screenshots:
// ----------------------------
// You can add your own screenshots for custom fan maps that you may be
// running on the server.   Simply upload a 150 x 150 pixel .JPG image
// into the IMAGES subfolder in the PHP Query directory.

// You must however name the screenshot with the full name of your map (minus
// all spaces).  For instance the Brewer County Courthouse map has a
// screenshot with the name BrewerCountyCourthouse.jpg

// It is recommended that you add a 2 pixel white border around the
// screenshot to keep the same style as the other map images.
// ------------------------------------------------------------

// Enter your Game Server IP to use. 
$defaultip = "127.0.0.1";

// Enter the join port of the game (the port that people use to join your server).
$defaultport = "10480";

// Enter the query port of the game (usually 10481, or 10491 if using the Admin Mod).
$queryport = "10483";

//This line of text appears below the Swat 4 logo and is meant
//to contain your server name or whatever else you prefer.
//This is is also visible in the title bar of the browser.
$servername = "Mod Test Server";

// The home button will take you back to your website homepage.
$query_url_name = "http://www.swat-4.com";

// Meta Tags Description if you want people to find
// your server's PHP query page with a search engine
$query_meta_description = "Live view of Swat 4 game server";

// Meta Tags Keywords if you want people to find
// your server's PHP query page with a search engine
$query_meta_keywords = "swat, swat 4, swat4, game, server, tactics, tactical, shooter, sierra";




// ====================================================================
//  Settings below only need changing if you want to modify look/style
// ====================================================================

//Show the Refresh/Home button? [true/false]
$showform = true;

//Show the player detail table? [true/false]
$showplayers = true;

//Width for server info table. You can't really make this much more
//narrower without making the map screenshots smaller.
$server_info_table = "525";

//Width config for Player stats table (name/score/ping)
$Playertablewidth = "610";

$bscolspan="9";
$vipcolspan="14";
$rdcolspan="11";
$sgcolspan="12";

// The following 3 should add up to $Playertablewidth
$Playerwidth = "170";
$Scorewidth = "80";
$Pingwidth = "60";
$Killswidth = "60";
$TKillswidth = "60";
$Deathswidth = "60";
$Arrestswidth = "60";
$Arrestedwidth = "60";

$TotalVIPWidth = "300";
$VIPEwidth = "60";
$VIPKVwidth = "60";
$VIPKIwidth = "60";
$VIPAwidth = "60";
$VIPUAwidth = "60";

$TotalRDWidth = "120";
$BombsDwidth = "60";
$RDObjectivewidth = "60";

$TotalSGWidth = "180";
$SGObjectivewidth = "60";
$SGEWidth = "60";
$SGKWidth = "60";

// Main page background colour
$query_body_color = "#000000";

//  Main font colour
$query_font_color = "#FFFFFF";

// Category font colour ie Name, Map, Gametype, etc
$query_catfont_color = "#CCCCFF";

// Colour for Player stats background
$player_color_bg = "#11111C";

// Colour for Player stats divider lines
$player_color_divider ="#333344";

?>