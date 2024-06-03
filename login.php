<?php
session_start();

include("config.php");
include("functions.php");
$ucapan = "Selamat Datang";

// Check if the user is already logged in using the session
if (isset($_SESSION['pengguna'])) {
    header("Location: index.php"); // Redirect to the index page if already logged in
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {

        // read from database
        $query = "SELECT * FROM user WHERE user_name = '$user_name' LIMIT 1";
        $result = mysqli_query($koneksi, $query);

        if ($result && mysqli_num_rows($result) > 0) {

            $user_data = mysqli_fetch_assoc($result);

            if ($user_data['password'] === $password) {
                $_SESSION['pengguna'] = $user_data;
                $_SESSION['user_id'] = $user_data['user_id'];

                // Check if "Remember Me" checkbox is selected
                if (isset($_POST['remember']) && $_POST['remember'] == 'on') {
                    // Set cookies with user information
                    setcookie('user_name', $user_name, time() + (86400 * 30), "/"); // Cookie expires after 30 days
                    setcookie('password', $password, time() + (86400 * 30), "/"); // Cookie expires after 30 days
                }

                header("Location: index.php");
                exit;
            }
        }

        $ucapan = "Username atau password salah!";
    } else {
        $ucapan = "Username atau password salah!";
    }
}

// Check if the "Remember Me" cookie is set
if (isset($_COOKIE['user_name']) && isset($_COOKIE['password'])) {
    $user_name = $_COOKIE['user_name'];
    $password = $_COOKIE['password'];

    // read from database
    $query = "SELECT * FROM user WHERE user_name = '$user_name' LIMIT 1";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);

        if ($user_data['password'] === $password) {
            $_SESSION['pengguna'] = $user_data;
            $_SESSION['user_id'] = $user_data['user_id'];

            header("Location: index.php");
            exit;
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        background: aliceblue;
    }

    .tombol:hover {
        background-color: crimson;
    }

    /*------------ Login container ------------*/

    .box-area {
        width: 600px;
        height: 600px;
    }

    /*------------ Right box ------------*/

    .right-box {
        padding: 40px 30px 40px 40px;
    }

    /*------------ Custom Placeholder ------------*/

    ::placeholder {
        font-size: 16px;
    }

    .rounded-4 {
        border-radius: 20px;
    }

    .rounded-5 {
        border-radius: 30px;
    }


    /*------------ For small screens------------*/

    @media only screen and (max-width: 768px) {

        .box-area {
            margin: 0 10px;

        }

        .left-box {
            height: 100px;
            overflow: hidden;
        }

        .right-box {
            padding: 20px;
        }

    }
</style>


<body>

    <!----------------------- Main Container -------------------------->

    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <!----------------------- Login Container -------------------------->

        <div class="row border rounded-5 p-3 bg-white shadow box-area">

            <!--------------------------- Left Box ----------------------------->

            <div class="rounded-4 d-flex justify-content-center align-items-center flex-column left-box" !important; ">
                <div class=" featured-image mb-3">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQmpcGhweq5EF159QCz2ut8QwvlmmOkHSklmQ&usqp=CAU" class="img-fluid" style="width: 180px; background-color: black; border-radius: 20px;">
            </div>
        </div>

        <!-------------------- ------ Right Box ---------------------------->

        <div class="text-center">
            <div class="row align-items-center">
                <div class="header-text mb-3">
                    <?php

                    ?>
                    <h2>
                        <?php
                        echo $ucapan;
                        ?>
                    </h2>
                    <p>Silahkan Login Menggunakan Akun Yang Sudah Ada.</p>


                </div>
                <form method="POST">
                    <div class="input-group mb-3">
                        <input type="text" id="username" name="user_name" class="form-control form-control-lg bg-light fs-6" placeholder="Username" required>
                    </div>
                    <div class="input-group mb-1">
                        <input type="password" id="password" name="password" class="form-control form-control-lg bg-light fs-6" <?php echo (isset($_COOKIE['password']) ? 'Value="'. $_COOKIE['password'] . '"' : 'placeholder="Password"');?> required>
                    </div>
                    <div class="input-group mb-4 mt-1 d-flex justify-content-between">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label for="remember" class="form-check-label text-secondary"><small>Remember Me</small></label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="submit" value="Login" class="btn btn-lg btn-primary tombol w-100 fs-6">
                    </div>

                </form>
                <p>Doesn't have Account? <a href="signUp.php">Sign Up</a></p>

            </div>
        </div>

    </div>
    </div>
</body>


</html>