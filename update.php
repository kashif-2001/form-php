<?php
session_start();
require 'phpserver.php';

$loggedInuser = $_SESSION['user'];


// $password = $loggedInuser['password'];
// $mysql = "SELECT * FROM `login` WHERE id=$id";
// $select_result = mysqli_query($con, $mysql);
// $user_data = mysqli_fetch_array($select_result);
$succes_msg = "";
if (isset($_POST['submit'])) {
    $id = $loggedInuser['id'];
    $curr_pass = $_POST['current_pass'];
    $new_pass = $_POST['new_pass'];


    $mysql = "SELECT * FROM `login` WHERE id=$id";
    $select_result = mysqli_query($con, $mysql);
    $row = mysqli_fetch_array($select_result);

    if (is_array($row) && $row[0] > 0) {
        $encryp_curr_pass = md5($curr_pass);

        if ($encryp_curr_pass === $row[3]) {
            $new_pass = md5($new_pass);
            $mysql = "UPDATE `login` SET `password`='$new_pass' WHERE id=$id";
            mysqli_query($con, $mysql);
            header("location:wellcome.php?message=update-password");
            die();
        } else {
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
    <title>Update Password</title>
    <!-- botstrip -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body>
    <br>
    <div class="col-lg-6 card m-auto">
        <form action="" method="POST">
            <div class=" p-1 text-center text-white bg-dark">
                <h1>Update Password</h1>
            </div><br>
            <label for="">Current Password:</label><br>
            <input class="form-control" type="password" name="current_pass" id="">
            <br>
            <label for="">New Password:</label><br>
            <input class="form-control" type="password" name="new_pass" id="">
            <br>
            <button class="btn btn-success" name="submit">SUBMIT</button>

        </form>
    </div>
</body>

</html>