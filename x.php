<?php
session_start();
?>
<?php
include('database.php');
$sentemail = "milans.pf@cbllk.com";
?>
<script src="sweetalert.min.js"></script>
<?php
//User Login
if(isset($_POST['loginAdmin'])){
    $username = $_POST['usernameAdmin'];
    $pwd = $_POST['pwd'];
    $sql = "SELECT * FROM adminlogin where email = '{$username}' and delstatus = 0";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $pasword = $row['pwd'];
            $id = $row['id'];
            $status = $row['status'];
        }
        $verifypwd = password_verify($pwd, $pasword);
		if($verifypwd){
            if($status == 0){
                $_SESSION['remlogin'] = $id;
                header("Location:main");
            }
            else{
                $_SESSION['remadminlogin'] = $id;
                header("Location:adminpanel");
            }
        }
        else{
            $_SESSION['wrongpwd'] = 100;
			echo "<script>window.history.back()</script>";
        }
    }
    else{
        $_SESSION['wrongemail'] = 100;
		echo "<script>window.history.back()</script>";
    }
    
}

//send otp to forget password
if(isset($_POST['forgetsendmail'])){
    $username = $_POST['usernameAdmin'];
    $to = $_POST['usernameAdmin'];
    $pwd = $_POST['pwd'];
    $_SESSION['otpsendemail'] = $username;
    $sql = "SELECT * FROM adminlogin where email = '{$username}'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        $email_subject = "Reminder";
        $rand1 = rand(100,999);
        $rand2 = rand(100,999);
        $_SESSION['stotp'] = $rand1 . $rand2;
        $sendotpnum = $_SESSION['stotp'];
        $email_body = "<html><body>Dear {$username}<br><br>";
        $email_body .= "Your verification code :  </b>{$sendotpnum}</b> .</body></html>";
                
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                
        // Create email headers
        $headers .= 'From: '.$sentemail."\r\n".
            'Reply-To: '.$sentemail."\r\n" .
            'X-Mailer: PHP/' . phpversion();
        $send_mail_result = mail($to,$email_subject,$email_body,$headers);
        header("Location:confirmotp");

    }
    else{
        $_SESSION['wrongemail'] = 100;
		echo "<script>window.history.back()</script>";
    }
}

//confirm otp
if(isset($_POST['confirmotp'])){
    $otp = $_POST['otp'];
    $_SESSION['stotp'] = $otp;
    if ($_SESSION['stotp'] == $otp){
        header("Location:resetpassword");
    }
    else{
        $_SESSION['wrongotp'] = 100;
		echo "<script>window.history.back()</script>";
    }
}

//reset password
if(isset($_POST['resetpwd'])){
    $pwd = $_POST['pwd'];
    $repwd = $_POST['repwd'];
    $email = $_SESSION['otpsendemail'];
    if ($pwd == $repwd){
        $hash = password_hash($pwd, PASSWORD_DEFAULT);
        $sqli = "UPDATE adminlogin set pwd = '{$hash}' where email = '{$email}'";
        if($conn->query($sqli) === TRUE){
    		header("Location:login");
    	}
    }
    else{
    	$_SESSION['wrongpwd'] = 100;
	    echo "<script>window.history.back()</script>";
    }
}

//Create User Account
if(isset($_POST['createAccount'])){
    $username = $_POST['usernameAdmin'];
    $sql = "SELECT * FROM adminlogin where email = '{$username}' and pwd = ''";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $id = $row['id'];
        }
        $password = $_POST['pwd'];
        $repassword = $_POST['repwd'];
        if($password ==  $repassword){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sqli = "UPDATE adminlogin set pwd = '{$hash}' where id = {$id}";
            if($conn->query($sqli) === TRUE){
                $_SESSION['remlogin'] = $id;
                header("Location:main");
            }
        }
        else{
            $_SESSION['wrongpwd'] = 100;
			echo "<script>window.history.back()</script>";
        }
    }
    else{
        $_SESSION['wrongemail'] = 100;
		echo "<script>window.history.back()</script>";
    }
    
}

//Add Reminder
if(isset($_POST['addrem'])){
	$title = $_POST['title'];
    $type = $_POST['type'];
    $sql = "SELECT * FROM categorylist where id = {$type}";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $type = $row['type'];
        }
    }
    echo $_FILES['img']['name'];
    if(isset($_FILES['img'])){
        if ($_FILES['img']['name'] == ''){
            $image = 'NoAttachment.png';
        }
        else{
            $image = $_FILES['img']['name'];
            $filetmpname = $_FILES['img']['tmp_name'];
            $filesize = $_FILES['img']['size'];
            $folder = 'images/';
        }
    }
    else{
        $image = 'NoAttachment.png';
    }
    $discription = $_POST['discription'];
    $uid = $_SESSION['remlogin'];
    $sdate = $_POST['sdate'];
    $edate = $_POST['edate'];
    //$rpeople = $_POST['rpeople'];
    die();
	//$sqli = "INSERT INTO `register`(userid, title, description,category,document, sdate, edate,status,responsible) VALUES ($uid,'$title','$discription','$type','$image','$sdate','$edate','Corrected','$rpeople')";
	$sqli = "INSERT INTO `register`(userid, title, description,category,document, sdate, edate,status) VALUES ($uid,'$title','$discription','$type','$image','$sdate','$edate','Corrected')";
	if($conn->query($sqli) === TRUE){
	    if($image != 'NoAttachment.png'){
	        move_uploaded_file($filetmpname,$folder.$image);
        }
		$_SESSION['sussessReg'] = 0;
		echo "<script>window.history.back()</script>";
	}
}

