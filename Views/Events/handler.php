<?php
if (session_id() === "" && $_SESSION['user_login_status'] != 1) { session_start(); }
/**
 * Event Handler
 * handles the group data
 */

require_once("../../config/db.php");
require_once("Events.php");


 if (isset($_POST["search"])) {
    $events = new Events();
    $result = $events->searchEvent();
    echo $result;
 }

 if (isset($_POST["join"])) {
    $events = new Events();
    $result = $events->joinEvent();
    echo $result;
 }

 if (isset($_POST["leaveEvent"])) {
    $events = new Events();
    $result = $events->leaveEvent();
    echo $result;
 }

 if (isset($_POST["isMember"])) {
    $events = new Events();
    $result = $events->isMember();
    echo $result;
 }
 if (isset($_POST["editEvent"])) {
    $events = new Events();
    $result = $events->editEvent();
    echo $result;
 }
 if (isset($_POST["delete"])) {
    $events = new Events();
    $result = $events->deleteEvent();
    echo $result;
 }
