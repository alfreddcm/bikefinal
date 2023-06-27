<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'connection.php';
$sql = "SELECT * FROM bikeinfo order by stat desc";
$result = $conn->query($sql);

// Adding
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $bikeid = $_POST["bikeid"];
        $biketype = $_POST["biketype"];
        $bikecolor = $_POST["bikecolor"];
        $bikedep = $_POST["bikedep"];
        $stat = $_POST["stat"];

        $checkQuery = "SELECT * FROM bikeinfo WHERE bikeid = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param("s", $bikeid);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            echo "<script>alert('Bike ID is already in the list!'); window.location.href='bikelist.php';</script>";
        } else {
            $insertQuery = "INSERT INTO bikeinfo (bikeid, biketype, bikecolor, bikedep, stat) VALUES (?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("sssss", $bikeid, $biketype, $bikecolor, $bikedep, $stat);
            $insertStmt->execute();

            if ($insertStmt->affected_rows > 0) {
                echo "<script>alert('Record has been saved!'); window.location.href='bikelist.php';</script>";
                exit;
            } else {
                echo "<script>alert('No record has been saved!');</script>";
            }
        }
}

// Deleting
if(isset($_GET['delete_id'])){
        $bikeid = $_GET['delete_id'];
        $stmt = $conn->prepare("DELETE FROM bikeinfo WHERE bikeid = ?");
        $stmt->bind_param("s", $bikeid);
        
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "<script>alert('Record Deleted!'); window.location.href='bikelist.php';</script>";
            } else {
                echo "<script>alert('No record found to delete!'); window.location.href='bikelist.php';</script>";
            }
        } else {
            echo "Error executing the delete query: " . $stmt->error;
        }
        
        $stmt->close();
}

?>

<style>

#add, #update {
    display: none;
}
::placeholder{
    color: white;
    font-family: Arial;
}
#add input, #update input{
    outline: none;
    text-align:center;
    height: 25px;
    background: transparent;
    border-bottom: 1px solid green;
    border-top: none;
    border-right: none;
    border-left: none;
    color: black;
    font-size: 15px;
    letter-spacing: 1px;
    margin-top: 3px;
    font-family: sans-serif;

}
#add button,#update button{
    width: 100px;
    height: 20px;
    background: green;
    border: none;
    margin-top: 10px;
    font-size: 12px;
    border-radius: 5px;
    cursor: pointer;
    color: #fff;
    transition: 0.4s ease;
   padding: 1px;
    text-decoration: none;
    color: #000;
    text-transform: uppercase;
}

#add,#update ::after{}
.grid-container {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        grid-gap: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 3px, 5px, 0.2);
        padding: 30px;
        background-color: RGB (240, 240, 240);
    }

    .grid-item {
        border-radius: 5px;
        padding: 10px;
        background-color: #ffffff;
        line-height: 0.1;
        flex-direction: column; 
        align-items: flex-start;
        justify-content: center;
        box-shadow:2px 3px 2px black;

    }
    .remove-button, .repair-button {
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: none;
        text-decoration: none;
    }

    .icon{
        width: 18px;
        height: 20px;
        margin-right: 5px;
    }

    .remove-text, .repair-text{
        display: inline;
        color:black;
    }
              /*nav*/

  .box{    
    background-color: rgba(128, 128, 128, 0.70);
    color:white;
    padding:20px;
    border-radius:7px;
    width:94%;
    margin:auto;
  }
  .flex{ 
    display:flex;
  }

    
</style>


<script>
    
function showadd() {
    var addDiv = document.getElementById("add");
    var updateDiv = document.getElementById("update");

    // Show the 'add' div and hide the 'update' div
    addDiv.style.display = "block";
    updateDiv.style.display = "none";
    event.preventDefault();

}

function updatebike() {
    var addDiv = document.getElementById("add");
    var updateDiv = document.getElementById("update");

    // Show the 'update' div and hide the 'add' div
    updateDiv.style.display = "block";
    addDiv.style.display = "none";
    event.preventDefault();
}
function cancel() {
  var addDiv = document.getElementById("add");
  var updateDiv = document.getElementById("update");

  // Hide both the 'add' and 'update' divs
  addDiv.style.display = "none";
  updateDiv.style.display = "none";
}

