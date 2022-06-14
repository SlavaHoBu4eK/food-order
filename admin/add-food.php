<?php include 'partials/menu.php'; ?>


    <div class="main-content">
        <div class="wrapper">
            <h1>Add Food</h1>
            <br><br>

            <?php
            if (isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title:</td>
                        <td>
                            <input type="text" name="title" placeholder="Title of the Food">
                        </td>
                    </tr>

                    <tr>
                        <td>Description:</td>
                        <td>
                            <textarea name="description" cols="30" rows="5"
                                      placeholder="Description of the Food"></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>Price:</td>
                        <td>
                            <input type="number" name="price">
                        </td>
                    </tr>

                    <tr>
                        <td>Select Image:</td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>

                    <tr>
                        <td>Category:</td>
                        <td>
                            <select name="category">

                                <?php
                                //Create PHP code to display categories from database
                                // 1. Create SQL to get all active categories from database
                                $sql = "SELECT * FROM `tbl_category` WHERE `active` = 'Yes' ";

                                //Executing Query
                                $res = mysqli_query($connect, $sql);

                                //Count rows to check whether we have categories or not
                                $count = mysqli_num_rows($res);

                                //If count is greater than zero, we have categories else we don't have categories
                                if ($count > 0) {
                                    //We have categories
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        //Get the details of categories
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>
                                        <option value="<?= $id ?>"><?= $title ?></option>
                                        <?php
                                    }
                                } else {

                                    // We don't have categories
                                    ?>
                                    <option value="0">No Category Found</option>
                                    <?php
                                }


                                // 2. Display on Dropdown
                                ?>

                        </td>
                    </tr>

                    <tr>
                        <td>Featured:</td>
                        <td>
                            <input type="radio" name="featured" value="Yes">Yes
                            <input type="radio" name="featured" value="No">No
                        </td>
                    </tr>

                    <tr>
                        <td>Active:</td>
                        <td>
                            <input type="radio" name="active" value="Yes">Yes
                            <input type="radio" name="active" value="No">No
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                        </td>
                    </tr>

                </table>


            </form>

            <?php
            // Check whether the button is clicked or not
            if (isset($_POST['submit'])) {
                //Add the Food in Database
                //echo "Clicked";

                // 1. Get the Data from Form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                //Check whether radio button for featured active are checked or not
                if (isset($_POST['featured'])) {
                    $featured = $_POST['featured'];
                } else {
                    $featured = "No"; //Setting the default value
                }

                if (isset($_POST['active'])) {
                    $active = $_POST['active'];
                } else {
                    $active = "No";
                }
                // 2. Upload the image if selected
                // Check whether the select image clicked or not and upload the image only if the image is selected
                if (isset($_FILES['image']['name'])) {
                    //Get the details of the selected image
                    $image_name = $_FILES['image']['name'];

                    //Check whether the image is selected or not and upload image only if selected
                    if ($image_name != "") {
                        //Image is Selected
                        // A. Rename the Image
                        // Get the Extension of selected image (jpg,png, gif, etc.)
                        $ext = explode('.', $image_name);
                        $ext = end($ext);

                        //Create New name for Image
                        $image_name = "Food-Name-" . rand(0000, 9999) . '.' . $ext; // New Image Name May Be "Food-Name-239.jpg"

                        // B. Upload the Image
                        //Get the src Path and Destination path

                        //Source path is current location of the image
                        $src = $_FILES['image']['tmp_name'];

                        //Destination Path for image to be uploaded
                       // $dst="/var/www/food-order.loc/admin/images/food/".$image_name;
                        $dst = "../images/food/" . $image_name;

                        //Finally upload the food image
                        $upload = move_uploaded_file($src, $dst);

                        //Check whether  image uploaded or not
                        if ($upload = false) {
                            //Failed to upload the image
                            //Redirect to Add Food Page with Error Message
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                            header("location:" . SITEURL . 'admin/add-food.php');

                            // Stop the Process
                            die();
                        }
                    }
                } else {
                    $image_name = ""; //Setting Default Value as blank
                }
                // 3. Insert into Database

                // Create a SQL Query to Save or Add Food
                //For Numerical we do not need to pass value inside quotes '' But for string value it is compulsory to add quotes''
                $sql2 = "INSERT INTO `tbl_food` SET
                           `title` = '$title',
                           `description`='$description',
                           `price`=$price,
                           `image_name`='$image_name',
                           `category_id`=$category,
                           `featured`='$featured',
                           `active`='$active'
                           ";

                //Execute the Query
                $res2 = mysqli_query($connect, $sql2);

                //Check whether data inserted or not
                // 4. Redirect with Message to Manage Food page
                if ($res2=true) {
                    //Data inserted successfully
                    $_SESSION['add'] = "<div class='success'>Food Added Successfully</div>";
                    header("location:" . SITEURL . 'admin/manage-food.php');

                } else {
                    //Failed to insert Data
                    $_SESSION['add'] = "<div class='error'>Failed to Add Food</div>";
                    header("location:" . SITEURL . 'admin/manage-food.php');
                }

            }
            ?>


        </div>
    </div>
<?php include 'partials/footer.php'; ?>