<?php
class automatedTesting{
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

  public $user1ID = 0;
  
  public $user2ID = 0;

  public $businessID = 0;

  public $eventID = 0;

  public $groupID = 0;

  function runTest(){

        $this->user1ID = 19;
        $this->user2ID = 20;

        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        echo("<script>console.log('Test 1: Adding Friends ');</script>");
        echo("<script>console.log('Adding: id = 20, user_name = jane2 ');</script>");
        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        // Add users as friends
        echo("<script>console.log('Friends before addFriend: ');</script>");
        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        $this->getUserFriends();

        $this->addFriend();
        $this->user1ID = 20;
        $this->user2ID = 19;
        $this->addFriend();

        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        echo("<script>console.log('Friends after addFriend: ');</script>");
        echo("<script>console.log('Expected New Friend: id = 20, user_name = jane2 ');</script>");
        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        $this->user1ID = 19;
        $this->user2ID = 20;
        $this->getUserFriends();

        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        echo("<script>console.log('Test 2: Creating Business ');</script>");
        echo("<script>console.log('Adding: name = BusinessTest, admin = 20, category = 4, address= Somewhere, opHours= Anytime ');</script>");
        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        // Member 2 creates business
        echo("<script>console.log('Businesses before createBusiness: ');</script>");
        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        $this->getBusinesses();

        $_POST['business_name'] = "BusinessTest";
        $_POST['category'] = 4;
        $_POST['address'] = "Somewhere";
        $_POST['opHours'] = "Anytime";
        $this->createBusiness();

        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        echo("<script>console.log('Businesses after createBusiness: ');</script>");
        echo("<script>console.log('Expected New Business: name = BusinessTest, admin = 20, category = 4, address= Somewhere, opHours= Anytime ');</script>");
        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        $this->getBusinesses();

        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        echo("<script>console.log('Test 3: Following Business ');</script>");
        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        // // Member 1 follows business
        $this->getBusinessFollowersTable();
        $this->followBusiness();

        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        echo("<script>console.log('Business Followers after followBusiness: ');</script>");
        echo("<script>console.log('Expected New Follower: id = 19, user_name = JSmith ');</script>");
        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        $this->getBusinessFollowersTable();

        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        echo("<script>console.log('Test 4: Creating Event ');</script>");
        echo("<script>console.log('Adding: name = EventTest, admin = 20, category = 2, place= Somewhere, description= Some description ');</script>");
        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        //Member 2 creates event
        $this->getEvents();
        $_POST['event_name'] = "EventTest";
        $_POST['category'] = 2;
        $_POST['description'] = "Some description";
        $_POST['place'] = "Somewhere";
        $this->createEvent();

        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        echo("<script>console.log('Events after createEvent: ');</script>");
        echo("<script>console.log('Expected New Event: name = EventTest, admin = 20, category = 2, place= Somewhere, description= Some description ');</script>");
        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        $this->getEvents();

        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        echo("<script>console.log('Test 5: Following Event ');</script>");
        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        // Member 1 joins event
        $this->getEventMembersTable();
        $this->joinEvent();

        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        echo("<script>console.log('Event Attendees after joinEvent: ');</script>");
        echo("<script>console.log('Expected New attendee: id = 19, user_name = JSmith ');</script>");
        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        $this->getEventMembersTable();

        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        echo("<script>console.log('Test 6: Creating Group ');</script>");
        echo("<script>console.log('Adding: name = GroupTest, admin = 20, category = 3, description= Some description ');</script>");
        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        // Member 2 creates group
        $this->getGroups();
        $_POST['group_name'] = "GroupTest";
        $_POST['category'] = 3;
        $_POST['description'] = " Some description";
        $this->createGroup();

        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        echo("<script>console.log('Groups after createGroup: ');</script>");
        echo("<script>console.log('Expected New Group: name = GroupTest, admin = 20, category = 3, description= Some description ');</script>");
        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        $this->getGroups();

        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        echo("<script>console.log('Test 7: Following Group ');</script>");
        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        // Member 1 joins group
        $this->getGroupMembersTable();
        $this->joinGroup();

        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        echo("<script>console.log('Group Members after joinGroup: ');</script>");
        echo("<script>console.log('Expected New Member: id = 19, user_name = JSmith ');</script>");
        echo("<script>console.log('-------------------------------------------------------------------------------------------------------------------------------------------------');</script>");
        $this->getGroupMembersTable();
  }

