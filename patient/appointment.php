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

    # Get work_schedule 
	$res = mysqli_query($con,
					"select 
					 t.firstName as therapistFirstName,
					 t.lastName as therapistLastName,
					 date_format(s.work_day,'%Y-%m-%d') as calendarDate,
					 dayname(s.work_day) as weekDay,
					 date_format(s.start_time, '%H:%i')  as startTime, 
					 date_format(s.end_time, '%H:%i')  as endTime
					from work_schedule s join therapist t on s.therapist_id = t.id 
					where s.id = $schedule_id and t.id = $therapist_id");
	$schedule=mysqli_fetch_array($res,MYSQLI_ASSOC);
	$therapist = $schedule['therapistFirstName'].' '. $schedule['therapistLastName'];


    # Get other appointments by this therapist at same time 
    $schedule_start = $schedule['calendarDate']." ".$schedule['startTime'].":00";
    $schedule_end = $schedule['calendarDate']." ".$schedule['endTime'].":00";    
    $apptmnts = mysqli_query($con, "select * from appointment
                                            where therapist_id = $therapist_id 
                                            and start_time >= '$schedule_start' and  end_time <= '$schedule_end' order by start_time");
    #$appointment=mysqli_fetch_array($res,MYSQLI_ASSOC);
    
    if (isset($_POST['submit'])) {        
        $bookDate = mysqli_real_escape_string($con,$_POST['appointmentDate']);
        $starttime     = mysqli_real_escape_string($con,$_POST['starttime']);
        $endtime     = mysqli_real_escape_string($con,$_POST['endtime']);
        $comment = mysqli_real_escape_string($con,$_POST['comment']);
        $schedule_id = mysqli_real_escape_string($con,$_POST['schedule_id']);
        # Reconstruct a 'YYYY-MM-DD HH24:MI:SS' datetime format that mySQL accepts
        $startDate = $bookDate.' '.$starttime.':00';
        $endDate = $bookDate.' '.$endtime.':00';
    
        ## ERROR CHECK before INSERT 
        $errMsg = NULL;
        # 1. Check if time interval is inside the work_schedule of the therapist, if not error     
        if( $bookDate != $schedule['calendarDate']) {
            $errMsg="Der Tag ist falsch, es muß ".$schedule['calendarDate']." sein.";
        
        } elseif (  $starttime < $schedule['startTime'] || $starttime > $schedule['endTime'] || $endtime > $schedule['endTime'] || $endtime < $schedule['startTime']   ) {
            $errMsg="Der Termin muß zwischen ".$schedule['startTime']." und ".$schedule['endTime']." Uhr sein (siehe links).";    
        } else {    
            # check other appointments if time is already booked 
            while ($appointment=mysqli_fetch_array($apptmnts,MYSQLI_ASSOC)) {   
                if(   ($startDate >= $appointment['start_time'] && $startDate < $appointment['end_time']) || 
                      ($endDate > $appointment['start_time'] && $endDate < $appointment['end_time']) ) {
                    $errMsg .= "Ein anderer Termin von ".$appointment['start_time']."  bis ".$appointment['end_time']." Uhr überschneidet sich mit Ihrem Interval (".$startDate.",".$endDate.") Bitte wählen Sie anderes Zeitinterval.";
                    break;
                }                           
            }
            if(!$errMsg) {
                //INSERT new appointment 
                $query = " INSERT INTO appointment ( patient_id, therapist_id , start_time, end_time, confirmed, delivered) 
                                VALUES ( 5, 1 , '$startDate', '$endDate', true, false) ";
                $appointment = mysqli_query($con, $query);
            }
        }

        if( $appointment && !$errMsg) {
            ?>           
            <?php 
            echo "<script>window.location.href='patientapplist.php';
                        alert('Ihr Termin mit $therapist am $bookDate, von $starttime bis $endtime Uhr, wurde erfolgreich gebucht!');
                  </script>"; 
        } else {
            echo "<script type='text/javascript'>
                    alert('Etwas funktionierte nicht, beheben Sie den Fehler: $errMsg');
                  </script>";            
        }
    }
?>
<!DOCTYPE html>
<html lang="de">
    <?php include("html_head.php"); ?>  
	<body>
       <?php include("header.php"); ?> 
		<section id="promo-1" class="content-block promo-1 min-height-600px bg-offwhite">
			<div class="container">
				<div class="row">
					<div class="row">
						<div class="col-md-3 col-sm-3">
							<div class="description">								
								<div class="panel panel-default">
									<div class="panel-body">
                                            <!-- <?php echo("Error description: " . mysqli_error($con)." query:".$query) .", schedule_id:".$schedule_id;   ?>  -->
											<div class="panel panel-default">
												<div class="panel-heading">
                                                            <h3 class="panel-title">Kunden Information</h3>    
                                                </div>
												<div class="panel-body">													
													<h4><?php echo $firstName; ?> <?php echo $lastName; ?></h4>
													Telefon: <?php echo $phone ?><br>
													Adresse: <?php echo $address ?>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading"><h3 class="panel-title">Therapeut Information</h3></div>
												<div class="panel-body">													
													<h4><?php echo $therapist ?></h4>
													Tag: <strong><?php echo $schedule['weekDay'] ?>,  <?php echo $schedule['calendarDate'] ?></strong><br>
													Zeit:<strong> <?php echo $schedule['startTime'] ?> - <?php echo $schedule['endTime'] ?> Uhr</strong><br>
												</div>
											</div>																				
									</div>
								</div>
								
							</div>
						</div>
						
						<div class="col-md-9 col-sm-9  user-wrapper">
                            <div class="description">	

								<div class="panel panel-default">
									<div class="panel-body">
                                            <!-- <?php echo("Error description: " . mysqli_error($con)." query:".$query) .", schedule_id:".$schedule_id;   ?>  -->
										<div class="panel panel-default">
                                            <!-- panel heading starat -->
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Bitte Wählen Sie einen Freien Termin:</h3>
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
                                                            <input class="form-control" id="appointmentDate" name="appointmentDate" type="text" required value="<?php echo $schedule['calendarDate'] ?>" />
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
                                                            <!-- Resubmit schedule_id to compare start/end time against it -->
                                                            <input type="hidden" id="schedule_id" name="schedule_id" value="$id" />
                                                        </div>
                                                        </div>
                                                        </div>
                                                        <div class="form-group">
                                                        <div class="col-sm-10 col-sm-offset-2">
                                                        <button class="btn btn-primary" type="submit" name="submit">Termin Buchen</button>
                                                        </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                    </div>
                                                    </div>
                                                </div>   
                                            </div>
                                        </div>                     
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                    <h3 class="panel-title">Folgende Termine sind schon gebucht:</h3>
                                            </div>
                                            <div class="panel-body">
                                                <ol><?php  
                                                        while ($appointment=mysqli_fetch_array($apptmnts,MYSQLI_ASSOC)) {          
                                                            $confirmed = ($appointment['confirmed']) ? '(bestätigt)' : '(nicht bestätigt)';                      
                                                            echo "<li>".$appointment['start_time']." - ".$appointment['end_time']." Uhr ".$confirmed;
                                                        } ?>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                </div>
            </div>
        </section>
        
        <?php include("footer.php"); ?>

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