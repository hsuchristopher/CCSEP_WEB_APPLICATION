<!--
Author: Christopher Chang
Date: Wednesday 26th September 2018
Purpose: CCSEP Assignment 2018, The success page for when a user has successfully registered
-->
<?php
    session_start();
?>

<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>CONGRATULATIONS NANI!!</title>
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

