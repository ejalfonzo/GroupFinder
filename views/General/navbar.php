<?php

// echo("<script>console.log('PHP: ".session_status()."');</script>");

echo '<nav class="navbar navbar-default navbar-static-top">';
echo    '<div class="container">';
echo        '<div class="navbar-header">';
echo            '<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar" style="width:45px;">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>';
echo            '<a class="navbar-brand" style="padding:8px;" href="/index.php"><img alt="Group Finder" src="/images/navLogo.png"></a>';
echo            '</div>';
echo            '<div id="navbar" class="navbar-collapse collapse">';
echo            '<ul class="nav navbar-nav" style="color:white;">

                    <li><a href="/Views/Groups/search.php" class="btn btn-flat" style="padding:10px; color:white;">Groups</a></li>
                    <li><a href="/Views/Events/search.php" class="btn btn-flat" style="padding:10px; color:white;">Events</a></li>
                </ul>';
echo            '<ul class="nav navbar-nav navbar-right" >';

        // <li><a href="#" class="active btn btn-flat" style="padding:10px;">Home</a></li>

if ($_SESSION['user_login_status'] != 1) {
    // Not Logged In
// echo "NOT LOGGED IN";
echo '<button type="button" class="btn" data-toggle="modal" data-target="#SignIn" style="background:#e7e7e7;">Sign In</button>';

}else{

echo               '<li class="dropdown">
                        <a href="bootstrap-elements.html" data-target="#" class="dropdown-toggle" data-toggle="dropdown" style="padding: 10px;">
                            <i class="mdi-action-account-circle" style="font-size:40px;"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)">Profile</a></li>
                            <li><a href="javascript:void(0)">My Groups</a></li>
                            <li><a href="javascript:void(0)">My Events</a></li>
                            <li><a href="javascript:void(0)">Buisness</a></li>
                            <li class="divider"></li>
                            <li><a href="/index.php?logout" type="submit" name="logout" value="Log out">Logout</a></li>
                        </ul>
                    </li>';

}

echo            '</ul>';
echo        '</div>
        </div>
    </nav>';


if ($_SESSION['user_login_status'] != 1) {
    //Sign in Modal
    echo'<div id="SignIn" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">';
    echo           '<div class="modal-header">
                        <button type="btn" class="close" data-dismiss="modal">&times;</button>
                        <h1 class="modal-title" style="font-size:25px;">Group Finder</h1>
                    </div>';
    echo                '<div class="modal-body">
                        <form method="post" action="/index.php" name="loginform" class="form-signin">

                            <label for="inputEmail" class="sr-only">Email address</label>
                            <input type="email" id="inputEmail" name="login_email" style="margin: 10px 0px 10px;" class="form-control" placeholder="Email address" required autofocus>
                            <label for="inputPassword" class="sr-only">Password</label>
                            <input type="password" id="inputPassword" name="login_password" style="margin-bottom: 20px;" class="form-control" placeholder="Password" required>

                            <button class="btn btn-lg btn-success btn-block" type="submit" name="login" value="Log in">Sign in</button>
                            <button class="btn btn-lg btn-primary btn-block" data-toggle="modal" data-dismiss="modal" data-target="#RegisterM">Register</button>
                        </form>
                    </div>';
                // <div class="modal-footer" style="text-align:center;">
                //     <div class="fb-login-button btn-block" style="display:inline-block; border-radius:5px; overflow:hidden;" scope="public_profile,email" onlogin="checkLoginState();" data-max-rows="1" data-size="xlarge" data-show-faces="false" data-auto-logout-link="false">
                //      Login with Facebook</div>
                // </div>
    echo        '</div>
            </div>
        </div>';

    //Register Modal
echo'<div id="RegisterM" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="btn" class="close" data-dismiss="modal">&times;</button>
                    <h1 class="modal-title" style="font-size:25px;">Group Finder Registration</h1>
                </div>
                <div class="modal-body">';

                //ALERT TEST
                    //     if (isset($registration)) {
                    //         if ($registration->errors) {
                    //             foreach ($registration->errors as $error) {
                    //                 echo '<div class="alert alert-dismissable alert-danger">'.
                    //                     '<button type="button" class="close" data-dismiss="alert">×</button>'.
                    //                     '<strong>'. $error .'</strong></div>' ;
                    //             }
                    //         }
                    //         if ($registration->messages) {
                    //             foreach ($registration->messages as $message) {
                    //                 echo $message;
                    //             }
                    //         }
                    //     }

echo                '<form method="post" action="/index.php" name="registerform">

                        <input id="login_input_firstname" class="login_input form-control" placeholder="First Name" type="text" pattern="[a-zA-Z0-9]{2,64}" name="first_name" style="margin: 10px 0px 0px;" required />
                        <input id="login_input_lastname" class="login_input form-control" placeholder="Last Name" type="text" pattern="[a-zA-Z0-9]{2,64}" name="last_name" style="margin: 10px 0px 0px;" required />
                        <!-- the user name input field uses a HTML5 pattern check -->
                        <input id="login_input_username" class="login_input form-control" placeholder="Username (only letters and numbers, 2 to 64 characters)" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" style="margin: 10px 0px 10px;" required />

                        <!-- the email input field uses a HTML5 email type check -->
                        <input id="login_input_email" class="login_input form-control" placeholder="Email" type="email" name="user_email" style="margin-bottom: 10px;" required />

                        <input id="login_input_password_new" class="login_input form-control" placeholder="Password (min. 6 characters)" type="password" name="user_password_new" style="margin-bottom: 10px;" pattern=".{6,}" required autocomplete="off" />

                        <input id="login_input_password_repeat" class="login_input form-control" placeholder="Repeat Password" type="password" name="user_password_repeat" style="margin-bottom: 20px;" pattern=".{6,}" required autocomplete="off" />
                        <input class="btn btn-lg btn-success btn-block" type="submit"  name="register" value="Register" />

                    </form>
                </div>
                <div class="modal-footer" style="text-align:center;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>';
}


?>
