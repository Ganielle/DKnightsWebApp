<?php
session_start();
include 'config.php';

$update=false;
$id="";
$teachersName="";
$teachersId="";		
$tphoto="";


if(isset($_GET['delete'])){
	$id=$_GET['delete'];

	$sql="SELECT photo FROM teachers_crud WHERE id=?";
	$stmt2=$conn->prepare($sql);
	$stmt2->bind_param("i",$id);
	$stmt2->execute();
	$result2=$stmt2->get_result();
	$row=$result2->fetch_assoc();


	$query="DELETE FROM teachers_crud WHERE id=?";
	$stmt=$conn->prepare($query);
	$stmt->bind_param("i",$id);
	$stmt->execute();

	header('location:teachersTeacher.php');
	$_SESSION['response']="Successfully Deleted!";
	$_SESSION['res_type']="danger";
}



if(isset($_GET['teachersTeacherDetails'])){
	$id=$_GET['teachersTeacherDetails'];
	$query="SELECT * FROM teachers_crud WHERE id=?";
	$stmt=$conn->prepare($query);
	$stmt->bind_param("i",$id);
	$stmt->execute();
	$result=$stmt->get_result();
	$row=$result->fetch_assoc();

	$tid=$row['id'];
	$teachersName=$row['teachersName'];
	$teachersId=$row['teachersId'];
	$tphoto=$row['photo'];
}
		
	

?>