<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('connection.php');
$sql = "SELECT * FROM bikeinfo where stat='available'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bike Management System</title>
</head>
<style>

    body{
        color: white;
    display:flex;       
	height: 100%;
    font-family: Poppins-Regular, sans-serif;
    background-image: url("bgimage.png");
    background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: center;
  background-size: 100%;
}
        
.column1 {
    color:white;
  float: left;
  width: 60%;
  padding: 10px;
}
.column2 {
  float: left;
  width: 40%;
  padding: 10px;
  height: 300px;
}
#idno{
    
    margin-top:px;
    width:68px;
}
#fname,#lname{
    width: 150px;
}
#course,#dep{
    width: 190px;
    margin-bottom:3px;
}
#datetime,#datetimer{
  margin-top:5px;
  width: 100%;
  text-align: center;
  outline: none;
}

.con{
    color: white;
    background: linear-gradient(to top, rgba(0,0,0,0.8)50%,rgba(0,0,0,0.8)50%);
    transform: scale(1.10);
    background-color:white;
    border-radius:3px;
    margin-top:6rem;
    width:400px;
    box-shadow:1px 3px 3px 3px black;
    padding:20px;
}
#status, #bikeid{
    border: 1px solid white;
    color:white;
        background-color: transparent;
    border-radius:3px;
    background-color:gren;
    font-size:15px;
    text-align:center;
    display: block;
  margin-left: auto;
  margin-right: auto;
    width:100%;
}
.side{
  display: flex;
  flex-direction: row-reverse;
  align-content:center;
  padding:20px;
}
.side button{
    text-shadow:2px 2px 2px black;
    color:white;
    font-size:18px;
    cursor: pointer;
    background-color: transparent;
  text-decoration:none;
  margin: 10px;
  border:none;
  transition: 0.4s ease-in-out;
}
.side button:hover{
    color:red;

}
#return input[type="text"],
input[type="number"]{
    outline: none;
    text-align:center;
    width: 90%;
    height: 25px;
    background: transparent;
    border-bottom: 1px solid green;
    border-top: none;
    border-right: none;
    border-left: none;
    font-size: 15px;
    letter-spacing: 1px;
    margin-top: 3px;
    font-family: sans-serif;
}
#borrow input[type="text"],
input[type="number"]{
    color:white;
    outline: none;
    text-align:center;
    height: 25px;
    background: transparent;
    border-bottom: 1px solid green;
    border-top: none;
    border-right: none;
    border-left: none;
    font-size: 15px;
    letter-spacing: 1px;
    margin-top: 3px;
    font-family: sans-serif;
}

::placeholder{
    color: white;
    font-family: Arial;
}
.postt{
    background-color: rgba(0, 0, 0, 0.5);
    letter-spacing: .5px;
    font-size:20px;
    margin-top:130px;
    padding:10px;
    width: 600px;
    border-radius:4px;
    box-shadow:1px 3px 3px 3px black;
}

.btnn{
    width: 100px;
    height: 20px;
    background: green;
    border: none;
    margin-top: 9px;
    font-size: 12px;
    border-radius: 10px;
    cursor: pointer;
    color: #fff;
    transition: 0.4s ease;
   padding: 1px;
    text-decoration: none;
    color: #000;
    text-transform: uppercase;
}
.btnn:hover{
    background: #fff;
    color: green;
}
</style>

<body>
        
    <div class="column1">
        <h1>Welcome to Bike Management System</h1>
        <div class="p">
            <?php echo "Today is " . date("l"); ?>
        </div>
        <div class="postt">
<center><p>
If your bike's out of commission, but you still need to get around, you might need to resort to borrowing a buddy's. But don't take that kindness for granted, borrowing a bike is a lot like babysitting - it's pretty easy, but if you mess up you're going to have some very angry parents on your hands. In today's post, let's look at the rules for successfully bumming a ride and keeping your friendships.
</p></center>
        </div>

    </div>

    <div class="column2">
        <div class="side">
            <button onclick="gohome()">Help and Support</button>
            <button onclick="gologin()">Login as administrator</button>
        </div>
