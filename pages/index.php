<!DOCTYPE html>
<html>
<!--
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
 *
-->
<?php
ob_start();
require_once('conf.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once('pages/magicquotesgpc.php');
include_once('pages/generate_option.php');
include_once('pages/imp_func_inc.php');
include_once('pages/swatUtils.php');
global $con;
?>
<!--<php
//load time calculator
$starttime = microtime(); $startarray = explode(" ", $starttime); $starttime = $startarray[1] + $startarray[0];
?> -->
    <head>
        <title>KoS - Knight of Sorrow</title>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />

        <!--[if IE 6]><link rel="stylesheet" href="css/ie6-style.css" type="text/css" media="all" /><![endif]-->
    </head>
    <body class="container">
        <!-- Page -->
        <div id="page" class="shell">

            <?php
            include_once 'header.php';
            ?>

            <!-- Main -->
            <div id="main">
                <div id="main-bot">
                    <div class="cl">&nbsp;</div>

                    <?php
                    if (isset($_GET["statistics"]))
                        include_once("pages/statistics.php");
                    else if (isset($_GET["logout"]))
                        include_once("pages/");
                    else if (isset($_GET["roundstats"]))
                        include_once("pages/round-stats.php");
                    else if(isset($_GET['registerclan']))
                        include_once("pages/registerclan.php");
                    else if(isset($_GET['clans']))
                        include_once("pages/clans.php");
                    else if(isset($_GET['rules']))
                        include_once("pages/rules.php");
                    else if(isset($_GET['news']))
                        include_once("pages/news.php");
                    else if(isset($_GET['search']))
                        include_once("pages/search.php");
                    else if(isset($_GET['downloads']))
                        include_once("pages/downloads.php");
                    else if(isset($_GET['comingsoon']))
                        include_once("pages/comingsoon.php");
                    else if(isset($_GET['registerserver']))
                        include_once("pages/registerserver.php");
                    else if(isset($_GET['servers']))
                        include_once("pages/serverlist.php");
                    else if(isset($_GET['server']))
                        include_once("pages/liveserverstream.php");
                    else if(isset($_GET['register']))
                        include_once("pages/registeruser.php");
                    else if(isset($_GET['login']))
                        include_once("pages/loginuser.php");
                    else if(isset($_GET['webadmin']))
                        include_once("pages/webadmin.php");
                    else if(isset($_GET['userprofile']) || isset($_GET['profile']))
                        include_once("pages/userprofile.php");
                    else
                        include_once 'pages/home.php';
                    include_once 'sidebar.php';
                    include_once 'footer.php';
                    ?>
                </div>
            </div>
            <!-- / Main -->
        </div>
        <!-- / Page -->
        <!-- Inclusion of all script at last body end as per new Guidlines -->
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.form.js"></script>
        <script src="js/gauge.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="js/main.js" type="text/javascript"></script>
    </body>
    <!--    //load time calculator
        //$endtime = microtime();
        //$endarray = explode(" ", $endtime); 
        //$endtime = $endarray[1] + $endarray[0];
        //$totaltime = $endtime - $starttime;
        //$totaltime = round($totaltime,10); 
        //echo "Seconds To Load: "; printf ("%fn", $totaltime);-->
</html>