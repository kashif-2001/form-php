<?php
require 'phpserver.php';
session_start();
// checking user 
$loggedInUser = $_SESSION['user'];
$user_data  = [];

if (isset($loggedInUser) && !empty($loggedInUser)) {
    $id = $loggedInUser['id'];
    echo "<br/>";

    $mysql = "SELECT * FROM `login` WHERE id=$id";
    $select_result = mysqli_query($con, $mysql);
    $user_data = mysqli_fetch_array($select_result);

    header('location:wellcome.php');
    die();
}

// 

if (isset($_POST['register'])) {
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result_encryp = md5($password);

    $mysql = "INSERT INTO `loginform`.`login`(`Name`, `email`, `password`)
     VALUES ('$username','$email','$result_encryp')";

    $insert_result = mysqli_query($con, $mysql);
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registeration Form</title>
    <!-- css link -->

    <!-- bootstrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <br><br>
    <div class="col-lg-6 m-auto">
        <form action="" method="post">
            <div class="card p-3">
                <div class="text-center bg-dark text-white">
                    <h1>Registeration Form</h1>
                </div><br>
                <label for="">Username:</label>
                <input type="text" name="name" class="form-control">
                <label for="">Email:</label>
                <input type="text" name="email" class="form-control">
                <label for="">Password:</label>
                <input type="password" name="password" class="form-control">
                <br><button class="btn btn-success mx-5" name="register">Register</button>
                <a href="login.php" class="btn btn-primary mx-5 my-2">Login</a>


            </div>



        </form>






    </div>
</body>

</html>