function dash(){
    window.location.href="dashboard.php";
}

function delete_id(bikeid)
{
 if(confirm('Sure To Remove This Record ?'))
 {
  window.location.href='bikelist.php?delete_id='+bikeid;
 }
}
function upstat(bikeid)
{
 if(confirm('Select ok to continue'))
 {
  window.location.href='changestat.php?upstat='+bikeid;
 }
}

function confirmSubmit1() {
        return confirm("Are you sure you want to submit the form?");
    }
    function confirmSubmit2() {
        return confirm("Are you sure you want to submit the form?");
    }
</script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Data</title>
    <link rel="stylesheet" href="style.css" class="rel">
</head>

<body>
<div class="navbar">
  <a href="dashboard.php">Dashboard</a>
  <a class="active" href="bikelist.php">Bike List</a>
  <a href="historylist.php">Transaction</a>
  <a href="repairlist.php">Repair List</a>
  <a href="login.php" onclick="return confirm('Are you sure you want to log out?')">Log out</a>
</div>
    <center><h1> Bike List</h1></center>
    <div class="box">
        <div class="flex">
             <?php echo "Number of bikes : " . $result->num_rows . "   " ?>
    <div class="show">
    <button onclick="showadd()">Add Bike</button>
    <button onclick="updatebike()">Edit Bike Information</button>
        </div>
   </div>   
    <center><div id="add">
                <h1>Adding bike</h1>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="return confirmSubmit1();">
                    <input type="number" id="bikeid" name="bikeid" placeholder="Bike ID " required>
                    <input type="text" id="biketype" name="biketype" placeholder="Bike Type " required>
                    <input type="text" id="bikecolor" name="bikecolor" placeholder="Bike Color " required>
                    <input type="text" id="bikedep" name="bikedep" placeholder="Bike Deperment " required>
                    <input type="hidden" name="stat" value="available">
                    <button type="submit">Submit</button>
                </form>
                <button onclick="cancel()">Cancel</button>

            </div>
            <div id="update">
                <h1>Edit Bike Information</h1>
                <form action="updatebike.php" method="POST" onsubmit="return confirmSubmit2();">
                    <input type="number" id="bikeid2" name="bikeid2" placeholder="Bike ID "required>  
                    <input type="number" id="newbikeid" name="newbikeid"placeholder="New Bike ID " required>
                    <input type="text" id="biketype" name="biketype" placeholder="New Bike Type"qrequired>
                    <input type="text" id="bikecolor" name="bikecolor" placeholder="New Bike Color " required>
                    <input type="text" id="bikedep" name="bikedep" placeholder="New Department Name" required>
                    <button type="submit">Update Bike</button>
                </form>
                <button onclick="cancel()">Cancel</button>
            </div></center>











<div class="grid-container">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='grid-item'>";
            echo "<table>";
            echo "<tr><td>Bike ID:</td><td>" . $row["bikeid"] . "</td></tr>";
            echo "<tr><td>Type:</td><td>" . $row["biketype"] . "</td></tr>";
            echo "<tr><td>Color:</td><td>" . $row["bikecolor"] . "</td></tr>";
            echo "<tr><td>Department:</td><td>" . $row["bikedep"] . "</td></tr>";
            echo "<tr><td>Status:</td><td>" . $row["stat"] . " </td></tr>";
            echo "</table>";
            ?>
            <center>
            <a href="javascript:delete_id(<?php echo $row["bikeid"]; ?>)" style='text-decoration:none'><img src="delete.png" alt="Delete" class='icon' />
            <span class='remove-text' >Remove</span>
        </a><br>
        <a href="javascript:upstat(<?php echo $row["bikeid"]; ?>)" style='text-decoration:none'><img src="up.png" alt="up" class='icon' />
        <span class='remove-text' >Change status</span>
    </a></center>

            <?php
            echo "</div>";
        } 
    } else {
        echo "<p> No results found. </p>";
    }
    $result->close();
    ?>
</div>
    <div>
            

            
        </div>
    </body>
</html>
