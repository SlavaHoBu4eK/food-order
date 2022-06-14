<?php
//Include constant.php file
include('../config/constants.php');

//echo "Delete Page";
// Check whether the id and image_name value is set or not

if (isset($_GET['id']) && isset($_GET['image_name'])) {
    //Get ID and Image Name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //Remove the image if available
    // Check whether the image is available or not and delete only if available
    if($image_name !="")

    {
        //It has Image and need to remove from Folder
        //Get the Image path
        $path = "../images/food/" . $image_name;

        //Remove  Image File From Folder
        $remove = unlink($path);

        //Check whether the Image is Removed or not
        if(!$remove){
        //Failed to remove Image
            $_SESSION['upload']="<div class='error'>Failed to Remove File</div>";
            header("location:" . SITEURL . 'admin/manage-food.php');
            die();
        }


    }

    //Delete Food from Database
    //SQL Query to Delete Data From Database
    $sql = "DELETE FROM `tbl_food` WHERE `id`=$id";

    //Execute the Query
    $res = mysqli_query($connect, $sql);

    //Check whether the data is Delete From Database or not
    if ($res) {
//Set Success Message and Redirect
        $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully</div>";
        //Redirect to Manage Category
        header("location:" . SITEURL . 'admin/manage-food.php');
    } else {
//Set Failed Message and Redirect
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Food</div>";
        //Redirect to Manage Category
        header("location:" . SITEURL . 'admin/manage-food.php');
    }


}
else
{
    //Redirect to Manage Food Page
    $_SESSION['unauthorize']="<div class='error'>Unauthorized Access</div>";
    header("location:" . SITEURL . 'admin/manage-food.php');
}