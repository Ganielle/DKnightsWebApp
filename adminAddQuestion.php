<?php

include 'action.php';



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
            

                    
                
                    <a href="adminWelcome.php"><i class="fas fa-home"></i><span>Dashboard</span></a>
                    <a href="adminStudent.php"><i class="fas fa-user-graduate"></i><span>Students</span></a>
                    <a href="adminTeacher.php"><i class="fas fa-chalkboard-teacher"></i><span>Teachers</span></a>
                    <a href="adminTopic.php"><i class="fas fa-table"></i><span>Topic List</span></a>
                  
                    
                    
            </div>
                
            
            <div class="content">
                 <div class="addquestioncontainer">

                     
                 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                 
                 <div class="col-md-12">
        <?php
        
        if(isset($_GET['addquestion'])){
         $id=$_GET['addquestion'];
          $query = "SELECT * FROM $id ";
          $stmt = $conn->prepare($query);
          $stmt->execute();
          $result = $stmt->get_result();
   
        }
        ?>
      

            <input name="topic_id" cols="30" rows="10" value="<?php echo $id; ?>" placeholder="<?php echo $id; ?>"></textarea>
                    <br>
      
                    <label for="name">Question</label>
                    <input name="newquestion" id="question" cols="30" rows="10"  placeholder="Write Question"></textarea>
                    <label for="name">Answer</label>
                    <input name="answer" id="question" cols="30" rows="10"  placeholder="Write Answer"></textarea>
                   
                  
                 
                    
                    <br><br><br>
            
                    <input type="submit" name="addquest" href="addquestion.php?addquestion=<?php echo($id[0]); ?>"  class="send-message-cta" value="Create">
                
                 
                <?php
             
          
             if(isset($_POST['addquest'])){ 
                 
                $id=$_POST['topic_id'];

                 $question=$_POST['newquestion'];
            
                $answer=$_POST['answer'];

                 $query="INSERT INTO questions(topic_name,question,answer)VALUES(?,?,?)";
                 $stmt=$conn->prepare($query);
                 $stmt->bind_param("sss",$id,$question,$answer);
                 $stmt->execute();
                 
               

                 echo '<script>alert("Successfully added to database")</script>';
             }

                
             
         
         
        
      

             ?>


                </form>



                            
                </div>
            </div>
            
</body>
</html>
