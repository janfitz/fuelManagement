<?php
/**
 * data.php
 *
 * @author Jan Fitz <jan@janfitz.cz>
 * @link
 */

/*
* Download all records as cvs
*/

// Get all records from database
if(isset($_GET['csvExport'])) {
  $fp = fopen('fuel.csv', 'w');
  $result = $db->query('SELECT * FROM fuel');
  while($row = $result->fetchArray() ) {
    fputcsv($fp, $row);
  }
 fclose($fp);

 // Download file as csv
 header('Content-Type: application/download');
 header('Content-Disposition: attachment; filename="fuel.csv"');
 header("Content-Length: " . filesize("fuel.csv"));
 $fp2 = fopen("fuel.csv", "r");
 fpassthru($fp2);
 fclose($fp2);
 unlink("fuel.csv");

}

/*
* Place typeahead data fill
*/

$dataSource = '[';

$result = $db->query('SELECT place FROM fuel');
while($row = $result->fetchArray() ) {
  $dataSource .= '"' . $row['place'] . '",';
}

$dataSource .= '" "]';

/*
* Insert new record
*/

if(isset($_GET['date'])) {
  $date = $_GET['date'];
  $liters = $_GET['liters'];
  $pricePerLiter = $_GET['pricePerLiter'];
  $priceOverall = $_GET['priceOverall'];
  $kmState = $_GET['kmState'];
  $place = $_GET['place'];
  $payment = $_GET['payment'];
  $note = $_GET['note'];

  if (empty($note)) {
    $note = "N/A";
  }

 if (!empty($date)) {
   if (!empty($liters)) {
     if (!empty($pricePerLiter)) {
       if (!empty($priceOverall)) {
         if (!empty($kmState)) {
           if (!empty($place)) {
             if (!empty($payment)) {
               $result = $db->exec("INSERT INTO fuel (date,liters,pricePerLiter,priceOverall,kmState,place,payment,note) VALUES ('$date', '$liters', '$pricePerLiter', '$priceOverall', '$kmState', '$place', '$payment', '$note')");
               if(!$result) {
                  echo $db->lastErrorMsg();
               }
               else {
                 $alertType = "success";
                 $alertMsg = "New record added successfully!";
               }
             }
           }
         }
       }
     }
   }
 }
}

/*
* Manage record deleteing
*/

if(isset($_GET['delete'])) {
  $deleteID = $_GET['delete'];

  $result = $db->exec("DELETE FROM fuel WHERE id='$deleteID'");
  if(!$result) {
    echo $db->lastErrorMsg();
  }
  else {
    $alertType = "warning";
    $alertMsg = "Record ID " . $deleteID . " deleted successfully!";
  }
}

/*
* Manage record editing
*/

if(isset($_GET['edit'])) {
  $editID = $_GET['edit'];

  $result = $db->exec("DELETE FROM fuel WHERE id='$deleteID'");
  if(!$result) {
    echo $db->lastErrorMsg();
  }
  else {
    $alertType = "success";
    $alertMsg = "Record ID " . $editID . " edited successfully!";
  }
}

/*
* Generating history table content
*/

if(isset($_GET['tableLimit'])) {
  $sql = "SELECT * from fuel";
}
else {
  $sql = "SELECT * from fuel LIMIT 5";
}

$tableContent = "";

$result = $db->query($sql);
while($row = $result->fetchArray() ) {
  $tableContent .= "<tr id='tr" . $row['id'] . "'><td>" . $row['id'] . "</td>" . "<td>" . $row['date'] . "</td>" . "<td>" . $row['liters'] . " l</td>" . "<td>" . $row['pricePerLiter'] . " Kc</td>" . "<td>" .
  $row['priceOverall'] . " Kc</td>" . "<td>" . $row['kmState'] . " km</td>" . "<td>" . $row['place'] . "</td>" . "<td>" . $row['payment'] . "</td>" . "<td>" . $row['note'] . "</td>" .
  "<td>" .
  "<button class='modalDeleteRecord' data-toggle='modal' data-target='#modalDeleteRecord' data-id='" . $row['id'] . "' style='background-color: Transparent; border: none;'><span class='badge' style='background-color: #d64f4f;'>delete</span></button>" .
  "</td></tr>";
}
?>
