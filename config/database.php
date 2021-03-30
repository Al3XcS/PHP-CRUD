<?php
//Folosim sa ne conectam la baza de date
$host = "localhost";
$db_name = "YourDatabase";
$username = "root";
$password = "";

try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
}

//Arata daca avem erori
catch(PDOException $exception){
    echo "Connection error: " . $exception->getMessage();
}
?>