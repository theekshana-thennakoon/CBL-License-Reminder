<?php
session_start();
include('database.php');
date_default_timezone_set('Asia/Colombo');
$fromdate = date("Y-m-d");
$fromdate = strtotime("{$fromdate}");
$sentemail = "milans.pf@cbllk.com";
?>

<?php
	$sql = "SELECT * FROM register where status = 'Corrected'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$id = $row['id'];
			$userid = $row['userid'];
			$title = $row['title'];
			$sdate = $row['sdate'];
			$edate = $row['edate'];
			$ninty = $row['ninty'];
			$thirty = $row['thirty'];
			$ten = $row['ten'];
			$expire = $row['expire'];
			$todate = strtotime("{$edate}");
			$diff_days = $todate - $fromdate;
			$different = floor($diff_days/(60*60*24));

            $sqla = "SELECT * FROM adminlogin where id = {$userid}";
            $resulta = $conn->query($sqla);
            if ($resulta->num_rows > 0){
                while($rowa = $resulta->fetch_assoc()){
                    $useremail = $rowa['email'];
                    $username = $rowa['name'];
                }
            }

			if ($different <= 0){
			    if ($expire != "sent"){
			        $to = $useremail;
                    $differentbody = "<b>The </b>{$title}</b> is Expired.</b>";
			    }
			}
			else if($different <= 10){
                if ($ten != "sent"){
                    $to = $useremail;
                    $differentbody = "You have to Correct </b>{$title}</b> and You have only </b>{$different} days to Expire this.</b>";
                }
			}
            else if($different <= 30){
                if ($thirty != "sent"){
                    $to = $useremail;
                    $differentbody = "You have to Correct </b>{$title}</b> and You have only </b>{$different} days to Expire this.</b>";
                }
			}
            else if($different <= 90){
                if ($ninty != "sent"){
                    $to = $useremail;
                    $differentbody = "You have to Correct </b>{$title}</b> and You have only </b>{$different} days to Expire this.</b>";
                }
			}
			if (isset($to)){
			    $sqla = "SELECT * FROM adminlist";
            	$resulta = $conn->query($sqla);
            	if ($resulta->num_rows > 0){
            		while($rowa = $resulta->fetch_assoc()){
            			$adminemailaddressget = $rowa['email'];
            			//$to = $to . ",{$adminemailaddressget}";
            		}
            	}
			}
            
            if (isset($to)){
                echo $to;
                $email_subject = "Reminder";
                $email_body = "<html><body>Dear {$username}<br><br>";
                $email_body .= "{$differentbody}</body></html>";
                echo "<br><br>" . $email_body;
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                
                // Create email headers
                $headers .= 'From: '.$sentemail."\r\n".
                    'Reply-To: '.$sentemail."\r\n" .
                    'X-Mailer: PHP/' . phpversion();
                $send_mail_result = mail($to,$email_subject,$email_body,$headers);

                if ($send_mail_result){
                    if ($different <= 0){
                        $sqli = "UPDATE register set status = 'Expired' where id = {$id}";
                        if($conn->query($sqli) === TRUE){
                            $sentcollumn = 'expire';
                        }
                    }
                    else if ($different <= 10){
                        $sentcollumn = 'ten';
                    }
                    else if ($different <= 30){
                        $sentcollumn = 'thirty';
                    }
                    else if ($different <= 90){
                        $sentcollumn = 'ninty';
                    }
                    $sqli = "UPDATE register set {$sentcollumn} = 'sent' where id = {$id}";
                    if($conn->query($sqli) === TRUE){
                        //echo "<script>window.history.back()</script>";
                    }
                    
                }
            }

		}
	}
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
	
	<link href="/projects/Election/assets/css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="/projects/Election/assets/css/style.css">
    <style>
    .header-1 img{width:30%;}
    .contact{margin-top:6%;}
    .ntfoundgif{width:20%;}
    .link{text-decoration:none;background:#E62E2D;padding:1% 2%;color:#fff;border-radius:20px;font-size:15px;}
    .link:hover{color:#fff;}
    @media (max-width: 739px) {
        .contact{mergin-top:0;
            display: flex;min-height: 80%;align-items: center;justify-content: center;
        }
        h1{font-size:22px;}
        .link{text-decoration:none;background:#f00;padding:3% 5%}
        .ntfoundgif{width:50%;}
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

        <center><a href="#" class="logo" style = 'color:#fe2121;'>
        <img src = '/projects/reminder/logo1.png'></a>

    </div>

    

</header>
<!-- Pickup section starts  -->

<section class="contact">
	<center>
    <h1>SENDING EMAILS.....</h1><br>
</section>

<!-- Pickup section ends -->
<br><br>
<!-- custom js file link  -->
<script src="script.js"></script>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>