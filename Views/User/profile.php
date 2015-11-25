<?php
if ($_SESSION['user_login_status'] != 1) { session_start(); }
// include the configs / constants for the database connection
// require_once("config/db.php");
// echo("<script>console.log('PHP: ".json_encode($_SESSION)."');</script>");
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

require_once("../../config/db.php");
require_once("User.php");
$user = new User();

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
    <script>
    function getUser(){
      var userID = '<?php echo $_SESSION["id"]; ?>';
      console.log("getUser?");
       $.ajax({
         type:"post",
         url:"handler.php",
         data:"getUser="+userID,
         success:function(data){
           console.log("User Result",data);
           var obj = JSON.parse(data);
           console.log("User: ", obj);
          //  createPostElement(obj);
         }
       });
     }


    function editProfile(){
      var userID = '<?php echo $_SESSION["id"]; ?>';
      var newProfile = {};
      newProfile.userName = $('#userName').val();
      newProfile.firstName = $('#firstName').val();
      newProfile.lastName = $('#lastName').val();
      newProfile.email = $('#userEmail').val()
      if($('#userImage').val()){
        newProfile.userImage = $('#userImage').val()
      }

      if( $('#passwordMain').val() && $('#passwordMain').val() == $('#passwordCheck').val()){
        newProfile.password = $('#passwordMain').val()
      }else{

      }
      console.log("newProfile",newProfile);
      console.log("editProfile?");
       $.ajax({
         type:"post",
         url:"handler.php",
         data:newProfile,
         success:function(data){
           console.log("Edit Profile Result",data);
           alert('Profile Saved Successfully');
          //  var obj = JSON.parse(data);
           // console.log("Feed: ", obj);
          //  createPostElement(obj);
         }
       });
     }
     $(document).on('click','#editProfile',function(){
       if($('#passwordMain').val() != $('#passwordCheck').val())
         alert('Passwords dont Match');
       else{
         editProfile();
       }
     });

      $(document).ready(function(){
        // getUser();
      });


  	</script>
    <style>
    	.deletePost{
    		cursor:pointer;
    	}
    </style>
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
                <li class="active"><a href="/Views/User/dashboard.php">Overview <span class="sr-only">(current)</span></a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li><a href="/Views/User/profile.php">Profile</a></li>
                <li><a href="/Views/Friends/manager.php">Friends</a></li>
                <li><a href="/Views/Groups/manager.php">Groups</a></li>
                <li><a href="/Views/Events/manager.php">Events</a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li><a href="/Views/Business/manager.php">Buisness</a></li>
            </ul>
        </div>
        <!-- Body Content -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1>Edit Profile</h1>

          <div class="row placeholders panel panel-primary" >
            <h3>Personal info</h3>
            <hr>
              <!-- left column -->
              <div class="col-md-3 placeholder">
                <div class="text-center">
                  <img <?php echo('src="'); $user->getUserImage(); echo('"'); ?> width="100" height="100" class="avatar img-circle" alt="avatar">
                  <!-- <h6>Upload a different photo...</h6>

                  <input id="userImage" type="file" class="form-control"> -->
                </div>
              </div>

              <!-- edit form column -->
              <div class="col-md-9 personal-info">
                <!-- <div class="alert alert-info alert-dismissable">
                  <a class="panel-close close" data-dismiss="alert">×</a>
                  <i class="fa fa-coffee"></i>
                  Passwords <strong>.alert</strong>. Use this to show important messages to the user.
                </div> -->


                <form class="form-horizontal" role="form">
                  <div class="form-group">
                    <label class="col-lg-3 control-label">First name:</label>
                    <div class="col-lg-8">
                      <input id="firstName" class="form-control" type="text" <?php echo('value="'); $user->getUserFirstName(); echo('"'); ?>>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-3 control-label">Last name:</label>
                    <div class="col-lg-8">
                      <input id="lastName" class="form-control" type="text" <?php echo('value="'); $user->getUserLastName(); echo('"'); ?>>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-3 control-label">Email:</label>
                    <div class="col-lg-8">
                      <input id="userEmail" class="form-control" type="text" <?php echo('value="'); echo($_SESSION["email"]); echo('"'); ?>>
                    </div>
                  </div>
                  <!-- <div class="form-group">
                    <label class="col-md-3 control-label">Username:</label>
                    <div class="col-md-8">
                      <input id="userName" class="form-control" type="text" value="janeuser">
                    </div>
                  </div> -->
                  <div class="form-group">
                    <label class="col-md-3 control-label">Password:</label>
                    <div class="col-md-8">
                      <input id="passwordMain" class="form-control" type="password" value="">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Confirm password:</label>
                    <div class="col-md-8">
                      <input id="passwordCheck" class="form-control" type="password" value="">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                      <input id="editProfile" type="button" class="btn btn-primary" value="Save Changes">
                      <span></span>
                      <!-- <input type="reset" class="btn btn-default" value="Cancel"> -->
                    </div>
                  </div>
                </form>
              </div>
          </div>

          	<br>

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
