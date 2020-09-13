<?php
include_once '../assets/conn/dbconnect.php';

// Get the variables.
$id = $_POST['id'];

$delete = mysqli_query($con,"DELETE FROM work_schedule WHERE id=$id");

?>

