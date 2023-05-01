<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "bootstrap.php");

//do 7 times
for ($i = 0; $i < 7; $i++) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $avg[$date] = Moestuin::getAvg($date);
}

$todayData = $avg[date('Y-m-d')];
$yesterdayData = $avg[date('Y-m-d', strtotime("-1 days"))];
$twoDaysAgoData = $avg[date('Y-m-d', strtotime("-2 days"))];
$threedaysAgoData = $avg[date('Y-m-d', strtotime("-3 days"))];
$fourDaysAgoData = $avg[date('Y-m-d', strtotime("-4 days"))];
$fiveDaysAgoData = $avg[date('Y-m-d', strtotime("-5 days"))];
$sixDaysAgoData = $avg[date('Y-m-d', strtotime("-6 days"))];

var_dump($todayData, $yesterdayData, $twoDaysAgoData, $threedaysAgoData, $fourDaysAgoData, $fiveDaysAgoData, $sixDaysAgoData);