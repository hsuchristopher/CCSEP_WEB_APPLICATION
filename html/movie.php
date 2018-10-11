<?php 
	include("database_con.php");

	// Only call start session if there is not a session already
	if(session_status() == PHP_SESSION_NONE)
	{
	    session_start();
	}
    // Only Execute when a User has already logged in
    if(isset($_SESSION["status"]))
    {
    	$conn = connect_to_database();
        updateSessionCookie($conn, $_SESSION["username"]);

        $select = $_GET["select"];

        $query = "SELECT * FROM Movies WHERE MovieID=$select";
        $result = mysqli_query($conn, $query);

        $purchased = false;

    
        $query = "SELECT * FROM Purchases WHERE MovieID = $select AND UserID = ".$_SESSION['user_id'];
        $count = mysqli_num_rows(mysqli_query($conn, $query));

        // If Movie hasn't been purchased yet then purchase it
        if($count != 0)
        {
            $purchased = true;            
        }

        if($_SERVER["REQUEST_METHOD"] == "POST")
        {

            // If user chooses to purchase the movie
            if(isset($_POST['purchase']) && !$purchased)
            {
                $curBal = $_SESSION["funds"];
                
                while($row = mysqli_fetch_assoc($result))
                {
                    $movie_price = $row["Price"];
                }
                
                if($curBal < $movie_price)
                {
                    // FAIL MESSAGE
                    $_SESSION["error"] = "Insufficient Funds!";
                    header("location: movie.php?select=$select");
                    return;
                }

                // Deduct from User account
                $newBalance = $curBal - $movie_price;

                // Update Funds for User
                $query = "UPDATE Users SET funds=" . $newBalance . " WHERE UserID=" . $_SESSION["user_id"];
                mysqli_query($conn, $query);


                // Link the Bought Movie with the UserID inside the Purchases Table
                $query = 'INSERT INTO Purchases(MovieID, UserID) VALUES(' . $select . ', ' . $_SESSION["user_id"] . ')';
                mysqli_query($conn, $query);

                // Notify User
                $_SESSION["success"] = "Congratulations! Successfully Purchased!";
                header("location: movie.php?select=$select");
                return;

            }
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
            $title = "Money Time!";
            include('header.php')
        ?> 
        <!-- My Own CSS -->
        <link rel="stylesheet" type="text/css" media="screen" href="./css/MYOWNCSS/index.css">
        <link rel="stylesheet" type="text/css" media="screen" href="./css/MYOWNCSS/movie.css">
    </head>

    <body>
        <?php
            // If Adding/Removing Fails
            if(isset($_SESSION["error"]))
            {
        ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                        echo $_SESSION["error"];
                        unset($_SESSION["error"]);
                    ?>
                </div>
        <?php
            }
        ?>
        <?php
            // If Adding was Successful
            if(isset($_SESSION["success"]))
            {
        ?>
                <div class="alert alert-success" role="alert">
                    <?php
                        echo $_SESSION["success"];
                        unset($_SESSION["success"]);
                    ?>
                </div>
        <?php
            }
        ?>


        <div class="wrapper">
            <?php include('navbar.php')?>
            <!-- Page Content --> 
            <div id="content" class="container-fluid">
                <?php include('navbarButton.php')?>
                <div class="card bg-danger m-2 border-0" style="width: 18 rem;">
                    <img class="card-img-top" src="./images/Movies/<?php echo $select?>.jpg" alt="No Image Uploaded">
                </div>
            </div>












                <!-- Purchase Button -->
                <?php if(!$purchased){?>  
                <form method="POST">
                    <button type="submit" name="purchase">
                        Purchase
                    </button>
                </form>
                <?php }else{ ?>
                    <h4>Movie Already Purchased</h4>
                <?php } ?>
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