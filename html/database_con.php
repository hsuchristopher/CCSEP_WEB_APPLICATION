<!--
    AUTHOR: Christopher Chang
    DATE: 14th of October 2018
    DEPENDENCIES: All the php files
    PURPOSE: Contains functions, that are used to connect to the database
             execute prepared statements, and queries rows from the database
             also, contains functions that set up session variables
-->
<?php
    /* ***
     * Used to connect to the mysql database, this function doesn't do any
     * user input checking
     */
    function connect_to_database()
    {
        $db_server = "localhost";
        $db_username = "ccsep";
        $db_password = "ccsep_2018";
        $db_name = "assignment";

        // Create Connection
        $conn = mysqli_connect($db_server, $db_username, $db_password, $db_name);

        // Check Connection
        if(!$conn)
        {
            die("Connection failed: " . mysqli_connect_error());
        }

        return $conn;
    }

    /**
     * When the User manages to successfully login, these global variables
     * for the session will be created and stored in a cookie
     */
    function updateSessionCookie($conn, $user)
    {
        $_SESSION["status"] = true;     // Tell if the user is logged in
        $_SESSION["username"] = $user;
        

        $query = "SELECT type FROM Users WHERE username=?";
        $_SESSION["credit"] = getRowValue($conn, $query, $user);                   // Privilege Level

        $query = "SELECT funds FROM Users WHERE username=?";
        $_SESSION["funds"] = getRowValue($conn, $query, $user);                    // Available Funds

        $query = "SELECT UserID FROM Users WHERE username=?";
        $_SESSION["user_id"] = getRowValue($conn, $query, $user);
    }

    /**
     * Sets Up Prepared Statement for Login and executes it,
     * This function returns the number of rows the query returns
     */
    function executePreparedLogin($user, $pass, $query, $conn)
    {
        // SET UP PREPARED STATEMENT
        if($stmt = mysqli_prepare($conn, $query))
        {
            /* Bind parameters for markers */
            mysqli_stmt_bind_param($stmt, "ss", $user, $pass);
            
            /* Execute Query */
            mysqli_stmt_execute($stmt);

            /* Store the result */
            $row_cnt = mysqli_stmt_store_result($stmt);            

            /* Count the Rows */
            $row_cnt = mysqli_stmt_num_rows($stmt);

            /* Bind the result variables */
            mysqli_stmt_bind_result($stmt, $password);

            /* Fetch the results */
            mysqli_stmt_fetch($stmt);
        }
            
        return $row_cnt;
    }

    /**
     * This is a generic Prepared Statement Function that only excepts
     * one search parameter (e.g ?) and returns the number of rows.
     * IMPORTS: 1: ? value, 2: connection to Database
     */
    function genericPreparedOne($arg1, $conn, $query)
    {
        if($stmt = mysqli_prepare($conn, $query))
        {
            mysqli_stmt_bind_param($stmt, "s", $arg1);
            mysqli_stmt_execute($stmt);
            $row_cnt = mysqli_stmt_store_result($stmt);   
            $row_cnt = mysqli_stmt_num_rows($stmt);
            mysqli_stmt_bind_result($stmt, $password);
            mysqli_stmt_fetch($stmt);
        }

        return $row_cnt;
    }

    /**
     * Once all the initial validation checking is done for signing up a user
     * this function will be called to actually register ONLY A NORMAL USER
     * (NOT PRIVILEGED ADMIN USER)
     */
    function registerRegularUser($email, $username, $password, $conn)
    {
        $query = "INSERT INTO Users (username, email, password) VALUES(?,?,?)";

        // SET UP PREPARED STATEMENT
        if($stmt = mysqli_prepare($conn, $query))
        {
            // In order for the user to be regular use, the type has to be equal to 1 and all users
            // initially start off with no funds when they sign up (So no need to input here)
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $password);
            mysqli_stmt_fetch($stmt);
        }
    }

    /**
     * This function is used for setting the global session variables in order to
     * create the cookie
     */
    function getRowValue($conn, $query, $bind_param)
    {
        if($stmt = mysqli_prepare($conn, $query))
        {
            mysqli_stmt_bind_param($stmt, "s", $bind_param);

            /* execute statement */
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            // In this case the While and foreach loops will only run once
            while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
            {
                foreach ($row as $r)
                {
                    // Assign the actual data
                    $retVal = $r;
                }
            }
        }

        return $retVal;
    }
?>