<!doctype html>
<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Group Finder</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/css/roboto.css"/>
    <link rel="stylesheet" type="text/css" href="/css/material.css"/>
    <link rel="stylesheet" type="text/css" href="/css/ripples.css"/>
    <!-- <link rel="stylesheet" type="text/css" href="/css/material-fullpalette.css"/> -->
    <!-- <link rel="icon" href="/images/logo.ico"> -->
</head>
<body>
    <!-- <script>$.material.init()</script> -->
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
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar" style="width:45px;">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" style='padding:8px;' href="/index.php"><img alt="Group Finder" src="/images/navLogo.png"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>

          </ul>
          <ul class="nav navbar-nav navbar-right" >
              <div id="status">
              </div>
            <!-- Trigger the modal with a button -->
            <button type="button" class="btn" data-toggle="modal" data-target="#SignIn" style="background:#e7e7e7;">Sign In</button>
         </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>


    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
        <div class="jumbotron">
            <h1>Group Finder</h1>
        <div class="form-group">

            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search for a group">
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

        <!-- Sign In Modal -->
        <div id="SignIn" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="btn" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Group Finder</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-signin">
                          <!-- <h2 class="form-signin-heading">Please sign in</h2> -->
                          <label for="inputEmail" class="sr-only">Email address</label>
                          <input type="email" id="inputEmail" style="margin-bottom: 10px;" class="form-control" placeholder="Email address" required autofocus>
                          <label for="inputPassword" class="sr-only">Password</label>
                          <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value="remember-me"> Remember me
                            </label>
                          </div>
                          <button class="btn btn-lg btn-success btn-block" type="submit">Sign in</button>
                          <button class="btn btn-lg btn-primary btn-block" data-toggle="modal" data-dismiss="modal" data-target="#RegisterM">Sign Up</button>
                        </form>
                    </div>
                    <div class="modal-footer" style="text-align:center;">
                        <div class="fb-login-button btn-block" style="display:inline-block; border-radius:5px; overflow:hidden;" scope="public_profile,email" onlogin="checkLoginState();" data-max-rows="1" data-size="xlarge" data-show-faces="false" data-auto-logout-link="false">
                         Login with Facebook</div>
                        <!-- <fb:login-button >
                        </fb:login-button> -->
                      <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->

                    </div>
                </div>
            </div>
        </div> <!-- end of Sign In modal -->

        <!-- Register Modal -->
        <div id="RegisterM" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="btn" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Group Finder</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-signup">
                          <!-- <h2 class="form-signin-heading">Please sign in</h2> -->
                          <!-- <label for="register_firstName" class="sr-only">First Name</label> -->
                          <input id="register_firstName" class="form-control" type="text" placeholder="Last Name" required>
                          <!-- <label for="register_lastName" class="sr-only">Last Name</label> -->
                          <input id="register_lastName" class="form-control" type="text" placeholder="First Name" required>

                          <!-- <label for="register_Email" class="sr-only">Email address</label> -->
                          <input type="email" id="register_Email" style="margin-bottom: 10px;" class="form-control" placeholder="Email address" required autofocus>
                          <!-- <label for="register_Password" class="sr-only">Password</label> -->
                          <input type="password" id="register_Password" class="form-control" placeholder="Password" required>

                          <button class="btn btn-lg btn-success btn-block" type="submit">Submit</button>
                        </form>
                    </div>
                    <div class="modal-footer" style="text-align:center;">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div> <!-- end of Sign In modal -->



        <footer class="footer">
            <div class="container">
                <p class="text-muted">Place footer content here.</p>
                <!-- <ol class="breadcrumb">
                  <li><a href="#">Home</a></li>
                  <li><a href="#">Library</a></li>
                  <li class="active">Data</li>
                </ol> -->
            </div>
        </footer>
    </div> <!-- /container -->


    <!-- <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> -->
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/bootstrap.js"></script>
    <script type="text/javascript" src="/js/material.js"></script>
    <script type="text/javascript" src="/js/ripples.js"></script>
    <!-- <script type="text/javascript" src="/js"></script> -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <!-- <script type="text/javascript" src="/js/bootstrap.min.js"></script> -->
</body>
</html>
