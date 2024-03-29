<?php
session_start();
//error_reporting(0);
include('faculty/includes/dbconnection.php');

?>
<!doctype html>
<html lang="en">
<?php include_once('includes/link.php'); ?>

        <script>
function getfacultys(val) {
     alert(val);
$.ajax({

type: "POST",
url: "get_facultys.php",
data:'sp_id='+val,
success: function(data){
$("#facultylist").html(data);
}
});
}
</script>
    </head>
    
    <body id="top">
    
        <main>

            <?php include_once('includes/header.php');?>

          
       
            

            

            <section class="section-padding" id="booking">
                <div class="container">
                    <div class="row">
                    
                        <div class="col-lg-12 col-12 mx-auto">
                            <div class="booking-form">
                                
                                <h2 class="text-center mb-lg-3 mb-2">Search Appointment History by Appointment Number</h2>
                            
                                <form role="form" method="post">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <input id="searchdata" type="text" name="searchdata" required="true" class="form-control" placeholder="Enter Appointment No.">
                                        </div>

                                        <div class="col-lg-3 col-md-4 col-6 mx-auto">
                                            <button type="submit" class="form-control" name="search" id="submit-button">Check</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <?php
if(isset($_POST['search']))
{ 

$sdata=$_POST['searchdata'];
  ?>
  <h4 align="center">Result against "<?php echo $sdata;?>" keyword </h4>
                    
                    <div class="widget-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Appointment Number</th>
                                        <th>Student Name</th>
                                        <th>Mobile Number</th>
                                        <th>Email</th>
                                       <th>Status</th>
                                        <th>Remark</th>
                                        <th>Consultation</th>
                                        
                                    </tr>
                                </thead>
                            
                                <tbody>
                  <?php
             
             $sql = "SELECT * FROM tblappointment WHERE AppointmentNumber LIKE :sdata OR MobileNumber LIKE :sdata";
             $query = $dbh->prepare($sql);
             $query->bindParam(':sdata', $sdata);
             $query->execute();
             $results = $query->fetchAll(PDO::FETCH_OBJ);
             
             

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt);?></td>
                                        <td><?php  echo htmlentities($row->AppointmentNumber);?></td>
                                        <td><?php  echo htmlentities($row->Name);?></td>
                                        <td><?php  echo htmlentities($row->MobileNumber);?></td>
                                        <td><?php  echo htmlentities($row->Email);?></td>
                                        <?php if($row->Status==""){ ?>

                     <td><?php echo "Not Updated Yet"; ?></td>
<?php } else { ?>                  <td><?php  echo htmlentities($row->Status);?>
                  </td>
                  <?php } ?>             
                 
                                        <?php if($row->Remark==""){ ?>

                     <td><?php echo "Not Updated Yet"; ?></td>
<?php } else { ?>                  <td><?php  echo htmlentities($row->Remark);?>
                  </td>
                  <?php } ?>
                  <td>
    <label for="fileUpload" class="custom-file-upload">
        Upload File
    </label>
    <input type="file" id="fileUpload" name="fileUpload" style="display:none;">
</td>

<style>

    .custom-file-upload {
   margin-left: 5px;
  display: inline-block;
  padding: 3px 6px;
  cursor: pointer;
  background-color: #9a3b3b;
  color: #fff;
  border: 1px solid #9a3b3b;
  border-radius: 7px;
}

.custom-file-upload:hover {
  background-color: #286090;
  border-color: #204d74;
}

</style>


                                        
                                    </tr>
                                
    
                                </tbody>
             
                <?php 
$cnt=$cnt+1;
} } else { ?>
  <tr>
    <td colspan="8"> No record found against this search</td>

  </tr>
  <?php } }?>
                            </table>
                        </div>

                    </div>
                </div>
            </section>
             
        </main>
        <?php include_once('includes/footer.php');?>
        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/scrollspy.min.js"></script>
        <script src="js/custom.js"></script>













        
    </body>
</html>