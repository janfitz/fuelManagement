<?php
/**
 * monthlyStats.php
 *
 * @author Jan Fitz <jan@janfitz.cz>
 * @link
 */

// Definition of variables
$avgConsumption_MONTHLY = 0;
$avgPrice_MONTHLY = 0;
$totalSpend_MONTHLY = 0;
$avgOverallPrice_MONTHLY = 0;
$divKm = [];
$counter= 0;
$kms = 0;
$sumLiters = 0;
$kmStateFirst = 0;
$kmStateLast = 0;

/*
* AVG fuel consumption
*/

// Get current month number
$month = (date('m'));

$result = $db->query("SELECT SUM(liters) AS sumLiters FROM fuel WHERE strftime('%m', date) = '$month'");
while($row = $result->fetchArray()) {
  $sumLiters = $row['sumLiters'];
}

$result = $db->query("SELECT kmState AS kmStateFirst FROM fuel WHERE strftime('%m', date) = '$month' ORDER BY kmState ASC LIMIT 1");
while($row = $result->fetchArray()) {
  $kmStateFirst = $row['kmStateFirst'];
}

$result = $db->query("SELECT kmState AS kmStateLast FROM fuel WHERE strftime('%m', date) = '$month' ORDER BY kmState DESC LIMIT 1");
while($row = $result->fetchArray()) {
  $kmStateLast = $row['kmStateLast'];
}

$kms = $kmStateLast - $kmStateFirst;
$distance_MONTHLY = $kms;

// If no record in current month
if($kms > 0) {
  $avgConsumption_MONTHLY = 100*$sumLiters/$kms;
}
else {
  $avgConsumption_MONTHLY = 0;
}

/*
* AVG price per liter
*/

$result = $db->query("SELECT AVG(pricePerLiter) AS pricePerLiter FROM fuel WHERE strftime('%m', date) = '$month'");
while($row = $result->fetchArray()) {
  $avgPrice_MONTHLY = $row['pricePerLiter'];
}

/*
* AVG total spend
*/

$result = $db->query("SELECT SUM(priceOverall) AS totalSpend_MONTHLY FROM fuel WHERE strftime('%m', date) = '$month'");
while($row = $result->fetchArray()) {
  $totalSpend_MONTHLY = $row['totalSpend_MONTHLY'];
}

/*
* AVG price overall
*/

$result = $db->query("SELECT AVG(priceOverall) AS priceOverall FROM fuel WHERE strftime('%m', date) = '$month'");
while($row = $result->fetchArray() ) {
  $avgOverallPrice_MONTHLY = $row['priceOverall'];
}

?>
