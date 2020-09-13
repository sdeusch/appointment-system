

<div class="collapse navbar-collapse navbar-ex1-collapse">
   <?php echo '<ul class="nav navbar-nav side-nav">';
      $PHP_SELF = basename($_SERVER['PHP_SELF']);  # this returns the last PHP file name, e.g. dashboard.php
      # echo $PHP_SELF;
     echo ($PHP_SELF == 'dashboard.php') ? 
            '<li><a class="active" href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i>Übersicht</a></li>' :
            '<li><a class="none"   href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i>Übersicht</a></li>';

     echo ($PHP_SELF == 'schedule.php') ? 
            '<li><a class="active" href="schedule.php"><i class="fa fa-fw fa-calendar"></i>Arbeit Planen</a></li>' :
            '<li><a class="none"   href="schedule.php"><i class="fa fa-fw fa-calendar"></i>Arbeit Planen</a></li>';

     echo ($PHP_SELF == 'profile.php') ? 
            '<li><a class="active" href="profile.php"><i class="fa fa-fw fa-user"></i>Meine Daten</a></li>' :
            '<li><a class="none"   href="profile.php"><i class="fa fa-fw fa-user"></i>Meine Daten</a></li>';

     echo ($PHP_SELF == 'patientlist.php') ? 
            '<li><a class="active" href="patientlist.php"><i class="fa fa-fw fa-archive"></i>Kunden Datei</a></li>' :
            '<li><a class="none"   href="patientlist.php"><i class="fa fa-fw fa-archive"></i>Kunden Datei</a></li>';

    echo '</ul>';
    ?>
</div>