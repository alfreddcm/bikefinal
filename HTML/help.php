<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help and support</title>

  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
      margin: 2;
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    .admin {
      text-align: center;
      margin: 20px;
      width: 250px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .admin:hover {
      transform: translateY(-5px);
    }

    .admin-image {
      width: 200px;
      height: 200px;
      border-radius: 50%;
    }
    .admin-image:hover {
        transform:scale(1.3);
        border:10px solid black;

    }
    .admin-details {
      padding: 20px;
    }

    .admin-name {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .admin-contact {
      font-size: 16px;
      margin-bottom: 5px;
    }

    .admin-email {
      font-size: 14px;
      color: #888;
    }
    .about-us p {
      font-size: 16px;
      color: #888;
    }
  </style>
</head>
<body>
    
<div class="container">
<h1>Help and Support</h1>

  <div class="container">
    <div class="admin">
      <img class="admin-image" src="admin1.jpg" alt="Admin 1 Picture">
      <div class="admin-details">
        <h2 class="admin-name">RYAN ARGONIA</h2>
        <p class="admin-contact">Contact Number: <span>9457296692</span></p>
        <p class="admin-email">Email Address: <span>argoniar6@gmail.com</span></p>
      </div>
    </div>

    <div class="admin">
      <img class="admin-image" src="admin2.jpg" alt="Admin 2 Picture">
      <div class="admin-details">
        <h2 class="admin-name">JAYMAR CHAVEZ</h2>
        <p class="admin-contact">Contact Number: <span>9853088881</span></p>
        <p class="admin-email">Email Address: <span>jaymarchavez666@GMAIL.com</span></p>
      </div>
    </div>

    <div class="admin">
      <img class="admin-image" src="admin3.jpg" alt="Admin 3 Picture">
      <div class="admin-details">
        <h2 class="admin-name">ALFRED MARCELINO</h2>
        <p class="admin-contact">Contact Number: <span>123456789</span></p>
        <p class="admin-email">Email Address: <span>alfredmarcelinoii45@gmail.com</span></p>

      </div>
    </div>

    <div class="admin">
      <img class="admin-image" src="admin4.jpg" alt="Admin 4 Picture">
      <div class="admin-details">
        <h2 class="admin-name">RHAIDEL DUMON</h2>
        <p class="admin-contact">Contact Number: <span>9675922314</span></p>
        <p class="admin-email">Email Address: <span>Deldumon23@gmail.com</span></p>       
    </div>
  
  </div>
  <div class="about-us">
    <center>
    <p>We are here to provide you with the best help and support for all your needs. Our team of dedicated admins is ready to assist you with any queries you may have. Feel free to contact any of our admins listed above for assistance.</p>
</div></center>
<div>
    <button onclick="gohome()">Home</button>
</div>

</body>
<style>
    .con{
        margin:auto;
        margin-top:5rem;
        padding:20px;
        border:1px solid black;
        width: 800px;
        height: 400px;
    }
</style>
<script>
       function gohome(){
        window.location.href="index.php";
    }
</script>
</html>