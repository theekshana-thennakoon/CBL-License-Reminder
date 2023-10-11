<?php
session_start();
include('database.php');
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
    <link rel="stylesheet" href="wrapstyle.css">
	<!-- custom css file link  -->
	<link href="assets/css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
	.home {margin-top:-70px}
	.header-1 img{width:30%;}
	table{width:100%;border:1px solid #ccc;}
	tr:nth-child(1){border:1px solid #ccc;}
	td:nth-child(1),th:nth-child(1){width:10%;border-right:1px solid #ccc;}
	th:nth-child(2),td:nth-child(2){border-right:1px solid #ccc;}
	th,td{padding:1%;font-size:15px;}
	a{text-decoration:none;color:#fe2121;}
	.copyright{position:fixed;bottom:0px;right:5px;padding:00%;z-index: -2;}
	</style>
</head>
<body>
<script src="sweetalert.min.js"></script>
<!-- header section starts  -->

<header>

    <div class="header-1">

	<center><a href="#" class="logo" style = 'color:#fe2121;'>
        <img src = 'logo1.png' title = logo></a></center>
    </div>

   

</header>


<!-- Pickup section starts  -->

<section class="contact">
	<center>
		<a href = 'addLecense' title = 'Add New License' class='btn' style = 'background:#fe2121;'>Add New License</a>
</center>

</section>

<section class="contact">
	<form style = 'background-color:#fff;'>
		<table>
			<tr>
				<th>Id</th>
				<th>License Type</th>
				<!--<th>Attachment</th>-->
			</tr>
			<?php
				$sql = "SELECT * FROM categorylist";
				$result = $conn->query($sql);
				if ($result->num_rows > 0){
					while($row = $result->fetch_assoc()){
						$id = $row['id'];
						$name = $row['type'];
						//$attachment = $row['attachment'];
						/*if($attachment == ''){
						    //$attachment = 'NoAttachment.png';
						}*/
						echo "<tr><td>{$id}</td><td style = 'text-align:left;'>{$name}</td></tr>";
					}
				}
			?>
		</table>
    </form>
	<div class="wrapper">
      <div class="content">
        <ul class="menu">
          <li class="item share">
            <ul class="share-menu"></ul>
          </li>
          <li class="item">
            <i class="uil uil-ban"></i>
          </li>
          <li class="item">
            <span>Right Click Disabled</span>
          </li>
        </ul>
      </div>
    </div>
</section>
<div class="copyright"><img src = 'back.png' width = '300'></div>
<!-- Pickup section ends -->
<br><br>
<!-- custom js file link  -->
<script src = "scripts.js">
</script>
</body>
</html>