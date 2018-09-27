<!--
Author: Christopher Chang
Date: Wednesday 26th September 2018
Purpose: CCSEP Assignment 2018, The login page for users to log in
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
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" type="text/css" media="screen" href="./css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" media="screen" href="./css/main.css"/>
        <!-- My Own CSS -->
        <link rel="stylesheet" type="text/css" media="screen" href="./css/MYOWNCSS/index.css">
        <link rel="stylesheet" type="text/css" media="screen" href="./css/MYOWNCSS/login.css">
        <!-- Bootstrap Scripts> -->
        <script src="./js/jquery-3.3.1.min.js"></script>
        <script src="./js/popper.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>
        <!-- FontAwesome Plugins -->
        <link rel="stylesheet" href="./js/fontawesome-free-5.3.1-web/css/solid.css">
        <script src="./js/fontawesome-free-5.3.1-web/js/all.js"></script>
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
                    <li>
                        <a href="login.php">Login</a>
                    </li>
                    <li>
                        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">About Us</a>
                        <ul class="collapse list-unstyled" id="pageSubmenu">
                            <li>
                                <a href="#">Page 1</a>
                            </li>
                            <li>
                                <a href="#">Page 2</a>
                            </li>
                            <li>
                                <a href="#">Page 3</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
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
                    </div>
                </nav>


                <!-- ALL OF THIS IS FOR THE LOGIN DIALOGUE BOX -->
                 <div class="modal-dialog text-center">
                    <div class="col-sm-15 main-section">
                        <!--FORM CONTENT GOES INSIDE THIS DIV CLASS -->
                        <div class="modal-content">
                            <!-- Default Avatar -->
                            <div class="col-12 user-img">
                                <img src="./images/jwints1.jpg" width="50%" height="50%">
                            </div>
                            <!-- Username and Password Fields -->
                            <form class="col-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Password">
                                </div>
                                <!-- Login Button Icon -->
                                <button type="submit" class="btn" id="loginbtn"><i class="fas fa-sign-in-alt"></i>Login</button>
                            </form>
                            <!-- Allow People to Sign up -->
                            <div class="col-12 noaccount">
                                <a href="signup.php">Don't have an account? Sign up now</a>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>

     

        <!-- &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&& JAVASCRIPT FUNCTIONS &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&-->
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