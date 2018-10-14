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

        $query2 = "SELECT * FROM Reviews WHERE MovieID = $select";
        $result2 = mysqli_query($conn, $query2);

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
            // The User wants to post a comment on the movie
            else if(isset($_POST['btn_comment']))
            {
                // Can't Post Empty Reviews
                if($_POST["comment"] == "")
                {
                    $_SESSION["error"] = "You must post something!";
                    header("location: movie.php?select=$select");
                    return;
                }
                else
                {
                    // Query To Insert Comment into Reviews Table
                    $query = "INSERT INTO Reviews(MovieID, UserID, Comment) VALUES($select, " . $_SESSION["user_id"] . ", '" . $_POST["comment"] . "')";
                    mysqli_query($conn, $query);

                    // Notify User Comment was successfully posted
                    $_SESSION["success"] = "Review Posted!";
                    header("location: movie.php?select=$select");
                    return;
                }
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
        <embed src="./audio/BAAM.mp3"  autostart="true" hidden='true'/>
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

                
                <div class="container">
                    <!-- Space for the Title -->
                    <div class="row">
                        <div class="col">
                            <h1 class="display-4" style="color: white;"> 
                                <?php
                                    
                                    //echo $cost;
                                ?>
                            </h1>
                        </div>
                    </div> 

                    <div class="row"> 
                        <div class="card bg-danger m-2 border-0" style="width: 18rem;">
                            <img class="card-img-top" src="./images/Movies/<?php echo $select?>.jpg" alt="No Image Uploaded" width="100%">
                        </div>

                        <div class="card bg-dark m-2 border-0" style="height: 15rem; top: 10.5rem; ">
                            <div class="card-header" style="color: white;">
                                Want to Buy this item?
                            </div>
                            <div class="card-body">
                                <h5 class="card-title" style="color: white;">
                                    Cost: 
                                    <?php 
                                        // Re-query the whole damn thing to get price
                                        $query = "SELECT * FROM Movies WHERE MovieID = $select";
                                        $result = mysqli_query($conn, $query);
                                        $row = mysqli_fetch_assoc($result);
                                        echo $row['Price'];
                                    ?>
                                    RayCoins
                                </h5>
                            </div>

                            <!-- Purchase Button -->
                            <?php if(!$purchased){?>  
                            <form method="POST">
                                <button class="btn btn-primary m-5" type="submit" name="purchase">
                                    Purchase
                                </button>
                            </form>
                            <?php }else{ ?>
                                <h4 class="m-5" style="color: #90EE90;">Purchased</h4>
                            <?php } ?>
                        </div>


                        <!-- Show the User how much money he/she has -->
                        <div class="col">
                            <div class="card bg-success text-white" style="top: 21.8rem;">
                                <div class="card-body">You currently have 
                                    <?php
                                        echo $_SESSION['funds'];
                                    ?>
                                    RayCoins
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Synopsis Card -->
                    <div class="row">
                        <div class="card bg-dark m-2 border-2">
                            <h4 class="card-title m-4" style="color: white;">Synopsis:</h4>
                            <p class="card-text m-4 " style="color: white;"><?php echo $row["Synopsis"];?></p>
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <div class="row">
                        <div class="col">
                            <form method="post">
                                <div class="card bg-dark m-2 border-2" style="right: 1rem;">
                                    <h4 class="card-title m-4" style="color: white;">Reviews:</h4>
                                    <textarea class="m-3" placeholder="Post a Comment" rows="4" cols="134" name="comment" required></textarea>
                                    <button type="submit" class="btn btn-primary m-3"name="btn_comment">Post</button>

                                    <div class="card-body">
                                        <table class="table table-hover table-light table-dark table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Comment</th>
                                                </tr>
                                            </thead>
                                            <!-- Print Out the Names and Comments Made -->
                                            <tbody>
                                                <?php while($row = mysqli_fetch_array($result2, MYSQLI_NUM)):;?>
                                                <tr>
                                                    <td>
                                                        <?php
                                                            $id = $row[1];
                                                            $query = "SELECT Username FROM Users WHERE UserID=$id";
                                                            $result = mysqli_query($conn, $query);
                                                            $name = mysqli_fetch_array($result, MYSQLI_ASSOC);
                                                            echo $name['Username'];
                                                        ?>    
                                                    </td>
                                                    <td><?php echo $row[2]; ?></td>
                                                </tr>
                                                <?php endwhile;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
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