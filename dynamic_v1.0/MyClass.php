<?php
require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSLoginDetailsManager.php");
class myClass
{

	public function startreg($userid,$userpass)
	{

	    $this->objNCSLoginDetailsManager=new clsNCSLoginDetailsManager();											
		$this->objNCSLoginDetails==new clsNCSLoginDetails();
		$sQuery="select * from ncslogindetails where lduserid=$userid;";
	//	echo $sQuery;
	//	echo $userpass;
	    $row=$this->objNCSLoginDetailsManager->retrieveNCSLoginDetails($sQuery);
	    if($row==null){
	    	return   "id-error";
	    }
		else if($row->getLDPassword()==$userpass)	
		{
			$_SESSION['lduserid']=$userid;
			$_SESSION['ldpassword']=$row->getLDPassword();
			if($row->getLDUserType()=='Admin')
			return  'admin';
		    else if($row->getLDUserType()=='Student')
			return 'student';
		}
		else if($row->getLDPassword()!=$userpass)
		{
			return 'pass-error';
		}
	}

	
	public function fupdate($id,$name,$pass,$email,$fac,$batch,$mob,$branch,$photo)
	{
		$link = pg_connect("host=localhost port=5432 dbname=NCS user=postgres password=akhil123");
		if(!$link)
		{
		    die("ERROR: Could not connect. ");
		}
		#$query = "UPDATE student name='$name',pass='$pass',email='$email',batch='$batch',fac='$fac',branch='$branch',status='yes',photo='$photo' WHERE id='$id';";
		$squery="UPDATE public.ncsstudentdetails SET  sdname='$name', sdbatch='$batch', sdbranch='$branch', sdemailid='$email' WHERE sdrollid='$id';";
		$result = pg_exec($link, $query);
	    $rows=pg_affected_rows($result);
		echo $row;
	}
	
}
//$obj=new myClass();
//$obj->startreg(201510261,'Akhil123')
?>