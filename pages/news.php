<?php
/**
 * Created by PhpStorm.
 * User: Kinnngg
 * Date: 28-02-2015
 * Time: 23:55
 */

if(isset($_GET['news']) && $_GET['news'] != '')
{
    $newsid = $con->escape_string($_GET['news']);

    $sql = "SELECT * FROM news WHERE id='$newsid' AND is_published=1 LIMIT 1;";
    $query = $con->query($sql);
    if($query->num_rows <= 0)
    {
        echo "<div id='content' class='panel panel-default padding10' style='color:black'><h4>No News Found</h4></div>";
    }
    else {
        $news = $query->fetch_object();
        $newsid = $news->id;
        $title = $news->title;
        $text = $news->text;
        $summary = $news->summary;
        $date = $news->date_created;
        $sign = $news->signature;
        $dateupdated = $news->date_updated;
        $timestamp = strtotime($date);
        $date = date("l, jS F Y", $timestamp);
        /**
         * Another Way
         * $dtime = new DateTime($result->my_datetime);
        print $dtime->format("Y-m-d H:i:s");
         */


        echo <<<_HTML
        <div id='content' class='panel panel-default padding10' style='color:black;line-height:20px'>
        <h3>$title</h3>
        <p><i>$date</i></p>
        <br>
        <p>$text</p>
        </div>
_HTML;

    }

}

else
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
               <div class="article row no-padding no-margin" style="border-bottom:2px dashed">
                    <h4 class=''><a style="color:#CE0000" href="./?news=$newsid">$title</a></h4>
                    <p class='newsdate'><i class="date">$date</i></p>
                    <p style="color:#434343;font-size:13px" class='newssummary'>$summary</p>
                </div>
HTML;

        }
    }

    echo <<<_HTML

<div id="content">
    <div class="panel panel-default padding15">
        $newsdata
    </div>

</div>
_HTML;

}

?>
