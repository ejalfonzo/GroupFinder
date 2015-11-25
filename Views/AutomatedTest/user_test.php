<?php
// include the configs / constants for the database connection
require_once("../../config/db.php");
require_once("../Business/Business.php");
$business = new Business();
require_once("../Events/Events.php");
$events = new Events();
require_once("../Friends/Friends.php");
$friends = new Friends();
require_once("../Groups/Groups.php");
$groups = new Groups();
require_once("../../classes/Registration.php");
$registration = new Registration();



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
				echo("<script>console.log('Total Users: ".$num_events."');</script>");
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

  function getUserFriends(){
	$result = $friends->getUserFriends();
	echo("<script>console.log('User Friends: ');</script>");
	if($result->num_rows>=1) {
		$num_friends = 0;
		while ($row = $result->fetch_object()) {
			echo("<script>console.log('User Friend Info: ".json_encode($row)."');</script>");
			$num_friends++;
		}
		echo("<script>console.log('Total Friends: ".$num_friends."');</script>");
	}
  }

  function getBusinessFollowersTable(){
    $result = $business->getFollowersTable();
    echo("<script>console.log('Business Followers: ');</script>");
	if($result->num_rows>=1) {
		$num_followers = 0;
		while ($row = $result->fetch_object()) {
			echo("<script>console.log('Business Follower Info: ".json_encode($row)."');</script>");
			$num_followers++;
		}
		echo("<script>console.log('Total Business Followers: ".$num_followers."');</script>");
	}
  }

  function getEventMembersTable(){
    $result = $events->getEventMembersTable();
    echo("<script>console.log('Event Members: ');</script>");
	if($result->num_rows>=1) {
		$num_members = 0;
		while ($row = $result->fetch_object()) {
			echo("<script>console.log('Event Member Info: ".json_encode($row)."');</script>");
			$num_members++;
		}
		echo("<script>console.log('Total Event Members: ".$num_members."');</script>");
	}
  }

  function getGroupMembersTable(){
  	$result = $groups->getGroupMembersTable();
    echo("<script>console.log('Group Members: ');</script>");
	if($result->num_rows>=1) {
		$num_members = 0;
		while ($row = $result->fetch_object()) {
			echo("<script>console.log('Group Member Info: ".json_encode($row)."');</script>");
			$num_members++;
		}
		echo("<script>console.log('Total Group Members: ".$num_members."');</script>");
	}
  }

  function deleteUser(){
  	$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if (!$this->db_connection->connect_errno){
			$userID = $this->db_connection->real_escape_string(strip_tags($_POST['deleteUser'], ENT_QUOTES));

			$sql = "DELETE FROM `ebabilon`.`users`
			WHERE id_user = '".$userID."';";
			$result = $this->db_connection->query($sql);
			echo("<script>console.log('User Deleted: ');</script>");
		}
  }
}

?>
<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/css/roboto.css"/>
    <link rel="stylesheet" type="text/css" href="/css/material.css"/>
    <link rel="stylesheet" type="text/css" href="/css/ripples.css"/>
    <link rel="stylesheet" type="text/css" href="/css/dashboard.css"/>
    <!-- <link rel="stylesheet" type="text/css" href="/css/selectize.css"/> -->
    <!-- <link rel="stylesheet" type="text/css" href="/css/timeline-style.css"/> -->
    <!-- <link rel="stylesheet" type="text/css" href="/css/reset.css"/> -->
    <!-- <link rel="icon" href="/images/logo.ico"> -->
    <script type="text/javascript" src="/js/jquery.js"></script>

	<title>Group Finder</title>
