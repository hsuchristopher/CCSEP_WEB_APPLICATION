<!-- Sidebar -->
<nav id="sidebar">
    <div class="sidebar-header">
        <h3>Funimation Knockoff!</h3>
    </div>

    <!-- Begin List for Side Bar -->
    <ul class="list-unstyled components">
        <p>Menu</p>
        <!-- Home Option: Navigates to index.php -->
        <li>
            <a href="index.php">Home</a>
        </li>
        <?php
            // IF THE USER HAS NOT LOGGED IN YOU WANT TO SHOW LOGIN AND SIGNUP OPTIONS ELSE NOT
            if(!(isset($_SESSION["status"])))
            {
        ?>
                <!-- Login Option: Navigates to login.php -->
                <li>
                    <a href="login.php">Login</a>
                </li>
                <li>
                    <a href="signup.php">Sign Up</a>
                </li>
        <?php
            }
        ?>
        <?php
            // IF SESSION IS SET YOU WANT TO ALLOW USERS TO PURCHASE AND ADD FUNDS etc.
            if((isset($_SESSION["status"])))
            {
        ?>
                <li>
                    <a href=#Profile>Profile</a>
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Store</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="purchase.php">Purchase</a>
                        </li>
                        <li>
                            <a href="addfunds.php">Add Funds</a>
                        </li>
                    </ul>
                </li>
                <?php
                    // Allows Access for Admin Panel (If the cred value is zero then he is an admin user if 1 then not.)
                    if($_SESSION["credit"] == 0)
                    {
                ?>
                        <li>
                            <a href="#adminSubMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Admin Panel</a>
                            <ul class="collapse list-unstyled" id="adminSubMenu">
                                <li>
                                    <a href="movielisting.php">Add/Remove Movies</a>
                                </li>
                                <li>
                                    <a href="userListing.php">Manage User Accounts</a>
                                </li>
                            </ul>
                        </li>
                <?php
                    }
                ?>
                <li>
                    <a href="signout.php">Sign Out</a>
                </li>
        <?php
            }
        ?>
    </ul>
</nav>
