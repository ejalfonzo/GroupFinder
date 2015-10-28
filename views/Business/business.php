<?php

/**
 * Class Groups
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
   * you know, when you do "$groups = new Groups();"
   */
  public function __construct()
  {
    if (isset($_POST["createBusiness"])) {
        $this->createBusiness();
    }
    if (isset($_GET["business"])) {
        $this->openBusiness();
    }
    if (isset($_POST["followBusiness"])) {
        $this->followBusiness();
    }
    if (isset($_POST["leaveBusiness"])) {
        $this->leaveBusiness();
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

        return json_encode($result_row);
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
        $groupID = $_GET["group"];

        // check if user or email address already exists
        $sql = "SELECT businessList.name, catList.name as category, businessList.address, businessList.opHours, id, first_name, last_name
        FROM ebabilon.businesses as businessList, ebabilon.users as userList, ebabilon.business_categories as catList
        WHERE id_business = '".$businessID."' AND businessList.admin = userList.id AND catList.id_category = businessList.category;";
        $query_get_user_info = $this->db_connection->query($sql);
        // get result row (as an object)
        $result_row = $query_get_user_info->fetch_object();


        return json_encode($result_row);
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
        $groupID = $_GET["group"];

        $sql = "SELECT id, first_name, last_name, user_image, email
        FROM ebabilon.followers, ebabilon.users as userList
        WHERE id_follower = userList.id AND id_business = '".$businessID."'";
        $query_get_user_info = $this->db_connection->query($sql);
        
        return $query_get_user_info;
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
            $userID = $_SESSION["id"];
            $name = $this->db_connection->real_escape_string(strip_tags($_POST['business_name'], ENT_QUOTES));
            $category = $this->db_connection->real_escape_string(strip_tags($_POST['category'], ENT_QUOTES));
            $address = $this->db_connection->real_escape_string(strip_tags($_POST['address'], ENT_QUOTES));
            $opHours = $this->db_connection->real_escape_string(strip_tags($_POST['opHours'], ENT_QUOTES));

            $sql = "INSERT INTO `ebabilon`.`businesses` (`name`, `address`, `opHours`, `admin`, `category`) 
            VALUES ('".$name."', '".$address."', '".$opHours."', '".$userID."', '".$category."');"
            $query_new_user_insert = $this->db_connection->query($sql);

            $business_id = mysqli_insert_id($this->db_connection);
            // echo("<script>console.log('results_row: ".json_encode($group_id)."');</script>");
            // if user has been added successfully
            if ($query_new_user_insert) {
                $this->messages[] = "Your account has been created successfully. You can now log in.";
                echo("<script>console.log('PHP: business created');</script>");

                $sql = "INSERT INTO `ebabilon`.`followers` (`id_business`, `id_follower`)
                VALUES ('".$business_id."', '".$userID."');";
                $query_new_member_insert = $this->db_connection->query($sql);

                if($query_new_member_insert){
                  echo("<script>console.log('PHP: Business Added');</script>");
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

        $sql = "SELECT myBusinesses.name, catList.name as category, myBusinesses.id_business, first_name, last_name
        FROM (SELECT businessList.name, businessList.category, businessList.admin, businessList.id_business
          FROM ebabilon.businesses as businessList, ebabilon.followers as followerList
          WHERE businessList.id_business = followerList.id_business AND followerList.id_follower = '" .$userID."') as myBusinesses, ebabilon.users, ebabilon.business_categories as catList
        WHERE myBusinesses.admin = id AND catList.id_category = myBusinesses.category;";
        $query_get_user_info = $this->db_connection->query($sql);
        
        return $query_get_user_info;
    }
  }

  function leaveBusiness(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno){
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userID = $_SESSION["id"];
        $businessID = $_GET["business"];

        $sql = "DELETE FROM `ebabilon`.`followers` WHERE `id_business`='".$businessID."' AND `id_follower` = '".$userID."';";
    }
  }

  function followBusiness(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno){
        // escaping, additionally removing everything that could be (html/javascript-) code
        $userID = $_SESSION["id"];
        $businessID = $_GET["business"];

        $sql = "INSERT INTO `ebabilon`.`followers` (`id_business`, `id_follower`)
        SELECT * FROM (SELECT '".$businessID."', '".$userID."') AS tmp
        WHERE NOT EXISTS (SELECT id_business, id_follower FROM ebabilon.followers WHERE id_business = '".$businessID."' AND id_follower = '".$userID."') LIMIT 1;";
    }
  }
}
