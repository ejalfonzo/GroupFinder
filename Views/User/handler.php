<?php
if (session_id() === "" && $_SESSION['user_login_status'] != 1) { session_start(); }
/**
 * User Handler
 * handles the User data
 */

require_once("../../config/db.php");
require_once("User.php");

if (isset($_POST["getUser"])) {
   $user = new User();
   $result = $user->getUser();
   echo $result;
}

 if (isset($_POST["getFeed"])) {
    $user = new User();
    $result = $user->getFeed();
    echo $result;
 }
 if (isset($_POST["createPost"])) {
    $user = new User();
    $result = $user->createPost();
    echo $result;
 }
 if (isset($_POST["deletePost"])) {
    $user = new User();
    $result = $user->deletePost();
    echo $result;
 }
 if (isset($_POST["userName"]) || isset($_POST["email"]) || isset($_POST["firstName"]) || isset($_POST["lastName"])) {
    $user = new User();
    $result = $user->editProfile();
    echo $result;
 }
