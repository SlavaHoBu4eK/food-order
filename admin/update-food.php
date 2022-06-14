<?php include 'partials/menu.php' ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Update food</h1>
            <br><br>

            <?php
            //Check whether ID is Set or Not
            if (isset($_GET['id'])) {
                //Get all the details
                $id = $_GET['id'];

                //SQL Query To Get Selected Food
                $sql2 = "SELECT * FROM `tbl_food` WHERE `id`='$id'";
                //Execute the Query
                $res2 = mysqli_query($connect, $sql2);

                //Get the value based on query executed
                $row2 = mysqli_fetch_assoc($res2);

                //Get the individual values of selected food
                $title = $row2['title'];
                $description = $row2['description'];
                $price = $row2['price'];
                $current_image = $row2['image_name'];
                $current_category = $row2['category_id'];
                $featured = $row2['featured'];
                $active = $row2['active'];

            } else {
                //Redirect to manage Food
                header("location:" . SITEURL . 'admin/manage-food.php');
            }
            ?>


            <form action="" method="post" enctype="multipart/form-data">
                <table class="tbl-30">

                    <tr>
                        <td>Title:</td>
                        <td><label>
                                <input type="text" name="title" value="<?= $title ?>">
                            </label></td>
                    </tr>

                    <tr>
                        <td>Description:</td>
                        <td>
                            <label>
                                <textarea name="description" cols="30" rows="5"><?= $description ?></textarea>
                            </label>
                        </td>
                    </tr>

                    <tr>
                        <td>Price:</td>
                        <td>
                            <label>
                                <input type="number" name="price" value="<?= $price=number_format($price,0) ?>">
                            </label>
                        </td>
                    </tr>

                    <tr>
                        <td>Current Image:</td>
                        <td>
                            <?php
                            if ($current_image == "") {
                                //Image not Available
                                echo "<div class='error'>Image no Available</div>";
                            } else {
                                //Image Available
                                ?>
                                <img src="<?= SITEURL ?>images/food/<?= $current_image ?>" width="150px">
                                <?php
                            }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Select New Image</td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>

                    <tr>
                        <td>Category:</td>
                        <td>
                            <label>
                                <select name="category">

                                    <?php
                                    //Query to Get Active Categories
                                    $sql = "SELECT * FROM `tbl_category` WHERE `active`='Yes'";

                                    //Execute the Query
                                    $res = mysqli_query($connect, $sql);
                                    //Count rows
                                    $count = mysqli_num_rows($res);

                                    //Check Whether category available or not
                                    if ($count > 0) {
                                        //Category available
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            $category_title = $row['title'];
                                            $category_id = $row['id'];

                                            // echo "<option value='$category_id'>$category_title</option>";
                                            ?>
                                            <option <?php if ($current_category == $category_id) {
                                                echo "selected";
                                            } ?> value="<?= $category_id ?>"><?= $category_title ?></option>
                                            <?php
                                        }
                                    } else {
                                        //Category not available
                                        echo "<option value='0'>Category not available</option>";
                                    }

                                    ?>


                                </select>
                            </label>
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
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <input type="hidden" name="current_image" value="<?= $current_image ?>">
                            <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                        </td>
                    </tr>

                </table>
            </form>



            <?php
            if (isset($_POST['submit'])) {
                //echo "button is clicked";
                // 1. Get all the details from the form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];

                $featured = $_POST['featured'];
                $active = $_POST['active'];

                // 2. Upload the image if selected

                //Check whether upload button is clicked or not
                if (isset($_FILES['image']['name'])) {
                    //Upload Button is Clicked
                    $image_name = $_FILES['image']['name'];  // New Image Name

                    //Check whether the file is available or not
                    if ($image_name != "") {
                        //Image is available
                        // A. Uploading New Image
                        //Rename the image

                        $ext = explode('.', $image_name);
                        $ext = end($ext);
                        $image_name = "Food-Name-" . rand(0000, 9999) . '.' . $ext;
                        $src = $_FILES['image']['tmp_name'];
                        $dst = "../images/food/" . $image_name;
                        $upload = move_uploaded_file($src, $dst);


                        //Check whether the Image is Uploaded or Not

                        if ($upload = false) {
                            // Set message
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image </div> ";
                            //Redirect to manage food
                            header("location:" . SITEURL . 'admin/manage-food.php');
                            //Stop the process
                            die();
                        }
                        // 3. Remove the image if new image is uploaded and current image exists
                        //B. Remove current image if available

                        if ($current_image != "") {
                            $remove_path = "../images/food/" . $current_image;
                            $remove = unlink($remove_path);
                            //Check whether the image is removed or not
                            //If failed to remove then display message and stop the process
                            if (!$remove) {
                                //Failed to Remove Image
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image</div>";
                                header("location:" . SITEURL . 'admin/manage-food.php');
                                die(); //Stop the process
                            }
                        }

                    }else {
                        $image_name = $current_image;
                    }

                } else {
                    $image_name = $current_image;
                }


                // 4. Update the food in database
                $sql3 = "UPDATE `tbl_food` SET 
                          `title` = '$title',
                          `description` = '$description',
                          `price` = '$price',
                           `image_name`='$image_name',
                          `category_id` = '$category',
                          `featured` = '$featured',
                          `active` = '$active'
                            WHERE `id` = '$id'
                          ";

                //Execute the Query
                $res3 = mysqli_query($connect, $sql3);

                //Check whether the query is executed or not
                if ($res3) {

                    $_SESSION['update'] = "<div class='success'>Food Updated Successfully</div>";
                    header("location:" . SITEURL . 'admin/manage-food.php');

                } else {
                    //Failed to Update Category
                    $_SESSION['update'] = "<div class='error'>Failed to Update Food </div>";
                    header("location:" . SITEURL . 'admin/manage-food.php');
                }
            }
            ?>
        </div>
    </div>
<?php include 'partials/footer.php' ?>