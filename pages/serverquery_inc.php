<?php
/**
 * Created by PhpStorm.
 * User: Kinnngg
 * Date: 02-03-2015
 * Time: 23:51
 */


//-------------------CONFIG.PHP---------------------------------
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



//--------------------FUNCTIONS.PHP----------------------------
// ----------------- Swat 4 PHP Server Query -----------------
//       Modified heavily by Slippery Jim For Swat 4
//  Additional function coding and improvements by cert|KeeKee and Gez
//
//        Originally made by A. Joling for another game
//                Version: 1.5 - June 6 2006
// ------------------------------------------------------------

// functions
function GetItemInfo ($itemname, $itemchunks) { $retval = "-";
    for ($i=0;$i<count($itemchunks);$i++)
        if (strcasecmp($itemchunks[$i], $itemname) == 0) $retval = $itemchunks[$i+1];
    return  $retval;
}

/**
 *
 * @param type $data
 * @return type
 */
function FontCodes($data) {
    $data=str_replace("[B]","[b]",$data);
    $data=str_replace("[U]","[u]",$data);
    $data=str_replace("[I]","[i]",$data);
    $data=str_replace("[C=","[c=",$data);
    preg_match_all("/\[([BbUuIi])\]/",$data,$bui_tags); $bui_count=count($bui_tags[1]);
    $color_count=substr_count($data,"[c=");
    if($color_count > 0) {
        if($bui_count > 0) {
            if($color_count==1) {
                for($i=$bui_count;$i>0;$i--) $data.="[/".$bui_tags[1][$i-1]."]";
                $data=ereg_replace("\[c=([0-9a-fA-F]{6})\]","<span style=\"color: #\\1;\">",$data)."</span>";
            } else {
                $tag=array("b"=>0,"u"=>0,"i"=>0);
                $color=explode("[c=",$data);
                $datatmp="";
                for($i=1;$i<count($color);$i++) { $colortmp="[c=".$color[$i];
                    if($tag['b']) { $colortmp=ereg_replace("(\[c=[0-9a-fA-F]{6}\])","\\1[b]",$colortmp); }
                    if($tag['u']) { $colortmp=ereg_replace("(\[c=[0-9a-fA-F]{6}\])","\\1[u]",$colortmp); }
                    if($tag['i']) { $colortmp=ereg_replace("(\[c=[0-9a-fA-F]{6}\])","\\1[i]",$colortmp); }
                    if(strpos($colortmp,"[b]")) { $colortmp.="[/b]"; $tag['b']=1; }
                    if(strpos($colortmp,"[u]")) { $colortmp.="[/u]"; $tag['u']=1; }
                    if(strpos($colortmp,"[i]")) { $colortmp.="[/i]"; $tag['i']=1; }
                    $datatmp.=$colortmp;
                }
                $data=$datatmp."</span>";
                $data=ereg_replace("\[c=([0-9a-fA-F]{6})\]","</span><span style=\"color: #\\1;\">",$data);
                $data=preg_replace('/<\/span>/','',$data,1);
            }
        } else {
            $data=ereg_replace("\[c=([0-9a-fA-F]{6})\]","</span><span style=\"color: #\\1;\">",$data);
            if(substr_count($data,"<span")) { $data=preg_replace('/<\/span>/','',$data,1); $data.="</span>"; }
        }
    } else {
        if($bui_count > 0) for($i=$bui_count;$i>0;$i--) $data.="[/".$bui_tags[1][$i-1]."]";
    }
    $data=ereg_replace("\[(/[bui])\]|\[([bui])\]","<\\1\\2>",$data);
    return $data;
}

function FixNickname($nick) {
    $nick=str_replace('&','&amp;',$nick);
    $nick=str_replace('<','&lt;',$nick);
    $nick=str_replace('>','&gt;',$nick);
    return $nick;
}

function SortPlayers($a,$b,$co,$jak) {
    if($co=="name") {
        $a2=strtolower($a['name']);
        $b2=strtolower($b['name']);
        if($a2==$b2) return 0;
        if((($jak=="+")&&($a2>$b2))||(($jak=="-")&&($a2<$b2))) return 1; else return -1;
    } else {
        if($a[$co]==$b[$co]) return 0;
        if((($jak=="+")&&($a[$co]>$b[$co]))||(($jak=="-")&&($a[$co]<$b[$co]))) return 1; else return -1;
    }
}

