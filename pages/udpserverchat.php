<?php
session_start();
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
$Username = $_SESSION['username'];
$Msg = $_REQUEST['serverchatmsg'];
$Msg = ($Msg);
if($Msg == '' || empty($Msg))
{
    return;
}
$MsgFormated = "[u][b]".$Username.":[\\b][\\u] [c=FFFFFF]".$Msg."[\\c]";
 $txtip="127.0.0.1";
 $txtportnum="10483";
$sock=fsockopen("udp://".$txtip,$txtportnum,$errno,$errstr,2);
if(!$sock){ echo "$errstr ($errno)<br/>\n"; exit; }
 fputs($sock,$MsgFormated); $gotfinal=False; $data="";
 socket_set_timeout($sock,0,1000);
 fclose($sock);
 ?>