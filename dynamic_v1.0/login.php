<?php
	session_start();
	function random_password( $length = 8 ) {
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    $password = substr( str_shuffle( $chars ), 0, $length );
	    return $password;
	}
	if(isset($_POST['currentcalendaryear']) && $_POST['currentcalendaryear']==true)
	{
		require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSCurrentCalendarYear.php");
		require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSCurrentCalendarYearManager.php");

		$objclsNCSCurrentCalendarYear=new clsNCSCurrentCalendarYear();
		$objclsNCSCurrentCalendarYearManager=new clsNCSCurrentCalendarYearManager();

		$objclsNCSCurrentCalendarYear->setCCYYear($_POST['changeyear']);
		if($objclsNCSCurrentCalendarYearManager->updateNCSCurrentCalendarYear($objclsNCSCurrentCalendarYear))
			echo "success";
		else
			echo "fail";

	}
	if(isset($_POST['attendance']) && $_POST['attendance']==true)
	{
		@pg_close();
		require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSMeetingInfoManager.php");
		require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
		$miid=$_POST['miid'];
		$flag=true;
		$objNCSMeetingInfoManager=new clsNCSMeetingInfoManager();
		pg_query("BEGIN;") or die("could not start query\n");
		if(isset($_POST['studattenid']))
		{
			$ids = json_decode($_POST['studattenid']);
			for($i=0;$i<sizeof($ids);$i++)
			{	

				if(!$objNCSMeetingInfoManager->updateNCSMeetingDetails($ids[$i],$miid,$connection))
				{
					$flag=false;
				}
				

			}

		}
		if($flag)
		{
			pg_query("COMMIT;") or die("COMMIT FAIL");
			echo 'success';	
		}
		else{
			pg_query("ROLLBACK;") or die("ROLLBACK IS NOT WORKING");
			echo 'fail';
		}
		pg_close();
	}

	if(isset($_POST['getstudentattendance']) && $_POST['getstudentattendance']==true)
	{
		
		$studid=$_POST['roll'];
		$date=$_POST['date'];
		require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsSearchTransaction.php");
		$objclsSearchTransaction=new clsSearchTransaction();
		$result=$objclsSearchTransaction->displayStudentAttendance($date,$studid);
		echo '<table class="table table-striped"><thead><tr><th>Roll Number</th><th>Name</th><th>Attendance</th></tr></thead><tbody>';
		while ($row = pg_fetch_assoc($result)):
        echo '<tr>';
           echo '<td>'.$row['sdrollid'].'</td>';
           echo '<td>'.$row['sdname'].'</td>';
           echo '<td>'.$row['mdstatus'].'</td>';
        echo '</tr>';
     	endwhile;
     	echo '</tbody></table>';
	}

	if(isset($_POST['addstudentfile']) && $_POST['addstudentfile']==true)
	{
		$path=$_FILES['file']['tmp_name'];
		$file = fopen($path,"r");
		$data=array();
		$list=array();
		$i=0;
		while(! feof($file))
		{
			array_push($data,fgetcsv($file));
		  	$i++;
		}
		fclose($file);
		if($_SESSION['role']=='Admin')
		{
			$flag=true;
			$existid=array();
			require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSStudentDetails.php");	
			require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSStudentDetailsManager.php");	
			
			for($j=1;$j<$i-1;$j++)
			{
				$roll=$data[$j][0];
				$objclsNCSStudentDetails=new clsNCSStudentDetails();
				$objclsNCSStudentDetailsManager=new clsNCSStudentDetailsManager();
				
				$query="SELECT * FROM ncsstudentdetails WHERE sdrollid=$roll";
				$obj=$objclsNCSStudentDetailsManager->retrieveNCSStudentDetails($query);
				if($obj==null)
				{
					require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSLoginDetails.php");
					require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSLoginDetailsManager.php");
					
					$objclsNCSLoginDetailsManager=new clsNCSLoginDetailsManager();
					$query="SELECT * FROM ncslogindetails WHERE lduserid=$roll";
					$objclsNCSLoginDetails=$objclsNCSLoginDetailsManager->retrieveNCSLoginDetails($query);
					
					if($objclsNCSLoginDetails==null)
					{
						$objclsNCSLoginDetails=new clsNCSLoginDetails();
						$pass=date('Y').random_password().substr($roll,-3);
						array_push($list,$roll.",".$pass);
						$options = array('cost'=>12);
						$password=password_hash($pass, PASSWORD_BCRYPT, $options);
						$objclsNCSLoginDetails->setLDUserId($roll);
						$objclsNCSLoginDetails->setLDPassword($password);
						if($objclsNCSLoginDetailsManager->SaveNCSLoginDetails($objclsNCSLoginDetails)=='success')
							$flag=true;
						else
							$flag=false;
					}
					else
					{
						require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSCounsellorDetailsManager.php");
						require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSCounsellorDetails.php");
						$objclsNCSCounsellorDetailsManager=new clsNCSCounsellorDetailsManager();
						$query2="SELECT cifid, sdrollid, cdid, cdyear FROM ncscounsellordetails;";
						$objclsNCSCounsellorDetails=$objclsNCSCounsellorDetailsManager->retrieveNCSCounsellorDetails($query2);
						if($objclsNCSCounsellorDetails==null)
						{
							$objclsNCSCounsellorDetails=new clsNCSCounsellorDetails();
							$objclsNCSCounsellorDetails->setSDRollId($roll);
							$objclsNCSCounsellorDetails->setCDYear($_SESSION['year']);
							if($objclsNCSCounsellorDetailsManager->SaveNCSCounsellorDetails($objclsNCSCounsellorDetails)==1)
							{
								echo "success";
								return;
							}
						}
						else
						{
							array_push($existid, $roll);
						}
					}
				}
				else
				{
					require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSLoginDetails.php");
					require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSLoginDetailsManager.php");
					
					$objclsNCSLoginDetailsManager=new clsNCSLoginDetailsManager();
					$query="SELECT * FROM ncslogindetails WHERE lduserid=$roll";
					$objclsNCSLoginDetails=$objclsNCSLoginDetailsManager->retrieveNCSLoginDetails($query);
					if($objclsNCSLoginDetails==null)
					{
						$objclsNCSLoginDetails=new clsNCSLoginDetails();
						$pass=date('Y').random_password().substr($roll,-3);
						array_push($list,$roll.",".$pass);
						$options = array('cost'=>12);
						$password=password_hash($pass, PASSWORD_BCRYPT, $options);
						$objclsNCSLoginDetails->setLDUserId($roll);
						$objclsNCSLoginDetails->setLDPassword($password);
						if($objclsNCSLoginDetailsManager->Save2NCSLoginDetails($objclsNCSLoginDetails)=='success')
							$flag=true;
						else
							$flag=false;
					}
					else
					{
						require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSCounsellorDetailsManager.php");
						require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSCounsellorDetails.php");
						$objclsNCSCounsellorDetailsManager=new clsNCSCounsellorDetailsManager();
						$query2="SELECT cifid, sdrollid, cdid, cdyear FROM ncscounsellordetails;";
						$objclsNCSCounsellorDetails=$objclsNCSCounsellorDetailsManager->retrieveNCSCounsellorDetails($query2);
						if($objclsNCSCounsellorDetails==null)
						{
							$objclsNCSCounsellorDetails=new clsNCSCounsellorDetails();
							$objclsNCSCounsellorDetails->setSDRollId($roll);
							$objclsNCSCounsellorDetails->setCDYear($_SESSION['year']);
							if($objclsNCSCounsellorDetailsManager->SaveNCSCounsellorDetails($objclsNCSCounsellorDetails)==1)
							{

								echo "success";
								return;
							}
						}
						else
						{
							array_push($existid, $roll);
						}
					}			
				}			
			}
			$file2 = fopen("doc/password.csv","w");
				foreach ($list as $line)
				{
					fputcsv($file2,explode(',',$line));
				}
				fclose($file2);
			if($flag)
				echo "success";
			else
			{
				foreach($existid as $id)
				{
					echo $id.'<br>';
				}
				echo 'These ids already exist';
				
			}
			
		}
		else
		{
			$flag=true;
			$existid=array();
			require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSStudentDetails.php");	
			require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSStudentDetailsManager.php");	
			for($j=1;$j<$i-1;$j++)
			{	
				$roll=$data[$j][0];
				$objclsNCSStudentDetails=new clsNCSStudentDetails();
				$objclsNCSStudentDetailsManager=new clsNCSStudentDetailsManager();
				$query="SELECT * FROM ncsstudentdetails WHERE sdrollid=$roll";
				$obj=$objclsNCSStudentDetailsManager->retrieveNCSStudentDetails($query);
				if($obj==null)
				{
					$objclsNCSStudentDetails->setSDRollId($roll);
					$objclsNCSStudentDetails->setSDName($data[$j][1]);
					$objclsNCSStudentDetails->setSDBatch($data[$j][2]);
					if($data[$j][3]=="")
						$data[$j][3]=" ";
					if($data[$j][4]=="")
						$data[$j][4]=" ";
					$objclsNCSStudentDetails->setSDPhone($data[$j][3]);
					$objclsNCSStudentDetails->setSDEmailId($data[$j][4]);
					$objclsNCSStudentDetails->setSDBranch($data[$j][5]);
					if($objclsNCSStudentDetailsManager->saveStudentDetails($objclsNCSStudentDetails)!='success')
					{
						$flag=false;
					}
				}
				else
				{
					$objclsNCSStudentDetails->setSDRollId($roll);
					$objclsNCSStudentDetails->setSDName($data[$j][1]);
					$objclsNCSStudentDetails->setSDBatch($data[$j][2]);
					if($data[$j][3]=="")
						$data[$j][3]=" ";
					if($data[$j][4]=="")
						$data[$j][4]=" ";
					$objclsNCSStudentDetails->setSDPhone($data[$j][3]);
					$objclsNCSStudentDetails->setSDEmailId($data[$j][4]);
					$objclsNCSStudentDetails->setSDBranch($data[$j][5]);
					if($objclsNCSStudentDetailsManager->updateStudentDetailsManager($objclsNCSStudentDetails)!='success')
					{
						$flag=false;
					}
				}
			}
			if($flag)
			{
				echo 'success';
			}
			else
			{
				echo 'fail';
			}

		}
	}
	if(isset($_POST['addstudent']) && $_POST['addstudent']==true)
	{
		require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSStudentDetails.php");	
		require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSStudentDetailsManager.php");	
		$objclsNCSStudentDetails=new clsNCSStudentDetails();
		$objclsNCSStudentDetailsManager=new clsNCSStudentDetailsManager();
		$objclsNCSStudentDetails->setSDRollId($_POST['roll']);
		if($_SESSION['role']!='Admin')
		{
			$objclsNCSStudentDetails->setSDName($_POST['name']);
			$objclsNCSStudentDetails->setSDBatch($_POST['batch']);
			$objclsNCSStudentDetails->setSDPhone($_POST['phone']);
			$objclsNCSStudentDetails->setSDEmailId($_POST['email']);
			$objclsNCSStudentDetails->setSDBranch($_POST['branch']);
			if($objclsNCSStudentDetailsManager->saveStudentDetails($objclsNCSStudentDetails)=='success')
				echo 'success';
			else
				echo 'fail';
		}
		else
		{
			$roll=$_POST['roll'];
			$password=date('Y').random_password().substr($_POST['roll'],-3);
			require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSLoginDetails.php");
			require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSLoginDetailsManager.php");
			$objclsNCSLoginDetails=new clsNCSLoginDetails();
			$objclsNCSLoginDetailsManager=new clsNCSLoginDetailsManager();
			$objclsNCSLoginDetails->setLDUserId($roll);
			$objclsNCSLoginDetails->setLDPassword($password);
			if($objclsNCSLoginDetailsManager->SaveNCSLoginDetails($objclsNCSLoginDetails)=='success')
				echo 'success';
			else
				echo 'fail';
			
		}
	}
	if(isset($_POST['meeting']) && $_POST['meeting']==true)
	{
		require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSMeetingInfo.php");
		$objclsNCSMeetingInfo=new clsNCSMeetingInfo();
		$objclsNCSMeetingInfo->setSDRollId($_POST['id']);
		$objclsNCSMeetingInfo->setMITitle($_POST['title']);
		$objclsNCSMeetingInfo->setMIDate($_POST['date']);
		$objclsNCSMeetingInfo->setMIPlace($_POST['place']);
		$objclsNCSMeetingInfo->setMIPurpose($_POST['about']);

		require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSMeetingInfoManager.php");
		$objclsNCSMeetingInfoManager=new clsNCSMeetingInfoManager();
		$res=$objclsNCSMeetingInfoManager->saveNCSMeetingInfoManager($objclsNCSMeetingInfo);
		echo $res;
	}
	if(isset($_POST['event']) && $_POST['event']==true)
	{

		$date=$_POST['date'];
		$title=$_POST['name'];
		$place=$_POST['place'];
		$about=$_POST['about'];
		require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSEventInfoManager.php");
		require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSEventInfo.php");
		$objclsNCSEventInfo=new clsNCSEventInfo();
		$objclsNCSEventInfoManager=new clsNCSEventInfoManager();
		$objclsNCSEventInfo->setEIDate($date);
		$objclsNCSEventInfo->setEITitle($title);
		$objclsNCSEventInfo->setEIPlace($place);
		$objclsNCSEventInfo->setEIPurpose($about);
		$EINo=$objclsNCSEventInfoManager->SaveNCSEventInfoManager($objclsNCSEventInfo);
		if($EINo!=null)
		{
			if(!empty($_FILES))
			{
				$tempPath=$_FILES['photo']['tmp_name'];
				#echo $tempPath;
				$uploadPath="../eventpic/".$EINo.".jpg";
				#echo $uploadPath;
				move_uploaded_file($tempPath, $uploadPath);
				
				
			}
			else
			{
				copy("../eventpic/nofilefound.jpg", "../eventpic/".$EINo.".jpg");
			}
			echo 'success';
		}
		else
		{
			echo "fail";
		}

		
	}
	if(isset($_POST['update']) && $_POST['update']==true)
	{
		
		
		if($_SESSION['role']!='Admin'){
			require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSStudentDetails.php");
			$objclsNCSStudentDetails=new clsNCSStudentDetails();
			
			$objclsNCSStudentDetails->setSDRollId($_SESSION['id']);
			if($_POST['name']=="")
				$objclsNCSStudentDetails->setSDName($_SESSION['name']);
			else
				$objclsNCSStudentDetails->setSDName($_POST['name']);
			if($_POST['email']=="")
				$objclsNCSStudentDetails->setSDEmailId($_SESSION['email']);
			else
				$objclsNCSStudentDetails->setSDEmailId($_POST['email']);
			if($_POST['batch']=="")
				$objclsNCSStudentDetails->setSDBatch($_SESSION['batch']);
			else
				$objclsNCSStudentDetails->setSDBatch($_POST['batch']);
			if($_POST['phone']=="")
				$objclsNCSStudentDetails->setSDPhone($_SESSION['phone']);
			else
				$objclsNCSStudentDetails->setSDPhone($_POST['phone']);
			if($_POST['branch']=="")
				$objclsNCSStudentDetails->setSDBranch($_SESSION['branch']);
			else
				$objclsNCSStudentDetails->setSDBranch($_POST['branch']);
			require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSStudentDetailsManager.php");
			$objclsNCSStudentDetailsManager=new clsNCSStudentDetailsManager();
			
			if($objclsNCSStudentDetailsManager->updateStudentDetailsManager($objclsNCSStudentDetails)=='success')
			{
				if(!empty($_FILES))
				{
					$tempPath=$_FILES['photo']['tmp_name'];
					#echo $tempPath;
					$uploadPath="../upload/".$objclsNCSStudentDetails->getSDRollId().".jpg";
					#echo $uploadPath;
					move_uploaded_file($tempPath, $uploadPath);
					
				}
				if($_POST['password']!="")
				{
					require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSLoginDetailsManager.php");
					$objclsNCSLoginDetailsManager=new clsNCSLoginDetailsManager();
					$options = array('cost'=>12);
						$password=password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
					if($objclsNCSLoginDetailsManager->updateNCSLoginDetails($password,$_SESSION['id']))
					{
						$fac=$_SESSION['fac'];
						$role=$_SESSION['role'];
						$cur_year=$_SESSION['year'];
						session_destroy();
						session_start();
						
						$_SESSION['ncs']=true;
						$_SESSION['role']=$role;
						$_SESSION['id']=$objclsNCSStudentDetails->getSDRollId();
						$_SESSION['name']=$objclsNCSStudentDetails->getSDName();
						$_SESSION['batch']=$objclsNCSStudentDetails->getSDBatch();
						$_SESSION['branch']=$objclsNCSStudentDetails->getSDBranch();
						$_SESSION['fac']=$fac;
						$_SESSION['phone']=$objclsNCSStudentDetails->getSDPhone();
						$_SESSION['email']=$objclsNCSStudentDetails->getSDEmailId();
						$_SESSION['year']=$cur_year;
						echo 'success';

					}
					else
					{
						echo 'fail';
						return;
					}
				}
				else
				{
					$fac=$_SESSION['fac'];
					$role=$_SESSION['role'];
					$cur_year=$_SESSION['year'];
						session_destroy();
						session_start();
						$_SESSION['ncs']=true;
						$_SESSION['role']=$role;
						$_SESSION['id']=$objclsNCSStudentDetails->getSDRollId();
						$_SESSION['name']=$objclsNCSStudentDetails->getSDName();
						$_SESSION['batch']=$objclsNCSStudentDetails->getSDBatch();
						$_SESSION['branch']=$objclsNCSStudentDetails->getSDBranch();
						$_SESSION['fac']=$fac;
						$_SESSION['phone']=$objclsNCSStudentDetails->getSDPhone();
						$_SESSION['email']=$objclsNCSStudentDetails->getSDEmailId();
						$_SESSION['year']=$cur_year;
					echo 'success';
				}
			}	
			else
			{
				echo 'fail';
			}
		}
		else
		{
			require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSCounsellorInfo.php");
			$objclsNCSCounsellorInfo=new clsNCSCounsellorInfo();
			
			$objclsNCSCounsellorInfo->setCIFid($_SESSION['id']);
			if($_POST['name']=="")
				$objclsNCSCounsellorInfo->setCIName($_SESSION['name']);
			else
				$objclsNCSCounsellorInfo->setCIName($_POST['name']);
			if($_POST['email']=="")
				$objclsNCSCounsellorInfo->setCIEmailId($_SESSION['email']);
			else
				$objclsNCSCounsellorInfo->setCIEmailId($_POST['email']);
			if($_POST['phone']=="")
				$objclsNCSCounsellorInfo->setCIContact($_SESSION['phone']);
			else
				$objclsNCSCounsellorInfo->setCIContact($_POST['phone']);

			require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSCounsellorInfoManager.php");
			$objclsNCSCounsellorInfoManager=new clsNCSCounsellorInfoManager();
			
			if($objclsNCSCounsellorInfoManager->updateCounsellorInfoManager($objclsNCSCounsellorInfo)=='success')
			{
				if(!empty($_FILES))
				{
					$tempPath=$_FILES['photo']['tmp_name'];
					#echo $tempPath;
					$uploadPath="../upload/".$objclsNCSCounsellorInfo->getCIFid().".jpg";
					#echo $uploadPath;
					move_uploaded_file($tempPath, $uploadPath);
					
				}
				if($_POST['password']!="")
				{
					require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSLoginDetailsManager.php");
					$objclsNCSLoginDetailsManager=new clsNCSLoginDetailsManager();
					$options = array('cost'=>12);
					
						$password=password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
					if($objclsNCSLoginDetailsManager->updateNCSLoginDetails($password,$_SESSION['id']))
					{
						$role=$_SESSION['role'];
						$cur_year=$_SESSION['year'];
						
						session_destroy();
						session_start();
						$_SESSION['ncs']=true;
						$_SESSION['role']=$role;
						$_SESSION['id']=$objclsNCSCounsellorInfo->getCIFid();
						$_SESSION['name']=$objclsNCSCounsellorInfo->getCIName();
						$_SESSION['phone']=$objclsNCSCounsellorInfo->getCIContact();
						$_SESSION['email']=$objclsNCSCounsellorInfo->getCIEmailId();
						$_SESSION['year']=$cur_year;
						echo 'success';

					}
					else
					{
						echo 'fail';
						return;
					}
				}
				else
				{
					$role=$_SESSION['role'];
					$cur_year=$_SESSION['year'];
						
						session_destroy();
						session_start();
						$_SESSION['ncs']=true;
						$_SESSION['role']=$role;
						$_SESSION['id']=$objclsNCSCounsellorInfo->getCIFid();
						$_SESSION['name']=$objclsNCSCounsellorInfo->getCIName();
						$_SESSION['phone']=$objclsNCSCounsellorInfo->getCIContact();
						$_SESSION['email']=$objclsNCSCounsellorInfo->getCIEmailId();
						$_SESSION['year']=$cur_year;
						
						echo 'success';
				}
			}	
			else
			{
				echo 'fail';
			}	
		}

		
	}
	if(isset($_POST['login']) && $_POST['login']==true)
	{
		$id=$_POST['name'];
		$pass=$_POST['password'];		
		require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSLoginDetailsManager.php");
		$objclsNCSLoginDetailsManager=new clsNCSLoginDetailsManager();
		$sQuery="select * from ncslogindetails where lduserid=$id;";
		//echo $sQuery;
		$objclsNCSLoginDetails=$objclsNCSLoginDetailsManager->retrieveNCSLoginDetails($sQuery);
		//echo "HELLO";
		//echo $objclsNCSLoginDetails->getLDPassword();
		
		if($objclsNCSLoginDetails==null)
		{
			echo 'Incorrect ID!! Please Try Again......';
		}
		
		else if(password_verify($pass,$objclsNCSLoginDetails->getLDPassword()))
		{
			$_SESSION['role']=$objclsNCSLoginDetails->getLDUserType();
			
			require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSCurrentCalendarYearManager.php");
			$objclsNCSCurrentCalendarYearManager=new clsNCSCurrentCalendarYearManager();
			$objclsNCSCurrentCalendarYear=$objclsNCSCurrentCalendarYearManager->retieveNCSCurrentCalendarYear();
			$_SESSION['year']=$objclsNCSCurrentCalendarYear->getCCYYear();
			
			if($objclsNCSLoginDetails->getLDUserType()=='Admin')
			{
				require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSCounsellorInfoManager.php");
				$objclsNCSCounsellorInfoManager= new clsNCSCounsellorInfoManager();
				$query="select * from ncscounsellorinfo where cifid=$id;";
				$objclsNCSCounsellor=$objclsNCSCounsellorInfoManager->retrieveNCSCounsellorInfo($query);
				$_SESSION['id']=$id;
				$_SESSION['ncs']=true;
				$_SESSION['name']=$objclsNCSCounsellor->getCIName();
				$_SESSION['phone']=$objclsNCSCounsellor->getCIContact();
				$_SESSION['email']=$objclsNCSCounsellor->getCIEmailId();

		
				echo 'admin';
			}
			else
			{
				if($objclsNCSLoginDetails->getLDStatus()=='t')
				{
					require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSStudentDetailsManager.php");
					$objclsNCSStudentDetailsManager= new clsNCSStudentDetailsManager();
					$objclsNCSStudentDetails=$objclsNCSStudentDetailsManager->retrieveStudentDetailManager($id,$_SESSION['year']);
					$_SESSION['ncs']=true;
					$_SESSION['id']=$id;
					$_SESSION['name']=$objclsNCSStudentDetails->getSDName();
					$_SESSION['batch']=$objclsNCSStudentDetails->getSDBatch();
					$_SESSION['branch']=$objclsNCSStudentDetails->getSDBranch();
					$_SESSION['fac']=$objclsNCSStudentDetails->getSDCounsellorName();
					$_SESSION['phone']=$objclsNCSStudentDetails->getSDPhone();
					$_SESSION['email']=$objclsNCSStudentDetails->getSDEmailId();
					$_SESSION['facid']=$objclsNCSStudentDetails->getSDCounsellorId();
			
					echo 'studentreg';
				}
				else
				{
					$_SESSION['lduserid']=$id;
					echo 'studentnotreg';
				}
			}
		}
		else
		{
			echo 'Incorrect Password!! Please Try Again......';
		}
	}
?>