<?php
session_start();
?>
<?php
include('database.php');
date_default_timezone_set('Asia/Colombo');
    $fromdate = date("Y-m-d");
    $fromdate = strtotime("{$fromdate}");
if(isset($_SESSION['remadminlogin'])){
    $sql = "SELECT * FROM adminlogin";
				$result = $conn->query($sql);
				if ($result->num_rows > 0){
                    $dlist = "";
					while($row = $result->fetch_assoc()){
						$id = $row['id'];
						$name = $row['name'];
						$email = $row['email'];
						$epf = $row['epf'];
						$jobstatus = $row['jobstatus'];
						$status = $row['status'];
						$delstatus = $row['delstatus'];
                        if($status == 0){
                            $status = "User";
                        }
                        else{
                            $status = "Admin";
                        }
                        if($delstatus == 0){
                            $btn = "<a href = ''><a href = 'processing?removeUser={$id}'><i class='fas fa-fw fa-trash'></i> Inactive</a>";
                        }
                        else{
                            $btn = "<a href = ''><a href = 'processing?reactiveUser={$id}' style = 'color:#fe0000;'><i class='fas fa-fw fa-reply-all'></i> Re active</a>";
                        }
                        $dlist .= "<tr><td>{$name}</td>
                        <td>{$epf}</td>
                        <td>{$email}</td>
                        <td>{$status}</td>
                        <td>{$btn}</td>
                        </tr>";
					}
				}
                else{
                    $dlist = "No Employee Found";
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

    <title>Users</title>

    <!-- Custom fonts for this template -->
    <link href="admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="admin/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-fw fa-users"></i> Users <a href= "add_user" class = "btn btn-primary" style = "background:#fe0000;border:none;">Add New</a></h1>
                    
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>EPF</th>
                                            <th>Email </th>
                                            <th>Status</th>
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
<?php
    if(isset($_SESSION['sussessRemuser'])){
    $txt = 'Successfully Remove the User.';
    echo "<script>
        swal({
        title: 'Successfully',
            text: '$txt',
            icon: 'success',
        });
    </script>";
    unset($_SESSION['sussessRemuser']);
}

if(isset($_SESSION['sussessReactive'])){
    $txt = 'Successfully Re Active the User.';
    echo "<script>
        swal({
        title: 'Successfully',
            text: '$txt',
            icon: 'success',
        });
    </script>";
    unset($_SESSION['sussessReactive']);
}

?>

</body>

</html>