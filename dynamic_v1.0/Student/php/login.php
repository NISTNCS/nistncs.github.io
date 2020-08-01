<?php
require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsSearchTransaction.php");

$objStudent=new clsSearchTransaction();
session_start();
	$id=$_SESSION['lduserid'];
	$name=$_POST['name'];
	$email=$_POST['email'];
	$fac=$_POST['fac'];
	$batch=$_POST['batch'];
	$phone=$_POST['mobile'];
	$branch=$_POST['branch'];
	$password=$_POST['password'];
	$options = [
						    'cost' => 12,
						];
	$pass=password_hash($password, PASSWORD_BCRYPT, $options);
	$uploadPath="";
	if(!empty($_FILES))
	{
		$tempPath=$_FILES['photo']['tmp_name'];
		#echo $tempPath;
		$uploadPath=$_SERVER['DOCUMENT_ROOT']."/upload/".$id.".jpg";
		#echo $uploadPath;
		move_uploaded_file($tempPath, $uploadPath);
		
	}
	
	$objStudent->StudentUpdate($id,$name,$pass,$email,$fac,$batch,$branch,$phone,null);
	
	echo "success";

?>