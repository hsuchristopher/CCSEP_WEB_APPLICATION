<!--
    AUTHOR: Christopher Chang
    DATE: 14th of October 2018
    DEPENDENCIES: This file is dependent on userlisting.php and movielisting.php
    PURPOSE: The main template that allows dynamic loading of the admin panel
             functionality
-->
<?php
	// Only call start session if there is not a session already
    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }

    $page = "movielisting.php";               /* otherwise, include the default page */

    // Checks if the User has selected one of the admin options
    if(isset($_GET["page"]))
    {
        // For php file Inclusion
        $page = $_GET['page'];                  /* gets the variable $page */
    } 
?>

<!DOCTYPE html>
<html>
	<head>
	    <?php
	        $title = "ADMIN PANEL";
	        include('header.php')
	    ?>
	    <link rel="stylesheet" type="text/css" media="screen" href="./css/MYOWNCSS/index.css">
	    <link rel="stylesheet" type="text/css" media="screen" href="./css/MYOWNCSS/movielisting.css">
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
            <?php include('navbar.php');?>
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
                <div class="container-fluid">
                     <?php
                     	// This is where the dynamic file include happens 
                     	include("$page");
                     ?>
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