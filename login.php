<?php
require 'phpserver.php';
session_start();
// if (isset($_SESSION['user'])) {
//     header('location:login.php');
// }
$loggedInUser = $_SESSION['user'];
$user_data  = [];

if (isset($loggedInUser) && !empty($loggedInUser)) {
    $id = $loggedInUser['id'];
    echo "<br/>";

    $mysql = "SELECT * FROM `login` WHERE id=$id";
    $select_result = mysqli_query($con, $mysql);
    $user_data = mysqli_fetch_array($select_result);
    header('location:login.php');
    die();
}




$error_msg = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $mysql = "SELECT * FROM `login` WHERE email='$email'";
    $select_result = mysqli_query($con, $mysql);

    $row = mysqli_fetch_row($select_result);


    if (is_array($row) && $row[0] > 0) {
        print_r($row);

        $user_password = md5($password);

        // TODO:
        // password comparsion
        if ($user_password === $row[3]) {
            $error_msg = "";
            echo "You have logged-in successfully...";
            // TODO:
            // sets sessions & redirect to profile/user account section
            // .... code

            $_SESSION['user'] = ['id' => $row[0], 'name' => $row[1], 'email' => $row[2], 'password' => $row[3], 'createdAt' => $row[4]];
            header('location:wellcome.php');
            die();
        } else {
            $error_msg = "You have entered incorrect email/password";
        }
    } else {
        $error_msg = "please Enter correct password";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
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
                    <h1>Login</h1>
                </div><br>

                <?php if ($error_msg !== "") { ?>
                    <div class="alert alert-danger"><?= $error_msg ?></div>
                <?php } ?>

                <label for="">Email:</label>
                <input type="text" name="email" class="form-control">
                <label for="">Password:</label>
                <input type="password" name="password" class="form-control">
                <br><button class="btn btn-success mx-5" name="login">Login</button>


            </div>



        </form>






    </div>
</body>

</html>