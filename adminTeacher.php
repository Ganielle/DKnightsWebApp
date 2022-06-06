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
  $photo_new_name = rand() . $photo_name;

  if ($photo_size > 5242880) {
      echo "<script>alert('Photo is very big. Maximum photo uploading size is 5MB.');</script>";
  } else {
      $sql = "UPDATE users SET  photo='$photo_new_name' WHERE id='{$_SESSION["user_id"]}'";
      $result = mysqli_query($conn, $sql);
      if ($result) {
          echo "<script>alert('Profile Updated successfully.');</script>";
          move_uploaded_file($photo_tmp_name, "ProfileUploads/" . $photo_new_name);
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
               <a href="logout.php" class=logout_btn>Logout</a>
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
            



                    <a href="adminWelcome.php"><i class="fas fa-home"></i><span>Dashboard</span></a>
                    <a href="adminStudent.php"><i class="fas fa-user-graduate"></i><span>Students</span></a>
                    <a href="adminTeacher.php"><i class="fas fa-chalkboard-teacher"></i><span>Teachers</span></a>
                    <a href="adminTopic.php"><i class="fas fa-table"></i><span>Topic List</span></a>
                  


            </div>


            <div class="content">
            <div class="teachercontainer">
    <div class="row justify-content-center">
      <div class="col-md-10">
 
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
          $query = 'SELECT * FROM teachers_crud';
          $stmt = $conn->prepare($query);
          $stmt->execute();
          $result = $stmt->get_result();
        ?>
        <h3 class="text-center ">Teachers Record </h3>
        
        <form action="adminTeacherAction.php" method="post" enctype="multipart/form-data">

        <div class="text-center">
        <a href="" class="btn btn-success "  data-toggle="modal" data-target="#modalRegisterForm" >Add Teacher</a>
      </div>     

        <table class="table table-hover " id="data-table"  style="color:white; height: 485px;">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>ID number</th>
            
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
              <td><?= $row['id']; ?></td>
              <td><?= $row['teachersName']; ?></td>
              <td><?= $row['teachersId']; ?></td>
            
              <td>
                <a href="adminTeacherDetails.php?adminTeacherDetails=<?= $row['id']; ?>" class="badge badge-success p-2">Details</a> |
                <a href="adminTeacherAction.php?delete=<?= $row['id']; ?>" class="badge badge-success p-2" onclick="return confirm('Do you want delete this record?');">Delete</a> |

              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>
  <script type="text/javascript">
  $(document).ready(function() {
    $('#data-table').DataTable({
      paging: true
    });
  });
  </script>
           
        
    



    <div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Sign up</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
          <i class="fas fa-id-card prefix grey-text"></i>
          <input type="text" name= "signup_teachersPassword" class="form-control validate">
          <label data-error="wrong" data-success="right" for="orangeForm-name">ID number</label>
        </div>
        <div class="md-form mb-5">
          <i class="fas fa-user prefix grey-text"></i>
          <input type="email" name= "signup_teachersFullname"  class="form-control validate">
          <label data-error="wrong" data-success="right" for="orangeForm-email">Teachers Fullname</label>
        </div>

        <div class="md-form mb-4">
          <i class="fas fa-lock prefix grey-text"></i>
          <input type="password" name= "signup_teachersPass" class="form-control validate">
          <label data-error="wrong" data-success="right" for="orangeForm-pass">Password</label>
        </div>

      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-deep-orange">Sign up</button>
      </div>
    </div>
  </div>
</div>

</form>




            </body>
</html>