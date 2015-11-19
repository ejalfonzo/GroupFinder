<?php

/**
 * Class Business
 * handles the user data
 */
class Business
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
   * you know, when you do "$business = new Business();"
   */
  public function __construct()
  {
    if (isset($_POST["createBusiness"])) {
        $this->createBusiness();
    }
    if (isset($_POST["search"])) {
        $this->searchBusinesses();
    }
    if (isset($_POST["follow"])) {
        $this->followBusiness();
    }
    if (isset($_POST["unfollow"])) {
        $this->unfollowBusiness();
    }
    if (isset($_POST["editBusiness"])) {
        $this->editBusiness();
    }
    // if (isset($_GET["gbusiness"])) {
    //     $this->openBusiness();
    // }
  }

  function editBusiness(){
    if (empty($_POST['business_name'])) {
        $this->errors[] = "Empty Name";
        echo("<script>console.log('Error: Empty Business Name');</script>");

    } elseif (strlen($_POST['business_name']) > 64 || strlen($_POST['business_name']) < 2) {
        $this->errors[] = "Name cannot be shorter than 2 or longer than 64 characters";
        echo("<script>console.log('Error: Name to short');</script>");

    } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['business_name'])) {
        $this->errors[] = "Name does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
        echo("<script>console.log('Error: Name bad schema');</script>");

    } elseif (!empty($_POST['business_name'])
        && strlen($_POST['business_name']) <= 64
        && strlen($_POST['business_name']) >= 2
        && preg_match('/^[a-z\d]{2,64}$/i', $_POST['business_name'])
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
            // 
            $userID = $_SESSION["id"];
            $businessID = $_GET["business"];
            $name = $this->db_connection->real_escape_string(strip_tags($_POST['business_name'], ENT_QUOTES));
            $category = $this->db_connection->real_escape_string(strip_tags($_POST['category'], ENT_QUOTES));
            $address = $this->db_connection->real_escape_string(strip_tags($_POST['address'], ENT_QUOTES));
            $opHours = $this->db_connection->real_escape_string(strip_tags($_POST['opHours'], ENT_QUOTES));

            $sql = "UPDATE `ebabilon`.`businesses` 
            SET name='".$name."', address='".$address."', opHours='".$opHours."', category='".$category."'
            WHERE id_business = '".$businessID."';";
            $query_edit_business = $this->db_connection->query($sql);
            echo("<script>console.log('query: ".json_encode($query_edit_business)."');</script>");

            if ($query_edit_business) {
                $this->messages[] = "Your account has been created successfully. You can now log in.";
                echo("<script>console.log('PHP: business edited');</script>");
                
                echo("<script>console.log('PHP Insert: ".json_encode($query_edit_business)."');</script>");
                $editResult = "Edited Business";
                return json_encode($editResult);
            } else {
                $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                echo("<script>console.log('PHP: ERROR Editing Business');</script>");
            }
        } else {
            $this->errors[] = "Sorry, no database connection.";
        }
    } else {
        $this->errors[] = "An unknown error occurred.";
    }
  }

  function followBusiness(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userID = $_SESSION["id"];
        $businessID = $this->db_connection->real_escape_string(strip_tags($_POST['follow'], ENT_QUOTES));
        // echo("<script>console.log('PHP: getGroupDetails ".json_encode($userID)."');</script>");

        // check if user or email address already exists
        $sql = "INSERT INTO `ebabilon`.`followers` (`id_business`, `id_follower`)
        SELECT * FROM (SELECT '".$businessID."', '".$userID."') AS tmp
        WHERE NOT EXISTS (SELECT id_business, id_follower FROM ebabilon.followers
        WHERE id_business = '".$businessID."' AND id_follower = '".$userID."') LIMIT 1;";
        $query_get_user_info = $this->db_connection->query($sql);
        // get result row (as an object)
        // echo("<script>console.log('PHP: getGroupDetails ".json_encode($query_get_user_info)."');</script>");
        if($query_get_user_info){
          $followResult = "Followed Business";
          return json_encode($followResult);
        }
        // $result_row = $query_get_user_info->fetch_object();
        //
        // return json_encode($result_row);


        // echo '<span class="text-muted">'. $result_row->name .'</span>';
    }
  }

  function unfollowBusiness(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userID = $_SESSION["id"];
        $businessID = $this->db_connection->real_escape_string(strip_tags($_POST['unfollow'], ENT_QUOTES));
        // echo("<script>console.log('PHP: getGroupDetails ".json_encode($userID)."');</script>");

        // check if user or email address already exists
        $sql = "DELETE FROM `ebabilon`.`followers` WHERE `id_business`='".$businessID."' AND `id_follower` = '".$userID."';";
        $query_get_user_info = $this->db_connection->query($sql);

        if($query_get_user_info){
          $joinResult = "Business Unfollowed";
          return json_encode($joinResult);
        }
    }
  }

  function isFollower(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userID = $_SESSION["id"];
        $business = $this->db_connection->real_escape_string(strip_tags($_POST['follow'], ENT_QUOTES));
        // echo("<script>console.log('PHP: getGroupDetails ".json_encode($userID)."');</script>");

        // check if user or email address already exists
        $sql = "SELECT * FROM ebabilon.followers WHERE id_business = '".$business."' AND id_follower = '".$userID."';";
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

  function searchBusinesses(){
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
        FROM ebabilon.businesses
        WHERE name like '%".$searchStatement."%';";

        $query_get_user_info = $this->db_connection->query($sql);

        // get result row (as an object)
        if ($query_get_user_info->num_rows >= 1) {
            $arrayResult = array();
          while($row = $query_get_user_info->fetch_object()){
            //   echo(json_encode($row));
            //   return $row;
            $sql2 = "SELECT * FROM ebabilon.followers WHERE id_business = '".$row->id_business."' AND id_follower = '".$userID."';";
            $query_isFollower = $this->db_connection->query($sql2);
            $result_Follower = $query_isFollower->fetch_object();
            if($result_Follower->id_follower == $userID){
              $arrayResult[] =  (array('id' => $row->id_business,'name'=> $row->name,
               'category' => $row->category, 'address' => $row->address, 'opHours' => $row->opHours, 'admin' => $row->admin,
              'isFollower' => true));
            }else{
              $arrayResult[] =  (array('id' => $row->id_group,'name'=> $row->name,
               'category' => $row->category, 'address' => $row->address, 'opHours' => $row->opHours, 'admin' => $row->admin,
              'isFollower' => false));
            }

            // echo(''.$row->id_group)
         }
         return json_encode($arrayResult);
       }
        // $result_row = $query_get_user_info->fetch_object();

        // echo '<span class="text-muted">'. $result_row->name .'</span>';
    }
  }

  function getBusiness(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userId = $_SESSION["id"];
        $businessID = $_GET["business"];

        // check if user or email address already exists
        $sql = "SELECT * FROM ebabilon.businesses WHERE id_business = '".$businessID."';";
        $query_get_user_info = $this->db_connection->query($sql);
        // get result row (as an object)
        $result_row = $query_get_user_info->fetch_object();

        return $result_row->name;
    }
  }

  function getBusinessDetails(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userId = $_SESSION["id"];
        $businessID = $_GET["business"];

        // check if user or email address already exists
        $sql = "SELECT businessList.name, catList.name as category, businessList.address, businessList.opHours, id, first_name, last_name, category as catId
        FROM ebabilon.businesses as businessList, ebabilon.users as userList, ebabilon.business_categories as catList
        WHERE id_business = '".$businessID."' AND businessList.admin = userList.id AND catList.id_category = businessList.category;";
        $query_get_user_info = $this->db_connection->query($sql);

        // get result row (as an object)
        return $query_get_user_info;
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

  function getFollowersTable(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userId = $_SESSION["id"];
        $businessID = $_GET["business"];

        $sql = "SELECT id, first_name, last_name, user_image, email
        FROM ebabilon.followers, ebabilon.users as userList
        WHERE id_follower = userList.id AND id_business = '".$businessID."'";
        $query_get_business_followers = $this->db_connection->query($sql);        
        return $query_get_business_followers;
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

  function createBusiness(){
    if (empty($_POST['business_name'])) {
        $this->errors[] = "Empty Username";
        echo("<script>console.log('Error: Empty Group Name');</script>");

    } elseif (strlen($_POST['business_name']) > 64 || strlen($_POST['business_name']) < 2) {
        $this->errors[] = "Username cannot be shorter than 2 or longer than 64 characters";
        echo("<script>console.log('Error: Username to short');</script>");

    } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['business_name'])) {
        $this->errors[] = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
        echo("<script>console.log('Error: Username bad schema');</script>");

    } elseif (!empty($_POST['business_name'])
        && strlen($_POST['business_name']) <= 64
        && strlen($_POST['business_name']) >= 2
        && preg_match('/^[a-z\d]{2,64}$/i', $_POST['business_name'])
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
            // 
            $userID = $_SESSION["id"];
            $name = $this->db_connection->real_escape_string(strip_tags($_POST['business_name'], ENT_QUOTES));
            $category = $this->db_connection->real_escape_string(strip_tags($_POST['category'], ENT_QUOTES));
            $address = $this->db_connection->real_escape_string(strip_tags($_POST['address'], ENT_QUOTES));
            $opHours = $this->db_connection->real_escape_string(strip_tags($_POST['opHours'], ENT_QUOTES));

            echo("<script>console.log('PHP Insert: ".json_encode($_POST)."');</script>");

            $sql = "INSERT INTO `ebabilon`.`businesses` (`name`, `address`, `opHours`, `admin`, `category`) 
            VALUES ('".$name."', '".$address."', '".$opHours."', '".$userID."', '".$category."');";
            $query_new_business_insert = $this->db_connection->query($sql);
            echo("<script>console.log('query: ".json_encode($query_new_business_insert)."');</script>");

            $business_id = mysqli_insert_id($this->db_connection);
            echo("<script>console.log('business_id: ".$business_id."');</script>");
            // echo("<script>console.log('results_row: ".json_encode($group_id)."');</script>");
            // if user has been added successfully
            if ($query_new_business_insert) {
                $this->messages[] = "Your account has been created successfully. You can now log in.";
                echo("<script>console.log('PHP: business created');</script>");

                $sql = "INSERT INTO `ebabilon`.`followers` (`id_business`, `id_follower`)
                VALUES ('".$business_id."', '".$userID."');";
                $query_new_follower_insert = $this->db_connection->query($sql);

                if($query_new_follower_insert){
                  echo("<script>console.log('PHP: Business Added');</script>");
                }
                echo("<script>console.log('PHP Insert: ".json_encode($query_new_business_insert)."');</script>");
            } else {
                $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                echo("<script>console.log('PHP: ERROR Creating Business');</script>");
            }
        } else {
            $this->errors[] = "Sorry, no database connection.";
        }
    } else {
        $this->errors[] = "An unknown error occurred.";
    }
  }

  function getBusinessCategories(){
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

        $sql = "SELECT * FROM ebabilon.business_categories;";
        $query_get_user_info = $this->db_connection->query($sql);

        return $query_get_user_info;
    }
  }

  function getMyBusinesses(){
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

        echo("<script>console.log('userID: ".$userID."');</script>");

        $sql = "SELECT myBusinesses.name, catList.name as category, myBusinesses.id_business, first_name, last_name
        FROM (SELECT businessList.name, businessList.category, businessList.admin, businessList.id_business
          FROM ebabilon.businesses as businessList, ebabilon.followers as followerList
          WHERE businessList.id_business = followerList.id_business AND followerList.id_follower = '" .$userID."') as myBusinesses, ebabilon.users, ebabilon.business_categories as catList
        WHERE myBusinesses.admin = id AND catList.id_category = myBusinesses.category;";
        $query_get_my_businesses = $this->db_connection->query($sql);
        
        return $query_get_my_businesses;
    }
  }
}
