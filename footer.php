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

/**
 * Getting last active users
 */

$lastactiveusers = '';

$sql = "SELECT * FROM user ORDER BY last_login_time DESC LIMIT 25;";
$query = $con->query($sql);
while($result = $query->fetch_object())
{
	
    $username = $result->username;
	$lastlogintime = $result->last_login_time;
	$linked_player_profile = $result->linked_playeroverall_name;
	$userrole = $result->admin_role;
	
	if($linked_player_profile != NULL || $linked_player_profile != '')
	{
		$displayUsername = $linked_player_profile;
	}
	else
	{
		$displayUsername = $username;
	}
	
	if($userrole == 1)
	{
		
		$displayUsername = "<font color='BABA00'>".$displayUsername."</font>";
	}
	if($userrole > 1)
	{
		$displayUsername = "<font color='17af17'>".$displayUsername."</font>";
	}
	
	$lastseen = timeago($lastlogintime);
	if($lastseen == "Just Now")
    $lastactiveusers = $lastactiveusers."<span class='footeruserahref'><a class='footeruserahref' href='./?userprofile=$username'>".$displayUsername."</a><sup><font color='00FF5B' size='1'>Online</font></sup></span>";
	else
	$lastactiveusers = $lastactiveusers."<span class='footeruserahref'><a class='footeruserahref' href='./?userprofile=$username'>".$displayUsername."</a></span>";
	}
?>
<!-- Footer -->
<div id="footer">
    <div class="navs">
        <div class="navs-bot">
            <div class="cl">&nbsp;</div>
        
                <p class="footeractiveusers no-margin" style="color: #FFFFFF !important;font-weight:bolder;font-size:14px">Last Active Users</p>
				<hr class="margin5">
                <?=$lastactiveusers?>
          
            <div class="cl">&nbsp;</div>
        </div>
    </div>
    <p class="copy" style="color: greenyellow">&copy; <span style="color: yellow">knight</span><span style="color: #7ab7e2">of</span><span style="color: red">sorrow</span><span style="color: wheat">.com</span>&nbsp; <span style="color: whitesmoke">2014-<?= date('Y') ?></span></p>
</div>
<!-- / Footer -->