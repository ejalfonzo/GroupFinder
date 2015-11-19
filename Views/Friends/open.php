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
require_once("Friends.php");
$friends = new Friends();

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

  	function removeFriend(friend){

  	   $.ajax({
  		   type:"post",
  		   url:"handler.php",
  		   data:"removeFriend="+friend,
  		   success:function(data){
  			   console.log("Result",data);
  			   var obj = JSON.parse(data);
  			   alert(obj);
  			   console.log("REMOVE FRIEND: ", obj);
           window.location.href = "/Views/Friends/manager.php";
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
            <li class="active"><a href="/Views/Friends/manager.php">Friends</a></li>
            <li><a href="/Views/Groups/manager.php">Groups</a></li>
            <li><a href="/Views/Events/manager.php">Events</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="/Views/Business/manager.php">Buisness</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

          <div class="row">
              <div class="col-md-12"><a class="btn btn-info btn-raised" style="float: right;" data-toggle="modal" data-dismiss="modal" data-target="#EditF">Edit Friend</a></div>
            </div>

            <div class="row placeholders panel panel-primary" style="margin-top:15px;">
              <!-- <div class="" style="margin-bottom:20px;"></div> -->
              <div class="panel-body">
              <div class="col-xs-6 col-sm-3 placeholder" style="margin:40px 0px; border-right: solid 2px gainsboro;">
                  <?php
                  $userFriends = $friends->getFriend();
                  $hasF = false;
                  echo("<script>console.log('getFriend: ".json_encode($userFriends)."');</script>");
                  if($userFriends->num_rows >= 1){
                    $hasF = true;
                  }
                  if ($hasF) {
                      while($row = $userFriends->fetch_object()) {
                          echo '<img src=" '. $row->user_image .' " width="100" height="100" class="img-responsive" alt="Generic placeholder thumbnail">';
                          echo '<h4>'.$row->user_name.'</h4>';
                          echo '<h4>'.$row->email.'</h4>';
                     }
                 }else if($userFriends != null){
                   echo '<h3 class="text-muted" style="margin-top:75px";>User has no Friends...</h3>';
                 }

                   ?>

              </div>
              <div class="col-xs-18 col-sm-9 placeholder" style="padding:25px;">
                  <?php
                  $userFriends = $friends->getFriendDetails();
                  $hasF = false;
                  echo("<script>console.log('getFriend: ".json_encode($userFriends)."');</script>");
                  if($userFriends->num_rows >= 1){
                    $hasF = true;
                  }
                  if ($hasF) {
                      while($row = $userFriends->fetch_object()) {
                          echo '<h3 style="text-align:left;">Friend:</h3>';
                          echo '<h4 style="text-align:left; padding-left:35px;">'.$row->first_name ." ".$row->last_name.'</h4>';
                          echo '<h3 style="text-align:left;">Email:</h3>';
                          if(isset($row->email)){
                            echo '<h4 style="text-align:left; padding-left:35px;">'.$row->email.'</h4>';
                          }else{
                            echo '<h4 style="text-align:left; padding-left:35px;"> No Email </h4>';
                          }
                          echo '<h3 style="text-align:left;">Category:</h3>';
                          if(isset($row->category)){
                            echo '<h4 style="text-align:left; padding-left:35px;">'.$row->category.'</h4>';
                          }else{
                            echo '<h4 style="text-align:left; padding-left:35px;"> No Category </h4>';
                          }
                     }
                 }else if($userFriends != null){
                   echo '<h3 class="text-muted" style="margin-top:75px";>User has no Friends...</h3>';
                 }

                  ?>
              </div>
            </div>

             <div class="panel-footer">
               <a href="" class="btn btn-flat btn-warning" data-toggle="modal" data-dismiss="modal" data-target="#RemoveF">Remove Friend</a>
             </div>
            </div>

            <div class="row panel panel-primary" >
              <div class="panel-heading" style="text-align: left; font-size: 20px;">Friends Businesses, Groups and Events </div>
              <?php
                $userFriends = $friends->getFriendsTable();
                $hasF = false;
                echo("<script>console.log('results_row: ".json_encode($userFriends)."');</script>");
                if($userFriends->num_rows >= 1){
                  $hasF = true;
                }
                if ($hasF) {
                  echo '<div class="table-responsive panel">
                    <table class="table table-striped table-hover">';
                    echo '<thead>
                      <tr>
                        <th>Image</th>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Category</th>
                      </tr>
                    </thead>';
                    while($row = $userFriends->fetch_object()) {
                        echo("<script>console.log('results_row: ".json_encode($row)."');</script>");
                      echo '<tr>';
                        echo   '<td><img src="'.$row->image.'" alt="" style="width:40px; height:auto;"></td>';
                        echo   '<td>'. $row->type . '</td>';
                        echo   '<td>'. $row->name . '</td>';
                        echo   '<td>'. $row->category . '</td>';
                      echo '</tr>';
                   }
                 echo'</table>
                 </div>';
               }else if($userFriends != null){
                 echo '<h3 class="text-muted" style="margin-top:75px";>User has no Friends...</h3>';
               }
              ?>
            </div>

          <!-- <h2 class="sub-header">Section title</h2> -->
        </div>
      </div>

      <!-- Remove Friend Modal -->
      <div id="RemoveF" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="btn" class="close" data-dismiss="modal">&times;</button>
                        <h1 class="modal-title" style="font-size:25px;">Are you sure you want to remove Friend:</h1>
                    </div>
                    <div class="modal-body">
                      <div class="portrait" style="margin:15px 250px 0px;">
                        <?php 
                        $userFriends = $friends->getFriend();
                        $name = $userFriends->fetch_object();
                        echo("<script>console.log('results_row Get Friend ID: ".$_GET["friend"]."')</script>");
                        echo '<h3>'.$name->user_name.'</h3>';
                        ?>
                      </div>
                    </div>
                    <div class="modal-footer" style="text-align:center;">
                      <button type="button" class="btn btn-warning" onclick="removeFriend(<?php echo($_GET["friend"]); ?>)">Remove</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Don't Remove</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Friend Modal -->
        <div id="EditF" class="modal fade" role="dialog">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="btn" class="close" data-dismiss="modal">&times;</button>
                          <h1 class="modal-title" style="font-size:25px;">Edit Business</h1>
                      </div>
                      <div class="modal-body">
                          <!-- action="open.php" -->
                          <h3> Select Friend Category</h3>
                          <form method="post" action="" name="editFriend">
                            <?php
                            $friendDetails = $friends->getFriendDetails();

                            $hasF = false;
                            echo("<script>console.log('results_row editFriend: ".json_encode($friendDetails)."');</script>");
                            if($friendDetails->num_rows >= 1){
                              echo("<script>console.log('has row');</script>");
                              $hasF = true;
                            }
                            if ($hasF) {
                                  $row = $friendDetails->fetch_object();
                                  $categories = $friends->getFriendCategories();

                                  //Category
                                  echo '<div class="dropdownjs" style="margin: 10px 0px 0px;">
                                   <div class="control-business">
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
                            }
                            ?>
                            <input class="btn btn-lg btn-success btn-block" placeholder="Description" type="submit"  name="editFriend" value="Edit Friend" />

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
    <script>
    $.material.init();
    </script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
</body>
</html>
