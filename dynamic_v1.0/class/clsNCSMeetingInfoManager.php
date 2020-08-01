<?php
           
require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSMeetingInfo.php");
  
class clsNCSMeetingInfoManager
{
    //save into database
	function saveNCSMeetingInfoManager($objNCSMeetingInfoManager, $myConn=null)
	{
	   //global $_SERVER['DOCUMENT_ROOT'];
		@pg_close();
		
		$MITitle=pg_escape_string($objNCSMeetingInfoManager->getMITitle());
		$MIDate=$objNCSMeetingInfoManager->getMIDate();
		$MIPlace=pg_escape_string($objNCSMeetingInfoManager->getMIPlace());
		$MIPurpose=pg_escape_string($objNCSMeetingInfoManager->getMIPurpose());
		$SDRollId=$objNCSMeetingInfoManager->getSDRollId();
		if($_SESSION['role']=='Admin')
			$color='#FF5722';
		else
			$color='#303F9F';

		$sQuery = "insert into NCSMeetingInfo(midate, miplace, mipurpose, sdrollid, mititle,micolor) 
		values ('$MIDate','$MIPlace','$MIPurpose',$SDRollId,'$MITitle','$color')";
       // echo "ab=".$sQuery;
		$lNumTuples=0;
  
		if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
		{
			pg_query("BEGIN;") or die("could not start query\n");
			$rsltNCSMeetingInfo = pg_exec($myConn,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery);
			$lNumTuples = pg_cmdtuples($rsltNCSMeetingInfo);
			$sQuery="SELECT miid FROM ncsmeetinginfo where midate='$MIDate' and sdrollid=$SDRollId;";
			$rsltNCSMeetingId=pg_exec($myConn,$sQuery) ;
			$lNumRows=0;
			$lNumRows = pg_numrows($rsltNCSMeetingId);
			if ($lNumRows == 0)
			{
				pg_close();
				return null;
			}
		//print_r($rsltNCSStudentDetails);
        	$arrNCSMeetingId = pg_fetch_array($rsltNCSMeetingId,0);
        	$NCSMeetingId=$arrNCSMeetingId['miid'];

        	$sQuery="SELECT sdrollid FROM ncsstudentguidedetails where sdrollidguide=$SDRollId;";
			$rsltNCSStudentDetailsName=pg_exec($connection,$sQuery) ;
			$lNumRows2=0;
			$lNumRows2 = pg_numrows($rsltNCSStudentDetailsName);
			if ($lNumRows2 == 0)
			{
				pg_close();
				return null;
			}
		//print_r($rsltNCSStudentDetails);
			for ($i=0; $i <lNumRows2 ; $i++) { 
				# code...
				$arrNCSStudentDetailsName = pg_fetch_array($rsltNCSStudentDetailsName,$i);
	        	$NCSStudentDetailsSDRollId=$arrNCSStudentDetailsName['sdrollid'];

	        	$sQuery="INSERT INTO ncsmeetingdetails(miid, sdrollid) VALUES ($NCSMeetingId,$NCSStudentDetailsSDRollId);";
	        	$rsltNCSMeetingDetails = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery.$connection);
				
				$lNumTuples += pg_cmdtuples($rsltNCSMeetingInfo);
				
			}
        	if($rsltNCSMeetingInfo and$rsltNCSMeetingId and $rsltNCSMeetingDetails)
			{
				pg_query("COMMIT;") or die("COMMIT FAIL");
				return 'success';
				
			}
			else{
				pg_query("ROLLBACK;") or die("ROLLBACK IS NOT WORKING");
				return 'fail';
			}
			@pg_close();
			
		}
		else
		{
			@pg_close();
			//global $_SERVER['DOCUMENT_ROOT'];
            //echo($connection);
			require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
			pg_query("BEGIN;") or die("could not start query\n");
			
			$rsltNCSMeetingInfo = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery.$connection);
			if($_SESSION['role']!='Admin')
			{
				$lNumTuples = pg_cmdtuples($rsltNCSMeetingInfo);
				$sQuery="SELECT miid FROM ncsmeetinginfo where midate='$MIDate' and sdrollid=$SDRollId;";
				$rsltNCSMeetingId=pg_exec($connection,$sQuery) ;
				$lNumRows=0;
				$lNumRows = pg_numrows($rsltNCSMeetingId);
				if ($lNumRows == 0)
				{
					pg_close();
					return null;
				}

			//print_r($rsltNCSStudentDetails);
				$arrNCSMeetingId = pg_fetch_array($rsltNCSMeetingId,0);
	        	$NCSMeetingId=$arrNCSMeetingId['miid'];
	        	$sQuery="SELECT sdrollid FROM ncsstudentguidedetails where cdid=(select cdid from ncscounsellordetails where cifid=".$_SESSION['facid']." and sdrollid=".$_SESSION['id'].");";
				$rsltNCSStudentDetailsName=pg_exec($connection,$sQuery) ;
				$lNumRows2=0;
				$lNumRows2 = pg_numrows($rsltNCSStudentDetailsName);
				if ($lNumRows2 == 0)
				{
					pg_close();
					return null;
				}
				$rsltNCSMeetingDetails=false;
				//echo $lNumRows2;
			//print_r($rsltNCSStudentDetails);
				for ($i=0; $i <$lNumRows2 ; $i++) { 
					# code...
					$arrNCSStudentDetailsName = pg_fetch_array($rsltNCSStudentDetailsName,$i);
		        	$NCSStudentDetailsSDRollId=$arrNCSStudentDetailsName['sdrollid'];

		        	$sQuery="INSERT INTO ncsmeetingdetails(miid, sdrollid) VALUES ($NCSMeetingId,$NCSStudentDetailsSDRollId);";
		        	$rsltNCSMeetingDetails = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery.$connection);
					
					$lNumTuples += pg_cmdtuples($rsltNCSMeetingInfo);
					
				}
				if($rsltNCSMeetingInfo and $rsltNCSMeetingId and $rsltNCSMeetingDetails)
				{
					pg_query("COMMIT;") or die("COMMIT FAIL");
					return 'success';
					
				}
				else{
					pg_query("ROLLBACK;") or die("ROLLBACK IS NOT WORKING");
				}
			}
			else
			{
				if($rsltNCSMeetingInfo)
				{
					pg_query("COMMIT;") or die("COMMIT FAIL");
					return 'success';
					
				}
				else{
					pg_query("ROLLBACK;") or die("ROLLBACK IS NOT WORKING");
					return 'fail';
				}
			}
			@pg_close();
		}
    }
    //retrieve

    //delete
    function updateNCSMeetingDetails($sdrollid,$miid,$connection)
    {
    	$sQuery="UPDATE ncsmeetingdetails SET mdstatus='present' WHERE sdrollid=$sdrollid and miid=$miid;";
		$rsltNCSMeetingInfo = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery.$connection);
		if($rsltNCSMeetingInfo)
			return true;
		else
			return false;
    }

    function deleteNCSMeetingInfoManager($id)
    {
    	require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
		pg_query("BEGIN;") or die("could not start query\n");
		$sQuery="DELETE FROM ncsmeetinginfo WHERE miid=$id;";
		$rsltNCSMeetingInfo = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery.$connection);

		if($rsltNCSMeetingInfo)
		{
			pg_query("COMMIT;") or die("COMMIT FAIL");
			return 'success';	
		}
		else{
			pg_query("ROLLBACK;") or die("ROLLBACK IS NOT WORKING");
			return 'fail';
		}

    }
    
}
?>