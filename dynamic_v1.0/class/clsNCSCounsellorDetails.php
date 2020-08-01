<?php


class clsNCSCounsellorDetails
{
	var $CIFId;
	var $SDRollId;
	var $CDYear;
    
    function getCIFId()
	{
		return $this->CIFId;
	}
	function setCIFId($Data)
	{
		$this->CIFId = $Data;
	}

	function getCDYear()
	{
		return $this->CDYear;
	}
	function setCDYear($Data)
	{
		$this->CDYear = $Data;
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