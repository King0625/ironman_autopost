<?php
include "config.php";

date_default_timezone_set('Asia/Taipei');

function crawlOnePage($ch){
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER	, array(COOKIE));

    $result = curl_exec($ch);

    return $result;
}

function publishPost($ch, $post_data){
    curl_setopt($ch, CURLOPT_POST, true);
    // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER	, array(COOKIE . ';Content-Type: application/x-www-form-urlencoded'));

    $output = curl_exec($ch);
    curl_close($ch);
    echo $output;
}
