<!--
AUTHOR: Christopher Chang
DATE: Sunday 14th October 2018
DEPENDENCIES: admin.php
PURPOSE: CCSEP Assignment 2018, userlisting page only for admin users to see inside the admin panel.
         privileged users are able to select users, and edit there profile, from their funds, their 
         privilege level and modify their passwords. Admins are also have the ability to delete other 
         users, including themselves.

         admin.php is considered a dependency for this file because the purpose of this page is to allow
         for PHP File include exploit, which can be exploited inside the GET request e.g /etc/passwd
-->
<?php
     // Include relavent functions for the database and the buttons for the page
     include("database_con.php");
     include("modal_buttons.php");

     // Only call start session if there is not a session already
     if(session_status() == PHP_SESSION_NONE)
     {
         session_start();
     }

     if($_SESSION["status"])
     {
        $conn = connect_to_database();
        updateSessionCookie($conn, $_SESSION["username"]);

        // Shows listing of Users upon loading of the page
        $query = "SELECT * FROM Users";
        $result = mysqli_query($conn, $query);

      
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            // Ensure the User has selected users to modify 
            if(empty($_POST["check_list"]))
            {
                $_SESSION["error"] = "Please Select Users to Edit";
                header("location: admin.php?page=userlisting.php");
                return;
            }
            /* Now You want to Ensure if either of the fields are filled in you need to 
               adjust the changes accordingly (Meaning, all the boxes don't have to be
               filled to query the server) */

            // If Remove Button was selected
            if(isset($_POST["delete_usr"]))
            {
                // Delete each item from the list checked
                foreach($_POST['check_list'] as $check)
                {
                    $query = "DELETE FROM Users WHERE UserID=" . $check . ";";
                    $result = mysqli_query($conn, $query);
                }

                // Tell the User Items have been deleted
                $_SESSION["success"] = "Users have been successfully deleted";
                header("location: admin.php?page=userlisting.php");
                return;
            }
            // Or the Apply Changes button was selected
            else if(isset($_POST["apply_changes"]))
            {
                // Begin building a Query String
                $query = "";

                if(!empty($_POST["change_password"]))
                {
                    foreach($_POST['check_list'] as $check)
                    {
                        $query .= "UPDATE Users SET password='" . md5($_POST["change_password"]) . 
                            "' WHERE UserID=" . $check . ";";
                    }
                }
                if(!empty($_POST["change_funds"]))
                {
                    foreach($_POST['check_list'] as $check)
                    {
                        $query .= "UPDATE Users SET funds='" . $_POST["change_funds"] . 
                            "' WHERE UserID=" . $check . ";";
                    }
                }
                if(!empty($_POST["make_admin"]))
                {
                    if($_POST["make_admin"] == "yes")
                    {
                        foreach($_POST['check_list'] as $check)
                        {
                            $query .= "UPDATE Users SET type='0' WHERE UserID='" . $check . "';";
                        }
                    }
                    else if($_POST["make_admin"] == "no")
                    {
                        foreach($_POST['check_list'] as $check)
                        {
                            $query .= "UPDATE Users SET type='1' WHERE UserID='" . $check . "';";
                            
                        }
                    }
                }
                // Execute Query
                if($query != "")
                {
                    // My reason to use multi query
                    mysqli_multi_query($conn, $query);
                }
                // Succsess Message
                //$_SESSION["success"] = "Changes have been successfully updated";
                header("location: admin.php?page=userlisting.php");
                return;
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


<!-- NO NEED FOR HTML TAGS HERE BECAUSE ALREADY INCLUDED INSIDE ADMIN.PHP -->
<?php
    // If Error Occurs
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
    // If Changing/Deleting was Successful
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
<embed src="./audio/kuroko.mp3"  autostart="true" hidden='true'/>
<!-- Extra Stylesheet for the Background image -->
<link rel="stylesheet" type="text/css" media="screen" href="./css/MYOWNCSS/userlisting.css">
<div class="container-fluid">
    <div class="row-6">
        
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editUser">
            Edit User
        </button>
        <!-- Table of Movies -->
        <table class="table table-hover table-light table-dark table-bordered">
            <thead class="thead-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Password</th>
                    <th scope="col">Type/Admin</th>
                    <th scope="col">Funds</th>
                    <th scope="col">Select</th>
                </tr>
            </thead>

            <tbody>
                <form class="col-12" action="userlisting.php" method="post">
                    <?php while($row = mysqli_fetch_array($result, MYSQLI_NUM)):;?>
                        <tr>
                            <td><?php echo $row[0];?></td>
                            <td><?php echo $row[1];?></td>
                            <td><?php echo $row[2];?></td>
                            <td><?php echo $row[3];?></td>
                            <td>
                                <?php 
                                    // 0 Means Admin User
                                    if($row[4] == 0)    
                                    {
                                        echo "Yes";
                                    }
                                    // 1 Means Normal User
                                    else if($row[4] == 1)
                                    {
                                        echo "No";
                                    }
                                ?>
                            </td>
                            <td><?php echo $row[5];?></td>
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
                        // DISPLAYS HTML For Editing Selected User 
                        editUserModal();
                    ?>
                </form>
            </tbody>
        </table>
    </div>
</div>