<?php

include "connection.php";

$city = $_GET['city'];


$fetch_query = "SELECT * FROM weather WHERE city = '{$city}' and weather_when>= DATE_SUB(NOW(),INTERVAL 3100 SECOND) ORDER BY weather_when DESC limit 1";
$result = mysqli_query($conn,$fetch_query);

$url = "https://api.openweathermap.org/data/2.5/weather?units=metric&q=".$city."&appid=2b762a623c4f95e31578d4f66a102bd0";
$test = @file_get_contents($url);

if($test==false){
    echo "error";
}

$json = json_decode($test,true);
if($result->num_rows==0){
    $insert_query = "INSERT INTO weather(city,temp,weatherType) VALUES('{$city}','{$json["main"]["temp"]}','{$json["weather"][0]["description"]}')";
    mysqli_query($conn,$insert_query);
}


function display($city){
    include "connection.php";
    $fetch_query = "SELECT * FROM weather WHERE city = '{$city}' ORDER BY weather_when DESC limit 1";
    $result = mysqli_query($conn,$fetch_query);
    $row = mysqli_fetch_array($result);

   
    echo "<div class='weather'>
    <h1 id='city'>{$row["city"]}</h1>
    <h1 id='temp'>{$row["temp"]}</h1>
    <h1 id='weatherType'>{$row["weatherType"]}</h1>
    <h1 id='weather_when'>{$row["weather_when"]}</h1>
    </div>";
}

display($city);

?>