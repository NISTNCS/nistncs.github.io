<?php
           
require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSCounsellorDetails.php");
//require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/class/clsNCSCounsellorDetailsSet.php");
  
class clsNCSCounsellorDetailsManager
{
    //save into database


	function SaveNCSCounsellorDetails($objNCSCounsellorDetails, $myConn=null)
	{
	   //global $_SERVER['DOCUMENT_ROOT'];
		$CDYear=$objNCSCounsellorDetails->getCDYear();
		$SDRollId=$objNCSCounsellorDetails->getSDRollId();
		
		$sQuery = "insert into NCSCounsellorDetails(cdyear,sdrollid) values ($CDYear,$SDRollId)";
		if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
		{
			$rsltNCSCounsellorDetails = pg_exec($myConn,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery);
			$lNumTuples = pg_cmdtuples($rsltNCSCounsellorDetails);
		}
		else
		{
			@pg_close();
			//global $_SERVER['DOCUMENT_ROOT'];
            //echo($connection);
			require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
			$rsltNCSCounsellorDetails = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery.$connection);
			$lNumTuples = pg_cmdtuples($rsltNCSCounsellorDetails);
			@pg_close();
		}
	return $lNumTuples;
    }
    //retrieve
    function retrieveNCSCounsellorDetails($sQuery)
    {
  // echo $sQuery;
        //global $_SERVER['DOCUMENT_ROOT'];            
	    @pg_close();
		require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
		$objNCSCounsellorDetails = new clsNCSCounsellorDetails();
		$rsltNCSCounsellorDetails = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager : retrieveNCSCounsellorDetails.");
		$lNumRows = pg_numrows($rsltNCSCounsellorDetails);
		if ($lNumRows == 0)
		{
			pg_close();
			return null;
		}
		
		//print_r($rsltNCSCounsellorDetails);
        $arrNCSCounsellorDetails = pg_fetch_array($rsltNCSCounsellorDetails,0);
		$objNCSCounsellorDetails->setCIFId($arrNCSCounsellorDetails['cifid']);
        $objNCSCounsellorDetails->setSDRollId($arrNCSCounsellorDetails['sdrollid']);
		
        pg_close();
        return $objNCSCounsellorDetails;            
     }
     
     function retrieveNCSCounsellorDetailsSet($sQuery)//this function retrieve set of phone book details//
      {
		 //global $_SERVER['DOCUMENT_ROOT'];            
	    @pg_close();
		require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
		$objNCSCounsellorDetailsSet = new clsNCSCounsellorDetailsSet();
		$rsltNCSCounsellorDetails = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:retrieveNCSCounsellorDetails.");
		$lNumRows = pg_numrows($rsltNCSCounsellorDetails);
		if($lNumRows == 0)
		{
			pg_close();
			return $objNCSCounsellorDetailsSet ;
		}
		for($lCount = 0; $lCount < $lNumRows; $lCount++)
		{
            $objNCSCounsellorDetails = new clsNCSCounsellorDetails();
            $arrNCSCounsellorDetails=pg_fetch_array($rsltNCSCounsellorDetails,$lCount);
            $objNCSCounsellorDetails->setCIFId($arrNCSCounsellorDetails[CIFId]);
            $objNCSCounsellorDetails->setSDRollId($arrNCSCounsellorDetails[SDRollId]);
			
        }
        pg_close();
        return $objNCSCounsellorDetailsSet; 
      }

     
	function retrieveNCSStudentGuideDetailsCount($sQuery)
     {

		require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
		$rsltNCSStudentGuideDetails = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:retrieveNCSCounsellorDetails.");
		$lNumRows = pg_numrows($rsltNCSStudentGuideDetails);
		if($lNumRows == 0)
		{
			return null ;
		}
		$arrNCSStudentGuideDetails=pg_fetch_array($rsltNCSStudentGuideDetails,0);
		 return $arrNCSStudentGuideDetails['studguidenum'];
            
     }
     
     //update
     function updateNCSCounsellorDetails($obj, $myConn=null)
	 {
        $CIFId = $obj->getCIFId();
        $SDRollId = $obj->getSDRollId();
       
           
        if($CIFId==null)
			$CIFId='null';
		else
			$CIFId="'$CIFId'";
        if($SDRollId==null)
			$SDRollId='null';
		else
			$SDRollId="'$SDRollId'";
      
        
        $sQuery = "update NCSCounsellorDetails set CIFid=$CIFid,SDRollId=$SDRollId,
                   where CIFId=$CIFId";
        //echo($sQuery);
       if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
		{
			$rsltUpdateDetails = pg_exec($myConn,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:updateNCSCounsellorDetails");
			$lNumTuples = pg_cmdtuples($rsltUpdateDetails);
		}
		else
		{
			@pg_close();
			//global $_SERVER['DOCUMENT_ROOT'];
            require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
			$rsltUpdateDetails = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:updateNCSCounsellorDetails");
			$lNumTuples = pg_cmdtuples($rsltUpdateDetails);
			pg_close();
		}
		return $lNumTuples;     
    }
     
     function deleteNCSCounsellorDetails($objNCSCounsellorDetails, $myConn=null)
	{
		//global $_SERVER['DOCUMENT_ROOT'];
        $CIFId=$objNCSCounsellorDetails->getCIFId();
		if($CIFId==null)
			$CIFId=null;
  
		$sQuery = "delete from NCSCounsellorDetails where CIFId='$CIFId'";
        //echo($sQuery);
		if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
		{
			$rsltDeleteDetails = pg_exec($myConn,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:deleteNCSCounsellorDetails");
			$lNumTuples = pg_cmdtuples($rsltDeleteDetails);
		}
		else
		{
			@pg_close();
			//global $_SERVER['DOCUMENT_ROOT'];
			  require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
			$rsltDeleteDetails = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:deleteNCSCounsellorDetails");
			$lNumTuples = pg_cmdtuples($rsltDeleteDetails);
			pg_close();
		}
	return $lNumTuples;
	}
    
    function SaveNCSCounsellorDetailsNew($objNCSCounsellorDetails, $myConn=null)
	{
	   //global $_SERVER['DOCUMENT_ROOT'];
       $CIFId=$objNCSCounsellorDetails->getCIFId();
		$SDRollId=$objNCSCounsellorDetails->getSDRollId();
		
		
		$sQuery = "insert into NCSCounsellorDetails(CIFId,SDRollId) 
		values ('$CIFId','$SDRollId')";
        //echo "ab=".$sQuery;
  
		if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
		{
			$rsltNCSCounsellorDetails = pg_exec($myConn,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery);
			$lNumTuples = pg_cmdtuples($rsltNCSCounsellorDetails);
		}
		else
		{
			@pg_close();
			 //global $_SERVER['DOCUMENT_ROOT'];
             //echo($connection);
			require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
			$rsltNCSCounsellorDetails = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery.$connection);
			$lNumTuples = pg_cmdtuples($rsltNCSCounsellorDetails);
			@pg_close();
		}
	return $lNumTuples;
    }
 }

?>