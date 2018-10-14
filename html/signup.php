<!--
AUTHOR: Christopher Chang
DATE: Sunday 14th of October 2018
DEPENDENCIES: none
PURPOSE: Signup page for any new users to create normal user accounts. 
         NOTE: This page, was not designed to be vulnerable, this page
         uses prepared statements so it is not susceptible to SQL injection
-->
<?php
    /* NOTE: The multiple returns used in this php code is standard used to
             reload the php code when an error occurs because you do not want
             the webpage to continue on loading the rest of the page */
    include("database_con.php");
    // Only call start session if there is not a session already
    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }

    // Users May only see this page if they haven't logged in
    if(!($_SESSION["status"]))
    {
        // Handle the form submissions
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            // Ensure that all the fields are set when posted
            if(isset($_POST["email"], $_POST["username"], $_POST["retypepwd"], $_POST["password"]))
            {
                // CREATE POST VARIABLES
                $email = $_POST["email"];
                $username = $_POST["username"];
                $password = $_POST["password"];
                $repass = $_POST["retypepwd"];

                // Connect to Database
                $conn = connect_to_database();

                /* ALL VALIDATION CHECKING */
                // Ensure both passwords are matching
                if($password == $repass)
                {
                    // Check if email already exists
                    $query = "SELECT email FROM Users WHERE email=?";
                    // Executes a prepared statement
                    $num_rows = genericPreparedOne($email, $conn, $query);
                    
                    // Check if already exists in the database
                    if($num_rows >= 1)
                    {
                        $_SESSION["error"] = "Email already exists!";
                        header('Location: signup.php');
                        /* The returns are used to reload the php code */
                        return;
                    }

                    // Check if Username already exists
                    $query = "SELECT username FROM Users WHERE username=?";
                    $num_rows = genericPreparedOne($username, $conn, $query);
                    if($num_rows >= 1)
                    {
                        $_SESSION["error"] = "Username already exists!";
                        header('Location: signup.php');
                        /* The returns are used to reload the php code */
                        return;
                    }
                }
                else    // Passwords do not match
                {
                    $_SESSION["error"] = "Passwords do not match!";
                    header('Location: signup.php');
                    /* The returns are used to reload the php code */
                    return;
                }
                // Hash the Password with md5
                $password = md5($password);
                /* If reached here then User can successfully sign up */
                registerRegularUser($email, $username, $password, $conn);
                header('Location: success.php');
                return;

            }
        }
    }
    else    // Redirect to index.php
    {
        header("location: index.php");
        return;
    }

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <embed src="./audio/aot.mp3"  autostart="true" hidden='true'/>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" type="text/css" media="screen" href="./css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" media="screen" href="./css/main.css"/>
        <!-- My Own CSS -->
        <link rel="stylesheet" type="text/css" media="screen" href="./css/MYOWNCSS/index.css">
        <link rel="stylesheet" type="text/css" media="screen" href="./css/MYOWNCSS/signup.css">
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
                        <a href="signup.php">Sign Up</a>
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
            </div>
            <!-- Spacing for Signup Form -->
            <div class="modal-dialog text-center">
                    <div class="col-sm-15 main-section">
                        <!--FORM CONTENT GOES INSIDE THIS DIV CLASS -->
                        <div class="modal-content">
                            <!-- Default Avatar -->
                            <div class="col-12 user-img">
                                <img src="./images/yonezu.gif" width="50%" height="50%">
                            </div>
                            <!-- Username and Password Fields -->
                            <form class="col-12" action="signup.php" method="post">
                            <div class="form-group">
                                    <input name="email" type="email" class="form-control" placeholder="Enter Email" required>
                                </div>
                                <div class="form-group">
                                    <input name="username" type="text" class="form-control" placeholder="Enter Username" required>
                                </div>
                                <div class="form-group">
                                    <input name="password" type="password" class="form-control" placeholder="Enter Password">
                                </div>
                                <div class="form-group">
                                    <input name="retypepwd" type="password" class="form-control" placeholder="Re-Enter Password">
                                </div>
                                <!-- Login Button Icon -->
                                <form action="success.php">
                                    <button type="submit" class="btn" id="loginbtn"><i class="fas fa-sign-in-alt"></i>Sign Up</button>
                                </form>
                            </form>
                            <?php
                                // Error Messages
                                if(isset($_SESSION["error"]))
                                {
                                    echo $_SESSION["error"];
                                    unset($_SESSION["error"]);
                                }
                            ?>
                            <!-- Allow People to Log in -->
                            <div class="col-12 noaccount">
                                <a href="login.php">Already have an account? Log in here</a>
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
<html>