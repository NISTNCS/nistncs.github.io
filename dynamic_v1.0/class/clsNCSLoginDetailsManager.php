<?php
           
require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSLoginDetails.php");
//require_once($_SERVER['DOCUMENT_ROOT']."/NCS/NCSSearch/class/clsNCSLoginDetailsSet.php");
  
class clsNCSLoginDetailsManager	
{
    function Save2NCSLoginDetails($objNCSLoginDetails, $myConn=null)
	{
	   //global $_SERVER['DOCUMENT_ROOT'];
		
			
		$LDUserId=$objNCSLoginDetails->getLDUserId();
		$LDPassword=$objNCSLoginDetails->getLDPassword();
		
		
        //echo "ab=".$sQuery;
  
		if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
		{
			$rsltNCSLoginDetails = pg_exec($myConn,$sQuery) or die ("Couldn't execute query in clsNCSLoginDetailsManager:SaveNCSLoginDetails".$sQuery);
			$lNumTuples = pg_cmdtuples($rsltNCSLoginDetails);
		}
		else
		{
			@pg_close();
			//global $_SERVER['DOCUMENT_ROOT'];
            //echo($connection);
            require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
			pg_query("BEGIN;") or die("could not start query\n");
            $sQuery = "INSERT INTO ncslogindetails(lduserid, ldpassword) VALUES ($LDUserId,'$LDPassword');";
			$year=$_SESSION['year'];
	    	$sQuery2="INSERT INTO ncscounsellordetails(sdrollid,cdyear) VALUES ($LDUserId,$year);";

			$rsltNCSLoginDetails = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSLoginDetailsManager:SaveNCSLoginDetails".$sQuery.$connection);
			
			$rsltNCSStudentDetails2 = pg_exec($connection,$sQuery2) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery2.$connection);

			if($rsltNCSLoginDetails and $rsltNCSStudentDetails2)
			{
				pg_query("COMMIT;") or die("COMMIT FAIL");
				return 'success';
			}
			else{
				pg_query("ROLLBACK;") or die("ROLLBACK IS NOT WORKING");
			}
			@pg_close();
		}
	return $lNumTuples;
    }
    //save into database
	function SaveNCSLoginDetails($objNCSLoginDetails, $myConn=null)
	{
	   //global $_SERVER['DOCUMENT_ROOT'];
		
			
		$LDUserId=$objNCSLoginDetails->getLDUserId();
		$LDPassword=$objNCSLoginDetails->getLDPassword();
		
		
        //echo "ab=".$sQuery;
  
		if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
		{
			$rsltNCSLoginDetails = pg_exec($myConn,$sQuery) or die ("Couldn't execute query in clsNCSLoginDetailsManager:SaveNCSLoginDetails".$sQuery);
			$lNumTuples = pg_cmdtuples($rsltNCSLoginDetails);
		}
		else
		{
			@pg_close();
			//global $_SERVER['DOCUMENT_ROOT'];
            //echo($connection);
            require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
			pg_query("BEGIN;") or die("could not start query\n");
            $sQuery = "INSERT INTO ncslogindetails(lduserid, ldpassword) VALUES ($LDUserId,'$LDPassword');";
			$sQuery1="INSERT INTO ncsstudentdetails(sdrollid) VALUES ($LDUserId);";
			$year=$_SESSION['year'];
	    	$sQuery2="INSERT INTO ncscounsellordetails(sdrollid,cdyear) VALUES ($LDUserId,$year);";

			$rsltNCSLoginDetails = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSLoginDetailsManager:SaveNCSLoginDetails".$sQuery.$connection);
			
			$rsltNCSStudentDetails1 = pg_exec($connection,$sQuery1) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery1.$connection);
			$rsltNCSStudentDetails2 = pg_exec($connection,$sQuery2) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery2.$connection);

			if($rsltNCSLoginDetails and $rsltNCSStudentDetails1 and $rsltNCSStudentDetails2)
			{
				pg_query("COMMIT;") or die("COMMIT FAIL");
				return 'success';
			}
			else{
				pg_query("ROLLBACK;") or die("ROLLBACK IS NOT WORKING");
			}
			@pg_close();
		}
	return $lNumTuples;
    }
	function updateNCSLoginDetails($LDPassword,$LDUserId, $myConn=null)
	 {      

        $sQuery = "update NCSLoginDetails set ldpassword='$LDPassword'
                   where lduserid=$LDUserId";
        //echo($sQuery);
       if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
		{
			$rsltUpdateDetails = pg_exec($myConn,$sQuery) or die ("Couldn't execute query in clsNCSLoginDetailsManager:updateNCSLoginDetails");
			$lNumTuples = pg_cmdtuples($rsltUpdateDetails);
		}
		else
		{
			@pg_close();
			//global $_SERVER['DOCUMENT_ROOT'];
			require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
			$rsltUpdateDetails = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSLoginDetailsManager:updateNCSLoginDetails");
			pg_close();
		}   
		return $rsltUpdateDetails; 
    }
	
	function deleteNCSLoginDetails($objNCSLoginDetails, $myConn=null)
	{
		//global $_SERVER['DOCUMENT_ROOT'];
        $LDUserId=$objNCSLoginDetails->getLDUserId();
		if($LDUserId==null)
			$LDUserId=null;
  
		$sQuery = "delete from NCSLoginDetails where lduserid='$LDUserId'";
        //echo($sQuery);
		if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
		{
			$rsltDeleteDetails = pg_exec($myConn,$sQuery) or die ("Couldn't execute query in clsNCSLoginDetailsManager:deleteNCSLoginDetails");
			$lNumTuples = pg_cmdtuples($rsltDeleteDetails);
		}
		else
		{
			@pg_close();
			//global $_SERVER['DOCUMENT_ROOT'];
			  require($_SERVER['DOCUMENT_ROOT']."/NCS/dbconnect.php");
			$rsltDeleteDetails = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSLoginDetailsManager:deleteNCSLoginDetails");
			$lNumTuples = pg_cmdtuples($rsltDeleteDetails);
			pg_close();
		}
	return $lNumTuples;
	}
	//retrieve
	 function retrieveNCSLoginDetails($sQuery)
    {
       // echo $sQuery;
        //global $_SERVER['DOCUMENT_ROOT'];            
	    @pg_close();
			require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
		$objNCSLoginDetails = new clsNCSLoginDetails();
		$rsltNCSLoginDetails = pg_exec($connection,$sQuery) ;
		$lNumRows=0;
		$lNumRows = pg_numrows($rsltNCSLoginDetails);
		if ($lNumRows == 0)
		{
			pg_close();
			return null;
		}
		//print_r($rsltNCSLoginDetails);
        $arrNCSLoginDetails = pg_fetch_array($rsltNCSLoginDetails,0);
		$objNCSLoginDetails->setLDUserId($arrNCSLoginDetails['lduserid']);
        $objNCSLoginDetails->setLDPassword($arrNCSLoginDetails['ldpassword']);
		$objNCSLoginDetails->setLDUserType($arrNCSLoginDetails['ldusertype']);
		$objNCSLoginDetails->setLDStatus($arrNCSLoginDetails['ldstatus']);
	//	echo	$objNCSLoginDetails->getLDStatus();

		
        pg_close();
        return $objNCSLoginDetails;            
     }
	 

 }

?>