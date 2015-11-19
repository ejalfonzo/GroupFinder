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
           window.location.href = "/Views/Business/manager.php";
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
            <li><a href="/Views/Friends/manager.php">Friends</a></li>
            <li><a href="/Views/Groups/manager.php">Groups</a></li>
            <li><a href="/Views/Events/manager.php">Events</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li class="active"><a href="/Views/Business/manager.php">Buisness</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

          <div class="row">

            <?php 
                $results = $business->getBusiness(); 

                echo '<div class="col-md-8"> <h1>'.$results.'</h1></div>';
                ?>
              <div class="col-md-4"><a class="btn btn-info btn-raised" style="float: right;" data-toggle="modal" data-dismiss="modal" data-target="#EditB">Edit Business</a></div>
            </div>

            <div class="row placeholders panel panel-primary" style="margin-top:15px;margin:20px 0px;width: 30xp">
                <?php 
                $businessDetails = $business->getBusinessDetails(); 

                $hasB = false;
                  echo("<script>console.log('results_row: ".json_encode($businessDetails)."');</script>");
                  if($businessDetails->num_rows >= 1){
                    $hasB = true;
                  }
                  if ($hasB) {
                      while($row = $businessDetails->fetch_object()) {
                        echo("<script>console.log('PHP: getBusinessDetails ".json_encode($row)."');</script>");

                        echo '<h3 style="text-align:left;margin-left: 1em;"> Coordinator:</h3>';
                        echo '<h4 style="text-align:left; padding-left:35px;margin-left: 1em;"> '.$row->first_name ." ".$row->last_name.'</h4>';
                        echo '<h3 style="text-align:left;margin-left: 1em;"> Category:</h3>';
                        if(isset($row->category)){
                          echo '<h4 style="text-align:left; padding-left:35px;margin-left: 1em;"> '.$row->category.'</h4>';
                        }
                        echo '<h3 style="text-align:left;margin-left: 1em;"> Description:</h3>';
                        if(isset($row->address)){
                          echo '<h4 style="text-align:left; padding-left:35px;margin-left: 1em;"> '.$row->address.'</h4>';
                        }else{
                          echo '<h4 style="text-align:left; padding-left:35px;margin-left: 1em;"> No Address </h4>';
                                }
                        if(isset($row->opHours)){
                          echo '<h4 style="text-align:left; padding-left:35px;margin-left: 1em;margin-bottom: 1em;"> '.$row->opHours.'</h4>';
                         }else{
                          echo '<h4 style="text-align:left; padding-left:35px;margin-left: 1em;margin-bottom: 1em;"> No Operational Hours </h4>';
                        }
                     }
                 }
                ?>
                <div class="panel-footer">
               <a href="" class="btn btn-flat btn-warning" data-toggle="modal" data-dismiss="modal" data-target="#UnfollowB">Unfollow Business</a>
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

      <!-- Unfollow Business Modal -->
      <div id="UnfollowB" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="btn" class="close" data-dismiss="modal">&times;</button>
                        <h1 class="modal-title" style="font-size:25px;">Are you sure you want to unfollow:</h1>
                    </div>
                    <div class="modal-body">
                      <div class="portrait" style="margin:15px 250px 0px;">
                        <?php 
                        $results = $business->getBusiness(); 
                        echo '<div class="col-md-8"> <h3>'.$results.'</h3></div>';
                        ?>
                      </div>
                    </div>
                    <div class="modal-footer" style="text-align:center;">
                      <button type="button" class="btn btn-warning" onclick="unfollowBusiness(<?php echo($_GET["business"]); ?>)">Unfollow</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Business Modal -->
        <div id="EditB" class="modal fade" role="dialog">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="btn" class="close" data-dismiss="modal">&times;</button>
                          <h1 class="modal-title" style="font-size:25px;">Edit Business</h1>
                      </div>
                      <div class="modal-body">
                          <!-- action="open.php" -->
                          <form method="post" action="" name="editBusiness">
                            <?php
                            $businessName = $business->getBusiness();
                            $businessDetailsEdit = $business->getBusinessDetails();

                            $hasB = false;
                            echo("<script>console.log('results_row editBusiness: ".json_encode($businessDetailsEdit)."');</script>");
                            if($businessDetailsEdit->num_rows >= 1){
                              echo("<script>console.log('has row');</script>");
                              $hasB = true;
                            }
                            if ($hasB) {
                                  $row = $businessDetailsEdit->fetch_object();
                                  $categories = $business->getBusinessCategories();

                                  echo '<input id="business_name" class="business_input form-control" value='.$businessName.' placeholder="Business Name" type="text" pattern="[a-zA-Z0-9]{2,64}" name="business_name" style="margin: 10px 0px 0px;" required />';

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


                                  //Address
                                  if(isset($row->address)){
                                    echo '<textarea class="form-control floating-label" placeholder="Business Address" rows="2" id="address" name="address" style="margin: 20px 0px 0px;">'.$row->address.'</textarea>';
                                  }else{
                                    echo '<textarea class="form-control floating-label" placeholder="Business Address" rows="2" id="address" name="address" style="margin: 20px 0px 0px;"></textarea>';
                                  }
                                  echo '<span class="help-block">Describe the business address, so others may know the location of your business.</span>';

                                  //OpHours
                                  if(isset($row->opHours)){
                                    echo '<textarea class="form-control floating-label" placeholder="Business Operational Hours" rows="2" id="opHours" name="opHours" style="margin: 20px 0px 0px;">'.$row->opHours.'</textarea>';
                                   }else{
                                    echo '<textarea class="form-control floating-label" placeholder="Business Operational Hours" rows="2" id="opHours" name="opHours" style="margin: 20px 0px 0px;"></textarea>';
                                  }    
                                  echo '<span class="help-block">State the business operational hours, so others may know when and where your business operates.</span>';
                  
                            }
                            ?>
                            <input class="btn btn-lg btn-success btn-block" placeholder="Description" type="submit"  name="editBusiness" value="Edit Business" />

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
