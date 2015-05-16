<?php

if(!islogin())
{
header("Location: ./?home");
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];

$username = $con->escape_string($username);
$sql = "SELECT * FROM user WHERE username LIKE '$username' LIMIT 1;";
$query = $con->query($sql);
$result = $query->fetch_object();
$adminrole = $result->admin_role;

if($adminrole < 2)
{
	header("Location:./?home");
}



function LoadChat($search,$from,$to)
{
	global $con;
	$search = $con->escape_string($search);
	$search = htmlentities($search);
	$sql = "SELECT * FROM chatlog WHERE msg LIKE '%$search%' ORDER BY time DESC LIMIT $from,$to;";
	$query = $con->query($sql);

    if ($query->num_rows <= 0) {
        return "No Chat History Found for '$search'";
    }
	$chathistorydata = '';
	while ($data = $query->fetch_object()) {
        $msg = $data->msg;
        $time = $data->time;
        $id = $data->id;
		$msg = str_ireplace($search,"<b style='background:rgb(95, 108, 106)'>".$search."</b>",$msg);
        $chathistorydata = $chathistorydata . $msg."<span class='right'>".timeago($time)."</span>"."<br>";
		}
		return $chathistorydata;
}


$chathistorysearchdata= "Try Searching the name of Player for all activities of that player.";
if(isset($_GET['chathistory']))
{
	$search = $con->escape_string($_GET['chathistory']);
	
	$query = $con->query("SELECT id FROM chatlog WHERE msg LIKE '%$search%';");
	$totalchats = $query->num_rows;

	$num_rec_per_page = 200;
	$total_pages = ceil($totalchats / $num_rec_per_page);
	
	if (isset($_GET["page"]))
    { $page  = $_GET["page"]; }
    else { $page=1; };
    $start_from = ($page-1) * $num_rec_per_page;
	
	$chathistorysearchdata = LoadChat($search,$start_from,$num_rec_per_page);
	

function getpager()
{
	global $search;
	$searchwithequal='';
	if($search != '')
	{
		$searchwithequal="=".$search;
	}
    if(!isset($_GET['page']))
    {
        $page=1;
    }
    else {
        $page = $_GET["page"];
    }
    global $total_pages;

    //Dont show pager is only one page of result
    if($total_pages == 1)
        return;


    if( $page > 1 && $page < $total_pages )
    {
        $last = $page - 1;
        $next = $page + 1;
        echo <<<_HTML
<nav>
<ul class="pager">
<li class="previous"><a href="./?chathistory$searchwithequal&page=$last"><span aria-hidden="true">&larr;</span> Previous</a></li>
<li class="next"><a href="./?chathistory$searchwithequal&page=$next">Next <span aria-hidden="true">&rarr;</span></a></li>
</ul>
</nav>
_HTML;
    }
    else if( $page == 1 )
    {
        $next = $page+1;
        echo <<<_HTML
<nav>
<ul class="pager">
<li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> Previous</a></li>
<li class="next"><a href="./?chathistory$searchwithequal&page=$next">Next <span aria-hidden="true">&rarr;</span></a></li>
</ul>
</nav>
_HTML;
    }
    else if( $page >= 2 )
    {
        $last = $page - 1;
        echo <<<_HTML
<nav>
<ul class="pager">
<li class="previous"><a href="./?chathistory$searchwithequal&page=$last"><span aria-hidden="true">&larr;</span> Previous</a></li>
<li class="next disabled"><a href="#">Next <span aria-hidden="true">&rarr;</span></a></li>
</ul>
</nav>
_HTML;

    }
}

}




?>
<div id="content" class="content">

<div class="block col-md-12 no-padding">
            <div class="">
			<form class="form form-inline margin5" name="chathistorysearchform" id="chatsearch" method="GET" role="search" action="./?chathistory">
            <div class="form-group">
                <input type="text" name="chathistory" id="chatsearchinput" class="form-control" placeholder="Search for Player Name or Any String" style="width: 572px">
            </div>
            <!--<input type="submit" class="btn btn-default" name="chathistorysearchbtn" value="Search" id="chathistorysearchbtn">-->
			<button type="submit" class="btn btn-default">Search</button>
        </form>
                <div class="head">
				
                    <div class="head-cnt">
                        <h3>Chat History (<?=$totalchats?>)</h3>
                        <div class="cl">&nbsp;</div>
                    </div>
                </div>
                <div class="col-articles articles chathistorylogdata" style="  padding: 10px;line-height: 1.4;font-size: 14px;height:500px;overflow:auto;">
                    <div class="cl">&nbsp;</div>
					<?=$chathistorysearchdata?>
                    <div class="cl">&nbsp;</div>
                </div>
            </div>
        
        </div>
<?=getpager()?>
</div>