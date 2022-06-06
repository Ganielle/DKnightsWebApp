<?php

include 'action.php';


if (!isset($_SESSION["user_id"]) || !isset($_COOKIE['user_id'])) {
    header("Location: adminIndex.php");
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
            

                    
                
                    <a href="adminWelcome.php"><i class="fas fa-home"></i><span>Dashboard</span></a>
                    <a href="adminStudent.php"><i class="fas fa-user-graduate"></i><span>Students</span></a>
                    <a href="adminTeacher.php"><i class="fas fa-chalkboard-teacher"></i><span>Teachers</span></a>
                    <a href="adminTopic.php"><i class="fas fa-table"></i><span>Topic List</span></a>
                  
                    
                    

   
                    

            </div>
                

            <div class="content">
            <div class="dashboardcontainer">
           
            <br />  
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                    <div class="col-md-12 mt-3">
                <h3 class="text-center">Progress Table</h3>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Topic name</label>
                            </div>
                            <select class="custom-select" id="select_tpn">
                                <option value="">Choose...</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                    <button id="filter" class="btn btn-sm btn-outline-light">Filter</button>
                    <button id="reset" class="btn btn-sm btn-outline-light">Reset</button>
                    </div>
                  
                </div>
               
                
            </div>
                    </div>
                </div>
                <div class="panel-body">
                       
                        <div id="chart_area" style="width: 100%; height: 498px;"></div>
                       
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


function fetch_tpn() {
        $.ajax({
            url: "fetch_std.php",
            type: "post",
            dataType: "json",
            success: function(data) {
                var tpnBody = "";
                for (var key in data) {
                    tpnBody += `<option value="${data[key]['TABLE_NAME']}">${data[key]['TABLE_NAME']}</option>`;
                }
                $("#select_tpn").append(tpnBody);
            }
        });
    }
    fetch_tpn();



    // Fetch Result


    // Fetch Records
    function fetch(tpn) {
        $.ajax({
            url: "records.php",
            type: "post",
            data: {
                tpn: tpn
              
               
               
                
            },
            dataType: "json",
            cache: false,
            success: function(data) {
                drawMonthwiseChart(data);
                
            }
        });
    }
    fetch();


    function drawMonthwiseChart(data, chart_main_title)
{

    
    window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location;
        window.location.reload();
    }
}
  

    var jsonData = data;
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Month');
    data.addColumn('number', 'Pass');
    data.addColumn('number', 'Fail');
    $.each(jsonData, function(i, jsonData){
        var month = jsonData.month;
        var PASS = parseFloat($.trim(jsonData.PASS));
        var FAIL = parseFloat($.trim(jsonData.FAIL));
        data.addRows([[month,PASS,FAIL]]);
    });
   

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_area'));
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
            
            minValue: 0,
            maxValue: 100,
            format: '#\'%\''
            
            
        }
    };


  var view = new google.visualization.DataView(data);
  view.setRows(rows);

  var chartSort = new google.visualization.ColumnChart(document.getElementById('chart_area'));
  chartSort.draw(view,options);

  

}

    // Filter

    $(document).on("click", "#filter", function(e) {
        e.preventDefault();

        var tpn= $("#select_tpn").val();
        

        if (tpn !== "") {
            $('#record_table').DataTable().destroy();
            fetch(tpn);
        } else {
            $('#record_table').DataTable().destroy();
            fetch();
        }
    });

 


    // Reset

    $(document).on("click", "#reset", function(e) {
        e.preventDefault();

        $("#select_tpn").html(`<option value="">Choose...</option>`);

        $('#record_table').DataTable().destroy();
        fetch(0);
        fetch_tpn();
       
    });
    </script>
</script>





