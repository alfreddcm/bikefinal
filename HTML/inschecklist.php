<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $bikeid = $_GET['bikeid'];
    $studidno = $_GET['studidno'];
    $checklist = $_POST['checklist'];
    $dateadded = date("Y-m-d");

        $parts = $_POST['checklist'];
        $partsString = implode(', ', $parts);

        $sql = "INSERT INTO repairlist (bikeid,studidno, brokenparts, dateadded) VALUES (?, ?, ?,?)";
        $query = $conn->prepare($sql);
        $query->bind_param("ssss", $bikeid, $studidno ,$partsString, $dateadded);
        $query->execute();
            $sql2 = "UPDATE bikeinfo SET stat = 'repair' WHERE bikeid = ?";
                        $query2 = $conn->prepare($sql2);
                        $query2->bind_param("s", $bikeid);
                        $query2->execute();

        if ($query) {
            echo "<script>alert('Bike added to the repair list.'); window.location.href='repairlist.php';</script>";
        } else {
            echo "<script>alert('Error adding to the list'); window.location.href='dashboard.php';</script>";
        }
    }
?>