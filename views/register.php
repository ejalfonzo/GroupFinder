
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Group Finder Register</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/css/roboto.css"/>
    <link rel="stylesheet" type="text/css" href="/css/material.css"/>

<style>

body {
    background-repeat: no-repeat;
    margin:0; padding:0;
    background-size: auto;
    margin: auto;
    margin-top: 100px;
}
.alignright {
    float: right;
}

</style>

</head>

<body >
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Register User</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form"><fieldset>
                            <form method="post" action="register.php" name="registerform">

                                <input id="login_input_firstname" class="login_input form-control" placeholder="First Name" type="text" pattern="[a-zA-Z0-9]{2,64}" name="first_name" style="margin: 10px 0px 0px;" required />
                                <input id="login_input_lastname" class="login_input form-control" placeholder="Last Name" type="text" pattern="[a-zA-Z0-9]{2,64}" name="last_name" style="margin: 10px 0px 0px;" required />

                                <input id="login_input_username" placeholder="Username" class="form-control" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />

                                <input id="login_input_email" placeholder="User's email" class="form-control" type="email" name="user_email" required />

                                <input id="login_input_password_new" placeholder="Password (min. 6 characters)" class="form-control" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />

                                <input id="login_input_password_repeat" placeholder="Repeat password" class="form-control" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
                                <!-- </select> -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" name="register" value="Register" />

                            </form>
                        </fieldset></form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/bootstrap.js"></script>
    <script type="text/javascript" src="/js/material.js"></script>

</body>

</html>
