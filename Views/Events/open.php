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
require_once("Events.php");
$events = new Events();

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

    function leaveEvent(events){

       $.ajax({
         type:"post",
         url:"handler.php",
         data:"leaveEvent="+events,
         success:function(data){
           console.log("Result",data);
           var obj = JSON.parse(data);
           alert(obj);
           console.log("LEAVE EVENT: ", obj);
           window.location.href = "/Views/Events/manager.php";
         }
       });
    }

    function deleteEvent(events){

       $.ajax({
         type:"post",
         url:"handler.php",
         data:"delete="+events,
         success:function(data){
           console.log("Result",data);
           var obj = JSON.parse(data);
           alert(obj);
           console.log("DELETE EVENT: ", obj);
           window.location.href = "/Views/Events/manager.php";
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
            <li><a href="/Views/User/profile.php">Profile</a></li>
            <li><a href="/Views/Friends/manager.php">Friends</a></li>
            <li><a href="/Views/Groups/manager.php">Groups</a></li>
            <li class="active"><a href="/Views/Events/manager.php">Events</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="/Views/Business/manager.php">Buisness</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <?php
          $results = $events->getEvent();

          // Edit only for admin
          $adminCheck = $events->isAdmin();

          echo("<script>console.log('isAdmin: ".json_encode($adminCheck)."');</script>");
          if ($adminCheck) {
            echo '<div class="row">';
            echo '<div class="col-md-12"><a class="btn btn-info btn-raised" style="float: right;" data-toggle="modal" data-dismiss="modal" data-target="#EditE">Edit Event</a></div>';
            echo '</div>';
           }
          ?>
          
            <div class="row placeholders panel panel-primary" style="margin-top:15px;">
              <div class="panel-body">
              <!-- <div class="" style="margin-bottom:20px;"></div> -->
              <div class="col-xs-6 col-sm-3 placeholder" style="margin:40px 0px; border-right: solid 2px gainsboro;">
                <?php 
                $results = $events->getEvent(); 

                echo '<img src=" '. $results->event_image .' " width="100" height="100" class="img-responsive" alt="Generic placeholder thumbnail">';
                echo '<div class="col-md-8"> <h1>'.$results->name.'</h1></div>';
                ?>
              </div>
              <div class="col-xs-18 col-sm-9 placeholder" style="padding:25px;">
                <?php
                  $eventDetails = $events->getEventDetails();
                  $hasE = false;
                  echo("<script>console.log('results_row: ".json_encode($eventDetails)."');</script>");
                  if($eventDetails->num_rows >= 1){
                    $hasE = true;
                  }
                  if ($hasE) {
                      while($row = $eventDetails->fetch_object()) {
                        echo("<script>console.log('PHP: getEventDetails ".json_encode($row)."');</script>");

                        echo '<h3 style="text-align:left;">Coordinator:</h3>';
                        echo '<h4 style="text-align:left; padding-left:35px;">'.$row->first_name ." ".$row->last_name.'</h4>';
                        echo '<h3 style="text-align:left;">Place:</h3>';
                        if(isset($row->place)){
                          echo '<h4 style="text-align:left; padding-left:35px;">'.$row->place.'</h4>';
                        }else{
                          echo '<h4 style="text-align:left; padding-left:35px;"> No Place </h4>';
                        }
                        echo '<h3 style="text-align:left;">Description:</h3>';
                        if(isset($row->description)){
                          echo '<h4 style="text-align:left; padding-left:35px;">'.$row->description.'</h4>';
                        }else{
                          echo '<h4 style="text-align:left; padding-left:35px;"> No Description </h4>';
                        }
                        echo '<h3 style="text-align:left;">Category:</h3>';
                        if(isset($row->category)){
                          echo '<h4 style="text-align:left; padding-left:35px;">'.$row->category.'</h4>';
                        }else{
                          echo '<h4 style="text-align:left; padding-left:35px;"> No Category </h4>';
                        }
                        echo '<h3 style="text-align:left;">Time:</h3>';
                         if(isset($row->time)){
                          echo '<h4 style="text-align:left; padding-left:35px;">'.$row->time.'</h4>';
                        }else{
                          echo '<h4 style="text-align:left; padding-left:35px;"> No Time </h4>';
                        }
                     }
                 }
                 echo '</div>';
                 echo '</div>';

                 $adminCheck = $events->isAdmin();
                 echo("<script>console.log('isAdmin: ".json_encode($adminCheck)."');</script>");
                 if (!$adminCheck) {
                  echo '<div class="panel-footer">';
                  echo '<a href="" class="btn btn-flat btn-warning" data-toggle="modal" data-dismiss="modal" data-target="#LeaveE">Leave Event</a>';
                  echo '</div> ';
                 }

                ?>
             </div>

            <div class="row panel panel-primary" >
              <div class="panel-heading" style="text-align: left; font-size: 20px;">Members</div>

              <?php
                $eventMembers = $events->getEventMembersTable();
                $hasE = false;
                echo("<script>console.log('results_row: ".json_encode($eventMembers)."');</script>");
                if($eventMembers->num_rows >= 1){
                  $hasE = true;
                }
                if ($hasE) {
                  echo '<div class="table-responsive panel">
                    <table class="table table-striped table-hover">';
                    echo '<thead>
                      <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                      </tr>
                    </thead>';
                    while($row = $eventMembers->fetch_object()) {
                      $date = date_create($row->time);


                      echo '<tr>';
                        echo   '<td><img src="'.$row->user_image.'" alt="" style="width:40px; height:auto;"></td>';
                        echo   '<td>'. $row->first_name . ' ' . $row->last_name . '</td>';
                        echo   '<td>'. $row->email . '</td>';
                      echo '</tr>';
                   }
                 echo'</table>
                 </div>';
               }else if($eventMembers != null){
                 echo '<h3 class="text-muted" style="margin-top:75px";>Group Has No Members...</h3>';
               }
              ?>

            </div>

          <!-- <h2 class="sub-header">Section title</h2> -->
        </div>
      </div>


      <!-- Leave Event Modal -->
      <div id="LeaveE" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="btn" class="close" data-dismiss="modal">&times;</button>
                        <h1 class="modal-title" style="font-size:25px;">Are you sure you want to leave:</h1>
                    </div>
                    <div class="modal-body">
                      <div class="portrait" style="margin:15px 250px 0px;">
                        <?php 
                        $results = $events->getEvent(); 
                        echo '<div class="col-md-8"> <h3>'.$results->name.'</h3></div>';
                        ?>
                      </div>
                    </div>
                    <div class="modal-footer" style="text-align:center;">
                      <button type="button" class="btn btn-warning" onclick="leaveEvent(<?php echo($_GET["event"]); ?>)">Leave</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Edit Event Modal -->
        <div id="EditE" class="modal fade" role="dialog">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="btn" class="close" data-dismiss="modal">&times;</button>
                          <h1 class="modal-title" style="font-size:25px;">Edit Event</h1>
                      </div>
                      <div class="modal-body">
                          <form method="post" action="" name="editEvent">
                            <?php
                            $eventName = $events->getEvent()->name;
                            $eventDetailsEdit = $events->getEventDetails();

                            $hasB = false;
                            //echo("<script>console.log('results_row editEvent: ".json_encode($eventDetailsEdit)."');</script>");
                            if($eventDetailsEdit->num_rows >= 1){
                              echo("<script>console.log('has row');</script>");
                              $hasB = true;
                            }
                            if(hasB) {
                                  $row = $eventDetailsEdit->fetch_object();
                                  echo("<script>console.log('results_row editEvent: ".$eventName."');</script>");
                                  $categories = $events->getEventCategories();
                                  //echo("<script>console.log('results_row editEvent: ".json_encode($categories->fetch_object())."');</script>");
                                  echo '<input id="event_name" class="event_input form-control" value="'.$eventName.'" placeholder="Event Name" type="text" pattern="[a-zA-Z0-9]{2,64}" name="event_name" style="margin: 10px 0px 0px;" required />';

                                  //Category
                                  echo '<div class="dropdownjs" style="margin: 10px 0px 0px;">
                                   <div class="control-event">
                                      <select class="form-control" placeholder="Select a Category" id="category" name="category">';
                                  if($categories != null){
                                   while($rowCat = $categories->fetch_object()){
                                    if($row->catId == $rowCat->id_category){
                                      echo('<option selected="selected" value="'.$rowCat->id_category.'">'. $rowCat->name . '</option>');
                                      }
                                      else{
                                        echo('<option value="'.$rowCat->id_category.'">'. $rowCat->name . '</option>');
                                      } 
                                    }
                                  }
                                  echo '</select>
                                       </div>
                                     </div>';

                                  //Place
                                  if(isset($row->place)){
                                    echo '<textarea class="form-control floating-label" placeholder="Event Place" rows="2" id="place" name="place" style="margin: 20px 0px 0px;">'.$row->place.'</textarea>';
                                  }else{
                                    echo '<textarea class="form-control floating-label" placeholder="Event Place" rows="2" id="place" name="place" style="margin: 20px 0px 0px;"></textarea>';
                                  }
                                  echo '<span class="help-block">Describe the event place, so other may know the location of your event.</span>';

                                  //Description
                                  if(isset($row->description)){
                                    echo '<textarea class="form-control floating-label" placeholder="Event Description" rows="2" id="description" name="description" style="margin: 20px 0px 0px;">'.$row->description.'</textarea>';
                                   }else{
                                    echo '<textarea class="form-control floating-label" placeholder="Event Description" rows="2" id="description" name="description" style="margin: 20px 0px 0px;"></textarea>';
                                  }    
                                  echo '<span class="help-block">State the event description, so other may know about your event.</span>';
                  
                            }
                            ?>
                            <input class="btn btn-lg btn-success btn-block" placeholder="Description" type="submit"  name="editEvent" value="Edit Event" />

                          </form>
                      </div>
                      <div class="modal-footer" style="text-align:center;">
                        <div class="col-md-4"><a class="btn btn-info btn-raised" style="float: right;background:red" data-toggle="modal" data-dismiss="modal" data-target="#DeleteE">Delete Event</a></div>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      </div>
                  </div>
              </div>
          </div>

      <!-- Delete Event Modal -->
      <div id="DeleteE" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="btn" class="close" data-dismiss="modal">&times;</button>
                        <h1 class="modal-title" style="font-size:25px;">Are you sure you want to delete:</h1>
                    </div>
                    <div class="modal-body">
                      <div class="portrait" style="margin:15px 250px 0px;">
                        <?php 
                        $results = $events->getEvent(); 
                        echo '<div class="col-md-8"> <h3>'.$results->name.'</h3></div>';
                        ?>
                      </div>
                    </div>
                    <div class="modal-footer" style="text-align:center;">
                      <button type="button" class="btn btn-warning" onclick="deleteEvent(<?php echo($_GET["event"]); ?>)">Delete</button>
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
