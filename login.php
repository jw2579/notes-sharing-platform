<?php
    session_start();
    $flag = 0;
    if (@$_GET['fail']=='true'){
        $flag = 1;
    }
    $flag = json_encode($flag);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">

</head>

<body class="bg-gradient-primary">

    <?php if(isset($_SESSION['admin'])) :?>
        <?php header('location: main.php'); ?>
    <?php else :?>

        <script type="text/javascript">
            window.onload = function() {
                var emailElt = document.getElementById("email");
                var pwdElt = document.getElementById("pwd");
                var errorElt = document.getElementById("error");
                var flag = <?php echo $flag;?>;
                
                if(flag == "1"){
                    errorElt.innerText = "Wrong Email Address or Password";
                }

                emailElt.onblur = function(){
                    var email = emailElt.value;
                    if (email === "") {
                        errorElt.innerText = "Email Address cannot be empty";
                    } 
                }

                pwdElt.onblur = function(){
                    var pwd = pwdElt.value;
                    if (pwd === "") {
                        errorElt.innerText = "Password cannot be empty";
                    } 
                }

                emailElt.onfocus = function() {
                    if (errorElt.innerText == "Email Address cannot be empty") {
                        errorElt.innerText = "";
                    }
                }

                pwdElt.onfocus = function() {
                    if (errorElt.innerText == "Password cannot be empty") {
                        errorElt.innerText = "";
                    }
                }

                var submitElt = document.getElementById("submitt");
                submitElt.onclick = function() {

                    pwdElt.focus();
                    pwdElt.blur();
                    emailElt.focus();
                    emailElt.blur();

                    if (errorElt.innerText=="" || errorElt.innerText == "Wrong Email Address or Password") {
                        var formElt = document.getElementById("form");
                        formElt.submit();
                    } 
                }
            }
        </script>

        <div class="container">

            <!-- Outer Row -->
            <div class="row justify-content-center">

                <div class="col-xl-10 col-lg-12 col-md-9">

                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block" >
                                    <img src = "https://i.imgur.com/udm9COQ.png" style = "object-fit: fill; overflow: hidden; width: 465px; height: 508px" ></img>
                                </div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                        </div>
                                        <form class="user" method="post" action="logincheck.php" id="form">
                                            <div class="form-group">
                                                <!-- email -->
                                                <input type="text" class="form-control form-control-user"
                                                    id="email" placeholder="Enter Email Address..." name="email">
                                            </div>
                                            <div class="form-group">
                                                <!-- pwd -->
                                                <input type="password" class="form-control form-control-user"
                                                    id="pwd" placeholder="Password" name="pwd">
                                            </div>
                                            
                                            <span class="col-sm-6" id="error"></span>
                                            <!-- login -->
                                            <input type="button" class="btn btn-primary btn-user btn-block" value="Login" id="submitt" />
                                            <br>
                                            <a href="./upload/summarize.php" class="btn btn-google btn-user btn-block">
                                                <i class="bi bi-cloud-upload-fill"></i>
                                                <span style = "opacity: 0">. </span>
                                                  Start Summarize
                                            </a>
                                        </form>
                                        <br>
                                        <div class="text-center">
                                            <!-- forgot -->
                                            <a class="small" href="forgot.php" >Forgot Password?</a>
                                        </div>
                                        <div class="text-center">
                                            <!-- register -->
                                            <a class="small" href="register.php">Create an Account!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>
    
    <?php endif;?>

</body>

</html>