<?php
    $host = "localhost";
    $username = "root";
    $password = " ";
    $Database = "gestions";
    try
    {
        $connect = new PDO("mysql:host=$host;dbname=$Database",$username,$password);
        $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        print "Connected in $Database";
    }
    catch(PDOException $e)
    {
        print "Erreur ". $e->getMessage();
        die();
    }
?>