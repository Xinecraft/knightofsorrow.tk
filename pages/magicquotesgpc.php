<?php
if(basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])){header('Location: /');}
//makes this file include-only by checking if the requested file is the same as this file

if (get_magic_quotes_gpc())
{
function stripslashes_deep($value)
{
$value = is_array($value) ?
array_map('stripslashes_deep', $value) :
stripslashes($value);
return $value;
}
$_POST = array_map('stripslashes_deep', $_POST);
$_GET = array_map('stripslashes_deep', $_GET);
$_COOKIE = array_map('stripslashes_deep', $_COOKIE);
$_REQUEST = array_map('stripslashes_deep', $_REQUEST);
}
?>