//Set the Reminder is Correct
if(isset($_GET['correctionId'])){
	
    $correctionId = $_GET['correctionId'];
	$sqli = "UPDATE register set status = 'Corrected' where id = {$correctionId}";
	if($conn->query($sqli) === TRUE){
		echo "<script>window.history.back()</script>";
	}
}

//Reset Correction
if(isset($_GET['recorrectionId'])){
	
    $correctionId = $_GET['recorrectionId'];
	$sqli = "UPDATE register set status = null where id = {$correctionId}";
	if($conn->query($sqli) === TRUE){
		echo "<script>window.history.back()</script>";
	}
}

//User Logout
if(isset($_GET['logoutId'])){
    session_destroy();
    header("Location:main");
}

//Delete the Reminder
if(isset($_GET['delId'])){
	
    $delId = $_GET['delId'];
	$sqli = "DELETE from register where id = {$delId}";
	if($conn->query($sqli) === TRUE){
		echo "<script>window.history.back()</script>";
	}
}

//Remove user
if(isset($_GET['removeUser'])){
	
    $delId = $_GET['removeUser'];
	$sqli = "Update adminlogin SET delstatus = 1 where id = {$delId}";
	if($conn->query($sqli) === TRUE){
        $_SESSION['sussessRemuser'] = 0;
		echo "<script>window.history.back()</script>";
	}
}
//Reactive user
if(isset($_GET['reactiveUser'])){
	
    $delId = $_GET['reactiveUser'];
	$sqli = "Update adminlogin SET delstatus = 0 where id = {$delId}";
	if($conn->query($sqli) === TRUE){
        $_SESSION['sussessReactive'] = 0;
		echo "<script>window.history.back()</script>";
	}
}
//Remove Category
if(isset($_GET['inactiveid'])){
	
    $correctionId = $_GET['inactiveid'];
	$sqli = "UPDATE categorylist set status = 0 where id = {$correctionId}";
	if($conn->query($sqli) === TRUE){
		echo "<script>window.history.back()</script>";
	}
}

//Re active Category
if(isset($_GET['activeid'])){
	
    $correctionId = $_GET['activeid'];
	$sqli = "UPDATE categorylist set status = 1 where id = {$correctionId}";
	if($conn->query($sqli) === TRUE){
		echo "<script>window.history.back()</script>";
	}
}

//Create Admin Account
if(isset($_POST['createadminAccount'])){
    $username = $_POST['usernameAdmin'];
    $sql = "SELECT * FROM adminlist where email = '{$username}' and pwd = ''";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $id = $row['id'];
        }
        $password = $_POST['pwd'];
        $repassword = $_POST['repwd'];
        if($password ==  $repassword){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sqli = "UPDATE adminlist set pwd = '{$hash}' where id = {$id}";
            if($conn->query($sqli) === TRUE){
                $_SESSION['remadminlogin'] = $id;
                header("Location:admin");
            }
        }
        else{
            $_SESSION['wrongpwd'] = 100;
			echo "<script>window.history.back()</script>";
        }
    }
    else{
        $_SESSION['wrongemail'] = 100;
		echo "<script>window.history.back()</script>";
    }
    
}

//Add New User
if(isset($_POST['addnewuser'])){
	$name = $_POST['name'];
    $epf = $_POST['epf'];
    $email = $_POST['email'];
    $sql = "SELECT * FROM adminlogin where email = '{$email}'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        $_SESSION['alreadyuser'] = 0;
		echo "<script>window.history.back()</script>";
    }
    else{
        $jobstatus = $_POST['jobstatus'];
        $userrole = $_POST['userrole'];
        $sqli = "INSERT INTO `adminlogin`(name, epf, jobstatus,email,status) VALUES ('$name','$epf','$jobstatus','$email',$userrole)";
        if($conn->query($sqli) === TRUE){
            $_SESSION['sussessReg'] = 0;
            echo "<script>window.history.back()</script>";
        }
    }
}


//Add New License
if(isset($_POST['addnewlicanse'])){
	$name = $_POST['name'];
    
    if(isset($_FILES['img'])){
        $img = $_FILES['img'];
        if ($img == ''){
            $image = $_FILES['img']['name'];
            $filetmpname = $_FILES['img']['tmp_name'];
            $filesize = $_FILES['img']['size'];
            $folder = 'images/';
        }
        else{
            $image = 'NoAttachment.png';
        }
    }
    else{
        $image = 'NoAttachment.png';
    }
    
	$sqli = "INSERT INTO `categorylist`(type) VALUES ('$name')";
	if($conn->query($sqli) === TRUE){
	    if($image != 'No Attachment.png'){
	        //move_uploaded_file($filetmpname,$folder.$image);
        }
		$_SESSION['sussessReg'] = 0;
		echo "<script>window.history.back()</script>";
	}
}
?>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>