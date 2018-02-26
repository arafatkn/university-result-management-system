<?php

	class Admin {
	
		private $id,$role;
		
		public function __construct(){
		
			if($this->is_admin()){
				$this->id = $_SESSION["adminid"];
			}
			$this->role = $this->data("role");
		}
		public function is_admin(){
			
			if(isset($_SESSION["adminid"])){
				return true;
			}
			else {
				return false;
			}
		}
		public function getId()
		{
			return $this->id;
		}
		public function getRole()
		{
			return $this->role;
		}
		public function login($admin,$password){
			
			global $db;
			$login = $db->select("admin","username,password",array("username"=>$admin));
			if($login->num_rows<1){
				return false;
			}
			$result=$login->fetch_assoc();
			if( password_verify($password,$result["password"]) )
			{
				return true;
			}
			return false;
		}
		public function logout()
		{
			if(isset($_SESSION["adminid"]))
			{
				unset($_SESSION["adminid"]);
			}
			return true;
		}
		public function data($var){
		
			global $db;
			$code = $db->select("admin",$var,array("id"=>$this->id));
			$fetch = $code->fetch_assoc();
			return $fetch[$var];
			
		}
		public function gdata($var,$Var){
		
			global $db;
			$code = $db->select("admin",$var,$Var);
			$fetch = $code->fetch_assoc();
			return $fetch[$var];
			
		}
		public function error($errors){
		
			echo '<div class="error">';
			foreach($errors as $error){
				echo $error."<br/>";
			}
			echo '</div>';
		}
		public function exists($user){
			global $db;
			$code = $db->select("admin","id",array("username"=>$user));
			if($code->num_rows<1){
				return false;
			}
			else {
				return true;
			}
		}
		public function valid($var){
			
			if(!preg_match('/([a-zA-Z0-9\-_]+)/',$var)){
				return false;
			}
			else {
				return true;
			}
		}
				
	}
?>
		
					