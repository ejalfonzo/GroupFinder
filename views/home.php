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

    <script>//FB Log in
      // This is called with the results from from FB.getLoginStatus().
      function statusChangeCallback(response) {
        console.log('statusChangeCallback');
        console.log(response);
        // The response object is returned with a status field that lets the
        // app know the current login status of the person.
        // Full docs on the response object can be found in the documentation
        // for FB.getLoginStatus().
        if (response.status === 'connected') {
          // Logged into your app and Facebook.
          testAPI();
        } else if (response.status === 'not_authorized') {
          // The person is logged into Facebook, but not your app.
          document.getElementById('status').innerHTML = 'Please log ' +
            'into this app.';
        } else {
          // The person is not logged into Facebook, so we're not sure if
          // they are logged into this app or not.
          document.getElementById('status').innerHTML = 'Please log ' +
            'into Facebook.';
        }
      }

      // This function is called when someone finishes with the Login
      // Button.  See the onlogin handler attached to it in the sample
      // code below.
      function checkLoginState() {
        FB.getLoginStatus(function(response) {
          statusChangeCallback(response);
        });
      }

      window.fbAsyncInit = function() {
      FB.init({
        appId      : '1657679817785018',
        cookie     : true,  // enable cookies to allow the server to access
                            // the session
        xfbml      : true,  // parse social plugins on this page
        version    : 'v2.2' // use version 2.2
      });

      // Now that we've initialized the JavaScript SDK, we call
      // FB.getLoginStatus().  This function gets the state of the
      // person visiting this page and can return one of three states to
      // the callback you provide.  They can be:
      //
      // 1. Logged into your app ('connected')
      // 2. Logged into Facebook, but not your app ('not_authorized')
      // 3. Not logged into Facebook and can't tell if they are logged into
      //    your app or not.
      //
      // These three cases are handled in the callback function.

      FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
      });

      };

      // Load the SDK asynchronously
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));

      // Here we run a very simple test of the Graph API after login is
      // successful.  See statusChangeCallback() for when this call is made.
      function testAPI() {
        console.log('Welcome!  Fetching your information.... ');
        FB.api('/me', function(response) {
          console.log('Successful login for: ' + response.name);
          document.getElementById('status').innerHTML =
            'Thanks for logging in, ' + response.name + '!';
        });
      }
    </script>
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

                <div class="input-group">
                    <input type="text" class="form-control input-lg" placeholder="Search for a group">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><div class="icon-preview"><i class="mdi-action-search"></i><span></span></div></button>
                    </span>
                </div><!-- /input-group -->
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

        <section id="cd-timeline">
        	<div class="cd-timeline-block">
        		<div class="cd-timeline-img">
        			<img src="/images/icons-svg/user-white.svg" alt="Picture">
        		</div> <!-- cd-timeline-img -->

        		<div class="cd-timeline-content">
        			<h2>Group Finder Team</h2>
        			<p>Our team is going to have a Happy Hour, be there... </p>
        			<a href="#0" class="cd-read-more">Read more</a>
        			<span class="cd-date">Sep 29</span>
        		</div> <!-- cd-timeline-content -->
        	</div> <!-- cd-timeline-block -->

            <script>
            $(document).ready(function () {
              //your code here
                $(window).scroll(function(){
                //    console.log($(window).scrollTop() >= $(document).height() - $(window).height() - 10 );
                    var scrollHeight = $(document).height();
	                var scrollPosition = $(window).height() + $(window).scrollTop();
	                if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
                        var timeline = document.getElementById("cd-timeline");
                        var block = document.createElement("div");
                        var att = document.createAttribute("class");
                        att.value = "cd-timeline-block";
                        block.setAttributeNode(att);

                        var imgDiv = document.createElement("div");
                        var att2 = document.createAttribute("class");
                        att2.value = "cd-timeline-img";
                        imgDiv.setAttributeNode(att2);

                        var img = document.createElement("img");
                        var att3 = document.createAttribute("src");
                        att3.value = "/images/icons-svg/user-white.svg";
                        img.setAttributeNode(att3);
                        var attP = document.createAttribute("alt");
                        attP.value = "Picture";
                        img.setAttributeNode(attP);

                        imgDiv.appendChild(img);
                        block.appendChild(imgDiv);

                        var content = document.createElement("div");
                        var att4 = document.createAttribute("class");
                        att4.value = "cd-timeline-content";
                        content.setAttributeNode(att4);
                        block.appendChild(content);

                        var title = document.createElement("h2");
                        var th2 = document.createTextNode("Title");
                        title.appendChild(th2);
                        content.appendChild(title);

                        var desc = document.createElement("p");
                        var tp = document.createTextNode("This is a auto get Panel");
                        desc.appendChild(tp);
                        content.appendChild(desc);

                        //   <span class="cd-date">Sep 29</span>
                        var date = document.createElement("span");
                        var attD = document.createAttribute("class");
                        attD.value = "cd-date";
                        date.setAttributeNode(attD);
                        dateT = document.createTextNode("Date Here");
                        date.appendChild(dateT);
                        content.appendChild(date);

                        timeline.appendChild(block); //add the text node to the newly created div.

                        // add the newly created element and its content into the DOM

                        console.log("Timeline", timeline);
                    //   document.body.insertBefore(block, currentDiv);

                   }
                })
            });

            </script>

        	<!-- <div class="cd-timeline-block">
        	</div> -->
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
