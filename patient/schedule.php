<?php
    session_start();
    include_once '../assets/conn/dbconnect.php';
    $q = $_GET['q'];
    $res = mysqli_query($con,"select 
            t.id        as therapistId,
            s.id        as scheduleId,
            t.firstName as firstName,
            t.lastName  as lastName,
            s.work_day  as workDay,
            s.start_time as startTime,
            s.end_time  as endTime,
            s.comment   as comment
      from therapist t join work_schedule s on s.therapist_id = t.id 
      where s.work_day = '$q' 
      order by s.start_time, t.lastName");
    if (!$res) {
        die("Error running $sql: " . mysqli_error());
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
        if (mysqli_num_rows($res)==0) {
            echo "<div class='alert alert-danger' role='alert'>Momentan sind keine Termine verfügbar. Probieren Sie bitte einen anderen Tag.</div>";        
        } else {
        echo "   <table class='table table-hover'>";
            echo " <thead>";
                echo " <tr>";
                    echo " <th>#</th>";
                    echo " <th>Therapeut</th>";
                    echo " <th>Tag</th>";
                    echo "  <th colspan=2 style='text-align:center'>Zwischen</th>";
                    echo " <th>Kommentar</th>";
                    echo "  <th>Reservieren</th>";
                echo " </tr>";
            echo "  </thead>";
            echo "  <tbody>";
                while($row = mysqli_fetch_array($res)) {
                ?>
                    <tr>
                        <?php                  
                            // if ($rowapp['bookAvail']!="available") {
                            // $btnstate="disabled";
                            // } else {
                            // $btnstate="";
                            // }
                            echo "<td>" . $row['scheduleId'] . "</td>";
                            echo "<td>" . $row['firstName'] . " " . $row['lastName'] . "</td>";
                            echo "<td>" . $row['workDay'] . "</td>";
                            echo "<td>" . $row['startTime'] . "</td>";
                            echo "<td>" . $row['endTime'] . "</td>";
                            echo "<td>" . $row['comment'] . "</td>";
                            echo "<td><a href='appointment.php?&id=" . $row['scheduleId'] . "&therapist_id=". $row['therapistId'] ."' class='btn btn-click btn-xs' role='button'>Book Now</a></td>";
                        ?>                        
                        </script>
                        <!-- ?> -->
                    </tr>
                <?php
                }
        }
        ?>
            </tbody>           
        </body>
    </html>