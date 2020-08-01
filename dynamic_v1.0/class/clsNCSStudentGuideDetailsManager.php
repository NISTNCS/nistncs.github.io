<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSStudentGuideDetails.php");
	
	class clsNCSStudentGuideDetailsManager
	{
		function retrieveStudentGuideDetails($sQuery)
		{
			@pg_close();
			$sQuery="SELECT ccyyear FROM ncscurrentcalendaryear;";
			
			require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
			
			$objclsNCSCurrentCalendarYear = new clsNCSCurrentCalendarYear();
			$rsltNCSSelectDetails = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager : retrieveNCSCounsellorDetails.");
			$lNumRows = pg_numrows($rsltNCSSelectDetails);
			if ($lNumRows == 0)
			{
				pg_close();
				return null;
			}
			
	        $arrNCSSelectDetails = pg_fetch_array($rsltNCSSelectDetails,0);
			$objclsNCSCurrentCalendarYear->setCCYYear($arrNCSSelectDetails['ccyyear']);
			
	        pg_close();
	        return $objclsNCSCurrentCalendarYear;
		}
	}
?>