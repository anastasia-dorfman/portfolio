<?php
        $hostname = "localhost";
        $username = "dev";
        $password = "dev1234";
        $dbName = "anastasia_dorfman_portfolio";
        
        global $con;
        $con = new mysqli($hostname, $username, $password, $dbName);
        if ($con->connect_error) {
            die("Connection failed" . $conn->connect_error);
        }
        
?>