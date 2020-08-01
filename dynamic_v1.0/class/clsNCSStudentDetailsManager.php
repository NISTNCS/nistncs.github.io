<?php
           
require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSStudentDetails.php");
  
class clsNCSStudentDetailsManager
{
    //save into database
    function retrieveNCSStudentDetailsCount($sQuery)
    {
		require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
		$rsltNCSStudentDetails = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:retrieveNCSCounsellorDetails.");
		$lNumRows = pg_numrows($rsltNCSStudentDetails);
		if($lNumRows == 0)
		{	
			pg_close();
			return null ;
		}
		$arrNCSStudentDetails=pg_fetch_array($rsltNCSStudentDetails,0);
		return $arrNCSStudentDetails['studnum'];

            
    }
    function retrieveNCSStudentDetails($sQuery)
    {
    	require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
		$rsltNCSStudentDetails = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:retrieveNCSCounsellorDetails.");
		$lNumRows = pg_numrows($rsltNCSStudentDetails);
		if($lNumRows == 0)
		{	
			pg_close();
			return null ;
		}
		$arrNCSStudentDetails=pg_fetch_array($rsltNCSStudentDetails,0);
		return 1;
		pg_close();

    }
	function retrieveStudentDetailManager($id,$year)
	{
		@pg_close();
		require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
		$objNCSStudentDetails = new clsNCSStudentDetails();
		
		$sQuery="SELECT sdrollid,sdname,sdbatch,sdbranch,sdemailid,sdphone,cifname,cifid from ncscounsellorinfo inner join (SELECT * from ncsstudentdetails inner join ncscounsellordetails using(sdrollid) where cdyear=$year) as t1 using(cifid) where sdrollid=$id;";
		$rsltNCSStudentDetails=pg_exec($connection,$sQuery) ;
		$lNumRows=0;
		$lNumRows = pg_numrows($rsltNCSStudentDetails);
		if ($lNumRows == 0)
		{
			pg_close();
			return null;
		}
        $arrNCSStudentDetails = pg_fetch_array($rsltNCSStudentDetails,0);
        $objNCSStudentDetails->setSDRollId($arrNCSStudentDetails['sdrollid']);
        $objNCSStudentDetails->setSDName($arrNCSStudentDetails['sdname']);
		$objNCSStudentDetails->setSDBatch($arrNCSStudentDetails['sdbatch']);
		$objNCSStudentDetails->setSDBranch($arrNCSStudentDetails['sdbranch']);
		$objNCSStudentDetails->setSDEmailId($arrNCSStudentDetails['sdemailid']);
		$objNCSStudentDetails->setSDPhone($arrNCSStudentDetails['sdphone']);
		$objNCSStudentDetails->setSDCounsellorName($arrNCSStudentDetails['cifname']);
		$objNCSStudentDetails->setSDCounsellorId($arrNCSStudentDetails['cifid']);
	
		
        pg_close();
        return $objNCSStudentDetails;	
	}

	function saveStudentDetails($objclsNCSStudentDetails,$myConn=null)
	{
		$SDRollID=$objclsNCSStudentDetails->getSDRollId();
		$SDName=$objclsNCSStudentDetails->getSDName();
		$SDBatch=$objclsNCSStudentDetails->getSDBatch();
		$SDPhone=$objclsNCSStudentDetails->getSDPhone();
		$SDEmailId=$objclsNCSStudentDetails->getSDEmailId();
		$SDBranch=$objclsNCSStudentDetails->getSDBranch();
		$SDRollIdGuide=$_SESSION['id'];

		@pg_close();
			//global $_SERVER['DOCUMENT_ROOT'];
            //echo($connection);
		require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
		pg_query("BEGIN;") or die("could not start query\n");
		
		$sQuery1="INSERT INTO ncsstudentdetails(sdrollid, sdname, sdbatch, sdbranch, sdemailid, sdphone)
    VALUES ($SDRollID, '$SDName', $SDBatch, '$SDBranch', '$SDEmailId', '$SDPhone');";
    	$sQuery2="INSERT INTO ncsstudentguidedetails(cdid,sdrollid) SELECT cdid,$SDRollID from ncscounsellordetails where sdrollid=$SDRollIdGuide;";

		$rsltNCSStudentDetails1 = pg_exec($connection,$sQuery1) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery1.$connection);
		$rsltNCSStudentDetails2 = pg_exec($connection,$sQuery2) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery2.$connection);

		if($rsltNCSStudentDetails1 and $rsltNCSStudentDetails2)
		{
			pg_query("COMMIT;") or die("COMMIT FAIL");
			return 'success';
					
		}
		else{
			pg_query("ROLLBACK;") or die("ROLLBACK IS NOT WORKING");
			
		}
			

	}

	function updateStudentDetailsManager($objclsNCSStudentDetails,$myConn=null)
	{
		$SDRollId=$objclsNCSStudentDetails->getSDRollId();
		$SDName=$objclsNCSStudentDetails->getSDName();
		$SDBatch=$objclsNCSStudentDetails->getSDBatch();
		$SDPhone=$objclsNCSStudentDetails->getSDPhone();
		$SDEmailId=$objclsNCSStudentDetails->getSDEmailId();
		$SDBranch=$objclsNCSStudentDetails->getSDBranch();
		require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");

		$sQuery="UPDATE public.ncsstudentdetails SET sdname='$SDName', sdbatch=$SDBatch, sdbranch='$SDBranch', sdemailid='$SDEmailId', sdphone='$SDPhone' WHERE sdrollid=$SDRollId;";

		$res=pg_exec($connection,$sQuery);
		if($res)
			return 'success';
		else
			return 'fail';
	}
}
?>