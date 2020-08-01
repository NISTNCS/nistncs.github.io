<?php
    require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSCurrentCalendarYear.php");
    require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsNCSCurrentCalendarYearManager.php");
    require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsSearchTransaction.php");
    
    $objclsNCSCurrentCalendarYearManager=new clsNCSCurrentCalendarYearManager();
    $objclsNCSCurrentCalendarYear=$objclsNCSCurrentCalendarYearManager->retieveNCSCurrentCalendarYear();
    $year=$objclsNCSCurrentCalendarYear->getCCYYear();
	$objclsSearchTransaction=new clsSearchTransaction();
    echo $objclsSearchTransaction->familytree($year);      
?>