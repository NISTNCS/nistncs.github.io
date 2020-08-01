<?php
class clsNCSMeetingInfo
{
    var	$MIDate;
    var $MITitle;
    var	$MIPlace;
	var	$MIPurpose;
	var	$SDRollId;
    
    function getMIDate()
	{
		return $this->MIDate;
	}
	function setMIDate($Data)
	{
		$this->MIDate = $Data;
	}
    
    function getMIPlace()
	{
		return $this->MIPlace;
	}
	function setMIPlace($Data)
	{
		$this->MIPlace = $Data;
	}
	function getMITitle()
	{
		return $this->MITitle;
	}
	function setMITitle($Data)
	{
		$this->MITitle = $Data;
	}
	function getMIPurpose()
	{
		return $this->MIPurpose;
	}
	function setMIPurpose($Data)
	{
		$this->MIPurpose = $Data;
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