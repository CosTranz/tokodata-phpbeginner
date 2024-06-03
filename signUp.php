<?php
session_start();

include("config.php");
include("functions.php");
$ucapan = "Selamat Datang";


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // something was posted
    $name = $_POST['name'];
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {

        // check if username already exists
        $query = "SELECT * FROM user WHERE user_name = '$user_name'";
        $result = mysqli_query($koneksi, $query);
        if (mysqli_num_rows($result) > 0) {
            // username already exists
            echo '<script>alert("Username sudah digunakan. Silakan gunakan username lain.");</script>';
        } else {
            // save to database
            $user_id = random_num(9);
            $query = "INSERT INTO user (user_id, name, user_name, password) VALUES ('$user_id', '$name', '$user_name', '$password')";

            mysqli_query($koneksi, $query);
            header("Location: login.php");
            die;
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
    <title>Sign Up</title>
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
        height: 620px;
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
                    <p>Silahkan memasukkan data yang diperlukan</p>


                </div>
                <form method="POST" name="signUp" onsubmit="return validateInput()">
                    <div class="input-group mb-3">
                        <input type="text" id="username" name="name" class="form-control form-control-lg bg-light fs-6" placeholder="Name" required>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" id="username" name="user_name" class="form-control form-control-lg bg-light fs-6" placeholder="Username" required>
                    </div>
                    <div class="input-group mb-1">
                        <input type="password" id="password" name="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password" required>
                    </div>
                    <div class="input-group mb-4 mt-1 d-flex justify-content-between">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="formCheck">
                            <label for="formCheck" class="form-check-label text-secondary" required><small>Agree all
                                    term of policy</small></label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="submit" value="SignUp" class="btn btn-lg btn-primary tombol w-100 fs-6">
                    </div>

                </form>
                <p>Already have Account? <a href="login.php">Login</a></p>


            </div>
        </div>

    </div>
    </div>
</body>
<script>
    function validateInput() {
        var input = document.forms["signUp"]["password"].value;
        var usr = document.forms["signUp"]["user_name"].value;
        if (input.length < 4) {
            alert("Password minimal harus 4 karakter.");
            return false;
        }
        if (usr.length < 3) {
            alert("Username minimal harus 3 karakter.");
            return false;
        }
    }
    if (!isNaN(document.forms["signUp"]["user_name"].value)) {
        alert("Username minimal harus terdapat 1 karakter huruf");
        document.forms["signUp"]["user_name"].focus();
        return false;
    }
    return true;
</script>

</html>