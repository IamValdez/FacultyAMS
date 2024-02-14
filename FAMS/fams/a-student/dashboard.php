<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (!isset($_SESSION['famsid'])) {
 
    header("Location: login.php");
    exit();
}



if (isset($_GET['logout'])) {
    
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}


// Fetch data from the database
$facid = $_SESSION['famsemailid'];
$sql_approved = "SELECT COUNT(*) as total FROM tblappointment WHERE Status='approved' AND user_ID=:facid";
$query_approved = $dbh->prepare($sql_approved);
$query_approved->bindParam(':facid', $facid, PDO::PARAM_STR);
$query_approved->execute();
$result_approved = $query_approved->fetch(PDO::FETCH_ASSOC);

$sql_cancelled = "SELECT COUNT(*) as total FROM tblappointment WHERE Status='Cancelled' AND user_ID=:facid";
$query_cancelled = $dbh->prepare($sql_cancelled);
$query_cancelled->bindParam(':facid', $facid, PDO::PARAM_STR);
$query_cancelled->execute();
$result_cancelled = $query_cancelled->fetch(PDO::FETCH_ASSOC);

$sql_pending = "SELECT COUNT(*) as total FROM tblappointment WHERE Status IS NULL AND user_ID=:facid";
$query_pending = $dbh->prepare($sql_pending);
$query_pending->bindParam(':facid', $facid, PDO::PARAM_STR);
$query_pending->execute();
$result_pending = $query_pending->fetch(PDO::FETCH_ASSOC);

$sql_total = "SELECT COUNT(*) as total FROM tblappointment WHERE user_ID=:facid";
$query_total = $dbh->prepare($sql_total);
$query_total->bindParam(':facid', $facid, PDO::PARAM_STR);
$query_total->execute();
$result_total = $query_total->fetch(PDO::FETCH_ASSOC);

