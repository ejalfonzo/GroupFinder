<?php

/**
 * Class Events
 * handles the user data
 */
class Events
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
   * you know, when you do "$events = new Events();"
   */
  public function __construct()
  {
    if (isset($_POST["createEvent"])) {
        $this->createEvent();
    }
    if (isset($_POST["search"])) {
        $this->searchEvent();
    }
    if (isset($_POST["join"])) {
        $this->joinEvent();
    }
    if (isset($_POST["leave"])) {
        $this->leaveEvent();
    }
    // if (isset($_GET["event"])) {
    //     $this->openEvent();
    // }
  }

  function joinEvent(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userID = $_SESSION["id"];
        $eventID = $this->db_connection->real_escape_string(strip_tags($_POST['join'], ENT_QUOTES));
        // echo("<script>console.log('PHP: getEventDetails ".json_encode($userID)."');</script>");

        // check if user or email address already exists
        $sql = "INSERT INTO `ebabilon`.`members` (`id_event`, `id_member`)
        SELECT * FROM (SELECT '".$eventID."', '".$userID."') AS tmp
        WHERE NOT EXISTS (SELECT id_event, id_member FROM ebabilon.members
        WHERE id_event = '".$eventID."' AND id_member = '".$userID."') LIMIT 1;";
        $query_get_user_info = $this->db_connection->query($sql);
        // get result row (as an object)
        // echo("<script>console.log('PHP: getEventDetails ".json_encode($query_get_user_info)."');</script>");
        if($query_get_user_info){
          $joinResult = "Joined Event";
          return json_encode($joinResult);
        }
        // $result_row = $query_get_user_info->fetch_object();
        //
        // return json_encode($result_row);


        // echo '<span class="text-muted">'. $result_row->name .'</span>';
    }
  }

  function leaveEvent(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userID = $_SESSION["id"];
        $eventID = $this->db_connection->real_escape_string(strip_tags($_POST['leave'], ENT_QUOTES));
        // echo("<script>console.log('PHP: getEventDetails ".json_encode($userID)."');</script>");

        // check if user or email address already exists
        $sql = "DELETE FROM `ebabilon`.`members` WHERE `id_event`='".$eventID."' AND `id_member` = '".$userID."';";
        $query_get_user_info = $this->db_connection->query($sql);
        // get result row (as an object)
        // echo("<script>console.log('PHP: getEventDetails ".json_encode($query_get_user_info)."');</script>");
        if($query_get_user_info){
          $joinResult = "Event Left";
          return json_encode($joinResult);
        }
    }
  }

  function isMember(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userID = $_SESSION["id"];
        $eventID = $this->db_connection->real_escape_string(strip_tags($_POST['join'], ENT_QUOTES));
        // echo("<script>console.log('PHP: getEventDetails ".json_encode($userID)."');</script>");

        // check if user or email address already exists
        $sql = "SELECT * FROM ebabilon.members WHERE id_event = '".$eventID."' AND id_member = '".$userID."';";
        $query_get_user_info = $this->db_connection->query($sql);
        // get result row (as an object)
        // echo("<script>console.log('PHP: getEventDetails ".json_encode($query_get_user_info)."');</script>");

        if($rows = $query_get_user_info->num_rows >= 1){
          $result_row = $query_get_user_info->fetch_object();
          return json_encode($rows);
        }
        //
        // return json_encode($result_row);


        // echo '<span class="text-muted">'. $result_row->name .'</span>';
    }
  }

  function searchEvent(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userID = $_SESSION["id"];
        $searchStatement = $this->db_connection->real_escape_string(strip_tags($_POST['search'], ENT_QUOTES));
        // echo("<script>console.log('searh results: ".json_encode($searchStatement)."');</script>");
        // check if user or email address already exists
        $sql = "SELECT *
        FROM ebabilon.events
        WHERE name like '%".$searchStatement."%';";

        $query_get_user_info = $this->db_connection->query($sql);

        // get result row (as an object)
        if ($query_get_user_info->num_rows >= 1) {
            $arrayResult = array();
          while($row = $query_get_user_info->fetch_object()){
            //   echo(json_encode($row));
            //   return $row;
            $sql2 = "SELECT * FROM ebabilon.members WHERE id_event = '".$row->id_event."' AND id_member = '".$userID."';";
            $query_isMember = $this->db_connection->query($sql2);
            $result_Member = $query_isMember->fetch_object();
            if($result_Member->id_member == $userID){
              $arrayResult[] =  (array('id' => $row->id_event,'name'=> $row->name,
               'category' => $row->category, 'description' => $row->description, 'admin' => $row->admin,
              'image' => $row->event_image, 'isMember' => true));
            }else{
              $arrayResult[] =  (array('id' => $row->id_event,'name'=> $row->name,
               'category' => $row->category, 'description' => $row->description, 'admin' => $row->admin,
              'image' => $row->event_image, 'isMember' => false));
            }

            // echo(''.$row->id_event)
         }
         return json_encode($arrayResult);
       }
        // $result_row = $query_get_user_info->fetch_object();

        // echo '<span class="text-muted">'. $result_row->name .'</span>';
    }
  }

  function getEvent(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userId = $_SESSION["id"];
        $eventID = $_GET["event"];

        // check if user or email address already exists
        $sql = "SELECT * FROM ebabilon.events WHERE id_event = '".$eventID."';";
        $query_get_user_info = $this->db_connection->query($sql);
        // get result row (as an object)
        $result_row = $query_get_user_info->fetch_object();

        echo '<img src=" '. $result_row->event_image .' " width="100" height="100" class="img-responsive" alt="Generic placeholder thumbnail">';
        echo '<h4>'.$result_row->name.'</h4>';
        // echo '<span class="text-muted">'. $result_row->name .'</span>';
    }
  }

  function getEventDetails(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userId = $_SESSION["id"];
        $eventID = $_GET["event"];

        // check if user or email address already exists
        $sql = "SELECT eventsList.id_event, eventsList.name, categoryList.name as category, eventsList.description, eventsList.event_image, id, first_name, last_name
        FROM ebabilon.events as eventsList, ebabilon.users as userList, ebabilon.event_categories as categoryList
        WHERE id_event = '".$eventID."' AND eventsList.admin = userList.id AND eventsList.category = categoryList.id_category;";
        $query_get_user_info = $this->db_connection->query($sql);
        // get result row (as an object)
        return $query_get_user_info;

        // echo '<span class="text-muted">'. $result_row->name .'</span>';
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
        $result_row = $query_get_user_info->fetch_object();
        echo("<script>console.log('PHP: ".json_encode($result_row->first_name)."');</script>");
        echo($result_row->first_name);
    }
  }

  function getEventMembersTable(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userId = $_SESSION["id"];
        $eventID = $_GET["event"];

        $sql = "SELECT id, first_name, last_name, user_image, email
        FROM ebabilon.attendees, ebabilon.users as userList
        WHERE id_attendee = userList.id AND id_event = '".$eventID."';";
        $query_get_user_info = $this->db_connection->query($sql);
        return $query_get_user_info;
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

  function createEvent(){
    if (empty($_POST['event_name'])) {
        $this->errors[] = "Empty Username";
        echo("<script>console.log('Error: Empty Event Name');</script>");

    } elseif (strlen($_POST['event_name']) > 64 || strlen($_POST['event_name']) < 2) {
        $this->errors[] = "Username cannot be shorter than 2 or longer than 64 characters";
        echo("<script>console.log('Error: Username to short');</script>");

    } elseif (!empty($_POST['event_name'])
        && strlen($_POST['event_name']) <= 64
        && strlen($_POST['event_name']) >= 2
    ) {
        echo("<script>console.log('Good: All Clear');</script>");
        // create a database connection
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // change character set to utf8 and check it
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
            echo("<script>console.log('Error: DB not utf8');</script>");
        }

        // if no connection errors (= working database connection)
        if (!$this->db_connection->connect_errno) {
            // echo("<script>console.log('Good: DB Connection');</script>");
            // escaping, additionally removing everything that could be (html/javascript-) code
            $userID = $_SESSION["id"];
            $name = $this->db_connection->real_escape_string(strip_tags($_POST['event_name'], ENT_QUOTES));
            $category = $this->db_connection->real_escape_string(strip_tags($_POST['category'], ENT_QUOTES));
            $description = $this->db_connection->real_escape_string(strip_tags($_POST['description'], ENT_QUOTES));
            $time = $this->db_connection->real_escape_string(strip_tags($_POST['event_time'], ENT_QUOTES));
            $place = $this->db_connection->real_escape_string(strip_tags($_POST['event_place'], ENT_QUOTES));

            $sql = "INSERT INTO `ebabilon`.`events` (`name`, `admin`, `category`, `description`, `time`, `place`)
            VALUES ('".$name."', '".$userID."', '".$category."', '".$description."', '".$time."', '".$place."');";
            $query_new_user_insert = $this->db_connection->query($sql);

            $event_id = mysqli_insert_id($this->db_connection);
            // echo("<script>console.log('results_row: ".json_encode($event_id)."');</script>");
            // if user has been added successfully
            if ($query_new_user_insert) {
                $this->messages[] = "Your account has been created successfully. You can now log in.";
                echo("<script>console.log('PHP: event created');</script>");

                $sql = "INSERT INTO `ebabilon`.`attendees` (`id_event`, `id_attendee`)
                VALUES  (".$event_id.",'".$userID."');";
                $query_new_member_insert = $this->db_connection->query($sql);

                if($query_new_member_insert){
                  echo("<script>console.log('PHP: User Added');</script>");
                }
                // echo("<script>console.log('PHP: ".json_encode($query_new_user_insert)."');</script>");
            } else {
                $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                echo("<script>console.log('PHP: ERROR Registering');</script>");
            }
        } else {
            $this->errors[] = "Sorry, no database connection.";
        }
    } else {
        $this->errors[] = "An unknown error occurred.";
    }
  }

  function getEventCategories(){
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

        $sql = "SELECT * FROM ebabilon.event_categories;";
        $query_get_user_info = $this->db_connection->query($sql);
        if ($query_get_user_info->num_rows >= 1) {
          return $query_get_user_info;
       }
    }
  }

  function getUserEvents(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userID = $_SESSION["id"];

        $sql = "SELECT myEvents.name, myEvents.category, myEvents.id_event, first_name, last_name
        FROM (SELECT eventsList.name, eventsList.category, eventsList.admin, eventsList.id_event
        FROM ebabilon.events as eventsList, ebabilon.attendees as memberList
        WHERE eventsList.id_event = memberList.id_event AND memberList.id_attendee = '" .$userID."') as myEvents, ebabilon.users
        WHERE myEvents.admin = id;";
        $query_get_user_info = $this->db_connection->query($sql);
        return $query_get_user_info;
    }
  }
}
