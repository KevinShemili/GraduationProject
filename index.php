<?php
session_start();
require "database/config.php";
require "scripts/getUser.php";

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

    <link href="img/logo.png" rel="icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">

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
                <a href="index.php" class="navbar-brand mx-4 mb-3">
                    <h4 class="text-primary">Sentiment Analysis</h4>
                </a>
                <div class=" d-flex align-items-center ms-4 mb-4">
                    <?php
                    if (isset($_SESSION["user_id"])) {
                        if ($user["profilePhoto"] == "") {
                            echo '<div class="position-relative">
                                    <img class="rounded-circle" src="img/default.png" alt="" style="width: 40px; height: 40px;">
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0">' . $user["username"] . '</h6>
                                </div>';
                        } else {
                            echo '<div class="position-relative">
                                    <img class="rounded-circle" src="img/uploads/' . $user["profilePhoto"] . '" alt="" style="width: 40px; height: 40px;">
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0">' . $user["username"] . '</h6>
                                </div>';
                        }
                    }
                    ?>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-laptop me-2"></i>Algorithms
                        </a>

                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="views/vader.php" class="dropdown-item">VADER</a>
                            <a href="views/textblob.php" class="dropdown-item">TextBlob</a>
                            <a href="views/bert.php" class="dropdown-item">Bert</a>
                        </div>

                    </div>

                    <?php
                    if (isset($_SESSION["user_id"])) {
                        echo '<a href="views/analyse.php?id=' . $userId . '" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Analyse</a>';
                    } else {
                        echo '<a href="views/signin.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Sign In</a>
                        <a href="views/signup.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Sign Up</a>';
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
                                            <img class="rounded-circle me-lg-2" src="img/default.png" alt="" style="width: 40px; height: 40px;">
                                            <span class="d-none d-lg-inline-flex">' . $username . '</span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                                            <a href="views/profile.php?id=' . $user_id . '" class="dropdown-item">My Profile</a>
                                            <a href="scripts/logout.php" class="dropdown-item">Log Out</a>
                                        </div>
                                    </div>';
                        } else {
                            echo '<div class="nav-item dropdown">
                                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                            <img class="rounded-circle me-lg-2" src="img/uploads/' . $user["profilePhoto"] . '" alt="" style="width: 40px; height: 40px;">
                                            <span class="d-none d-lg-inline-flex">' . $username . '</span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                                            <a href="views/profile.php?id=' . $user_id . '" class="dropdown-item">My Profile</a>
                                            <a href="scripts/logout.php" class="dropdown-item">Log Out</a>
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
                    <div class="w-50">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">VADER</h6>
                            <a href="views/vader.php">Expand</a>
                        </div>
                        <div class="w-100">
                            <h6 class="mb-3">Advantages:</h6>
                            <p class="text-left pl-3">
                            <p>Pre-trained on social media data and domain-specific language</p>
                            <p>Can handle negation, intensifiers, and emoticons well</p>
                            <p>Computational efficiency and speed</p>
                            </p>
                            <h6 class="mt-4 mb-3">Disadvantages:</h6>
                            <p class="text-left pl-3">
                            <p>Relies on a fixed set of rules and heuristics</p>
                            <p>Can have difficulty with sarcasm and irony</li>
                            <p>May require additional preprocessing for non-English text</p>
                            </p>
                        </div>
                    </div>
                    <div class="w-50">
                        <div class="d-flex justify-content-center">
                            <i class="bi bi-speedometer2" style="font-size: 7rem; color: #00a000;"></i>
                        </div>
                        <div class="text-center mt-3">
                            <h6>Good Speed</h6>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary text-center rounded p-4 d-flex align-items-center">
                    <div class="w-50">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">BERT</h6>
                            <a href="views/bert.php">Expand</a>
                        </div>
                        <div class="w-100">
                            <h6 class="mb-3">Advantages:</h6>
                            <p class="text-left pl-3">
                            <p>State-of-the-art performance on many NLP tasks</p>
                            <p>Can handle complex language structure and nuances well</p>
                            <p>Can be fine-tuned for specific tasks and domains</p>
                            </p>
                            <h6 class="mt-4 mb-3">Disadvantages:</h6>
                            <p class="text-left pl-3">
                            <p>Large computational requirements and longer processing time</p>
                            <p>May require extensive domain-specific training data for optimal performance</li>
                            <p>May be prone to bias and ethical concerns if not properly trained and validated</p>
                            </p>
                        </div>
                    </div>
                    <div class="w-50">
                        <div class="d-flex justify-content-center">
                            <i class="bi bi-speedometer2" style="font-size: 7rem; color: #f73000;"></i>
                        </div>
                        <div class="text-center mt-3">
                            <h6>Below Average Speed</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary text-center rounded p-4 d-flex align-items-center">
                    <div class="w-50">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">TextBlob</h6>
                            <a href="views/textblob.php">Expand</a>
                        </div>
                        <div class="w-100">
                            <h6 class="mb-3">Advantages:</h6>
                            <p class="text-left pl-3">
                            <p>TextBlob comes with pre-built models for various NLP tasks</p>
                            <p>Provides a range of NLP functionalities such as sentiment analysis, part-of-speech tagging, and noun phrase extraction</p>
                            <p>TextBlob allows users to easily train their own models for specific tasks and domains</p>
                            </p>
                            <h6 class="mt-4 mb-3">Disadvantages:</h6>
                            <p class="text-left pl-3">
                            <p>Lower accuracy and performance compared to more advanced NLP models</p>
                            <p>May require additional customization and training for specific tasks and domains</li>
                            <p>May have difficulty with complex language structure and nuances</p>
                            </p>
                        </div>
                    </div>
                    <div class="w-50">
                        <div class="d-flex justify-content-center">
                            <i class="bi bi-speedometer2" style="font-size: 7rem; color: #00a000;"></i>
                        </div>
                        <div class="text-center mt-3">
                            <h6>Good Speed</h6>
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
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>