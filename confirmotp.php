<?php
session_start();
if(isset($_SESSION['remlogin'])){
    header("Location:main");
}
if(isset($_SESSION['remadminlogin'])){
  header("Location:adminpanel");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Reminder</title>
	
	<link href="assets/css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <style>
    body{
        background-image: url(back.jpg);
        background-size: cover;
        background-repeat: no-repeat;
        height:90vh;
    }
    .copyright{position:fixed;bottom:0px;right:0px;padding:00%;z-index: -2;}
	
    @media (max-width: 739px) {
        .contact{
            margin-top:0;display: flex;min-height: 80%;align-items: center;justify-content: center;
        }
	    .header-1 img{width:80%;}
	    .inputBox .selectplant{width:100%}
    } 
    </style>
</head>
<body>
<script src="sweetalert.min.js"></script>
  <div class="container py-5 h-100 mt-5">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="Reminder.png"
                alt="login form" class="img-fluid" style="height:100%; width:100%; border-radius: 1rem 0 0 1rem;" />
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <form action='processing' method = 'post' style = 'border:2px solid #fff;'>

                  <div class="d-flex align-items-center mb-3 pb-1">
                    <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                  </div>

                  <h5 class="fw-normal fs-1 mb-3 pb-3" style="letter-spacing: 1px;">Verify OTP Code</h5>

                  <div class="form-outline mb-4">
                    <input type="email" id="form2Example17" name = 'otp' placeholder='Email Address' class="form-control fs-4 form-control-lg" />
                    <label class="form-label fs-5" placeholder='Password' for="form2Example17">OTP Number</label>
                  </div>

                  <div class="pt-1 mb-4">
                    <button class="btn btn-dark btn-lg btn-block p-2 fs-3" name = 'confirmotp' type="submit" style = 'border:none;background:#fe2121;'>Confirm Verification Code</button>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<div class="copyright"><img src = 'back.png' width = '300'></div>
<!-- Pickup section ends -->
<br><br>
<!-- custom js file link  -->
<script src="script.js"></script>
<?php
if(isset($_SESSION['wrongpwd'])){
  echo "<script>
      swal({
      title: 'Wrong Password',
          text: 'Please Check Your Password',
          icon: 'error',
      });
  </script>";
  session_destroy();
}

if(isset($_SESSION['wrongemail'])){
  echo "<script>
      swal({
      title: 'Wrong Email',
          text: 'Please Check Your Email Address',
          icon: 'error',
      });
  </script>";
  session_destroy();
}

?>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>