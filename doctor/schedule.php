<?php
    session_start();
    include_once '../assets/conn/dbconnect.php';
    if(!isset($_SESSION['doctorSession'])) {
        header("Location: ../index.php");
    }
    $usersession = $_SESSION['doctorSession'];
    $therapist_id = $usersession;
    $schedule=mysqli_query($con,"SELECT * FROM therapist WHERE id=".$usersession);
    $userRow=mysqli_fetch_array($schedule,MYSQLI_ASSOC);

    if (isset($_POST['submit'])) {
        $date = mysqli_real_escape_string($con,$_POST['date']);
        $starttime     = mysqli_real_escape_string($con,$_POST['starttime']);
        $endtime     = mysqli_real_escape_string($con,$_POST['endtime']);
        $comment = mysqli_real_escape_string($con,$_POST['comment']);

        //INSERT
        $query = " INSERT INTO work_schedule ( therapist_id , work_day, start_time, end_time, comment)
                       VALUES ( $therapist_id , '$date', '$starttime', '$endtime', '$comment') ";

        $scheduleult = mysqli_query($con, $query);
        
        if( $scheduleult )
        {
        ?>
        <script type="text/javascript">
                alert('Arbeitszeit erfolgreich gespeichert!');
        </script>
        <?php
        }
        else
        {
            
        ?>
        <script type="text/javascript">
                alert('Etwas funktionierte nicht, probiere es nochmal.');
        </script>
        <?php
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
                                $result=mysqli_query($con,"SELECT * FROM work_schedule where therapist_id = ".$userRow['id']);

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
        <!-- /#wrapper -->

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
                        $tbody.find('.no-scheduleult').remove();
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
                    /* Clean previous no-scheduleult if exist */
                    $table.find('tbody .no-scheduleult').remove();
                    /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
                    $rows.show();
                    $filteredRows.hide();
                    /* Prepend no-scheduleult row if all rows are filtered */
                    if ($filteredRows.length === $rows.length) {
                        $table.find('tbody').prepend($('<tr class="no-scheduleult text-center"><td colspan="'+ $table.find('.filters th').length +'">No scheduleult found</td></tr>'));
                    }
                });
            });
        </script>

    </body>
</html>