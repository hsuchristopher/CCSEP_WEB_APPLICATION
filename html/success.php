<!--
AUTHOR: Christopher Chang
DATE: Sunday 14th of October 2018
DEPENDENCIES: none
PURPOSE: The Success Page for when the User successfully creates an account with
         funimation knockoff!. This page just congratulates the user and redirects
         them back to the index page
-->
<?php
    // Only call start session if there is not a session already
    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }
?>

<head>
    <embed src="./audio/ohno.mp3"  autostart="true" hidden='true'/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>OH MY GOD!!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" media="screen" href="./css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="./css/main.css"/>
    <!-- My Own CSS -->
    <link rel="stylesheet" type="text/css" media="screen" href="./css/MYOWNCSS/success.css">
    <!-- Bootstrap Scripts> -->
    <script src="./js/jquery-3.3.1.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</head>

<!DOCTYPE html>
<body>
    <div class="container">
        <div class="card bg-success text-white">
            <div class="card-body">
                Congratulations! Welcome to the Knockoff ARMY! User has been successfully registered
            </div>
            <button type="submit" onclick="location.href='index.php';" class="btn" id="redirectbtn"><i class="fas fa-sign-in-alt"></i>BACK TO SAFETY</button>
  </div>
    </div>
</body>