<?php
	require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSMeetingInfoManager.php");
	if(isset($_POST['id']))
	{
		$id=$_POST['id'];
		$clsNCSMeetingInfoManager=new clsNCSMeetingInfoManager();
		if($clsNCSMeetingInfoManager->deleteNCSMeetingInfoManager($id)=='success')
			echo 'success';
		else
			echo 'fail';

	}
?>