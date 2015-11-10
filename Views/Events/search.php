<?php

/**
 * Search Handler
 * handles the user data
 */

require_once("../../config/db.php");
require_once("Events.php");


 if (isset($_POST["search"])) {
    $events = new Events();
    $result = $events->searchEvent();
    echo $result;
 }
