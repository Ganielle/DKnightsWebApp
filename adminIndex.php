<?php

include 'config.php';

session_start();

error_reporting(0);

if (isset($_SESSION["user_id"]) || isset($_COOKIE['user_id'])) {
  header("Location: adminWelcome.php");
}

if (isset($_POST["signup"])) {
  $full_name = mysqli_real_escape_string($conn, $_POST["signup_full_name"]);
  $username = mysqli_real_escape_string($conn, $_POST["signup_username"]);
  $phone = mysqli_real_escape_string($conn, $_POST["signup_phone"]);
  $password = mysqli_real_escape_string($conn, md5($_POST["signup_password"]));
  $cpassword = mysqli_real_escape_string($conn, md5($_POST["signup_cpassword"]));
  $token = md5(rand());
 




  $check_username = mysqli_num_rows(mysqli_query($conn, "SELECT username FROM users WHERE username='$username'"));

  if ($password !== $cpassword) {
    echo "<script>alert('Password did not match.');</script>";
  } elseif ($check_username> 0) {
    echo "<script>alert('Student Number already exists in out database.');</script>";
  } else {

 

    $sql = "INSERT INTO users (full_name, username,phone, password, token, status) VALUES ('$full_name', '$username','$phone','$password', '$token', '0')";
  
    $result = mysqli_query($conn, $sql);
  

  
    if ($result) {


      $_POST["signup_full_name"] = "";
      $_POST["signup_username"] = "";
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


if (isset($_POST["submit"])) {
  $full_name = mysqli_real_escape_string($conn, $_POST["signup_full_name"]);
  $email = mysqli_real_escape_string($conn, $_POST["signup_email"]);
  $phone = mysqli_real_escape_string($conn, $_POST["signup_phone"]);
  $password = mysqli_real_escape_string($conn, md5($_POST["signup_password"]));
  $cpassword = mysqli_real_escape_string($conn, md5($_POST["signup_cpassword"]));
  $token = md5(rand());
   

  if ($password === $cpassword) {
      $photo_name = $_FILES["image"]["name"];
      $photo_tmp_name = $_FILES["image"]["tmp_name"];
      $photo_size = $_FILES["image"]["size"];
      $photo_new_name = rand() . $photo_name;

      if ($photo_size > 5242880) {
          echo "<script>alert('Photo is very big. Maximum photo uploading size is 5MB.');</script>";
      } else {
        $sql = "INSERT INTO users (full_name, email,phone, password,image, token, status) VALUES ('$full_name', '$email','$phone','$password','$photo_new_name', '$token', '0')";
        $result = mysqli_query($conn, $sql);
          if ($result) {
            
              move_uploaded_file($photo_tmp_name, "loginUploads/" . $photo_new_name);
          } else {
        
              echo  $conn->error;
          }
      }
  } else {
      echo "<script>alert('Password not matched. Please try again.');</script>";
  }
}


if (isset($_POST["signin"])) {
  $username = mysqli_real_escape_string($conn, $_POST["username"]);
  $password = mysqli_real_escape_string($conn, md5($_POST["password"]));
  $check_username= mysqli_query($conn, "SELECT id FROM users WHERE username='$username' AND password='$password' AND status='0'");


  if (mysqli_num_rows($check_username) > 0) {
    $row = mysqli_fetch_assoc($check_username);
    $_SESSION["user_id"] = $row['id'];
    $_SESSION['full_name'] = $full_name;
    setcookie('user_id', $row['id'],time() + +3600*24*5);
    header("Location:  adminWelcome.php");
   
  } else {
   
    echo "<script>alert('Login details is incorrect. Please try again.');</script>";
  }
}


if (isset($_POST["signin"])) {

  setcookie("username",$_POST["username"],time()+time() + 60*60*24*30);
  setcookie("password",$_POST["password"],time() + 60*60*24*30);
  header("Location: adminWelcome.php");
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
            <input type="text" placeholder="Username" name="username" value="<?php echo $_SESSION['username']; ?>" required />
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
        <form action="" class="sign-up-form" method="post" entype="multipart/form-data">
          <h2 class="title">Sign up</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Full Name" name="signup_full_name" value="<?php echo $_POST["signup_full_name"]; ?>" required />
          </div>
          <div class="input-field">
          <i class="fas fa-id-card"></i>
            <input type="text" placeholder="Username" name="signup_username" value="<?php echo $_POST["signup_username"]; ?>" required />
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

        <!-- <button class="btn transparent" id="sign-up-btn">
            Sign up
            </button> -->
        
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