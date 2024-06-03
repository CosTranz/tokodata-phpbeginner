<?php
session_start();

include 'config.php';

$user = null;
if (isset($_SESSION['pengguna'])) {
  $user = $_SESSION['pengguna'];
  $idusr = $user['user_id'];
  $nama = $user['name'];
} else {
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TOKO DATA</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
    .navbar {
      background-color: #000080;
      padding: 10px;
    }

    .navbar h3 {
      color: #fff;
    }

    .anav {
      text-decoration: none;
      color: white;
    }

    .container {
      margin-top: 20px;
    }

    .btn-danger {
      margin-left: 10px;
    }

    .table {
      margin-top: 20px;
    }

    .pagination {
      margin-top: 20px;
      display: flex;
      justify-content: center;
    }

    .pagination a {
      margin: 0 5px;
    }
  </style>
</head>

<body>
  <nav class="navbar">
    <div class="container">
      <h3><a href="index.php" class="anav">BUKUTOPIA</a></h3>
      <div class="d-flex">
        <?php
        if ($user) {
          echo '<span style="color: white;" class="me-2">' . $nama . ' (' . $idusr . ')</span>';
          echo '<a href="logout.php" class="btn btn-sm btn-danger me-2">Logout</a>';
          echo '<a href="tabel.php" class="btn btn-sm btn-primary me-2">Tabel</a>';
          echo '<a href="gantiakun.php" class="btn btn-sm btn-primary">Ganti Akun</a>';
        } else {
          echo '<a href="login.php" class="btn btn-sm btn-primary">Login</a>';
        }
        ?>
      </div>


    </div>
  </nav>

  <div class="container px-2 py-3" id="custom-cards">
    <h2 class="pb-2 border-bottom">Comic Cards</h2>

    <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
      <div class="col">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('img/spiderman.jpg');">
          <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
            <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Power, Athletic, Instinct</h3>
            <ul class="d-flex list-unstyled mt-auto">
              <li class="me-auto">

              </li>
              <li class="d-flex align-items-center me-3">
                <svg class="bi me-2" width="1em" height="1em">
                  <use xlink:href="#geo-fill" />
                </svg>
                <small>Spiderman</small>
              </li>
              <li class="d-flex align-items-center">
                <svg class="bi me-2" width="1em" height="1em">
                  <use xlink:href="#calendar3" />
                </svg>
                <small>3d</small>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('img/batman2.jpeg');">
          <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
            <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Strongest, Darkness, Batman</h3>
            <ul class="d-flex list-unstyled mt-auto">
              <li class="me-auto">

              </li>
              <li class="d-flex align-items-center me-3">
                <svg class="bi me-2" width="1em" height="1em">
                  <use xlink:href="#geo-fill" />
                </svg>
                <small>Batman</small>
              </li>
              <li class="d-flex align-items-center">
                <svg class="bi me-2" width="1em" height="1em">
                  <use xlink:href="#calendar3" />
                </svg>
                <small>4d</small>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('img/iron23.jpg');">
          <div class="d-flex flex-column h-100 p-5 pb-3 text-shadow-1">
            <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Smartest, Intelligent, Rich</h3>
            <ul class="d-flex list-unstyled mt-auto">
              <li class="me-auto">
              </li>
              <li class="d-flex align-items-center me-3">
                <svg class="bi me-2" width="1em" height="1em">
                  <use xlink:href="#geo-fill" />
                </svg>
                <small>Iron Man</small>
              </li>
              <li class="d-flex align-items-center">
                <svg class="bi me-2" width="1em" height="1em">
                  <use xlink:href="#calendar3" />
                </svg>
                <small>5d</small>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>

</html>