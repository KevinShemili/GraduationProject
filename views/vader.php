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
                            <a href="" class="dropdown-item">VADER</a>
                            <a href="textblob.php" class="dropdown-item">TextBlob</a>
                            <a href="bert.php" class="dropdown-item">Bert</a>
                        </div>

                    </div>

                    <?php
                    if (isset($_SESSION["user_id"])) {
                        echo '<a href="../views/analyse.php?id=' . $userId . '" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Analyse</a>';
                    } else {
                        echo '<a href="../views/signin.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Sign In</a>
                        <a href="../views/signup.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Sign Up</a>';
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
                        $user_id = $_SESSION["user_id"];
                        if ($user["profilePhoto"] == "") {
                            echo '<div class="nav-item dropdown">
                                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                            <img class="rounded-circle me-lg-2" src="../img/default.png" alt="" style="width: 40px; height: 40px;">
                                            <span class="d-none d-lg-inline-flex">' . $username . '</span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                                            <a href="../views/profile.php?id=' . $user_id . '" class="dropdown-item">My Profile</a>
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
                                            <a href="../views/profile.php?id=' . $user_id . '" class="dropdown-item">My Profile</a>
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


            <!-- Algorithms Section -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary text-center rounded p-4 d-flex align-items-center">
                    <div class="w-100">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">VADER</h6>
                        </div>
                        <div class="w-100">
                            <p class="text-left pl-3 mb-4">
                                VADER (Valence Aware Dictionary and sEntiment Reasoner) is a rule-based sentiment analysis tool
                                specifically designed for sentiment analysis of social media texts. It is pre-trained on social media
                                data and domain-specific language, making it an effective tool for sentiment analysis on Twitter,
                                Facebook, and other social media platforms. VADER uses a lexicon of words and rules to determine
                                the sentiment of a text, and can handle negation, intensifiers, and emoticons well.
                            </p>
                            <p class="text-left pl-3">
                                VADER is computationally efficient and fast, making it an ideal tool for real-time sentiment
                                analysis of social media data. However, it relies on a fixed set of rules and heuristics and can
                                have difficulty with sarcasm and irony. It may also require additional preprocessing for non-English
                                text. Overall, VADER is a useful tool for sentiment analysis of social media data, especially for
                                real-time analysis and monitoring of social media sentiment.
                            </p>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Algorithms End -->

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="../index.php">Twitter Sentiment Analysis</a>, Graduation Project.
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