<?php
	require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsSearchTransaction.php");
	$objclsSearchTransaction=new clsSearchTransaction();
	echo $objclsSearchTransaction->eventDetails();		
?>