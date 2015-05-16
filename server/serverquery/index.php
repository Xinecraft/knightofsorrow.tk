<?php
// ----------------- Swat 4 PHP Server Query -----------------
//       Modified heavily by Slippery Jim For Swat 4
//  Additional function coding and improvements by cert|KeeKee and Gez
//
//        Originally made by A. Joling for another game
//                Version: 1.5 -June 6 2006
// ------------------------------------------------------------

//Show all errors...
	error_reporting(E_ALL);
	
//Include configuration file
	include './swat4query/config.php';

//Include functions
	include './swat4query/functions.php';
?>
<html>
<title><?=GetServerName();?></title>
<head>
	<style type="text/css">
	<!--
	/* Local CSS so we do not mess-up someone else's layout */
	.tableclass { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; font-style: normal; font-weight: normal; color: <?=$query_font_color;?>; }
	.catfont { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; font-style: normal; font-weight: normal; color: <?=$query_catfont_color;?>; }
	.formfont { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10pt; color: <?=$query_font_color;?>; text-decoration: none; }
	a.formfont:link, a.formfont:visited { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10pt; color: <?=$query_font_color;?>; text-decoration: none; }
    a.formfont:hover { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10pt; color: <?=$query_font_color;?>; text-decoration: underline; }
	.query_title { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14pt; color: <?=$query_font_color?>; text-align: center; }
	a:link, a:visited {color: #444459;	TEXT-DECORATION: none; font-variant : normal; border: #000000;}
    a:hover {color: #666679; text-decoration: underline; font-variant : normal; border: #000000;}
	BODY { margin: 0px 0px 0px 0px; background: <?=$query_body_color;?>; }
	-->
	</style>
<meta http-equiv="Pragma" content="no-cache">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<meta name="description" content="<?=$query_meta_description;?>">
<meta name="keywords" content="<?=$query_meta_keywords;?>">
</head>
<body >
<p align="center"><img src="./swat4query/images/logo.gif" width="300" height="75"></p>
<p class="query_title"><?=$servername;?></p>
		<hr width="<?=$server_info_table;?>" noshade size="1">
		<br>		
	<table width="<?=$server_info_table;?>" border="0" align="center" cellpadding="0" cellspacing="0" class="tableclass">
	  <tr>
 	    <td height="20"><p class="catfont" align="right">Name:</p></td>
	    <td height="20">&nbsp;&nbsp;<?=$option['hostname'];?></td>
	    <td height="20">&nbsp;</td>
	  </tr>
 	  <tr>
 	   <td height="20"><p class="catfont" align="right">Map:</p></td>
  	   <td height="20">&nbsp;&nbsp;<?=$option['map'];?></td>
  	   <td height="20">&nbsp;</td>
	  </tr>
	  <tr>
  	   <td height="20">&nbsp;</td>
  	   <td height="20">&nbsp;</td>
 	  </tr>
	  <tr>
 	   <td height="20"><p class="catfont" align="right">Gametype:</p></td>
  	   <td height="20">&nbsp;&nbsp;<?=$option['gametype'];?></td>
  	   <td rowspan="8">
			<?
			// Right cell of server info (screenshot)
			$mapfile = "./swat4query/images/".str_replace(" ","",$option['map']).".jpg";
			if (file_exists($mapfile)) {
			?>
				<img src="<? echo $mapfile;?>" width="200" height="200"/>
			<? } else { ?>
				<img src="./swat4query/images/none.jpg"/>
			<? } ?>
		</td>
  	 </tr>
  	 <tr>
    	<td height="20"><p class="catfont" align="right">Mod:</p></td>
    	<td height="20">&nbsp;&nbsp;<?=$option['mods'];?></td>
  	 </tr>
 	 <tr>
    	<td height="20"><p class="catfont" align="right">Password:</p></td>
    	<td height="20">&nbsp;&nbsp;<?=$option['password'];?></td>
  	 </tr>
  	 <tr>
    	<td height="20"><p class="catfont" align="right">Players:</p></td>
    	<td height="20">&nbsp;&nbsp;<?=$option['players_current'];?>/<?=$option['players_max'];?></td>
  	 </tr>
  	 <tr>
    	<td height="20"><p class="catfont" align="right">Server IP:</p></td>
    	<td height="20">&nbsp;&nbsp;<?=$txtip;?>:<?=$defaultport;?></td>
  	 </tr>
  	 <tr>
    	<td height="20"><p class="catfont" align="right">Stats:</p></td>
    	<td height="20">&nbsp;&nbsp;<?=$option['statsenabled'];?></td>
  	 </tr>
  	 <tr>
    	<td height="20"><p class="catfont" align="right">Version:</p></td>
    	<td height="20">&nbsp;&nbsp;<?=$option['patch'];?></td>
  	 </tr>
	 	  <tr>
 	   <td height="20"><p class="catfont" align="right">Round:</p></td>
  	   <td height="20">&nbsp;&nbsp;<?=$option['round']."/".$option['numrounds'];?></td>
  	   <td height="20">&nbsp;</td>
	  </tr>
	  	  <tr>
 	   <td height="20"><p class="catfont" align="right">Next Map:</p></td>
  	   <td height="20">&nbsp;&nbsp;<?=$option['nextmap'];?></td>
  	   <td height="20">&nbsp;</td>
	  </tr>
  	 <tr>
    	<td height="20">&nbsp;</td>
    	<td height="20">&nbsp;</td>
  	 </tr>
     <tr>
    	<td height="20">&nbsp;</td>
    	<td height="20">&nbsp;</td>
  	 </tr>
	</table>

     <br>

	<center><font color=ffffff><b>SWAT</b>: <?=$option['swatwon'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Suspects</b>: <?=$option['suspectswon'];?></font></center>

	 <br>
	<a name="RQ"></a>

	<? //Check if the playerlist should be visible (see config file)
	if ($showplayers == true) {

		$thecolspan = $bscolspan;
		if ( $option['gametype'] == "VIP Escort" )
		{
			$Playertablewidth+=$TotalVIPWidth;
			$thecolspan = $vipcolspan;
		}
		if ( $option['gametype'] == "Rapid Deployment" )
		{
			$Playertablewidth+=$TotalRDWidth;
			$thecolspan = $rdcolspan;
		}
		if ( $option['gametype'] == "Smash And Grab" )
		{
			$Playertablewidth+=$TotalSGWidth;
			$thecolspan = $sgcolspan;
		}

		echo "<table width=\"<?=$Playertablewidth;?>\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" class=\"tableclass\">";

 		if ($option['players_current'] == 0) { ?>
 			<tr><td width="<?=$Playerwidth;?>" bgcolor="<?=$player_color_bg;?>"><div align="center">No players online.</div></td></tr>
 		<? } else { ?>
			<tr>
			 <td width="10">&nbsp;</td>
			 <td width="<?=$Playerwidth;?>"><p class="formfont"><?=LinkImageSort($_by,"name",($_sorting['name']==1)?"ASC":"DESC",(($_sorting['name'] * -1)==1)?"ASC":"DESC","Player");?></p></td>
			 <td width="<?=$Scorewidth;?>"><p class="formfont" align="center"><?=LinkImageSort($_by,"score",($_sorting['score']==1)?"ASC":"DESC",(($_sorting['score'] * -1)==1)?"ASC":"DESC","Scores");?></p></td>
			 <td width="<?=$Pingwidth;?>"><p class="formfont" align="center"><?=LinkImageSort($_by,"ping",($_sorting['ping']==1)?"ASC":"DESC",(($_sorting['ping'] * -1)==1)?"ASC":"DESC","Ping");?></p></td>
			 <td width="<?=$Killswidth;?>"><p class="formfont" align="center"><?=LinkImageSort($_by,"kills",($_sorting['kills']==1)?"ASC":"DESC",(($_sorting['kills'] * -1)==1)?"ASC":"DESC","Kills");?></p></td>
			 <td width="<?=$TKillswidth;?>"><p class="formfont" align="center"><?=LinkImageSort($_by,"tkills",($_sorting['tkills']==1)?"ASC":"DESC",(($_sorting['tkills'] * -1)==1)?"ASC":"DESC","TeamKills");?></p></td>
			 <td width="<?=$Deathswidth;?>"><p class="formfont" align="center"><?=LinkImageSort($_by,"deaths",($_sorting['deaths']==1)?"ASC":"DESC",(($_sorting['deaths'] * -1)==1)?"ASC":"DESC","Deaths");?></p></td>
			 <td width="<?=$Arrestswidth;?>"><p class="formfont" align="center"><?=LinkImageSort($_by,"arrests",($_sorting['arrests']==1)?"ASC":"DESC",(($_sorting['arrests'] * -1)==1)?"ASC":"DESC","Arrests");?></p></td>
			 <td width="<?=$Arrestedwidth;?>"><p class="formfont" align="center"><?=LinkImageSort($_by,"arrested",($_sorting['arrested']==1)?"ASC":"DESC",(($_sorting['arrested'] * -1)==1)?"ASC":"DESC","Arrested");?></p></td>
			<? if ( $option['gametype'] == "VIP Escort" ) { ?>
			 <td width="<?=$VIPEwidth;?>"><p class="formfont" align="center"><?=LinkImageSort($_by,"vipe",($_sorting['vipe']==1)?"ASC":"DESC",(($_sorting['vipe'] * -1)==1)?"ASC":"DESC","Escaped as VIP");?></p></td>
			 <td width="<?=$VIPKVwidth;?>"><p class="formfont" align="center"><?=LinkImageSort($_by,"vipkv",($_sorting['vipkv']==1)?"ASC":"DESC",(($_sorting['vipkv'] * -1)==1)?"ASC":"DESC","Killed VIP Valid");?></p></td>
			 <td width="<?=$VIPKIwidth;?>"><p class="formfont" align="center"><?=LinkImageSort($_by,"vipki",($_sorting['vipki']==1)?"ASC":"DESC",(($_sorting['vipki'] * -1)==1)?"ASC":"DESC","Killed VIP Invalid");?></p></td>
			 <td width="<?=$VIPAwidth;?>"><p class="formfont" align="center"><?=LinkImageSort($_by,"vipa",($_sorting['vipa']==1)?"ASC":"DESC",(($_sorting['vipa'] * -1)==1)?"ASC":"DESC","Arrested VIP");?></p></td>
			 <td width="<?=$VIPUAwidth;?>"><p class="formfont" align="center"><?=LinkImageSort($_by,"vipua",($_sorting['vipua']==1)?"ASC":"DESC",(($_sorting['vipua'] * -1)==1)?"ASC":"DESC","Freed VIP");?></p></td>
			<? } ?>
			<? if ( $option['gametype'] == "Rapid Deployment" ) { ?>
			 <td width="<?=$BombsDWidth;?>"><p class="formfont" align="center"><?=LinkImageSort($_by,"bombsd",($_sorting['bombsd']==1)?"ASC":"DESC",(($_sorting['bombsd'] * -1)==1)?"ASC":"DESC","Bombs Defused");?></p></td>
			 <td width="<?=$RDObjectivewidth;?>"><p class="formfont" align="center"><?=LinkImageSort($_by,"rdobjective",($_sorting['rdobjective']==1)?"ASC":"DESC",(($_sorting['rdobjective'] * -1)==1)?"ASC":"DESC","Objective");?></p></td>
			<? } ?>
			<? if ( $option['gametype'] == "Smash And Grab" ) { ?>
			 <td width="<?=$SGObjectiveWidth;?>"><p class="formfont" align="center"><?=LinkImageSort($_by,"sgobjective",($_sorting['sgobjective']==1)?"ASC":"DESC",(($_sorting['sgobjective'] * -1)==1)?"ASC":"DESC","Objective");?></p></td>
			 <td width="<?=$SGEwidth;?>"><p class="formfont" align="center"><?=LinkImageSort($_by,"sge",($_sorting['sge']==1)?"ASC":"DESC",(($_sorting['sge'] * -1)==1)?"ASC":"DESC","Escaped with case");?></p></td>
			 <td width="<?=$SGKwidth;?>"><p class="formfont" align="center"><?=LinkImageSort($_by,"sgk",($_sorting['sgk']==1)?"ASC":"DESC",(($_sorting['sgk'] * -1)==1)?"ASC":"DESC","Carrier Kills");?></p></td>
			<? } ?>
			</tr>
			<? foreach($option['players'] as $player) { ?>
			<tr>
			  <td width="10" bgcolor="<?=$player_color_bg;?>"> </td>
			  <td width="<?=$Playerwidth;?>" bgcolor="<?=$player_color_bg;?>">
			<? if ( $player['team'] == "0" ) echo "<font color=0000FF>"; ?>
			<? if ( $player['team'] == "1" ) echo "<font color=FF0000>"; ?><?=$player['name'];?></td>
			  <td width="<?=$Scorewidth;?>" bgcolor="<?=$player_color_bg;?>" align="center"><?=$player['score'];?></td>
			  <td width="<?=$Pingwidth;?>" bgcolor="<?=$player_color_bg;?>" align="center"><?=$player['ping'] > 999 ? 999 : $player['ping'];?></td>
			  <td width="<?=$Killswidth;?>" bgcolor="<?=$player_color_bg;?>" align="center"><?=$player['kills'];?></td>
			  <td width="<?=$TKillswidth;?>" bgcolor="<?=$player_color_bg;?>" align="center"><?=$player['tkills'];?></td>
			  <td width="<?=$Deathswidth;?>" bgcolor="<?=$player_color_bg;?>" align="center"><?=$player['deaths'];?></td>
			  <td width="<?=$Arrestswidth;?>" bgcolor="<?=$player_color_bg;?>" align="center"><?=$player['arrests'];?></td>
			  <td width="<?=$Arrestedwidth;?>" bgcolor="<?=$player_color_bg;?>" align="center"><?=$player['arrested'];?></td>
			<? if ( $option['gametype'] == "VIP Escort" ) { ?>
			  <td width="<?=$VIPEwidth;?>" bgcolor="<?=$player_color_bg;?>" align="center"><?=$player['vipe'];?></td>
			  <td width="<?=$VIPKVwidth;?>" bgcolor="<?=$player_color_bg;?>" align="center"><?=$player['vipkv'];?></td>
			  <td width="<?=$VIPKIwidth;?>" bgcolor="<?=$player_color_bg;?>" align="center"><?=$player['vipki'];?></td>
			  <td width="<?=$VIPAwidth;?>" bgcolor="<?=$player_color_bg;?>" align="center"><?=$player['vipa'];?></td>
			  <td width="<?=$VIPUAwidth;?>" bgcolor="<?=$player_color_bg;?>" align="center"><?=$player['vipua'];?></td>
			<? } ?>
			<? if ( $option['gametype'] == "Rapid Deployment" ) { ?>
			 <td width="<?=$BombsDWidth;?>" bgcolor="<?=$player_color_bg;?>" align="center"><?=$player['bombsd'];?></td>
			 <td width="<?=$RDObjectivewidth;?>" bgcolor="<?=$player_color_bg;?>" align="center"><?=$player['rdobjective'];?></td>
			<? } ?>
			<? if ( $option['gametype'] == "Smash And Grab" ) { ?>
			 <td width="<?=$SGObjectiveWidth;?>" bgcolor="<?=$player_color_bg;?>" align="center"><?=$player['sgobjective'];?></td>
			 <td width="<?=$SGEwidth;?>" bgcolor="<?=$player_color_bg;?>" align="center"><?=$player['sge'];?></td>
			 <td width="<?=$SGKwidth;?>" bgcolor="<?=$player_color_bg;?>" align="center"><?=$player['sgk'];?></td>
			<? } ?>
			</tr>
			<tr bgcolor="<?=$player_color_divider;?>" >
			  <td height="1" colspan=<?=$thecolspan?>></td>
			</tr>
								
			<? }
			 } ?>
			</table> 
<? } ?>
			  <br/>
			  <hr width="<?=$server_info_table;?>" size="1" noshade>
		<br>
	<?
	//Check if the refresh/home button is enabled (see config file)
	If ($showform == true)
		{
	?>
	<table width="225" border="0" align="center" cellpadding="0" cellspacing="0">
  		<tr>
    		<td width="75">

				<form action="<?=$_SERVER['PHP_SELF'];?>#RQ" METHOD="post" name="frmselect" target="_self">
				<table class="formfont" border="1" cellspacing="0" cellpadding="0" align="center">
					<tr> 
					  <td><input name="submit" type="submit" value="Refresh"></td>
					</tr>
			    </table>
			</form>
		</td>
  		</tr>
	</table>

<?
	}
?>
<br>
<div align="center"><font color="#333349" size="1" face="Arial, Helvetica, sans-serif">Swat 4 PHP Server Query v1.5 - by <a href="http://www.swat-4.com" target="_blank">Slippery Jim</a>, <a href="http://cert-clan.com" target="_blank">cert|KeeKee</a> and <a href="http://www.swat4ses.co.uk/gezmods" target="_blank">Gez</a><br>
Based on work by A. Joling<br>
Modified by Gez</font></div>
</BODY>
</HTML>