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

    <title>Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
    <?php if(isset($_SESSION['admin'])) :?>
        <?php header('location: main.php'); ?>
    <?php else :?>
        <script type="text/javascript">
            window.onload = function() {
                var name1Elt = document.getElementById("name1");
                var name2Elt = document.getElementById("name2");
                var emailElt = document.getElementById("email");
                var pwdElt = document.getElementById("pwd");
                var pwd2Elt = document.getElementById("pwd2");
                var errorElt = document.getElementById("error");
                var flag = <?php echo $flag;?>;
                
                if(flag == "1"){
                    errorElt.innerText = "Same Name exist!";
                }
                name1Elt.onblur = function(){
                    var name1 = name1Elt.value;
                    name1 = name1.trim();
                    name1Elt.value = name1;
                    if (name1 === "") {
                        errorElt.innerText = "First name cannot be empty";
                    } 
                }

                name1Elt.onfocus = function() {
                    if (errorElt.innerText == "First name cannot be empty") {
                        errorElt.innerText = "";
                    }
                }

                name2Elt.onblur = function(){
                    var name2 = name2Elt.value;
                    name2 = name2.trim();
                    name2Elt.value = name2;
                    if (name2 === "") {
                        errorElt.innerText = "Last name cannot be empty";
                    } 
                }

                name2Elt.onfocus = function() {
                    if (errorElt.innerText == "Last name cannot be empty") {
                        errorElt.innerText = "";
                    }
                }

                emailElt.onblur = function() {
                    var emailRegExp = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                    if (!emailRegExp.test(emailElt.value)) {
                        errorElt.innerText = "invalid email address";
                    }
                }

                emailElt.onfocus = function() {
                    if (errorElt.innerText == "invalid email address") {
                        errorElt.innerText = "";
                    }
                }

                pwd2Elt.onblur = function() {
                    var pwd = pwdElt.value;
                    var pwd2 = pwd2Elt.value;
                    if (pwd != pwd2) {
                        errorElt.innerText = "Passwords do not match";
                    }
                }

                pwd2Elt.onfocus = function() {
                    if (errorElt.innerText == "Passwords do not match") {
                        errorElt.innerText = "";
                    }
                }

                var submitElt = document.getElementById("submitt");
                submitElt.onclick = function() {

                    name1Elt.focus();
                    name1Elt.blur();
                    name2Elt.focus();
                    name2Elt.blur();
                    emailElt.focus();
                    emailElt.blur();
                    pwd2Elt.focus();
                    pwd2Elt.blur();

                    if (errorElt.innerText=="") {
                        var formElt = document.getElementById("form");
                        formElt.submit();
                    } 
                }
            }

        </script>
        <div class="container">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                        <div class="col-lg-7">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                </div>
                                <form action ="registercheck.php" class="user" method="post" id="form">
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <!-- name1 -->
                                            <input type="text" class="form-control form-control-user" id="name1"
                                                placeholder="First Name" name="name1">
                                        </div>
                                        <div class="col-sm-6">
                                            <!-- name2 -->
                                            <input type="text" class="form-control form-control-user" id="name2"
                                                placeholder="Last Name" name="name2">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <!-- email -->
                                        <input type="text" class="form-control form-control-user" id="email"
                                            placeholder="Email Address" name="email">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <!-- pwd -->
                                            <input type="password" class="form-control form-control-user"
                                                id="pwd" placeholder="Password" name="pwd">
                                        </div>
                                        <div class="col-sm-6">
                                            <!-- pwd2 -->
                                            <input type="password" class="form-control form-control-user"
                                                id="pwd2" placeholder="Repeat Password">
                                        </div>
                                    </div>


                                    <span class="col-sm-6" id="error"></span>


                                    <!-- submitt -->
                                    <input type="button" class="btn btn-primary btn-user btn-block" value="Register Account" id="submitt" />
                                    <hr>
                                    <!-- summarize -->
                                    <a href="./upload/summarize.php" class="btn btn-google btn-user btn-block">
                                        <i class="fab fa-google fa-fw"></i> Start Summarize
                                    </a>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <!-- forgot -->
                                    <a class="small" href="forgot.php">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <!-- login -->
                                    <a class="small" href="login.php">Already have an account? Login!</a>
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
    <?php endif; ?>

</body>

</html>