<?php
if (session_id() === "" && $_SESSION['user_login_status'] != 1) { session_start(); }
/**
 * Group Handler
 * handles the group data
 */

require_once("../../config/db.php");
require_once("Groups.php");


 if (isset($_POST["search"])) {
    $groups = new Groups();
    $result = $groups->searchGroup();
    echo $result;
 }

 if (isset($_POST["join"])) {
    $groups = new Groups();
    $result = $groups->joinGroup();
    echo $result;
 }

 if (isset($_POST["leave"])) {
    $groups = new Groups();
    $result = $groups->leaveGroup();
    echo $result;
 }

 if (isset($_POST["isMember"])) {
    $groups = new Groups();
    $result = $groups->isMember();
    echo $result;
 }
 if (isset($_POST["editGroup"])) {
    $groups = new Groups();
    $result = $groups->editGroup();
    echo $result;
 }
 if (isset($_POST["delete"])) {
    $groups = new Groups();
    $result = $groups->deleteGroup();
    echo $result;
 }
 
