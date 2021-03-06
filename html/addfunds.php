<!--
    AUTHOR: Christopher Chang
    DATE: 14th of October 2018
    DEPENDENCIES: none  
    PURPOSE: Allows users to add funds to their account to purchase movies.
             This functionality updates the current user logged in funds.
-->
<?php
    include("database_con.php");

    // Only call start session if there is not a session already
    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }
    // User Must be logged in in order to add funds
    if(isset($_SESSION["status"]))
    {
        // Connect to Database
        $conn = connect_to_database();
        updateSessionCookie($conn, $_SESSION["username"]);

        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if(isset($_POST["balance"]))
            {
                $uid = $_SESSION["user_id"];
                
                $additions = $_POST["balance"];
                $newbalance = $_SESSION["funds"] + $additions;

                $query = "UPDATE Users SET funds=$newbalance WHERE userID=$uid";
                mysqli_query($conn, $query);

                $_SESSION['funds'] = $newbalance;

                // To not get the form resubmission error when refreshing the page
                header("Location: addfunds.php");
                return;
            }
        }
        // Message to User on their current balance
        if($_SESSION["funds"] == NULL)
        {
            $balance_info = "You currently have 0 RayCoins Available";
        }
        else
        {
            $balance_info = "You currently have {$_SESSION['funds']} RayCoins Available";
        }
    }
    else
    {
        // User hasn't logged in redirect!
        header("location: login.php");
        $_SESSION["error"] = "LOG IN FIRST YOU IDIOT!";
        return;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "FIGHTING GOLD!";
            include('header.php')
        ?> 
        <embed src="./audio/jojo5.mp3"  autostart="true" hidden='true'/>
        <!-- My Own CSS -->
        <link rel="stylesheet" type="text/css" media="screen" href="./css/MYOWNCSS/index.css">
        <link rel="stylesheet" type="text/css" media="screen" href="./css/MYOWNCSS/addfunds.css">
    </head>
    <body>  
        <div class="wrapper">
            <?php include('navbar.php')?>
            <!-- Page Content --> 
            <div id="content" class="container-fluid">
                <?php include('navbarButton.php')?>
                <br><br><br><br>  
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-auto">
                        <div class="card text-white bg-dark">
                            <div class="card-header">
                                SO YOU WANT SOME MONEY
                            </div>
                            <div class="card-body"> 
                                <?php
                                    echo $balance_info;
                                ?>
                                <form class="form-inline" method="post" action="addfunds.php">
                                    <label class="card-text" style="white-space:nowrap">Enter the amount of RayCoins:</label>
                                    <input class="form-control ml-3" type="number" name="balance" value="0" min="0" step="1">
                                    <button type="submit" class="btn btn-primary ml-5">Add Funds</button>
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
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
