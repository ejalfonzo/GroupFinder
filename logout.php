<?php 

    // First we execute our common code to connection to the database and start the session 
    // requirement not necessary here, you can always log out, if not logged in, it does nothing but redirect to index page
    //require("common.php"); 
     
    // We remove the user's data from the session 
    unset($_SESSION['user']); 
     
    // We redirect them to the login page 
    header("Location: index.php"); 
    die("Redirecting to: index.php");