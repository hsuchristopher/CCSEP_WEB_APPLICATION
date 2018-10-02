<!--
Author: Christopher Chang
Date: Wednesday 26th September 2018
Purpose: CCSEP Assignment 2018, the homepage given when the web application starts
-->

<!DOCTYPE html>
<?php
    // Only call start session if there is not a session already
    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>OH MY GOD!!</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" type="text/css" media="screen" href="./css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" media="screen" href="./css/main.css"/>
        <!-- My Own CSS -->
        <link rel="stylesheet" type="text/css" media="screen" href="./css/MYOWNCSS/index.css">
        <!-- Bootstrap Scripts> -->
        <script src="./js/jquery-3.3.1.min.js"></script>
        <script src="./js/popper.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>
    </head>



    <body>    
        <div class="wrapper">
            <!-- Sidebar -->
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3>Funimation Knockoff!</h3>
                </div>

                <!-- Begin List for Side Bar -->
                <ul class="list-unstyled components">
                    <p>Menu</p>
                    <!-- Home Option: Navigates to index.php -->
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <?php
                        // IF THE USER HAS NOT LOGGED IN YOU WANT TO SHOW LOGIN AND SIGNUP OPTIONS ELSE NOT
                        if(!(isset($_SESSION["status"])))
                        {
                    ?>
                            <!-- Login Option: Navigates to login.php -->
                            <li>
                                <a href="login.php">Login</a>
                            </li>
                            <li>
                                <a href="signup.php">Sign Up</a>
                            </li>
                    <?php
                        }
                    ?>
                    <?php
                        // IF SESSION IS SET YOU WANT TO ALLOW USERS TO PURCHASE AND ADD FUNDS etc.
                        if((isset($_SESSION["status"])))
                        {
                    ?>
                            <li>
                                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Store</a>
                                <ul class="collapse list-unstyled" id="pageSubmenu">
                                    <li>
                                        <a href="#">Purchase</a>
                                    </li>
                                    <li>
                                        <a href="#">Add Funds</a>
                                    </li>
                                </ul>
                            </li>
                            
                            <li>
                                <a href="signout.php">Sign Out</a>
                            </li>
                    <?php
                        }
                    ?>
                </ul>
            </nav>
            
            <!-- Page Content --> 
            <div id="content">
                <nav class="navbar navbar-expand-lg navbar-light bg-transparent">
                    <div class="container-fluid">
                        <!-- CREATE THE TOGGLE SIDEBAR BUTTON --> 
                        <button type="button" id="sidebarCollapse" class="btn btn-default btn-lg">
                            <span class="glyphicon glyphicon-nav" aria-hidden="true"></span>
                        </button>
                        <?php
                            if(isset($_SESSION["welcome_message"]))
                            {
                                // Display Login Message if User has logged in!
                                echo $_SESSION["welcome_message"];
                                unset($_SESSION["welcome_message"]);
                            }
                        ?>
                    </div>
                </nav>
            </div>
        </div>

        <!-- JAVASCRIPT FUNCTIONS -->
        <!-- Toggle Sidebar -->
        <script type="text/javascript">
        $(document).ready(function(){
            $("#sidebarCollapse").on("click", function(){
                $('#sidebar').toggleClass('active');
            });
        });
        </script>
    </body>



               

</html>