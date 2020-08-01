<?php


class clsNCSEventInfo
{
	var $EINo;
	var $EIDate;
	var $EIPlace;
	var $EITitle;
	var $EIPurpose;
    
    function getEINo()
	{
		return $this->EINo;
	}
	function setEINo($Data)
	{
		$this->EINo = $Data;
	}
    function getEIPlace()
	{
		return $this->EIPlace;
	}
	function setEIPlace($Data)
	{
		$this->EIPlace = $Data;
	}
    function getEIDate()
	{
		return $this->EIDate;
	}
	function setEIDate($Data)
	{
		$this->EIDate = $Data;
	}
	 function getEITitle()
	{
		return $this->EITitle;
	}
	function setEITitle($Data)
	{
		$this->EITitle = $Data;
	}
	 function getEIPurpose()
	{
		return $this->EIPurpose;
	}
	function setEIPurpose($Data)
	{
		$this->EIPurpose = $Data;
	}
    
 }
?>