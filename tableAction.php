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

	header('location:tableDetails.php');
	$_SESSION['response']="Successfully Inserted to the database!";
	$_SESSION['res_type']="success";
}








if(isset($_GET['delete'])){
	$id=$_GET['delete'];

	$sql="SELECT photo FROM $id WHERE id=?";
	$stmt2=$conn->prepare($sql);
	$stmt2->bind_param("i",$id);
	$stmt2->execute();
	$result2=$stmt2->get_result();
	$row=$result2->fetch_assoc();


	$query="DELETE FROM $id WHERE id=?";
	$stmt=$conn->prepare($query);
	$stmt->bind_param("i",$id);
	$stmt->execute();

	header('location:table.php');
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
		
	

?>