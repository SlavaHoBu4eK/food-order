<?php
//Authorization -Access Control
//Check whether the user is locked in or not
if(!isset($_SESSION['user']))  //IF User session is not set
{
// User is not logged in
    // Redirect to Login  page with message
$_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access Admin Panel</div>";
//Redirect to Login Page
    header('location:'.SITEURL.'admin/login.php');

}
?>