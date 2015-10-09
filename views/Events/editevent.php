<!DOCTYPE html>
<html >
  <head>
    <title>GroupFinder Edit Event A</title>
    <meta charset="UTF-8">
    <link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
    <link rel="stylesheet" href="../../css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <style type="text/css">
      .floatbox {float:left; width:110px; height:100px; margin-right:10px;}
      .floatbox img {display:block;}
    </style>

  </head>
  <body>
    <?php 
     $path = $_SERVER['DOCUMENT_ROOT']; 
     $path .= "/Views/General/navbar.php"; 
     include_once($path); 
    ?> 

    <div class="container">

      <div class="row row-offcanvas row-offcanvas-left">
      <!-- sidebar -->
        <div class="col-xs-0 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <ul class="nav">
              <li><a href="#">Timeline</a></li>
              <li><a href="#">Friends</a></li>   
              <li><a href="#">Groups</a></li>              
              <li><a href="#">Events</a></li>
              <li><a href="#">Business</a></li>              
            </ul>
        </div>


        <!-- Content -->
          <div class="col-xs-12 col-sm-9">
            <div class="page-header">
                <h1 id="timeline">Edit Event A</h1>
                <!-- Event Info-->
                <div class="container">
                    <div class="floatbox">
                    <a href="#0">
                      <img src="../../images/profilepic.jpg" alt="Profile Pic" style="width:110px;height:100px">
                    </a>
                    </div>
                  </div>
                  <button>Select Photo</button>
                <form role="form">
                  <div class="form-group">
                    <label for="eventName">Name</label>
                    <input class="form-control" id="eventName" type="text" style="width:40%" />
                  </div>
                  <div class="form-group">
                   <label for="eventCategory">Category</label>
                    <input class="form-control" id="eventCategory" type="text" style="width:40%" />
                  </div>
                  <div class="form-group">
                   <label for="eventLocation">Location</label>
                    <input class="form-control" id="eventLocation" type="text" style="width:40%" />
                  </div>
                  <div class="form-group">
                   <label for="eventTime">Time</label>
                    <input class="form-control" id="eventTime" type="text" style="width:40%" />
                  </div>
                </form>

                <!-- Save, Cancel or Delete -->
                <p></p>
                <button type="submit" class="btn btn-default">Save</button>
                <button type="submit" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-default">Delete</button>
            </div>
         </div>
        </div>
      </div>
    </div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  </body>
</html>
