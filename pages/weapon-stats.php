<?php
/**
 * Created by PhpStorm.
 * User: Kinnngg
 * Date: 22-02-2015
 * Time: 13:23
 */
function getweapondata()
{
    global $con;
    $sql = "SELECT name,SUM(time) AS timeused,SUM(shots) AS shotsfired,SUM(hits) AS shotshit,SUM(kills) AS totalkills,MAX(distance) AS farkill,COUNT(player) AS playerused FROM `weapon` WHERE name NOT IN(27,28,29,31,32,33) GROUP BY name ORDER BY totalkills DESC,shotsfired DESC;";   // Not select IAmCuff-32 and ZipCuffs-33 etc
    $query = $con->query($sql);
    if ($query->num_rows <= 0) {
        echo "No Weapons";
        return;
    }

    $weapondata = '';
    while($weapon = $query->fetch_object())
    {
        $name = $weapon->name;
        $timeused = $weapon->timeused;
        $shotsfired = $weapon->shotsfired;
        $shotshit = $weapon->shotshit;
        $totalkills = $weapon->totalkills;
        $farkill = $weapon->farkill;
        $farkill = round($farkill/100,2);
        $playerused = $weapon->playerused;
        $accuracy = $shotsfired==0 ? 0 : round(($shotshit/$shotsfired)*100,1);

        $timeused = formatHM($timeused);
        $name = GetElemfromId($name,'W');

        $weapondata = $weapondata . "<tr><td><b><a>$name</a></b></td><td>$timeused</td><td>$shotsfired</td><td>$accuracy%</td><td>$totalkills</td><td class='text-right'>$farkill m</td></tr>";
    }
    return $weapondata;
}
?>

<div class="row no-margin no-padding">
    <div class="block">
        <div class="block-bot">
            <div class="head">
                <div class="head-cnt">
                    <h3>Weapon Statistics</h3>
                    <div class="cl">&nbsp;</div>
                </div>
            </div>
            <div class="col-articles articles">
                <div class="cl">&nbsp;</div>
                <div class="padding10 stdtablecont">
                    <table class="stdtable table table-striped table-hover no-margin padding10">
                        <thead style="color: #204d74">
                        <tr>
                            <th class="col-md-4">Name</th>
                            <th class="col-md-2">Time Used</th>
                            <th class="col-md-2">Shots Fired</th>
                            <th class="col-md-2">Accuracy</th>
                            <th class="col-md-2">Kills</th>
                            <th class="col-md-2 text-right">LongestKill</th>

                        </tr>
                        </thead>
                        <tbody id="">
                        <?=getweapondata()?>
                        </tbody>
                    </table>
                </div>
                <div class="cl">&nbsp;</div>
            </div>
        </div>

    </div>

</div>
<!-- / Content -->