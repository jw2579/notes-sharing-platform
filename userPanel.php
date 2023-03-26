<?php
    session_start();
    if ($_SESSION['admin'] != 2) {
        header("Location: ./login.php");
    }
    include_once('db.php');

    // user data arrays
    $userIDs = array();
    $userNames = array();
    $userEmails = array();

    $id = @$_GET['id'];
    if (isset($id)) {
        $result = $conn->query("delete from user where id='$id'");
    }
    
    $result = $conn->query("SELECT * FROM user");
    while($row=mysqli_fetch_assoc($result))//将result结果集中查询结果取出一条
    {
        array_push($userIDs,$row["id"]);
        array_push($userNames,$row["name"]);
        array_push($userEmails, $row["email"]);

    }

    // encode to json format for js
    $userIDs = json_encode($userIDs);
    $userNames = json_encode($userNames);
    $userEmails = json_encode($userEmails);

    

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Summarize</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa fa-file-text"></i>
                </div>
                <div class="sidebar-brand-text mx-3">X-uni <sup>v3</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="./userPanel.php">
                    <i class="fa fa-address-card"></i>
                    <span>User Panel</span></a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="./articlePanel.php">
                    <i class="fa fa-file-text"></i>
                    <span>Article Panel</span></a>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="col-6">
                        <!-- !!!!!!!!!!!!!!! -->
                        <h5 class="m-0 font-weight-bold text-primary">Welcome back, Manager</h5>
                    </div>
                    
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['name'];?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <?php if(isset($_SESSION['admin'])) :?>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </div>
                            <?php endif;?>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading
                    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
                    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> -->

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">User Control Panel</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Manipulation</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Manipulation</th>
                                        </tr>
                                    </tfoot>

                                    <!-- !Need Backend! Tbody stores the content of each user information-->
                                    <tbody id = "userSheet">
                                        <!-- One example of user data-->
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="./out.php">Logout</a>
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

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <script type="text/javascript">
        var userIDs = <?php echo $userIDs; ?>;
        var userNames = <?php echo $userNames; ?>;
        var userEmails = <?php echo $userEmails; ?>;

        // 
        userSheet = document.getElementById("userSheet");

        for (var i = 0; i < userIDs.length; i++) {
            // Initial tr
            var tr = document.createElement("tr");

            // td appends
            var newUserID = document.createElement("td"); 
            newUserID.innerText = String(userIDs[i]);
            tr.appendChild(newUserID);

            var newUsername = document.createElement("td");
            newUsername.innerText = String(userNames[i]);
            tr.appendChild(newUsername);

            var newEmail = document.createElement("td");
            newEmail.innerText = String(userEmails[i]);
            tr.appendChild(newEmail);

            var newBlock = document.createElement("td");
            tr.appendChild(newBlock);

            var newButton = document.createElement("a");
            newButton.setAttribute("class", "btn btn-google btn-block");
            newButton.id = String(userIDs[i]);
            newButton.onclick = function() {
                window.location = "./userPanel.php?id="+this.id;
            }

            var trashIcon = document.createElement("i");
            trashIcon.setAttribute("class", "fa fa-bitbucket");
            newButton.appendChild(trashIcon);
            
            var ss = document.createElement("span");
            newButton.appendChild(ss);
            
            ss.innerText = " Delete";
            tr.appendChild(newButton);
            newBlock.appendChild(newButton);

            userSheet.appendChild(tr);
            
        }
        
        console.log("Iteratively output finished");
    </script>
</body>

</html>