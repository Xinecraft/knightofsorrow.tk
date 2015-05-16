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


function getlatestnews()
{
    global $con;
    $newsdata = "";
    $sql = "SELECT * FROM news WHERE is_published=1 ORDER BY pinned,date_created DESC LIMIT 3;";
    $query = $con->query($sql);
    $date = date('D : d-M-Y');
    if($query->num_rows <= 0)
    {
        $newsdata = <<<_HTML
                <div class="article">
                    <h4><a href="">No News Found</a></h4>
                    <small class="date">$date</small>
                    <p>No new news found in our Db</p>
                </div>
_HTML;
    }
    else
    {
        while($news = $query->fetch_object())
        {
            $newsid = $news->id;
            $title = $news->title;
            $summary = $news->summary;
            $date = $news->date_created;
            $timestamp = strtotime($date);
            $date = date("l, jS F Y", $timestamp);
            /**
             * Another Way
             * $dtime = new DateTime($result->my_datetime);
                print $dtime->format("Y-m-d H:i:s");
             */

            $newsdata = $newsdata.<<<HTML
               <div class="article">
                    <h4 class='newstitle'><a href="./?news=$newsid">$title</a></h4>
                    <p class='newsdate'><small class="date">$date</small></p>
                    <p class='newssummary'>$summary</p>
                </div>
HTML;

        }
    }
    return $newsdata;
}
if(!isset($_GET['webadmin']))
{
// THEN ECHO ALL ESLE REMOVE THE SIDE BAR
?>

<!--  -->
<div id="sidebar">
    <!-- Join Server -->
    <div id="search" class="block">
        <div class="block-bot">
            <div class="block-cnt">
               <!--
                <form action="#" method="post">
                    <div class="cl">&nbsp;</div>
                    <div class="fieldplace">
                        <input type="text" class="field" value="Search" title="Search" />
                    </div>
                    <input type="submit" class="button" value="GO" />
                    <div class="cl">&nbsp;</div>
                </form> -->
                <h4 style="border-bottom: 2px dashed gray;color: #f5f5f5;font-family:'DS-Digital', Helvetica, Arial, sans-serif;">Join Server</h4>
                <p class="text-center"><a href="xfire:join?game=swat4&amp;server=31.186.250.153:10480" class="xfire-join" data-toggle="tooltip" data-original-title="Join via Xfire">31.186.250.153:10480</a></p>
            </div>
			<div class="block-cnt">
               <!--
                <form action="#" method="post">
                    <div class="cl">&nbsp;</div>
                    <div class="fieldplace">
                        <input type="text" class="field" value="Search" title="Search" />
                    </div>
                    <input type="submit" class="button" value="GO" />
                    <div class="cl">&nbsp;</div>
                </form> -->
                <h4 style="border-bottom: 2px dashed gray;color: #f5f5f5;font-family:'DS-Digital', Helvetica, Arial, sans-serif;">Donate</h4>
               <p style="color:orange" class="text-center">KoS cost 50 Euro per month to run. Please consider donating! 
	 <form class="text-center" action="https://www.nlservernl.com/whmcs/grouppay.php?hash=13f61-c1a22-80ffd-419d8-515b9-1eddc-7a" method="post" target="_top">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
            </div>
        </div>
    </div>
    <!-- / Search -->
	
	


    <div class="block" id="newsblock">
        <div class="block-bot">
            <div class="head">
                <div class="head-cnt">
                    <h3>Latest News</h3>
                </div>
            </div>
            <div class="text-articles articles">

                <?=getlatestnews()?>

                <div class="cl">&nbsp;</div>
                <a href="./?news" class="view-all ainorange">view all</a>
                <div class="cl">&nbsp;</div>
            </div>
        </div>
    </div>



    <!--ShoutBox-->
    <div class="block">
        <script type="text/javascript" src="http://www5.yourshoutbox.com/shoutbox/start.php?key=997372833"></script>
    </div>

	<div class="block">
	<iframe src="http://cache.www.gametracker.com/components/html0/?host=31.186.250.153:9987&bgColor=333333&fontColor=CCCCCC&titleBgColor=222222&titleColor=FF9900&borderColor=555555&linkColor=FFCC00&borderLinkColor=222222&showMap=0&currentPlayersHeight=260&showCurrPlayers=1&showTopPlayers=0&showBlogs=0&width=220" frameborder="0" scrolling="no" width="220" height="448"></iframe></div>
	
    <!-- Polls-->
    <div class="block text-center"><iframe src="http://files.quizsnack.com/iframe/embed.html?hash=q7ul6is9&width=220&height=350&wmode=transparent&t=1425111140&width=220&height=350" width="220" height="350" seamless="seamless" scrolling="no" frameborder="0" allowtransparency="true"></iframe>
    </div>
	
	
		<!--
    <div class="block">
        <div class="block-bot">
            <div class="head">
                <div class="head-cnt">
                    <h3>Top Videos</h3>
                </div>
            </div>
            <div class="image-articles articles">
                <div class="cl">&nbsp;</div>
                <div class="article">
                    <div class="cl">&nbsp;</div>
                    <div class="image"> <a href="#"><img src="css/images/img1.gif" alt="" /></a> </div>
                    <div class="cnt">
                        <h4><a href="#">FALLOUT3</a></h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed elementum molestie </p>
                    </div>
                    <div class="cl">&nbsp;</div>
                </div>
                <div class="article">
                    <div class="cl">&nbsp;</div>
                    <div class="image"> <a href="#"><img src="css/images/img2.gif" alt="" /></a> </div>
                    <div class="cnt">
                        <h4><a href="#">Crysis</a></h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed elementum molestie </p>
                    </div>
                    <div class="cl">&nbsp;</div>
                </div>
                <div class="article">
                    <div class="cl">&nbsp;</div>
                    <div class="image"> <a href="#"><img src="css/images/img3.gif" alt="" /></a> </div>
                    <div class="cnt">
                        <h4><a href="#">F.E.A.R.2</a></h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed elementum molestie </p>
                    </div>
                    <div class="cl">&nbsp;</div>
                </div>
                <div class="cl">&nbsp;</div>
                <a href="#" class="view-all">view all</a>
                <div class="cl">&nbsp;</div>
            </div>
        </div>
    </div>
    -->

	
</div>
<!-- / Sidebar -->

<div class="cl">&nbsp;</div>

<?php
}
?>
