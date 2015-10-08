<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>GroupFinder Groups</title>
    
    <link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
    <link rel="stylesheet" href="../../css/style.css">
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

        <!-- Table -->
          <div class="col-xs-12 col-sm-9">
            <div class="page-header">
                <h1 id="timeline">Groups</h1>
            </div>

            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>
                          Group Name
                        </th>
                        <th>
                          Category
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="active">
                        <td>
                          <div class="floatbox"><a href="#0"><img src="../../images/profilepic.jpg" alt="Profile Pic" style="width:70px;height:60px"><p>GroupA</p></a></div>
                        </td>
                        <td>
                          <a href="#">CategoryA</a>
                        </td>
                      </tr>
                      <tr class="success">
                        <td>
                          <div class="floatbox"><a href="#0"><img src="../../images/profilepic.jpg" alt="Profile Pic" style="width:70px;height:60px"><p>GroupB</p></a></div>
                        </td>
                        <td>
                          <a href="#">CategoryC</a>
                        </td>
                      </tr>
                      <tr class="warning">
                        <td>
                          <div class="floatbox"><a href="#0"><img src="../../images/profilepic.jpg" alt="Profile Pic" style="width:70px;height:60px"><p>GroupC</p></a></div>
                        </td>
                        <td>
                          <a href="#">CategoryB</a>
                      </tr>
                      <tr class="danger">
                        <td>
                          <div class="floatbox"><a href="#0"><img src="../../images/profilepic.jpg" alt="Profile Pic" style="width:70px;height:60px"><p>GroupD</p></a></div>
                        </td>
                        <td>
                          <a href="#">CategoryC</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div><!-- Table end -->

         </div>
        </div>
      </div>
    </div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  </body>
</html>
