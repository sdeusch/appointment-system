<?php
	session_start();
	include_once '../assets/conn/dbconnect.php';

	# Get User Data 
	$usersession = $_SESSION['patientSession'];
	$res=mysqli_query($con,"SELECT * FROM patient WHERE patientEmail='".$usersession."'");
	$userRow=mysqli_fetch_array($res,MYSQLI_ASSOC);
	$userId =$userRow['id'];
	$firstName =$userRow['patientFirstName'];
	$lastName =$userRow['patientLastName'];
	$phone = $userRow['patientPhone'];
	$address =$userRow['patientAddress'];
	$dob =$userRow['patientDOB'];
	
	# Get schedule of Therapist
	if (isset($_GET['id']) && isset($_GET['therapist_id'])) {
		$schedule_id =$_GET['id'];
		$therapist_id = $_GET['therapist_id'];
	}

	$res = mysqli_query($con,
					"select 
					 t.firstName as therapistFirstName,
					 t.lastName as therapistLastName,
					 date_format(s.work_day,'%d.%m %Y') as calendarDate,
					 dayname(s.work_day) as weekDay,
					 date_format(s.start_time, '%H:%i')  as startTime, 
					 date_format(s.end_time, '%H:%i')  as endTime
					from work_schedule s join therapist t on s.therapist_id = t.id 
					where s.id = $schedule_id and t.id = $therapist_id");
	$schedule=mysqli_fetch_array($res,MYSQLI_ASSOC);
	$therapist = $schedule['therapistFirstName'].' '. $schedule['therapistLastName'];


	//INSERT
	if (isset($_POST['appointment'])) {
	$patientIc = mysqli_real_escape_string($con,$schedule['icPatient']);
	$scheduleid = mysqli_real_escape_string($con,$appid);
	$symptom = mysqli_real_escape_string($con,$_POST['symptom']);
	$comment = mysqli_real_escape_string($con,$_POST['comment']);
	$avail = "notavail";

	$query = "INSERT INTO appointment (  patientIc , scheduleId , appSymptom , appComment  )
	VALUES ( '$patientIc', '$scheduleid', '$symptom', '$comment') ";

	//update table appointment schedule
	$sql = "UPDATE doctorschedule SET bookAvail = '$avail' WHERE scheduleId = $scheduleid" ;
	$scheduleres=mysqli_query($con,$sql);
	if ($scheduleres) {
		$btn= "disable";
	} 


	$result = mysqli_query($con,$query);
	// echo $result;
	if( $result )
	{
	?>
	<script type="text/javascript">
	alert('Appointment made successfully.');
	</script>
	<?php
	header("Location: patientapplist.php");
	}
	else
	{
		echo mysqli_error($con);
	?>
	<script type="text/javascript">
	alert('Appointment booking fail. Please try again.');
	</script>
	<?php
	header("Location: patient/patient.php");
	}

	}
?>
<!DOCTYPE html>
<html lang="de">
    <?php include("html_head.php"); ?>  
	
	  <body>

             <div id="wrapper">

            <?php include("header.php"); ?> 

            <div id="page-wrapper">
                <div class="container-fluid">
                    
                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="page-header">
                             Arbeit Planen
                            </h2>                            
                        </div>
                    </div>
                    <!-- Page Heading end-->

                    <!-- panel start -->
                    <div class="panel panel-primary">

                        <!-- panel heading starat -->
                        <div class="panel-heading">
                            <h3 class="panel-title">Bitte tragen Sie Ihre geplanten Arbeitszeiten hier ein:</h3>
                        </div>
                        <div class="panel-body">
                        <!-- panel content start -->
                            <div class="bootstrap-iso">
                             <div class="container-fluid">
                              <div class="row">
                               <div class="col-md-12 col-sm-12 col-xs-12">
                                <form class="form-horizontal" method="post">
                                 <div class="form-group form-group-lg">
                                  <label class="control-label col-sm-2 requiredField" for="date">
                                   Tag
                                   <span class="asteriskField">
                                    *
                                   </span>
                                  </label>
                                  <div class="col-sm-10">
                                   <div class="input-group">
                                    <div class="input-group-addon">
                                     <i class="fa fa-calendar">
                                     </i>
                                    </div>
                                    <input class="form-control" id="date" name="date" type="text" required/>
                                   </div>
                                  </div>
                                 </div>
                                 <div class="form-group form-group-lg">
                                  <label class="control-label col-sm-2 requiredField" for="starttime">
                                   Begin
                                   <span class="asteriskField">
                                    *
                                   </span>
                                  </label>

                                  <div class="col-sm-10">
                                   <div class="input-group clockpicker"  data-align="top" data-autoclose="true">
                                    <div class="input-group-addon">
                                     <i class="fa fa-clock-o">
                                     </i>
                                    </div>
                                    <input class="form-control" id="starttime" name="starttime" type="text" required/>
                                   </div>
                                  </div>
                                 </div>
                                 <div class="form-group form-group-lg">
                                  <label class="control-label col-sm-2 requiredField" for="endtime">
                                   Ende
                                   <span class="asteriskField">
                                    *
                                   </span>
                                  </label>
                                  <div class="col-sm-10">
                                   <div class="input-group clockpicker"  data-align="top" data-autoclose="true">
                                    <div class="input-group-addon">
                                     <i class="fa fa-clock-o">
                                     </i>
                                    </div>
                                    <input class="form-control" id="endtime" name="endtime" type="text" required/>
                                   </div>
                                  </div>
                                 </div>
                                  <div class="form-group form-group-lg">
                                  <label class="control-label col-sm-2 requiredField" for="endtime">
                                   Notiz
                                  </label>
                                  <div class="col-sm-10">
                                   <div class="input-group"  data-align="top">
                                    <div class="input-group-addon">
                                     <i class="fa fa-sticky-note">
                                     </i>
                                    </div>
                                    <input class="form-control" id="comment" name="comment" type="text"/>
                                   </div>
                                  </div>
                                 </div>
                                 <div class="form-group">
                                  <div class="col-sm-10 col-sm-offset-2">
                                   <button class="btn btn-primary " name="submit" type="submit">
                                     Speichern
                                   </button>
                                  </div>
                                 </div>
                                </form>
                               </div>
                              </div>
                             </div>
                            </div>                        
                        <!-- panel content end -->
                        <!-- panel end -->
                        </div>
                    </div>
                    <!-- panel start -->

                     <!-- panel start -->
                    <div class="panel panel-primary filterable">

                        <!-- panel heading starat -->
                        <div class="panel-heading">
                            <h3 class="panel-title">Geplante Arbeitszeiten</h3>
                            <div class="pull-right">
                            <button class="btn btn-default btn-xs btn-filter"><span class="fa fa-filter"></span> Filter</button>
                        </div>
                        </div>
                        <!-- panel heading end -->

                        <div class="panel-body">
                        <!-- panel content start -->
                           <!-- Table -->
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr class="filters">
                                    <th><input type="text" class="form-control" placeholder="ID" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Datum" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Begin" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Ende" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Notiz" disabled></th>
                                    <th></th>
                                </tr>
                            </thead>
                            </tbody>
                                <?php 
                                $result=mysqli_query($con,"SELECT * FROM work_schedule");

                                while ($schedule=mysqli_fetch_array($result)) {             
                                        echo "<tr>";
                                            echo "<td>" . $schedule['id'] . "</td>";
                                            echo "<td>" . $schedule['work_day'] . "</td>";
                                            echo "<td>" . $schedule['start_time'] . "</td>";
                                            echo "<td>" . $schedule['end_time'] . "</td>";
                                            echo "<td>" . $schedule['comment'] . "</td>";
                                            echo "<form method='POST'>";
                                            echo "<td class='text-center'><a href='#' id='".$schedule['id']."' class='delete'> <span class='fa fa-trash'></span></a>
                                            </span></a></td>
                                            </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    <!-- panel start -->
 
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->
        </div>

<!-- jQuery -->
         <script src="../patient/assets/js/jquery.js"></script>
        
        <!-- Bootstrap Core JavaScript -->
        <!-- <script src="../patient/assets/js/bootstrap.min.js"></script> -->
        <script src="assets/js/bootstrap-clockpicker.js"></script>

        <!-- Date Picker -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

        <script>
            $(document).ready(function(){
                var date_input=$('input[name="date"]'); //our date input has the name "date"
                var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
                date_input.datepicker({
                    format: 'yyyy/mm/dd',
                    container: container,
                    todayHighlight: true,
                    autoclose: true,
                })
            })
        </script>

        <script type="text/javascript">
             $('.clockpicker').clockpicker();
        </script>

        <script type="text/javascript">
            $(function() {
                $(".delete").click(function(){
                var element = $(this);
                var id = element.attr("id");
                var info = 'id=' + id;
                if(confirm("Sind Sie sicher?")) {                
                    $.ajax({
                        type: "POST",
                        url: "deleteschedule.php",
                        data: info,
                        success: function(){}
                    });
                    $(this).parent().parent().fadeOut(300, function(){ $(this).remove();});
                }
                return false;
                });
            });
        </script>

    </body>
</html>