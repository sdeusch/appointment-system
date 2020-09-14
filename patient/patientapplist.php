<?php
	session_start();
	include_once '../assets/conn/dbconnect.php';

	if(!isset($_SESSION['patientSession'])) {
		header("Location: ../index.php");
	}
	# 1. Load User info 
	$usersession = $_SESSION['patientSession'];
	$res=mysqli_query($con,"SELECT * FROM patient WHERE patientEmail='".$usersession."'");

	if ($res===false) {
		header("Location: ../index.php");
		# echo mysql_error();
		echo 'Something went wrong';
		echo var_dump($_SESSION);
		echo var_dump($usersession);
	} 
	$userRow=mysqli_fetch_array($res,MYSQLI_ASSOC);

	# 2. Load user's appointments
	$patientEmail=$usersession;
	$res=mysqli_query($con, "select a.id as appointment_id,  
									date_format(a.start_time,'%W, %d.%M %Y') as calendarDate,
									date_format(a.start_time, '%H:%i') as start_time,
									date_format(a.end_time, '%H:%i') as end_time,
									case when a.confirmed then 'Bestätigt' else 'Nicht bestätigt' end as confirmed, 
									t.firstName as firstName,
									t.lastName as lastName,
									p.id as patientId
							FROM patient p JOIN appointment a on p.id = a.patient_id
                                   		   JOIN therapist t on a.therapist_id = t.id
							 where p.patientEmail = '$patientEmail'
							 and a.start_time > now() - interval 1 day
							 order by a.start_time");
		if (!$res) {
			die( "Error running $sql: " . mysqli_error());
		}		
?>
<!DOCTYPE html>
<html lang="de">
<?php include("html_head.php"); ?>  
<body">
	<?php include("header.php"); ?> 
	<section id="promo-1" class="content-block promo-1 bg-offwhite" style="height: 100%;">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-8">
					<div class="description">								
						<div class="panel panel-default">
							<div class="panel-body">
								<table class='table table-hover'>
									<thead>
										<tr>
											<th>ID</th>
											<th>Therapeut</th>
											<th>Datum</th>
											<th>Beginn</th>
											<th>Ende</th>
											<th>Status</th>
											<th>Absagen</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											while($usrappts = mysqli_fetch_array($res)) { 
										?>
										<tr>
										<?php 
											echo "<td>" . $usrappts['appointment_id'] . "</td>";
											echo "<td>" . $usrappts['firstName'] ." ".$usrappts['lastName'] . "</td>";
											echo "<td>" . $usrappts['calendarDate'] . "</td>";
											echo "<td>" . $usrappts['start_time'] . " Uhr</td>";
											echo "<td>" . $usrappts['end_time'] . " Uhr</td>";
											echo "<td>" . $usrappts['confirmed'] . "</td>";
											echo "<td class='text-center'><a href='#' id='".$usrappts['appointment_id']."' class='delete'> <span class='fa fa-trash'></span></a>";
										?>
										</tr>
										<?php
										}
										?>				
									</tbody>
								</table>
								<div class="panel-body">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
	</section>	
	<?php include("footer.php"); ?>
	<script type="text/javascript">
            $(function() {
                $(".delete").click(function(){
                var element = $(this);
                var id = element.attr("id");
                var info = 'id=' + id;
                if(confirm("Wollen Sie diesen Termin wirklich absagen?")) {                
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