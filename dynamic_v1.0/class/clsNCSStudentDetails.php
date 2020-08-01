<?php
class clsNCSStudentDetails
{
    var	$SDName;
    var	$SDBatch;
	var	$SDBranch;
	var	$SDEmailId;
	var	$SDRollId;
	var	$SDPhone;
	var $SDCounsellorName;
	var $SDCounsellorId;
    
    function getSDName()
	{
		return $this->SDName;
	}
	function setSDName($Data)
	{
		$this->SDName = $Data;
	}
	function getSDCounsellorId()
	{
		return $this->SDCounsellorId;
	}
	function setSDCounsellorId($Data)
	{
		$this->SDCounsellorId = $Data;
	}
    function getSDCounsellorName()
    {
    	return $this->SDCounsellorName;
    }
    function setSDCounsellorName($Data)
    {
    	$this->SDCounsellorName=$Data;
    }
    function getSDBatch()
	{
		return $this->SDBatch;
	}
	function setSDBatch($Data)
	{
		$this->SDBatch = $Data;
	}
	function getSDBranch()
	{
		return $this->SDBranch;
	}
	function setSDBranch($Data)
	{
		$this->SDBranch = $Data;
	}
	function getSDEmailId()
	{
		return $this->SDEmailId;
	}
	function setSDEmailId($Data)
	{
		$this->SDEmailId = $Data;
	}
	    function getSDPhone()
	{
		return $this->SDPhone;
	}
	function setSDPhone($Data)
	{
		$this->SDPhone = $Data;
	}
	function getSDRollId()
	{
		return $this->SDRollId;
	}
	function setSDRollId($Data)
	{
		$this->SDRollId = $Data;
	}
	
    
 }
 ?>