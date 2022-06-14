<?php include 'partials/menu.php' ?>


    <!-- Main Content Section Starts -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Manage food</h1>

            <br><br>

            <?php
            if (isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            if (isset($_SESSION['delete'])) {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }
            if (isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            if (isset($_SESSION['unauthorize'])) {
                echo $_SESSION['unauthorize'];
                unset($_SESSION['unauthorize']);

             }
            if (isset($_SESSION['failed-remove'])) {
                echo $_SESSION['failed-remove'];
                unset($_SESSION['failed-remove']);
            }
            if (isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }


            ?>
            <br><br>
            <!-- Button to Add Admin-->
            <a href="<?= SITEURL ?>admin/add-food.php" class="btn-primary">Add Food</a>
            <br/> <br/><br/>

            <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
                <?php
                //Create a SQL Query to Get all the Food
                $sql = "SELECT * FROM `tbl_food` ";

                //Execute Query
                $res = mysqli_query($connect, $sql);

                //Count Rows to check whether we have foods or not
                $count = mysqli_num_rows($res);

                //Create Serial Number Variable and assigned the value as 1
                $sn = 1;

                if ($count > 0) {
                    //we have food in Database
                    //Get the foods from Database and display
                    while ($row = mysqli_fetch_assoc($res)) {
                        //Get the values from individual columns
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                        ?>
                        <tr>
                            <td><?= $sn++ ?>.</td>
                            <td><?= $title ?></td>
                            <td>$<?= $price= number_format($price,0); ?></td>
                            <td><?php
                                //Check whether we have image or not
                                if($image_name=="")
                                {
                                    //We don't have image, display error message
                                    echo "<div class='error'>Image Not Added</div>";
                                }
                                else
                                {
                                    //We have Image, display Image
                                    ?>
                                    <img src="<?=SITEURL; ?>images/food/<?=$image_name?>" width="100px">
                                        <?php
                                }
                                ?></td>
                            <td><?= $featured ?></td>
                            <td><?= $active ?></td>
                            <td>
                                <a href="<?= SITEURL ?>admin/update-food.php?id=<?=$id?>" class="btn-secondary"> Update Food</a>
                                <a href="<?= SITEURL ?>admin/delete-food.php?id=<?=$id?>&image_name=<?=$image_name?>" class="btn-danger"> Delete Food</a>
                            </td>
                        </tr>
                        <?php

                    }
                } else {
                    //Food Not Added in Database
                    echo "<tr><td colspan='7' class='error'>Food Not Added Yet</td> 

</tr>";
                }


                ?>


            </table>
        </div>
    </div>
    <!-- Main Content Section Starts -->
<?php include 'partials/footer.php' ?>