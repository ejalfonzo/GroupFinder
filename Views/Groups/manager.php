<?php
if ($_SESSION['user_login_status'] != 1) { session_start(); }
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
    <link rel="stylesheet" type="text/css" href="/css/dashboard.css"/>
    <!-- <link rel="stylesheet" type="text/css" href="/css/timeline-style.css"/> -->
    <!-- <link rel="stylesheet" type="text/css" href="/css/reset.css"/> -->
    <!-- <link rel="icon" href="/images/logo.ico"> -->
    <script type="text/javascript" src="/js/jquery.js"></script>
</head>
<body>

    <!-- Static navbar -->
    <?php
       $path = $_SERVER['DOCUMENT_ROOT'];
       $path .= "/Views/General/navbar.php";
       include_once($path);
    ?>


    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar panel" style="margin-bottom:0px;">
          <ul class="nav nav-sidebar">
            <li><a href="/Views/User/dashboard.php">Overview <span class="sr-only">(current)</span></a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Friends</a></li>
            <li class="active"><a href="/Views/Groups/manager.php">Groups</a></li>
            <li><a href="#">Events</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Buisness</a></li>
            <!-- <li><a href="">Nav item again</a></li> -->
            <!-- <li><a href="">One more nav</a></li> -->
            <!-- <li><a href="">Another nav item</a></li> -->
            <!-- <li><a href="">More navigation</a></li> -->
          </ul>
          <!-- <ul class="nav nav-sidebar">
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
          </ul> -->
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div class="row">
              <div class="col-md-8"> <h1>My Groups</h1></div>
              <div class="col-md-4"><a class="btn btn-info btn-raised" style="float: right;" data-toggle="modal" data-dismiss="modal" data-target="#CreateG">Create Group</a></div>
            </div>


          <div class="row placeholders panel panel-primary" >
              <div class="panel-heading" style="margin-bottom:20px;">Groups</div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="100" height="100" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="100" height="100" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="100" height="100" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="100" height="100" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
          </div>

          <!-- <h2 class="sub-header">Section title</h2> -->
        </div>
      </div>



        <div id="CreateG" class="modal fade" role="dialog">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="btn" class="close" data-dismiss="modal">&times;</button>
                          <h1 class="modal-title" style="font-size:25px;">Create Group</h1>
                      </div>
                      <div class="modal-body">
                          <!-- action="open.php" -->
                          <form method="post" action="#" name="groupCreation">

                              <input id="group_input_name" class="group_input form-control" placeholder="Group Name" type="text" pattern="[a-zA-Z0-9]{2,64}" name="first_name" style="margin: 10px 0px 0px;" required />
                              <input id="group_input_description" class="group_input form-control" placeholder="Description" type="text" pattern="[a-zA-Z0-9]{2,64}" name="last_name" style="margin: 10px 0px 0px;" required />
                              <input id="group_input_email" class="group_input form-control" placeholder="Email" type="email" name="user_email" style="margin-bottom: 10px;" required />

                              <label for="groupDescription" class="control-label">Group's Description</label>
                              <textarea class="form-control" rows="2" id="group_description"></textarea>
                              <span class="help-block">Describe your group, so other may know the purpose of your group.</span>

                              <input class="btn btn-lg btn-success btn-block" placeholder="Description" type="submit"  name="createGroupe" value="createGroup" />

                          </form>
                      </div>
                      <div class="modal-footer" style="text-align:center;">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      </div>
                  </div>
              </div>
          </div>



      <!-- <footer class="footer">
          <div class="container">
              <p class="text-muted">Place footer content here.</p>
          </div>
      </footer> -->

    </div>






    <!-- <script src="//code.jquery.com/jquery-1.11.3.min.js"></script> -->
    <!-- <script type="text/javascript" src="/js/jquery.js"></script> -->
    <script type="text/javascript" src="/js/bootstrap.js"></script>
    <script type="text/javascript" src="/js/material.js"></script>
    <script type="text/javascript" src="/js/ripples.js"></script>
    <script type="text/javascript" src="/js/modernizr.js"></script>
    <script>$.material.init()</script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
</body>
</html>
