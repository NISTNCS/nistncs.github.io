<?php          
require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSCounsellorInfo.php");
//require_once($_SERVER['DOCUMENT_ROOT']."/NCS/class/clsNCSCounsellorInfoSet.php");
  
class clsNCSCounsellorInfoManager
{
  //save into database
	function retrieveNCSCounsellorDetailsCount($sQuery)
     {
     	require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
		$rsltNCSCounsellorDetails = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:retrieveNCSCounsellorDetails.");
		$lNumRows = pg_numrows($rsltNCSCounsellorDetails);
		if($lNumRows == 0)
		{
			return null ;
		}
		$arrNCSCounsellorDetails=pg_fetch_array($rsltNCSCounsellorDetails,0);
		return $arrNCSCounsellorDetails['facnum'];
            
     }

	function SaveNCSCounsellorInfo($objNCSCounsellorInfo, $myConn=null)
	{
	   //global $_SERVER['DOCUMENT_ROOT'];
		$CIFName=$objNCSCounsellorInfo->getCIName();
		$CIFId=$objNCSCounsellorInfo->getCIFId();
		$CIDept=$objNCSCounsellorInfo->getCIDept();
		$CIEmailId=$objNCSCounsellorInfo->getCIEmailId();
		
		$sQuery = "INSERT INTO public.ncscounsellorinfo(
            cifid, cifname, cidept,  ciemail)
    VALUES ($CIFId,'$CIFName','$CIDept','$CIEmailId')";
        //echo "ab=".$sQuery;
  
		if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
		{
			$rsltNCSCounsellorInfo = pg_exec($myConn,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorInfoManager:SaveNCSCounsellorInfo".$sQuery);
			$lNumTuples = pg_cmdtuples($rsltNCSCounsellorInfo);
		}
		else
		{
			@pg_close();
			//global $_SERVER['DOCUMENT_ROOT'];
            //echo($connection);
			require($_SERVER['DOCUMENT_ROOT']."/NCS/dbconnect.php");
			$rsltNCSCounsellorInfo = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorInfoManager:SaveNCSCounsellorInfo".$sQuery.$connection);
			$lNumTuples = pg_cmdtuples($rsltNCSCounsellorInfo);
			@pg_close();
		}
	return $lNumTuples;
    }

