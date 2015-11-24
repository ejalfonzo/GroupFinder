<?php

/**
 * Class recovery
 * handles the user's password recovery process
 */

/**
* password generator function
*/
require_once("generator.php");

class Recovery
{
    /**
     * @var object The database connection
     */
    private $db_connection = null;
    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$recovery = new Recovery();"
     */
    public function __construct()
    {

        // check the possible actions:
        // reset user password
        if (isset($_POST["resetPassword"])) {
            $this->resetPassword();
        }
    }

    /**
     * reset password with post data
     */
    private function resetPassword()
    {
        // check login form contents
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field was empty.";
            echo("<script>console.log('RESET: Empty Username');</script>");
        } elseif (empty($_POST['user_email'])) {
            $this->errors[] = "Email field was empty.";
            echo("<script>console.log('RESET: Empty Email');</script>");
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_email'])) {

            // create a database connection, using the constants from config/db.php (which we loaded in Views/Recovery/view.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escape the POST stuff
                $user_name = $this->db_connection->real_escape_string($_POST['user_name']);
                $email = $this->db_connection->real_escape_string($_POST['user_email']);

                // database query, getting id, email and user_name of the selected user
                $sql = "SELECT id, email, user_name
                        FROM users
                        WHERE email = '" . $email . "' OR user_name = '" .$user_name. "';";

                $result_of_is_user_check = $this->db_connection->query($sql);

                // if this user exists
                if ($result_of_is_user_check->num_rows == 1) {

                    // get result row (as an object)a
                    $result_row = $result_of_is_user_check->fetch_object();
                    $userID = $result_row->id;

                    // Generate a new password using generator function
                    $user_new_password = $generatePassword();

                    // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
                    // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
                    // PHP 5.3/5.4, by the password hashing compatibility library
                    $user_new_password_hash = password_hash($user_new_password, PASSWORD_DEFAULT);

                    $sql2 = "UPDATE `ebabilon`.`users` 
                     SET password='".$user_new_password_hash."'
                     WHERE id = '".$userID."';";

                    $result_of_password_change = $this->db_connection->query($sql2);

                    if ($result_of_password_change) {
                        //Send email with new password
                        $subject = 'New Account Password';
                        $message = 'New Password: ' . '"'.$user_new_password.'"';
                        $headers = 'From: noreply@groupfinder.xyz'.phpversion(); 

                        mail($email, $subject, $message, $headers);

                        $this->messages[] = "Your account password has been changed successfully. The new password has been sent to your email.";
                    } else {
                        $this->errors[] = "Sorry, your password reset failed. Please go back and try again.";
                        echo("<script>console.log('PHP: ERROR Reseting');</script>");
                    }

                } else {
                    $this->errors[] = "Wrong username or email. Try again.";
                    echo("<script>console.log('RESET: Wrong Username or Email');</script>");
                }
            } else {
                $this->errors[] = "Database connection problem.";
                echo("<script>console.log('RESET: DB Problems');</script>");
            }
        }
    }
}
