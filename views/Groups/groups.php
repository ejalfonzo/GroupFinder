<?php

/**
 * Class Groups
 * handles the user data
 */
class Groups
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
   * you know, when you do "$groups = new Groups();"
   */
  public function __construct()
  {
    if (isset($_POST["createGroup"])) {
        $this->createGroup();
    }
    if (isset($_POST["search"])) {
        $this->searchGroup();
    }
    if (isset($_POST["join"])) {
        $this->joinGroup();
    }
    if (isset($_POST["leave"])) {
        $this->leaveGroup();
    }
    // if (isset($_GET["group"])) {
    //     $this->openGroup();
    // }
  }

  function joinGroup(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userID = $_SESSION["id"];
        $groupID = $this->db_connection->real_escape_string(strip_tags($_POST['join'], ENT_QUOTES));
        // echo("<script>console.log('PHP: getGroupDetails ".json_encode($userID)."');</script>");

        // check if user or email address already exists
        $sql = "INSERT INTO `ebabilon`.`members` (`id_group`, `id_member`)
        SELECT * FROM (SELECT '".$groupID."', '".$userID."') AS tmp
        WHERE NOT EXISTS (SELECT id_group, id_member FROM ebabilon.members
        WHERE id_group = '".$groupID."' AND id_member = '".$userID."') LIMIT 1;";
        $query_get_user_info = $this->db_connection->query($sql);
        // get result row (as an object)
        // echo("<script>console.log('PHP: getGroupDetails ".json_encode($query_get_user_info)."');</script>");
        if($query_get_user_info){
          $joinResult = "Joined Group";
          return json_encode($joinResult);
        }
        // $result_row = $query_get_user_info->fetch_object();
        //
        // return json_encode($result_row);


        // echo '<span class="text-muted">'. $result_row->name .'</span>';
    }
  }

  function leaveGroup(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userID = $_SESSION["id"];
        $groupID = $this->db_connection->real_escape_string(strip_tags($_POST['leave'], ENT_QUOTES));
        // echo("<script>console.log('PHP: getGroupDetails ".json_encode($userID)."');</script>");

        // check if user or email address already exists
        $sql = "DELETE FROM `ebabilon`.`members` WHERE `id_group`='".$groupID."' AND `id_member` = '".$userID."';";
        $query_get_user_info = $this->db_connection->query($sql);
        // get result row (as an object)
        // echo("<script>console.log('PHP: getGroupDetails ".json_encode($query_get_user_info)."');</script>");
        if($query_get_user_info){
          $joinResult = "Group Left";
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
        $groupID = $this->db_connection->real_escape_string(strip_tags($_POST['join'], ENT_QUOTES));
        // echo("<script>console.log('PHP: getGroupDetails ".json_encode($userID)."');</script>");

        // check if user or email address already exists
        $sql = "SELECT * FROM ebabilon.members WHERE id_group = '".$groupID."' AND id_member = '".$userID."';";
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

  function searchGroup(){
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
        FROM ebabilon.groups
        WHERE name like '%".$searchStatement."%';";

        $query_get_user_info = $this->db_connection->query($sql);

        // get result row (as an object)
        if ($query_get_user_info->num_rows >= 1) {
            $arrayResult = array();
          while($row = $query_get_user_info->fetch_object()){
            //   echo(json_encode($row));
            //   return $row;
            $sql2 = "SELECT * FROM ebabilon.members WHERE id_group = '".$row->id_group."' AND id_member = '".$userID."';";
            $query_isMember = $this->db_connection->query($sql2);
            $result_Member = $query_isMember->fetch_object();
            if($result_Member->id_member == $userID){
              $arrayResult[] =  (array('id' => $row->id_group,'name'=> $row->name,
               'category' => $row->category, 'description' => $row->description, 'admin' => $row->admin,
              'image' => $row->group_image, 'isMember' => true));
            }else{
              $arrayResult[] =  (array('id' => $row->id_group,'name'=> $row->name,
               'category' => $row->category, 'description' => $row->description, 'admin' => $row->admin,
              'image' => $row->group_image, 'isMember' => false));
            }

            // echo(''.$row->id_group)
         }
         return json_encode($arrayResult);
       }
        // $result_row = $query_get_user_info->fetch_object();

        // echo '<span class="text-muted">'. $result_row->name .'</span>';
    }
  }

  function getGroup(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userId = $_SESSION["id"];
        $groupID = $_GET["group"];

        // check if user or email address already exists
        $sql = "SELECT * FROM ebabilon.groups WHERE id_group = '".$groupID."';";
        $query_get_user_info = $this->db_connection->query($sql);
        // get result row (as an object)
        $result_row = $query_get_user_info->fetch_object();

        echo '<img src=" '. $result_row->group_image .' " width="100" height="100" class="img-responsive" alt="Generic placeholder thumbnail">';
        echo '<h4>'.$result_row->name.'</h4>';
        // echo '<span class="text-muted">'. $result_row->name .'</span>';
    }
  }

  function getGroupDetails(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userId = $_SESSION["id"];
        $groupID = $_GET["group"];

        // check if user or email address already exists
        $sql = "SELECT groupsList.id_group, groupsList.name, groupsList.category, groupsList.description, groupsList.group_image, id, first_name, last_name
        FROM ebabilon.groups as groupsList, ebabilon.users as userList
        WHERE id_group = '".$groupID."' AND groupsList.admin = userList.id;";
        $query_get_user_info = $this->db_connection->query($sql);
        // get result row (as an object)
        $result_row = $query_get_user_info->fetch_object();
        echo("<script>console.log('PHP: getGroupDetails ".json_encode($result_row)."');</script>");

        echo '<h3 style="text-align:left;">Coordinator:</h3>';
        echo '<h4 style="text-align:left; padding-left:35px;">'.$result_row->first_name ." ".$result_row->last_name.'</h4>';
        echo '<h3 style="text-align:left;">Description:</h3>';
        if(isset($result_row->description)){
          echo '<h4 style="text-align:left; padding-left:35px;">'.$result_row->description.'</h4>';
        }else{
          echo '<h4 style="text-align:left; padding-left:35px;"> No Description </h4>';
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

  function getGroupMembersTable(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userId = $_SESSION["id"];
        $groupID = $_GET["group"];

        $sql = "SELECT id, first_name, last_name, user_image, email
        FROM ebabilon.members, ebabilon.users as userList
        WHERE id_member = userList.id AND id_group = '".$groupID."';";
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

  function createGroup(){
    if (empty($_POST['group_name'])) {
        $this->errors[] = "Empty Username";
        echo("<script>console.log('Error: Empty Group Name');</script>");

    } elseif (strlen($_POST['group_name']) > 64 || strlen($_POST['group_name']) < 2) {
        $this->errors[] = "Username cannot be shorter than 2 or longer than 64 characters";
        echo("<script>console.log('Error: Username to short');</script>");

    } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['group_name'])) {
        $this->errors[] = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
        echo("<script>console.log('Error: Username bad schema');</script>");

    } elseif (!empty($_POST['group_name'])
        && strlen($_POST['group_name']) <= 64
        && strlen($_POST['group_name']) >= 2
        && preg_match('/^[a-z\d]{2,64}$/i', $_POST['group_name'])
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
            $name = $this->db_connection->real_escape_string(strip_tags($_POST['group_name'], ENT_QUOTES));
            $category = $this->db_connection->real_escape_string(strip_tags($_POST['category'], ENT_QUOTES));
            $description = $this->db_connection->real_escape_string(strip_tags($_POST['description'], ENT_QUOTES));

            $sql = "INSERT INTO `ebabilon`.`groups` (`name`, `admin`, `category`, `description`)
            VALUES ('".$name."', '".$userID."', '".$category."', '".$description."');";
            $query_new_user_insert = $this->db_connection->query($sql);

            $group_id = mysqli_insert_id($this->db_connection);
            // echo("<script>console.log('results_row: ".json_encode($group_id)."');</script>");
            // if user has been added successfully
            if ($query_new_user_insert) {
                $this->messages[] = "Your account has been created successfully. You can now log in.";
                echo("<script>console.log('PHP: group created');</script>");

                $sql = "INSERT INTO `ebabilon`.`members` (`id_group`, `id_member`)
                VALUES  (".$group_id.",'".$userID."');";
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

  function getGroupCategories(){
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

        $sql = "SELECT * FROM ebabilon.group_categories;";
        $query_get_user_info = $this->db_connection->query($sql);
        if ($query_get_user_info->num_rows >= 1) {

          return $query_get_user_info;
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

        $sql = "SELECT myGroups.name, myGroups.category, myGroups.id_group, first_name, last_name
        FROM (SELECT groupsList.name, groupsList.category, groupsList.admin, groupsList.id_group
        FROM ebabilon.groups as groupsList, ebabilon.members as memberList
        WHERE groupsList.id_group = memberList.id_group AND memberList.id_member = '" .$userID."') as myGroups, ebabilon.users
        WHERE myGroups.admin = id;";
        $query_get_user_info = $this->db_connection->query($sql);
        return $query_get_user_info;
    }
  }
}
