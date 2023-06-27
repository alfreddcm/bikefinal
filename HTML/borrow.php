<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bikeid = $_POST['dropd'];
    $studid = $_POST['idno'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $course = $_POST['course'];
    $department = $_POST['dep'];
    $datetime = $_POST['datetime'];

    if ($bikeid === '' || $studid === '' || $fname === '' || $lname === '' || $course === '' || $department === '' || $datetime === '') {
        echo "<script>alert('Please fill in all required fields.'); window.location.href='index.php';</script>";
        exit();
    }

    $sql = "SELECT * FROM history ORDER BY transno DESC LIMIT 1";
    $query = $conn->prepare($sql);
    if ($query->execute()) {
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $valid = $row['dtreturn'];
            $checkstudid = $row['studidno'];
            $checkfname = $row['studfname'];
            $checklname = $row['studlname'];

            if ($valid == null && $studid == $checkstudid && $fname == $checkfname && $lname == $checklname) {
                echo "<script>alert('You cannot borrow a bike. Please return the borrowed bike first.'); window.location.href='index.php';</script>";
                exit();
            }
        }

        $query->close();

        $sql1 = "SELECT * FROM history WHERE studidno = ? AND (studfname != ? and studlname != ?) AND dtreturn IS NULL";
        $query1 = $conn->prepare($sql1);
        $query1->bind_param("sss", $studid, $fname, $lname);
        $query1->execute();
        $result1 = $query1->get_result();

        if ($result1->num_rows > 0) {
            echo "<script>alert('ID number and Name mismatch. Please check your input'); window.location.href='index.php';</script>";
            exit();
        }
        
        $query1->close();
        $sql2 = "INSERT INTO history (bikeid, studidno, studfname, studlname, course, depname, dtborrow) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $query2 = $conn->prepare($sql2);
        $query2->bind_param("sssssss", $bikeid, $studid, $fname, $lname, $course, $department, $datetime);
        $query2->execute();

        $sql3 = "UPDATE bikeinfo SET stat = ? WHERE bikeid = ?";
        $query3 = $conn->prepare($sql3);
        $status = "borrowed";
        $query3->bind_param("ss", $status, $bikeid);
        $query3->execute();

        if ($query2->affected_rows > 0 && $query3->affected_rows > 0) {
            echo "<script>alert('Transaction Recorded!'); window.location.href='index.php';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to record the transaction!'); window.location.href='index.php';</script>";
            exit();
        }
    }
        }
?>
