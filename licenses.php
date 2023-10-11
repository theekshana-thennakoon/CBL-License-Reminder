<?php
session_start();
?>
<?php
include('database.php');
date_default_timezone_set('Asia/Colombo');
    $fromdate = date("Y-m-d");
    $fromdate = strtotime("{$fromdate}");
if(isset($_SESSION['remadminlogin'])){
    $sql = "SELECT * FROM register";
				$result = $conn->query($sql);
				if ($result->num_rows > 0){
                    $dlist = "";
					while($row = $result->fetch_assoc()){
						$id = $row['id'];
						$title = $row['title'];
						$status = $row['status'];
						$category = $row['category'];
						$sdate = $row['sdate'];
						$edate = $row['edate'];
						$todate = strtotime("{$edate}");
            			$diff_days = $todate - $fromdate;
            			$different = floor($diff_days/(60*60*24));
            			if ($different < 0){
            			    $status = "<b><font style = 'color:#E62E2D;'>Expired</font></b>";
            			    $action = "<a href = 'processing?correctionId={$id}'><i class='fa fa-check' aria-hidden='true'></i> Correct</a>";
            			}
						else if ($status != 'Corrected'){
							$status = "<b><font style = 'color:#E62E2D;'>Pending</font></b>";
						}
						else{
							$status = "<b><font style = 'color:#0f0;'>Renewed</font></b>";
						}
						$action = " <a href = 'processing?delId={$id}'><i class='fas fa-trash fa-sm' style='color:#E62E2D;size:15px;'></i> Inactive</a>";
						$dlist .= "<tr><td><a href = 'reminderDetails?viewId={$id}' style = 'color:#fe0000;'>{$title}</a></td><td>{$category}</td><td>{$status}</td><td>{$sdate}</td><td>{$edate}</td><td>{$action} </td></tr>";
					}
				}
                else{

                }
}
else{
    header("Location:../login");
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

    <title>Licenses</title>

    <!-- Custom fonts for this template -->
    <link href="../reminderr/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../reminderr/admin/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../reminderr/admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
            include('sidebar.php');
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Topbar -->
            <?php
                include('topbar.php');
            ?>
<!-- End of Topbar -->

            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800"> Licence List</h1>
                    
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <?php echo $dlist;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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

</body>

</html>