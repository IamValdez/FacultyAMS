<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
  


// Fetch user role counts from the database
$sql = "SELECT role, COUNT(*) as count FROM tblfaculty GROUP BY role";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_ASSOC);

// Initialize role count array with default values
$roleCounts = [
    'Admin' => 0,
    'Faculty' => 0,
    'Student' => 0,
];

// Update role count array with actual values from the database
foreach ($results as $result) {
    switch ($result['role']) {
        case 1:
            $roleCounts['Admin'] = $result['count'];
            break;
        case 2:
            $roleCounts['Faculty'] = $result['count'];
            break;
        case 3:
            $roleCounts['Student'] = $result['count'];
            break;
    }
}


$sqlAppointments = "SELECT AppointmentDate, COUNT(*) as count FROM tblappointment GROUP BY AppointmentDate";
$queryAppointments = $dbh->prepare($sqlAppointments);
$queryAppointments->execute();
$appointmentsData = $queryAppointments->fetchAll(PDO::FETCH_ASSOC);

// Retrieves the faculty ID from the session
$facid = $_SESSION['famsid'];

// Constructs a database query to select all approved appointments for the current faculty member
$sql = "SELECT * FROM tblappointment WHERE Status='Approved' AND Faculty=:facid";
$query = $dbh->prepare($sql);
$query->bindParam(':facid', $facid, PDO::PARAM_STR);
$query->execute();

// Fetches the query results as an array of objects
$results = $query->fetchAll(PDO::FETCH_OBJ);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Account</title>
    <link rel="icon" href="images/logo.jpg">
    <link rel="stylesheet" href="libs/bower/fullcalendar/dist/fullcalendar.min.css">
    <script src="libs/bower/fullcalendar/dist/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="./assets/css/calendarMod.css">
    <link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
    <link rel="stylesheet" href="libs/bower/animate.css/animate.min.css">
    <link rel="stylesheet" href="libs/bower/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/core.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
    <script src="libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>
    <script>
        Breakpoints();
    </script>
</head>

<body class="menubar-left menubar-unfold menubar-light theme-primary">

    <?php include_once('includes/super-header.php'); ?>

    <?php include_once('includes/super-sidebar.php'); ?>

    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">



    
            
       
        </div>
    </main>
    <!--========== END app main -->

    <?php include_once('includes/footer.php'); ?>

    <?php include_once('includes/customizer.php'); ?>

    <!-- build:js assets/js/core.min.js -->
    <script src="libs/bower/jquery/dist/jquery.js"></script>
    <script src="libs/bower/jquery-ui/jquery-ui.min.js"></script>
    <script src="libs/bower/jQuery-Storage-API/jquery.storageapi.min.js"></script>
    <script src="libs/bower/bootstrap-sass/assets/javascripts/bootstrap.js"></script>
    <script src="libs/bower/jquery-slimscroll/jquery.slimscroll.js"></script>
    <script src="libs/bower/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
    <script src="libs/bower/PACE/pace.min.js"></script>
    <!-- endbuild -->

    <!-- build:js assets/js/app.min.js -->
    <script src="assets/js/library.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/app.js"></script>
    <!-- endbuild -->

    <script src="libs/bower/moment/moment.js"></script>

    <script src="assets/js/fullcalendar.js"></script>

    <!-- build:js assets/js/app.min.js -->
    <script src="libs/bower/jquery/dist/jquery.js"></script>
    <script src="libs/bower/jquery-ui/jquery-ui.min.js"></script>
    <script src="libs/bower/moment/moment.js"></script>

    <!-- endbuild -->
    <script src="assets/js/core.js"></script>
    <script src="assets/js/app.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>

    <!-- jQuery -->
<script src="libs/bower/jquery/dist/jquery.js"></script>

<!-- Bootstrap JS -->
<script src="libs/bower/bootstrap-sass/assets/javascripts/bootstrap.js"></script>

<!-- Your Custom Scripts -->
<script src="assets/js/library.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/js/app.js"></script>






</body>

</html>
