<!--
Author: Christopher Chang
Date: Wednesday 26th September 2018
Purpose: CCSEP Assignment 2018, the homepage given when the web application starts
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
<html>
    <head>
        <embed src="./audio/ora.mp3"  autostart="true" hidden='true'/>
        <?php
            $title = "WHAT ARE YOU BUYING";
            include('header.php')
        ?>
        <link rel="stylesheet" type="text/css" media="screen" href="./css/MYOWNCSS/index.css">
        
    </head>

    <body>    
        <?php
            if(isset($_SESSION["welcome_message"]))
            {
        ?>
                <div class="alert alert-success" role="alert">
                    <?php
                        echo $_SESSION["welcome_message"];
                        unset($_SESSION["welcome_message"]);
                    ?>
                </div>
        <?php
            }
        ?>
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
                    </div>
                </nav>
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