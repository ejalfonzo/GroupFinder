<?php
// include the configs / constants for the database connection
require_once("../../config/db.php");
require_once("AutomatedTest.php");
$test = new automatedTesting();

if($_GET){
    if(isset($_GET['autoTest'])){
        autoTest();
    }else if(isset($_GET['clearTest'])){
        clearTest();
    }
}
function autoTest(){
    //here run tests
    $test = new automatedTesting();
    $test->resetTest();
    $test->runTest();
    echo("<a href='user_test.php?clearTest=true' class='btn'>Clear Tests</a>");
}
function clearTest(){
    //here clear
    $test = new automatedTesting();
    $test->deleteUsers();
}

?>
<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/css/roboto.css"/>
    <link rel="stylesheet" type="text/css" href="/css/material.css"/>
    <link rel="stylesheet" type="text/css" href="/css/ripples.css"/>
    <link rel="stylesheet" type="text/css" href="/css/dashboard.css"/>
    <!-- <link rel="stylesheet" type="text/css" href="/css/selectize.css"/> -->
    <!-- <link rel="stylesheet" type="text/css" href="/css/timeline-style.css"/> -->
    <!-- <link rel="stylesheet" type="text/css" href="/css/reset.css"/> -->
    <!-- <link rel="icon" href="/images/logo.ico"> -->
    <script type="text/javascript" src="/js/jquery.js"></script>

    <title>Group Finder</title>
</head>
<body>
    <div class="panel panel-primary">
        <div>
            <h1>Automated Tests</h1>

            <a href='user_test.php?autoTest=true' class="btn">Start Test</a>

        </div>
      </div>


    <script type="text/javascript" src="/js/bootstrap.js"></script>
    <script type="text/javascript" src="/js/material.js"></script>
    <script type="text/javascript" src="/js/ripples.js"></script>
    <script type="text/javascript" src="/js/dropdown.js"></script>
    <!-- <script type="text/javascript" src="/js/selectize.min.js"></script> -->
    <script type="text/javascript" src="/js/modernizr.js"></script>
    <script>
    $.material.init();
    $(document).ready(function() {
      $(".select").dropdown({"optionClass": "withripple"});
    });
    $().dropdown({autoinit: "select"});
    </script>
</body>
</html>
