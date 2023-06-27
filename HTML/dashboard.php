<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('connection.php');
session_start();


if (isset($_GET['idno'])){
  $idno = $_GET['idno'];

  $sql="SELECT * from admin where idno= ? ";
  $query=$conn->prepare($sql);
  $query->bind_param("s",$idno);
  $query->execute();
  $result = $query->get_result();
  $row = $result->fetch_assoc();

  $fname = $row['fname'];
  $lname = $row['lname'];
  $depname = $row['depname'];

  $_SESSION['fname'] = $fname;
  $_SESSION['lname'] = $lname;
  $_SESSION['depname'] = $depname;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
require('connection.php');

$sql0 = "SELECT stat, COUNT(*) as count FROM bikeinfo GROUP BY stat";
$result0 = $conn->query($sql0);
$bikeCounts = $result0->fetch_all(MYSQLI_ASSOC);

// Extract the counts for each status
$borrowedCount = 0;
$availableCount = 0;
$repairCount = 0;

foreach ($bikeCounts as $bike) {
    switch ($bike['stat']) {
        case 'borrowed':
            $borrowedCount = $bike['count'];
            break;
        case 'available':
            $availableCount = $bike['count'];
            break;
        case 'repair':
            $repairCount = $bike['count'];
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css" class="rel">
    <style>

  
          .dashboard {
            width: 80%;
              display: flex;
              flex-direction: row;
              justify-content: space-between;
              align-items: center;
              margin-left: auto;
              margin-right: auto;
              padding:4px;
         }
  
          fieldset {
            margin: auto;
            transform:scale(1.1);
            color:white;
              border-radius: 10px;
              border: 3px solid white;
              width: 2in;
              height: 1in;
              margin-bottom: 1in;
              box-shadow: 2px 2px 2px black;
          }
          fieldset legend{
            width:10rem;
            height: 1.6rem;
            background: black;
            border-radius: 3px;
            font-size: large;
            margin-left:-30px;
          }
          .fieldset1, .fieldset2, .fieldset3{
            background-color: #333;
          }
          .fieldset1:hover, .fieldset2:hover, .fieldset3:hover{
            transform:scale(1.2);
          }
          .fieldset1{
            height: auto;
            margin-top:85px;

          }
    .href a{
      text-decoration:none;
      color:white;
      width: 100%;
      text-align: center;
          }
          .href a{
      text-decoration:none;
      color:white;
      width: 100%;
      text-align: center;
          }

  .con {
margin-left:auto;
margin-right:auto;
    width:85%;
  display: flex;
  justify-content: space-between;
}

.user {
  background-color: #333;
  color:white;
  flex-grow: 1;
}

.navbar {
  text-align: right;
  height: 30px;
}

.nav-links {
  display: inline-block;
}

.nav-links a {
  margin-left: 10px;
}
.text{
  
  margin-top:7px;
  margin-left:7px;
}

  .active {
    background-color: gray;
  }

    </style>
</head>
<body>
<div class="con">
              <div class="user">
                <div class="text">
                   <?php echo "HELLO  ".$_SESSION['fname'] . " " . $_SESSION['lname']."<br>";
                    echo $_SESSION['depname']. " Department"; ?> 
                </div>
                   
              </div>

<div class="navbar">
  <a class="active" href="dashboard.php">Dashboard</a>
  <a href="bikelist.php">Bike List</a>
  <a  href="historylist.php">Transaction</a>
  <a href="repairlist.php">Repair List</a>
  <a href="login.php" onclick="return confirm('Are you sure you want to log out?')">Log out</a>
</div> 

</div> 
  <div class="dashboard">
    <div class="href">
      <a href="bikelist.php">
        <fieldset class="fieldset1">
          <legend>BIKE LIST</legend>
          <?php
                $sql = "SELECT * FROM bikeinfo";
                $query = $conn->query($sql);
                $result = $query->fetch_all(MYSQLI_ASSOC);
                $rowCount = count($result);
                echo $rowCount . " registered Bike";
            ?><br><?php
            $sql = "SELECT * FROM bikeinfo where stat='available'";
            $query = $conn->query($sql);
            $result = $query->fetch_all(MYSQLI_ASSOC);
            $rowCount = count($result);
            echo $rowCount . " available bike";
        ?>
            <div class="containerg">
            <canvas id="myChart"></canvas>
          </div>
        </fieldset>
      </a>
    </div>
    <div class="href"><a href="historylist.php">
        <fieldset class="fieldset2">
            <legend>TRANSACTIONS</legend>
            <?php
                $sql = "SELECT * FROM bikeinfo where stat='borrowed'";
                $query = $conn->query($sql);
                $result = $query->fetch_all(MYSQLI_ASSOC);
                $rowCount = count($result);
                echo $rowCount . " borrowed bike";
            ?><br>
            <?php
               $sql = "SELECT * FROM history WHERE dtreturn <> ''";
               $query = $conn->query($sql);
               $result = $query->fetch_all(MYSQLI_ASSOC);
               $rowCount = count($result);
               
               if ($rowCount > 0) {
                   echo $rowCount . " returned bike(s)";
               } else {
                   echo "No bikes returned";
               }
               
            ?>
        </fieldset></a></div>

        <div class="href"> <a href="repairlist.php">
        <fieldset class="fieldset3">
            <legend>REPAIR LIST</legend>
            <?php
                $sql = "SELECT * FROM repairlist ";
                $query = $conn->query($sql);
                $result = $query->fetch_all(MYSQLI_ASSOC);
                $rowCount = count($result);
                echo $rowCount . " listed bike ";
            ?>
        </fieldset>
        <br></a> </div>
      </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    var borrowedCount = <?php echo $borrowedCount; ?>;
    var availableCount = <?php echo $availableCount; ?>;
    var repairCount = <?php echo $repairCount; ?>;

    // Create the chart
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Borrowed', 'Available', 'Repair'],
            datasets: [{
                label: 'Bike Status',
                data: [borrowedCount, availableCount, repairCount],
                backgroundColor: [
                    'red',
                    'green',
                    'pink'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            plugins: {
                datalabels: {
                    formatter: function(value, context) {
                        return context.chart.data.labels[context.dataIndex];
                    },
                    color: 'black',
                    font: {
                        weight: 'bold'
                    },
                    anchor: 'end',
                    align: 'start',
                    offset: 10
                }
            }
        }
    });
  </script>
</body>
</html>
