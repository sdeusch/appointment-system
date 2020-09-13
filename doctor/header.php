          <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="dashboard.php">Willkommen <?php echo $userRow['firstName'];?> <?php echo $userRow['lastName'];?></a>
                </div>
                    <!-- Top Menu Items -->
                    <ul class="nav navbar-right top-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $userRow['firstName']; ?> <?php echo $userRow['lastName']; ?><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="profile.php"><i class="fa fa-fw fa-user"></i>Meine Daten</a>
                                </li>
                                
                                <li class="divider"></li>
                                <li>
                                    <a href="logout.php?logout"><i class="fa fa-fw fa-power-off"></i>Ausloggen</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                <!-- Sidebar Menu Items -->
                <?php include("left_nav.php"); ?>
                <!-- /.navbar-collapse -->
            </nav>
            <!-- navigation end -->