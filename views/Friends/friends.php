<?php

/**
 * Class Friends
 * handles the user data
 */
class Friends
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
   * you know, when you do "$friends = new Friends();"
   */
  public function __construct()
  {
    if (isset($_POST["addFriend"])) {
        $this->addFriend();
    }
    if (isset($_POST["search"])) {
        $this->searchFriend();
    }
    if (isset($_POST["removeFriend"])) {
        $this->removeFriend();
    }
    if (isset($_POST["editFriend"])) {
        $this->editFriend();
    }
    // if (isset($_GET["friend"])) {
    //     $this->openFriend();
    // }
  }

  function editFriend(){
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
   // 
      $userID = $_SESSION["id"];
      $friendID = $_GET["friend"];
      $category = $this->db_connection->real_escape_string(strip_tags($_POST['category'], ENT_QUOTES));

      $sql = "UPDATE `ebabilon`.`friends` 
      SET  category='".$category."'
      WHERE id_friend = '".$friendID."';";
      $query_edit_friend = $this->db_connection->query($sql);
      echo("<script>console.log('query: ".json_encode($query_edit_friend)."');</script>");

      if ($query_edit_friend) {
          $this->messages[] = "Your account has been created successfully. You can now log in.";
          echo("<script>console.log('PHP: business edited');</script>");
           
          echo("<script>console.log('PHP Insert: ".json_encode($query_edit_friend)."');</script>");
          $editResult = "Edited Friend";
          return json_encode($editResult);
      } else {
          $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
          echo("<script>console.log('PHP: ERROR Editing Friend');</script>");
      }
    } else {
            $this->errors[] = "Sorry, no database connection.";
    }
  }

  function addFriend(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userID = $_SESSION["id"];
        $friendID = $this->db_connection->real_escape_string(strip_tags($_POST['addFriend'], ENT_QUOTES));
        // echo("<script>console.log('PHP: getGroupDetails ".json_encode($userID)."');</script>");

        // check if user or email address already exists
        $sql = "INSERT INTO `ebabilon`.`friends` (`id_friend`, `id_user`)
        SELECT * FROM (SELECT '".$friendID."', '".$userID."') AS tmp
        WHERE NOT EXISTS (SELECT id_friend, id_user FROM ebabilon.friends
        WHERE id_friend = '".$friendID."' AND id_user = '".$userID."') LIMIT 1;";
        $query_get_user_info_2 = $this->db_connection->query($sql);
        
        $sql = "INSERT INTO `ebabilon`.`friends` (`id_friend`, `id_user`)
        SELECT * FROM (SELECT '".$userID."', '".$friendID."') AS tmp
        WHERE NOT EXISTS (SELECT id_friend, id_user FROM ebabilon.friends
        WHERE id_friend = '".$userID."' AND id_user = '".$friendID."') LIMIT 1;";
        $query_get_user_info = $this->db_connection->query($sql);

        if($query_get_user_info && $query_get_user_info_2){
          $addResult = "Added Friend";
          return json_encode($addResult);
        }
    }
  }

  function removeFriend(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userID = $_SESSION["id"];
        $friendID = $this->db_connection->real_escape_string(strip_tags($_POST['removeFriend'], ENT_QUOTES));
        // echo("<script>console.log('PHP: getGroupDetails ".json_encode($userID)."');</script>");

        // check if user or email address already exists
        $sql = "DELETE FROM ebabilon.friends WHERE `id_friend`='".$friendID."' AND `id_user` = '".$userID."';";
        $query_get_user_info = $this->db_connection->query($sql);
        $sql = "DELETE FROM ebabilon.friends WHERE `id_friend`='".$userID."' AND `id_user` = '".$friendID."';";
        $query_get_user_info_2 = $this->db_connection->query($sql);
        // get result row (as an object)
        // echo("<script>console.log('PHP: getGroupDetails ".json_encode($query_get_user_info)."');</script>");
        if($query_get_user_info && $query_get_user_info_2){
          $removeResult = "Removed Friend";
          return json_encode($removeResult);
        }
    }
  }

  function isFriend(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userID = $_SESSION["id"];
        $friendID = $this->db_connection->real_escape_string(strip_tags($_POST['isFriend'], ENT_QUOTES));
        // echo("<script>console.log('PHP: getGroupDetails ".json_encode($userID)."');</script>");

        // check if user or email address already exists
        $sql = "SELECT * FROM ebabilon.friends WHERE id_friend = '".$friendID."' AND id_user = '".$userID."';";
        $query_get_user_info = $this->db_connection->query($sql);
        // get result row (as an object)
        // echo("<script>console.log('PHP: getGroupDetails ".json_encode($query_get_user_info)."');</script>");

        if($rows = $query_get_user_info->num_rows >= 1){
          $result_row = $query_get_user_info->fetch_object();
          return json_encode($rows);
        }
        //
        // return json_encode($result_row);


        // echo '<span class="text-muted">'. $result_row->name .'</span>';
    }
  }

  function searchFriend(){
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
        FROM ebabilon.users
        WHERE first_name like '%".$searchStatement."%' OR last_name like '%".$searchStatement."%' OR user_name like '%".$searchStatement."%';";

        $query_get_user_info = $this->db_connection->query($sql);

        // get result row (as an object)
        if ($query_get_user_info->num_rows >= 1) {
            $arrayResult = array();
          while($row = $query_get_user_info->fetch_object()){
            //   echo(json_encode($row));
            //   return $row;
            $sql = "SELECT *
            FROM ebabilon.friends
            WHERE id_user = '".$userID."' AND id_friend = '".$row->id."';";
            $query_isFriend = $this->db_connection->query($sql);
            $result_Friend = $query_isFriend->fetch_object();
            if($result_Friend->id == $userID){
              $arrayResult[] =  (array('id' => $row->id,'user_name'=> $row->user_name,
               'email' => $row->email, 'image' => $row->user_image, 'isFriend' => true));
            }else{
              $arrayResult[] =  (array('id' => $row->id,'user_name'=> $row->user_name,
               'email' => $row->email, 'image' => $row->user_image, 'isFriend' => false));
            }

            // echo(''.$row->id_group)
         }
         return json_encode($arrayResult);
       }
        // $result_row = $query_get_user_info->fetch_object();

        // echo '<span class="text-muted">'. $result_row->name .'</span>';
    }
  }

  function getFriend(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userId = $_SESSION["id"];
        $friendID = $_GET["friend"];

        // check if user or email address already exists
        $sql = "SELECT id, user_name, first_name, last_name, email, user_image
        FROM ebabilon.users as userList
        WHERE id = '".$friendID."';";
        $query_get_user_info = $this->db_connection->query($sql);

        return $query_get_user_info;
        // get result row (as an object)

        // echo '<span class="text-muted">'. $result_row->name .'</span>';
    }
  }

  function getFriendDetails(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userId = $_SESSION["id"];
        $friendID = $_GET["friend"];

        // check if user or email address already exists
        $sql = "SELECT DISTINCT userList.id, user_name, first_name, last_name, email, user_image, friend.category AS catId, catList.name AS category
        FROM ebabilon.users AS userList, ebabilon.friends_categories AS catList, (SELECT id_friend, category FROM ebabilon.friends) AS friend
        WHERE userList.id ='".$friendID."' AND catList.id_category = friend.category AND friend.id_friend = userList.id;";
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

  function getFriendsTable(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userId = $_SESSION["id"];
        $adminID = $_GET["friend"];

        $sql = "SELECT id_business as id, businessList.name, categoriesList.name as category, business_image as image, 'Business' as type
        FROM ebabilon.businesses as businessList, ebabilon.business_categories as categoriesList
        WHERE admin = '".$adminID."' AND categoriesList.id_category = businessList.category
        UNION
        SELECT id_group as id, groupsList.name, categoriesList.name as category, group_image as image, 'Group'
        FROM ebabilon.groups as groupsList, ebabilon.group_categories as categoriesList
        WHERE admin = '".$adminID."' AND categoriesList.id_category = groupsList.category
        UNION
        SELECT id_event as id, eventsList.name, categoriesList.name as category, event_image as image, 'Event'
        FROM ebabilon.events as eventsList, ebabilon.event_categories as categoriesList
        WHERE admin = '".$adminID."' AND categoriesList.id_category = eventsList.category;";
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

  function getFriendCategories(){
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

        $sql = "SELECT * FROM ebabilon.friends_categories;";
        $query_get_user_info = $this->db_connection->query($sql);
        if ($query_get_user_info->num_rows >= 1) {

          return $query_get_user_info;
       }
    }
  }

  function getUserFriends(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userID = $_SESSION["id"];

        $sql = "SELECT id, user_name, email, first_name, last_name, user_image, categoriesList.name as category
        FROM ebabilon.friends as friendsList, ebabilon.users as userList, ebabilon.friends_categories as categoriesList
        WHERE friendsList.id_friend = userList.id AND categoriesList.id_category = friendsList.category AND id_user = '".$userID."';";
        $query_get_user_info = $this->db_connection->query($sql);
        return $query_get_user_info;
    }
  }
}
