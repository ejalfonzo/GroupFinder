<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>GroupFinder Group Sample</title>
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


        <!-- Posts -->
          <div class="col-xs-12 col-sm-9">
            <div class="page-header">
              <div class="floatbox">
                  <a href="#0">
                    <img src="../../images/profilepic.jpg" alt="Profile Pic" style="width:110px;height:100px">
                  </a>
              </div>
              <a href="#0"><h1 id="timeline">Group A</h1></a>
              <h3> Group Category: <a href="#0">Category A</a></h3>
              <p>Here is the groups's description</p>
            </div>

            <div class="container" style="display: inline-block;background: lightgreen;width: 400px;">
              <h4>Group A's Members<a href="#0">(See All)</a></h4>
              <div class="floatbox"><a href="#0"><img src="../../images/profilepic.jpg" alt="Profile Pic" style="width:70px;height:60px"><p>User1</p></a></div>
              <div class="floatbox"><a href="#0"><img src="../../images/profilepic.jpg" alt="Profile Pic" style="width:70px;height:60px"><p>User2</p></a></div>
              <div class="floatbox"><a href="#0"><img src="../../images/profilepic.jpg" alt="Profile Pic" style="width:70px;height:60px"><p>User3</p></a></div>   
            </div>
            <div class="container" style="display: inline-block; background: lightblue;width: 400px;">
              <h4>Group A's Events<a href="#0">(See All)</a></h4>
              <div class="floatbox"><a href="#0"><p>Event1</p></a></div>
              <div class="floatbox"><a href="#0"><p>Event2</p></a></div>
              <div class="floatbox"><a href="#0"><p>Event3</p></a></div>   
            </div>
            
            <h1></h1>
            <button type="submit" class="btn btn-default">Create New Event</button>
            <button type="submit" class="btn btn-default">Write a Post</button>
            <button type="submit" class="btn btn-default">Invite</button>            

            <ul class="timeline">
                <li>
                  <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
                  <div class="timeline-panel">
                    <div class="timeline-heading">
                      <h4 class="timeline-title">Post 1</h4>
                      <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 3 hours ago</small></p>
                    </div>
                    <div class="timeline-body">
                      <p>Random stuff</p>
                    </div>
                  </div>
                </li>
                <li class="timeline-inverted">
                  <div class="timeline-badge warning"><i class="glyphicon glyphicon-credit-card"></i></div>
                  <div class="timeline-panel">
                    <div class="timeline-heading">
                      <h4 class="timeline-title">Post 2</h4>
                    </div>
                    <div class="timeline-body">
                      <p>More here...</p>
                      <p>...and here</p>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="timeline-badge danger"><i class="glyphicon glyphicon-credit-card"></i></div>
                  <div class="timeline-panel">
                    <div class="timeline-heading">
                      <h4 class="timeline-title">Post 3</h4>
                    </div>
                    <div class="timeline-body">
                      <p>More stuff</p>
                  </div>
                </li>
                <li class="timeline-inverted">
                  <div class="timeline-panel">
                    <div class="timeline-heading">
                      <h4 class="timeline-title">Post 4</h4>
                    </div>
                    <div class="timeline-body">
                      <p>Nothing here</p>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="timeline-badge info"><i class="glyphicon glyphicon-floppy-disk"></i></div>
                  <div class="timeline-panel">
                    <div class="timeline-heading">
                      <h4 class="timeline-title">Post 5</h4>
                   </div>
                   <div class="timeline-body">
                     <p>More random stuff</p>
                     <hr>
                   </div>
                 </div>
               </li>
               <li>
                 <div class="timeline-badge"><i class="glyphicon glyphicon-wrench"></i></div>
                <div class="timeline-panel">
                 <div class="timeline-panel">
                   <div class="timeline-heading">
                     <h4 class="timeline-title">Post 6</h4>
                   </div>
                   <div class="timeline-body">
                     <p>Nothing more</p>
                   </div>
                 </div>
               </li>
               <li class="timeline-inverted">
                 <div class="timeline-badge success"><i class="glyphicon glyphicon-thumbs-up"></i></div>
                 <div class="timeline-panel">
                   <div class="timeline-heading">
                     <h4 class="timeline-title">Post 7</h4>
                   </div>
                   <div class="timeline-body">
                     <p>Nothing</p>
                   </div>
                 </div>
               </li>
           </ul>
         </div>
        </div>
      </div>
    </div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  </body>
</html>
