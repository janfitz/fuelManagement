<?php
  include 'auth.php';

  // Start using session
  session_start();

  // Inicialiaze alert message
  $alertMsg = "";
  $alertType = "";

  include 'carProfile.php';

  // Define class for fuel db of current car profile selection
  class MyDB extends SQLite3 {
    function __construct($databaseToOpen) {
      $this->open($databaseToOpen);
    }
  }

  // New instance of SQLite3 database
  $db = new MyDB($databaseToOpen);
  if(!$db) {
    echo $db->lastErrorMsg();
  }

  include 'data.php';
  include 'stats/monthlyStats.php';
  include 'stats/overallStats.php';
  include 'stats/weeklyStats.php';

  // Close database "fuel" for current car profile selection
  $db->close();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="author" content="Jan Fitz">
    <meta name="keywords" content="fuel, car, management, statistics, ccs">
    <meta name="description" content="App for managing fuel consumption and other car statistics">
    <title>Fuel Management app</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker3.css"/>
    <link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
  </head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="col-md-6">
          <h2>Fuel Management app</h2>
        </div>
        <div class="col-md-6">
          <br>
          <div class="col-md-4" style="padding-top: 10px;">
            <i class="fa fa-car" aria-hidden="true"></i><b> Car profile: </b>
          </div>
          <div class="col-md-8">
            <form action="index.php" method="get">
              <div class="form-group pull-right">
                <?php echo $carProfileSelect; ?>
              </div>
            </form>
          </div>
        </div>
      </div>
      <hr>
    </div>

    <div class="row">
      <div class="col-lg-12">

        <!-- Main buttons group-->
        <button class="addRecord btn btn-default" onclick="clearRequest();"><i class="fa fa-refresh" aria-hidden="true"></i> Clear request</button>
        <button id="addRecord" class="addRecord btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> Add record</button>
        <form action="index.php" method="get" style="display: inline;">
          <input type="text" name="csvExport" value="csvExport" style="display: none;">
          <button type="submit" id="downloadAll" class="btn btn-default"><i class="fa fa-download" aria-hidden="true"></i> Export CSV</button>
        </form>
        <button class='modalAddProfile btn btn-default' data-toggle='modal' data-target='#addProfileModal'><i class="fa fa-plus" aria-hidden="true"></i> Add profile</button>
        <button class='modalEditProfile btn btn-default' data-toggle='modal' data-target='#editProfileModal'><i class="fa fa-pencil" aria-hidden="true"></i> Edit profile</button><br><br>
      </div>
    </div>

    <!-- Alerts -->
    <?php
      if(!empty($alertMsg)) {
        echo "<div class='alert alert-" . $alertType . " alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>". $alertMsg ."</div>";
      }
    ?>

    <!-- Add new record -->
    <div class="row">
      <div class="col-lg-12">
        <div class="form_class">
        <br>
         <div class="panel panel-primary">
           <div class="panel-heading">Add new record</div>
             <div class="panel-body">
               <p>All field are required except note</p>
              <form method="get" action="index.php">
               <div class="col-md-6">
                 <div class="form-group">
                   <div class="input-group">
                    <div class="input-group-addon">
                     <i class="fa fa-calendar"></i>
                    </div>
                    <input class="form-control" id="date" name="date" placeholder="Date" type="text"/>
                   </div>
                 </div>
                 <div class="form-group">
                   <input type="text" placeholder="Liters" id="litersID" class="form-control" name="liters">
                 </div>
                 <div class="form-group">
                   <input type="text" placeholder="Price per Liters" id="pricePerLiterID" class="form-control" name="pricePerLiter">
                 </div>
                 <div class="form-group">
                   <input type="text" placeholder="Price Overall" id="overallPriceID" class="form-control" name="priceOverall" onfocus="countOverallPrice()">
                 </div>
               </div>
               <div class="col-md-6">
                 <div class="form-group">
                   <input type="text" placeholder="km State" class="form-control" name="kmState">
                 </div>
                 <div class="form-group">
                   <input type="text" placeholder="Place" class="typeahead form-control" name="place" data-provide="typeahead" data-items="4" data-source='<?php echo $dataSource; ?>'>
                 </div>
                 <div class="form-group">
                   <input type="text" placeholder="Payment" class="form-control" name="payment">
                 </div>
                 <div class="form-group">
                   <input type="text" placeholder="Note" class="form-control" name="note">
                 </div>
               </div>
               <button type="submit" class="btn btn-default">Add</button>
             </form>
            </div>
           </div>
         </div>
       </div>
     </div>

     <!-- Statistics -->
     <div class="row">
       <div class="col-lg-12">
         <h3><i class="fa fa-bar-chart" aria-hidden="true"></i> Statistics</h3>
         <hr>
        <div class="col-md-4">
         <div class="panel panel-primary">
          <div class="panel-heading">Overall</div>
            <div class="panel-body">
              <ul class="list-group">
                <li class="list-group-item"><?php echo "AVG fuel consumption: <b>" . round($avgConsumption_OVERALL, 2) . " l</b>"; ?></li>
                <li class="list-group-item"><?php echo "AVG fuel price: <b>" . round($avgPrice_OVERALL, 2) . " Kc</b>"; ?></li>
                <li class="list-group-item"><?php echo "AVG total fuel price: <b>" . round($avgOverallPrice_OVERALL, 2) . " Kc</b>"; ?></li>
                <li class="list-group-item"><?php echo "SUM fuel price: <b>" . round($totalSpend_OVERALL, 2) . " Kc</b>"; ?></li>
                <li class="list-group-item"><?php echo "SUM distance: <b>" . $distance_OVERALL . " Km</b>"; ?></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <div class="row">
                <div class="col-md-6">
                  Monthly (<?php echo date("F"); ?>)
                </div>
              </div>
            </div>
            <div class="panel-body">
              <ul class="list-group">
                <?php
                  // If monthly consumption value if better than overall avarage, display as green else red
                  if($avgConsumption_MONTHLY <= $avgConsumption_OVERALL) {
                    echo "<li class='list-group-item list-group-item-success'>";
                  }
                  else {
                    echo "<li class='list-group-item list-group-item-danger'>";
                  }
                  echo "AVG fuel consumption: <b>" . round($avgConsumption_MONTHLY, 2) . " l</b>";
                ?>
                </li>
                <li class="list-group-item"><?php echo "AVG fuel price: <b>" . round($avgPrice_MONTHLY, 2) . " Kc</b>"; ?></li>
                <li class="list-group-item"><?php echo "AVG total fuel price: <b>" . round($avgOverallPrice_MONTHLY, 2) . " Kc</b>"; ?></li>
                <li class="list-group-item"><?php echo "SUM fuel price: <b>" . round($totalSpend_MONTHLY, 2) . " Kc</b>"; ?></li>
                <li class="list-group-item"><?php echo "SUM distance: <b>" . $distance_MONTHLY ." Km</b>"; ?></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="panel panel-primary">
            <div class="panel-heading">Weekly</div>
              <div class="panel-body">
                <ul class="list-group">
                  <?php
                    // If weekly consumption value if better than overall avarage, display as green else red
                    if($avgConsumption_WEEKLY <= $avgConsumption_OVERALL) {
                      echo "<li class='list-group-item list-group-item-success'>";
                    }
                    else {
                      echo "<li class='list-group-item list-group-item-danger'>";
                    }
                    echo "AVG fuel consumption: <b>" . round($avgConsumption_WEEKLY, 2) . " l</b>";
                  ?>
                  </li>
                  <li class="list-group-item"><?php echo "AVG fuel price: <b>" . round($avgPrice_WEEKLY, 2) . " Kc</b>"; ?></li>
                  <li class="list-group-item"><?php echo "AVG total fuel price: <b>" . round($avgOverallPrice_WEEKLY, 2) . " Kc</b>"; ?></li>
                  <li class="list-group-item"><?php echo "SUM fuel price: <b>" . round($totalSpend_WEEKLY, 2) . " Kc</b>"; ?></li>
                  <li class="list-group-item"><?php echo "distance: <b>" . $distance_WEEKLY ." Km</b>"; ?></li>
                </ul>
              </div>
            </div>
          </div>
				</div>
      </div>

      <!-- Table with recent history -->
      <div class="row">
        <div class="col-lg-12">
          <h3><i class="fa fa-history" aria-hidden="true"></i> Recent History</h3>
          <hr>
          <div id="recentHistory">
           <table class="table table-striped" style="text-align: center;">
             <tr style="background: #337ab7; color: #fff;">
               <th><b>ID </b></th>
               <th><b>Date </b></th>
               <th><b>Liters </b></th>
               <th><b>Price per liter</b></th>
               <th><b>Price overall</b></th>
               <th><b>km State</b></th>
               <th><b>Place </b></th>
               <th><b>Payment </b></th>
               <th><b>Note </b></th>
               <th><b>Action </b></th>
             </tr>
             <?php echo $tableContent; ?>
           </table>
          </div>
	  <!--
          <form action="index.php" method="get">
           <input type="text" style="display: none;" value="moreContent" name="tableLimit">
           <button type="submit" class="btn btn-default">Show complete history</button>
          </form>
	  -->
        </div>
      </div>
    </div>

    <!-- PHP file with modals -->
    <?php include 'modals.php'; ?>

    <!-- javascript files -->
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-typeahead.js"></script>
    <script type="text/javascript" src="js/app.js"></script>

</body>