<div class="con"> 
<label for="">Select action:</label><br>
<select name="status" id="status" required>
<option value="borrow">BORROWING</option>
<option value="return">RETURNING</option>
</select><br>

<div id="borrow">
<form action="borrow.php" method="POST" id="borrowform" onsubmit="return validateForm();">
<?php echo "Number available bikes: " . $result->num_rows;?><br>
<label for="">Choose bike id:</label><br>
<select name="dropd" id="bikeid">
<?php while ($row = mysqli_fetch_assoc($result)): ?>
<option value="<?php echo $row["bikeid"]; ?>">
<?php echo $row["bikeid"]; ?>
</option>
<?php endwhile; ?>
</select>
<input type="text" name="idno" id="idno" placeholder="ID No" require>
<input type="text" name="fname" id="fname" placeholder="First Name" require>
<input type="text" name="lname" id="lname" placeholder="Last Name" require><br>
<input type="text" name="course" id="course" placeholder="Course" require>
<input type="text" name="dep" id="dep" placeholder="Department" require><br>
<input type="datetime-local" name="datetime" id="datetime" require> 
<br>
<center><input type="submit" class="btnn" name="submit"></center>
</form>
</div>


<div id="return">
<form action="return.php" method="POST" id="returnform" onsubmit="return validateForm2();">
<label for="">Enter bike id:</label><br>
    <center><input type="text" name="bikeidr" id="bikeidr" placeholder="Bike ID">
    <input type="text" name="idnor" id="idnor" placeholder="ID No"><br>
    <input type="datetime-local" name="datetimer" id="datetimer" require> 
    <br>
    <input type="submit" name="submit" class="btnn"></center>
</form>
</div>
</div>
</body>


<script>
 var currentDatetime = new Date();

var Datetime = new Date(currentDatetime.getTime() + (currentDatetime.getTimezoneOffset() * 60000));
Datetime.setHours(Datetime.getHours() + 16);
var formattedDatetime = Datetime.toISOString().slice(0, 16);
document.getElementById("datetime").value = formattedDatetime.replace("T", " ");
document.getElementById("datetimer").value = formattedDatetime.replace("T", " ");


    function gologin(){
        window.location.href="login.php";
    }
    function validateForm() {
        if (confirm("Are you sure you want to submit the form?")) {
                return true;
            } else {
                return false;
            }
        
        const idno = document.getElementById("idno").value;
        const fname = document.getElementById("fname").value;
        const lname = document.getElementById("lname").value;
        const course = document.getElementById("course").value;
        const dep = document.getElementById("dep").value;
        
        if (idno === ""  || fname === "" || lname === "" || course=== "" || dep=== "" ) {
            alert("Please fill in all required fields.");
            return false;
        }
        return true;
    }
    function validateForm2() {

        if (confirm("Are you sure you want to submit the form?")) {
                return true;
            } else {
                return false;
            }

        const idno = document.getElementById("idnor").value;
        const bikeid = document.getElementById("bikeidr").value;
        
        if (isNaN(idno) || isNaN(bikeid))  {
        alert('Please check your ID number or bikeid!');
        return false;
             }

        if (idno === "" || bikeid === "") {
            alert("Please fill in all required fields.");
            return false;
        }     

        return true;

        
    }
    const statusSelect = document.getElementById('status');
    const borrowDiv = document.getElementById('borrow');
    const returnDiv = document.getElementById('return');
    returnDiv.style.display = 'none';
    
    statusSelect.addEventListener('change', function() {
        const selectedOption = statusSelect.value;
        if (selectedOption === 'borrow') {
            borrowDiv.style.display = 'block';
            returnDiv.style.display = 'none';
        } else if (selectedOption === 'return') {
            borrowDiv.style.display = 'none';
            returnDiv.style.display = 'block';
        }
    });
    function gohome(){
        window.location.href="help.php";
    }
</script>

</html>