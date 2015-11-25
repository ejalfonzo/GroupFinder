<?php

/**
 * Class registration
 * handles the user registration
 */
class Registration
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
        if (isset($_POST["register"])) {
            $this->registerNewUser();
        }
    }

    /**
     * handles the entire registration process. checks all error possibilities
     * and creates a new user in the database if everything is fine
     */
    public function registerNewUser()
    {
        // echo("<script>console.log('Register New User');</script>");
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Empty Username";
            echo("<script>console.log('Error: Empty Username');</script>");

        } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
            $this->errors[] = "Empty Password";
            echo("<script>console.log('Error: Empty Password');</script>");

        }elseif (empty($_POST['first_name']) || empty($_POST['last_name'])) { // ADDED for First & Last Name
            $this->errors[] = "Empty Name";
            echo("<script>console.log('Error: Empty Names');</script>");

        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
            $this->errors[] = "Password and password repeat are not the same";
            echo("<script>console.log('Error: Passwords dont match');</script>");

        } elseif (strlen($_POST['user_password_new']) < 6) {
            $this->errors[] = "Password has a minimum length of 6 characters";
            echo("<script>console.log('Error: Password to short');</script>");

        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
            $this->errors[] = "Username cannot be shorter than 2 or longer than 64 characters";
            echo("<script>console.log('Error: Username to short');</script>");

        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
            $this->errors[] = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
            echo("<script>console.log('Error: Username bad schema');</script>");

        } elseif (empty($_POST['user_email'])) {
            $this->errors[] = "Email cannot be empty";
            echo("<script>console.log('Error: Empty Email');</script>");

        } elseif (strlen($_POST['user_email']) > 64) {
            $this->errors[] = "Email cannot be longer than 64 characters";
            echo("<script>console.log('Error: Email to long');</script>");

        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Your email address is not in a valid email format";
            echo("<script>console.log('Error: Email not valid');</script>");

        } elseif (!empty($_POST['user_name'])
            && strlen($_POST['user_name']) <= 64
            && strlen($_POST['user_name']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
            && !empty($_POST['user_email'])
            && strlen($_POST['user_email']) <= 64
            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
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
                $first_name = $this->db_connection->real_escape_string(strip_tags($_POST['first_name'], ENT_QUOTES));
                $last_name = $this->db_connection->real_escape_string(strip_tags($_POST['last_name'], ENT_QUOTES));
                $salt = "0";

                $user_name = $this->db_connection->real_escape_string(strip_tags($_POST['user_name'], ENT_QUOTES));
                $user_email = $this->db_connection->real_escape_string(strip_tags($_POST['user_email'], ENT_QUOTES));

                $user_password = $_POST['user_password_new'];
                //Test Debug
                // echo("<script>console.log('PHP: ".json_encode($user_name)."');</script>");
                // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
                // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
                // PHP 5.3/5.4, by the password hashing compatibility library
                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

                // check if user or email address already exists
                $sql = "SELECT * FROM users WHERE user_name = '" . $user_name . "' OR email = '" . $user_email . "';";
                $query_check_user_name = $this->db_connection->query($sql);

                if ($query_check_user_name->num_rows == 1) {
                    $this->errors[] = "Sorry, that username / email address is already taken.";
                } else {
                    // write new user's data into database
                    // $sql = "INSERT INTO users (user_name, user_password_hash as password, user_email as email)
                    $sql = "INSERT INTO users (user_name, password, email, salt, first_name, last_name)
                            VALUES('" . $user_name . "', '" . $user_password_hash . "', '" . $user_email . "', '" . $salt ."', '" . $first_name . "', '" . $last_name . "');";
                    $query_new_user_insert = $this->db_connection->query($sql);
                    $ID = mysql_insert_id();
                    echo("<script>console.log('Total Group Members: ".mysql_insert_id()."');</script>");

                    // if user has been added successfully
                    if ($query_new_user_insert) {
                        $this->messages[] = "Your account has been created successfully. You can now log in.";
                        // echo("<script>console.log('PHP: ".json_encode($query_new_user_insert)."');</script>");
                        return $ID;
                    } else {
                        $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                        echo("<script>console.log('PHP: ERROR Registering');</script>");
                    }
                }
            } else {
                $this->errors[] = "Sorry, no database connection.";
            }
        } else {
            $this->errors[] = "An unknown error occurred.";
        }
    }
}
