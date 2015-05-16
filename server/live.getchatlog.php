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
 * GET CHAT FROM DB AND SHOW IN CHATLOG
 */
ob_start();
require_once('../conf.php');
ini_set('display_errors', 1);
error_reporting(E_ERROR);
include_once('../pages/magicquotesgpc.php');
include_once('../pages/ip2locationlite.class.php');
include_once('../pages/generate_option.php');
include_once('../pages/imp_func_inc.php');
global $con;

$sql = "SELECT * FROM chatlog ORDER BY time DESC LIMIT 35;";
$result = $con->query($sql);

while($data = $result->fetch_array())
{
    print($data[1])."<br>";
}
?>