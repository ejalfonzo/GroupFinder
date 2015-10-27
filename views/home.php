<?php
// if ($_SESSION['user_login_status'] != 1) { session_start(); }
// include the configs / constants for the database connection
// require_once("config/db.php");

// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            // echo $error;
            echo("<script>console.log('PHP: ".json_encode($error)."');</script>");
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            // echo $message;
            echo("<script>console.log('PHP: ".json_encode($message)."');</script>");
        }
    }
}

// require_once("../config/db.php");
require_once("Basic.php");
$basic = new Basic();

function timelineCard(){
    echo '<div class="cd-timeline-block">
        <div class="cd-timeline-img">
            <img src="/images/icons-svg/user-white.svg" alt="Picture">
        </div> <!-- cd-timeline-img -->

        <div class="cd-timeline-content">
            <h2>Group Finder Team</h2>
            <p>Our team is going to have a Happy Hour, be there... </p>
            <a href="#0" class="cd-read-more">Read more</a>
            <span class="cd-date">Sep 29</span>
        </div>
    </div> ';
}
?>
<!doctype html>
<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Group Finder</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/css/roboto.css"/>
    <link rel="stylesheet" type="text/css" href="/css/material.css"/>
    <link rel="stylesheet" type="text/css" href="/css/ripples.css"/>
    <link rel="stylesheet" type="text/css" href="/css/timeline-style.css"/>
    <link rel="stylesheet" type="text/css" href="/css/reset.css"/>
    <!-- <link rel="icon" href="/images/logo.ico"> -->
    <script type="text/javascript" src="/js/jquery.js"></script>
</head>
<body>
    <script>// FB Like/Share Button
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '1657679817785018',
          xfbml      : true,
          version    : 'v2.4'
        });
      };
      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
    </script>

    <!-- Static navbar -->
    <?php
       $path = $_SERVER['DOCUMENT_ROOT'];
       $path .= "/Views/General/navbar.php";
       include_once($path);
    ?>

    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
        <div class="jumbotron" style="margin-top:80px;">
            <h1 style="margin-bottom: 20px;">Group Finder</h1>
            <div class="form-group">
        		<div>
    				<form method=GET action="/Views/viewSearch.php" name="searchItem">
            			<div class="input-group">
            				<input type="text" id="search" class="form-control input-lg" placeholder="Search in Group Finder" style="margin-bottom:10px; height:55px; font-size:25px;">
            				<span class="input-group-btn">
            					<button class="btn btn-default" id="searchButton" type="button" type="submit" value="Search" class="search_button"><div class="icon-preview"><i class="mdi-action-search"></i><span></span></div></button>
            				</span>
            			</div><!-- /input-group -->
    				</form>
        		</div>
            </div>
            <p>Hello World, this is our main home screen where you will be able to search or view featured group and/or catalog of groups</p>
            <div
                class="fb-like"
                data-share="true"
                data-width="450"
                data-show-faces="true">
            </div>
        </div>

        <!-- Vertical Timeline -->
        <h1 style="font-size:40px; padding: 15px 25px 0px;">Event Timeline</h1>
        <section id="cd-timeline">
              <?php $basic->getAllEventsTimeline(); ?>
        </section>


        <footer class="footer">
            <div class="container">
                <p class="text-muted">Place footer content here.</p>
            </div>
        </footer>
    </div> <!-- /container -->

    <!-- <script src="//code.jquery.com/jquery-1.11.3.min.js"></script> -->
    <!-- <script type="text/javascript" src="/js/jquery.js"></script> -->
    <script type="text/javascript" src="/js/bootstrap.js"></script>
    <script type="text/javascript" src="/js/material.js"></script>
    <script type="text/javascript" src="/js/ripples.js"></script>
    <script type="text/javascript" src="/js/timeline.js"></script>
    <script type="text/javascript" src="/js/modernizr.js"></script>
    <script>$.material.init()</script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
</body>
</html>
