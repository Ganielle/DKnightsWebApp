<?php

include 'action.php';


if (!isset($_COOKIE["user_id"])) {
    header("Location: index.php");
}


include 'config.php';

define('DB_HOST', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'wordlabdatabase');


$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$query = sprintf("SELECT topic_id, enrolled,month,year,pass_percentage,fail_percentage FROM progress_table GROUP BY year DESC");
$result = $mysqli->query($query);



if(isset($_POST["year"]))
{
 $query = "
 SELECT * FROM progress_table
 WHERE year = '".$_POST["year"]."' 
 ORDER BY id ASC
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  $output[] = array(
   'month'   => $row["month"],
 
  );
 }
 echo json_encode($output);
}

?>







<!DOCTYPE html>
<html>
  <head>
    <title>ChartJS - BarGraph</title>
    <style type="text/css">
      #chart-container {
        width: 640px;
        height: auto;
      }
    </style>
  </head>
  <body>
    <div id="chart-container">
      <canvas id="mycanvas"></canvas>




                            <select name="year" class="form-control" id="year">
                                <option value="">Select Year</option>
                            <?php
                            foreach($result as $row)
                            {
                                echo '<option value="'.$row["year"].'">'.$row["year"].'</option>';
                            }
                            ?>
                            </select>




    </div>

    
    <!-- javascript -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/Chart.min.js"></script>
    <script type="text/javascript" src="js/app.js"></script>

    
  </body>
</html>