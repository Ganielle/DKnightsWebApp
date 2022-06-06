<?php
session_start();

include 'config.php';


$update=false;
$id="";
$studentFullname="";
$studentNumber="";
$password="";
$photo="";

if(isset($_POST['add'])){
	$studentFullname=$_POST['signup_studentFullname'];
	$studentNumber=$_POST['signup_studentNumber'];
	$password=$_POST['password'];

	$photo=$_FILES['image']['name'];
	$upload="uploads/".$photo;

	$query="INSERT INTO student_crud(studentFullname,studentNumber,password,studentphoto)VALUES(?,?,?,?)";
	$stmt=$conn->prepare($query);
	$stmt->bind_param("ssss",$studentFullname,$studentNumber,$password,$upload);
	$stmt->execute();
	move_uploaded_file($_FILES['image']['tmp_name'], $upload);

	header('location:student.php');
	$_SESSION['response']="Successfully Inserted to the database!";
	$_SESSION['res_type']="success";
}
if(isset($_GET['delete'])){
	$id=$_GET['delete'];

	$sql="SELECT studentphoto FROM student_crud WHERE id=?";
	$stmt2=$conn->prepare($sql);
	$stmt2->bind_param("i",$id);
	$stmt2->execute();
	$result2=$stmt2->get_result();
	$row=$result2->fetch_assoc();

	$imagepath=$row['studentphoto'];
	unlink($imagepath);

	$query="DELETE FROM student_crud WHERE id=?";
	$stmt=$conn->prepare($query);
	$stmt->bind_param("i",$id);
	$stmt->execute();

	header('location:student.php');
	$_SESSION['response']="Successfully Deleted!";
	$_SESSION['res_type']="danger";
}
if(isset($_GET['edit'])){
	$id=$_GET['edit'];

	$query="SELECT * FROM student_crud WHERE id=?";
	$stmt=$conn->prepare($query);
	$stmt->bind_param("i",$id);
	$stmt->execute();
	$result=$stmt->get_result();
	$row=$result->fetch_assoc();

	$id=$row['id'];
	$studentFullname=$row['studentFullname'];
	$studentNumber=$row['studentNumber'];
	$password=$row['password'];
	$photo=$row['studentphoto'];

	$update=true;
}
if(isset($_POST['update'])){
	$id=$_POST['id'];
	$studentFullname=$_POST['signup_studentFullname'];
	$studentNumber=$_POST['signup_studentNumber'];
	$password=$_POST['password'];
	$oldimage=$_POST['oldimage'];

	if(isset($_FILES['image']['name'])&&($_FILES['image']['name']!="")){
		$newimage="uploads/".$_FILES['image']['name'];
		unlink($oldimage);
		move_uploaded_file($_FILES['image']['tmp_name'], $newimage);
	}
	else{
		$newimage=$oldimage;
	}
	$query="UPDATE student_crud SET studentFullname=?,studentNumber=?,password=?,studentphoto=? WHERE id=?";
	$stmt=$conn->prepare($query);
	$stmt->bind_param("ssssi",$studentFullname,$studentNumber,$password,$newimage,$id);
	$stmt->execute();

	$_SESSION['response']="Updated Successfully!";
	$_SESSION['res_type']="primary";
	header('location:student.php');
}



	if(isset($_GET['details'])){
		$id=$_GET['details'];
		$query="SELECT * FROM student_crud WHERE id=?";
		$stmt=$conn->prepare($query);
		$stmt->bind_param("i",$id);
		$stmt->execute();
		$result=$stmt->get_result();
		$row=$result->fetch_assoc();

		$vid=$row['id'];
		$studentFullname=$row['studentFullname'];
		$studentNumber=$row['studentNumber'];
		$vphoto=$row['studentphoto'];
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

				header('location:table.php');
				$_SESSION['response']="Table added successfully!";
				$_SESSION['res_type']="primary";

	}




?>