<!DOCTYPE html>
<?php
    // Only call start session if there is not a session already
    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }

    // If user is logged in
    if($_SESSION["status"])
    {
    }
    else    // Means User hasn't logged in, redirect to login page
    {
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
        <link rel="stylesheet" type="text/css" media="screen" href="./css/MYOWNCSS/index.css">
        <link rel="stylesheet" type="text/css" media="screen" href="./css/MYOWNCSS/profile.css">
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
                            <div class="row">
                                <div class="col">
                                    <h1 class="display-1" style="color:black">Welcome <?php echo $_SESSION["username"]?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>

                <div class="container-fluid">
                    <div class="col-sm-3">
                        <div class="row-sm-3">
                            <form action="profile.php" method="post" enctype="multipart/form-data">
                                <input type="file" name="fname">
                                <input type="submit" name="upload">
                            </form>
                        <div>
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