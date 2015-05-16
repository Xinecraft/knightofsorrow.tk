<?php
echo date("H:i:s d-m-y");
/*
 * Tge MIT License
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
require_once('conf.php');
ini_set('display_errors',1);
error_reporting(E_ALL);
include_once('pages/magicquotesgpc.php');
include_once('pages/generate_option.php');
include_once('pages/imp_func_inc.php');
global $con;

//$player_name = 'king';
//$sql = "SELECT * FROM alias WHERE name LIKE '$player_name' LIMIT 1;";
//        $checkalias = $con->query($sql);
//        echo $checkalias->num_rows;
//        $aliasdata = $checkalias->fetch_array();
//        $alias_profile_id = $aliasdata["profile"];
//        echo $alias_profile_id;
//$ip= "123.432.231.43";
//$trimmed = substr($ip, 0, strrpos($ip, "."));
//echo $trimmed;
//print("0\n<br>All ok");
//$str='GET /gp/swat4.php?0=2yQsWidu&1=1.2.0&2=10480&3=1423931280&4=d9120466&6=1.0&7=Swat%20vs%20Suspects&11=1&12=16&13=2&14=3&15=121&16=121&17=120&22=5&27%5B0%5D%5B0%5D=0&27%5B0%5D%5B1%5D=127.0.0.1&27%5B0%5D%5B3%5D=1&27%5B0%5D%5B5%5D=%7CSRV%7CKinnngg&27%5B0%5D%5B7%5D=119&27%5B0%5D%5B11%5D=1&27%5B0%5D%5B17%5D=1&27%5B0%5D%5B39%5D%5B0%5D=6&27%5B0%5D%5B39%5D%5B1%5D=8&27%5B0%5D%5B39%5D%5B2%5D=16&27%5B0%5D%5B39%5D%5B3%5D=25&27%5B0%5D%5B39%5D%5B4%5D=25&27%5B0%5D%5B39%5D%5B5%5D=25&27%5B0%5D%5B39%5D%5B6%5D=25&27%5B0%5D%5B39%5D%5B7%5D=25&27%5B0%5D%5B39%5D%5B8%5D=25&27%5B0%5D%5B39%5D%5B9%5D=3&27%5B0%5D%5B39%5D%5B10%5D=19&27%5B0%5D%5B39%5D%5B11%5D=22&27%5B0%5D%5B40%5D%5B0%5D%5B0%5D=7&27%5B0%5D%5B40%5D%5B0%5D%5B1%5D=23&27%5B0%5D%5B40%5D%5B0%5D%5B2%5D=60&27%5B0%5D%5B40%5D%5B1%5D%5B0%5D=25&27%5B0%5D%5B40%5D%5B1%5D%5B1%5D=42&27%5B0%5D%5B40%5D%5B1%5D%5B2%5D=7&27%5B0%5D%5B40%5D%5B2%5D%5B0%5D=6&27%5B0%5D%5B40%5D%5B2%5D%5B1%5D=31&27%5B0%5D%5B40%5D%5B2%5D%5B2%5D=90 HTTP/1.1" 200 3 "-" "SWAT-HTTP/1.1.0"';
//echo urldecode($str);
//echo "<br><br>";
//$arrays = $_GET;
//
//echo '<code>'.json_encode($arrays).'</code>';
//
//
//
//echo $arrays[0];
//
////&27[1][0]=1&27[1][1]=122.2.0.1&27[1][3]=0&27[1][5]=|KOS|Dlan&27[1][7]=129&27[1][11]=1&27[1][17]=1&27[1][39][0]=5&27[1][39][1]=7&27[1][39][2]=16&27[1][39][3]=25&27[1][39][4]=25&27[1][39][5]=25&27[1][39][6]=25&27[1][39][7]=25&27[1][39][8]=25&27[1][39][9]=3&27[1][39][10]=19&27[1][39][11]=22&27[1][40][0][0]=7&27[1][40][0][1]=23&27[1][40][0][2]=60&27[1][40][1][0]=25&27[1][40][1][1]=42&27[1][40][1][2]=7&27[1][40][2][0]=6&27[1][40][2][1]=31&27[1][40][2][2]=190
//
//$str = "0=2yQsWidu&1=1.2.0&2=10480&3=1423931280&4=d9120466&6=1.0&7=Swat%20vs%20Suspects&11=1&12=16&13=2&14=3&15=121&16=121&17=120&22=5&27[0][0]=0&27[0][1]=101.60.51.20&27[0][3]=1&27[0][5]=|SRV|Kinnngg&27[0][7]=119&27[0][11]=1&27[0][17]=1&27[0][39][0]=6&27[0][39][1]=8&27[0][39][2]=16&27[0][39][3]=25&27[0][39][4]=25&27[0][39][5]=25&27[0][39][6]=25&27[0][39][7]=25&27[0][39][8]=25&27[0][39][9]=3&27[0][39][10]=19&27[0][39][11]=22&27[0][40][0][0]=7&27[0][40][0][1]=23&27[0][40][0][2]=60&27[0][40][1][0]=25&27[0][40][1][1]=42&27[0][40][1][2]=7&27[0][40][2][0]=6&27[0][40][2][1]=31&27[0][40][2][2]=90&27[1][0]=1&27[1][1]=122.136.46.151&27[1][3]=0&27[1][5]=|KOS|Dlan&27[1][7]=129&27[1][11]=1&27[1][17]=1&27[1][39][0]=5&27[1][39][1]=7&27[1][39][2]=16&27[1][39][3]=25&27[1][39][4]=25&27[1][39][5]=25&27[1][39][6]=25&27[1][39][7]=25&27[1][39][8]=25&27[1][39][9]=3&27[1][39][10]=19&27[1][39][11]=22&27[1][40][0][0]=7&27[1][40][0][1]=23&27[1][40][0][2]=60&27[1][40][1][0]=25&27[1][40][1][1]=42&27[1][40][1][2]=7&27[1][40][2][0]=6&27[1][40][2][1]=31&27[1][40][2][2]=190";
//
//var_dump($_GET);
//$times = 1424457563;
//$timest = 1424477160;
//if (date_default_timezone_set('UTC')){
//    echo "UTC is a valid time zone";
//}else{
//    echo "The system doesn't know WTFUTC.  Maybe try updating tzinfo with your package manager?";
//}
//echo timeago2(1424477160)."<br>".time()."<br>";
//echo date_default_timezone_get(); //date("h:i:s d-m-Y",$timest);


//echo "<br>".date("h:i:s d-m-Y").  timezone_version_get();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>

    <![endif]-->
</head>

<script>
    alert($.fn.tooltip.Constructor.VERSION);
</script>
<body class="container">

<h1>SWAT4 TEST THINGS</h1>


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-large" data-toggle="modal" data-target="#myModal">Launch demo modal</button>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="purchaseLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="purchaseLabel">Purchase</h4>
            </div>
            <div class="modal-body">
                sup?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Purchase</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<script>
        $('.modal-body').load("index.html");


</script>
</body>
</html>
