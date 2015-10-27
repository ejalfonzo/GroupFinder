<?php

/**
 * Search Handler
 * handles the user data
 */

require_once("../config/db.php");
require_once("Basic.php");


 if (isset($_POST["search"])) {
    $events = new Basic();
    $result = $events->search();
    echo $result;
 }
