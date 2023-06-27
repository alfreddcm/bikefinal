<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'connection.php';
$sql = "SELECT bikeid,studidno,brokenparts,dateadded FROM repairlist";
$result = $conn->query($sql);

// Removing from repairlist
if (isset($_GET['delete_id'])) {
    $bikeid = $_GET['delete_id'];

    $deleteStmt = $conn->prepare("DELETE FROM repairlist WHERE bikeid = ?");
    $deleteStmt->bind_param("s", $bikeid);


    $sql="UPDATE bikeinfo set stat='available' where bikeid=?";
    $updatestat=$conn->prepare($sql);
    $updatestat->bind_param("s", $bikeid);
    $updatestat->execute();

    if ($deleteStmt->execute() && $deleteStmt->affected_rows > 0) {
        echo "<script>alert('Bike removed from list!'); window.location.href='repairlist.php';</script>";
    } else {
        echo "<script>alert('Error removing bike from history!');</script>";
    }

    $deleteStmt->close();
}

?>
    <script>
        function dash(){
    window.location.href="dashboard.php";
}
function delete_id(bikeid)
{
 if(confirm('Sure To Remove This Record ?'))
 {
  window.location.href='repairlist.php?delete_id='+bikeid;
 }
}
    </script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repair</title>
    <link rel="stylesheet" href="style.css" class="rel">
</head>
<body>
<div class="navbar">
  <a href="dashboard.php">Dashboard</a>
  <a href="bikelist.php">Bike List</a>
  <a href="historylist.php">Transaction</a>
  <a class="active" href="repairlist.php">Repair List</a>
  <a href="login.php" onclick="return confirm('Are you sure you want to log out?')">Log out</a>
</div>


    <center><h1>Repair List</h1></center>
    <div class="box">
    <table>
        <tr>
            <th>Bikeid</th>
            <th>Student ID</th>
            <th>Broken parts</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["bikeid"] . "</td>";
                echo "<td>";
                if ($row["studidno"] == 0) {
                    echo "Added by admin";
                } else {
                    echo $row["studidno"];
                }
                echo "</td>";
                echo "<td>" . $row["brokenparts"] . "</td>";
                echo "<td>" . $row["dateadded"] . "</td>";
                echo "<td>";
                ?>
                <a href="javascript:delete_id(<?php echo $row["bikeid"]; ?>)"><img src="delete.png" alt="Delete" class='remove-icon' width='20px' height='15px' />
                <span class='remove-text'>Remove</span></a>
                <?php
            }
        } else {
            echo "<tr><td colspan='5' ><center>No records found.</center></td></tr>";
        }
        ?> 
    </table>
</div>
</body>
</html>
