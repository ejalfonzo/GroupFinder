<?php
if (session_id() === "" && $_SESSION['user_login_status'] != 1) { session_start(); }
// include the configs / constants for the database connection
// require_once("config/db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Group Finder Events</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/css/roboto.css"/>
    <link rel="stylesheet" type="text/css" href="/css/material.css"/>
    <link rel="stylesheet" type="text/css" href="/css/ripples.css"/>
    <link rel="stylesheet" type="text/css" href="/css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="/css/timeline-style.css"/>
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
                <h1 id="timeline">Events</h1>
            </div>
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>
                          Event Name
                        </th>
                        <th>
                          Creator
                        </th>
                        <th>
                          Status
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="active">
                        <td>
                          <div class="floatbox"><a href="#0"><img src="../../images/profilepic.jpg" alt="Profile Pic" style="width:70px;height:60px"><p>EventA</p></a></div>
                        </td>
                        <td>
                          <div class="floatbox"><a href="#0"><img src="../../images/profilepic.jpg" alt="Profile Pic" style="width:70px;height:60px"><p>Person1</p></a></div>
                        </td>
                        <td>
                          <select>
                           <option value="pending">Pending</option>
                           <option value="assisting">Assisting</option>
                           <option value="declined">Declined</option>
                          </select>
                        </td>
                      </tr>
                      <tr class="success">
                        <td>
                          <div class="floatbox"><a href="#0"><img src="../../images/profilepic.jpg" alt="Profile Pic" style="width:70px;height:60px"><p>EventB</p></a></div>
                        </td>
                        <td>
                          <div class="floatbox"><a href="#0"><img src="../../images/profilepic.jpg" alt="Profile Pic" style="width:70px;height:60px"><p>Person2</p></a></div>
                        </td>
                        <td>
                          <select>
                           <option value="pending">Pending</option>
                           <option value="assisting">Assisting</option>
                           <option value="declined">Declined</option>
                          </select>
                        </td>
                      </tr>
                      <tr class="warning">
                        <td>
                          <div class="floatbox"><a href="#0"><img src="../../images/profilepic.jpg" alt="Profile Pic" style="width:70px;height:60px"><p>EventC</p></a></div>
                        </td>
                        <td>
                          <div class="floatbox"><a href="#0"><img src="../../images/profilepic.jpg" alt="Profile Pic" style="width:70px;height:60px"><p>Person3</p></a></div>
                        <td>
                          <select>
                           <option value="pending">Pending</option>
                           <option value="assisting">Assisting</option>
                           <option value="declined">Declined</option>
                          </select>
                        </td>
                      </tr>
                      <tr class="danger">
                        <td>
                          <div class="floatbox"><a href="#0"><img src="../../images/profilepic.jpg" alt="Profile Pic" style="width:70px;height:60px"><p>EventD</p></a></div>
                        </td>
                        <td>
                          <div class="floatbox"><a href="#0"><img src="../../images/profilepic.jpg" alt="Profile Pic" style="width:70px;height:60px"><p>Person4</p></a></div>
                        </td>
                        <td>
                          <select>
                           <option value="pending">Pending</option>
                           <option value="assisting">Assisting</option>
                           <option value="declined">Declined</option>
                          </select>
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

    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/bootstrap.js"></script>
    <script type="text/javascript" src="/js/material.js"></script>
    <script type="text/javascript" src="/js/ripples.js"></script>
    <script type="text/javascript" src="/js/modernizr.js"></script>
  </body>
</html>