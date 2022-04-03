<?php
    $servername = "localhost";
    $username = "denisko_root";
    $password = "jl@<8jDKfrwe]sF";
    $dbname = "denisko28";

    function MysqlConnect()
    {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
?>