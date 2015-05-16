<?php

$sql = "SELECT u.*,r.* FROM `user` as u,kosclanrank as r WHERE u.kosclanrank=r.id ORDER BY r.id;";
$result = $con->query($sql);
while($user = $result->fetch_object())
{
	$i++;
	$username = $user->username;
	$playername = $user->linked_playeroverall_name;
	$rankname = $user->rankname;
	$playerCountryCode = $user->country;
	
 $data = $data."<tr><td>".$i."</td><td><img data-toggle='tooltip' data-placement='top' title='".country_code_to_country($playerCountryCode)."' src='images/flags/20_shiny/$playerCountryCode.png'></td><td><a href='./?userprofile=$username' class='ainorange'>".$username."</a></td><td><a href='./?statistics=player&detail=".urlencode($playername)."' class='ainorange'>".$playername."</a></td><td style='color: rgb(0, 128, 12);
  font-weight: bold;'>".$rankname."</td></tr>";
}
?>


<div id="content">

<div class="row no-margin no-padding">
<div class="alert alert-info alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>This is the list of KoS Clan Members as per website Database!</strong>
</div>
    <div class="block">
        <div class="block-bot">
            <div class="head">
                <div class="head-cnt">
                    <h3>KoS Clan Members</h3>
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
                            <th class="col-md-2">Username</th>
                            <th class="col-md-3">Player Name</th>
                            <th class="col-md-2">Rank</th>
                        </tr>
                        </thead>
                        <tbody id="playertabledata">
                        <?=$data?>
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