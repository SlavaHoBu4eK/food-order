<?php
//Include constant.php file 
include('../config/constants.php');

//echo "Delete Page";
// Check whether the id and image_name value is set or not

if (isset($_GET['id']) && isset($_GET['image_name'])) {
    //Get the value and delete
    // Echo "Get Value and Delete";
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //Remove the physical image file is available
    if ($image_name != "") {
        //Image is Available. So remove it
        $path = "../images/category/" . $image_name;
        //Remove the Image
        $remove = unlink($path);

        //if Failed to remove image then add an error message and stop the process
        if (!$remove) {
            //Set the Session Message
            $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image</div>";
            //Redirect to Manage Category Page
            header("location:" . SITEURL . 'admin/manage-category.php');
            // Stop the process
            die();
       }
    }
    //Delete Data from Database
    //SQL Query to Delete Data From Database
    $sql = "DELETE FROM `tbl_category` WHERE `id`=$id";

    //Execute the Query
    $res = mysqli_query($connect, $sql);

    //Check whether the data is Delete From Database or not
    if ($res == true) {
//Set Success Message and Redirect
        $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully</div>";
        //Redirect to Manage Category
        header("location:" . SITEURL . 'admin/manage-category.php');
    } else {
//Set Failed Message and Redirect
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Category</div>";
        //Redirect to Manage Category
        header("location:" . SITEURL . 'admin/manage-category.php');
    }


    // Redirect to Manage Category page with Message


} else {
    //Redirect to Manage Category Page
    header("location:" . SITEURL . 'admin/manage-category.php');
}

