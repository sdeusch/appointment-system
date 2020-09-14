<?php
session_start();
include_once '../assets/conn/dbconnect.php';
if(!isset($_SESSION['patientSession']))
{
header("Location: ../index.php");
}

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
$userId = $userRow['id'];
?>


<!-- update -->
<?php
if (isset($_POST['submit'])) {
	$patientFirstName = $_POST['patientFirstName'];
	$patientLastName = $_POST['patientLastName'];
	$patientDOB = $_POST['date'];
	$patientAddress = $_POST['patientAddress'];
	$patientPhone = $_POST['patientPhone'];
	$patientEmail = $_POST['patientEmail'];

	$res=mysqli_query($con,"update patient 
							set patientFirstName='$patientFirstName', 
								patientLastName='$patientLastName', 
								patientDOB='$patientDOB', 
								patientAddress='$patientAddress', 
								patientPhone=$patientPhone, 
								patientEmail='$patientEmail' 
							WHERE id=$userId");


	header( 'Location: profile.php' ) ;
}
?>

<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Kunden Termine</title>
		
		<link href="assets/css/material.css" rel="stylesheet">
		<link href="assets/css/default/style.css" rel="stylesheet">
		 <link href="assets/css/default/style1.css" rel="stylesheet"> 
		<link href="assets/css/default/blocks.css" rel="stylesheet">
		<link href="assets/css/date/bootstrap-datepicker.css" rel="stylesheet">
		<link href="assets/css/date/bootstrap-datepicker3.css" rel="stylesheet">
		<!--Font Awesome (added because you use icons in your prepend/append)-->
		<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css" />		
	</head>
	<body>
		<?php include("header.php"); ?> 
		<!-- 1st section start -->
		<section id="promo-1" class="content-block promo-1 min-height-600px bg-offwhite">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-3">					
						<div class="user-wrapper">
							<img src="assets/img/1.jpg" class="img-responsive" />
							<div class="description">
								<h4><?php echo $userRow['patientFirstName']; ?> <?php echo $userRow['patientLastName']; ?></h4>
								<h5>Beruf</h5>
								<p>Motto</p>
								<hr />
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Profil Ändern</button>
							</div>
						</div>
					</div>
					<div class="col-md-9 col-sm-9  user-wrapper">
						<div class="description">
							<h3> <?php echo $userRow['patientFirstName']; ?> <?php echo $userRow['patientLastName']; ?> </h3>
							<hr />								
							<div class="panel panel-default">
								<div class="panel-body">			
								<table class="table table-user-information" align="center">
									<tbody>
									<tr>
										<td>Geburtstag</td>
										<td><?php echo $userRow['patientDOB']; ?></td>
									</tr>
									<tr>
										<td>Vorname</td>
										<td><?php echo $userRow['patientFirstName']; ?></td>
									</tr>
									<tr>
										<td>Nachname</td>
										<td><?php echo $userRow['patientLastName']; ?></td>
									</tr>
									<tr>
										<td>Addresse</td>
										<td><?php echo $userRow['patientAddress']; ?>
										</td>
									</tr>
									<tr>
										<td>Telefone</td>
										<td><?php echo $userRow['patientPhone']; ?>
										</td>
									</tr>
									<tr>
										<td>Email</td>
										<td><?php echo $userRow['patientEmail']; ?>
										</td>
									</tr>
									</tbody>
								</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- first section end -->
		


		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Profil Ändern</h4>
			</div>
			<div class="modal-body">
				<form action="<?php $_PHP_SELF ?>" method="post" >
				<table class="table table-user-information">
					<tbody>					
					<tr>
						<td>Vorname:</td>
						<td><input type="text" class="form-control" name="patientFirstName" value="<?php echo $userRow['patientFirstName']; ?>"  /></td>
					</tr>
					<tr>
						<td>Nachname</td>
						<td><input type="text" class="form-control" name="patientLastName" value="<?php echo $userRow['patientLastName']; ?>"  /></td>
					</tr>
					<tr>
						<td>Geburtstag</td>
						<!-- <td><input type="text" class="form-control" name="patientDOB" value="<?php echo $userRow['patientDOB']; ?>"  /></td> -->
						<td>
						<div class="form-group ">
								<div class="input-group" style="margin-bottom:10px;">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input class="form-control" id="date" name="date" value="<?php echo $userRow['patientDOB']; ?>" onchange="showUser(this.value)"/>
								</div>								
						</div>
						</td>
						
					</tr>
					<tr>
						<td>Telefon</td>
						<td><input type="text" class="form-control" name="patientPhone" value="<?php echo $userRow['patientPhone']; ?>"  /></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type="text" class="form-control" name="patientEmail" value="<?php echo $userRow['patientEmail']; ?>"  /></td>
					</tr>
					<tr>
						<td>Addresse</td>
						<td><textarea class="form-control" name="patientAddress"  ><?php echo $userRow['patientAddress']; ?></textarea></td>
					</tr>
					<tr>
						<td>
						<input type="submit" name="submit" class="btn btn-info" value="Speichern"></td>
						</tr>
					</tbody>              
					</table>
				</form>
			</div>
			</div>
		</div>
		</div>
		<br/>
		<br/>




		<?php include("footer.php"); ?>
			
			<script type="text/javascript">
														$(function () {
														$('#patientDOB').datetimepicker();
														});
			</script>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="assets/js/jquery.js"></script>
		<script src="assets/js/date/bootstrap-datepicker.js"></script>
		<script src="assets/js/moment.js"></script>
		<script src="assets/js/transition.js"></script>
		<script src="assets/js/collapse.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="assets/js/bootstrap.min.js"></script>
		
		<!-- date start -->
		<script>
			$(document).ready(function(){
				var date_input=$('input[name="date"]'); //our date input has the name "date"
				var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
				date_input.datepicker({
				format: 'yyyy-mm-dd',
				container: container,
				todayHighlight: true,
				autoclose: true,
				})
			});
		</script>
		<script>
			function showUser(str) {		
				if (str == "") {
					document.getElementById("txtHint").innerHTML = "No data to be shown";
					return;
				} else {
					if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp = new XMLHttpRequest();
				} else {
					// code for IE6, IE5
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
					xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
				}

				};
				xmlhttp.open("GET","schedule.php?q="+str,true);
				console.log(str);
				xmlhttp.send();
				}
			}
		</script>

		</body>
	</html>