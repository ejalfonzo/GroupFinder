
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>UPRMatricula</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<style>

body {
    background-repeat: no-repeat;
    background-color: #EAEADE;
    margin:0; padding:0;
    background-size: auto;
    margin: auto;
    margin-top: 100px;
    
    
}
.alignright {
    float: right;
}

h1 {
    color: green;
}

</style>
 
</head>

<body  background="images/UPRM Arco.gif">


    <div class="container">
    
        
        <div class="row">
        
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">UPRMatricula Register Student</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>




<form method="post" action="register.php" name="registerform">

    <input id="login_input_username" placeholder="Username" class="form-control" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />

    <input id="login_input_email" placeholder="User's email" class="form-control" type="email" name="user_email" required />

    <input id="login_input_password_new" placeholder="Password (min. 6 characters)" class="form-control" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />

    <input id="login_input_password_repeat" placeholder="Repeat password" class="form-control" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />

    </select>


    <input type="submit" class="btn btn-lg btn-success btn-block" name="register" value="Register" />



</form>

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>

</body>

</html>
