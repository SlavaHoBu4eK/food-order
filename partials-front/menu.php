<?php
include('/var/www/food-order.loc/config/constants.php'); ?>

        <?php
        if (isset($_SESSION['login'])){
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <!-- Important to make website responsive -->
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Restaurant Website</title>

            <!-- Link our CSS file -->
            <link rel="icon" href="images/icon/icon2.png">
            <link rel="stylesheet" href="css/style.css">
        </head>

        <body>
        <!-- Navbar Section Starts Here -->
        <section class="navbar">
            <div class="container">
                <div class="logo">
                    <a href="<?=SITEURL?>" title="Logo">
                        <img src="images/logo.png"  alt="Restaurant Logo" class="img-responsive">
                    </a>
                </div>

                <div class="menu text-right">
                    <ul>
                        <li>
                            <a href="<?=SITEURL?>">Home</a>
                        </li>
                        <li>
                            <a href="<?=SITEURL?>categories.php">Categories</a>
                        </li>
                        <li>
                            <a href="<?=SITEURL?>foods.php">Foods</a>
                        </li>
                        <li>
                            <a href="#">Contact</a>
                        </li>
                    </ul>
                </div>

                <div class="clearfix"></div>
            </div>
        </section>
        <!-- Navbar Section Ends Here -->