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

	$sql="SELECT photo FROM users WHERE id=?";
	$stmt2=$conn->prepare($sql);
	$stmt2->bind_param("i",$id);
	$stmt2->execute();
	$result2=$stmt2->get_result();
	$row=$result2->fetch_assoc();


	$query="DELETE FROM users WHERE id=?";
	$stmt=$conn->prepare($query);
	$stmt->bind_param("i",$id);
	$stmt->execute();

	header('location:teacher.php');
	$_SESSION['response']="Successfully Deleted!";
	$_SESSION['res_type']="danger";
}



if(isset($_GET['teacherdetails'])){
	$id=$_GET['teacherdetails'];
	$query="SELECT * FROM users WHERE id=?";
	$stmt=$conn->prepare($query);
	$stmt->bind_param("i",$id);
	$stmt->execute();
	$result=$stmt->get_result();
	$row=$result->fetch_assoc();

	$tid=$row['id'];
	$fullname=$row['full_name'];
	$uname=$row['username'];
	$phone=$row['phone'];
	$tphoto=$row['photo'];
}
		
	

?>