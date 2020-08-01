<?php


class clsSearchTransaction
{
	function familytree($year)
	{
		$myquery = "select t3.sdname as name,cifname as parent, t4.sdname as child from ncsstudentdetails as t4 inner join (select cifname,sdname,sdrollid from ncsstudentguidedetails inner join (select cifname,sdname,cdid from ncsstudentdetails inner join (select cifname,sdrollid,cdid from ncscounsellorinfo inner join ncscounsellordetails using(cifid) where cdyear='$year') as t1 using(sdrollid)) as t2 using(cdid)) as t3 using(sdrollid) ;
";
require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");

	    $res = pg_exec($connection,$myquery);
		
	    if ( ! $res ) {
				echo pg_last_error();
	        die;
	    }
	    
	    $data = array();
	    
	    for ($x = 0; $x < pg_numrows($res); $x++) {
	        $data[] = pg_fetch_assoc($res);
	    }
	    
	    echo json_encode($data);     
	     
	    pg_close();
	}
	function eventDetails()
	{
		 $query = "SELECT miid as id,mititle as title,midate::timestamp as date,micolor as color FROM ncsmeetinginfo UNION SELECT eno as id,etitle as title,eidate::timestamp as date, '#3E2723' as color FROM ncseventinfo;";

		require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
		$rsltNCSMeetingDetails = pg_exec($connection,$query) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery.$connection);
		 @pg_close();

		$lNumRows=0;
		$lNumRows = pg_numrows($rsltNCSMeetingDetails);
		if ($lNumRows == 0)
		{
			pg_close();
			return null;
		}
	        
