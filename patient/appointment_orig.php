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
		<?php include("header.php"); ?> 
		
		<div class="container">
			<section style="padding-bottom: 50px; padding-top: 50px;">
				<div class="row">
					<!-- start -->
					<!-- USER PROFILE ROW STARTS-->
					<div class="row">
						<div class="col-md-3 col-sm-3">
							<div class="description">
								
								
								<div class="panel panel-default">
									<div class="panel-body">
										
										
										<form class="form" role="form" method="POST" accept-charset="UTF-8">
											<div class="panel panel-default">
												<div class="panel-heading">Kunden Information</div>
												<div class="panel-body">													
													<h4><?php echo $firstName; ?> <?php echo $lastName; ?></h4>
													Telefon: <?php echo $phone ?><br>
													Adresse: <?php echo $address ?>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading">Therapeut Information</div>
												<div class="panel-body">													
													<h4><?php echo $therapist ?></h4>
													Tag: <?php echo $schedule['weekDay'] ?>,  <?php echo $schedule['calendarDate'] ?><br>
													Zeit: <?php echo $schedule['startTime'] ?> - <?php echo $schedule['endTime'] ?> Uhr<br>
												</div>
											</div>
											    
											<div class="panel panel-default">
												<div class="panel-heading">Folgende Termine sind schon gebucht:</div>
												<div class="panel-body">


												</div>
											</div>
											

										</form>
									</div>
								</div>
								
							</div>
						</div>
						
						<div class="col-md-9 col-sm-9  user-wrapper">

							
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
                                    <input class="form-control" id="date" name="date" type="text" required disabled value="<?php echo $schedule['calendarDate'] ?>" />
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
                                   <input type="submit" name="appointment" id="submit" class="btn btn-primary" value="Termin Buchen">
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

						</div>
					</div>
					<!-- USER PROFILE ROW END-->
					<!-- end -->
					<script src="assets/js/jquery.js"></script>
			<script src="assets/js/bootstrap.min.js"></script>
				</body>
			</html>