<?php
           
require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSEventInfo.php");
//require_once($_SERVER['DOCUMENT_ROOT']."/NCS/class/clsNCSCounsellorDetailsSet.php");
  
class clsNCSEventInfoManager
{
    //save into database
	function SaveNCSEventInfoManager($objclsNCSEventInfo, $myConn=null)
	{
	   //global $_SERVER['DOCUMENT_ROOT'];
		$EITitle=pg_escape_string($objclsNCSEventInfo->getEITitle());
		$EIPurpose=pg_escape_string($objclsNCSEventInfo->getEIPurpose());
		$EIDate=$objclsNCSEventInfo->getEIDate();
		$EIPlace=pg_escape_string($objclsNCSEventInfo->getEIPlace());
		$EINo=null;
		$sQuery = "INSERT INTO public.ncseventinfo(eidate, eipurpose, etitle, eiplace) VALUES ('$EIDate', '$EIPurpose', '$EITitle','$EIPlace') returning eno;";
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
			$rsltNCSEventInfo = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSEventInfoManager:SaveNCSEventInfoManager".$sQuery.$connection);
			$lNumRows=0;
			$lNumRows = pg_numrows($rsltNCSEventInfo);
			if ($lNumRows == 0)
			{
				pg_close();
				return null;
			}
			//print_r($rsltNCSLoginDetails);
	        $arrNCSEventInfo = pg_fetch_array($rsltNCSEventInfo,0);
			$EINo=$arrNCSEventInfo['eno'];
	        
			@pg_close();

		}
	return $EINo;
    }
    //retrieve
    function retrieveNCSEventInfo($sQuery)
    {
  // echo $sQuery;
        //global $_SERVER['DOCUMENT_ROOT'];            
	    @pg_close();
		require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
		$rsltNCSEventInfo = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager : retrieveNCSCounsellorDetails.");
		$lNumRows = pg_numrows($rsltNCSEventInfo);
		if ($lNumRows == 0)
		{
			pg_close();
			return null;
		}
		
		//print_r($rsltNCSCounsellorDetails);
        pg_close();
        return $rsltNCSEventInfo;            
     }
 }

?>