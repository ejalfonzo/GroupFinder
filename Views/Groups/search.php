<?php

/**
 * Search Handler
 * handles the user data
 */
 require_once("Groups.php");
 if (isset($_POST["search"])) {
    $groups = new Groups();
    $result = $groups->searchGroup();
    echo $result;
 }
