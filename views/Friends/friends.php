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
    // if (isset($_GET["friend"])) {
    //     $this->openFriend();
    // }
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
        $sql2 = "INSERT INTO `ebabilon`.`friends` (`id_friend`, `id_user`)
        SELECT * FROM (SELECT '".$userID."', '".$friendID."') AS tmp
        WHERE NOT EXISTS (SELECT id_friend, id_user FROM ebabilon.friends
        WHERE id_friend = '".$userID."' AND id_user = '".$friendID."') LIMIT 1;";
        $query_get_user_info = $this->db_connection->query($sql2);
        // get result row (as an object)
        // echo("<script>console.log('PHP: getGroupDetails ".json_encode($query_get_user_info)."');</script>");
        if($query_get_user_info && $query_get_user_info_2){
          $addResult = "Added Friend";
          return json_encode($addResult);
        }
        // $result_row = $query_get_user_info->fetch_object();
        //
        // return json_encode($result_row);


        // echo '<span class="text-muted">'. $result_row->name .'</span>';
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
        $sql = "DELETE FROM `ebabilon`.`friends` WHERE `id_friend`='".$friendID."' AND `id_user` = '".$userID."';";
        $query_get_user_info = $this->db_connection->query($sql);
        $sql2 = "DELETE FROM `ebabilon`.`friends` WHERE `id_friend`='".$userID."' AND `id_user` = '".$friendID."';";
        $query_get_user_info_2 = $this->db_connection->query($sql2);
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
        FROM ebabilon.friends
        WHERE name like '%".$searchStatement."%';";

        $query_get_user_info = $this->db_connection->query($sql);

        // get result row (as an object)
        if ($query_get_user_info->num_rows >= 1) {
            $arrayResult = array();
          while($row = $query_get_user_info->fetch_object()){
            //   echo(json_encode($row));
            //   return $row;
            $sql2 = "SELECT * FROM ebabilon.friends as friendsList, ebabilon.users as userList
            WHERE friendsList.id_user = userList.id
            AND friendsList.id_friend = '".$row->id_friend."'
            AND userList.id = '".$userID."';";
            $query_isFriend = $this->db_connection->query($sql2);
            $result_Friend = $query_isFriend->fetch_object();
            if($result_Friend->id_friend == $userID){
              $arrayResult[] =  (array('id' => $row->id_friend,'name'=> $row->name,
               'email' => $row->email, 'image' => $row->friend_image, 'isFriend' => true));
            }else{
              $arrayResult[] =  (array('id' => $row->id_friend,'name'=> $row->name,
               'email' => $row->email, 'image' => $row->friend_image, 'isFriend' => false));
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
        $sql = "SELECT * FROM ebabilon.friends as friendsList, ebabilon.users as userList
        WHERE friendsList.id_user = userList.id AND friendsList.id_friend = '".$friendID."';";
        $query_get_user_info = $this->db_connection->query($sql);
        // get result row (as an object)
        $result_row = $query_get_user_info->fetch_object();

        echo '<img src=" '. $result_row->user_image .' " width="100" height="100" class="img-responsive" alt="Generic placeholder thumbnail">';
        echo '<h4>'.$result_row->name.'</h4>';
        echo '<h4>'.$result_row->email.'</h4>';
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
        $sql = "SELECT friendsList.id_friend, friendsList.name, friendsList.category, friendsList.friend_email, friendsList.friend_image, id, first_name, last_name
        FROM ebabilon.friends as friendsList, ebabilon.users as userList
        WHERE firendsList.id_friend = '".$friendID."' AND firendsList.id_user = userList.id;";
        $query_get_user_info = $this->db_connection->query($sql);
        // get result row (as an object)
        $result_row = $query_get_user_info->fetch_object();
        echo("<script>console.log('PHP: getFriendDetails ".json_encode($result_row)."');</script>");

        echo '<h3 style="text-align:left;">Friend:</h3>';
        echo '<h4 style="text-align:left; padding-left:35px;">'.$result_row->first_name ." ".$result_row->last_name.'</h4>';
        echo '<h3 style="text-align:left;">Email:</h3>';
        if(isset($result_row->email)){
          echo '<h4 style="text-align:left; padding-left:35px;">'.$result_row->email.'</h4>';
        }else{
          echo '<h4 style="text-align:left; padding-left:35px;"> No Email </h4>';
        }
        echo '<h3 style="text-align:left;">Category:</h3>';
        if(isset($result_row->category)){
          echo '<h4 style="text-align:left; padding-left:35px;">'.$result_row->category.'</h4>';
        }else{
          echo '<h4 style="text-align:left; padding-left:35px;"> No Category </h4>';
        }
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
        $friendID = $_GET["friend"];

        $sql = "SELECT *
        FROM ebabilon.friends as friendsList, ebabilon.users as userList
        WHERE friendsList.id_user = userList.id AND id_friend = '".$friendID."';";
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

        $sql = "SELECT * FROM ebabilon.friend_categories;";
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