function SortPlayers_name_ASC($a,$b) { return SortPlayers($a,$b,'name','+'); }
function SortPlayers_name_DESC($a,$b) { return SortPlayers($a,$b,'name','-'); }
function SortPlayers_score_ASC($a,$b) { return SortPlayers($a,$b,'score','+'); }
function SortPlayers_score_DESC($a,$b) { return SortPlayers($a,$b,'score','-'); }
function SortPlayers_ping_ASC($a,$b) { return SortPlayers($a,$b,'ping','+'); }
function SortPlayers_ping_DESC($a,$b) { return SortPlayers($a,$b,'ping','-'); }
function SortPlayers_kills_ASC($a,$b) { return SortPlayers($a,$b,'kills','+'); }
function SortPlayers_kills_DESC($a,$b) { return SortPlayers($a,$b,'kills','-'); }
function SortPlayers_tkills_ASC($a,$b) { return SortPlayers($a,$b,'tkills','+'); }
function SortPlayers_tkills_DESC($a,$b) { return SortPlayers($a,$b,'tkills','-'); }
function SortPlayers_deaths_ASC($a,$b) { return SortPlayers($a,$b,'deaths','+'); }
function SortPlayers_deaths_DESC($a,$b) { return SortPlayers($a,$b,'deaths','-'); }
function SortPlayers_arrests_ASC($a,$b) { return SortPlayers($a,$b,'arrests','+'); }
function SortPlayers_arrests_DESC($a,$b) { return SortPlayers($a,$b,'arrests','-'); }
function SortPlayers_arrested_ASC($a,$b) { return SortPlayers($a,$b,'arrested','+'); }
function SortPlayers_arrested_DESC($a,$b) { return SortPlayers($a,$b,'arrested','-'); }
function SortPlayers_vipe_ASC($a,$b) { return SortPlayers($a,$b,'vipe','+'); }
function SortPlayers_vipe_DESC($a,$b) { return SortPlayers($a,$b,'vipe','-'); }
function SortPlayers_vipkv_ASC($a,$b) { return SortPlayers($a,$b,'vipkv','+'); }
function SortPlayers_vipkv_DESC($a,$b) { return SortPlayers($a,$b,'vipkv','-'); }
function SortPlayers_vipki_ASC($a,$b) { return SortPlayers($a,$b,'vipki','+'); }
function SortPlayers_vipki_DESC($a,$b) { return SortPlayers($a,$b,'vipki','-'); }
function SortPlayers_vipa_ASC($a,$b) { return SortPlayers($a,$b,'vipa','+'); }
function SortPlayers_vipa_DESC($a,$b) { return SortPlayers($a,$b,'vipa','-'); }
function SortPlayers_vipua_ASC($a,$b) { return SortPlayers($a,$b,'vipua','+'); }
function SortPlayers_vipua_DESC($a,$b) { return SortPlayers($a,$b,'vipua','-'); }
function SortPlayers_bombsd_ASC($a,$b) { return SortPlayers($a,$b,'bombsd','+'); }
function SortPlayers_bombsd_DESC($a,$b) { return SortPlayers($a,$b,'bombsd','-'); }
function SortPlayers_rdobjective_ASC($a,$b) { return SortPlayers($a,$b,'rdobjective','+'); }
function SortPlayers_rdobjective_DESC($a,$b) { return SortPlayers($a,$b,'rdobjective','-'); }
function SortPlayers_sgobjective_ASC($a,$b) { return SortPlayers($a,$b,'sgobjective','+'); }
function SortPlayers_sgobjective_DESC($a,$b) { return SortPlayers($a,$b,'sgobjective','-'); }
function SortPlayers_sge_ASC($a,$b) { return SortPlayers($a,$b,'sge','+'); }
function SortPlayers_sge_DESC($a,$b) { return SortPlayers($a,$b,'sge','-'); }
function SortPlayers_sgk_ASC($a,$b) { return SortPlayers($a,$b,'sgk','+'); }
function SortPlayers_sgk_DESC($a,$b) { return SortPlayers($a,$b,'sgk','-'); }

