<?php

include 'config.php';

session_start();

error_reporting(0);

if (isset($_SESSION["user_id"]) || isset($_COOKIE['user_id'])) {
  header("Location: welcome.php");
}

if (isset($_POST["signup"])) {
  $full_name = mysqli_real_escape_string($conn, $_POST["signup_full_name"]);
  $studentNumber = mysqli_real_escape_string($conn, $_POST["signup_studentNumber"]);
  $phone = mysqli_real_escape_string($conn, $_POST["signup_phone"]);
  $password = mysqli_real_escape_string($conn, md5($_POST["signup_password"]));
  $cpassword = mysqli_real_escape_string($conn, md5($_POST["signup_cpassword"]));
  $token = md5(rand());
 




  $check_studNum = mysqli_num_rows(mysqli_query($conn, "SELECT studentNumber FROM users WHERE studentNumber='$studentNumber'"));

  if ($password !== $cpassword) {
    echo "<script>alert('Password did not match.');</script>";
  } elseif ($check_studNum > 0) {
    echo "<script>alert('Student Number already exists in out database.');</script>";
  } else {

 

    $sql = "INSERT INTO users (full_name, studentNumber,phone, password, token, status) VALUES ('$full_name', '$studentNumber','$phone','$password', '$token', '0')";
  
    $result = mysqli_query($conn, $sql);
  

  
    if ($result) {


      $_POST["signup_full_name"] = "";
      $_POST["signup_studentNumber"] = "";
      $_POST["signup_phone"] = "";
      $_POST["signup_password"] = "";
      $_POST["signup_cpassword"] = "";

     

    
    

      $to = $email;
      $subject = "Email verification - Pure Coding YouTube";

      $message = "
      <html>
      <head>
      <title>{$subject}</title>
      </head>
      <body>
      <p><strong>Dear {$full_name},</strong></p>
      <p>Thanks for registration! Verify your email to access our website. Click below link to verify your email.</p>
      <p><a href='{$base_url}verify-email.php?token={$token}'>Verify Email</a></p>
      </body>
      </html>
      ";

   
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

      $headers .= "From: ". $my_email;

      if (mail($to,$subject,$message,$headers)) {
        echo "<script>alert('We have sent a verification link to your email - {$email}.');</script>";
      } else {
        echo "<script>alert('You are now registered');</script>";
      }
    } else {
      echo "<script>alert('User registration failed.');</script>";
    }
  }



}





if (isset($_POST["signin"])) {
  $teachersId = mysqli_real_escape_string($conn, $_POST["teachersId"]);
  $password = mysqli_real_escape_string($conn, ($_POST["password"]));
  $check_studNum= mysqli_query($conn, "SELECT id FROM teachers_crud WHERE teachersId='$teachersId' AND password='$password' ");
  
  
  
  if (mysqli_num_rows($check_studNum) > 0) {
    $row = mysqli_fetch_assoc($check_studNum);
    $_SESSION["id"] = $row['id'];
    $_SESSION['teachersName'] = $teachersName;
    setcookie('id', $row['id'],time() + +3600*24*5);
    header("Location: teachersWelcome.php");
   
  } else {
   
    echo "<script>alert('Login details is incorrect. Please try again.');</script>";
  }
  }

if (isset($_POST["signin"])) {

  setcookie("teachersId",$_POST["teachersId"],time()+time() + 60*60*24*30);
  setcookie("password",$_POST["password"],time() + 60*60*24*30);
  header("Location: teachersWelcome.php");
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <title>wordlab.com</title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">


        <form action="" method="post" class="sign-in-form">
          <h2 class="title">Sign in</h2>
          <div class="input-field">
          <i class="fas fa-id-card"></i>
            <input type="text" placeholder="teachersId" name="teachersId" value="<?php echo $_SESSION['teachersId']; ?>" required />
          </div>
          
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="password" value="<?php echo $_SESSION['password']; ?>" required />
          </div>
          <input type="submit" value="Login" name="signin" class="btn solid" />
          <div class="form-row">
          <button onClick="parent.location='http://localhost/loginsystem/adminIndex.php'" type="button" >Admin</button>
          <button onClick="parent.location='http://localhost/loginsystem/teacherIndex.php'" type="button" >Teacher</button> 
          <button onClick="parent.location='http://localhost/loginsystem/index.php'" type="button" >Student</button>  
          </div>

          <p style="display: flex;justify-content: center;align-items: center;margin-top: 20px;"><a href="forgot-password.php" style="color: #4590ef;">Forgot Password?</a></p>
        </form>



        <form action="index.php" class="sign-up-form" method="post" entype="multipart/form-data">
          <h2 class="title">Sign up</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Full Name" name="signup_full_name" value="<?php echo $_POST["signup_full_name"]; ?>" required />
          </div>
          <div class="input-field">
          <i class="fas fa-id-card"></i>
            <input type="text" placeholder="Student Number" name="signup_studentNumber" value="<?php echo $_POST["signup_studentNumber"]; ?>" required />
          </div>
          <div class="input-field">
            <i class="fas fa-phone"></i>
            <input type="phone" placeholder="Phone Number" name="signup_phone" value="<?php echo $_POST["signup_phone"]; ?>" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="signup_password" value="<?php echo $_POST["signup_password"]; ?>" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Confirm Password" name="signup_cpassword" value="<?php echo $_POST["signup_cpassword"]; ?>" required />
          </div>
          

          <input type="submit" class="btn" name="signup" value="Sign up" />
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <div class="wordlabtext">
        <h3>WordLab<span>School Inc.</span></h3> 
          </div>
          <p>
        ------------------------------------------------------
          </p>
          
        
        </div>
        <img src="img/wordlabmainlogo.png" class="image" alt="" />
        
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>One of us ?</h3>
          <p>
      ----------------------------------------
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Sign in
          </button>
        </div>
        <img src="img/kids.png" class="image" alt="" />
      </div>
    </div>
  </div>

  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <script src="app.js"></script>
</body>

</html>