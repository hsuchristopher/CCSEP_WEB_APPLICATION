<!--
Author: Christopher Chang
Date: Wednesday 26th September 2018
Purpose: CCSEP Assignment 2018, Database Connection File with Functions
-->

<?php

    /* ***
     * Used to connect to the mysql database, this function doesn't do any
     * user input checking
     */
    function connect_to_database()
    {
        $db_name = "localhost";
        $db_username = "ccsep";
        $db_password = "ccsep_2018";
        $db_name = "assignment";

        // Create Connection
        $conn = mysqli_connect($db_name, $db_username, $db_password);

        // Check Connection
        if(!$conn)
        {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    
?>