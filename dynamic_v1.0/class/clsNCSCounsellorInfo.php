<?php


class clsNCSCounsellorInfo
{
	var $CIName;
	var $CIFid;
	var $CIDept;
    var $CIEmailId;
	var $CIContact;
    
    
    function getCIName()
	{
		return $this->CIName;
	}
	function setCIName($Data)
	{
		$this->CIName = $Data;
	}
    
    function getCIFid()
	{
		return $this->CIFid;
	}
	function setCIFid($Data)
	{
		$this->CIFid = $Data;
	}
    
    function getCIDept()
	{
		return $this->CIDept;
	}
	function setCIDept($Data)
	{
		$this->CIDept = $Data;
	}

    
    function getCIEmailId()
	{
		return $this->CIEmailId;
	}
	function setCIEmailId($Data)
	{
		$this->CIEmailId = $Data;
	}
    
	 function getCIContact()
	{
		return $this->CIContact;
	}
	function setCIContact($Data)
	{
		$this->CIContact = $Data;
	}
    }
?>