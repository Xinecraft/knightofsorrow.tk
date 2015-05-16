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
<!-- Content -->
<div id="content">

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li <?php if($_REQUEST["statistics"]=="player"  || $_REQUEST['statistics']==''){echo "class='active'";}?>><a href="./?statistics=player">Player</a></li>
                    <li <?php if($_REQUEST["statistics"]=="round"){echo "class='active'";}?>><a href="./?statistics=round">Round</a></li>
                    <li <?php if($_REQUEST["statistics"]=="server"){echo "class='active'";}?>><a href="./?statistics=server">Server</a></li>
                    <li <?php if($_REQUEST["statistics"]=="country"){echo "class='active'";}?>><a href="./?statistics=country">Country</a></li>
                    <li <?php if($_REQUEST["statistics"]=="weapons"){echo "class='active'";}?>><a href="./?statistics=weapons">Weapons</a></li>

                  <!--  <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">Dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                            <li class="divider"></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li> -->
                </ul>
                <form class="navbar-form navbar-right no-padding" role="search" method="get" name="search">
                    <div class="form-group">
                        <input type="text" class="form-control" name="search" placeholder="Search Player">
                    </div>
                    <button type="submit" class="btn btn-default">Go</button>
                </form>
              <!--
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Link</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </li>
                </ul>
                -->
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <?php

    /**
     * URL Redirections with GET
     */
        switch($_GET['statistics'])
        {
            case "round":
                if(isset($_GET['detail']))
                    include_once("round-details.php");
                else
                    include_once("round-stats.php");
                break;
            case "player":
                if(isset($_GET['detail']))
                    include_once("player-details.php");
                else
                include_once("player-stats.php");
                break;
            case "weapons":
                include_once("weapon-stats.php");
                break;
            case "country":
                include_once("country-stats.php");
                break;
            case "server":
                include_once("server-stats.php");
                break;
            default:
                include_once("player-stats.php");
                break;
        }


    ?>

</div>
<!-- / Content -->
<script type="text/javascript" charset="utf-8">
    //<![CDATA[
    $(function() {
        $('.navbar-nav li').each(function() {
            var href = $(this).find('a').attr('href');
            if (href === window.location.pathname) {
                $(this).addClass('active');
            }
        });
    });
    //]]>
</script>