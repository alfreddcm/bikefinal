<?php
require('connection.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["newbikeid"])) {
    $bikeid2 = $_POST["bikeid2"];
    $newBikeId = $_POST["newbikeid"];
    $newBikeType = $_POST["biketype"];
    $newBikeColor = $_POST["bikecolor"];
    $newBikeDep = $_POST["bikedep"];

    $checkQuery = "SELECT * FROM bikeinfo WHERE bikeid = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $bikeid2);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {

        $sql = "SELECT * FROM bikeinfo WHERE bikeid = ?";
        $query = $conn->prepare($sql);
        $query->bind_param("s", $newBikeId);
        $query->execute();
        $result = $query->get_result();

        if ($result->affected_rows > 0) {
            echo "<script>alert('Bike id already on the list!'); window.location.href='bikelist.php';</script>";
        } else {
        $updateQuery = "UPDATE bikeinfo SET bikeid = ?, biketype = ?, bikecolor = ?, bikedep = ? WHERE bikeid = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("sssss", $newBikeId, $newBikeType, $newBikeColor, $newBikeDep, $bikeid2);
        $updateStmt->execute();

        if ($updateStmt->affected_rows > 0) {
            echo "<script>alert('Bike information updated successfully!'); window.location.href='bikelist.php';</script>";
        } else {
            echo "<script>alert('Error updating bike information!'); window.location.href='bikelist.php';</script>";
        }
        }
    } else {
        echo "<script>alert('Bike ID does not exist!'); window.location.href='bikelist.php';</script>";
    }
}


?>