<!--
    AUTHOR: Christopher Chang
    DATE: 14th of October 2018
    DEPENDENCIES: userlisting.php, movielisting.php
    PURPOSE: php functions that contains HTML for the modal windows for the admin panel
-->

<?php
    /**
     * Pop Up Window for Deleting a Movie, User must be fill in all
     * required fields add a movie
     */
    function addMovieModal()
    {
?>
    <!-- The Modal -->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add A Movie</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="col-12" action="movielisting.php" method="post">
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <input name="movie_name" type="text" class="form-control" placeholder="Movie Title" required>
                    </div>
                    <div class="form-group">
                        <input name="movie_synopsis" type="text" class="form-control" placeholder="Synopsis" required>
                    </div>
                    <div class="form-group">
                        <input name="movie_price" type="number" class="form-control" placeholder="Price" required>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="add_btn" value="add">Submit</button>
                </div>
            </form>
        </div>
    </div>
<?php
    }
?>


<?php
    /**
     * Pop Up Window for Deleting a Movie
     */
    function deleteMovieModal()
    {
?>
        <!-- The Modal -->
        <div class="modal fade" id="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Remove Item</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        Are you sure you want to permantley delete these items?
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-success btn-lg" name="remove_btn" value="delete">Yes</button>
                    </div>

                </div>
            </div>
        </div>
<?php
    }
?>


<?php
    /**
     * Pop Up Window for Editing a User as Admin,
     * NOTE: There is a slight bug in this function for when a User wants to set the funds of any user to
     * zero, they cannot do this because of the php thinking that zero means false not the number
     */
    function editUserModal()
    {
?>
        <!-- The Modal -->
        <div class="modal fade" id="editUser">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">SO YOU WANNA CHANGE SOMETHING</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <input name="change_password" type="password" class="form-control" placeholder="Change Password">
                        </div>
                        <div class="form-group">
                            <input name="change_funds" type="number" class="form-control" placeholder="Edit Funds (Enter New Total Funds)">
                        </div>
                        <h5>Make Admin:</h5>
                        <div class="form-group col-1">
                            <label class="container">
                                <input type="radio" name="make_admin" class="form-check-input" value="yes">
                                Yes
                            </label>
                            <label class="container">
                                <input type="radio" name="make_admin" class="form-check-input" value="no">
                                No
                            </label>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" name="apply_changes" value="apply" style="background-color: blue">Apply Changes</button>
                        <button type="submit" class="btn btn-danger" name="delete_usr" value="delete" style="background-color: red;">Delete Account/s</button>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
?>