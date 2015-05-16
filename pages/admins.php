<?php
function getadmintable()
{
    global $con;
    global $string,$totaluser;
    $playertabledata = '';
    $string = $con->escape_string($_GET['search']);
    $sql = "SELECT username,id,email,fullname,country,last_login_time,admin_role FROM user WHERE admin_role > 1 ORDER BY admin_role DESC,last_login_time DESC;";
    $query = $con->query($sql);
    $totaluser = $query->num_rows;
    if($query->num_rows <= 0)
    {
        $playertabledata = '<tr><td></td><td></td><td></td><th>No  User  Found</th><td></td><td></td></tr>';
        return $playertabledata;
    }

    while($data=$query->fetch_object())
    {
        $id ++;
        $countryiso = $data->country;
        $adminrole = $data->admin_role;
        $username = $data->username;
        $email = $data->email;
        $lastlogintime = $data->last_login_time;
        $lastlogintime = timeago($lastlogintime);
		switch($adminrole)
{
    case 0:
        $userclass = "User";
        break;
    case 1:
        $userclass = "Sub Administrator";
        break;
    case 2:
        $userclass = "Administrator";
        break;
    case 3:
        $userclass = "Super Administrator";
        break;
    default:
        $userclass = "User";
        break;
}
		
        $playertabledata = $playertabledata . "<tr data-id='$id'><td><b>$id</b></td><td><img data-toggle='tooltip' data-placement='top' title='".country_code_to_country($countryiso)."' src='images/flags/20_shiny/$countryiso.png'></td><td><strong><a class='ainorange' href='./?userprofile=$username'>$username</a></strong></td><td>$userclass</td><td class='text-right'>$lastlogintime</td></tr>";
    }
    return $playertabledata;
}
$adminresult = getadmintable();
?>


<div id="content">

<div class="row no-margin no-padding">
    <div class="block">
        <div class="block-bot">
            <div class="head">
                <div class="head-cnt">
                    <h3>Admin List</h3>
                    <div class="cl">&nbsp;</div>
                </div>
            </div>
            <div class="col-articles articles">
                <div class="cl">&nbsp;</div>
                <div class="commontable" id="playerstatstable">
                    <table class="stdtable table table-striped table-hover no-margin">
                        <thead>
                        <tr>
                            <th class="col-md-1">#</th>
                            <th class="col-md-1">Flag</th>
                            <th class="col-md-3">Username</th>
                            <th class="col-md-3">Rank</th>
                            <th class="col-md-3 text-right">Last Seen</th>
                        </tr>
                        </thead>
                        <tbody id="playertabledata">
                        <?=$adminresult?>
                        </tbody>
                    </table>
                </div>
                <div class="cl">&nbsp;</div>
            </div>
        </div>
    </div>
	
</div>
    </div>
<!-- / Content -->
