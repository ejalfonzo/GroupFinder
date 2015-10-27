<?php

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
