<!--
Author: Christopher Chang
Date: Wednesday 26th September 2018
Purpose: CCSEP Assignment 2018, Modal forms for Admin Users to add/remove movies
-->

<?php
    /**
     * Pop Up Window for Deleting a Movie
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
                        <input name="movie_id" type="number" class="form-control" placeholder="Movie ID" required>
                    </div>
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
                    <button type="submit" class="btn" name="add_btn" value="add">Submit</button>
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
                        <button type="submit" class="btn btn-danger" name="remove_btn" value="delete" style="background-color: red;">Yes</button>
                    </div>

                </div>
            </div>
        </div>










<?php
    }
?>