    function getUsers(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if (!$this->db_connection->connect_errno){
			$sql = "SELECT * FROM `ebabilon`.`users`;";
			$result = $this->db_connection->query($sql);
			echo("<script>console.log('Users: ');</script>");
			if($result->num_rows>=1) {
				$num_users = 0;
				while ($row = $result->fetch_object()) {
					echo("<script>console.log('Users Info: ".json_encode($row)."');</script>");
					$num_users++;
				}
				echo("<script>console.log('Total Users: ".$num_users."');</script>");
			}
		}
	}

	function getEvents(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if (!$this->db_connection->connect_errno){
			$sql = "SELECT * FROM `ebabilon`.`events`;";
			$result = $this->db_connection->query($sql);
			echo("<script>console.log('Events: ');</script>");
			if($result->num_rows>=1) {
				$num_events = 0;
				while ($row = $result->fetch_object()) {
					echo("<script>console.log('Event Info: ".json_encode($row)."');</script>");
					$num_events++;
				}
				echo("<script>console.log('Total Events: ".$num_events."');</script>");
			}
		}
	}

	function getGroups(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if (!$this->db_connection->connect_errno){
			$sql = "SELECT * FROM `ebabilon`.`groups`;";
			$result = $this->db_connection->query($sql);
			echo("<script>console.log('Groups: ');</script>");
			if($result->num_rows>=1) {
				$num_groups = 0;
				while ($row = $result->fetch_object()) {
					echo("<script>console.log('Group Info: ".json_encode($row)."');</script>");
					$num_groups++;
				}
				echo("<script>console.log('Total Groups: ".$num_groups."');</script>");
			}
		}
	}

	function getBusinesses(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if (!$this->db_connection->connect_errno){
			$sql = "SELECT * FROM `ebabilon`.`businesses`;";
			$result = $this->db_connection->query($sql);
			echo("<script>console.log('Businesses: ');</script>");
			if($result->num_rows>=1) {
				$num_businesses = 0;
				while ($row = $result->fetch_object()) {
					echo("<script>console.log('Business Info: ".json_encode($row)."');</script>");
					$num_businesses++;
				}
				echo("<script>console.log('Total Businesses: ".$num_businesses."');</script>");
			}
		}
	}

