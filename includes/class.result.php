<?php

	class Result {
	
		private $mark2grade,$mark2gpa,$gpa2grade,$grade2gpa;
		
		public function __construct(){
			$this->mark2grade = array("F","F","F","F","F","F","F","F",
								"D","C","C+","B-","B","B+","A-","A","A+","A+","A+","A+","A+");
			$this->mark2gpa = array("0.00","0.00","0.00","0.00","0.00","0.00","0.00","0.00",
								"2.00","2.25","2.50","2.75","3.00","3.25","3.50","3.75",
								"4.00","4.00","4.00","4.00","4.00");
			$this->gpa2grade = array("0.00"=>"F","2.00"=>"D","2.25"=>"C","2.50"=>"C+","2.75"=>"B-",
								"3.00"=>"B","3.25"=>"B+","3.50"=>"A-","3.75"=>"A","4.00"=>"A+");
			$this->grade2gpa = array("F"=>"0.00","D"=>"2.00","C"=>"2.25","C+"=>"2.50","B-"=>"2.75",
								"B"=>"3.00","B+"=>"3.25","A-"=>"3.50","A"=>"3.75","A+"=>"4.00");
		}
		public function is_valid($num)
		{
			if($num>100)
				return false;
			if($num<0)
				return false;
			return true;
		}
		public function mark2grade($num)
		{
			return $this->mark2grade[(int)($num/5)];
		}
		public function mark2gpa($num)
		{
			return $this->mark2gpa[(int)($num/5)];
		}
		public function gpa2grade($gpa)
		{
			return $this->gpa2grade[$gpa];
		}
		public function grade2gpa($grade)
		{
			return $this->grade2gpa[$grade];
		}
				
	}
?>
		
					