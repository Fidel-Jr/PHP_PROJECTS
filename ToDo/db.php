<?php 

    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "todo";

    $dsn = "mysql:host=$host;dbname=$dbname";
    $con = new PDO($dsn, $user, $password);

?>