	function createGroup(){
    if (empty($_POST['group_name'])) {
        $this->errors[] = "Empty group_name";
        echo("<script>console.log('Error: Empty Group Name');</script>");

    } elseif (strlen($_POST['group_name']) > 64 || strlen($_POST['group_name']) < 2) {
        $this->errors[] = "group_name cannot be shorter than 2 or longer than 64 characters";
        echo("<script>console.log('Error: group_name to short');</script>");

    } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['group_name'])) {
        $this->errors[] = "group_name does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
        echo("<script>console.log('Error: group_name bad schema');</script>");

    } elseif (!empty($_POST['group_name'])
        && strlen($_POST['group_name']) <= 64
        && strlen($_POST['group_name']) >= 2
        && preg_match('/^[a-z\d]{2,64}$/i', $_POST['group_name'])
    ) {
       //echo("<script>console.log('Good: All Clear');</script>");
        // create a database connection
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // change character set to utf8 and check it
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
            echo("<script>console.log('Error: DB not utf8');</script>");
        }

        // if no connection errors (= working database connection)
        if (!$this->db_connection->connect_errno) {

            $name = $this->db_connection->real_escape_string(strip_tags($_POST['group_name'], ENT_QUOTES));
            $category = $this->db_connection->real_escape_string(strip_tags($_POST['category'], ENT_QUOTES));
            $description = $this->db_connection->real_escape_string(strip_tags($_POST['description'], ENT_QUOTES));

            $sql = "INSERT INTO `ebabilon`.`groups` (`name`, `admin`, `category`, `description`)
            VALUES ('".$name."', '".$this->user2ID."', '".$category."', '".$description."');";
            $query_new_user_insert = $this->db_connection->query($sql);

            $this->groupID = mysqli_insert_id($this->db_connection);
            // if group has been added successfully
            if ($query_new_user_insert) {
                $this->messages[] = "Your account has been created successfully. You can now log in.";
                //echo("<script>console.log('PHP: group created');</script>");

                $sql = "INSERT INTO `ebabilon`.`members` (`id_group`, `id_member`)
                VALUES  (".$this->groupID.",'".$this->user2ID."');";
                $query_new_member_insert = $this->db_connection->query($sql);

                if($query_new_member_insert){
                  //echo("<script>console.log('PHP: Group Added');</script>");
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

  function createEvent(){
    if (empty($_POST['event_name'])) {
        $this->errors[] = "Empty event_name";
        echo("<script>console.log('Error: Empty Event Name');</script>");

    } elseif (strlen($_POST['event_name']) > 64 || strlen($_POST['event_name']) < 2) {
        $this->errors[] = "event_name cannot be shorter than 2 or longer than 64 characters";
        echo("<script>console.log('Error: event_name to short');</script>");

    } elseif (!empty($_POST['event_name'])
        && strlen($_POST['event_name']) <= 64
        && strlen($_POST['event_name']) >= 2
    ) {
        //echo("<script>console.log('Good: All Clear');</script>");
        // create a database connection
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // change character set to utf8 and check it
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
            echo("<script>console.log('Error: DB not utf8');</script>");
        }

        // if no connection errors (= working database connection)
        if (!$this->db_connection->connect_errno) {

            $name = $this->db_connection->real_escape_string(strip_tags($_POST['event_name'], ENT_QUOTES));
            $category = $this->db_connection->real_escape_string(strip_tags($_POST['category'], ENT_QUOTES));
            $description = $this->db_connection->real_escape_string(strip_tags($_POST['description'], ENT_QUOTES));
            $time = $this->db_connection->real_escape_string(strip_tags($_POST['time'], ENT_QUOTES));
            $place = $this->db_connection->real_escape_string(strip_tags($_POST['place'], ENT_QUOTES));

            $sql = "INSERT INTO `ebabilon`.`events` (`name`, `admin`, `category`, `description`, `time`, `place`)
            VALUES ('".$name."', '".$this->user2ID."', '".$category."', '".$description."', '".$time."', '".$place."');";
            $query_new_user_insert = $this->db_connection->query($sql);

            $this->eventID = mysqli_insert_id($this->db_connection);
            // if user has been added successfully
            if ($query_new_user_insert) {
                $this->messages[] = "Your account has been created successfully. You can now log in.";
                //echo("<script>console.log('PHP: event created');</script>");

                $sql = "INSERT INTO `ebabilon`.`attendees` (`id_event`, `id_attendee`)
                VALUES  (".$this->eventID.",'".$this->user2ID."');";
                $query_new_member_insert = $this->db_connection->query($sql);

                if($query_new_member_insert){
                  //echo("<script>console.log('PHP: User Added');</script>");
                }
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

  function createBusiness(){
    if (empty($_POST['business_name'])) {
        $this->errors[] = "Empty business_name";
        echo("<script>console.log('Error: Empty Business Name');</script>");

    } elseif (strlen($_POST['business_name']) > 64 || strlen($_POST['business_name']) < 2) {
        $this->errors[] = "business_name cannot be shorter than 2 or longer than 64 characters";
        echo("<script>console.log('Error: business_name to short');</script>");

    } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['business_name'])) {
        $this->errors[] = "business_name does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
        echo("<script>console.log('Error: business_name bad schema');</script>");

    } elseif (!empty($_POST['business_name'])
        && strlen($_POST['business_name']) <= 64
        && strlen($_POST['business_name']) >= 2
        && preg_match('/^[a-z\d]{2,64}$/i', $_POST['business_name'])
    ) {
       // echo("<script>console.log('Good: All Clear');</script>");
        // create a database connection
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // change character set to utf8 and check it
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
            echo("<script>console.log('Error: DB not utf8');</script>");
        }

        // if no connection errors (= working database connection)
        if (!$this->db_connection->connect_errno) {

            $name = $this->db_connection->real_escape_string(strip_tags($_POST['business_name'], ENT_QUOTES));
            $category = $this->db_connection->real_escape_string(strip_tags($_POST['category'], ENT_QUOTES));
            $address = $this->db_connection->real_escape_string(strip_tags($_POST['address'], ENT_QUOTES));
            $opHours = $this->db_connection->real_escape_string(strip_tags($_POST['opHours'], ENT_QUOTES));

            //echo("<script>console.log('PHP Insert: ".json_encode($_POST)."');</script>");

            $sql = "INSERT INTO `ebabilon`.`businesses` (`name`, `address`, `opHours`, `admin`, `category`) 
            VALUES ('".$name."', '".$address."', '".$opHours."', '".$this->user2ID."', '".$category."');";
            $query_new_business_insert = $this->db_connection->query($sql);
           // echo("<script>console.log('query: ".json_encode($query_new_business_insert)."');</script>");

            $this->businessID = mysqli_insert_id($this->db_connection);
            // if user has been added successfully
            if ($query_new_business_insert) {
                $this->messages[] = "Your account has been created successfully. You can now log in.";
                //echo("<script>console.log('PHP: business created');</script>");

                $sql = "INSERT INTO `ebabilon`.`followers` (`id_business`, `id_follower`)
                VALUES ('".$this->businessID."', '".$this->user2ID."');";
                $query_new_follower_insert = $this->db_connection->query($sql);

                if($query_new_follower_insert){
                  //echo("<script>console.log('PHP: Business Added');</script>");
                }
                //echo("<script>console.log('PHP Insert: ".json_encode($query_new_business_insert)."');</script>");
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


	function addFriend(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        $sql = "INSERT INTO `ebabilon`.`friends` (`id_friend`, `id_user`)
        SELECT * FROM (SELECT '".$this->user2ID."', '".$this->user1ID."') AS tmp
        WHERE NOT EXISTS (SELECT id_friend, id_user FROM ebabilon.friends
        WHERE id_friend = '".$this->user2ID."' AND id_user = '".$this->user1ID."') LIMIT 1;";
        $query_get_user_info_2 = $this->db_connection->query($sql);
        
        $sql = "INSERT INTO `ebabilon`.`friends` (`id_friend`, `id_user`)
        SELECT * FROM (SELECT '".$this->user1ID."', '".$this->user2ID."') AS tmp
        WHERE NOT EXISTS (SELECT id_friend, id_user FROM ebabilon.friends
        WHERE id_friend = '".$this->user1ID."' AND id_user = '".$this->user2ID."') LIMIT 1;";
        $query_get_user_info = $this->db_connection->query($sql);

        if($query_get_user_info && $query_get_user_info_2){
          //echo("<script>console.log('Added Friend');</script>");
        }
    }
  }

  function joinGroup(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        $sql = "INSERT INTO `ebabilon`.`members` (`id_group`, `id_member`)
        SELECT * FROM (SELECT '".$this->groupID."', '".$this->user1ID."') AS tmp
        WHERE NOT EXISTS (SELECT id_group, id_member FROM ebabilon.members
        WHERE id_group = '".$this->groupID."' AND id_member = '".$this->user1ID."') LIMIT 1;";
        $query_get_user_info = $this->db_connection->query($sql);
        // get result row (as an object)
        // echo("<script>console.log('PHP: getGroupDetails ".json_encode($query_get_user_info)."');</script>");
        if($query_get_user_info){
          //echo("<script>console.log('Joined Group');</script>");
        }
    }
  }

  function joinEvent(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {

        $sql = "INSERT INTO `ebabilon`.`attendees` (`id_event`, `id_attendee`)
        SELECT * FROM (SELECT '".$this->eventID."', '".$this->user1ID."') AS tmp
        WHERE NOT EXISTS (SELECT id_event, id_attendee FROM ebabilon.attendees
        WHERE id_event = '".$this->eventID."' AND id_attendee = '".$this->user1ID."') LIMIT 1;";
        $query_get_user_info = $this->db_connection->query($sql);

        if($query_get_user_info){
          //echo("<script>console.log('Joined Event');</script>");
        }
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

        $sql = "INSERT INTO `ebabilon`.`followers` (`id_business`, `id_follower`)
        SELECT * FROM (SELECT '".$this->businessID."', '".$this->user1ID."') AS tmp
        WHERE NOT EXISTS (SELECT id_business, id_follower FROM ebabilon.followers
        WHERE id_business = '".$this->businessID."' AND id_follower = '".$this->user1ID."') LIMIT 1;";
        $query_get_user_info = $this->db_connection->query($sql);

        if($query_get_user_info){
          //echo("<script>console.log('Followed Business');</script>");
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
    	$sql = "SELECT id, user_name, email, first_name, last_name, user_image, categoriesList.name as category
            FROM ebabilon.friends as friendsList, ebabilon.users as userList, ebabilon.friends_categories as categoriesList
            WHERE friendsList.id_friend = userList.id AND categoriesList.id_category = friendsList.category AND id_user = '".$this->user1ID."';";
        $result = $this->db_connection->query($sql);
    	echo("<script>console.log('User1 Friends: ');</script>");
    	if($result->num_rows>=1) {
    		$num_friends = 0;
    		while ($row = $result->fetch_object()) {
    			echo("<script>console.log('User Friend Info: ".json_encode($row)."');</script>");
    			$num_friends++;
    		}
    		echo("<script>console.log('Total Friends: ".$num_friends."');</script>");
    	}
        else{
            echo("<script>console.log('Total Friends: 0');</script>");
        }
    }
  }

  function getBusinessFollowersTable(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$this->db_connection->set_charset("utf8")) {
        $this->errors[] = $this->db_connection->error;
        echo("<script>console.log('Error: DB not utf8');</script>");
    }
    if (!$this->db_connection->connect_errno) {
        $sql = "SELECT id, first_name, last_name, user_image, email
            FROM ebabilon.followers, ebabilon.users as userList
            WHERE id_follower = userList.id AND id_business = '".$this->businessID."'";
        $result = $this->db_connection->query($sql);
        echo("<script>console.log('Business Followers: ');</script>");
    	if($result->num_rows>=1) {
    		$num_followers = 0;
    		while ($row = $result->fetch_object()) {
    			echo("<script>console.log('Business Follower Info: ".json_encode($row)."');</script>");
    			$num_followers++;
    		}
    		echo("<script>console.log('Total Business Followers: ".$num_followers."');</script>");
    	}
        else{
            echo("<script>console.log('Total Business Followers: 0');</script>");
        }
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
        $sql = "SELECT id, first_name, last_name, user_image, email
            FROM ebabilon.attendees, ebabilon.users as userList
            WHERE id_attendee = userList.id AND id_event = '".$this->eventID."';";
        $result = $this->db_connection->query($sql);
        echo("<script>console.log('Event Members: ');</script>");
    	if($result->num_rows>=1) {
    		$num_members = 0;
    		while ($row = $result->fetch_object()) {
    			echo("<script>console.log('Event Member Info: ".json_encode($row)."');</script>");
    			$num_members++;
    		}
    		echo("<script>console.log('Total Event Members: ".$num_members."');</script>");
    	}
        else{
            echo("<script>console.log('Total Event Members: 0');</script>");
        }
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
      	$sql = "SELECT id, first_name, last_name, user_image, email
            FROM ebabilon.members, ebabilon.users as userList
            WHERE id_member = userList.id AND id_group = '".$this->groupID."';";
        $result = $this->db_connection->query($sql);
        echo("<script>console.log('Group Members: ');</script>");
    	if($result->num_rows>=1) {
    		$num_members = 0;
    		while ($row = $result->fetch_object()) {
    			echo("<script>console.log('Group Member Info: ".json_encode($row)."');</script>");
    			$num_members++;
    		}
    		echo("<script>console.log('Total Group Members: ".$num_members."');</script>");
    	}
        else{
            echo("<script>console.log('Total Group Members: 0');</script>");
        }
    }
  }

  function deleteUsers(){
  	$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if (!$this->db_connection->connect_errno){

			$sql = "DELETE FROM `ebabilon`.`users` WHERE `id`='19';";
			$result = $this->db_connection->query($sql);
            $sql2 = "DELETE FROM `ebabilon`.`users` WHERE `id`='20';";
            $result2 = $this->db_connection->query($sql2);

            if($result && $result2){
                //echo("<script>console.log('User Deleted: ');</script>");
            }
		}
  }

  function resetTest(){
    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if (!$this->db_connection->connect_errno){
            $sql = "INSERT INTO `ebabilon`.`users` (`id`, `user_name`, `email`, `salt`, `password`, `first_name`, `last_name`, `user_image`, `isAdmin`, `optOutEmail`) 
            VALUES ('19', 'JSmith', 'john@smith.com', '0', '$2y$10$FMCgD5rgip88rR.83aJOsOPGnQirD0dLnscEZ5KT1qKBP/QRtZPBG', 'John', 'Smith', '/images/stock/default-user.png', '0', '0');";
            $result = $this->db_connection->query($sql);
            $sql2 = "INSERT INTO `ebabilon`.`users` (`id`, `user_name`, `email`, `salt`, `password`, `first_name`, `last_name`, `user_image`, `isAdmin`, `optOutEmail`) 
            VALUES ('20', 'jane2', 'jane@smith.com', '0', '$2y$10$qFW3Y5yzykJocsxwyzbSEu0ZNQZp5ycE66n.ZMUVj9DUcFN7F4M1K', 'Jane', 'Smith', '/images/stock/default-user.png', '0', '0');";
            $result2 = $this->db_connection->query($sql2);
            
        }
  }
}
?>