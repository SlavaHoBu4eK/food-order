<?php include 'partials/menu.php' ?>

    <!-- Main Content Section Starts -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Update Category</h1>
            <br><br>
            <?php
            //Check whether the id is set or not
            if (isset($_GET['id'])) {
                //Get the id and all the other details
                // echo 'Getting the data';
                $id = $_GET['id'];

                //Create  SQL Query to get all the  other details
                $sql = "SELECT * FROM `tbl_category` WHERE `id`=$id";

                //Execute the Query
                $res = mysqli_query($connect, $sql);
                //Count the Rows to check whether the id is valid or not
                $count = mysqli_num_rows($res);
                if ($count == 1) {
                    //Get all the data
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                } else {
                    //redirect to manage category with session message
                    $_SESSION['no-category-found'] = "<div class='error'>Category not Found</div>";
                    header("location:" . SITEURL . 'admin/manage-category.php');
                }

            } else {
                //Redirect to Manage Category
                header("location:" . SITEURL . 'admin/manage-category.php');
            }
            ?>

            <form action="" method="post" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title:</td>
                        <td>
                            <input type="text" name="title" value="<?= $title ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Current Image:</td>
                        <td>
                            <?php
                            if ($current_image != "") {
                                //Display Image
                                ?>
                                <img src="<?= SITEURL ?>images/category/<?= $current_image ?>" width="150">
                                <?php
                            } else {
                                //Display Message
                                echo "<div class='error'>Image Not Added </div>";
                            }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>New Image:</td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>

                    <tr>
                        <td>Featured:</td>
                        <td>
                            <input <?php if ($featured == "Yes") {
                                echo "checked";
                            } ?> type="radio" name="featured" value="Yes">Yes
                            <input <?php if ($featured == "No") {
                                echo "checked";
                            } ?> type="radio" name="featured" value="No">No
                        </td>
                    </tr>

                    <tr>
                        <td>Active:</td>
                        <td>
                            <input <?php if ($active == "Yes") {
                                echo "checked";
                            } ?> type="radio" name="active" value="Yes">Yes
                            <input <?php if ($active == "No") {
                                echo "checked";
                            } ?> type="radio" name="active" value="No">No
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="hidden" name="current_image" value="<?= $current_image ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>

            <?php
            if (isset($_POST['submit'])) {
                //echo 'clicked';
                //1.Get all the values from our form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2.Updating new Image if Selected
                //Check whether  the image is selected or not
                if (isset($_FILES['image']['name'])) {
                    //Get the Image Details
                    $image_name = $_FILES['image']['name'];

                    //Check whether the image is available or not
                    if ($image_name != "") {
                        //Image available
                        //A. Upload the New Image

                        //Auto Rename Our Image
                        //GEt the Extension of our Image(jpg,png,gif, etc) e.g. "special.food1.jpg"
                        $ext = explode('.', $image_name);
                        $ext = end($ext);

                        //Rename the image
                        $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext; //e.g. Food_Category_849.jpg

                        $source_path = $_FILES['image']['tmp_name'];

                        //$destination_path = "/var/www/food-order.loc/admin/images/category/".$image_name;
                        $destination_path = "../images/category/" . $image_name;

//                    Finally Upload the Image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //Check whether the Image is Uploaded or Not
                        //And if the image is not uploaded then we will stop the process and redirect with error message
                        if ($upload = false) {
                            // Set message
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image </div> ";
                            //Redirect to Add Category Page
                            header("location:" . SITEURL . 'admin/manage-category.php');
                            //Stop the process
                            die();
                        }

                        //B. Remove the Current Image if Available
                        if ($current_image != "") {
                            $remove_path = "../images/category/" . $current_image;
                            $remove = unlink($remove_path);
                            //Check whether the image is removed or not
                            //If failed to remove then display message and stop the process
                            if (!$remove) {
                                //Failed to Remove Image
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image</div>";
                                header("location:" . SITEURL . 'admin/manage-category.php');
                                die(); //Stop the process
                            }

                        }

                    } else {
                        $image_name = $current_image;
                    }

                } else {
                    $image_name = $current_image;
                }

                //3. Update the Database
                $sql2 = "UPDATE `tbl_category` SET 
                          `title`='$title',
                          `image_name`='$image_name',
                          `featured`='$featured',
                          `active`='$active'
                            WHERE `id`='$id'
                          ";

                //Execute the Query
                $res2 = mysqli_query($connect, $sql2);

                //4.Redirect to Manage Category with Message
                //Check whether executed or not
                if ($res2) {
                    //Category Updated
                    $_SESSION['update'] = "<div class='success'>Category Updated Successfully</div>";
                    header("location:" . SITEURL . 'admin/manage-category.php');
                } else {
                    //Failed to Update Category
                    $_SESSION['update'] = "<div class='error'>Failed to Update Category </div>";
                    header("location:" . SITEURL . 'admin/manage-category.php');
                }


            }

            ?>
        </div>
    </div>

<?php include 'partials/footer.php' ?>