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
    <title>mediBase Portal - My Profile</title>
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


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.php" class="navbar-brand mx-4 mb-3">
                    <img src="img/logo.png" alt="mediBase logo" style="margin-left: -5%;">
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php echo $doctor_name; ?></h6>
                        <span><?php echo $doctor_department; ?></span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.php" class="nav-item nav-link"><i class="fa fa-house me-2"></i>Home</a>
                    <a href="patients.php" class="nav-item nav-link"><i class="fa fa-hospital-user me-2"></i>My Patients</a>
                    <a href="patient-registration.php" class="nav-item nav-link"><i class="fa fa-user-plus me-2"></i>Register Patient</a>
                    <a href="signin.php" class="nav-item nav-link"><i class="fa fa-right-from-bracket me-2"></i>Log out</a>
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
                            <a href="my_profile.php" class="dropdown-item openPopupBtn" data-popup-target="doctorInfoPopup"><i class="fa fa-user-doctor me-3"></i>My Profile</a>
                            <a href="#" class="dropdown-item openPopupBtn" data-popup-target="settingsPopup"><i class="fa fa-gear me-3"></i>Settings</a>
                            <a href="signin.php" class="dropdown-item"><i class="fa fa-right-from-bracket me-3"></i>Log Out</a>
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

            <!-- TO BE DELETED -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <span class="close">&times;</span>
                    <h2 class="mb-4">Your Profile Details</h2>
                    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                        <p><strong>First Name: </strong><span class="doctor-editable-field">Alice</span></p>
                        <p><strong>Last Name: </strong><span class="doctor-editable-field">Chaltikyan</span></p>
                        <p><strong>Date of Birth: </strong><span>02.01.1988</span></p>
                        <p><strong>Gender: </strong><span>Female</span></p>
                        <p><strong>Nationality: </strong><span class="doctor-editable-field">Germany</span></p>
                        <p><strong>Email Address: </strong><span class="doctor-editable-field">lukas.walker@gmail.com</span></p>
                        <p><strong>Phone No.:: </strong><span class="doctor-editable-field">06428490257923</span></p>
                        <p><strong>Address: </strong><span class="doctor-editable-field">Alois-Gäßl-Straße 4</span></p>
                        <p><strong>License No.: </strong><span class="doctor-editable-field">8239629247</span></p>
                        <p>
                            <label for="department"><strong>Department: </strong></label>
                            <select name="Department" id="department" class="doctor-editable-field">
                                <option value="Cardiology">Cardiology</option>
                                <option value="Orthopedics">Orthopedics</option>
                                <option value="Dermatology">Dermatology</option>
                            </select>
                        </p>
                        <p>
                            <label for="position"><strong>Position (role): </strong></label>
                            <select name="Position" id="position" class="doctor-editable-field">
                                <option value="Cardiology">Medical Doctor (MD)</option>
                                <option value="Orthopedics">Consultant</option>
                            </select>
                        </p>
                        <p><strong>Username: </strong><span class="doctor-editable-field">a.chaltikan</span></p>
                        <p><strong>Password: </strong><span class="doctor-editable-field">ljXVk6bBKtvbhqK</span></p>
                        <p><strong>Emergency Contact Name: </strong><span class="doctor-editable-field">Divi Müller</span></p>
                        <button class="btn btn-sm btn-primary" id="editDoctorInfoBtn"><i class="fa fa-user-pen me-2"></i>Edit Info</button>
                    </form>
                </div>
            </div>
            <!-- TO BE DELETED -->

            <!-- Patient Info Form -->
            <div id="patientInfoPopup" class="popup" style="<?php echo isset($patient_info_data) ? 'display: block;' : 'display: none;'; ?>">
                        <div class="popup-content">
                            <span class="close">&times;</span>
                            <h2>Your Profile Information</h2>
                            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                                <!-- Display patient information if available -->
                                <?php if ($patient_info_data) : ?>
                                    <p><strong>Name: </strong><input type="text" name="first_name" value="<?php echo htmlspecialchars($patient_info_data['first_name']); ?>"></p>
                                    <p><strong>Date of Birth: </strong><span><?php
                                                                                $dateObject = new DateTime($patient_info_data['birthdate']);
                                                                                $formattedDate = $dateObject->format('d-m-Y');
                                                                                echo htmlspecialchars($formattedDate); ?></span></p>
                                    <p><strong>Gender: </strong><span><?php echo htmlspecialchars($patient_info_data['gender']); ?></span></p>
                                    <p><strong>Nationality: </strong><input type="text" name="nationality" value="<?php echo htmlspecialchars($patient_info_data['nationality']); ?>"></p>
                                    <p><strong>Email Address: </strong><input type="email" name="email" value="<?php echo htmlspecialchars($patient_info_data['email']); ?>" style="width: 25%;" disabled></p>
                                    <p><strong>Phone No.: </strong><input type="tel" name="mobile_phone" value="<?php echo htmlspecialchars($patient_info_data['mobile_phone']); ?>" disabled></p>
                                    <p><strong>Address: </strong><input type="text" name="blood_group" value="<?php echo htmlspecialchars($patient_info_data['blood_group']); ?>" disabled></p>
                                    <p><strong>License No.: </strong><input type="text" name="blood_group" value="<?php echo htmlspecialchars($patient_info_data['blood_group']); ?>" disabled></p>
                                    <p><strong>Department: </strong><input type="text" name="blood_group" value="<?php echo htmlspecialchars($patient_info_data['blood_group']); ?>" disabled></p>
                                    <p><strong>Position (role): </strong><input type="text" name="blood_group" value="<?php echo htmlspecialchars($patient_info_data['blood_group']); ?>" disabled></p>
                                    <p><strong>Username: </strong><input type="text" name="blood_group" value="<?php echo htmlspecialchars($patient_info_data['blood_group']); ?>" disabled></p>
                                    <p><strong>Password: </strong><input type="text" name="blood_group" value="<?php echo htmlspecialchars($patient_info_data['blood_group']); ?>" disabled></p>
                                    <p><strong>Emergency Contact Name: </strong><input type="text" name="blood_group" value="<?php echo htmlspecialchars($patient_info_data['blood_group']); ?>" disabled></p>

                                    <input type="hidden" name="patient_id" value="<?php echo htmlspecialchars($patient_info_data['id']); ?>">
                                    <button type="button" class="btn btn-sm btn-primary" id="editPatientInfoBtn" name="editPatientInfoBtn"><i class="fa fa-user-pen me-2"></i>Edit Info</button>
                                    <button type="submit" class="btn btn-sm btn-primary" id="updatePatientProfile" name="update_patient_profile" style="display: none; margin: 25px 0px 0px"><i class="fa fa-save me-2"></i>Save Changes</button>
                                <?php else : ?>
                                    <p>No patient information available.</p>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>

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

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
