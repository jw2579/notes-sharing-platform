<?php
    session_start();

    if ($_POST['email']!="") {
        include_once('db.php');

        $email = $_POST['email'];
        $name = $_POST['name1'].' '.$_POST['name2'];
        $pwd = $_POST['pwd'];

        $res = "User added failed";
        $q = "reason: you are beautiful";
        $check = $conn->query("SELECT * FROM user WHERE name = '$name'");
        if (mysqli_num_rows($check)>0) {
            $q="reason: exist";
        } else {
            $result = $conn->query("insert into user (email,name,pwd) values ('$email','$name','$pwd')");
            if ($result) {
                $res = "User added successfully";
                $_SESSION['admin']=1;
                $_SESSION['name']=$name;
                $_SESSION['pwd']=$pwd;
            }
        }
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
                // 以下方式定时跳转
                // setTimeout("javascript:location.href='main.php'", 2500); 
                window.location.href='main.php';  
        </script>
    <?php else :?>
        <?php header('location: register.php?fail=true'); ?>
    <?php endif;?>
</body>
</html>