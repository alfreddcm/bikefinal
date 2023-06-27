<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('connection.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $idno=$_POST['idno'];
    $pass=$_POST['pass'];

    $sql = "SELECT * FROM admin WHERE idno= ? ";
    $query = $conn->prepare($sql);
    $query->bind_param("s", $idno);   
    $query->execute();
    $query->store_result();

    if ($query->num_rows > 0) {
        $sql1 = "SELECT * FROM admin WHERE idno= ? and pass = ?";
    $query1= $conn->prepare($sql1);
    $query1->bind_param("ss", $idno, $pass);   
    $query1->execute();
    $query1->store_result();
    
        if($query1->num_rows > 0){
            echo "<script>alert('Logged in! redirecting to dashboard.'); window.location.href='dashboard.php?idno=" . $idno . "';</script>";
        }else{
            echo "<script>alert('Incorrect password. Try again!'); window.location.href='login.php';</script>";
        }

    } else {
        echo "<script>alert('User not found. Please sign up!'); window.location.href='login.php';</script>";
    }

};
?>
<style>
       body{
    display:flex;       
	height: 100%;
    font-family: Poppins-Regular, sans-serif;
    background-image: url("bgimage.png");
    background-repeat: no-repeat;
 background-attachment: fixed;
  background-position: center;
  background-size: 100%;
}
        .container {
            color:white;
            background: linear-gradient(to top, rgba(0,0,0,0.8)50%,rgba(0,0,0,0.8)50%);
            margin-top:1.5in;
            margin-left:auto;
            margin-right:auto;
            display:block;
            background-color: white;
            border-radius:3px;
            box-shadow: 1px 1px 1px 1px;
            padding: 20px;
            width:400px;
            height: 263px;
        }
label, p{
    color:white;
}
        .container input[type="text"],
        .container input[type="number"],
        .container input[type="password"] {
            font-size:15px;
            border: none;
            border-bottom: 1px solid black;
            padding: 5px;
            margin-bottom: 10px;
        }
    .btnn{
    transform: scale(1.4);
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
.btnn:hover{
    background: #fff;
    color: green;
}
.cre{
    color:white;
cursor: pointer;
    text-decoration:none;
    background:transparent;
    border:none;
}
</style>
<script>
     function validateForm() {
        return confirm("Are you sure you want to submit the form?");

        const idno  = document.getElementById("idno").value;
        const fname = document.getElementById("pass").value;

        if (idno === ""  || pass === "") {
            alert("Please fill in all required fields.");
            return false;
        }
        return true;
}
function show() {
  var x = document.getElementById("pass");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login form</title>
</head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <div class="container">
    <h2>Login</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="return validateForm()";>
            <table>
            <tr><td><label for="idno">ID No : </label></td>
                <td><input type="number" name="idno" id="idno" required></td>
            </tr>
            <tr><td><label for="pass">Password: </label></td>
                <td><input type="password" name="pass" id="pass" required></td>
            </tr>
            <tr><td style="color:white; "><input type="checkbox" onclick="show()">Show Password</td></tr>
            </table>
            <center><input type="submit" value="Login" class="btnn" ></center>
    </form>
    <center><button class="cre"onclick="gosignup()">Create new account</button> <br>
    <button class="cre" onclick="gohome()">Return home</button></center>
    
    </div>
</body>
</html>
<script>
    
    
    function gohome(){
        window.location.href="index.php";
    }
    function gosignup(){
        window.location.href="signup.php";
    }

    
</script>
