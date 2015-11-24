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

    function createPost(){
      $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

      // change character set to utf8 and check it
      if (!$this->db_connection->set_charset("utf8")) {
          $this->errors[] = $this->db_connection->error;
          echo("<script>console.log('Error: DB not utf8');</script>");
      }
      if (!$this->db_connection->connect_errno) {
          // escaping, additionally removing everything that could be (html/javascript-) code
          $userID = $_SESSION["id"];
          $destinationID = $_SESSION["id"];
          $postMessage = $this->db_connection->real_escape_string(strip_tags($_POST['createPost'], ENT_QUOTES));
          $today = date("Y-m-d H:i:s"); //("F j, Y, g:i a")
          // echo("<script>console.log('PHP: Today? ".$today."');</script>");
          // check if user or email address already exists
          $sql = "INSERT INTO `ebabilon`.`posts` (`message`, `date`, `author`, `destination`)
          VALUES ('".$postMessage."', '".$today."', '".$userID."', '".$destinationID."');";
          $query_new_post_insert = $this->db_connection->query($sql);
          if ($query_new_post_insert) {
            // echo("POSTID? ". $this->db_connection->insert_id);
            $this->messages[] = "Your post has been created successfully. You can now log in.";

            $sql = "SELECT message, date, destination, first_name, last_name, user_image
            FROM ebabilon.posts, users
            WHERE id = author AND id_post = '".$this->db_connection->insert_id."';";
            $query_get_user_info = $this->db_connection->query($sql);
            $arrayResult = array();
            if($result_row = $query_get_user_info->fetch_object()){
              return json_encode($result_row);
            }
            // echo("<script>console.log('PHP: ".json_encode($query_new_user_insert)."');</script>");
        } else {
            $this->errors[] = "Sorry, your post failed. Please go back and try again.";
            echo("PHP: ERROR Post");
        }
      }
    }

    function deletePost(){
      $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

      // change character set to utf8 and check it
      if (!$this->db_connection->set_charset("utf8")) {
          $this->errors[] = $this->db_connection->error;
          echo("<script>console.log('Error: DB not utf8');</script>");
      }
      if (!$this->db_connection->connect_errno) {
          // escaping, additionally removing everything that could be (html/javascript-) code
          $postID = $this->db_connection->real_escape_string(strip_tags($_POST['deletePost'], ENT_QUOTES));

          // check if user or email address already exists
          $sql = "DELETE FROM `ebabilon`.`posts` WHERE `id_post`='".$postID."';";
          $query_new_post_delete = $this->db_connection->query($sql);
          // get result row (as an object)
          // $result_row = $query_new_post_delete->fetch_object();
          // echo($result_row);
          if ($query_new_post_delete) {
              $this->messages[] = "Your post has been created successfully. You can now log in.";
              // echo("<script>console.log('PHP: ".json_encode($query_new_user_insert)."');</script>");
          } else {
              $this->errors[] = "Sorry, your post failed. Please go back and try again.";
              echo("<script>console.log('PHP: ERROR Post');</script>");
          }
      }
    }

    function getFeed(){
      $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

      // change character set to utf8 and check it
      if (!$this->db_connection->set_charset("utf8")) {
          $this->errors[] = $this->db_connection->error;
          echo("<script>console.log('Error: DB not utf8');</script>");
      }
      if (!$this->db_connection->connect_errno) {
          // escaping, additionally removing everything that could be (html/javascript-) code
          $userID = $_SESSION["id"];
          // check if user or email address already exists
          $sql = "SELECT postList.id_post, message, postList.date, id as authorID, first_name, last_name, user_image
          FROM ebabilon.posts as postList, ebabilon.users as authorsList
          WHERE author = authorsList.id AND destination = '".$userID."';";
          $query_get_user_info = $this->db_connection->query($sql);
          // get result row (as an object)
          // $result_row = $query_get_user_info->fetch_object();
          $arrayResult = array();
          while($result_row = $query_get_user_info->fetch_object()){
            $arrayResult[] = ($result_row);

          }
          return json_encode($arrayResult);
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
            $row = $query_get_user_info = $this->db_connection->query($sql);
            return $row;
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
            $row = $query_get_user_info = $this->db_connection->query($sql);
            return $row;
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
            $row = $query_get_user_info = $this->db_connection->query($sql);
            return $row;
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
