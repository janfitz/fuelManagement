<?php
/**
 * weeklyStats.php
 *
 * @author Jan Fitz <jan@janfitz.cz>
 * @link
 */

// Definition of variables
$avgConsumption_WEEKLY = 0;
$avgPrice_WEEKLY = 0;
$totalSpend_WEEKLY = 0;
$avgOverallPrice_WEEKLY = 0;
$divKm = [];
$counter= 0;
$kms = 0;
$sumLiters = 0;


/* AVG fuel consumption */

$result = $db->query("SELECT SUM(liters) AS sumLiters FROM fuel WHERE date BETWEEN datetime('now', '-6 days') AND datetime('now', 'localtime')");
while($row = $result->fetchArray()) {
  $sumLiters = $row['sumLiters'];
}

$result = $db->query("SELECT kmState AS kmStateFirst FROM fuel WHERE date BETWEEN datetime('now', '-6 days') AND datetime('now', 'localtime') ORDER BY kmState ASC LIMIT 1");
while($row = $result->fetchArray()) {
  $kmStateFirst = $row['kmStateFirst'];
}

$result = $db->query("SELECT kmState AS kmStateLast FROM fuel WHERE date BETWEEN datetime('now', '-6 days') AND datetime('now', 'localtime') ORDER BY kmState DESC LIMIT 1");
while($row = $result->fetchArray()) {
  $kmStateLast = $row['kmStateLast'];
}

$kms = $kmStateLast - $kmStateFirst;
$distance_WEEKLY = $kms;

// If no record in current week
if($kms > 0) {
  $avgConsumption_WEEKLY = 100*$sumLiters/$kms;
}
else {
  $avgConsumption_WEEKLY = 0;
}

/* AVG price per liter */

$result = $db->query("SELECT AVG(pricePerLiter) AS pricePerLiter FROM fuel WHERE date BETWEEN datetime('now', '-6 days') AND datetime('now', 'localtime')");
while($row = $result->fetchArray()) {
  $avgPrice_WEEKLY = $row['pricePerLiter'];
}

/* AVG total spend */

$result = $db->query("SELECT SUM(priceOverall) AS totalSpend_WEEKLY FROM fuel WHERE date BETWEEN datetime('now', '-6 days') AND datetime('now', 'localtime')");
while($row = $result->fetchArray()) {
  $totalSpend_WEEKLY = $row['totalSpend_WEEKLY'];
}

/* AVG price overall */

$result = $db->query("SELECT AVG(priceOverall) AS priceOverall FROM fuel WHERE date BETWEEN datetime('now', '-6 days') AND datetime('now', 'localtime')");
while($row = $result->fetchArray() ) {
  $avgOverallPrice_WEEKLY = $row['priceOverall'];
}

?>
