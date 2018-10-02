<!--
Author: Christopher Chang
Date: Wednesday 26th September 2018
Purpose: CCSEP Assignment 2018, DESTROYS SESSION VARIABLES AND LOGS USER OUT
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