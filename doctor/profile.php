<?php
    session_start();
    include_once '../assets/conn/dbconnect.php';
    // include_once 'connection/server.php';
    if(!isset($_SESSION['doctorSession']))
    {
    header("Location: ../index.php");
    }
    $therapist_id = $_SESSION['doctorSession'];
    $res=mysqli_query($con,"SELECT * FROM therapist WHERE id=".$therapist_id);
    $userRow=mysqli_fetch_array($res,MYSQLI_ASSOC);


     if (isset($_POST['submit'])) {
        //variables
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];

        $res=mysqli_query($con,"UPDATE therapist SET firstName='$firstName', lastName='$lastName', phone='$phone', email='$email', address='$address' WHERE id=".$therapist_id);
        // $userRow=mysqli_fetch_array($res);

        header( 'Location: profile.php' ) ;
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
                              Meine Daten
                            </h2>                            
                        </div>
                    </div>
                    <!-- Page Heading end-->

                    <!-- panel start -->
                    <div class="panel panel-primary">
                        <!-- Default panel contents -->
                       <div class="panel-heading">
                        <h3 class="panel-title">Details </h3>
                       </div>

                       <div class="panel-body">
                          <div class="container">
                            <section style="padding-bottom: 50px; padding-top: 50px;">
                                <div class="row">
                                    <!-- start -->
                                    <!-- USER PROFILE ROW STARTS-->
                                    <div class="row">
                                        <div class="col-md-3 col-sm-3">
                                            
                                            <div class="user-wrapper">
                                                <img src="assets/img/1.jpg" class="img-responsive" />
                                                <div class="description">
                                                    <h4><?php echo $userRow['firstName']; ?> <?php echo $userRow['lastName']; ?></h4>
                                                    <hr />
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Profil Speichern</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-9 col-sm-9  user-wrapper">
                                            <div class="description">
                                                <h3> <?php echo $userRow['firstName']; ?> <?php echo $userRow['lastName']; ?> </h3>
                                                <hr />
                                                
                                                <div class="panel panel-default">
                                                    <div class="panel-body">
                                                        <table class="table table-user-information" align="center">
                                                            <tbody>
                                                                
                                                                
                                                                <tr>
                                                                    <td>ID</td>
                                                                    <td><?php echo $userRow['id']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Firmen IC</td>
                                                                    <td><?php echo $userRow['employeeNum']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Adresse</td>
                                                                    <td><?php echo $userRow['address']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Telephon</td>
                                                                    <td><?php echo $userRow['phone']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Email</td>
                                                                    <td><?php echo $userRow['email']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Gebursttag</td>
                                                                    <td><?php echo $userRow['dob']; ?>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- USER PROFILE ROW END-->
                                    <div class="col-md-4">
                                        <!-- Large modal -->                                        
                                        <!-- Modal -->
                                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">Meine Daten</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- form start -->
                                                        <form action="<?php $_PHP_SELF ?>" method="post" >
                                                            <table class="table table-user-information">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Firmen IC</td>
                                                                        <td><?php echo $userRow['employeeNum']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Vorname:</td>
                                                                        <td><input type="text" class="form-control" name="firstName" value="<?php echo $userRow['firstName']; ?>"  /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Nachname:</td>
                                                                        <td><input type="text" class="form-control" name="lastName" value="<?php echo $userRow['lastName']; ?>"  /></td>
                                                                    </tr>
                                                                    
                                                                    <tr>
                                                                        <td>Telefon</td>
                                                                        <td><input type="text" class="form-control" name="phone" value="<?php echo $userRow['phone']; ?>"  /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Email</td>
                                                                        <td><input type="text" class="form-control" name="email" value="<?php echo $userRow['email']; ?>"  /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Adresse</td>
                                                                        <td><textarea class="form-control" name="address"  ><?php echo $userRow['address']; ?></textarea></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="submit" name="submit" class="btn btn-info" value="Update Info"></td>
                                                                    </tr>
                                                                    </tbody>
                                                                    
                                                                </table>
                                                                
                                                                
                                                            </form>
                                                            <!-- form end -->
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <br /><br/>
                                        </div>                                        
                                    </div>
                                        <!-- panel content end -->
                                        <!-- panel end -->
                                </div>
                            </section>                          
                          </div>     
                        </div>
                      </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->



    </body>
</html>