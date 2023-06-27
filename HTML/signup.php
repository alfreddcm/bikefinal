<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idno = $_POST['idno'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $depname = $_POST['depname'];
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];

    $uppercase = preg_match('@[A-Z]@', $pass);
    $lowercase = preg_match('@[a-z]@', $pass);
    $number = preg_match('@[0-9]@', $pass);
    $specialChars = preg_match('@[^\w]@', $pass);

    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($pass) < 8) {
        echo "<script>alert('Password should be at least 8 characters in length and should include at least one uppercase letter, one lowercase letter, one number, and one special character.');</script>";
    } else {
        if ($pass != $pass2) {
            echo "<script>alert('Password mismatch!'); </script>";
        } else {
            $sql = "SELECT * FROM admin WHERE idno=?";
            $query = $conn->prepare($sql);
            $query->bind_param("s", $idno);
            $query->execute();
            $query->store_result();

            if ($query->num_rows > 0) {
                echo "<script>alert('ID number is already in use!'); window.location.href='signup.php';</script>";
            } else {
                $sql1 = "INSERT INTO admin (idno, fname, lname, depname, pass) VALUES (?, ?, ?, ?, ?)";
                $query1 = $conn->prepare($sql1);
                $query1->bind_param("sssss", $idno, $fname, $lname, $depname, $pass);
                $query1->execute();
                $query1->store_result();

                echo "<script>alert('Account added! You can now log in.');  window.location.href='login.php';</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>

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
            margin-top: 1.3in;
            margin-left: auto;
            margin-right: auto;
            display: block;
            background-color: white;
            border-radius: 3px;
            box-shadow: 10px 10px 10px;
            padding: 20px;
            width: 400px;
        }

        .container input[type="text"],
        .container input[type="number"],
        .container input[type="password"] {
            font-size: 15px;
            border: none;
            border-bottom: 1px solid black;
            padding: 5px;
            margin-bottom: 10px;
        }
        .cre{
            margin-top:4px;
    color:white;
cursor: pointer;
    text-decoration:none;
    background:transparent;
    border:none;
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Account</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" onsubmit="return confirmSubmit();">
            <table>
                <tr>
                    <td><label for="idno">ID Number:</label></td>
                    <td><input type="number" name="idno" id="idno" required></td>
                </tr>
                <tr>
                    <td><label for="fname">First Name:</label></td>
                    <td><input type="text" name="fname" id="fname" required></td>
                </tr>
                <tr>
                    <td><label for="lname">Last Name:</label></td>
                    <td><input type="text" name="lname" id="lname" required></td>
                </tr>
                <tr>
                    <td><label for="depname">Department Name:</label></td>
                    <td><input type="text" name="depname" id="depname" required></td>
                </tr>
                <tr>
                    <td><label for="pass">Password:</label></td>
                    <td><input type="password" name="pass" id="pass" required></td>
                </tr>
                <tr>
                    <td><label for="pass2">Confirm password:</label></td>
                    <td><input type="password" name="pass2" id="pass2" required></td>
                </tr>
                <tr>
                    <td><input type="checkbox" onclick="show()">Show Password
                </td></tr>

            </table>
            <center><input type="submit" value="Signup" id="submit" class="btnn"></center>
        </form>
        <center><button class="cre" onclick="glogin()">Already have an account?</button> <br>
        <button class="cre" onclick="gohome()">Return home</button></center>

    </div></center>
</body>
</html>

<script>
    function confirmSubmit() {
        return confirm("Are you sure you want to submit the form?");
    }
    function show() {

  var x = document.getElementById("pass");
  var y = document.getElementById("pass2");
  if (x.type === "password" && y.type === "password"){
    x.type = "text";
    y.type = "text";
  } else {
    x.type = "password";
    y.type = "password";

  }
}
function gohome(){
        window.location.href="index.php";
    }
    function glogin(){
        window.location.href="login.php";
    }

</script>
