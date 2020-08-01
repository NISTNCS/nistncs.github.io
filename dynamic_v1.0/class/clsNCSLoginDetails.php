<?php

class clsNCSLoginDetails
{
	var $LDUserId;
	var $LDPassword;
	var $LDUserType;
	var $LDStatus;
    
    function getLDUserId()
	{
		return $this->LDUserId;
	}
	function setLDUserId($Data)
	{
		$this->LDUserId = $Data;
	}
    
    function getLDPassword()
	{
		return $this->LDPassword;
	}
	function setLDPassword($Data)
	{
		$this->LDPassword = $Data;
	}
    
    function getLDUserType()
	{
		return $this->LDUserType;
	}
	function setLDUserType($Data)
	{
		$this->LDUserType = $Data;
	}
     function getLDStatus()
	{
		return $this->LDStatus;
	}
	function setLDStatus($Data)
	{
		$this->LDStatus = $Data;
	}
    
   
 }
?>