	    @pg_close();
		return json_encode(pg_fetch_all($rsltNCSMeetingDetails));

	}
	function MeetingDates($id)
	{
		$query="SELECT miid,midate FROM ncsmeetinginfo where sdrollid=$id;";
		@pg_close();

		require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
		$rsltNCSMeetingDetails = pg_exec($connection,$query) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery.$connection);
		$lNumRows=0;
		$lNumRows = pg_numrows($rsltNCSMeetingDetails);
		if ($lNumRows == 0)
		{
			pg_close();
			return null;
		}
	        
	    @pg_close();
		return $rsltNCSMeetingDetails;
	}
	function displayStudentAttendance2($year,$id,$myConn=null)
	{
		$query="select sdname as studname,sdrollid as studroll from ncsstudentdetails inner join (select sdrollid from ncsstudentguidedetails where cdid=(SELECT cdid FROM ncscounsellordetails where cdyear=$year and sdrollid=$id)) as t1 using(sdrollid) ;";
		if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
		{
			$var1= pg_exec($myConn,$query) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery);
			$lNumTuples = pg_cmdtuples($rsltNCSMeetingInfo);
		}
		else
		{
			@pg_close();

			require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
			$rsltNCSMeetingDetails = pg_exec($connection,$query) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery.$connection);
			$lNumRows=0;
			$lNumRows = pg_numrows($rsltNCSMeetingDetails);
			if ($lNumRows == 0)
			{
				pg_close();
				return null;
			}
	        
	        @pg_close();
		}
		return $rsltNCSMeetingDetails;
	}
	function displayStudentAttendance($date,$id,$myConn=null)
	{
		$query="select sdrollid,sdname,mdstatus from ncsstudentdetails inner join (select sdrollid,mdstatus from ncsmeetingdetails where miid=(SELECT miid FROM ncsmeetinginfo where midate='$date' and sdrollid=$id)) as t1 using(sdrollid);";
		if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
		{
			$var1= pg_exec($myConn,$query) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery);
			$lNumTuples = pg_cmdtuples($rsltNCSMeetingInfo);
		}
		else
		{
			@pg_close();

			require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
			$rsltNCSMeetingDetails = pg_exec($connection,$query) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery.$connection);
			$lNumRows=0;
			$lNumRows = pg_numrows($rsltNCSMeetingDetails);
			if ($lNumRows == 0)
			{
				pg_close();
				return null;
			}
	        
	        @pg_close();
		}
		return $rsltNCSMeetingDetails;
	}
	function displayMeetingDetails($myConn=null)
	{
		$query="SELECT sdrollid,midate,miplace,mipurpose,mititle,sdname FROM ncsmeetinginfo inner join ncsstudentdetails using(sdrollid);";
		if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
		{
			$var1= pg_exec($myConn,$query) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery);
			$lNumTuples = pg_cmdtuples($rsltNCSMeetingInfo);
		}
		else
		{
			@pg_close();

			require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
			$rsltNCSMeetingDetails = pg_exec($connection,$query) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery.$connection);
			$lNumRows=0;
			$lNumRows = pg_numrows($rsltNCSMeetingDetails);
			if ($lNumRows == 0)
			{
				pg_close();
				return null;
			}
			#print_r($rsltNCSStudentDetails);retrieveNCSCounsellorDetailsCount($query1);
	        
	        return $rsltNCSMeetingDetails;
			@pg_close();
		}
	}
	function retieveCounts($myConn=null)
	{
		$query1="SELECT count(cifid) as facnum FROM ncscounsellorinfo;";
		$query2="SELECT count(sdrollid) as studguidenum FROM ncscounsellordetails;";
		$query3="SELECT count(sdrollid) as studnum FROM ncsstudentguidedetails;";
		
		@pg_close();	
		
		require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
		pg_query("BEGIN;") or die("could not start query\n");
		

		require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSCounsellorInfoManager.php");
		require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSCounsellorDetailsManager.php");
		require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSStudentDetailsManager.php");

		$objclsNCSCounsellorInfoManager=new clsNCSCounsellorInfoManager();
		$objclsNCSCounsellorDetailsManager=new clsNCSCounsellorDetailsManager();
		$objclsNCSStudentDetailsManager=new clsNCSStudentDetailsManager();

		$CounsellorCount=$objclsNCSCounsellorInfoManager->retrieveNCSCounsellorDetailsCount($query1);
		$StudentGuideCount=$objclsNCSCounsellorDetailsManager->retrieveNCSStudentGuideDetailsCount($query2);
		$StudentCount=$objclsNCSStudentDetailsManager->retrieveNCSStudentDetailsCount($query3);

		if(!($CounsellorCount==null or $StudentGuideCount==null or $StudentCount==null))
		{
			pg_query("COMMIT;") or die("COMMIT FAIL");
			$Count = array('counsellorNumber' => $CounsellorCount ,'studentGuideNumber'=>$StudentGuideCount,'studentNumber'=>$StudentCount);
			return $Count;			
		}
		else{
			pg_query("ROLLBACK;") or die("ROLLBACK IS NOT WORKING");
			return null;
		}
		@pg_close();


	}
	function displayStudentDetails($myConn=null)
	{
		$query="select id as studroll,name as studname,batch,branch,email,phone,sdname as studguidename from ncsstudentdetails inner join (select a.sdrollid as sdrollid,t1.sdrollid as id,sdname as name,sdbatch as batch, sdbranch as branch,sdemailid as email,sdphone as phone  from ncscounsellordetails as a inner join (select * from ncsstudentdetails inner join ncsstudentguidedetails using(sdrollid)) as t1 using(cdid) where cdyear=2017) as t2 using(sdrollid) ;";
		if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
		{
			$var1= pg_exec($myConn,$query) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery);
			$lNumTuples = pg_cmdtuples($rsltNCSMeetingInfo);
		}
		else
		{
			@pg_close();

			require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
			$rsltNCSStudentDetails = pg_exec($connection,$query) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery.$connection);
			$lNumRows=0;
			$lNumRows = pg_numrows($rsltNCSStudentDetails);
			if ($lNumRows == 0)
			{
				pg_close();
				return null;
			}
			#print_r($rsltNCSStudentDetails);
	        
	        return $rsltNCSStudentDetails;
			@pg_close();
		}


	}
	function Search($sdrollid,$myConn=null)
	{
	   $query="select t1.sdrollid,t3.sdname , t1.mdstatus,t2.midate from ncsmeetingdetails t1 left join ncsmeetinginfo t2 using(miid) left join ncsstudentdetails t3 on t3.sdrollid=t1.sdrollid";

  
		if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
		{
			$var1= pg_exec($myConn,$query) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery);
			$lNumTuples = pg_cmdtuples($rsltNCSMeetingInfo);
		}
		else
		{
			@pg_close();

			require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
			$var1 = pg_exec($connection,$query) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery.$connection);
			$lNumTuples = pg_cmdtuples($rsltNCSMeetingInfo);
			@pg_close();
		}
	return $var1;
    }
	function StudentUpdate($id,$name,$pass,$email,$fac,$batch,$branch,$phone,$myConn=null)
	{
		if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
		{
			pg_query("BEGIN;") or die("could not start query\n");
			$res1=pg_exec("UPDATE ncsstudentdetails SET  sdname='$name', sdbatch='$batch', sdbranch='$branch', sdemailid='$email' ,sdphone='$phone' WHERE sdrollid='$id';");
			$res2=pg_exec("UPDATE ncslogindetails SET  ldpassword='$pass' WHERE lduserid='$id';");
			if($res1 and $res2)
			{
				pg_query("COMMIT;") or die("COMMIT FAIL");
				
			}
			else{
				pg_query("ROLLBACK;") or die("ROLLBACK IS NOT WORKING");
			}
			@pg_close();
		}
		else
		{
			@pg_close();
			
			require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
			pg_query("BEGIN;") or die("could not start query\n");
			$res1=pg_exec($connection,"UPDATE ncsstudentdetails SET  sdname='$name', sdbatch='$batch', sdbranch='$branch', sdemailid='$email',sdphone='$phone' WHERE sdrollid='$id';");
			$res2=pg_exec($connection,"UPDATE ncslogindetails SET  ldpassword='$pass' WHERE lduserid='$id';");
			$res3=pg_exec($connection,"UPDATE ncslogindetails SET ldstatus='t' WHERE lduserid=$id;");
			$year=$_SESSION['year'];
			$res4=pg_exec($connection,"UPDATE ncscounsellordetails SET cifid=$fac WHERE sdrollid=$id and cdyear=$year");
			if($res1 and $res2 and $res3)
			{
				pg_query("COMMIT;") or die("COMMIT FAIL");
				
			}
			else{
				pg_query("ROLLBACK;") or die("ROLLNACK IS NOT WORKING");
			}
			@pg_close();
		}

	}
	function Atten($query)
	{
		if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
		{
			return pg_exec($query);
		}
		else
		{
			@pg_close();
			require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
			return pg_exec($connection,$query);
		}
	}
  
    
}
?>