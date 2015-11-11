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
require_once("../../config/db.php");
require_once("Business.php");
$business = new Business();

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
    <!-- <link rel="stylesheet" type="text/css" href="/css/selectize.css"/> -->
    <!-- <link rel="stylesheet" type="text/css" href="/css/timeline-style.css"/> -->
    <!-- <link rel="stylesheet" type="text/css" href="/css/reset.css"/> -->
    <!-- <link rel="icon" href="/images/logo.ico"> -->
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript">

    function unfollowBusiness(business){

       $.ajax({
         type:"post",
         url:"handler.php",
         data:"unfollow="+business,
         success:function(data){
           console.log("Result",data);
           var obj = JSON.parse(data);
           alert(obj);
           console.log("UNFOLLOW BUSINESS: ", obj);
           window.location.href = "/Views/Buisness/manager.php";
           // createElement(obj);
         }
       });
    }
    </script>
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
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

            <div class="row placeholders panel panel-primary" style="margin-top:15px;">
              <!-- <div class="" style="margin-bottom:20px;"></div> -->
              <div class="col-xs-6 col-sm-3 placeholder" style="margin:40px 0px; border-right: solid 2px gainsboro;">
                <?php $results = $business->getBusiness(); ?>
              </div>
              <div class="col-xs-18 col-sm-9 placeholder" style="padding:25px;">
                <?php 
                $businessDetails = $business->getBusinessDetails(); 

                $hasB = false;
                  echo("<script>console.log('results_row: ".json_encode($businessDetails)."');</script>");
                  if($businessDetails->num_rows >= 1){
                    $hasB = true;
                  }
                  if ($hasB) {
                      while($row = $businessDetails->fetch_object()) {
                        echo("<script>console.log('PHP: getEventDetails ".json_encode($row)."');</script>");

                        echo '<h3 style="text-align:left;">Coordinator:</h3>';
                        echo '<h4 style="text-align:left; padding-left:35px;">'.$row->first_name ." ".$row->last_name.'</h4>';
                        echo '<h3 style="text-align:left;">Description:</h3>';
                        if(isset($row->address)){
                          echo '<h4 style="text-align:left; padding-left:35px;">'.$row->address.'</h4>';
                        }else{
                          echo '<h4 style="text-align:left; padding-left:35px;"> No Address </h4>';
                                }
                        if(isset($row->opHours)){
                          echo '<h4 style="text-align:left; padding-left:35px;">'.$row->opHours.'</h4>';
                         }else{
                          echo '<h4 style="text-align:left; padding-left:35px;"> No Operational Hours </h4>';
                        }
                     }
                 }
                ?>
              </div>
            </div>

            <div class="row panel panel-primary" >
              <div class="panel-heading" style="text-align: left; font-size: 20px;">Followers</div>
              <?php 
              $followers = $business->getFollowersTable(); 
              $hasFs = true;
              echo("<script>console.log('results_row: ".json_encode($followers)."');</script>");
                if($followers->num_rows >= 1){
                  $hasFs = true;
                }
                if ($hasFs) {
                  echo '<div class="table-responsive panel">
                    <table class="table table-striped table-hover">';
                    echo '<thead>
                      <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                      </tr>
                    </thead>';
                    while($row = $followers->fetch_object()) {
                      $date = date_create($row->time);

                      echo '<tr>';
                        echo   '<td><img src="'.$row->user_image.'" alt="" style="width:40px; height:auto;"></td>';
                        echo   '<td>'. $row->first_name . ' ' . $row->last_name . '</td>';
                        echo   '<td>'. $row->email . '</td>';
                      echo '</tr>';
                   }
                 echo'</table>
                 </div>';
               }else if($followers != null){
                 echo '<h3 class="text-muted" style="margin-top:75px";>Business Has No Followers...</h3>';
               }                       
              ?>
            </div>

          <!-- <h2 class="sub-header">Section title</h2> -->
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
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
</body>
</html>
