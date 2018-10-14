<!--
Author: Christopher Chang
Date: Wednesday 26th September 2018
Purpose: CCSEP Assignment 2018, Movie Listing for admin user to add/remove movies
-->

<?php
    include("database_con.php");
    include("modal_buttons.php");


    // Only call start session if there is not a session already
    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }

    // If user is logged in
    if($_SESSION["status"])
    {
        $conn = connect_to_database();
        updateSessionCookie($conn, $_SESSION["username"]);

        // Shows listing of movies upon loading of the page
        $query = "SELECT * FROM Movies";
        $result = mysqli_query($conn, $query);

        /* When Admin adds a Movie */
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_btn"]))
        {

            $name = $_POST["movie_name"];
            $synopsis = $_POST["movie_synopsis"];
            $price = $_POST["movie_price"];

            // BEGIN ADDING NEW MOVIE INTO DATABASE
            $query = "INSERT INTO Movies(name, synopsis, price) VALUES('$name','$synopsis','$price')";

            echo $query;

            // Execute the Query /Insert Into Table
            $result = mysqli_query($conn, $query);

            // Notify Admin that Movie was added
            $_SESSION["success"] = "Movie was Successfully Added!";
            header("location: admin.php?page=movielisting");
            return;
        }
        // USER WANTS TO DELETE AN ITEM
        else if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["remove_btn"]))
        {
            if(empty($_POST["check_list"]))
            {
                // Print Error Message
                $_SESSION["error"] = "You must select items to remove";
                header("location: admin.php?page=movielisting");
                return;
            }
            else
            {
                foreach($_POST['check_list'] as $check) 
                {
                    // Query to Delete Row
                    $query = "DELETE FROM Movies WHERE MovieID=" . $check . "";
                    
                    // Execute Query
                    $result = mysqli_query($conn, $query);
                }
                
                // Tell the User Items have been deleted
                $_SESSION["success"] = "Items have been successfully deleted";
                header("location: admin.php?page=movielisting");
                return;
            }
        }
    }
    else    // Means User hasn't logged in, redirect to login page
    {
        header("location: login.php");
        $_SESSION["error"] = "LOG IN FIRST YOU IDIOT!";
        return;
    }

?>
<embed src="./audio/tg.mp3"  autostart="true" hidden='true'/>
<!-- NO NEED FOR HTML TAGS AROUND THIS BECOZ ITS ALREADY INCLUDED -->
<div> 
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
        Add Movie
    </button>
    <?php
        // Displays HTML For Adding a Movie
        addMovieModal();
    ?>
</div>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteModal">
    Delete Movie
</button>
<div class="row-6">
    <!-- Table of Movies -->
    <table class="table table-hover table-light table-dark table-bordered">
        <thead class="thead-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Synopsis</th>
                <th scope="col">Price</th>
                <th scope="col">Select</th>
            </tr>
        </thead>
        <tbody>
            <form class="col-12" action="movielisting.php" method="post">
                <?php while($row = mysqli_fetch_array($result, MYSQLI_NUM)):;?>
                    <tr>
                        <td><?php echo $row[0];?></td>
                        <td><?php echo $row[1];?></td>
                        <td><?php echo $row[2];?></td>
                        <td><?php echo $row[3];?></td>
                        <td>
                            <div class="col-sm-2" style="text-align: center;">
                                <!-- By Storing the name as a check_list you can delete multiple entries now since it
                                    is inside a list -->
                                <input type="checkbox" name="check_list[]" class="form-check-input" value="<?php echo $row[0];?>">
                            </div>
                        </td>     
                    </tr>
                <?php endwhile;?>
                <?php
                    // Displays HTML For Deleting a Movie
                    deleteMovieModal();
                ?>
            </form>
        </tbody>
    </table>
</div>
                