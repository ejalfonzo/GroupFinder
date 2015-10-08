<!DOCTYPE html>
<html >
  <head>
    <title>GroupFinder Create Event</title>
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
                <h1 id="timeline">Create an Event</h1>
                <!-- Enter Event Info-->
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
                    <label for="eventName">Event Name</label>
                    <input class="form-control" id="eventName" type="text" style="width:40%" />
                  </div>
                  <div class="form-group">
                    <label for="eventCategory">Event Category</label>
                    <input class="form-control" id="eventCategory" type="text" style="width:40%" />
                  </div>
                  <div class="form-group">
                   <label for="eventLocation">Event Location</label>
                    <input class="form-control" id="eventLocation" type="text" style="width:40%" />
                  </div>
                  <div class="form-group">
                    <label for="sel1">Select Date:</label>
                    <select class="form-control" id="sel1" style="width:15%" style="float:right;">
                      <option>January</option>
                      <option>February</option>
                      <option>March</option>
                      <option>April</option>
                      <option>May</option>
                      <option>June</option>
                      <option>July</option>
                      <option>August</option>
                      <option>September</option>
                      <option>October</option>
                      <option>November</option>
                      <option>Dcember</option>
                    </select>
                    <select class="form-control" id="sel2" style="width:10%">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                      <option>6</option>
                      <option>7</option>
                      <option>8</option>
                      <option>9</option>
                      <option>10</option>
                      <option>11</option>
                      <option>12</option>
                      <option>13</option>
                      <option>14</option>
                      <option>15</option>
                      <option>16</option>
                      <option>17</option>
                      <option>18</option>
                      <option>19</option>
                      <option>20</option>
                      <option>21</option>
                      <option>22</option>
                      <option>23</option>
                      <option>24</option>
                      <option>25</option>
                      <option>26</option>
                      <option>27</option>
                      <option>28</option>
                      <option>29</option>
                      <option>30</option>
                      <option>31</option>
                    </select>
                    <select class="form-control" id="sel3" style="width:10%">
                      <option>2015</option>
                      <option>2016</option>
                      <option>2017</option>
                      <option>2018</option>     
                    </select>
                  </div>



                  <a id="modal-514361" href="#modal-container-514361" role="button" class="btn" data-toggle="modal">Add Friends</a>
      
                  <div class="modal fade" id="modal-container-514361" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                           
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            ×
                          </button>
                          <h4 class="modal-title" id="myModalLabel">
                            Friends
                          </h4>
                        </div>
                        <div class="modal-body">
                          ...
                        </div>
                        <div class="modal-footer">
                           
                          <button type="button" class="btn btn-default" data-dismiss="modal">
                            Close
                          </button> 
                          <button type="button" class="btn btn-primary">
                            Save Selection
                          </button>
                        </div>
                      </div>
                      
                    </div>
                    
                  </div>

                </form>

                <!-- Create or Cancel -->
                <button type="submit" class="btn btn-default">Create</button>
                <button type="submit" class="btn btn-default">Cancel</button>
            </div>
         </div>
        </div>
      </div>
    </div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  </body>
</html>