    //retrieve
    function retrieveNCSCounsellorInfo($sQuery)
    {
  // echo $sQuery;
        //global $_SERVER['DOCUMENT_ROOT'];            
	    @pg_close();
	    require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
		$objNCSCounsellorInfo = new clsNCSCounsellorInfo();
		$rsltNCSCounsellorInfo = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorInfoManager : retrieveNCSCounsellorInfo.");
		$lNumRows = pg_numrows($rsltNCSCounsellorInfo);
		if ($lNumRows == 0)
		{
			pg_close();
			return null;
		}
		
		//print_r($rsltNCSCounsellorInfo);
        $arrNCSCounsellorInfo = pg_fetch_array($rsltNCSCounsellorInfo,0);
		$objNCSCounsellorInfo->setCIName($arrNCSCounsellorInfo['cifname']);
        $objNCSCounsellorInfo->setCIFId($arrNCSCounsellorInfo['cifid']);
	 	$objNCSCounsellorInfo->setCIDept($arrNCSCounsellorInfo['cidept']);
	 	$objNCSCounsellorInfo->setCIContact($arrNCSCounsellorInfo['cicontact']);
	 	$objNCSCounsellorInfo->setCIEmailId($arrNCSCounsellorInfo['ciemail']);
			

		
        pg_close();
        return $objNCSCounsellorInfo;            
     }
     function updateCounsellorInfoManager($objclsNCSCounsellorInfo,$myConn=null)
	{
		$CIFId=$objclsNCSCounsellorInfo->getCIFId();
		$CIName=$objclsNCSCounsellorInfo->getCIName();
		$CIPhone=$objclsNCSCounsellorInfo->getCIContact();
		$CIEmailId=$objclsNCSCounsellorInfo->getCIEmailId();
		require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
		$sQuery="UPDATE ncscounsellorinfo SET cifname='$CIName', cicontact=$CIPhone, ciemail='$CIEmailId' WHERE cifid=$CIFId;";

		$res=pg_exec($connection,$sQuery);
		if($res)
			return 'success';
		else
			return 'fail';
	}
     /*
     function retrieveNCSCounsellorInfoSet($sQuery)//this function retrieve set of phone book details//
      {
		 //global $_SERVER['DOCUMENT_ROOT'];            
	    @pg_close();
		require($_SERVER['DOCUMENT_ROOT']."/NCS/dbconnect.php");
		$objNCSCounsellorInfoSet = new clsNCSCounsellorInfoSet();
		$rsltNCSCounsellorInfo = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorInfoManager:retrieveNCSCounsellorInfo.");
		$lNumRows = pg_numrows($rsltNCSCounsellorInfo);
		if($lNumRows == 0)
		{
			pg_close();
			return $objNCSCounsellorInfoSet ;
		}
		for($lCount = 0; $lCount < $lNumRows; $lCount++)
		{
            $objNCSCounsellorInfo = new clsNCSCounsellorInfo();
            $arrNCSCounsellorInfo=pg_fetch_array($rsltNCSCounsellorInfo,$lCount);
           $objNCSCounsellorInfo->setCIFName($arrNCSCounsellorInfo[cifname]);
        $objNCSCounsellorInfo->setCIFId($arrNCSCounsellorInfo[cifid]);
	 $objNCSCounsellorInfo->setCIDept($arrNCSCounsellorInfo[cidept]);
	 $objNCSCounsellorInfo->setCIContact($arrNCSCounsellorInfo[cicontact]);
	 $objNCSCounsellorInfo->setCIEmailId($arrNCSCounsellorInfo[ciemailid]);
				
			
        }
        pg_close();
        return $objNCSCounsellorInfoSet;
      }
     
     //update
     function updateNCSCounsellorInfo($obj, $myConn=null)
	 {
	 $CIFName = $obj->getCIFName();
        $CIFId = $obj->getCIFId();
        $CIDept = $obj->getCIDept();
	 $CIContact = $obj->getCIContact();
	 $CIEmailId = $obj->getEmailId();
       
           
        if($CIFName==null)
			$CIFName='null';
		else
			$CIFName="'$CIFName'";
        if($CIFId==null)
			$CIFId='null';
		else
			$CIFId="'$CIFId'";
	if($CIDept==null)
			$CIDept='null';
		else
			$CIDept="'$CIDept'";
	if($CIContact==null)
			$CIContact='null';
		else
			$CIContact="'$CIContact'";
	if($CIEmailId==null)
			$CIEmailId='null';
		else
			$CIEmailId="'$CIEmailId'";
	
      
        
        $sQuery = "update NCSCounsellorInfo set cifname=$CIFName,cifid=$CIFId,cidept=$CIDept,cicontact=$CIContact,ciemailid=$CIEmailId
                   where CIFId=$CIFId";
        //echo($sQuery);
       if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
		{
			$rsltUpdateDetails = pg_exec($myConn,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorInfoManager:updateNCSCounsellorInfo");
			$lNumTuples = pg_cmdtuples($rsltUpdateDetails);
		}
		else
		{
			@pg_close();
			//global $_SERVER['DOCUMENT_ROOT'];
            require($_SERVER['DOCUMENT_ROOT']."/NCS/dbconnect.php");
			$rsltUpdateDetails = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsInfo:updateNCSCounsellorInfo");
			$lNumTuples = pg_cmdtuples($rsltUpdateDetails);
			pg_close();
		}
		return $lNumTuples;     
    }
     
     function deleteNCSCounsellorInfo($objNCSCounsellorInfo, $myConn=null)
	{
		//global $_SERVER['DOCUMENT_ROOT'];
        $CIFId=$objNCSCounsellorInfo->getCIFId();
		if($CIFId==null)
			$CIFId=null;
  
		$sQuery = "delete from NCSCounsellorInfo where CIFId='$CIFId'";
        //echo($sQuery);
		if(is_resource($myConn) and get_resource_type($myConn)== 'pgsql link')
		{
			$rsltDeleteDetails = pg_exec($myConn,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:deleteNCSCounsellorInfo");
			$lNumTuples = pg_cmdtuples($rsltDeleteDetails);
		}
		else
		{
			@pg_close();
			//global $_SERVER['DOCUMENT_ROOT'];
			  require($_SERVER['DOCUMENT_ROOT']."/NCS/dbconnect.php");
			$rsltDeleteDetails = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorInfoManager:deleteNCSCounsellorInfo");
			$lNumTuples = pg_cmdtuples($rsltDeleteDetails);
			pg_close();
		}
	return $lNumTuples;
	} */
 }

?>