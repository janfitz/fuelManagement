<?php
/**
 * overallStats.php
 *
 * @author Jan Fitz <jan@janfitz.cz>
 * @link
 */

// Definition of variables
$avgConsumption_OVERALL = 0;
$avgPrice_OVERALL = 0;
$totalSpend_OVERALL = 0;
$avgOverallPrice_OVERALL = 0;
$kms = 0;
$kmStateFirst = 0;
$kmStateLast = 0;
$sumLiters = 0;

/*
* AVG fuel consumption
*/

$result = $db->query("SELECT SUM(liters) AS sumLiters FROM fuel");
while($row = $result->fetchArray()) {
  $sumLiters = $row['sumLiters'];
}

$result = $db->query("SELECT kmState AS kmStateFirst FROM fuel ORDER BY kmState ASC LIMIT 1");
while($row = $result->fetchArray()) {
  $kmStateFirst = $row['kmStateFirst'];
}

$result = $db->query("SELECT kmState AS kmStateLast FROM fuel ORDER BY kmState DESC LIMIT 1");
while($row = $result->fetchArray()) {
  $kmStateLast = $row['kmStateLast'];
}

$kms = $kmStateLast - $kmStateFirst;
$distance_OVERALL = $kms;

// If no record
if($kms > 0) {
  $avgConsumption_OVERALL = 100*$sumLiters/$kms;
}
else {
  $avgConsumption_OVERALL = 0;
}

/*
* AVG price per liter
*/

$result = $db->query("SELECT AVG(pricePerLiter) AS pricePerLiter FROM fuel");
while($row = $result->fetchArray()) {
  $avgPrice_OVERALL = $row['pricePerLiter'];
}

/*
* AVG total spend
*/

$result = $db->query("SELECT SUM(priceOverall) AS totalSpend_OVERALL FROM fuel");
while($row = $result->fetchArray()) {
  $totalSpend_OVERALL = $row['totalSpend_OVERALL'];
}

/*
* AVG price overall
*/

$result = $db->query("SELECT AVG(priceOverall) AS priceOverall FROM fuel");
while($row = $result->fetchArray()) {
  $avgOverallPrice_OVERALL = $row['priceOverall'];
}

?>
