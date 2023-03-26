<?php

    session_start();

    include_once('db.php');
    $arr = array();
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    $q = "login failed";
    $check = $conn->query("SELECT * FROM user WHERE email = '$email' AND pwd = '$pwd' ");
    if (mysqli_num_rows($check)>0) {
        $n = $conn->query("SELECT * FROM user WHERE email = '$email'");
        while($row=mysqli_fetch_assoc($n))//将result结果集中查询结果取出一条
        {
            $name=$row["name"];
            $admin=$row["admin"];
        }
        $_SESSION['name']=$name;
        $_SESSION['admin']=$admin;
        $_SESSION['email']=$email;
        $_SESSION['pwd']=$pwd;
        $q="login success";
    }

    if ($_SESSION['admin']==2) {
        header("location: ./userPanel.php");
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
        <?php header('location: login.php?fail=true'); ?>
    <?php endif;?>

</body>
</html>