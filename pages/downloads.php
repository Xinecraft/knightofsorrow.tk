<?php
/**
 * Created by PhpStorm.
 * User: Kinnngg
 * Date: 02-03-2015
 * Time: 13:16
 */

?>
    <div id="content" class="panel panel-default padding10" style="color:black;line-height: 20px">

        <div class="item" style="border-bottom: 2px dashed #dcdcdc">
        <h3>Anti Cheat</h3>
        <p><i>antics_v1 by rapher</i></p>
        <br>
        <p>The <strong style="color: #ff0000">Antics</strong> blocks all the cheats in SWAT4 game.</p>
        <p>After downloading Antics just put the <b>antics_v1.u</b> in your SYSTEM directory of SWAT4.</p>
        <br>
        <p class="text-center">
        <a class="btn btn-default text-center" href="./downloads/antics_v1.u">Download Antics</a></p>
            </div>

        <div class="item" style="border-bottom: 2px dashed #dcdcdc">
            <h3>GameSpy v1</h3>
            <p><i>GS1 by Serge modified by Kinnngg</i></p>
            <br>
            <p>The <strong style="color: #ff0000">GameSpy vs1 Query</strong> package provides GameSpy Query multiprotocol (both UDP and TCP) listen support for SWAT4 servers.
            This Protocol make quering SWAT4 server much easier and also returns more data than GSv2 or AMServerQuery listener. <br>We Recommend using this in your Server.</p>
            <p>The modified version of GSv1 by kinnngg allow query of little bit extra data from server.</p>
            <h4 class="no-margin">Installation:</h4>
            <ul class="margin15">
                <li>After downloading this just copy <b>GSv1.u</b> in your SYSTEM directory of SWAT4.</li>
                <li>Open <code>Swat4DedicatedServer.ini</code></li>
                <li>Navigate to <code>[Engine.GameEngine]</code></li>
                <li>Comment out or remove the following line if present:<br><code>ServerActors = IpDrv.MasterServerUplink</code></li>
                <li>Insert the following line anywhere in the section:<br><code>ServerActors = GS1.Listener</code></li>
                <li>Add the following Section at the end of file<br><code class="padding5">[GS1.Listener]<br>Enabled=True</code></li>
                <li>Restart your server and now it is ready to listen to GameSpy v1 protocol queries on the join port + 1 <br>(e.g. 10481).</li>
                <li>It is possible to change query port. Just add <code>Port</code> propery in <code>[GS1.Listener]</code> section with port number. E.g.</li>
                <code class="padding5">[GS1.Listener]<br>Enabled=True<br>Port=10483</code>

            </ul>
            <br>
            <p class="text-center">
                <a class="btn btn-default text-center" href="./downloads/GS1.u">Download GS1.u</a></p>
        </div>

        <div class="item" style="border-bottom: 2px dashed #dcdcdc">
            <h3>Admin Mod Modified</h3>
            <p><i>AMMod by GEZ modified by Kinnngg</i></p>
            <br>
            <p>The <strong style="color: #ff0000">Admin Mod</strong> make SWAT4 server administration easy by adding lot of Admin commands and Web Admin. It also allow query to Server.</p>
            <p>The modified version of AMMod by Kinnngg allow query of little bit extra data from server.</p>
            <p>After downloading this just replace this with <b>AMMod.u</b> in your SYSTEM directory of SWAT4.</p>
            <br>
            <p class="text-center">
                <a class="btn btn-default text-center" href="./downloads/AMMod.u">Download AMMod.u</a></p>
        </div>

        <div class="item" style="border-bottom: 2px dashed #dcdcdc">
            <h3>Download Mod</h3>
            <p><i>download mod by GEZ</i></p>
            <br>
            <p>The <strong style="color: #ff0000">Download Mod</strong> allow file download from Servers.</p>
            <p>After downloading this just put the <b>downloads.u</b> in your SYSTEM directory of SWAT4.</p>
            <br>
            <p class="text-center">
                <a class="btn btn-default text-center" href="./downloads/DownloadMod.u">Download DownloadMod.u</a></p>
        </div>
		
		<div class="item" id="VotingMod" >
            <h3>Voting Mod</h3>
            <p><i>SWAT4 Voting & Whois Mod(KMod) by Kinnngg</i></p>
            <br>
            <p>The <strong style="color: #ff0000">Voting & Whois Mod(KMod)</strong> allow users to start votes in SWAT4. There are three Vote commands available !vote kick,!vote map & !vote ask</p>
            <p>Voting Mod need <b>Julia Mod</b>, <b>Utils Mod</b> and <b>HTTP Mod</b> already present in Server. Dont worry if you don't have.<br> <b>We will guide you from beginning!</b></p>
			<h4>Follow the Steps as given below:</h4>
		
			<p>First of all download the listed files from the link provided!<br>
			<p class="text-center">
			<a class="btn btn-default text-center" href="./downloads/Julia.u">Julia.u</a> or <a class="btn btn-default text-center" target="_blank" href="https://github.com/sergeii/swat-julia/releases/download/2.3.1/swat-julia.2.3.1.swat4.tar.gz">Download Julia From GitHub</a><br><br>
			<a class="btn btn-default text-center" href="./downloads/Utils.u">Utils.u</a> or <a class="btn btn-default text-center" target="_blank" href="https://github.com/sergeii/swat-utils/releases/download/1.0.0/swat-utils.1.0.0.swat4.tar.gz">Download Utils From GitHub</a><br><br>
			<a class="btn btn-default text-center" href="./downloads/HTTP.u">HTTP.u</a> or <a class="btn btn-default text-center" target="_blank" href="https://github.com/sergeii/swat-http/releases/download/1.1.0/swat-http.1.1.0.swat4.tar.gz">Download HTTP From GitHub</a><br><br>
			<a class="btn btn-default text-center" href="./downloads/KMod.u">KMod.u</a> or <a class="btn btn-default text-center" target="_blank" href="https://github.com/kinnngg/SWAT-Vote/releases/download/v1.0/KMod.u">Download KMod From GitHub</a>
			</p>
			<p>After downloading you may need to extract the compressed file to get the .u file.<br>
			Just put all files i.e, Julia.u , HTTP.u , Utils.u , KMod.u to your System directory of SWAT4 which is mostly<br>
			<kbd>C:\Program Files\Sierra\SWAT 4\Content\System</kbd> &nbsp; or &nbsp; <kbd>(Your Swat4 Installation Path)\SWAT 4\Content\System</kbd>
			</p>
			
			<p><br>
			Now Open your <code>Swat4DedicatedServer.ini</code> file and find for Section <code>ServerActors</code> and append these lines at last of ServerActors:<br>
			<code class="padding5">
			ServerActors=Utils.Package<br>
			ServerActors=HTTP.Package<br>
			ServerActors=Julia.Core<br>
			ServerActors=KMod.Vote</code>
			<br><br>
			Now your section it may look like this:<br>
			<code class="padding5">
			[Engine.GameEngine]<br>
			.........<br>
			.........<br>
			ServerActors=AMMod.AMGameMod<br>
			ServerActors=Utils.Package<br>
			ServerActors=HTTP.Package<br>
			ServerActors=Julia.Core<br>
			ServerActors=KMod.Vote<br>
			.........<br>
			.........
			</code>
			</p>
            <br>
			<p>Now go to the last of <kbd>Swat4DedicatedServer.ini</kbd> file and add these sections to it.<br>
			
			<code class="padding5">
			[Julia.Core]<br>
			Enabled=True<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
			[KMod.Vote]<br>
			Enabled=True<br>
			CanVoteAgainstAdmin=True<br>
			bVoteMapEnabled=True<br>
			OnlyAdminCanStartVote=False
			</code>
			<br>
			<p><b>Congrats! You have just installed Voting Mod to your Server. Restart your server once :)</b></p>
            </div>
    </div>
