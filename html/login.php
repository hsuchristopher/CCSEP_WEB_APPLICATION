<!--
    AUTHOR: Christopher Chang
    DATE: 14th of October 2018
    DEPENDENCIES: none 
    PURPOSE: Allows Users to log in, and then start their session. This
             page is susceptible to SQL Blind Injection. During the User
             validation
-->
<!DOCTYPE html>
<?php
    // Included Files
    include("database_con.php");
    // Only call start session if there is not a session already
    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }
    // ONLY ATTEMPT TO LOGIN IF THE USER IS ALREADY NOT LOGGED IN
    if(!isset($_SESSION["status"]))
    {
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            // Check the HTML Code to see if the username and password fields are set           
            if(isset($_POST["username"]) && isset($_POST["password"]))
            {
                $user = $_POST["username"];
                $pass = $_POST["password"];

                // Hash the password to check if the has values match with the database
                $pass = md5($pass);

                // Connect to Database and check the connection
                $conn = connect_to_database();
               
                // Now see if the user is allowed to log in
                if($user !== "" && $pass !== "")
                {

                    /* Prepared Statement before I purposely broke the code */
                    // Retrieve the SQL Query
                    //$sql = "SELECT Password FROM Users WHERE Username=? AND Password=?";

                    // Execute Prepared Statement in function
                    //$count = executePreparedLogin($user, $pass, $sql, $conn);


                    /* This is where the Blind SQL Injection will be */
                    $query = "SELECT Username FROM Users WHERE Username='$user'";
                    $result = mysqli_query($conn, $query);
                    $count = mysqli_num_rows($result);      

                    if($count == 0)     // Invalid User
                    {
                        // Error Message using Flash Variable
                        $_SESSION["error"] = "Incorrect Username";
                        header("Location: login.php");
                        return;
                    }
                    else if($count > 0)     // Valid Users
                    {
                        // Now check if the given Username matches the password
                        $query = "SELECT Password FROM Users WHERE Username='$user' AND Password='$pass'";
                        $result = mysqli_query($conn, $query);
                        $count = mysqli_num_rows($result); 
                        
                        if($count != 1)
                        {
                            // Error Message using Flash Variable
                            $_SESSION["error"] = "Incorrect Password";
                            header("Location: login.php");
                            return;
                        }
                        else if($count == 1)    // Returns 1 row
                        {
                            // CREATE SESSION VARIABLES
                            updateSessionCookie($conn, $user);

                            // Allows the welcome message to be only shown upon login and never again
                            $query = "SELECT username FROM Users WHERE username=?";
                            $name = getRowValue($conn, $query, $user);
                            $_SESSION["welcome_message"] = "Welcome {$name}!";


                            header('Location: index.php');
                            return;
                        }
                    }
                }
            }
        }
    }
    else    // Means User has already logged in so Redirect to index.php
    {
        header("location: index.php");
        return;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <embed src="./audio/tg1.mp3"  autostart="true" hidden='true'/>
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
                <!-- ALL OF THIS IS FOR THE LOGIN DIALOGUE BOX -->
                 <div class="modal-dialog text-center">
                    <div class="col-sm-15 main-section">
                        <!--FORM CONTENT GOES INSIDE THIS DIV CLASS -->
                        <div class="modal-content">
                            <!-- Default Avatar -->
                            <div class="col-12 user-img">
                                <img src="./images/kenshi.gif" width="50%" height="50%">
                            </div>
                            <!-- Username and Password Fields -->
                            <form class="col-12" action="login.php" method="post">
                                <div class="form-group">
                                    <input name="username" type="text" class="form-control" placeholder="Username" required>
                                </div>
                                <div class="form-group">
                                    <input name="password" type="password" class="form-control" placeholder="Password">
                                </div>
                                <!-- Login Button Icon -->
                                <button type="submit" class="btn" id="loginbtn"><i class="fas fa-sign-in-alt"></i>Login</button>
                            </form>
                            <!-- Flash and Redirect Session with error message -->
                            <?php
                                if(isset($_SESSION["error"]))
                                {
                                    // Print Error Message then destroy the session variable
                                    echo $_SESSION["error"];
                                    unset($_SESSION["error"]);
                                }
                            ?>
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