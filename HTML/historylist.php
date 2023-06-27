<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'connection.php';
$sql1="ALTER TABLE history AUTO_INCREMENT = 1";
$resultq1 = $conn->query($sql1);

$sql = "SELECT * FROM history ORDER BY dtreturn";
$result = $conn->query($sql);

$isOnRepairList = false; // Flag to indicate if the bike is on the repair list

$checkRepairStmt = $conn->prepare("SELECT * FROM repairlist WHERE bikeid = ?");
$checkRepairStmt->bind_param("s", $row["bikeid"]);
$checkRepairStmt->execute();

if ($checkRepairStmt->get_result()->num_rows > 0) {
    $isOnRepairList = true;
}

$checkRepairStmt->close();

// Removing from history
if (isset($_GET['delete_id'])) {
    $bikeid = $_GET['delete_id'];
    $deleteStmt = $conn->prepare("DELETE FROM history WHERE bikeid = ?");
    $deleteStmt->bind_param("s", $bikeid);

    if ($deleteStmt->execute() && $deleteStmt->affected_rows > 0) {
        $sqlauto="ALTER TABLE history AUTO_INCREMENT = 1";
        $resultq1 = $conn->query($sqlauto);
        $sql3 = "UPDATE bikeinfo SET stat = ? WHERE bikeid = ?";
        $query3 = $conn->prepare($sql3);
        $status = "available";
        $query3->bind_param("ss", $status, $bikeid);
        $query3->execute();


        echo "<script>alert('Bike removed from history!'); window.location.href='historylist.php';</script>";
    } else {
        echo "<script>alert('Error removing bike from history!');</script>";
    }

    $deleteStmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History List</title>
    <link rel="stylesheet" href="style.css" class="rel">
    <style>
        .icon{
        width: 18px;
        height: 20px;
        margin-right: 5px;
    }
    
    </style>
    <script>
        function dash(){
    window.location.href="dashboard.php";
}
function delete_id(bikeid)
{
 if(confirm('Sure To Remove This Record ?'))
 {
  window.location.href='historylist.php?delete_id='+bikeid;
 }
}
    </script>
</head>

<body>
<div class="navbar">
  <a href="dashboard.php">Dashboard</a>
  <a href="bikelist.php">Bike List</a>
  <a class="active" href="historylist.php">Transaction</a>
  <a href="repairlist.php">Repair List</a>
  <a href="login.php" onclick="return confirm('Are you sure you want to log out?')">Log out</a>
</div>

   <center><h1>History List</h1></center>
   <div class="box"> 
    <?php
    echo "Number on the list : " . $result->num_rows;
    ?>

    <table>
        <tr>
            <th>Bike ID</th>
            <th>Student ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Course</th>
            <th>Department</th>
            <th>Date Borrowed</th>
            <th>Date Returned</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["bikeid"] . "</td>";
                echo "<td>" . $row["studidno"] . "</td>";
                echo "<td>" . $row["studfname"] . "</td>";
                echo "<td>" . $row["studlname"] . "</td>";
                echo "<td>" . $row["course"] . "</td>";
                echo "<td>" . $row["depname"] . "</td>";
                echo "<td>" . $row["dtborrow"] . "</td>";

                if($row['dtreturn'] ==""){
                    echo "<td>Not returned</td>";
                }else{
                    echo "<td>" . $row["dtreturn"] . "</td>";
                }

                echo "<td>";
                ?>
                <a href="javascript:delete_id(<?php echo $row["bikeid"]; ?>)" style='text-decoration:none' class="remove-button"><img src="delete.png" alt="Delete" class='icon' />
            <span class='remove-text' >Remove</span>
        </a>

                <?php
                if ($row['dtreturn'] == "") {
                    echo "</td>";
                } else {
                    $sql = "SELECT * FROM repairlist WHERE bikeid = ?";
                    $query = $conn->prepare($sql);
                    $query->bind_param("s", $row['bikeid']);
                    $query->execute();
                    $result1 = $query->get_result();
                    $isOnRepairList = ($result1->num_rows > 0);
                    
                    if (!$isOnRepairList) {
                        echo "<a href='movetorepair.php?rn=" . $row['bikeid'] . "&studidno=" . $row['studidno'] . "&studfname=" . $row['studfname'] .  "&studlname=" . $row['studlname'] . "' class='repair-button'>";
                        echo "<img src='repair.png' alt='Move to Repair' class='repair-icon' width='20px' height='15px'>";
                        echo "<span class='repair-text'>Move to Repair</span></a>";
                    }else{
                        echo "Bike on repair list";
                    }       
}
                }echo "</center></td>"; 
                echo "</tr>";
        } else {
            echo "<tr><td colspan='9'><center>No records found.</center></td></tr>";
        }
        ?>
        </div>
    </table>
</body>

</html>
