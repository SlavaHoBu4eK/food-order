<?php
include '../config/constants.php';
?>
    <html>
    <head>
        <title>Login - Fod Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
    <div class="login">
        <h1 class="text-center">Login</h1>
        <br><br>

        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        if (isset($_SESSION['no-login-message'])) {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }
        ?>
        <br><br>

        <!-- Login  Form Starts Here-->
        <form action="" method="POST" class="text-center">
            Username: <br>
            <input type="text" name="username" placeholder="Enter Username"> <br><br>
            Password: <br>
            <input type="password" name="password" placeholder="Enter Password"> <br> <br>
            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br><br>
        </form>
        <!-- Login  Form Ends Here-->


        <p class="text-center">Created By <a href="https://www.instagram.com/accounts/login/?next=/slava__bogdanov/">Slava
                Bogdaov</a></p>
    </div>

    </body>
    </html>

<?php
// Check whether  the Submit Button  Clicked or Not

if (isset($_POST['submit'])) {
    //Process for login
    // 1. Get the Data from Login form
    //$username = $_POST['username'];
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    // $password = md5($_POST['password']);
    $raw_password = md5($_POST['password']);
    $password = mysqli_real_escape_string($connect, $raw_password);


    // 2.SQL to check whether the user with username and password exists or not
    $sql = "SELECT * FROM tbl_admin  WHERE `username` ='$username' AND `password`='$password'";

    // 3. Execute the Query
    $res = mysqli_query($connect, $sql);

    // 4. Count rows to check whether the user exists or not
    $count = mysqli_num_rows($res);

    if ($count == 1) {
//User Available and Login Success
        $_SESSION['login'] = "<div class='success'>Login Successful</div>";
        $_SESSION['user'] = $username;

        // Redirect to Home Page/Dashboard
        header('location:' . SITEURL . 'admin/');
    } else {
        // User Not Available and Login Fail
        $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match</div>";
        // Redirect to Home Page/Dashboard
        header('location:' . SITEURL . 'admin/login.php');
    }
}
?>