<?php
    session_start();
    include_once '../assets/conn/dbconnect.php';
    if(!isset($_SESSION['doctorSession'])) {
        header("Location: ../index.php");
    }
    $therapist_id  = $_SESSION['doctorSession'];
    $res=mysqli_query($con,"SELECT * FROM therapist WHERE id=".$therapist_id );
    $userRow=mysqli_fetch_array($res,MYSQLI_ASSOC);
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
                            <h2 class="page-header">Übersicht</h2>
                        </div>
                    </div>
                    <!-- Page Heading end-->

                    <!-- panel start -->
                    <div class="panel panel-primary filterable">
                        <!-- Default panel contents -->
                       <div class="panel-heading">
                        <h3 class="panel-title">Gebuchte Kunden (ab heute)</h3>
                        <div class="pull-right">
                            <button class="btn btn-default btn-xs btn-filter"><span class="fa fa-filter"></span> Filter</button>
                        </div>
                        </div>
                        <div class="panel-body">
                        <!-- Table -->
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr class="filters">
                                    <th><input type="text" class="form-control" placeholder="Kunde ID" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Name" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Telefon" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Email" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Tag" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Datum" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Begin" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Ende" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Bestätigt" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Löschen" disabled></th>
                                </tr>
                            </thead>
                            
                            <?php 
                            $res=mysqli_query($con,"select 
                                                     a.id as appointmentId, 
                                                     p.id as patientId,                                                      
                                                     p.patientFirstName as patientFirstName,
                                                     p.patientLastName as patientLastName,
                                                     p.patientEmail as patientEmail,
                                                     p.patientPhone as patientPhone,
                                                     date_format(a.start_time,'%d.%m %Y') as calendarDate,
                                                     dayname(a.start_time) as weekDay,
                                                     date_format(a.start_time, '%H:%i')  as startTime, 
                                                     date_format(a.end_time, '%H:%i')  as endTime, 
                                                     a.confirmed as confirmed,
                                                     a.delivered as delivered                              
                                                  from appointment a join therapist t on a.therapist_id = t.id 
                                                                     join patient p on  p.id = a.patient_id 
                                                   where t.id = $therapist_id 
                                                  
                                                   order by a.start_time");
                                  if (!$res) {
                                    printf("Error: %s\n", mysqli_error($con));                                    
                                }
                            while ($appointment=mysqli_fetch_array($res)) {
                                                                
                                if($appointment['confirmed']==TRUE) {
                                     $confirm_icon='fa fa-check';
                                } else {
                                     $confirm_icon='fa fa-question';                                    
                                }
                                echo "<tbody>";
                                echo "<tr >";
                                    echo "<td>" . $appointment['patientId'] . "</td>";
                                    echo "<td>" . $appointment['patientLastName'] . ", ". $appointment['patientFirstName'] . "  </td>";
                                    echo "<td>" . $appointment['patientPhone'] . "</td>";
                                    echo "<td>" . $appointment['patientEmail'] . "</td>";
                                    echo "<td>" . $appointment['weekDay'] . "</td>";
                                    echo "<td>" . $appointment['calendarDate'] . "</td>";
                                    echo "<td>" . $appointment['startTime'] . " Uhr</td>";
                                    echo "<td>" . $appointment['endTime'] . " Uhr</td>";
                                    echo "<td class='text-center'><a href='#' id='".$appointment['appointmentId']."'                         > <span class='".$confirm_icon."'></span></a>";
                                    echo "<td class='text-center'><a href='#' id='".$appointment['appointmentId']."' class='delete'> <span class='fa fa-trash'></span></a>";
                            } 
                                echo "</tr>";
                           echo "</tbody>";
                       echo "</table>";
                        ?>
                    </div>
                </div>
                    <!-- panel end -->
<script type="text/javascript">
        function chkit(uid, chk) {
            chk = (chk==true ? "1" : "0");
            var url = "checkdb.php?userid="+uid+"&chkYesNo="+chk;
            if(window.XMLHttpRequest) {
                req = new XMLHttpRequest();
            } else if(window.ActiveXObject) {
                req = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Use get instead of post.
            req.open("GET", url, true);
            req.send(null);
        }
</script>

                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->

        <script type="text/javascript">
            $(function() {
                $(".delete").click(function(){
                    var element = $(this);
                    var appid = element.attr("id");
                    var info = 'id=' + appid;
                    if(confirm("Wollen Sie diese Reservation wirklich löschen?"))
                    {
                        $.ajax({
                            type: "POST",
                            url: "deleteappointment.php",
                            data: info,
                            success: function(){}
                        });
                        $(this).parent().parent().fadeOut(300, function(){ $(this).remove();});
                    }
                    return false;
                });
            });
        </script>
        <!-- Bootstrap Core JavaScript -->
        
        <!-- Latest compiled and minified JavaScript -->
         <!-- script for jquery datatable start-->
        <script type="text/javascript">
            /*
            Please consider that the JS part isn't production ready at all, I just code it to show the concept of merging filters and titles together !
            */
            $(document).ready(function(){
                $('.filterable .btn-filter').click(function(){
                    var $panel = $(this).parents('.filterable'),
                    $filters = $panel.find('.filters input'),
                    $tbody = $panel.find('.table tbody');
                    if ($filters.prop('disabled') == true) {
                        $filters.prop('disabled', false);
                        $filters.first().focus();
                    } else {
                        $filters.val('').prop('disabled', true);
                        $tbody.find('.no-result').remove();
                        $tbody.find('tr').show();
                    }
                });

                $('.filterable .filters input').keyup(function(e){
                    /* Ignore tab key */
                    var code = e.keyCode || e.which;
                    if (code == '9') return;
                    /* Useful DOM data and selectors */
                    var $input = $(this),
                    inputContent = $input.val().toLowerCase(),
                    $panel = $input.parents('.filterable'),
                    column = $panel.find('.filters th').index($input.parents('th')),
                    $table = $panel.find('.table'),
                    $rows = $table.find('tbody tr');
                    /* Dirtiest filter function ever ;) */
                    var $filteredRows = $rows.filter(function(){
                        var value = $(this).find('td').eq(column).text().toLowerCase();
                        return value.indexOf(inputContent) === -1;
                    });
                    /* Clean previous no-result if exist */
                    $table.find('tbody .no-result').remove();
                    /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
                    $rows.show();
                    $filteredRows.hide();
                    /* Prepend no-result row if all rows are filtered */
                    if ($filteredRows.length === $rows.length) {
                        $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
                    }
                });
            });
        </script>
        <!-- script for jquery datatable end-->

    </body>
</html>