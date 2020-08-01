<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSCurrentCalendarYear.php");

	class clsNCSCurrentCalendarYearManager
	{
		function saveNCSCurrentCalendarYear($objclsNCSCurrentCalendarYear)
		{
			$CCYYear=$objclsNCSCurrentCalendarYear->getCCYYear();
			
			$sQuery = "INSERT INTO ncscurrentcalendaryear(ccyyear) VALUES ($CCYYear);";

			@pg_close();
			require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
			$rsltNCSInsertDetails = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:SaveNCSCounsellorDetails".$sQuery.$connection);
			$lNumTuples = pg_cmdtuples($rsltNCSInsertDetails);
			@pg_close();
			
			return $lNumTuples;
		}
		function updateNCSCurrentCalendarYear($objclsNCSCurrentCalendarYear)
		{
			$CCYYear=$objclsNCSCurrentCalendarYear->getCCYYear();
			
			$sQuery = "UPDATE ncscurrentcalendaryear SET ccyyear=$CCYYear WHERE ccyid=1;";
   
	        if($CCYYear==null)
				$CCYYear='null';
			
	        
	        @pg_close();
			
			require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
			$rsltNCSUpdateDetails = pg_exec($connection,$sQuery) or die ("Couldn't execute query in clsNCSCounsellorDetailsManager:updateNCSCounsellorDetails");
			$lNumTuples = pg_cmdtuples($rsltNCSUpdateDetails);
			if($lNumTuples==0)
			{
				@pg_close();
				return false;
			}

			@pg_close();

			return true;     
		}
		function retieveNCSCurrentCalendarYear()
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