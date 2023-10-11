<?php
session_start();
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
	<form action='processing' method = 'post'>

        <div class='inputBox'>
            <input type = 'text' name = 'name' placeholder='Enter Name' maxlength="50" required>
            <input type = 'text' name = 'epf' placeholder='Enter EPF' maxlength="50" required>
        </div>
		
        <div class='inputBox'>
            <input type = 'email' name = 'email' placeholder='Enter Email Address' maxlength="50" required>
            <input type = 'text' name = 'jobstatus' placeholder='Enter Job Status' maxlength="50" required>
        </div>
            <input type='submit' name = 'addnewuser' value='Add User' class='btn' style = 'background:#fe2121;'>
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
    $txt = 'Successfully Added New User.';
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
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>