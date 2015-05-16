<?php
/* from halls-of-valhalla.org */

/*
 To use:
 1. Include this file
 2. Add getTokenForURL() to URLs with GET parameters
 3. Add getTokenForm() to forms
 4. When validating GET and POST data, execute validateCSRFToken().
 */

if(basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])){header('Location: ./?home');}
//makes this file include-only by checking if the requested file is the same as this file

function getCSRFToken(){
  if(!isset($_SESSION['token']) or empty($_SESSION['token']))
    setNewToken();
  return $_SESSION['token'];
}

function setNewToken(){
  $_SESSION['token'] = generateCSRFToken();
}

function generateCSRFToken(){
  return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
      mt_rand(0, 0xffff), mt_rand(0, 0xffff),
      mt_rand(0, 0xffff),
      mt_rand(0, 0x0fff) | 0x4000,
      mt_rand(0, 0x3fff) | 0x8000,
      mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

function validateCSRFToken(){
  if(!isValidToken()){
    actionOnInvalid();
  }
  setNewToken(); //comment if you don't want a new token after each post/get
}

function isValidToken(){
  if(isset($_POST['token']) and getCSRFToken()===$_POST['token']) return true;
  if(isset($_GET['token']) and getCSRFToken()===$_GET['token']) return true;
  return false;
}

function actionOnInvalid(){
  header('Location: ./?csrffail');
  exit();
}

function getTokenForm(){
  $token = getCSRFToken();
  return "<input type='hidden' name='token' value='{$token}'/>";
}

function getTokenForURL($symbol = "&amp;"){
  $token = getCSRFToken();
  return "{$symbol}token=$token";
}

?>