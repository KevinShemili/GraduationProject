<?php
session_start();
require "../database/config.php";
require "../scripts/getUser.php";

if (isset($_SESSION["user_id"])) {
    $userId = $_SESSION["user_id"];
    $user = getUserById_SelectAll($userId, $connection);
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

    <script src="../js/profile.js" defer></script>
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">

        <!-- Spinner -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner -->

        <!-- Modal1 Start -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle" style="color: black;">Success.</h5>
                    </div>
                    <div class="modal-body" id="modaltext">
                        Saving Changes...
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border mx-auto" role="status"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal1 End -->

        <!-- Modal2 Start -->
        <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle" style="color: black;">Remove Photo</h5>
                        <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete your profile photo?
                    </div>
                    <div class="modal-footer">
                        <button id="modalDelete" type="button" class="btn btn-secondary" data-dismiss="modal">Delete</button>
                        <button id="modalCancel" type="button" class="btn btn-primary">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal2 Start -->

        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="../index.php" class="navbar-brand mx-4 mb-3">
                    <h4 class="text-primary">Sentiment Analysis</h4>
                </a>
                <div class=" d-flex align-items-center ms-4 mb-4">
                    <?php
                    if (isset($_SESSION["user_id"])) {
                        if ($user["profilePhoto"] == "") {
                            echo '<div class="position-relative">
                                    <img class="rounded-circle" src="../img/default.png" alt="" style="width: 40px; height: 40px;">
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0">' . $user["username"] . '</h6>
                                </div>';
                        } else {
                            echo '<div class="position-relative">
                                    <img class="rounded-circle" src="../img/uploads/' . $user["profilePhoto"] . '" alt="" style="width: 40px; height: 40px;">
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0">' . $user["username"] . '</h6>
                                </div>';
                        }
                    }
                    ?>
                </div>
                <div class="navbar-nav w-100">
                    <a href="../index.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-laptop me-2"></i>Algorithms
                        </a>

                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="button.html" class="dropdown-item">VADER</a>
                            <a href="typography.html" class="dropdown-item">TEXT BLOB</a>
                            <a href="element.html" class="dropdown-item">ALGO 3</a>
                        </div>

                    </div>

                    <?php
                    if (isset($_SESSION["user_id"])) {
                        echo '<a href="analyse.php?id=' . $userId . '" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Analyse</a>';
                    } else {
                        echo '<a href="signin.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Sign In</a>
                        <a href="signup.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Sign Up</a>';
                    }
                    ?>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>

                <div class="navbar-nav align-items-center ms-auto">
                    <?php
                    if (isset($_SESSION["user_id"])) {
                        $username = $user["username"];
                        if ($user["profilePhoto"] == "") {
                            echo '<div class="nav-item dropdown">
                                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                            <img class="rounded-circle me-lg-2" src="../img/default.png" alt="" style="width: 40px; height: 40px;">
                                            <span class="d-none d-lg-inline-flex">' . $username . '</span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                                            <a href="#" class="dropdown-item">My Profile</a>
                                            <a href="../scripts/logout.php" class="dropdown-item">Log Out</a>
                                        </div>
                                    </div>';
                        } else {
                            echo '<div class="nav-item dropdown">
                                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                            <img class="rounded-circle me-lg-2" src="../img/uploads/' . $user["profilePhoto"] . '" alt="" style="width: 40px; height: 40px;">
                                            <span class="d-none d-lg-inline-flex">' . $username . '</span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                                            <a href="#" class="dropdown-item">My Profile</a>
                                            <a href="../scripts/logout.php" class="dropdown-item">Log Out</a>
                                        </div>
                                    </div>';
                        }
                    } else {
                        echo '<div style="margin-top: 20px; margin-bottom: 20px; color: #191C24; user-select: none; ">drop</div>';
                    }
                    ?>
                </div>
            </nav>
            <!-- Navbar End -->


            <!-- Edit Profile Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">

                    <div class="bg-secondary rounded p-10">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Edit your information</h6>
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-basic-tab" data-bs-toggle="pill" data-bs-target="#pills-basic" type="button" role="tab" aria-controls="pills-basic" aria-selected="true">Basic</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-photo-tab" data-bs-toggle="pill" data-bs-target="#pills-photo" type="button" role="tab" aria-controls="pills-photo" aria-selected="false">Profile Photo</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-keys-tab" data-bs-toggle="pill" data-bs-target="#pills-keys" type="button" role="tab" aria-controls="pills-keys" aria-selected="false">Keys</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="pills-tabContent">

                                <div class="tab-pane fade show active" id="pills-basic" role="tabpanel" aria-labelledby="pills-basic-tab">
                                    <h6 class="mb-4 mt-4">Credentials</h6>
                                    <div>
                                        <h5 id="invisible-error1" style="color: red;"></h5>
                                    </div>
                                    <form>
                                        <div class="mb-3">
                                            <label for="exampleInputUsername" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="exampleInputUsername" autocomplete="new-password">
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1" autocomplete="new-password">
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="exampleInputPassword1" autocomplete="new-password" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword2" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="exampleInputPassword2" autocomplete="new-password" disabled>
                                        </div>
                                        <input class="form-check-input" type="checkbox" id="checkbox1" checked>
                                        <label class="form-check-label" for="gridCheck1">
                                            Read Only
                                        </label><br>
                                        <button id="saveBtn1" type="button" class="btn btn-success mt-5">Save</button>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="pills-photo" role="tabpanel" aria-labelledby="pills-photo-tab">
                                    <div class="bg-secondary rounded h-100 p-4">
                                        <h6 class="mb-4">Change Photo</h6>
                                        <div>
                                            <h5 id="invisible-error2" style="color: red;"></h5>
                                        </div>
                                        <form id="imgForm" method="post">
                                            <div class="mb-3 text-center">
                                                <?php
                                                if ($user["profilePhoto"] == "") {
                                                    echo '<img class="rounded-circle me-lg-2 mx-auto mb-5" id="imagePreview" src="../img/default.png" alt="" style="width: 150px; height: 150px;">';
                                                } else {
                                                    echo '<img class="rounded-circle me-lg-2 mx-auto mb-5" id="imagePreview" src="../img/uploads/' . $user["profilePhoto"] . '" alt="" style="width: 150px; height: 150px;">';
                                                }
                                                ?>

                                                <input class="form-control bg-dark mt-3" type="file" id="imgInput" accept="image/jpg, image/jpeg, image/png">
                                            </div>
                                            <button id="saveBtn2" type="button" class="btn btn-success mt-5">Save</button>
                                            <button id="deletePhotoButton" type="button" class="btn btn-danger mt-5">Remove Photo</button>
                                        </form>

                                    </div>
                                </div>

                                <div class="tab-pane fade" id="pills-keys" role="tabpanel" aria-labelledby="pills-keys-tab">

                                    <h6 class="mb-4 mt-4">Twitter Secret Keys</h6>
                                    <div>
                                        <h5 id="invisible-error3" style="color: red;"></h5>
                                    </div>
                                    <form>
                                        <div class="mb-3">
                                            <label for="consumerKey" class="form-label">Consumer Key</label>
                                            <input type="text" class="form-control" id="consumerKey" autocomplete="new-password" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="consumerSecret" class="form-label">Consumer Secret</label>
                                            <input type="text" class="form-control" id="consumerSecret" autocomplete="new-password" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="accessToken" class="form-label">Access Token</label>
                                            <input type="text" class="form-control" id="accessToken" autocomplete="new-password" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="accessTokenSecret" class="form-label">Access Token Secret</label>
                                            <input type="text" class="form-control" id="accessTokenSecret" autocomplete="new-password" disabled>
                                        </div>
                                        <input class="form-check-input" type="checkbox" id="checkbox2" checked>
                                        <label class="form-check-label" for="gridCheck1">
                                            Read Only
                                        </label><br>
                                        <button id="saveBtn3" type="button" class="btn btn-success mt-5">Save</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <!-- Edit Profile End -->

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="index.php">Twitter Sentiment Analysis</a>, Graduation Project.
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <a href="">Kevin Shemili</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
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