<?php
session_start();
?>
<?php
include('database.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Reminder</title>

    <!-- font awesome cdn link  -->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
-->
    <!-- custom css file link  -->
	
	<link href="assets/css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="wrapstyle.css">
	<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    
    <style>
    .header-1 img{width:30%;}
    .inputBox select , .inputBox input{
	  padding:1rem;font-size: 1.7rem;background:#f7f7f7;text-transform: none;
	  margin:1rem 0;border:.1rem solid rgba(0,0,0,.3);width: 49%;
    }
    .copyright{position:fixed;bottom:0px;right:5px;padding:00%;z-index: -2;}
	
    @media (max-width: 739px) {
        .contact{
            display: flex;min-height: 80%;align-items: center;justify-content: center;
        }
	    .header-1 img{width:80%;}
	    .inputBox .selectplant{width:100%}
    } 
    </style>
</head>
<body>
<script src="sweetalert.min.js"></script>

<!-- header section starts  -->

<header>

    <div class="header-1">
        <button title = 'Back' style = 'position:fixed;left:30px;color:#fe2121;font-size:20px;' onclick="window.history.back()">
		<b>&#10611;</b></button>
        <center><a href="#" class="logo" style = 'color:#fe2121;'>
        <img src = 'logo1.png'></a></center>

    </div>

    

</header>
<!-- Pickup section starts  -->

<section class="contact">
	<form action='processing' method = 'post' style = 'background:#fff;' enctype="multipart/form-data">

        <div class='inputBox'>
            <input type = 'text' name = 'title' placeholder='Enter Title' maxlength="50" required>
            <select name = 'type' required>
                <option value="#">Select Category</option>
                <?php
                    $sql = "SELECT * FROM categorylist WHERE status = 1 order by type ASC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $id = $row['id'];
                            $type = $row['type'];
                            $categorydrp .= "<option value = {$id}>{$type}</option>";
                        }
                        $categorydrp .= "<option value = Other>Other</option>";
                        echo $categorydrp;
                    }
                    else{
                        echo "<option value = No License>No Licenses</option>";   
                    }
                ?>
            </select>
        </div>
		
		<div class='inputBox'>
            <textarea name = 'discription' placeholder='Enter Description' required></textarea>
        </div>

        <div class='inputBox'>
            <input type = 'text' name = 'sdate' placeholder='Start Date' onfocus = "(this.type='date')" required>
            <input type = 'text' name = 'edate' placeholder='End Date' onfocus = "(this.type='date')" required>
        </div>
        <div class='inputBox'>
            <input type="file" accept = ".pdf" id="file-ip-1" name="img" placeholder = "Upload Image" placeholder = 'Select Attachments' id="files" onchange="showPreview(event);">
            
            <select name = 'rpeople'  id="rpeople" multiple data-live-search="true" required>
                <option value="#">Select Responsibility People</option>
                <?php
                    $sqlr = "SELECT * FROM adminlogin WHERE delstatus = 0";
                    $resultr = $conn->query($sqlr);
                    if ($resultr->num_rows > 0){
                        $rpeoplelist = "";
                        while($rowr = $resultr->fetch_assoc()){
                            $idr = $rowr['id'];
                            $namer = $rowr['name'];
                            $emailr = $rowr['email'];
                            $rpeoplelist .= "<option value = {$emailr}>{$namer}</option>";
                        }
                        echo $rpeoplelist;
                    }
                    else{
                        echo "<option value = No Users>No Users</option>";   
                    }
                ?>
            </select>
        </div>
        <input type='submit' name = 'addrem' value='Add to list' class='btn' style = 'background:#fe2121;'>
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
<script src="script.js"></script>
<?php

if(isset($_SESSION['sussessReg'])){
    $txt = 'Successfully Submited the Remind.';
    echo "<script>
        swal({
        title: 'Successfully',
            text: '$txt',
            icon: 'success',
        });
    </script>";
    unset($_SESSION['sussessReg']);
}

?>
<script src="scripts.js"></script>
<script>
    $('#rpeople').selectpicker();
</script>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>