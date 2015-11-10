<?php
if (session_id() === "" && $_SESSION['user_login_status'] != 1) { session_start(); }
/**
 * Event Handler
 * handles the group data
 */

require_once("../../config/db.php");
require_once("Events.php");


 if (isset($_POST["search"])) {
    $groups = new Events();
    $result = $groups->searchEvent();
    echo $result;
 }

 if (isset($_POST["join"])) {
    $groups = new Events();
    $result = $groups->joinEvent();
    echo $result;
 }

 if (isset($_POST["leave"])) {
    $groups = new Events();
    $result = $groups->leaveEvent();
    echo $result;
 }

 if (isset($_POST["isMember"])) {
    $groups = new Events();
    $result = $groups->isMember();
    echo $result;
 }
