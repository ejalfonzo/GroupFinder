<?php
if ($_SESSION['user_login_status'] != 1) { session_start(); }
// include the configs / constants for the database connection
// require_once("config/db.php");
echo("<script>console.log('PHP: ".json_encode($_SESSION)."');</script>");
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
                <li><a href="#">Profile</a></li>
                <li><a href="#">Friends</a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li><a href="/Views/Groups/manager.php">Groups</a></li>
                <li><a href="#">Events</a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li><a href="">Buisness</a></li>
            </ul>
        </div>
        <!-- Body Content -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1>Dashboard</h1>

          <div class="row placeholders panel panel-primary" >
            <!-- <div class="" style="margin-bottom:20px;"></div> -->
            <div class="col-xs-6 col-sm-3 placeholder" style="margin:40px 0px; border-right: solid 2px gainsboro;">
              <button class="btn btn-flat btn-primary" style="padding: 3px;border-radius: 50%;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Profile">
                <img <?php echo('src="'); $user->getUserImage(); echo('"'); ?> width="100" height="100" class="img-responsive" alt="Generic placeholder thumbnail">
              </button>
              <h4><?php $user->getUserFirstName(); echo(" "); $user->getUserLastName(); ?></h4>
              <span class="text-muted"><?php $_SESSION["email"]; ?></span>
            </div>
            <div class="col-xs-18 col-sm-9 placeholder">
              <h3 style="text-align:left;">Upcoming Events</h3>
                  <?php
                    $table = $user->getUpcomingEventsTable();
                    if ($table) {
                      echo '<div class="table-responsive panel">
                        <table class="table table-striped table-hover">';
                      echo '<thead>
                        <tr>
                          <th>Event Name</th>
                          <th>Coordinator</th>
                          <th>Date</th>
                          <th>Place</th>
                        </tr>
                      </thead>';
                      while($row = $table->fetch_object()) {
                        $date = date_create($row->time);
                        // echo("<script>console.log('results_row: ".json_encode($row)."');</script>");
                        echo '<tr>';
                          echo   '<td>'. $row->name . '</td>';
                          echo   '<td>'. $row->first_name . ' ' . $row->last_name . '</td>';
                          echo   '<td>'. date_format($date, 'F j, Y, g:i a') . '</td>';
                          echo   '<td>'. $row->place . '</td>';
                        echo '</tr>';
                     }
                     echo'</table>
                     </div>';
                   }else{
                     echo '<h3 class="text-muted" style="margin-top:75px";>You Have No Upcoming Events...</h3>';
                   }
                   ?>
            </div>
          </div>

          <div class="row placeholders panel panel-primary" >
              <div class="panel-heading" style="margin-bottom:20px; text-align: left; font-size: 20px;">Your Groups</div>
                <?php
                    $groups = $user->getUserGroups();
                    // echo("<script>console.log('results_row: ".json_encode($groups)."');</script>");
                    echo'<div class="panel-body">';
                    $r = false;
                    if($groups->num_rows >= 1){
                        $r = true;
                    }
                    if($r){
                          while($row2 = $groups->fetch_object()) {
                            // echo("<script>console.log('results_row: ".json_encode($row2)."');</script>");
                            echo '<div class="col-xs-6 col-sm-3 placeholder" style="margin-bottom:0px;">';
                              echo '<button onclick="location.href = '."'"."/Views/Groups/open.php?group=".$row2->id_group."'".';" class="btn btn-flat btn-primary" style="padding: 3px;border-radius: 50%;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Profile">';
                              echo   '<img src="/images/stock/members.png" width="100" height="100" class="img-responsive" alt="Generic placeholder thumbnail">';
                              echo '</button>';
                              echo   '<h4>'. $row2->name . '</h4>';
                              echo   '<span class="text-muted">'. $row2->description . '</span>';
                            echo '</div>';
                         }
                    }else {
                     echo '<h3 class="text-muted" style="margin-top:75px";>You Have No Groups...</h3>';
                   }
                   echo '</div>';
                ?>
              <div class="panel-footer"> <a href="/Views/Groups/manager.php" class="btn btn-flat btn-primary">See All</a></div>

          </div>

          <div class="row panel panel-primary" >
            <div class="panel-heading" style="text-align: left; font-size: 20px;">Your Events</div>
            <?php
                $users = $user->getAllEventsTable();
                if ($users->num_rows >= 1) {
                  echo '<div class="table-responsive panel">
                    <table class="table table-striped table-hover">';
                    echo '<thead>
                      <tr>
                        <th>Event Name</th>
                        <th>Coordinator</th>
                        <th>Date</th>
                        <th>Place</th>
                        <th>Description</th>
                      </tr>
                    </thead>';
                    while($row = $users->fetch_object()) {
                      $date = date_create($row->time);
                      echo("<script>console.log('results_row: ".json_encode($row)."');</script>");
                      echo '<tr>';
                        echo   '<td>'. $row->name . '</td>';
                        echo   '<td>'. $row->first_name . ' ' . $row->last_name . '</td>';
                        echo   '<td>'. date_format($date, 'F j, Y, g:i a') . '</td>';
                        echo   '<td>'. $row->place . '</td>';
                        echo   '<td>'. $row->description . '</td>';
                      echo '</tr>';
                   }
                 echo'</table>
                 </div>';
               }else{
                 echo '<h3 class="text-muted" style="margin-top:75px";>You Have No Upcoming Events...</h3>';
               }
            ?>
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
