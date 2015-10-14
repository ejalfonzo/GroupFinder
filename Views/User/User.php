<?php

/**
 * Class User
 * handles the user data
 */
class User
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
                $date = date_create($row->time);
                echo("<script>console.log('results_row: ".json_encode($row)."');</script>");
                echo '<tr>';
                  echo   '<td>'. $row->name . '</td>';
                  echo   '<td>'. $row->first_name . ' ' . $row->last_name . '</td>';
                  echo   '<td>'. date_format($date, 'F j, Y, g:i a') . '</td>';
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

      function getAllEventsTable(){
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

            $sql = "SELECT myEvents.name, myEvents.time, myEvents.place, myEvents.description, first_name, last_name
            FROM (SELECT eventsList.name, eventsList.time, eventsList.place, eventsList.description, eventsList.admin
            FROM ebabilon.events as eventsList, ebabilon.attendees as attendList
            WHERE eventsList.id_event = attendList.id_event AND attendList.id_attendee = '" .$userID . "') as myEvents, ebabilon.users
            WHERE time > '" .$today->date . "' AND myEvents.admin = id;";
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
                    <th>Description</th>
                  </tr>
                </thead>';
                while($row = $query_get_user_info->fetch_object()) {
                  $date = date_create($row->time);
                  echo("<script>console.log('results_row: ".json_encode($row)."');</script>");
                  echo '<tr>';
                    echo   '<td>'. $row->name . '</td>';
                    echo   '<td>'. $row->first_name . ' ' . $row->last_name . '</td>';
                    echo   '<td>'. date_format($date, 'F j, Y, g:i a') . '</td>';
                    echo   '<td>'. $row->place . '</td>';
                    echo   '<td>'. $row->description . '</td>';
                  echo '</tr>';
               }
             echo'</table>
             </div>';
           }else{
             echo '<h3 class="text-muted" style="margin-top:75px";>You Have No Upcoming Events...</h3>';
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

            $sql = "SELECT myGroups.name, myGroups.category, myGroups.id_group, first_name, last_name
            FROM (SELECT groupsList.name, groupsList.category, groupsList.admin, groupsList.id_group
            FROM ebabilon.groups as groupsList, ebabilon.members as memberList
            WHERE groupsList.id_group = memberList.id_group AND memberList.id_member = '" .$userID."') as myGroups, ebabilon.users
            WHERE myGroups.admin = id;";
            $query_get_user_info = $this->db_connection->query($sql);
            if ($query_get_user_info->num_rows >= 1) {

              while($row = $query_get_user_info->fetch_object()) {
                echo("<script>console.log('results_row: ".json_encode($row)."');</script>");
                echo '<div class="col-xs-6 col-sm-3 placeholder" style="margin-bottom:0px;">';
                  echo '<button onclick="location.href = '."'"."/Views/Groups/open.php?group=".$row->id_group."'".';" class="btn btn-flat btn-primary" style="padding: 3px;border-radius: 50%;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Profile">';
                  echo   '<img src="/images/stock/members.png" width="100" height="100" class="img-responsive" alt="Generic placeholder thumbnail">';
                  echo '</button>';
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
