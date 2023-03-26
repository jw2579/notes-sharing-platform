<?php

    session_start();

    include_once('db.php');

    $email = $_POST['email'];
    $name = $_POST['name'];
    $pwd = $_POST['pwd'];

    $q = "login failed";
    $check = $conn->query("SELECT * FROM user WHERE email = '$email' AND name = '$name' ");
    if (mysqli_num_rows($check)>0) {
        $c = $conn->query("UPDATE user SET pwd = '$pwd' WHERE user.email = '$email'");
        $_SESSION['admin']=1;
        $_SESSION['name']=$name;
        $_SESSION['pwd']=$pwd;
        $q="login success";
        echo $_SESSION['admin'];
    } 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>registercheck</title>
</head>
<body>
    <?php if(isset($_SESSION['admin'])) :?>
        <script type="text/javascript"> 
            window.location.href='main.php';
        </script>
        
    <?php else :?>
        <!-- ifelse语句加验证失败 -->
        <?php header('location: forgot.php?fail=true'); ?>
    <?php endif;?>

</body>
</html>