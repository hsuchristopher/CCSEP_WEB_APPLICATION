<!--
AUTHOR: Christopher Chang
DATE: 14th of October 2018
DEPENDENCIES: none
PURPOSE: Displays a list of movies in Bootstrap4 card format that the User can
         go and visit their own personal page for and then purchase the movie.
         This page allows any user (privilleged/normal) to search for a movie
         in the database and allows the user to select the movie.

         This page is suseptible to Reflected XSS - See the report
         for more information.
-->
<!DOCTYPE html>
<?php
    include("database_con.php");

    // Only call start session if there is not a session already
    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }
    if($_SESSION["status"])
    {
        $conn = connect_to_database();
        updateSessionCookie($conn, $_SESSION["username"]);
    
        $search = NULL;

        if(isset($_GET['search']))
        {
            $search = $_GET['search'];
            $query = "SELECT * FROM Movies WHERE Name LIKE '%$search%' ORDER BY Name";
        }
        else
        {
            // Get all the Movie Names
            $query = "SELECT * FROM Movies ORDER BY Name";
        }
        $result = mysqli_query($conn, $query);
    }
    else
    {
        // User hasn't logged in redirect!
        header("location: login.php");
        $_SESSION["error"] = "LOG IN FIRST YOU IDIOT!";
        return;
    }
    
?>
<html>
    <head>
        <?php
            $title = "MOVIES/ANIME!";
            include('header.php')
        ?>
        <embed src="./audio/gc2.mp3"  autostart="true" hidden='true'/>
        <link rel="stylesheet" type="text/css" media="screen" href="./css/MYOWNCSS/index.css">
        <link rel="stylesheet" type="text/css" media="screen" href="./css/MYOWNCSS/purchase.css">
    </head>
    <body>
        <div class="wrapper">
            <?php include('navbar.php')?>
            <!-- Page Content --> 
            <div id="content">
                <nav class="navbar navbar-expand-lg navbar-light bg-transparent">
                    <div class="container-fluid">
                        <!-- CREATE THE TOGGLE SIDEBAR BUTTON --> 
                        <button type="button" id="sidebarCollapse" class="btn btn-default btn-lg">
                            <span class="glyphicon glyphicon-nav" aria-hidden="true"></span>
                        </button>
                        <div class="container">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <?php if($search == NULL)
                                    {
                                        echo '<h1 class="display-4" style="color:white">BUY MOVIES</h1>';
                                    }
                                    else
                                    {
                                        echo "<h1 class=\"display-4\" style=\"color:white\">Search: $search</h1>";
                                    }?>
                                </div>
                                <div class="col-md-auto m-auto">
                                    <form method="GET">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="search">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-success form-control">Search</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>  
                    </div>
                </nav>
                <div class="container-fluid">
                    <div class="row justify-content-center">
                    <?php
                        while($row = mysqli_fetch_assoc($result))
                        {
                    ?>
                            <div class="card bg-danger m-2 border-0" style="width: 18rem; cursor:pointer" onmouseover="cardHover(this)" onmouseout="cardUnHover(this)" onclick="window.location.href='movie.php?select=<?php echo $row['MovieID']?>'">
                                <img class="card-img-top" src="./images/Movies/<?php echo $row['MovieID']?>.jpg" alt="No Image Uploaded">
                                <div class="card-cover"></div>
                                <div class="card-name pt-2 pb-2">
                                    <label class="m-0"><?php echo $row['Name'] ?></label>
                                </div>
                            </div>
                    <?php
                        }
                    ?>
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


        // Functions that allow the cards to hover and display the movie name
        function cardHover(card){
            $($(card).children(".card-cover")[0]).css("opacity", "0.8");
            $($(card).children(".card-name")[0]).css("opacity", "1");
        }

        function cardUnHover(card){
            $($(card).children(".card-cover")[0]).css("opacity","0");
            $($(card).children(".card-name")[0]).css("opacity","0");
        }
        </script>
    </body>
</html>