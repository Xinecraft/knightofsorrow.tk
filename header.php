<?php
/*
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
 */
?>
<!-- Header -->
<div id="header">
    <!-- Top Navigation -->
    <div id="top-nav">
        <ul>
            <?php
            if(islogin()) {
                $username = $_SESSION['username'];
				$addtoheader = '';
				$userid = $_SESSION['userid'];
				$query = $con->query("SELECT id FROM pings WHERE reciever = '$userid' AND seen = 0;");
				if($query->num_rows > 0)
				{
					//echo "<script>alert('You have $query->num_rows New Ping');</script>";
					$addtoheader = "<li><a class='headerusername' href='./?pinguser' style='color:#00ff00 !important;'>$query->num_rows New Ping</a></li>";
				}
                echo <<<_HTML
                <li class="home"><a href='./?login=logout'>Logout</a></li>
				$addtoheader
                <li><a class="headerusername" href="./?profile">$username</a></li>
_HTML;

            }
            else
            {
                ?>
                <li class="home"><a href="./?home">Guest</a></li>
                <li><a href="./?login">LOGIN</a></li>
                <li class="last"><a href="./?register">REGISTER</a></li>
            <?php
            }
            ?>
        </ul>
    </div>
    <!-- / Top Navigation -->
    <div class="cl">&nbsp;</div>
    <!-- Logo -->
    <div id="logo">
        <h1><a href="./"><span style="color: yellow">knight</span> <span>of</span> <span style="color: red">sorrow</span></a><small><sub>Beta</sub></small></h1>
        <p class="description">Swat4 Server & Community</p>
    </div>
    <!-- / Logo -->
    <!-- Main Navigation -->
    <div id="main-nav">
        <div class="bg-right">
            <div class="bg-left">
                <ul class="no-margin">
                    <li><a href="./?kosclan">KoS Clan</a></li>
                    <li><a href="./?comingsoon">videos</a></li>
                    <li><a href="./?clans">clans</a></li>
                    <li><a href="./?rules">rules</a></li>
                    <li><a href="./?admins">admins</a></li>
                    <li><a href="./?bans">Bans</a></li>
                    <li><a href="./?comingsoon">forum</a></li>
                    <li><a href="./?news">news</a></li>
                    <li><a href="./?charts">Charts</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- / Main Navigation -->
    <div class="cl">&nbsp;</div>
    <!-- Sort Navigation -->
    <div id="sort-nav">
        <div class="bg-right">
            <div class="bg-left">
                <div class="cl">&nbsp;</div>
                <ul>
                    <li class="first active first-active"><a href="./?home">Home</a><span class="sep">&nbsp;</span></li>
                    <li><a href="./?statistics">Statistics </a><span class="sep">&nbsp;</span></li>
                    <li><a href="./?servers">Servers</a><span class="sep">&nbsp;</span></li>
                    <li><a href="./?comingsoon">Screenshots</a><span class="sep">&nbsp;</span></li>
                    <li><a href="./?downloads">Downloads</a><span class="sep">&nbsp;</span></li>

<?php

                    if(!isset($_GET['statistics'])) {
                        echo <<<_HTML
 <li style="float: right !important;margin-right: 10px;">
                        <form class="navbar-form navbar-right no-padding no-margin" role="search">
                            <div class="form-group">
                                <input type="text" name="search" class="form-control" placeholder="Search Player">
                            </div>
                            <button type="submit" class="btn btn-default">Go</button>
                        </form>
                    </li>
_HTML;
                    }
?>
                </ul>
                <div class="cl">&nbsp;</div>
            </div>
        </div>
    </div>
    <!-- / Sort Navigation -->
</div>
<!-- / Header -->