// Assign fetched data to variables
$approved_count = $result_approved['total'];
$cancelled_count = $result_cancelled['total'];
$pending_count = $result_pending['total']; // New variable for pending count
$total_count = $result_total['total'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
	
	<title>Student Account</title>

	<link rel="icon" href="images/logo.jpg">
	
<link rel="stylesheet" href="libs/bower/fullcalendar/dist/fullcalendar.min.css">
 	 <script src="libs/bower/fullcalendar/dist/fullcalendar.min.js"></script> 
	<link rel="stylesheet" href="./assets/css/calendarMod.css">
	<link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
	<!-- build:css assets/css/app.min.css -->
	<link rel="stylesheet" href="libs/bower/animate.css/animate.min.css">
	<link rel="stylesheet" href="libs/bower/fullcalendar/dist/fullcalendar.min.css">
	<link rel="stylesheet" href="libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/core.css">
	<link rel="stylesheet" href="assets/css/app.css">
	<link rel="stylesheet" href="style.css">
	<!-- endbuild -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
	<script src="libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
	<script>
		Breakpoints();
	</script>
</head>
	
<body class="menubar-left menubar-unfold menubar-light theme-primary">
<!--============= start main area -->


 <?php include_once('includes/student-header.php');?>

<?php include_once('includes/student-sidebar.php');?>



<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
  <div class="wrap">
<section class="app-content">
		<div class="row">
			
		<script>
// Disable back button
history.pushState(null, null, document.URL);
window.addEventListener('popstate', function () {
    history.pushState(null, null, document.URL);
});
</script>
<div class="col-md-3 col-sm-3">
    <div class="widget stats-widget">
        <div class="widget-body clearfix">
            <div class="pull-left">
                <?php 
                $facid = $_SESSION['famsemailid'];
                $sql = "SELECT * FROM tblappointment WHERE Status IS NULL AND user_ID=:facid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':facid', $facid, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $pending_count = $query->rowCount();
                ?>
                <h3 class="widget-title text-warning"><span class="counter" data-plugin="counterUp"><?php echo htmlentities($pending_count);?></span></h3>
                <small class="text-color">Pending Appointment</small>
            </div>
            <span class="pull-right big-icon watermark"><i class="fa fa-unlock-alt" style="color: #ffce56;"></i></span>
        </div>
        <footer class="widget-footer bg-warning">
            <a href="pending-appointment.php"><small> View Detail</small></a>
            <span class="small-chart pull-right" data-plugin="sparkline" data-options="[5,4,3,5,2],{ type: 'bar', barColor: '#ffffff', barWidth: 5, barSpacing: 2 }"></span>
        </footer>
    </div><!-- .widget -->
</div>



<div class="col-md-3 col-sm-3">
    <div class="widget stats-widget">
        <div class="widget-body clearfix">
            <div class="pull-left">
                <?php 
                $facid = $_SESSION['famsemailid'];
                $sql = "SELECT * FROM tblappointment WHERE Status='approved' AND user_ID=:facid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':facid', $facid, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $totncanapt = $query->rowCount();
                ?>
                <h3 class="widget-title text-success"><span class="counter" data-plugin="counterUp"><?php echo htmlentities($totncanapt);?></span></h3>
                <small class="text-success">Approved Appointment</small>
            </div>
            <span class="pull-right big-icon watermark"><i class="fa fa-check-circle text-success"></i></span>
        </div>
        <footer class="widget-footer bg-success">
            <a href="approved-appointment.php"><small> View Detail</small></a>
            <span class="small-chart pull-right" data-plugin="sparkline" data-options="[2,4,3,4,3], { type: 'bar', barColor: '#ffffff', barWidth: 5, barSpacing: 2 }"></span>
        </footer>
    </div><!-- .widget -->
</div>







<div class="col-md-3 col-sm-3">
    <div class="widget stats-widget">
        <div class="widget-body clearfix">
            <div class="pull-left">
                <?php 
                $facid = $_SESSION['famsemailid'];
                $sql = "SELECT * FROM tblappointment WHERE Status='Cancelled' AND user_ID=:facid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':facid', $facid, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $totncanapt = $query->rowCount();
                ?>
                <h3 class="widget-title text-danger"><span class="counter" data-plugin="counterUp"><?php echo htmlentities($totncanapt);?></span></h3>
                <small class="text-danger">Cancelled Appointment</small>
            </div>
            <span class="pull-right big-icon watermark"><i class="fa fa-times-circle text-danger"></i></span>
        </div>
        <footer class="widget-footer bg-danger">
            <a href="cancelled-appointment.php"><small> View Detail</small></a>
            <span class="small-chart pull-right" data-plugin="sparkline" data-options="[2,4,3,4,3], { type: 'bar', barColor: '#ffffff', barWidth: 5, barSpacing: 2 }"></span>
        </footer>
    </div><!-- .widget -->
</div>



<div class="col-md-3 col-sm-3">
    <div class="widget stats-widget">
        <div class="widget-body clearfix">

            <div class="pull-left">
                <?php 
                $facid = $_SESSION['famsemailid'];
                $sql = "SELECT * FROM tblappointment WHERE user_ID = :facid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':facid', $facid, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $totapt = $query->rowCount();
                ?>
                <h3 class="widget-title" style="color: #4bc0c0;"><span class="counter" data-plugin="counterUp"><?php echo htmlentities($totapt);?></span></h3>
                <small style="color: #4bc0c0;">Total Requested </small>
            </div>
            <span class="pull-right big-icon watermark"><i class="fa fa-file-text-o" style="color: #4bc0c0;"></i></span>
        </div>

       
        <footer class="widget-footer" style="background-color: #4bc0c0;">
            <a href="all-appointment.php"><small> View Detail</small></a>
            <span class="small-chart pull-right" data-plugin="sparkline" data-options="[5,4,3,5,2],{ type: 'bar', barColor: '#ffffff', barWidth: 5, barSpacing: 2 }"></span>
        </footer>
    </div><!-- .widget -->
</div>





		

<div class="col-md-8">
    <div class="widget">
        <div class="widget-header text-center">
            <h3><i class="fa fa-"></i> My Appointments</h3>
        </div>
        <div class="widget-body">
            <div id="calendar"></div>
        </div>
    </div>
</div>
			

<!--CHART -->
	<div class="col-md-4 col-sm-4">
	<div class="widget stats-widget" style = "   position: relative;
  width: 100%;
  padding: 20px;
  display: grid;
  grid-template-columns: 1fr;
  min-height: 20px;"><h4 style = "text-align: center;"></h4>
  
        <canvas id="myChart"></canvas>
		
      </div>
	  </div>
	  </div>
	  
	  </div>
  
  
		
	</section><!-- #dash-content -->
</div><!-- .wrap -->

  <!-- APP FOOTER -->
 <?php include_once('includes/footer.php');?>
  <!-- /#app-footer -->
</main>
<!--========== END app main -->

<?php include_once('includes/customizer.php');?>
	
	

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
	<script src="libs/bower/fullcalendar/dist/fullcalendar.min.js"></script>
	<script src="assets/js/fullcalendar.js"></script>

	<!-- build:js assets/js/app.min.js -->
<script src="libs/bower/jquery/dist/jquery.js"></script>
<script src="libs/bower/jquery-ui/jquery-ui.min.js"></script>
<script src="libs/bower/moment/moment.js"></script>
<script src="libs/bower/fullcalendar/dist/fullcalendar.min.js"></script>
<!-- endbuild -->
<script src="assets/js/core.js"></script>
<script src="assets/js/app.js"></script>

<script>
    // Use fetched data to populate the chart
    var ctx = document.getElementById("myChart").getContext("2d");
    var myChart = new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: ["Approved", "Cancelled", "Pending", "Total"],
            datasets: [
                {
                    label: "# of Appointments",
                    data: [<?php echo $approved_count; ?>, <?php echo $cancelled_count; ?>, <?php echo $pending_count; ?>, <?php echo $total_count; ?>],
                    backgroundColor: [
                        "rgba(16, 196, 105, 1)",
                        "rgba(255, 91, 91, 1)",
                        "rgba(249, 200, 81, 1)",
                        "rgba(75, 192, 192, 1)"
                    ],
                },
            ],
        },
        options: {
            responsive: true,
        },
    });
</script>

<script>
$(document).ready(function() {
    // Initializes the FullCalendar plugin with options and configurations
    $('#calendar').fullCalendar({

        // Defines the header section of the calendar, including navigation buttons and current view title
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
        },

        // Sets the default date of the calendar to the current date
        defaultDate: '<?php echo date("Y-m-d"); ?>',

        // Disables the ability to edit events on the calendar
        editable: false,

        // Defines the events to be displayed on the calendar using data from a database query
        events: function(start, end, timezone, callback) {
            // Retrieve start and end dates in the format needed for the query
            var start = start.format('YYYY-MM-DD');
            var end = end.format('YYYY-MM-DD');
            
            // Make an AJAX request to fetch events for the specified date range
            $.ajax({
                url: 'get_events.php',
                type: 'POST',
                data: {
                    facid: '<?php echo $_SESSION['famsemailid']; ?>',
                    start: start,
                    end: end
                },
                success: function(response) {
                    // Parse the response as JSON and pass it to FullCalendar
                    var events = JSON.parse(response);
                    callback(events);
                }
            });
        },
        
        eventRender: function(event, element) {
            // Concatenates the full name to the end of the event title
            element.find('.fc-title').append('<br>' + event.description);
        }
    });
});
</script>



</body>
</html>
