<?php
if (session_id() === "" && $_SESSION['user_login_status'] != 1) { session_start(); }
/**
 * Friend Handler
 * handles the friend data
 */

require_once("../../config/db.php");
require_once("Friends.php");


 if (isset($_POST["search"])) {
    $friends = new Friends();
    $result = $friends->searchFriend();
    echo $result;
 }

 if (isset($_POST["addFriend"])) {
    $friends = new Friends();
    $result = $friends->addFriend();
    echo $result;
 }

 if (isset($_POST["removeFriend"])) {
    $friends = new Friends();
    $result = $friends->removeFriend();
    echo $result;
 }

 if (isset($_POST["isFriend"])) {
    $friends = new Friends();
    $result = $friends->isFriend();
    echo $result;
 }
 if (isset($_POST["editFriend"])) {
    $friends = new Business();
    $result = $friends->editFriend();
    echo $result;
 }
 if (isset($_POST["getFeed"])) {
     $friends = new Friends();
     $result = $friends->getFeed();
     echo $result;
  }
  if (isset($_POST["createPost"])) {
     $friends = new Friends();
     $result = $friends->createPost();
     echo $result;
  }
  if (isset($_POST["deletePost"])) {
     $friends = new Friends();
     $result = $friends->deletePost();
     echo $result;
  }
