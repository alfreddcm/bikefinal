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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css" class="rel">
</head>
      <style>
          .con{
            margin-top: 140px;
            border-radius:8px;
            width: 1000px;
            background-color: rgba(0, 0, 0, 0.3);
            margin-left: auto;
            margin-right: auto;
            box-shadow:8px 6px 6px;
          }
          .user{
            color:white;
            font-size:23px;
            font-weight: bold;
           padding: 10px;
            margin-bottom: 0.5rem;
             display: flex;
             flex-direction: column;
            width: 75%;
            margin-left: 100px;
            margin-right: auto;
          }
  
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
          /*nav*/
  .navbar {
    background-color: #333;
      display: flex;
      justify-content: flex-end;
      padding: 10px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .navbar a {
    color: #fff;
      text-decoration: none;
      padding: 8px 16px;
      margin: 0 8px;
      border-radius: 4px;
      transition: background-color 0.3s ease;
  }

  .active {
    background-color: gray;
  }

      </style>
</head>
<body>
<div class="navbar">
  <a class="active" href="dashboard.php">Dashboard</a>
  <a href="bikelist.php">Bike List</a>
  <a href="historylist.php">Transaction</a>
  <a href="repairlist.php">Repair List</a>
  <a href="login.php" onclick="return confirm('Are you sure you want to log out?')">Log out</a>
</div>

  <div class="con">
              <div class="user">
                    <?php echo "Hello ".$_SESSION['fname'] . " " . $_SESSION['lname']."<br>";
                    echo $_SESSION['depname']. " Department"; ?> 
              </div>

       <div class="dashboard">
        <div class="href"><a href="bikelist.php">
          <fieldset class="fieldset1">
            <legend>BIKE LIST</legend>
            <?php
                $sql = "SELECT * FROM bikeinfo";
                $query = $conn->query($sql);
                $result = $query->fetch_all(MYSQLI_ASSOC);
                $rowCount = count($result);
                echo $rowCount . " registered Bike";
            ?><br>
        </fieldset></a></div>

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
                $sql = "SELECT * FROM bikeinfo where stat='available'";
                $query = $conn->query($sql);
                $result = $query->fetch_all(MYSQLI_ASSOC);
                $rowCount = count($result);
                echo $rowCount . " available bike";
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
  </body>
</html>
