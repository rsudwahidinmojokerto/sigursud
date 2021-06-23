<?php

include "config/controller.php";
session_start();
$lg = new lsp();

if ($lg->sessionCheck() == "true") {
    if ($_SESSION['level'] == "Admin") {
        header("location:pageAdmin.php");
    } else if ($_SESSION['level'] == "Manager") {
        header("location:pageManager.php");
    } else if ($_SESSION['level'] == "Kasir") {
        header("location:pageKasir.php");
    } else if ($_SESSION['level'] == "Master") {
        header("location:pageMaster.php");
    }
}

if (isset($_POST['btnLogin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($response = $lg->login($username, $password)) {
        if ($response['response'] == "positive") {
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['level'] = $response['level'];
            if ($response['level'] == "Admin") {
                $response = $lg->redirect("pageAdmin.php");
            } else if ($response['level'] == "Manager") {
                $response = $lg->redirect("pageManager.php");
            } else if ($response['level'] == "Kasir") {
                $response = $lg->redirect("pageKasir.php");
            } else if ($response['level'] == "Master") {
                $response = $lg->redirect("pageMaster.php");
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Ksatria Wahidin">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Login</title>

    <!-- Fontfaces CSS-->
    <link href="assets/css/font-face.css" rel="stylesheet" media="all">
    <link href="assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="assets/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="assets/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="assets/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="assets/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="assets/css/theme.css" rel="stylesheet" media="all">
    <link href="assets/css/sweet-alert.css" rel="stylesheet">

</head>

<body class="animsition" style="background: url(assets/images/rsud.jpeg) no-repeat; background-size: cover;">
    <div class="page-wrapper">
        <div class="page-content">
            <div class="container">
                <br><br>
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="assets/images/icon/logo-sigu.png" alt="Sistem Informasi Gudang Logistik">
                            </a>
                        </div>
                        <br>
                        <div class="login-form">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input required class="au-input au-input--full" type="text" name="username" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input required class="au-input au-input--full" type="password" name="password" placeholder="Password">
                                </div>
                                <br>
                                <button name="btnLogin" class="au-btn au-btn--block au-btn--green m-b-20" type="submit"><i class="zmdi zmdi-key"></i> LOGIN</button>
                            </form>
                            <div class="register-link">
                                <p>Copyright © <?php echo date('Y'); ?> Ksatria Wahidin</p><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="assets/vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="assets/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="assets/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="assets/vendor/slick/slick.min.js">
    </script>
    <script src="assets/vendor/wow/wow.min.js"></script>
    <script src="assets/vendor/animsition/animsition.min.js"></script>
    <script src="assets/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="assets/vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="assets/vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="assets/vendor/circle-progress/circle-progress.min.js"></script>
    <script src="assets/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="assets/vendor/select2/select2.min.js">
    </script>
    <script src="assets/js/sweetalert.min.js"></script>

    <!-- Main JS-->
    <script src="assets/js/main.js"></script>
    <?php include "config/alert.php"; ?>
</body>

</html>
<!-- end document-->