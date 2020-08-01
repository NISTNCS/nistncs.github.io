<?php
	class clsNCSStudentGuideDetails
	{
		var SDRollId;
		var CDId;
		var SGDId;
		function getSDRollId()
		{
			return $this->SDRollId;
		}
		function setSDRollId($data)
		{
			$this->SDRollId=$data;
		}
		function getCDId()
		{
			return $this->CDId;
		}
		function setCDId($data)
		{
			$this->CDId=$data;
		}
		function getSDSGDId()
		{
			return $this->SDSGDId;
		}
		function setSDSGDId($data)
		{
			$this->SDSGDId=$data;
		}
	}
?>