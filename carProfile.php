<?php
class profilesDB extends SQLite3 {
 function __construct() {
   $this->open('dbs/profiles.db');
 }
}

// New instance of SQLite3 database
$profilesDB = new profilesDB();
if(!$profilesDB) {
 echo $profilesDB->lastErrorMsg();
}

// Delete car profile
if(isset($_GET['deleteCarProfile'])) {
  $carID = $_GET['deleteCarProfile'];
  $result = $profilesDB->query("DELETE FROM car WHERE id='$carID'");
  $_SESSION['carID'] = 1;
  // Delete database
  if(!unlink("dbs/fuelManagement_" . $carID . ".db")) {
    $alertType = "danger";
    $alertMsg = "Unable to delete car profile!";
  }
  else {
    $alertType = "warning";
    $alertMsg = "Car profile deleted successfully!";
  }
}

// Define variables
$carID = 1;
$carProfileSelect = "";

if (!empty($_SESSION['carID'])) {
  $carID = $_SESSION['carID'];
}

if(isset($_GET['carProfileSelect'])) {
  $carID = $_GET['carProfileSelect'];
  $_SESSION['carID'] = $carID;
}

// Specify database name based on session "carID"
$databaseToOpen = "dbs/fuelManagement_" . $carID . ".db";

// Edit car profile
if(isset($_GET['modelEdit'])) {
  if(isset($_GET['regNumberEdit'])) {
    $model = $_GET['modelEdit'];
    $regNumber = $_GET['regNumberEdit'];
    $result = $profilesDB->query("UPDATE car SET model='$model' WHERE id='$carID'");
    $result = $profilesDB->query("UPDATE car SET regNumber='$regNumber' WHERE id='$carID'");
    $alertType = "success";
    $alertMsg = "Car profile edited successfully!";
  }
}

// Add car profile
if(isset($_GET['modelAdd'])) {
  if(isset($_GET['regNumberAdd'])) {
    $model = $_GET['modelAdd'];
    $regNumber = $_GET['regNumberAdd'];

    $result = $profilesDB->query("INSERT INTO car (model, regNumber) VALUES ('$model', '$regNumber')");

    // Create new database for new car profile
    $databaseName = "";
    $result = $profilesDB->query("SELECT * FROM car ORDER BY id DESC LIMIT 1");
    while($row = $result->fetchArray()) {
      $databaseName .= "dbs/fuelManagement_" . $row['id'] . ".db";
    }
    if(!copy("dbs/emptyFuelDatabase.db", $databaseName)) {
      $alertType = "warning";
      $alertMsg = "Unable to create new car profile!";
    }
    else {
      $alertType = "success";
      $alertMsg = "New car profile created successfully!";
    }
  }
}

$result = $profilesDB->query("SELECT * FROM car WHERE id='$carID'");
while($row = $result->fetchArray()) {
  $carProfileSelect = "<select name='carProfileSelect' class='form-control' onchange='this.form.submit()'><option name='" . $row['id'] . "' value='" . $row['id'] . "'>" . $row['model'] . ", " . $row['regNumber'] . "</option>";
}

$result = $profilesDB->query("SELECT * FROM car WHERE id<>'$carID'");
while($row = $result->fetchArray()) {
 $carProfileSelect .= "<option name='" . $row['id'] . "' value='" . $row['id'] . "'>" . $row['model'] . ", " . $row['regNumber'] . "</option>";
}

$carProfileSelect .= "</select>";

?>
