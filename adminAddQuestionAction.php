<?php
session_start();
include 'config.php';






 if(isset($_POST['add'])){
	
	$id=$_POST['addquestion'];
	$question=$_POST['newquestion'];



	$query="INSERT INTO questions(topic_name,question)VALUES(?,?)";
	$stmt=$conn->prepare($query);
	$stmt->bind_param("ss",$id,$question);
	$stmt->execute();
	


	echo "Successfully Inserted to the database!";

}


if(isset($_GET['delete'])){
	$id=$_GET['delete'];


	$query="DELETE FROM questions WHERE id=?";
	$stmt=$conn->prepare($query);
	$stmt->bind_param("i",$id);
	$stmt->execute();

	header('location:adminTopic.php');
	$_SESSION['response']="Successfully Deleted!";
	$_SESSION['res_type']="danger";
}

	

if(isset($_POST['addquest'])){ 
                 
	$id=$_POST['topic_id'];

	 $question=$_POST['newquestion'];

	$answer=$_POST['answer'];

	 $query="INSERT INTO questions(topic_name,question,answer)VALUES(?,?,?)";
	 $stmt=$conn->prepare($query);
	 $stmt->bind_param("sss",$id,$question,$answer);
	 $stmt->execute();
	 

	 header("location:adminViewQuestion.php?adminViewQuestion=$id");
	 echo '<script>alert("Successfully added to database")</script>';

	
 }





?>
