<?php
include('/var/www/food-order.loc/config/constants.php');
include('/var/www/food-order.loc/admin/partials/login-check.php');
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Food Order Website - Home Page</title>
    <link rel="icon" href="../../images/icon/icon2.png">
    <link rel="stylesheet" href="../css/admin.css">

</head>
<body>
<!-- Menu Section Starts -->
<div class="menu text-center">
    <div class="wrapper">
        <ul>
            <li><a href="/admin/index.php">Home</a></li>
            <li><a href="/admin/manage-admin.php">Admin</a></li>
            <li><a href="/admin/manage-category.php">Category</a></li>
            <li><a href="/admin/manage-food.php">Food</a></li>
            <li><a href="/admin/manage-order.php">Order</a></li>
            <li><a href="/admin/logout.php">Logout</a></li>
        </ul>
    </div>
</div>
<!-- Menu Section Ends -->