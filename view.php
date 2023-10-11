<?php
session_start();

if(!isset($_GET['viewId'])){
	header("Location:main");
}
else{
	$viewId = $_GET['viewId'];
	include('database.php');
    date_default_timezone_set('Asia/Colombo');
    $fromdate = date("Y-m-d");
    $fromdate = strtotime("{$fromdate}");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--<link rel="icon" href="https://th.bing.com/th/id/R.c70638d537870aec2fdae3699a22c1df?rik=N76Nn3vS2F3PeQ&riu=http%3a%2f%2fwww.lanmds.com%2fwp-content%2fuploads%2f2016%2f03%2fPress-Release-image-1.jpg&ehk=Vq46veuwxCiHGJYg%2fg3qHHgR%2f%2b%2fDyENwzMaKaydjS0o%3d&risl=&pid=ImgRaw&r=0">
-->
	<title>Reminder</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="fontawasome.css">

    <!-- custom css file link  -->
	
	<link href="assets/css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <noscript>
      <style type='text/css'>
        [data-aos] {
            opacity: 1 !important;
            transform: translate(0) scale(1) !important;
        }
      </style>
    </noscript>
    <style>
    
	.home {margin-top:-70px}
	.header-1 img{width:30%;}
	table{width:100%;border:1px solid #ccc;}
	th{border-right:1px solid #ccc;}
	th,td{padding:1%;font-size:15px;border-bottom:1px solid #ccc;text-align:left;}
	a{text-decoration:none;color:#fe2121;}
	.copyright{position:fixed;bottom:0px;right:5px;padding:00%;z-index: -2;}
  @media (max-width: 739px) {
	.header-1 img{width:80%;}
  } 
    </style>
</head>
<body id = 'invoice'>
<script src="sweetalert.min.js"></script>

<!-- header section starts  -->

<header>

    <div class="header-1">
    <button title = 'Back' class = 'back_btn' style = 'position:fixed;left:30px;color:#fe2121;font-size:20px;' onclick="window.history.back()">
		<b>&#10611;</b></button>
	<center><a href="#" class="logo" style = 'color:#fe2121;'>
        <img src = 'logo1.png'></a></center>
    </div>

    

</header>


<!-- Pickup section starts  -->

<section class="contact"></section>
<center><button class='btn btn-light text-dark shadow-sm mt-1 me-1' id='download' target='_blank'  style = 'background:#f00;color:#fff;'><font style = 'color:#fff;'>Download Report</font></button></center>
<section class="contact">
	<form style = 'background:#fff;'>
		<table >
			<?php
				$sql = "SELECT * FROM register where id = {$viewId}";
				$result = $conn->query($sql);
				if ($result->num_rows > 0){
					while($row = $result->fetch_assoc()){
						$id = $row['id'];
						$title = $row['title'];
						$description = $row['description'];
						$status = $row['status'];
						$category = $row['category'];
						$edate = $row['edate'];
						$sdate = $row['sdate'];
						$todate = strtotime("{$edate}");
                        $diff_days = $todate - $fromdate;
			            $different = floor($diff_days/(60*60*24));
			            if($different < 0){
			                $status = "<b><font style = 'color:#f00;'>Expired</font></b>";
			                $remainingStates = $status;
			            }
						else{
							$status = "<b><font style = 'color:#0f0;'>Renewed</font></b>";
							$todate = strtotime("{$edate}");
                            $diff_days = $todate - $fromdate;
			                $different = floor($diff_days/(60*60*24));
                            $remainingStates = $different . " Days Remaining";
                            $action = "<a href = 'processing?correctionId={$id}'><i class='fa fa-check' aria-hidden='true'></i> Correct</a>";
						}
						echo "<tr><th>Title</th><td>{$title}</td></tr>
                        <tr><th>Description</th><td>{$description}</td><tr>
                        <tr><th>Category</th><td>{$category}</td><tr>
                        <tr><th>Status</th><td>{$status}</td></tr>
                        <tr><th>Start Date</th><td>{$sdate}</td></tr>
                        <tr><th>End Date</th><td>{$edate}</td></tr>
                        <tr><th>Date Remaining to Expire</th><td>{$remainingStates}</td></tr>
                        ";

					}
				}
			?>
		</table>
    </form>
	
</section>
<div class="copyright"><img src = 'back.png' width = '300'></div>
<!-- Pickup section ends -->
<br><br>
<!-- custom js file link  -->
<script src="script.js"></script>
<script>
    window.onload = function () {
            document.getElementById("download")
            .addEventListener("click", () => {
                document.getElementById("download").style.display='none';
                const invoice = this.document.getElementById("invoice");
                console.log(invoice);
                console.log(window);
                var opt = {
                    margin: 0.2,
                    filename: 'Report.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2 },
                    jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
                };
                html2pdf().from(invoice).set(opt).save();
            })
        }
</script>
</body>
</html>