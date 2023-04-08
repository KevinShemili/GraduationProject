<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (isset($_SESSION['user_id'])) {
    header('location:../index.php');
    die();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Twitter Sentiment Analysis</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="../img/logo.png" rel="icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <link href="../css/style.css" rel="stylesheet">

    <script src="../js/signup.js" defer></script>
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">

        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle" style="color: black;">Successful Signup.</h5>
                    </div>
                    <div class="modal-body">
                        Redirecting to login...
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border mx-auto" role="status"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Sign Up Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3>Sign Up</h3>
                        </div>

                        <div>
                            <h5 id="invisible-error" style="color: red;"></h5>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingText" placeholder="Username" name="username" autocomplete="off">
                            <label for="floatingText">Username</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" placeholder="Email" name="email" autocomplete="off">
                            <label for="floatingInput">Email address</label>
                        </div>

                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" autocomplete="off">
                            <label for="floatingPassword">Password</label>
                        </div>

                        <button type="submit" id="button" class="btn btn-primary py-3 w-100 mb-4">Sign Up</button>
                        <p class="text-center mb-0">Already have an Account? <a href="signin.php">Sign In</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign Up End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/chart/chart.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/tempusdominus/js/moment.min.js"></script>
    <script src="../lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="../lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>

</body>

</html>