</head>
<body>
	<div class="panel panel-primary">
	    <div>
	    	<h1>Automated Tests</h1>

	    	<button></button>
	    	<h3>User being created:</h3>
	    	<h4>Name: John Smith</h4>
	    	<h4>Email: john@smith.com</h4>
	    	<?php
	    	$automatedTesting = new automatedTesting();

	    	$user_1_ID = 19;
	    	$user_2_ID = 20;

	    	// Add new user
	    	$_POST['user_name'] = "john";
		    $_POST['user_email'] = "john@smith.com";
		   	$_POST['first_name'] = "John";
		   	$_POST['last_name'] = "Smith";
		   	$_POST['user_password_new'] = "testing";
		   	$_POST['user_password_repeat'] = "testing";
	    	$registration->registerNewUser();


	    	$automatedTesting->getUsers();

	    	// Add another new user
	    	$_POST['user_name'] = "jane2";
		    $_POST['user_email'] = "jane@smith.com";
		   	$_POST['first_name'] = "Jane";
		   	$_POST['last_name'] = "Smith";
		   	$_POST['user_password_new'] = "testing";
		   	$_POST['user_password_repeat'] = "testing";
	    	$registration->registerNewUser();

	    	$automatedTesting->getUsers();

	    	// Add users as friends
	    	$_SESSION["id"] = $user_1_ID;
	    	$_POST['addFriend'] = $user_2_ID;
	    	$friends->addFriend();
	    	$temp = $_POST['addFriend'];
	    	$_POST['addFriend'] = $_SESSION["id"];
	    	$_SESSION["id"] = $temp;
	    	$friends->addFriend();
	    	$automatedTesting->getUsers();


	    	$automatedTesting->getBusinesses();
	    	// Member 2 creates business
	    	$_POST['business_name'] = "BusinessTest";
	    	$_POST['category'] = 4;
	    	$_POST['address'] = "Somewhere";
	    	$_POST['opHours'] = "Anytime";
	    	$business->createBusiness();
	    	$automatedTesting->getBusinesses();


	    	$automatedTesting->getBusinessFollowersTable();
	    	
	    	// Member 1 follows business
	    	$_POST['business'] = 12;
	    	$_POST['follow'] = $user_1_ID;
	    	$business->followBusiness();
	    	$automatedTesting->getBusinessFollowersTable();

	    	$automatedTesting->getEvents();
	    	// Member 2 creates event
	    	$_POST['event_name'] = "EventTest";
	    	$_POST['category'] = 2;
	    	$_POST['description'] = "Some description";
	    	$_POST['place'] = "Somewhere";
	    	$events->createEvent();
	    	$automatedTesting->getEvents();

	    	$automatedTesting->getEventMembersTable();
	    	// Member 1 joins event
	    	$_POST['join'] = $user_1_ID;
	    	$events->joinEvent();
	    	$automatedTesting->getEventMembersTable();

	    	$automatedTesting->getGroups();
	    	// Member 2 creates group
	    	$_POST['group_name'] = "GroupTest";
	    	$_POST['category'] = 3;
	    	$_POST['description'] = " Some description";
	    	$groups->createGroup();
	    	$automatedTesting->getGroups();

	    	$automatedTesting->getGroupMembersTable();
	    	// Member 1 joins group
	    	$_POST['join'] = $user_1_ID;
	    	$groups->createGroup();
	    	$automatedTesting->getGroupMembersTable();

	    	$automatedTesting->getUsers();
	    	// Delete user1 and user2
	    	$_POST['deleteUser'] = $user_1_ID;
	    	$automatedTesting->deleteUser();
	    	$_POST['deleteUser'] = $user_2_ID;
	    	$automatedTesting->deleteUser();
	    	echo("<script>console.log('Users:');</script>");
	    	$automatedTesting->getUsers();
	    	echo("<script>console.log('Events:');</script>");
	    	$automatedTesting->getEvents();
	    	echo("<script>console.log('Businesses:');</script>");
	    	$automatedTesting->getBusinesses();
	    	echo("<script>console.log('Groups:');</script>");
	    	$automatedTesting->getGroups();
	    	?>

	    </div>
	  </div>


	<script type="text/javascript" src="/js/bootstrap.js"></script>
    <script type="text/javascript" src="/js/material.js"></script>
    <script type="text/javascript" src="/js/ripples.js"></script>
    <script type="text/javascript" src="/js/dropdown.js"></script>
    <!-- <script type="text/javascript" src="/js/selectize.min.js"></script> -->
    <script type="text/javascript" src="/js/modernizr.js"></script>
    <script>
    $.material.init();
    $(document).ready(function() {
      $(".select").dropdown({"optionClass": "withripple"});
    });
    $().dropdown({autoinit: "select"});
    </script>
</body>
</html>
