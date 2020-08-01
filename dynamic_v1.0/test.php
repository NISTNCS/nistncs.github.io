<?php
	$connect=mysqli_connect("localhost","root","","database1");
	$query="SELECT * FROM tbl_emp ORDER BY ID DESC";
	$result=mysqli_query($connect,$query));
?>