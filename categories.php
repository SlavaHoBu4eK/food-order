<?php include 'partials-front/menu.php'; ?>


    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
            //Display All the Categories that are active
            $sql = "SELECT * FROM `tbl_category` WHERE `active`='Yes'";

            //Execute the Query
            $res = mysqli_query($connect, $sql);

            //Count Rows
            $count = mysqli_num_rows($res);

            //Check whether categories available or not
            if ($count > 0) {
                //Categories available
                while($row=mysqli_fetch_assoc($res))
                {
                    //Get the Values
                    $id=$row['id'];
                    $title=$row['title'];
                    $image_name=$row['image_name'];
                    ?>
                    <a href="<?=SITEURL?>category-foods.php?category_id=<?=$id?>">
                        <div class="box-3 float-container">
                            <?php
                            if($image_name=="")
                            {
                                //image not available
                                echo "<div class='error'>Image not fund</div>";
                            }
                            else
                            {
                                //image  available
                                ?>

                                <img src="<?=SITEURL?>images/category/<?=$image_name?>" alt="Pizza" class="img-responsive img-curve">
                                    <?php
                            }
                            ?>


                            <h3 class="float-text text-white"><?=$title?></h3>
                        </div>
                    </a>
                        <?php
                }
            } else {
                // Categories is not available
                echo "<div class='error'>Category not found</div>";
            }

            ?>




            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


<?php include 'partials-front/footer.php'; ?>