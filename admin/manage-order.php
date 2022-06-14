<?php include 'partials/menu.php' ?>


    <!-- Main Content Section Starts -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Order</h1>

            <br/> <br/><br/>

            <?php
            if (isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
            ?>
            <br><br>

            <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Food</th>
                    <th>Price</th>
                    <th>Qty.</th>
                    <th>Total</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Customer Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>

                <?php
                //Get all the orders from database
                $sql = "SELECT * FROM `tbl_order` ORDER BY `id` DESC";
                //Execute Query
                $res = mysqli_query($connect, $sql);
                //count the rows
                $count = mysqli_num_rows($res);

                $sn = 1;
                if ($count > 0) {
                    //Order available
                    while ($row = mysqli_fetch_assoc($res)) {
                        //Get all the order details
                        $id = $row['id'];
                        $food = $row['food'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $total = $row['total'];
                        $order_date = $row['order_date'];
                        $status = $row['status'];
                        $customer_name = $row['customer_name'];
                        $customer_contact = $row['customer_contact'];
                        $customer_email = $row['customer_email'];
                        $customer_address = $row['customer_address'];
                        ?>

                        <tr>
                            <td><?= $sn++ ?>.</td>
                            <td><?= $food ?></td>
                            <td><?= $price ?></td>
                            <td><?= $qty ?></td>
                            <td><?= $total ?></td>
                            <td><?= $order_date ?></td>

                            <td>
                                <?php
                                //Ordered, on Delivery, Delivered, Cancelled
                                if($status=="Ordered")
                                {
                                    echo "<label>$status</label>";
                                }
                                elseif($status=="On Delivery")
                                {
                                    echo "<label style='color:orange'>$status</label>";
                                }
                                elseif($status=="Delivered")
                                {
                                    echo "<label style='color:green'>$status</label>";
                                }
                                elseif($status=="Cancelled")
                                {
                                    echo "<label style='color:red'>$status</label>";
                                }
                                ?>
                            </td>

                            <td><?= $customer_name ?></td>
                            <td><?= $customer_contact ?></td>
                            <td><?= $customer_email ?></td>
                            <td><?= $customer_address ?></td>
                            <td>
                                <a href="<?= SITEURL ?>admin/update-order.php?id=<?= $id ?>" class="btn-secondary">
                                    Update Order</a>

                            </td>
                        </tr>
                        <?php


                    }
                } else {
                    //Order not available
                    echo "<tr><td colspan='12' class='error'>Orders not Available</td></tr>";
                }
                ?>


            </table>
        </div>
    </div>
    <!-- Main Content Section Starts -->
<?php include 'partials/footer.php' ?>