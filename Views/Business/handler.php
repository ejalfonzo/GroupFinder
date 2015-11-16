<?php
if (session_id() === "" && $_SESSION['user_login_status'] != 1) { session_start(); }
/**
 * Business Handler
 * handles the business data
 */

require_once("../../config/db.php");
require_once("Business.php");


 if (isset($_POST["search"])) {
    $businesses = new Business();
    $result = $businesses->searchBusinesses();
    echo $result;
 }

 if (isset($_POST["follow"])) {
    $businesses = new Business();
    $result = $businesses->followBusiness();
    echo $result;
 }

 if (isset($_POST["unfollow"])) {
    $businesses = new Business();
    $result = $businesses->unfollowBusiness();
    echo $result;
 }

 if (isset($_POST["isFollower"])) {
    $businesses = new Business();
    $result = $businesses->isFollower();
    echo $result;
 }
 if (isset($_POST["editBusiness"])) {
    $businesses = new Business();
    $result = $businesses->editBusiness();
    echo $result;
 }
