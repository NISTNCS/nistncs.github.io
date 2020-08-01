<?php

require_once($_SERVER['DOCUMENT_ROOT']."/NCS/NCSSearch/class/clsNCSCounsellorDetails.php");
 
class clsNCSCounsellorDetailsSet
{ 
	var $aNCSCounsellorDetails = array();
	function Add($obj)
	{
		$this->aNCSCounsellorDetails[] = $obj;
	}
	function GetCount()
	{
		return count($this->aNCSCounsellorDetails);
	}
	function GetItem($lIndex)
	{
		$lLastEntry = $this->GetCount();
		if($lIndex < 0 || $lIndex > $lLastEntry-1)
		{
			echo " MyError: Illegal index Passed to  clsNCSCounsellorDetailsSet:GetItem()";
			exit;
		}
		return $this->aNCSCounsellorDetails[$lIndex];
	}
	function Remove($lIndex)
	{
		$lLastEntry = $this->GetCount();
		if($lIndex < 0 || $lIndex > $lLastEntry-1)
		{
			echo " MyError: Illegal index Passed to clsNCSCounsellorDetailsSet:Remove()";
			exit;
		}
		for($i = $lIndex; $i < $lLastEntry; $i++)
		{
			$this->aNCSCounsellorDetails[$i] = $this->aNCSCounsellorDetails[$i+1];
		}
		array_pop($this->aNCSCounsellorDetails);
	}
}
?>


        
    