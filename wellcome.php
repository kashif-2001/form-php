<?php
session_start();
require 'phpserver.php';



// echo '<pre>';
// print_r($_FILES);
// print_r($_SESSION);
// echo '</pre>';

$loggedInUser = $_SESSION['user'];
$user_data  = [];

$op_message = isset($_GET['message']) ? $_GET['message'] : '';

if (isset($loggedInUser) && !empty($loggedInUser)) {
    $id = $loggedInUser['id'];
    $name = $loggedInUser['name'];

    // echo "Welcome $name (ID: $id)";
    echo "<br/>";

    $mysql = "SELECT * FROM `login` WHERE id=$id";
    $select_result = mysqli_query($con, $mysql);
    $user_data = mysqli_fetch_array($select_result);
} else {
    header('location:login.php');
    die();
}

if (isset($_FILES['user_profile'])) {
    // echo "<pre>";
    // print_r($_FILES);
    // echo "</pre>";

    $file_name = $_FILES['user_profile']['name'];
    $file_size = $_FILES['user_profile']['size'];
    $file_tmp = $_FILES['user_profile']['tmp_name'];
    $file_type = $_FILES['user_profile']['type'];
    $target_file = 'uploads/' . basename($file_name);

    if (move_uploaded_file($file_tmp, $target_file)) {
        $mysql = "UPDATE `login` SET `profile_pic`='$file_name' WHERE id=$id";
        $result_update = mysqli_query($con, $mysql);
        header('location:wellcome.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WELLCOME</title>
    <!-- css link -->
    <link rel="stylesheet" href="style.css">
    <!-- bootstrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body>
    <div class="row p-4">
        <div class="col-lg-6 m-auto">
            <form method="POST" enctype="multipart/form-data" class="">
                <div class="card p-2">

                    <?php if ($op_message === 'update-password') { ?>

                        <div class="alert alert-success">Your password has been updated successfully</div>

                    <?php } ?>


                    <img class="img-thumbnail rouonded shadow-sm" src="<?php echo 'uploads/' . $user_data['profile_pic'];  ?>" alt="">

                    <div class="p-3">
                        <h3>About</h3>
                        <h3>Name: <?= $user_data['Name'] ?></h3>
                        <h5>Email: <?= $user_data['email'] ?></h5>
                        <h6>Date of Submition: <br><?= date('d-M-Y', strtotime($user_data['createdAt'])); ?></h6>
                    </div>
                    <input type="file" name="user_profile" required /><br>
                    <button class="btn btn-success" type="submit">Upload profile picture</button>
                    <br>
                    <a href="update.php" class="btn btn-primary">UPDATE</a>
                    <br>
                    <a href='destroy.php' class="btn btn-danger shadow">LOGOUT</a>
                    <br>
                </div>
            </form>
        </div>
        <!-- <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body d-flex justify-content-end">
                    <a href='destroy.php' class="btn btn-danger">LOGOUT</a>
                </div>
            </div>
        </div> -->
    </div>
</body>

</html>