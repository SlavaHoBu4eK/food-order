<?php include 'partials/menu.php'; ?>


    <div class="main-content">
        <div class="wrapper">
            <h1>Add Admin</h1>
            <br><br>

            <?php
            if (isset($_SESSION['add'])) //Checking weather the  session  is set of not
            {
                echo $_SESSION['add'];  //Display the session message if set
                unset($_SESSION['add']);  //Remove session message
            }
            ?>
            <form action="" method="post">

                <table class="tbl-30">
                    <tr>
                        <td>Full Name:</td>
                        <td><label>
                                <input type="text" name="full_name" placeholder="Enter Your Name">
                            </label></td>
                    </tr>
                    <tr>
                        <td>Username:</td>
                        <td><label>
                                <input type="text" name="username" placeholder="Your Username">
                            </label></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><label>
                                <input type="password" name="password" placeholder="Your Password">
                            </label></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                        </td>

                    </tr>

                </table>

            </form>
        </div>
    </div>

<?php include 'partials/footer.php'; ?>

<?php
// Process the value from Form and save it in Database

// Check whether Submit Button clicked or not
if (isset($_POST['submit'])) {
//Button clicked
    // echo 'Button clicked';
    //Get the Data from Form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    //SQL query to save the data into database
    $sql = "INSERT INTO `tbl_admin` SET
            `full_name`='$full_name', 
            `username`='$username',
             `password`='$password'";

    //3. Executing Query and saving data into database
    $res = mysqli_query($connect, $sql) or die(mysqli_error());

//4. Check whether the (Query is executed) data is inserted or not and display appropriate message
    if ($res == TRUE) {
//    // Create a Session Variable to Display Message
        $_SESSION['add'] = "<div class='success'>Admin added successfully</div> ";
        // Redirect page
        header("location:" . SITEURL . 'admin/manage-admin.php');
    } else {
        $_SESSION['add'] = "<div class='error'>Failed to Add Admin </div>";
//    // Redirect page

        header("location:" . SITEURL . 'admin/add-admin.php');

    }
}