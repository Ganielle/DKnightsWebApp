<?php
session_start();
include 'config.php';

$update=false;
$id="";
$name="";
$email="";
$phone="";
$photo="";


$studentFullname="";
$studentNumber="";
$password="";
$photo="";

if(isset($_POST['add'])){
	$id=$_GET['tableName'];
	$studentFullname=$_POST['signup_studentFullname'];
	$studentNumber=$_POST['signup_studentNumber'];
	$password=$_POST['password'];

	$photo=$_FILES['image']['name'];
	$upload="uploads/".$photo;

	$query="INSERT INTO $id(studentFullname,studentNumber,password,photo)VALUES(?,?,?,?)";
	$stmt=$conn->prepare($query);
	$stmt->bind_param("ssss",$studentFullname,$studentNumber,$password,$upload);
	$stmt->execute();
	move_uploaded_file($_FILES['image']['tmp_name'], $upload);

	header('location:teachersTopicDetails.php');
	$_SESSION['response']="Successfully Inserted to the database!";
	$_SESSION['res_type']="success";
}








if(isset($_GET['delete'])){
	$id=$_GET['delete'];


	$query="DROP TABLE $id;";
	$stmt=$conn->prepare($query);
	$stmt->execute();

	header('location:teachersTopic.php');
	$_SESSION['response']="Successfully Deleted!";
	$_SESSION['res_type']="danger";
}



if(isset($_GET['tabledetails'])){
	$id=$_GET['tabledetails'];
	$query="SELECT * $id ";
	$stmt=$conn->prepare($query);
	$stmt->bind_param("i",$id);
	$stmt->execute();
	$result=$stmt->get_result();
	$row=$result->fetch_assoc();



	$id=$row['id'];
	$student_name=$row['student_name'];
	$topic_name=$row['topic_name'];
	$status=$row['status'];
	
}
		



if (isset($_POST["Ctable"])) {


	$tableName = $_POST['tableName'];
	$query = "CREATE TABLE $tableName (
		`id` int(11) NOT NULL,
		`studentFullname` varchar(255) NOT NULL,
		`studentNumber` varchar(255) NOT NULL,
		`month` varchar(255) NOT NULL,
		`status` varchar(255) NOT NULL
	  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$stmt=$conn->prepare($query);
		$stmt->execute();
		$result=$stmt->get_result();

			header('location:teachersTopic.php');
			$_SESSION['response']="Table added successfully!";
			$_SESSION['res_type']="primary";

}

	

?>