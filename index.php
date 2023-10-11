<?php
session_start();
if(!isset($_SESSION['remlogin'])){
	header("Location:login");
}
else{
	$userId = $_SESSION['remlogin'];
	include('database.php');
	date_default_timezone_set('Asia/Colombo');
    $fromdate = date("Y-m-d");
    $fromdate = strtotime("{$fromdate}");
    
    $sqlcat = "SELECT count(id) as cidcat, category FROM register where userid = {$userId} and status = 'Corrected' group by category";
	$resultcat = $conn->query($sqlcat);
	if ($resultcat->num_rows > 0){
	    while($rowcat = $resultcat->fetch_assoc()){
    	    if($rowcat['category'] == "Agreement"){
    	        $agreement = $rowcat['cidcat'];
    	    }
    	    else if($rowcat['category'] == "Standard"){
    	        $standed = $rowcat['cidcat'];
    	    }
    	    else if($rowcat['category'] == "Law"){
    	        $law = $rowcat['cidcat'];
    	    }
    	    else if($rowcat['category'] == "Regulation"){
    	        $regulaation = $rowcat['cidcat'];
    	    }
    	    else if($rowcat['category'] == "Policy"){
    	        $policy = $rowcat['cidcat'];
    	    }
    	    else{
    	        $other = $rowcat['cidcat'];
    	    }
	    }
	}
	if(!isset($agreement)){
	    $agreement = 0;
	}
	if(!isset($standed)){
	    $standed = 0;
	}
	if(!isset($law)){
	    $law = 0;
	}
	if(!isset($regulaation)){
	    $regulaation = 0;
	}
	if(!isset($policy)){
	    $policy = 0;
	}
	if(!isset($other)){
	    $other = 0;
	}
	if(isset($_POST["filter"])){
	    if(!empty($_POST["lType"])){
	        $whereCategory = '';
	        foreach($_POST["lType"] as $lType){
	            if ($whereCategory == ''){
	                $whereCategory = "category = '{$lType}'";
	            }
	            else{
	                $whereCategory .= " or category = '{$lType}'";
	            }
	        }
	        $where = "{$whereCategory}";
	    }
	    else{
	        $where = '';
	    }
	    if(!empty($_POST["fdate"]) and !empty($_POST["edate"])){
	        $fd = $_POST["fdate"];
	        $ed = $_POST["edate"];
	        if($where == ''){
	            $where .= " sdate BETWEEN '{$fd}' and '{$ed}'";
	        }
	        else{
	            $where .= " and sdate BETWEEN '{$fd}' and '{$ed}'";
	        }
	    }
	    else{
	        $where = $where;
	    }
	}
	else{
	    $where = '';
	}
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
    <link rel="stylesheet" href="wrapstyle.css">
	<!-- custom css file link  -->
	<link href="assets/css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
	.home {margin-top:-70px}
	.header-1 img{width:30%;}
	table{width:100%;border:1px solid #ccc;}
	tr:nth-child(1){border:1px solid #ccc;}
	th,td{padding:1%;font-size:15px;}
	a{text-decoration:none;color:#fe2121;}
	.copyright{position:fixed;bottom:0px;right:5px;padding:00%;z-index: -2;}
	.showorhide{display:none;}
	.hideorshow,.hideorshow form{text-align:left;width:30%;margin-top:5px;position:fixed;background:#fff;padding:1%;right:20px;font-size:16px;}
	</style>
</head>
<body>
<script src="sweetalert.min.js"></script>
<!-- header section starts  -->

<header>

    <div class="header-1">

	<center><a href="#" class="logo" style = 'color:#fe2121;'>
        <img src = 'logo1.png' title = logo></a></center>
        <a href="processing?logoutId=1" title = 'Signout' style = 'position:fixed;right:30px;color:#fe2121;font-size:20px;'>
		<b>&#10140;</b></a>
    </div>

   

</header>


<!-- Pickup section starts  -->

<section class="contact">
	<center>
		<a href = 'setReminder' title = 'Add New Reminder' class='btn' style = 'background:#fe2121;'>Add License / Agreement</a>
		<button onclick = 'displaylicenTypeFilter()' title = 'Filter From License Type' id = 'licenTypeFilter' class='btn' style = 'position:fixed;right:20px;background:#fff;color:#000;border:1px solid #aaa;'>Filter Licenses</button>
		<div id = 'displaycheckbox' class = 'showorhide'>
		    <form action = '#' method = 'post'>
    		    <input name = 'lType[]' type = 'checkbox' value = "Agreement"> Agreement<br>
    		    <input name = 'lType[]' type = 'checkbox' value = "Standard"> Standard<br>
    		    <input name = 'lType[]' type = 'checkbox' value = "Law"> Law<br>
    		    <input name = 'lType[]' type = 'checkbox' value = "Regulations"> Regulations<br>
    		    <input name = 'lType[]' type = 'checkbox' value = "Policy"> Policy<br>
    		    <input name = 'lType[]' type = 'checkbox' value = "Other"> Other<br>
    		    <input name = 'fdate' type = 'date' style = 'padding:1rem;font-size: 1.7rem;background:#f7f7f7;text-transform: none;margin:1rem 0;border:.1rem solid rgba(0,0,0,.3);width: 49%;'>
    		    <input name = 'edate' type = 'date' style = 'padding:1rem;font-size: 1.7rem;background:#f7f7f7;text-transform: none;margin:1rem 0;border:.1rem solid rgba(0,0,0,.3);width: 49%;'>
    		    <center><input name = 'filter' type = 'submit' value = 'Search' style = 'padding:1rem;font-size: 1.5rem;background:#f00;color:#fff;text-transform: none;margin:1rem 0;border:.1rem solid rgba(0,0,0,.3);width: 49%;'></center>
		    </form>
		</div>
</center>

</section>
<section class="contact">
    <form style = 'background:#fff;'>
	    <table >
		    <tr>
				<th>Agreement - <?php echo $agreement;?></th>
				<th>Standard - <?php echo $standed;?></th>
				<th>Law - <?php echo $law;?></th>
				<th>Regulation - <?php echo $regulaation;?></th>
				<th>Policy - <?php echo $policy;?></th>
				<th>Others - <?php echo $other;?></th>
			</tr>
		</table>
	</form>
	<br>
	<form style = 'background:#fff;'>
		<table >
			<tr style = 'border-left:none;border-right:none;'>
				<th colspan = '7'></th>
			</tr>
			<tr>
				<th>Title</th>
				<th>Category</th>
				<th>Year</th>
				<th>Status</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Attachment</th>
			</tr>
			<?php
			    if($where == ''){
			        $sql = "SELECT * FROM register where userid = {$userId} order by id desc";
			    }
			    else{
			        $sql = "SELECT * FROM register where userid = {$userId} and {$where} order by id desc";
			    }
				$result = $conn->query($sql);
				if ($result->num_rows > 0){
					while($row = $result->fetch_assoc()){
						$id = $row['id'];
						$title = $row['title'];
						$status = $row['status'];
						$category = $row['category'];
						$sdate = $row['sdate'];
						$edate = $row['edate'];
						$document = $row['document'];
						if ($document != "NoAttachment.png"){
						    $atacment = "<a href = 'images/{$document}'>Attachment</a>";
						}
						else{
						    $atacment = "No Attachment";
						}
						$todate = strtotime("{$edate}");
            			$diff_days = $todate - $fromdate;
            			$different = floor($diff_days/(60*60*24));
            			$year = $sdate[0].$sdate[1].$sdate[2].$sdate[3];
            			if ($different < 0){
            			    $status = "<b><font style = 'color:#E62E2D;'>Expired</font></b>";
            			}
						else{
							$status = "<b><font style = 'color:#0f0;'>Renewed</font></b>";
						}
						echo "<tr><td><a href = 'reminderDetails?viewId={$id}'>{$title}</a></td><td style = 'text-align:left;'>{$category}</td><td>{$year}</td><td>{$status}</td><td>{$sdate}</td><td>{$edate}</td><td>{$atacment} </td></tr>";
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

<script>
function displaylicenTypeFilter(){
    var displaycheckbox = document.getElementById("displaycheckbox");
    
    if(displaycheckbox.className =="showorhide"){
        displaycheckbox.className ="hideorshow";
    }
    else{
        displaycheckbox.className ="showorhide";
    }
}
</script>
</body>
</html>