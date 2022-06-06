<?php


include 'action.php';


if (!isset($_COOKIE["id"])) {
    header("Location: teacherIndex.php");
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
        $sql = "UPDATE teachers_crud SET  photo='$photo_new_name' WHERE id='{$_SESSION["id"]}'";
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
            
            $sql = "SELECT * FROM teachers_crud WHERE id='{$_SESSION["id"]}'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
           
            <div class="inputBox">
                <img src="image/selectphoto.svg" alt="" class="select-profile">
                <input type="file" accept="image/*" id="photo" name="photo" class="form-control-file" value="This is some text" required>
            </div>
            <img src="ProfileUploads/<?php echo $row["photo"]; ?>" class="profile-img"   alt="">
            <p><?php echo $row['teachersName']; ?></p>
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
            

                    
                
                    <a href="teachersWelcome.php"><i class="fas fa-home"></i><span>Dashboard</span></a>
                    <a href="teachersStudent.php"><i class="fas fa-user-graduate"></i><span>Students</span></a>
                    <a href="teachersTeacher.php"><i class="fas fa-chalkboard-teacher"></i><span>Teachers</span></a>
                    <a href="teachersTopic.php"><i class="fas fa-table"></i><span>Topic List</span></a>
                  
            </div>


  


  
    <div class="content">
        <div class="studentdetailscontainer" >
    
                                    
            <h2 class="bg-light p-0 rounded text-left text-dark"  style=" width: 330px;">ID : <?= $vid; ?></h2>
                <div class="img-left">
                    <img src="<?= $vphoto; ?>" width="330" height="330" class="student-img">
                </div>
                    <h5 class="text-light">Name : <?= $studentFullname; ?></h5>
                    <h5 class="text-light">Student Number : <?= $studentNumber; ?></h5>                                       
                        <div class="Schart">
                                        
                            <div class="input-group-prepend"  style=" width: 330px;">
                                
                            </div>
                            <div id="Schart_area" style=" width: 850px; height:450px;   "></div>
                        </div>
        </div>
    </div>
    







           
        
</body>
</html>

  <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"
        integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/r-2.2.3/datatables.min.js"></script>

    <!-- Moment Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback();


    function fetch_Syrs() {
        $.ajax({
            url: "fetch_Syrs.php",
            type: "post",
            dataType: "json",
            success: function(data) {
                var SyrsBody = "";
                for (var key in data) {
                  SyrsBody += `<option value="${data[key]['year']}">${data[key]['year']}</option>`;
                }
                $("#select_Syrs").append(SyrsBody);
            }
        });
    }
    fetch_Syrs();



    function fetch(Syrs) {
        $.ajax({
            url: "Srecords.php",
            type: "post",
            data: {
                Syrs: Syrs
               
               
                
            },
            dataType: "json",
            cache: false,
            success: function(data) {
                drawStudentChart(data);
                
            }
        });
    }
    fetch(0);


    function drawStudentChart(data, chart_main_title)
{

    window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location + '#loaded';
        window.location.reload();
    }
}
  

    var jsonData = data;
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Month');
    data.addColumn('number', 'Average');
    
    $.each(jsonData, function(i, jsonData){
        var month = jsonData.month;
        var average = parseFloat($.trim(jsonData.average));
        
        data.addRows([[month, average]]);
    });
   

    var chart = new google.visualization.ColumnChart(document.getElementById('Schart_area'));
    chart.draw(data, options);

    // sort rows by month name chronologically
  var monthOrder = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
  ];
  var rows = data.getSortedRows([{column: 0}]);
  rows.sort(function (a, b) {
    var monthA = data.getValue(a, 0);
    var monthB = data.getValue(b, 0);
    return monthOrder.indexOf(monthA) - monthOrder.indexOf(monthB);
  });
  var options = {
        title:chart_main_title,
        
        hAxis: {
            title: "Months"
            
        },
        vAxis: {
            width:400,
            height:300,
            minValue: 0,
            maxValue: 100,
            format: '#\'%\''
            
            
        }
    };


  var view = new google.visualization.DataView(data);
  view.setRows(rows);

  var chartSort = new google.visualization.ColumnChart(document.getElementById('Schart_area'));
  chartSort.draw(view,options);

  

}


$(document).on("click", "#filter", function(e) {
        e.preventDefault();

        
        var Syrs= $("#select_Syrs").val();

        if (Syrs !== "") {
            $('#record_table').DataTable().destroy();
            fetch(Syrs);

        } else {
            $('#record_table').DataTable().destroy();
            fetch(0);
        }
    });

 


    // Reset

    $(document).on("click", "#reset", function(e) {
        e.preventDefault();

      
        $("#select_Syrs").html(`<option value="">Choose...</option>`);

        $('#record_table').DataTable().destroy();
        fetch(0);
        fetch_Syrs();
    });
    </script>
</script>
