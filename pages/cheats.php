<?php
$myfile = fopen("/var/swt.ini", "r") or die("Cant open");
//echo fread($myfile,filesize("abc.ini"));//  IPPolicies=DENY,39.59.124.232,RETARD,|KoS|?Kinnngg,106.215.140.208
$i = 0;
if(!myfile)
{
echo "File Not Found!";
}
while(!feof($myfile))
{
$ipbanmatch = fgets($myfile);
if(preg_match('/IPPolicies=DENY/',$ipbanmatch))
{
$i++;
$array = split(",",$ipbanmatch);
$playername = $array[2];
$playerip = $array[1];
$adminame = $array[3];
$playerGeo = getiplocation_json($playerip);
$playerCountryCode = $playerGeo->countryCode;
if(preg_match("/([0-9]):([0-9])/",$playername))
{
$playername =  $array[3];
$adminame = $array[4];
}

if($playername == "~ManualIPBan")
{
$playername = "<span style='color:#BB2F0E'>Manual IP Ban</span>";
}
else
{
$playername = $playername;
}

$adminame = preg_replace("/\(VIEW\)/","",$adminame);
$adminame = preg_replace("/\(SPEC\)/","",$adminame);

$playername = preg_replace("/\(VIEW\)/","",$playername);
$playername = preg_replace("/\(SPEC\)/","",$playername);

$playerip = "<b style='color:#006A11'>".$playerip."</b>";
if($playername != "<span style='color:#BB2F0E'>Manual IP Ban</span>")
{
$playername = "<a href='./?statistics=player&detail=".urlencode(utf8_encode($playername))."'><b style='color:#BB2F0E'>".($playername)."</b></a>";
}
if(!preg_match("/WebAdmin/",$adminame))
{
$adminame = "<a href='./?statistics=player&detail=".urlencode($adminame)."'><b style='color:#BB2F0E'>".($adminame)."</b></a>";
}
else
{
$adminame = "<span style='color:#BB2F0E'>".$adminame."</span>";
}

if(preg_match("/ManualIPBan/",$adminame))
{
$adminame = "<span style='color:#BB2F0E'>Unknown Admin</span>";
}
$playername = utf8_encode($playername);
$adminame = utf8_encode($adminame);

$bandata = $bandata."<tr><td>".$i."</td><td><img data-toggle='tooltip' data-placement='top' title='".country_code_to_country($playerCountryCode)."' src='images/flags/20_shiny/$playerCountryCode.png'></td><td>".$playername."</td><td>".$playerip."</td><td>".$adminame."</td></tr>";
}
}
fclose($myfile);
?>
<div id="content">

<div class="row no-margin no-padding">
<div class="alert alert-info alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>If you have got banned without good reason, please Shout in the Shout Box to get unbanned in Server!</strong>
</div>
    <div class="block">
        <div class="block-bot">
            <div class="head">
                <div class="head-cnt">
                    <h3>Ban List</h3>
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
                            <th class="col-md-3">Player Name</th>
                            <th class="col-md-3">IP</th>
                            <th class="col-md-3">Banned By</th>
                        </tr>
                        </thead>
                        <tbody id="playertabledata">
                        <?=$bandata?>
                        </tbody>
                    </table>
                </div>
                <div class="cl">&nbsp;</div>
            </div>
        </div>

    </div>

</div>
<!-- / Content -->
</div>
