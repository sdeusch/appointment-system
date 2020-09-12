

<div class="collapse navbar-collapse navbar-ex1-collapse">
   <?php echo '<ul class="nav navbar-nav side-nav">';
      $PHP_SELF = basename($_SERVER['PHP_SELF']);  # this returns the last PHP file name, e.g. dashboard.php
      # echo $PHP_SELF;
      echo ($PHP_SELF == 'doctordashboard.php') ? 
            '<li><a class="active" href="doctordashboard.php"><i class="fa fa-fw fa-dashboard"></i>Übersicht</a></li>' :
            '<li><a class="none"   href="doctordashboard.php"><i class="fa fa-fw fa-dashboard"></i>Übersicht</a></li>';

     echo ($PHP_SELF == 'addschedule.php') ? 
            '<li><a class="active" href="addschedule.php"><i class="fa fa-fw fa-calendar"></i>Termine Planen</a></li>' :
            '<li><a class="none"   href="addschedule.php"><i class="fa fa-fw fa-calendar"></i>Termine Planen</a></li>';

     echo ($PHP_SELF == 'patientlist.php') ? 
            '<li><a class="active" href="patientlist.php"><i class="fa fa-fw fa-archive"></i>Kunden Datei</a></li>' :
            '<li><a class="none"   href="patientlist.php"><i class="fa fa-fw fa-archive"></i>Kunden Datei</a></li>';

    echo '</ul>';
    ?>
</div>