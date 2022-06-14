<?php include 'partials-front/menu.php'; ?>

<?php
//check whether id is past or not
if (isset($_GET['category_id'])) {
    //category_id is set and get the id
    $category_id = $_GET['category_id'];

    //Get the category title based on category_id
    $sql = "SELECT `title` FROM `tbl_category` WHERE `id`='$category_id'";

    //Execute the Query
    $res = mysqli_query($connect, $sql);

    //Get the value from database
    $row = mysqli_fetch_assoc($res);

    //Get the title
    $category_title = $row['title'];

} else {
    //Category not past
    //Redirect to home page
    header('location:' . SITEURL);
}


?>


    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">

            <h2>Foods on <a href="#" class="text-white">"<?= $category_title ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->


    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php

            //CREate SQL Query to Get foods based on selected category
            $sql2 = "SELECT * FROM `tbl_food` WHERE `category_id`='$category_id'";

            //Execute the Query
            $res2 = mysqli_query($connect, $sql2);

            //Count the rows
            $count2 = mysqli_num_rows($res2);
            //check whether food is available or not
            if ($count2 > 0) {
                //food is available
                while ($row2 = mysqli_fetch_assoc($res2)) {
                    $id=$row2['id'];
                    $title = $row2['title'];
                    $price = $row2['price'];
                    $description = $row2['description'];
                    $image_name = $row2['image_name'];
                    ?>


                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php
                            if($image_name=="")
                            {
                                //image not available
                                echo "<div class='error'>Image is not available</div>";
                            }
                            else
                            {
                                //Image is available
                                ?>
                                <img src="<?=SITEURL?>images/food/<?=$image_name?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                           <?php
                            }
                            ?>

                        </div>

                        <div class="food-menu-desc">
                            <h4><?= $title ?></h4>
                            <p class="food-price">$<?= $price ?></p>
                            <p class="food-detail">
                                <?=$description?>
                            </p>
                            <br>

                            <a href="<?=SITEURL?>order.php?food_id=<?=$id?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>

                    <?php


                }
            } else {
                //food is not available
                echo "<div class='error'>Food not available</div>";
            }

            ?>


            <div class="clearfix"></div>


        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->


<?php include 'partials-front/footer.php'; ?>