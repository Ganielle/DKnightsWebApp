<?php
session_start();
include 'config.php';





if(isset($_POST['delete'])){
	$id=$_GET["$row"];
 

	$query="DELETE FROM questions WHERE id=?";
	$stmt=$conn->prepare($query);
	$stmt->bind_param("i",$id);
	$stmt->execute();

	header('location:teachersViewQuestion.php');
	$_SESSION['response']="Successfully Deleted!";
	$_SESSION['res_type']="danger";
}


	
	

?>