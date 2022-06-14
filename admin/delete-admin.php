<?php
//Include constant.php file
include('../config/constants.php');
// 1. Get the ID of Admin to be Deleted
$id = $_GET['id'];

// 2. Create SQL Query to Delete Admin
$sql = "DELETE FROM `tbl_admin` WHERE `id`=$id";

//Execute the Query
$res = mysqli_query($connect, $sql);

//Check whether the Query executed successfully or not
if ($res == TRUE) {
    //Query executed Successfully and Admin Deleted
 //   echo 'Admin Deleted';
    //Create Session Variable To Display Message
    $_SESSION['delete']= "<div class='success'>Admin Deleted Successfully.</div>";
    //Redirect To Manage-Admin Page
    header("location:" . SITEURL . 'admin/manage-admin.php');
} else {
    // Failed to Delete Admin
  //  echo 'Failed to  Delete Admin';
    $_SESSION['delete'] = "<div class='error'>Failed to  Delete Admin. Try Again Later.</div>";
    header("location:" . SITEURL . 'admin/manage-admin.php');

}

// 3. Redirect to Admin-Manage page with message(success/error)