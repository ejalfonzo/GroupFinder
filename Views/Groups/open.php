<?php
if ($_SESSION['user_login_status'] != 1) { session_start(); }
// include the configs / constants for the database connection

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
require_once("Groups.php");
$groups = new Groups();

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

  	function leaveGroup(group){

  	   $.ajax({
  		   type:"post",
  		   url:"handler.php",
  		   data:"leave="+group,
  		   success:function(data){
  			   console.log("Result",data);
  			   var obj = JSON.parse(data);
  			   alert(obj);
  			   console.log("LEAVE GROUP: ", obj);
           window.location.href = "/Views/Groups/manager.php";
  			   // createElement(obj);
  		   }
  	   });
  	}

    function deleteGroup(group){

       $.ajax({
         type:"post",
         url:"handler.php",
         data:"delete="+group,
         success:function(data){
           console.log("Result",data);
           var obj = JSON.parse(data);
           alert(obj);
           console.log("DELETE GROUP: ", obj);
           window.location.href = "/Views/Groups/manager.php";
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
            <li><a href="/Views/User/profile.php">Profile</a></li>
            <li><a href="/Views/Friends/manager.php">Friends</a></li>
            <li class="active"><a href="/Views/Groups/manager.php">Groups</a></li>
            <li><a href="/Views/Events/manager.php">Events</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="/Views/Business/manager.php">Buisness</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

          <?php
          $results = $groups->getGroup();

          // Edit only for admin
          $adminCheck = $groups->isAdmin();

          echo("<script>console.log('isAdmin: ".json_encode($adminCheck)."');</script>");
          if ($adminCheck) {
            echo '<div class="row">';
            echo '<div class="col-md-12"><a class="btn btn-info btn-raised" style="float: right;" data-toggle="modal" data-dismiss="modal" data-target="#EditG">Edit Group</a></div>';
            echo '</div>';
           }
          ?>

            <div class="row placeholders panel panel-primary" style="margin-top:15px;">
              <!-- <div class="" style="margin-bottom:20px;"></div> -->
              <div class="panel-body">
              <div class="col-xs-6 col-sm-3 placeholder" style="margin:40px 0px; border-right: solid 2px gainsboro;">
                <?php
                $results = $groups->getGroup();

                echo '<img src=" '. $results->group_image .' " width="100" height="100" class="img-responsive" alt="Generic placeholder thumbnail">';
                echo '<h4>'.$results->name.'</h4>';
                 ?>
              </div>
              <div class="col-xs-18 col-sm-9 placeholder" style="padding:25px;">
                <?php
                $groupsDetails = $groups->getGroupDetails();

                $hasG = false;
                  echo("<script>console.log('results_row: ".json_encode($groupsDetails)."');</script>");
                  if($groupsDetails->num_rows >= 1){
                    $hasG = true;
                  }
                  if ($hasG) {
                      while($row = $groupsDetails->fetch_object()) {
                        echo("<script>console.log('PHP: getGroupDetails ".json_encode($row)."');</script>");

                        echo '<h3 style="text-align:left;margin-left: 1em;"> Coordinator:</h3>';
                        echo '<h4 style="text-align:left; padding-left:35px;margin-left: 1em;"> '.$row->first_name ." ".$row->last_name.'</h4>';
                        echo '<h3 style="text-align:left;margin-left: 1em;"> Category:</h3>';
                        if(isset($row->category)){
                          echo '<h4 style="text-align:left; padding-left:35px;margin-left: 1em;"> '.$row->category.'</h4>';
                        }
                        echo '<h3 style="text-align:left;margin-left: 1em;"> Description:</h3>';
                        if(isset($row->description)){
                          echo '<h4 style="text-align:left; padding-left:35px;margin-left: 1em;"> '.$row->description.'</h4>';
                        }else{
                          echo '<h4 style="text-align:left; padding-left:35px;margin-left: 1em;"> No Description </h4>';
                                }
                     }
                 }

                 echo '</div>';
                 echo '</div>';

                 $adminCheck = $groups->isAdmin();
                 echo("<script>console.log('isAdmin: ".json_encode($adminCheck)."');</script>");
                 if (!$adminCheck) {
                  echo '<div class="panel-footer">';
                  echo '<a href="" class="btn btn-flat btn-warning" data-toggle="modal" data-dismiss="modal" data-target="#LeaveG">Leave Group</a>';
                  echo '</div> ';
                 }

                ?>
            </div>

            <div class="row panel panel-primary" >
              <div class="panel-heading" style="text-align: left; font-size: 20px;">Members</div>
              <?php
                $events = $groups->getGroupMembersTable();
                $hasE = false;
                echo("<script>console.log('results_row: ".json_encode($events)."');</script>");
                if($events->num_rows >= 1){
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
                    while($row = $events->fetch_object()) {
                      $date = date_create($row->time);

                      echo '<tr>';
                        echo   '<td><img src="'.$row->user_image.'" alt="" style="width:40px; height:auto;"></td>';
                        echo   '<td>'. $row->first_name . ' ' . $row->last_name . '</td>';
                        echo   '<td>'. $row->email . '</td>';
                      echo '</tr>';
                   }
                 echo'</table>
                 </div>';
               }else if($events != null){
                 echo '<h3 class="text-muted" style="margin-top:75px";>Group Has No Members...</h3>';
               }
              ?>
            </div>

          <!-- <h2 class="sub-header">Section title</h2> -->
        </div>
      </div>

      <!-- Leave Group Modal -->
      <div id="LeaveG" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="btn" class="close" data-dismiss="modal">&times;</button>
                        <h1 class="modal-title" style="font-size:25px;">Are you sure you want to leave:</h1>
                    </div>
                    <div class="modal-body">
                      <div class="portrait" style="margin:15px 250px 0px;">
                        <?php
                        $results = $groups->getGroup();

                        echo '<h3>'.$results->name.'</h3>';
                        ?>
                      </div>
                    </div>
                    <div class="modal-footer" style="text-align:center;">
                      <button type="button" class="btn btn-warning" onclick="leaveGroup(<?php echo($_GET["group"]); ?>)">Leave</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Stay</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Group Modal -->
        <div id="EditG" class="modal fade" role="dialog">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="btn" class="close" data-dismiss="modal">&times;</button>
                          <h1 class="modal-title" style="font-size:25px;">Edit Group</h1>
                      </div>
                      <div class="modal-body">
                          <!-- action="open.php" -->
                          <form method="post" action="" name="editGroup">
                            <?php
                            $groupName = $groups->getGroup()->name;
                            $groupDetailsEdit = $groups->getGroupDetails();

                            $hasB = false;
                            echo("<script>console.log('results_row editGroup: ".json_encode($groupDetailsEdit)."');</script>");
                            if($groupDetailsEdit->num_rows >= 1){
                              echo("<script>console.log('has row');</script>");
                              $hasB = true;
                            }
                            if ($hasB) {
                                  $row = $groupDetailsEdit->fetch_object();
                                  $categories = $groups->getGroupCategories();

                                  echo '<input id="group_name" class="group_input form-control" value='.$groupName.' placeholder="Group Name" type="text" pattern="[a-zA-Z0-9]{2,64}" name="group_name" style="margin: 10px 0px 0px;" required />';

                                  //Category
                                  echo '<div class="dropdownjs" style="margin: 10px 0px 0px;">
                                   <div class="control-group">
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


                                  //Address
                                  if(isset($row->description)){
                                    echo '<textarea class="form-control floating-label" placeholder="Group Description" rows="2" id="description" name="description" style="margin: 20px 0px 0px;">'.$row->description.'</textarea>';
                                  }else{
                                    echo '<textarea class="form-control floating-label" placeholder="Group Description" rows="2" id="description" name="description" style="margin: 20px 0px 0px;"></textarea>';
                                  }
                                  echo '<span class="help-block">Describe the group, so others may know about your group.</span>';
                            }
                            ?>
                            <input class="btn btn-lg btn-success btn-block" placeholder="Description" type="submit"  name="editGroup" value="Edit Group" />

                          </form>
                      </div>
                      <div class="modal-footer" style="text-align:center;">
                        <div class="col-md-4"><a class="btn btn-info btn-raised" style="float: right;background:red" data-toggle="modal" data-dismiss="modal" data-target="#DeleteG">Delete Group</a></div>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      </div>
                  </div>
              </div>
          </div>

      <!-- Delete Group Modal -->
      <div id="DeleteG" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="btn" class="close" data-dismiss="modal">&times;</button>
                        <h1 class="modal-title" style="font-size:25px;">Are you sure you want to delete:</h1>
                    </div>
                    <div class="modal-body">
                      <div class="portrait" style="margin:15px 250px 0px;">
                        <?php
                        $results = $groups->getGroup();

                        echo '<h3>'.$results->name.'</h3>';
                        ?>
                      </div>
                    </div>
                    <div class="modal-footer" style="text-align:center;">
                      <button type="button" class="btn btn-warning" onclick="deleteGroup(<?php echo($_GET["group"]); ?>)">Delete</button>
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
    <script>
    $.material.init();
    </script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
</body>
</html>
