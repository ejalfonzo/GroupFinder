<?php

/**
 * Class User
 * handles the user data
 */
class Basic
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$registration = new Registration();"
     */
    public function __construct()
    {
        if (isset($_POST["search"])) {
            $this->search();
        }
    }

    function search(){
      $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

      // change character set to utf8 and check it
      if (!$this->db_connection->set_charset("utf8")) {
          $this->errors[] = $this->db_connection->error;
          echo("<script>console.log('Error: DB not utf8');</script>");
      }
      if (!$this->db_connection->connect_errno) {
          // escaping, additionally removing everything that could be (html/javascript-) code
          $searchStatement = $this->db_connection->real_escape_string(strip_tags($_POST['search'], ENT_QUOTES));
          $arrayResult = array();

          $sql = "SELECT *
          FROM ebabilon.groups
          WHERE name like '%".$searchStatement."%';";

          $query_get_user_info = $this->db_connection->query($sql);

          // get result row (as an object)
          if ($query_get_user_info->num_rows >= 1) {
            while($row = $query_get_user_info->fetch_object()){
              $arrayResult[] =  (array('type'=>'group','id' => $row->id_group,'name'=> $row->name,
               'category' => $row->category, 'description' => $row->description, 'admin' => $row->admin,
              'image' => $row->group_image));
           }
         }

         $sql = "SELECT *
         FROM ebabilon.events
         WHERE name like '%".$searchStatement."%';";

         $query_get_user_info = $this->db_connection->query($sql);
         // get result row (as an object)
         if ($query_get_user_info->num_rows >= 1) {

           while($row = $query_get_user_info->fetch_object()){
             $arrayResult[] =  (array('type'=>'event','id' => $row->id_event,'name'=> $row->name, 'place'=>$row->place, 'time'=>$row->time,
              'category' => $row->category, 'description' => $row->description, 'admin' => $row->admin));
          }
        }
        // if(count($arrayResult) >= 1){
            return json_encode($arrayResult);
        // }
      }
    }

    function getUserFirstName(){
      $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

      // change character set to utf8 and check it
      if (!$this->db_connection->set_charset("utf8")) {
          $this->errors[] = $this->db_connection->error;
          echo("<script>console.log('Error: DB not utf8');</script>");
      }
      if (!$this->db_connection->connect_errno) {
          // escaping, additionally removing everything that could be (html/javascript-) code
          $user_name = $_SESSION["user_name"];
          $email = $_SESSION['email'];
          // check if user or email address already exists
          $sql = "SELECT first_name FROM users WHERE user_name = '" . $user_name . "' OR email = '" . $user_email . "';";
          $query_get_user_info = $this->db_connection->query($sql);
          // get result row (as an object)
          $result_row = $query_get_user_info->fetch_object();  echo("<script>console.log('PHP: ".json_encode($result_row->first_name)."');</script>");
          echo($result_row->first_name);
        }
  }
  function getUserLastName(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $user_name = $_SESSION["user_name"];
        $email = $_SESSION['email'];
        // check if user or email address already exists
        $sql = "SELECT last_name FROM users WHERE user_name = '" . $user_name . "' OR email = '" . $user_email . "';";
        $query_get_user_info = $this->db_connection->query($sql);
        // get result row (as an object)
        $result_row = $query_get_user_info->fetch_object();
        echo($result_row->last_name);
      }
    }
    function getUserImage(){
      $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

      // change character set to utf8 and check it
      if (!$this->db_connection->set_charset("utf8")) {
          $this->errors[] = $this->db_connection->error;
          echo("<script>console.log('Error: DB not utf8');</script>");
      }
      if (!$this->db_connection->connect_errno) {
          // escaping, additionally removing everything that could be (html/javascript-) code
          $user_name = $_SESSION["user_name"];
          $email = $_SESSION['email'];
          // check if user or email address already exists
          $sql = "SELECT user_image FROM users WHERE user_name = '" . $user_name . "' OR email = '" . $user_email . "';";
          $query_get_user_info = $this->db_connection->query($sql);
          // get result row (as an object)
          $result_row = $query_get_user_info->fetch_object();
          echo($result_row->user_image);
        }
      }

      function getUpcomingEventsTable(){
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        // change character set to utf8 and check it
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
            echo("<script>console.log('Error: DB not utf8');</script>");
        }
        if (!$this->db_connection->connect_errno) {
            // escaping, additionally removing everything that could be (html/javascript-) code
            $userID = $_SESSION["id"];
            $email = $_SESSION['email'];
            $today = new DateTime();
            $today->format('Y-m-d H:i:s');

            $sql = "SELECT myEvents.name, myEvents.time, myEvents.place, myEvents.category, first_name, last_name
            FROM (SELECT eventsList.name, eventsList.time, eventsList.place, eventsList.category, eventsList.admin
            FROM ebabilon.events as eventsList, ebabilon.attendees as attendList
            WHERE eventsList.id_event = attendList.id_event AND attendList.id_attendee = '" .$userID . "') as myEvents, ebabilon.users
            WHERE time > '" .$today->date . "' AND myEvents.admin = id
            LIMIT 3;";
            $query_get_user_info = $this->db_connection->query($sql);
            if ($query_get_user_info->num_rows >= 1) {
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
              while($row = $query_get_user_info->fetch_object()) {
                echo("<script>console.log('results_row: ".json_encode($row)."');</script>");
                echo '<tr>';
                  echo   '<td>'. $row->name . '</td>';
                  echo   '<td>'. $row->first_name . ' ' . $row->last_name . '</td>';
                  echo   '<td>'. $row->time . '</td>';
                  echo   '<td>'. $row->place . '</td>';
                echo '</tr>';
             }
             echo'</table>
             </div>';
           }else{
             echo '<h3 class="text-muted" style="margin-top:75px";>You Have No Upcoming Events...</h3>';
           }
        }
      }

      function getAllEventsTimeline(){
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        // change character set to utf8 and check it
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
            echo("<script>console.log('Error: DB not utf8');</script>");
        }
        if (!$this->db_connection->connect_errno) {
            // escaping, additionally removing everything that could be (html/javascript-) code
            $userID = $_SESSION["id"];
            $email = $_SESSION['email'];
            $today = new DateTime();
            $today->format('Y-m-d H:i:s');

            if($userID){
              $sql = "SELECT myEvents.name, myEvents.time, myEvents.place, myEvents.description, first_name, last_name
              FROM (SELECT eventsList.name, eventsList.time, eventsList.place, eventsList.description, eventsList.admin
              FROM ebabilon.events as eventsList, ebabilon.attendees as attendList
              WHERE eventsList.id_event = attendList.id_event AND attendList.id_attendee = '" .$userID . "') as myEvents, ebabilon.users
              WHERE time > '" .$today->date . "' AND myEvents.admin = id;";
            }else{
              $sql = "SELECT myEvents.name, myEvents.time, myEvents.place, myEvents.description, first_name, last_name
              FROM (SELECT eventsList.name, eventsList.time, eventsList.place, eventsList.description, eventsList.admin
              FROM ebabilon.events as eventsList, ebabilon.attendees as attendList
              WHERE eventsList.id_event = attendList.id_event ') as myEvents, ebabilon.users
              WHERE time > '" .$today->date . "' AND myEvents.admin = id;";
            }
            $query_get_user_info = $this->db_connection->query($sql);
            if ($query_get_user_info->num_rows >= 1) {

              // echo '<div class="cd-timeline-block">
              //     <div class="cd-timeline-img">
              //         <img src="/images/icons-svg/star-white.svg" alt="Picture">
              //     </div> <!-- cd-timeline-img -->
              //
              //     <div class="cd-timeline-content">
              //         <h2>Group Finder Team</h2>
              //         <p>Our team is going to have a Happy Hour, be there... </p>
              //         <a href="#0" class="cd-read-more">Read more</a>
              //         <span class="cd-date">Sep 29</span>
              //     </div>
              // </div> ';

                while($row = $query_get_user_info->fetch_object()) {
                  $date = date_create($row->time);
                    echo("<script>console.log('results_row: ".json_encode($row)."');</script>");
                    echo '<div class="cd-timeline-block">
                         <div class="cd-timeline-img">
                             <img src="/images/icons-svg/star-white.svg" alt="Picture">
                         </div>';
                    echo '<div class="cd-timeline-content">';

                    echo   '<h2>'. $row->name . '</h2>';
                    // echo   '<p>'. $row->first_name . ' ' . $row->last_name . '</p>';
                    // echo   '<p>'. $row->place . '</p>';
                    echo   '<p>'. $row->description . '</p>';
                    echo   '<span class="cd-date">'. date_format($date, 'M j') . '</span>';
                    echo '</div>';
                   echo '</div>';
               }

           }else{
            //  echo '<h3 class="text-muted" style="margin-top:75px";>You Have No Upcoming Events...</h3>';
           }
        }
      }

      function getUserGroups(){
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        // change character set to utf8 and check it
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
            echo("<script>console.log('Error: DB not utf8');</script>");
        }
        if (!$this->db_connection->connect_errno) {
            // escaping, additionally removing everything that could be (html/javascript-) code
            $userID = $_SESSION["id"];
            $email = $_SESSION['email'];

            // check if user or email address already exists
            // $sql = "SELECT name FROM events WHERE user_name = '" . $user_name . "' OR email = '" . $user_email . "';";

            $sql = "SELECT myGroups.name, myGroups.category, first_name, last_name
            FROM (SELECT groupsList.name, groupsList.category, groupsList.admin
            FROM ebabilon.groups as groupsList, ebabilon.members as memberList
            WHERE groupsList.id_group = memberList.id_group AND memberList.id_member = '" .$userID."') as myGroups, ebabilon.users
            WHERE myGroups.admin = id
            LIMIT 4;";
            $query_get_user_info = $this->db_connection->query($sql);
            if ($query_get_user_info->num_rows >= 1) {

              while($row = $query_get_user_info->fetch_object()) {
                echo("<script>console.log('results_row: ".json_encode($row)."');</script>");
                echo '<div class="col-xs-6 col-sm-3 placeholder">';
                  echo   '<img src="/images/stock/members.png" width="100" height="100" class="img-responsive" alt="Generic placeholder thumbnail">';
                  echo   '<h4>'. $row->name . '</h4>';
                  echo   '<span class="text-muted">'. $row->description . '</span>';
                echo '</div>';
             }
           }else{
             echo '<h3 class="text-muted" style="margin-top:75px";>You Have No Groups...</h3>';
           }
        }
      }

    /**
    * request the user's information
    */
    private function userInfoHeader(){
      // create a database connection
      $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

      // change character set to utf8 and check it
      if (!$this->db_connection->set_charset("utf8")) {
          $this->errors[] = $this->db_connection->error;
          echo("<script>console.log('Error: DB not utf8');</script>");
      }
      if (!$this->db_connection->connect_errno) {
          echo("<script>console.log('Good: DB Connection');</script>");
          // escaping, additionally removing everything that could be (html/javascript-) code
          $user_name = $_SESSION["user_name"];
          $email = $_SESSION['email'];


          // check if user or email address already exists
          $sql = "SELECT * FROM users WHERE user_name = '" . $user_name . "' OR email = '" . $user_email . "';";
          $query_get_user_info = $this->db_connection->query($sql);

          //Test Debug
          echo("<script>console.log('PHP: ".json_encode($sql)."');</script>");

        }
    }
}
