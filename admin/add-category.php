<?php include 'partials/menu.php'; ?>
    <div class="main-content">
        <div class="wrapper">
            <h1>Add Category</h1>

            <br><br>

            <?php
            if (isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if (isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            ?>
            <br><br>

            <!--            Add Category Form Starts-->
            <form action="" method="post" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title:</td>
                        <td><input type="text" name="title" placeholder="Category Title"></td>
                    </tr>

                    <tr>
                        <td>Select Image:</td>
                        <td><input type="file" name="image">

                        </td>
                    </tr>

                    <tr>
                        <td>Featured:</td>
                        <td><input type="radio" name="featured" value="Yes">Yes
                            <input type="radio" name="featured" value="No">No
                        </td>
                    </tr>

                    <tr>
                        <td>Active:</td>
                        <td><input type="radio" name="active" value="Yes">Yes
                            <input type="radio" name="active" value="No">No
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add category" class="btn-secondary">
                        </td>
                    </tr>

                </table>

            </form>
            <!--            Add Category Form Ends-->
            <?php
            //Check whether     the Submit Button is Clicked or Not
            if (isset($_POST['submit'])) {
                //  echo "clicked";
                // 1.Get The Value From Category  Form
                $title = $_POST['title'];

                //For  Radio Input Type, We need to Check whether the Button is selected or Not
                if (isset($_POST['featured'])) {
                    //Get The Value From Form
                    $featured = $_POST['featured'];
                } else {
                    // Set the Default Value From Form
                    $featured = "No";

                }
                if (isset($_POST['active'])) {

                    $active = $_POST['active'];
                } else {

                    $active = "No";

                }

                // Check whether the image is selected or not and Set the Value for image name  accordingly
                //  print_r($_FILES['image']);
                //die();// break the cod here
                if (isset($_FILES['image']['name'])) {
                    //Upload the Image
                    // To Upload image we need image name, source path and destination path
                    $image_name = $_FILES['image']['name'];

                    //Upload the Image only if image is selected
                    if ($image_name != "") {


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
                            header("location:" . SITEURL . 'admin/add-category.php');
                            //Stop the process
                            die();
                        }
                    }
                } else {
                    //Do not upload image and set the image_name value as blank
                    $image_name = "";
                }

                //2. Create SQL Query  to Insert Category into Database
                $sql = "INSERT INTO `tbl_category` SET
                               `title`='$title',
                               `image_name`='$image_name',
                               `featured`='$featured',
                               `active`='$active'
                ";
                // 3. Execute The Query and Save Database
                $res = mysqli_query($connect, $sql);

                // 4. Check whether the Query Executed or Not and Data Added or Not
                if ($res) {
                    // Query executed and Category Added
                    $_SESSION['add'] = "<div class='success'>Category Added Successfully</div>";
                    //Redirect To Manage Category Page
                    header("location:" . SITEURL . 'admin/manage-category.php');

                } else {
                    // Failed to Add Category

                    $_SESSION['add'] = "<div class='error'>Failed To Add Category</div>";

                    header("location:" . SITEURL . 'admin/add-category.php');
                }
            }
            ?>

        </div>
    </div>


<?php include 'partials/footer.php'; ?>