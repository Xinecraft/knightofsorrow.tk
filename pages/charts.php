<div id="content">
<div class="pie panel panel-default col-md-12 no-padding no-margin">
<div class="panel-heading"><b>Maps (Round Played)</b></div>
<?php
$sql = "SELECT mapname,COUNT(*) as games FROM `game` GROUP BY mapname;";
$query= $con->query($sql);
$maparray = array();
while($result = $query->fetch_object())
{
$mapid = $result->mapname;
$maparray[$mapid] = $result->games;
switch($mapid)
{
case 0:
$abombStats = $result->games;
break;
case 5:
$fairfaxStats = $result->games;
case 6:
$foodwallStats =  $result->games;
case 15:
$projectStats = $result->games;
}
}
?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Rounds', 'Played'],
          ['Food Wall Restaurant',     <?=$foodwallStats?>],
          ['A-Bomb NightClub',      <?=$abombStats?>],
          ['Fairfax Residence',  <?=$fairfaxStats?>],
          ['The Wolcott Project', <?=$projectStats?>]
        ]);

		var options = {"width":"600","height":"300","titlePosition":"none","chartArea":{"left":38,"bottom":0,"width":"92%","height":"80%"},"backgroundColor":"#ffffff","titleTextStyle":{"fontSize":16},"legend":{"position":"top","alignment":"end"}};

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
    <div id="piechart" class="no-padding no-margin" style="width: 676px; height: 300px;"></div>
</div>
</div>