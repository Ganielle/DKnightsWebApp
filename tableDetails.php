<?php



include 'teacheraction.php';


if (!isset($_COOKIE["user_id"])) {
    header("Location: index.php");
}

include 'config.php';


if (isset($_POST["submit"])) {
   

 
  $photo_name = $_FILES["photo"]["name"];
  $photo_tmp_name = $_FILES["photo"]["tmp_name"];
  $photo_size = $_FILES["photo"]["size"];
  $photo_new_name =  $photo_name;




  if ($photo_size > 5242880) {
      echo "<script>alert('Photo is very big. Maximum photo uploading size is 5MB.');</script>";
  }else if (file_exists($photo_new_name)) {
      $message = "The file $photo_new_name exists";
  } 





  else {
      $sql = "UPDATE users SET  photo='$photo_new_name' WHERE id='{$_SESSION["user_id"]}'";
      $result = mysqli_query($conn, $sql);
      if ($result) {

          if (file_exists($photo_new_name)){
              echo "<script>alert('file already exists.');</script>";

          }else{

          echo "<script>alert('Profile Updated successfully.');</script>";
          move_uploaded_file($photo_tmp_name, "ProfileUploads/" . $photo_new_name);

        
             
          }


          
      } else {
          echo "<script>alert('Profile can not Updated.');</script>";
          echo  $conn->error;
      }




  }


  

  


}
      


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" >
<title>wordlab.com</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<link rel="stylesheet" href="welcome.css">


<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css" />

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>


</head>


<body>

  <input type="checkbox" id="check">
  <header>
      <label for="check">
          <i class="fa fa-bars" id="sidebar_btn"></i>
      </label>
      <div class="left_area">
          <h3>Word<span>Lab</span></h3>
      </div>
      <div class="right_area">
         <a href="logout.php" class=logout_btn >Logout</a>
      </div> 
      
  </header>    

  
      <div class="sidebar">
      
    
      <center>
      <div class="inputBox">
          <h4>WELCOME</p></h4>
      <div class="wrapper">

      <form action="" method="post" enctype="multipart/form-data">
      <?php 
      
      $sql = "SELECT * FROM users WHERE id='{$_SESSION["user_id"]}'";
      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
      ?>
     
      <div class="inputBox">
          <img src="image/selectphoto.svg" alt="" class="select-profile">
          <input type="file" accept="image/*" id="photo" name="photo" class="form-control-file" value="This is some text" required>
      </div>
      <img src="ProfileUploads/<?php echo $row["photo"]; ?>" class="profile-img"   alt="">
      <p><?php echo $row['full_name']; ?></p>
      <?php
          }
      }

      ?>
      <div>
          <button type="submit" name="submit" class="btn btn-success">Update Profile</button>
      </div>
  </form>


      </div>

      </div>
            </center>
            
                    <a href="welcome.php"><i class="fas fa-home"></i><span>Dashboard</span></a>
                    <a href="student.php"><i class="fas fa-user-graduate"></i><span>Students</span></a>
                    <a href="teacher.php"><i class="fas fa-chalkboard-teacher"></i><span>Teachers</span></a>
                    <a href="table.php"><i class="fas fa-table"></i><span>Table</span></a>


            </div>


  <div class="container">

    <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-10">
      <form action="" method="post" enctype="multipart/form-data">
        <hr>
        <?php if (isset($_SESSION['response'])) { ?>
        <div class="alert alert-<?= $_SESSION['res_type']; ?> alert-dismissible text-center">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <b><?= $_SESSION['response']; ?></b>
        </div>
        <?php } unset($_SESSION['response']); ?>
      </div>
    </div>
    <div class="row">
     
      <div class="col-md-12">
        <?php
         $id=$_GET['tabledetails'];

          
          $query = "SELECT topic_name,question,answer,remarks FROM questions WHERE topic_name='$id'";
          $stmt = $conn->prepare($query);
          $stmt->execute();
          $result = $stmt->get_result();
        ?>
      


        
                
    <div class="row pt-4 justify-content-right">
      <div class="col-md-5 mx-5 mt-5 bg-dark p-4 rounded ">
        <h2 class="bg-light p-1 rounded text-left text-dark">ID : <?= $id; ?></h2>
      
      
        <table class="table table-hover text-light" id="data-table">
          <thead>
            <tr>
             
              <th>Question</th>
              <th>Answer</th>
              <th>Remarks</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            
    
            
            while ($tbrow=$result->fetch_assoc()) { ?>
            <tr>
             
              <td><?= $tbrow['question']; ?></td>
              <td><?= $tbrow['answer']; ?></td>
              <td><?= $tbrow['remarks']; ?></td>
              <td>
           
                <a href="teacheraction.php?delete=<?= $row['id']; ?>" class="badge badge-success p-2" onclick="return confirm('Do you want delete this record?');">Delete</a> 

              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>







      </div>
    </div>
  </div>
</div>




      
    </div>
       
      </div>
    </div>


          


  </div>
 
            </form>

            </div>
           
        
</body>













</html>