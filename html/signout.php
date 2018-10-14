<!--
AUTHOR: Christopher Chang
DATE: 14th of October 2018
DEPENDENCIES: none
PURPOSE: When the User selects the signout option from the navbar
	     this php code just aids in destroying the session variables
	     then navigates back to the homepage
-->
<?php
    // Only call start session if there is not a session already
    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }
    // Log User Out
    session_destroy();
    header("Location: index.php");
?>