function LinkImageSort($_by,$sby,$soby,$soby2,$stitle) {
    if($_by==$sby) return <<<EOF
<a href="{$_SERVER['PHP_SELF']}?sort={$soby}&amp;by={$sby}" class="formfont" onmouseover="if(document.getElementById('so{$sby}')){ document.getElementById('so{$sby}').src='./swat4query/images/server_{$soby}.gif'; }" onmouseout="if(document.getElementById('so{$sby}')){ document.getElementById('so{$sby}').src='./swat4query/images/server_{$soby2}.gif'; }"><b>{$stitle}</b> <img src="./swat4query/images/server_{$soby2}.gif" width="11" height="9" border="0" alt="{$soby}" id="so{$sby}" />
EOF;
    else return '<a href="'.$_SERVER['PHP_SELF'].'?sort='.$soby.'&amp;by='.$sby.'" class="formfont"><b>'.$stitle.'</b>';
}

function GetServerName() {
    global $servername;
    if(strlen($servername) > 0)
        return $servername;
    else
        return "Swat 4 PHP Server Query";
}
// End functions


/**
 * GET SERVER DETAILS FUNCTION :::::::::::::::::::::::::::::::
 */
function getserverdetail($ipaddr,$qport)
{
// Retrieving data from the server
    $txtip = $ipaddr;
    $txtportnum = $qport;

    $sock = fsockopen("udp://" . $txtip, $txtportnum, $errno, $errstr, 2);
    if (!$sock) {
        echo "$errstr ($errno)<br/>\n";
        exit;
    }
    fputs($sock, "\\status\\");
    $gotfinal = False;
    $data = "";
    socket_set_timeout($sock, 0, 200000);
    $starttime = Time();
    while (!($gotfinal == True || feof($sock))) {
        if (($buf = fgetc($sock)) == FALSE) usleep(100);
        $data .= $buf;
        if (strpos($data, "final\\") != False) $gotfinal = True;
        if ((Time() - $starttime) > 2) {
            $gotfinal = True;
        }
    }
    fclose($sock);
    $chunks = split('[\]', $data);


// Correcting data
    if (getiteminfo("hostname", $chunks) == "-") {
        $option['hostname'] = "__offline__";
    } else {
        $option['hostname'] = FontCodes(getiteminfo("hostname", $chunks));
        $option['hostname'] = preg_replace( '/[^[:print:]]/', '',$option['hostname']);
    }
    $option['password'] = (getiteminfo("password", $chunks) == 0) ? "No" : "Yes";
    $option['patch'] = getiteminfo("gamever", $chunks);
    $mods_tmp = getiteminfo("gamevariant", $chunks);
    $option['mods'] = ($mods_tmp == "SWAT 4") ? "None" : $mods_tmp;
    $option['map'] = getiteminfo("mapname", $chunks);
    $option['gametype'] = getiteminfo("gametype", $chunks);
    $option['players_current'] = getiteminfo("numplayers", $chunks);
    $option['players_max'] = getiteminfo("maxplayers", $chunks);
    $option['statsenabled'] = (getiteminfo("statsenabled", $chunks) == 0) ? "No" : "Yes";
    $option['swatwon'] = getiteminfo("swatwon", $chunks);
    $option['suspectswon'] = getiteminfo("suspectswon", $chunks);

    $option['round'] = getiteminfo("round", $chunks);
    $option['numrounds'] = getiteminfo("numrounds", $chunks);
    $option['suspectsscore'] = getiteminfo("suspectsscore", $chunks);
    $option['swatscore'] = getiteminfo("swatscore", $chunks);
    $option['timeleft'] = getiteminfo("timeleft", $chunks);
    $option['nextmap'] = getiteminfo("nextmap", $chunks);

    $option['players'] = array();
    for ($i = 0; $i < $option['players_current']; $i++) {
        $nametmp = FixNickname(getiteminfo("player_" . $i, $chunks));
        $nametmp = FontCodes($nametmp);
        if ($nametmp != "-") {
            $option['players'][$i]['name'] = preg_replace( '/[^[:print:]]/', '',$nametmp);
            $option['players'][$i]['score'] = getiteminfo("score_" . $i, $chunks);
            $option['players'][$i]['ping'] = getiteminfo("ping_" . $i, $chunks);
            $option['players'][$i]['ip'] = getiteminfo("playerip_" . $i, $chunks);
            $option['players'][$i]['team'] = getiteminfo("team_" . $i, $chunks);
            $option['players'][$i]['kills'] = getiteminfo("kills_" . $i, $chunks);
            $option['players'][$i]['tkills'] = getiteminfo("tkills_" . $i, $chunks);
            $option['players'][$i]['deaths'] = getiteminfo("deaths_" . $i, $chunks);
            $option['players'][$i]['arrests'] = getiteminfo("arrests_" . $i, $chunks);
            $option['players'][$i]['arrested'] = getiteminfo("arrested_" . $i, $chunks);
            $option['players'][$i]['vipe'] = getiteminfo("vipescaped_" . $i, $chunks);
            $option['players'][$i]['vipkv'] = getiteminfo("validvipkills_" . $i, $chunks);
            $option['players'][$i]['vipki'] = getiteminfo("invalidvipkills_" . $i, $chunks);
            $option['players'][$i]['vipa'] = getiteminfo("arrestedvip_" . $i, $chunks);
            $option['players'][$i]['vipua'] = getiteminfo("unarrestedvip_" . $i, $chunks);
            $option['players'][$i]['bombsd'] = getiteminfo("bombsdiffused_" . $i, $chunks);
            $option['players'][$i]['rdobjective'] = getiteminfo("rdcrybaby_" . $i, $chunks);
            $option['players'][$i]['sgobjective'] = getiteminfo("sgcrybaby_" . $i, $chunks);
            $option['players'][$i]['sge'] = getiteminfo("escapedcase_" . $i, $chunks);
            $option['players'][$i]['sgk'] = getiteminfo("killedcase_" . $i, $chunks);
        } else {
            $option['players'][$i]['name'] = "-";
            $option['players'][$i]['score'] = "-";
            $option['players'][$i]['ping'] = "-";
            $option['players'][$i]['ip'] = "-";
            $option['players'][$i]['team'] = "-";
            $option['players'][$i]['kills'] = "-";
            $option['players'][$i]['tkills'] = "-";
            $option['players'][$i]['deaths'] = "-";
            $option['players'][$i]['arrests'] = "-";
            $option['players'][$i]['arrested'] = "-";
            $option['players'][$i]['vipe'] = "-";
            $option['players'][$i]['vipkv'] = "-";
            $option['players'][$i]['vipki'] = "-";
            $option['players'][$i]['vipa'] = "-";
            $option['players'][$i]['vipua'] = "-";
            $option['players'][$i]['bombsd'] = "-";
            $option['players'][$i]['rdobjective'] = "-";
            $option['players'][$i]['sgobjective'] = "-";
            $option['players'][$i]['sge'] = "-";
            $option['players'][$i]['sgk'] = "-";
        }
    }

    if ((!IsSet($_GET['by'])) || (!IsSet($_GET['sort']))) {
        $_by = "score";
        $_sort = -1;
    } else {
        $_by = $_GET['by'];
        $_sort = ($_GET['sort'] == "ASC") ? 1 : -1;
    }
    $_sorting = array("name" => 1, "score" => -1, "ping" => 1, "ip" => 1, "kills" => 1, "tkills" => 1, "deaths" => 1, "arrests" => 1, "arrested" => 1, "vipe" => 1, "vipkv" => 1, "vipki" => 1, "vipa" => 1, "vipua" => 1, "bombsd" => 1, "rdobjective" => 1, "sgobjective" => 1, "sge" => 1, "sgk" => 1);
    $_sorting[$_by] = $_sort * -1;
    $usortopt = ($_sort == 1) ? "ASC" : "DESC";
    @usort($option['players'], "SortPlayers_" . $_by . "_" . $usortopt);

    // RETURN THE JSON ENCODED DATA
    return (json_encode($option));
}

?>