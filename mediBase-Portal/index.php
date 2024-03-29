<?php
include("../connection.php");

session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // Access user-specific information
    $doctor_id = $_SESSION["id"];
    $username = $_SESSION["username"];
}
// Change name on profile to doctor's name
$name_sql = "SELECT name, department FROM doctors WHERE id = $doctor_id";
$name_result = $conn->query($name_sql);

if ($name_result && $name_result->num_rows > 0) {
    $row = $name_result->fetch_assoc();
    $doctor_name = $row["name"];
    $doctor_department = $row["department"];
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>mediBase Portal - Home</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="mediBase, EHR, Healthcare" name="keywords">
    <meta content="mediBase is a project on Information Systems in Healthcare by Jouhanzasom" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
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

        <!-- Welcome Back Slide-in (Based on Session Cookie) Start -->
        <div class="alert alert-success" id="welcomeAlert" style="display: none; position: fixed; top: -100px; left: 50%; transform: translateX(-50%); z-Index: 2000" role="alert">
            Welcome back, <span id="username"></span>!
        </div>
        <?php
            $showWelcomeBack = isset($_GET['login']) && $_GET['login'] === 'success';
        ?>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var showWelcomeBack = <?php echo json_encode($showWelcomeBack); ?>;
                var user = getCookie("customSessionUser");

                function checkForWelcomeBack() {
                    var user = getCookie("customSessionUser");
                    if (user) {
                        var welcomeAlert = document.getElementById("welcomeAlert");
                        var usernameSpan = document.getElementById("username");
                        usernameSpan.textContent = user;
                        welcomeAlert.style.display = "block";
                        welcomeAlert.classList.add("slide-in");

                        setTimeout(function () {
                        welcomeAlert.classList.replace("slide-in", "slide-out");
                        }, 3000);
                    }
                }

                if (user && showWelcomeBack) {
                    checkForWelcomeBack()
                }
            });
        </script>
        <!-- Welcome Back Popup (Based on Session Cookie) End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.php" class="navbar-brand mx-4 mb-3">
                    <img src="img/logo.png" alt="mediBase logo" style="margin-left: -5%;">
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                        </div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php echo $doctor_name; ?></h6>
                        <span><?php echo $doctor_department; ?></span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.php" class="nav-item nav-link active"><i class="fa fa-house me-2"></i>Home</a>
                    <a href="patients.php" class="nav-item nav-link"><i class="fa fa-hospital-user me-2"></i>My
                        Patients</a>
                    <a href="patient-registration.php" class="nav-item nav-link"><i class="fa fa-user-plus me-2"></i>Register Patient</a>
                    <a href="signin.php" class="nav-item nav-link"><i class="fa fa-right-from-bracket me-2"></i>Log
                        out</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="index.php" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control bg-dark border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex"><?php echo $doctor_name; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="my-profile.php" class="dropdown-item openPopupBtn" data-popup-target="doctorInfoPopup"><i class="fa fa-user-doctor me-3"></i>My Profile</a>
                            <a href="#" class="dropdown-item openPopupBtn" data-popup-target="settingsPopup"><i class="fa fa-gear me-3"></i>Settings</a>
                            <a href="signin.php" class="dropdown-item"><i class="fa fa-right-from-bracket me-3"></i>Log
                                Out</a>
                        </div>
                        <!-- Settings Message Popup -->
                        <div id="settingsPopup" class="popup">
                            <div class="popup-content">
                                <span class="close">&times;</span>
                                <p>For settings changes, please contact the Admin.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Greeting Doctor Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <h2><span id="doctorGreeting"></span>, Dr. <?php echo $doctor_name; ?>!</h2>
                </div>
            </div>
            <!-- Greeting Doctor End -->

            <!-- External Links Tiles Row-1 Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-4 external-link-tile">
                        <a href="https://www.medscape.com/" target="_blank" rel="noopener noreferrer">
                            <div class="bg-secondary rounded d-flex align-items-center p-4">
                                <i class="fa fa-book-medical fa-3x text-primary"></i>
                                <div class="ms-3">
                                    <p class="mb-2">Medscape &nbsp;<i class="fa fa-arrow-up-right-from-square"></i></p>
                                    <h6 class="mb-0">Medical Reference</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-4 external-link-tile">
                        <a href="https://www.drugs.com/" target="_blank" rel="noopener noreferrer">
                            <div class="bg-secondary rounded d-flex align-items-center p-4">
                                <i class="fa fa-pills fa-3x text-primary"></i>
                                <div class="ms-3">
                                    <p class="mb-2">Drugs.com &nbsp;<i class="fa fa-arrow-up-right-from-square"></i></p>
                                    <h6 class="mb-0">Drug Database</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-4 external-link-tile">
                        <a href="https://www.cdc.gov/index.htm" target="_blank" rel="noopener noreferrer">
                            <div class="bg-secondary rounded d-flex align-items-center p-4">
                                <i class="fa fa-newspaper fa-3x text-primary"></i>
                                <div class="ms-3">
                                    <p class="mb-2">CDC &nbsp;<i class="fa fa-arrow-up-right-from-square"></i></p>
                                    <h6 class="mb-0">Latest Health News</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- External Links Tiles Row-1 End -->

            <!-- External Links Tiles Row-2 Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-4 external-link-tile">
                        <a href="https://www.thelancet.com/" target="_blank" rel="noopener noreferrer">
                            <div class="bg-secondary rounded d-flex align-items-center p-4">
                                <i class="fa fa-book-journal-whills fa-3x text-primary"></i>
                                <div class="ms-3">
                                    <p class="mb-2">The Lancet &nbsp;<i class="fa fa-arrow-up-right-from-square"></i>
                                    </p>
                                    <h6 class="mb-0">Medical Journals</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-4 external-link-tile">
                        <a href="https://www.who.int/data/gho" target="_blank" rel="noopener noreferrer">
                            <div class="bg-secondary rounded d-flex align-items-center p-4">
                                <i class="fa fa-disease fa-3x text-primary"></i>
                                <div class="ms-3">
                                    <p class="mb-2">WHO GHO &nbsp;<i class="fa fa-arrow-up-right-from-square"></i></p>
                                    <h6 class="mb-0">Diseases Database</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-4 external-link-tile">
                        <a href="https://www.mdcalc.com/" target="_blank" rel="noopener noreferrer">
                            <div class="bg-secondary rounded d-flex align-items-center p-4">
                                <i class="fa fa-person-circle-question fa-3x text-primary"></i>
                                <div class="ms-3">
                                    <p class="mb-2">MDCalc &nbsp;<i class="fa fa-arrow-up-right-from-square"></i></p>
                                    <h6 class="mb-0">Decision Support Tool</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- External Links Tiles Row-2 End -->

            <!-- Widgets Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-secondary rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Calendar</h6>
                            </div>
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Widgets End -->


            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">mediBase</a>, All Rights Reserved.
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed by <a href="https://github.com/so-mb/mediBase">Jouhanzasom&reg;</a>
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

    <!-- Main Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
