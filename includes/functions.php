<?php
function dateTimeToElement($startTime,$endTime) {
    $start = date_create();
    $end = date_create();
    date_timestamp_set($start,$startTime);
    date_timestamp_set($end,$endTime);
    
    $diff = $start->diff($end);
    return ( $diff->format('%h'));
}