<?php

/**
 * Class login
 * handles the user's login and logout process
 */
class Login
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
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {

        // create/read session, absolutely necessary
        session_start();

        // check the possible login actions:
        // if user tried to log out (happen when user clicks logout button)
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        // login via post data (if user just submitted a login form)
        elseif (isset($_POST["login"])) {
            $this->dologinWithPostData();
        }
    }

    /**
     * log in with post data
     */
    private function dologinWithPostData()
    {
        // check login form contents
        if (empty($_POST['login_email'])) {
            $this->errors[] = "Username field was empty.";
            echo("<script>console.log('LOGIN: Empty Username or Email');</script>");
        } elseif (empty($_POST['login_password'])) {
            $this->errors[] = "Password field was empty.";
            echo("<script>console.log('LOGIN: Empty Password');</script>");
        } elseif (!empty($_POST['login_email']) && !empty($_POST['login_password'])) {

            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escape the POST stuff
                $email = $this->db_connection->real_escape_string($_POST['login_email']);

                // database query, getting all the info of the selected user (allows login via email address in the
                // username field)        user_password_hash,
                $sql = "SELECT id, email, user_name, first_name, last_name, salt, password as user_password_hash, isAdmin
                        FROM users
                        WHERE email = '" . $email . "';";
                        // SELECT id, email, firstName, lastName, salt, password, isAdmin
                        //from users
                        //where email = '". $email. "';

                $result_of_login_check = $this->db_connection->query($sql);

                // if this user exists
                if ($result_of_login_check->num_rows == 1) {

                    // get result row (as an object)
                    $result_row = $result_of_login_check->fetch_object();

                    // using PHP 5.5's password_verify() function to check if the provided password fits
                    // the hash of that user's password
                    if (password_verify($_POST['login_password'], $result_row->user_password_hash)) {

                        // write user data into PHP SESSION (a file on your server)
                        $_SESSION['email'] = $result_row->login_email;
                        // $_SESSION['email'] = $result_row->user_email;

                        $_SESSION['accountType'] = $result_row->accountType;
                        // $_SESSION['language'] = $result_row->language;
                        // $_SESSION['studentID'] = $result_row->studentID;

                        $_SESSION['user_login_status'] = 1;
                        echo("<script>console.log('LOGIN: LOGGED IN');</script>");
                    } else {
                        $this->errors[] = "Wrong password. Try again.";
                        echo("<script>console.log('LOGIN: Wrong Password');</script>");
                    }
                } else {
                    $this->errors[] = "This user does not exist.";
                    echo("<script>console.log('LOGIN: User Doest Not Exists');</script>");
                }
            } else {
                $this->errors[] = "Database connection problem.";
                echo("<script>console.log('LOGIN: DB Problems');</script>");
            }
        }
    }

    /**
     * perform the logout
     */
    public function doLogout()
    {
        echo("<script>console.log('LOGIN: TRY Logged Out');</script>");
        // delete the session of the user
        $_SESSION = array();
        session_destroy();
        // return a little feeedback message
        $this->messages[] = "You have been logged out.";
        echo("<script>console.log('LOGIN: Logged Out');</script>");

    }

    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        // default return
        return false;
    }

    public function defaultUser(){
	    if ($_SESSION['isAdmin']){
		    return true;
	    }
	    return false;
    }

    // public function buisnessUser(){
	//     if ($_SESSION['accountType']== 'buisness'){
	// 	    return true;
	//     }
	//     return false;
    // }

    public function adminUser(){
	    if ($_SESSION['accountType']== 'admin'){
		    return true;
	    }
	    return false;
    }

}
