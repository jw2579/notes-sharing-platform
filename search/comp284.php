<?php
    session_start();
    if (!isset($_SESSION['name'])) {
        $_SESSION['name']="Please login first";
    }
    
    if ($_SESSION['admin']==2) {
        header("location: ./userPanel.php");
    }
    
    $user_name =  $_SESSION['name'];
    include_once('../db.php');
    $arr = array();
    $brr = array();
    $weight_arr = array();
    $ud_dname = array();
    
    $document_uploader = array();

    $re_message = $conn->query("SELECT message FROM user WHERE `name` = '$user_name' ");
    $user_message = mysqli_fetch_assoc($re_message)["message"];
    $re_alert = $conn->query("SELECT alert FROM user WHERE `name` = '$user_name' ");
    $user_alert = mysqli_fetch_assoc($re_alert)["alert"];
    
    $result = $conn->query("SELECT * FROM document WHERE `type` = 'Networks' ORDER BY weight DESC");
    while($row=mysqli_fetch_assoc($result))//将result结果集中查询结果取出一条
    {
        array_push($arr,$row["name"]);
        array_push($brr,$row["abstract"]);
        array_push($weight_arr,$row["weight"]);
        array_push($document_uploader, $row["upload_user"]);
    
    }
    $re_ud = $conn->query("SELECT * from (select name from document where type = 'Networks') d left JOIN (select dname from updown where uname = '$user_name') upd on d.name = upd.dname");
    while($row_ud=mysqli_fetch_assoc($re_ud))//将result结果集中查询结果取出一条
    {
        $ud_dname[$row_ud["name"]] = $row_ud["dname"];
    
    }
    $arr = json_encode($arr);
    $brr = json_encode($brr);
    $weight_arr = json_encode($weight_arr);
    $ud_dname = json_encode($ud_dname);
    $user_name = json_encode($user_name);
    $document_uploader = json_encode($document_uploader);
    
    $filename = @$_GET['filename'];
    if (isset($filename)) {
        ob_clean(); // readable
        $file1 = '../cloud/'.$filename;
        header('Pragma: public');   // required
        header('Expires: 0');       // no cache
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private',false);
        header('Content-Type:application/force-download');
        header('Content-Disposition: attachment; filename="'.basename($file1).'"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: '.filesize($file1));    // provide file size
        header('Connection: close');
        readfile($file1); 
        exit();
    } 
    
    if (@$_GET['center']=='manual.pdf') {
        ob_clean(); // readable
        $file1 = '../manual.pdf';
        header('Pragma: public');   // required
        header('Expires: 0');       // no cache
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private',false);
        header('Content-Type:application/force-download');
        header('Content-Disposition: attachment; filename="'.basename($file1).'"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: '.filesize($file1));    // provide file size
        header('Connection: close');
        readfile($file1); 
        exit();
    } 
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Networks</title>
    <link rel="shortcut  icon" href="../img/logo.ico" type="image/x-icon" />

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
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
<?php if(isset($_SESSION['admin'])) :?>
    <script type="text/javascript">
        window.onload = function(){
            var k=document.getElementById('kk');
            var f=document.getElementById('ff');
            k.onclick=function() {
                f.submit();
            }
        }
    </script>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../main.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa fa-file-text"></i>
                </div>
                <div class="sidebar-brand-text mx-3">X-uni <sup>v3</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="../background.php">
                    <i class="	fa fa-chain"></i>
                    <span>Background</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Start
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                    aria-controls="collapseTwo">
                    <i class="fa fa-globe"></i>
                    <span>Search</span>
                </a>
                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Select field</h6>
                        <a class="collapse-item" href="comp207.php">Database</a>
                        <a class="collapse-item" href="comp219.php">Machine Learning</a>
                        <a class="collapse-item" href="comp222.php">Game Theory</a>
                        <a class="collapse-item" href="comp202.php">Algorithms</a>
                        <a class="collapse-item active" href="comp284.php">Networks</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="../upload/summarize.php">
                    <i class="fa fa-file-word-o"></i>
                    <span>Summarize</span></a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="../upload/upload.php">
                    <i class="bi bi-upload"></i>
                    <span>Upload</span></a>
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

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2" id = search_for>
                      <div class="input-group-append">
                          <button class="btn btn-primary" type="button" onclick="searchFor()">
                              <i class="fas fa-search fa-sm"></i>
                          </button>
                      </div>
                  </div>

                  <script>
                    function searchFor(){
                      var sf = document.getElementById("search_for");
                      switch(sf.value){
                        case "Machine Learning":
                          window.location.href="comp219.php";
                          break;
                        case "Database":
                          window.location.href="comp207.php";
                          break;
                        case "Game Theory":
                          window.location.href="comp222.php";
                          break;
                        case "Algorithms":
                          window.location.href="comp202.php";
                          break;
                        case "Networks":
                          window.location.href="comp284.php";
                          break;
                      }
                    }
                  </script>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2" id = search_for_xs>
                                  <div class="input-group-append">
                                      <button class="btn btn-primary" type="button" onclick = "searchFor_xs()">
                                          <i class="fas fa-search fa-sm"></i>
                                      </button>
                                  </div>
                              </div>
                              <script>
                                function searchFor_xs(){
                                  var sf = document.getElementById("search_for_xs");
                                  switch(sf.value){
                                    case "Machine Learning":
                                      window.location.href="comp219.php";
                                      break;
                                    case "Database":
                                      window.location.href="comp207.php";
                                      break;
                                    case "Game Theory":
                                      window.location.href="comp222.php";
                                      break;
                                    case "Algorithms":
                                      window.location.href="comp202.php";
                                      break;
                                    case "Networks":
                                      window.location.href="comp284.php";
                                      break;
                                  }
                                }
                              </script> 
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter" id = "newAlerts"><?php echo $user_alert?></span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="alertsDropdown" id = "dropDownAlerts">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="uncheckedAlert.php">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">Click Here</div>
                                        <span class="font-weight-bold">Check your new like!</span>
                                    </div>
                                </a>
                            </div>

                            <script>
                                if(<?php echo $user_alert?> == 0){
                                    document.getElementById("newAlerts").style.display = "none"; 
                                }
                            </script>
                        </li>

                        <!-- Nav Item - Messages -->
                      <li class="nav-item dropdown no-arrow mx-1">
                          <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick = "toNone()">
                              <i class="fas fa-envelope fa-fw"></i>
                              <!-- Counter - Messages -->
                              <span class="badge badge-danger badge-counter" id = "newMessages"><?php echo $user_message?></span>
                          </a>
                          <!-- Dropdown - Messages -->
                          <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="messagesDropdown">
                                    <h6 class="dropdown-header">
                                        Message Center
                                    </h6>
                                    <a class="dropdown-item d-flex align-items-center" href="./comp284.php?center=manual.pdf">
                                        <div class="dropdown-list-image mr-3">
                                            <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                                alt="">
                                            <div class="status-indicator bg-success"></div>
                                        </div>
                                        <div class="font-weight-bold">
                                            <div class="text-truncate">User Manual</div>
                                            <div class="small text-gray-500">Click here to download </div>
                                        </div>

                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="../background.php">
                                        <div class="dropdown-list-image mr-3">
                                            <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                                alt="">
                                            <div class="status-indicator"></div>
                                        </div>
                                        <div>
                                            <div class="text-truncate">See what we have done</div>
                                            <div class="small text-gray-500">Click here to check</div>
                                        </div>
                                    </a>
                              </div>
                            <script>
                                if(<?php echo $user_message?> == 0){
                                    document.getElementById("newMessages").style.display = "none"; 
                                }
                                function toNone(){
                                    var user_name = <?php echo $user_name; ?>;
                                    var jsonUsername = JSON.stringify(user_name);
                                    $.ajax({
                                    type:"POST",
                                    url:"mesAle.php",
                                    dataType:"json",
                                    async:false,
                                    data:{'jsonResMes': jsonUsername},
                                    success:function(json){}
                                    });
                                    document.getElementById("newMessages").style.display = "none"; 
                                }
                            </script>                              
                           
                      </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

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
                                    <a class="dropdown-item" href="../profile.php">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Profile
                                    </a>
                                    <div class="dropdown-divider"></div>
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

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Networks</h1>
                    </div>

                    <div class="row" id = "main_list">

                            <!-- Basic Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Learning Outcome</h6>
                                </div>
                                <div class="card-body">
                                    <h6>After learning this module, you can understand the basic theoretical principles of computer communications networks; understand how the notion of layering and abstraction apply to the design of computer communication networks; understand the organisation of the Internet, and how this organisation relates to the OSI seven layer model.</h6> 
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
                        <span>Copyright &copy; Xuni 2021</span>
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
        aria-hidden="false">
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
                    <a class="btn btn-primary" href="../out.php">Logout</a>
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

    <script type="text/javascript">
        
    window.onload = addElement();

    function insertAfter(newNode, existingNode) {
        existingNode.parentNode.insertBefore(newNode, existingNode.nextSibling);
    }
    function addElement(){
        // 新建一个二维数组 遍历 然后把数据库中每一个attribute的值  传递到docData中
        var vote_count = new Array();//限制每次按钮只可以单击一次
        var file_weight = new Array();
        var file_name = new Array();
        var document_update_user = new Array();
        var docData={};
        
        var arr=<?php echo $arr; ?>;
        var brr=<?php echo $brr; ?>;
        var weight_arr=<?php echo $weight_arr; ?>;
        var ud_dname = <?php echo $ud_dname; ?>;
        var user_name = <?php echo $user_name; ?>;
        var document_uploader = <?php echo $document_uploader; ?>;

        for (var i = 0; i < arr.length; i++){
            docData.name=arr[i];
            docData.abstract=brr[i];
            var cardId = i.toString();
            // 1st layer
            const newDiv = document.createElement("div");
            newDiv.setAttribute("class", "card shadow mb-4");
            newDiv.setAttribute("id", cardId);

            // 2nd layer
            const newCardDiv = document.createElement("div");
            newCardDiv.setAttribute("class", "card-header py-3");

            // 3rd layer: title
            const newCardTitle = document.createElement("h4");
            newCardTitle.innerHTML = docData.name;
            newCardTitle.setAttribute("class", "card-title");
            
            // 3rd layer: abstract
            const newCardContent = document.createElement("p");
            newCardContent.setAttribute("class", "card-text");
            newCardContent.innerText = docData.abstract;

            // 3rd layer: Download
            const newCardDownload = document.createElement("a");
            newCardDownload.setAttribute("class", "col-xl-2 col-md-4 mb-3 btn btn-google btn-block");
            newCardDownload.innerText = "Download    "; 
            newCardDownload.id=arr[i].toString();
            newCardDownload.onclick = function(){
                window.location = "./comp284.php?filename="+newCardDownload.id;
            }


            // 4rd layer: inside Download
            const newDownloadLogo = document.createElement("i");
            newDownloadLogo.setAttribute("class", "fa fa-cloud-download fa-fw");
            newCardDownload.appendChild(newDownloadLogo);

            // 3rd layer
            const newCardVote = document.createElement("a");
            // newCardVote.type = "button";
            var filename = String(arr[i]);
            newCardVote.id = "vbtn" + String(i);
            file_weight[newCardVote.id] = weight_arr[i];
            //store each filename in array so it can be access by onclick
            file_name[newCardVote.id] = filename;
            document_update_user[newCardVote.id] = document_uploader[i];

            newCardVote.setAttribute("class", "col-xl-2 col-md-4 mb-3 btn btn-google btn-block");
            newCardVote.innerText = "Like(" + file_weight[newCardVote.id] + ")      ";   
            newCardVote.style.marginTop = 0;
            newCardVote.style.marginLeft = "1%";


            if(ud_dname[file_name[newCardVote.id]] != null){

                newCardVote.style.background="green";
                newCardVote.innerText = "Cancel      ";            
                vote_count[newCardVote.id] = 1;
                // newCardVote.style.marginTop = 0;
                // newCardVote.style.marginLeft = "5px";
            }else{
                //the button is now red
                //this means that the user did not up this document
                vote_count[newCardVote.id] = 2;
            }

            newCardVote.onclick = function(){
                if(vote_count[newCardVote.id] ==  2){
                    if(ud_dname[file_name[newCardVote.id]] == null){
                        newCardVote.style.background="green";
                        newCardVote.innerText = "Cancel    ";
                        //now the database has added 1
                        var jsonFilename = JSON.stringify(file_name[newCardVote.id]);
                        var jsonUsername = JSON.stringify(user_name);
                        $.ajax({
                        type:"POST",
                        url:"weight.php",
                        dataType:"json",
                        async:false,
                        data:{'jsonResFile':jsonFilename, 'jsonResUser': jsonUsername},
                        success:function(json){}
                        });
                        ud_dname[file_name[newCardVote.id]] = file_name[newCardVote.id];
                        
                        const newUpDown = document.createElement("i");
                        newUpDown.setAttribute("class", "fa fa-thumbs-down fa-fw");
                        newCardVote.appendChild(newUpDown);
                        
                        //increase alert due to up
                        var jsonUploader = JSON.stringify(document_update_user[newCardVote.id]);
                        $.ajax({
                        type:"POST",
                        url:"mesAle.php",
                        dataType:"json",
                        async:false,
                        data:{'jsonResUp': jsonUploader},
                        success:function(json){}
                        }); 
                        
                    }else{
                        //cancel like, like turn to original value
                        newCardVote.style.background="#e74a3b";
                        newCardVote.innerText = "Like(" + file_weight[newCardVote.id] + ")    ";  
                        var jsonFileCancel = JSON.stringify(file_name[newCardVote.id]);
                        var jsonUserCancel = JSON.stringify(user_name);
                        $.ajax({
                        type:"POST",
                        url:"weight.php",
                        dataType:"json",
                        async:false,
                        data:{'jsonResFileCan':jsonFileCancel, 'jsonResUserCan': jsonUserCancel},
                        success:function(json){}
                        });
                        ud_dname[file_name[newCardVote.id]] = null;
                        
                        const newUpDown = document.createElement("i");
                        newUpDown.setAttribute("class", "fa fa-thumbs-up fa-fw");
                        newCardVote.appendChild(newUpDown);
                        
                        //decrease alert due to down
                        var jsonUploader = JSON.stringify(document_update_user[newCardVote.id]);
                        $.ajax({
                        type:"POST",
                        url:"mesAle.php",
                        dataType:"json",
                        async:false,
                        data:{'jsonResDown': jsonUploader},
                        success:function(json){}
                        });  
                    
                    }
                }else if(vote_count[newCardVote.id] ==  1){
                    //liked before
                    if(ud_dname[file_name[newCardVote.id]] == null){
                        //turn to green, like now
                        newCardVote.style.background="green";
                        newCardVote.innerText = "Cancel      ";
                        var jsonFilename = JSON.stringify(file_name[newCardVote.id]);
                        var jsonUsername = JSON.stringify(user_name);
                        $.ajax({
                        type:"POST",
                        url:"weight.php",
                        dataType:"json",
                        async:false,
                        data:{'jsonResFile':jsonFilename, 'jsonResUser': jsonUsername},
                        success:function(json){}
                        });
                        ud_dname[file_name[newCardVote.id]] = file_name[newCardVote.id];
                        
                        const newUpDown = document.createElement("i");
                        newUpDown.setAttribute("class", "fa fa-thumbs-down fa-fw");
                        newCardVote.appendChild(newUpDown);
                        
                        var jsonUploader = JSON.stringify(document_update_user[newCardVote.id]);
                        $.ajax({
                        type:"POST",
                        url:"mesAle.php",
                        dataType:"json",
                        async:false,
                        data:{'jsonResUp': jsonUploader},
                        success:function(json){}
                        });                         
                        
                    }else{
                        //cancel like, turn to red
                        newCardVote.style.background="#e74a3b";
                        newCardVote.innerText = "Like(" + (parseInt(file_weight[newCardVote.id]) - 1) + ") ";  
                        var jsonFileCancel = JSON.stringify(file_name[newCardVote.id]);
                        var jsonUserCancel = JSON.stringify(user_name);
                        $.ajax({
                        type:"POST",
                        url:"weight.php",
                        dataType:"json",
                        async:false,
                        data:{'jsonResFileCan':jsonFileCancel, 'jsonResUserCan': jsonUserCancel},
                        success:function(json){}
                        });
                        ud_dname[file_name[newCardVote.id]] = null;
                        
                        const newUpDown = document.createElement("i");
                        newUpDown.setAttribute("class", "fa fa-thumbs-up fa-fw");
                        newCardVote.appendChild(newUpDown);
                        
                        //decrease alert due to down
                        var jsonUploader = JSON.stringify(document_update_user[newCardVote.id]);
                        $.ajax({
                        type:"POST",
                        url:"mesAle.php",
                        dataType:"json",
                        async:false,
                        data:{'jsonResDown': jsonUploader},
                        success:function(json){}
                        });                          
                    
                    }
                }

            }
 

            // 4rd layer: inside updown
            if (vote_count[newCardVote.id] == 1) {
                const newUpDown = document.createElement("i");
                newUpDown.setAttribute("class", "fa fa-thumbs-down fa-fw");
                newCardVote.appendChild(newUpDown);
            } else {
                const newUpDown = document.createElement("i");
                newUpDown.setAttribute("class", "fa fa-thumbs-up fa-fw");
                newCardVote.appendChild(newUpDown);
            }
            
            const newCardButton = document.createElement("div");
            newCardButton.setAttribute("class", "row");
            
            const newSpan = document.createElement("span");
            newSpan.innerText="ss";
            newSpan.style.opacity = 0;
            
            // appends
            newDiv.appendChild(newCardDiv);
            newCardDiv.appendChild(newCardTitle);
            newCardDiv.appendChild(newCardContent); 
            newCardDiv.appendChild(newCardButton);
            newCardButton.appendChild(newSpan);
            newCardButton.appendChild(newCardDownload);
            newCardButton.appendChild(newCardVote);
            
            var currentDiv;
            if(i == 0){
                currentDiv = document.getElementById("main_list");
            }else{
                currentDiv = document.getElementById((i-1).toString());
            }
            // var currentDiv = document.getElementById("doc_head");
            // console.log(currentDiv);
            insertAfter(newDiv, currentDiv);
        
        }
    }
    </script>
<?php else :?>
      <?php header('location: ../login.php'); ?>
<?php endif;?>
</body>

</html>