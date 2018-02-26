<?php

class Database extends mysqli {

   private $host,$user,$pass,$name;
   public $link;
   
   public function __construct($db_host,$db_user,$db_pass,$db_name){
   
      $this->host=$db_host;
      $this->user=$db_user;
      $this->pass=$db_pass;
      $this->name=$db_name;
      $this->link=parent::__construct($this->host,$this->user,$this->pass,$this->name);
      
      if($this->connect_errno){
         
         echo 'MySQL Database Connection Error: '.$this->connect_error;
         exit;
         
      }
   }
   public function select($table,$fields="",$where="",$order="",$limit=""){
      if($fields==""){
         $fields="*";
      }
      $code="SELECT $fields FROM $table";
      if(is_array($where)){
         $Where=array();
         foreach($where as $key=>$value){
            
            $Where[]="$key='$value'";
         }
         if(count($Where)>1){
            $code.=" WHERE ".implode(" AND ",$Where)."";
         }
         else {
            $code.=" WHERE ".$Where[0]."";
         }
      }
      if($order){
         $code.=" ORDER BY $order";
      }
      if($limit){
         $code.=" LIMIT $limit";
      }
      return $this->query($code);
   }
   public function insert($table,$vars){
      $code="INSERT INTO $table (";
      $Keys=array();
      $Vars=array();
      foreach($vars as $key=>$value){
         $Keys[]=$key;
         $Vars[]="'$value'";
      }
      if(count($Keys)>1){
         $code.="".implode(",",$Keys).") VALUES (".implode(",",$Vars).")";
      }
      else {
         $code.="".$Keys[0].") VALUES (".$Vars[0].")";
      }
      return $this->query($code);
   }
   public function update($table,$set,$where=""){
      $code="UPDATE $table SET";
      $Set=array();
      foreach($set as $key=>$value){
         $Set[]="$key='$value'";
      }
      if(count($Set)>1){
         $code.=" ".implode(",",$Set)."";
      }
      else {
         $code.=" ".$Set[0]."";
      }
      if(is_array($where)){
         $Where=array();
         foreach($where as $key=>$value){
            
            $Where[]="$key='$value'";
         }
         if(count($Where)>1){
            $code.=" WHERE ".implode(" AND ",$Where)."";
         }
         else {
            $code.=" WHERE ".$Where[0]."";
         }
      }
      return $this->query($code);
   }
   public function delete($table,$where=""){
      $code="DELETE FROM $table";
      if(is_array($where)){
         $Where=array();
         foreach($where as $key=>$value){
            
            $Where[]="$key='$value'";
         }
         if(count($Where)>1){
            $code.=" WHERE ".implode(" AND ",$Where)."";
         }
         else {
            $code.=" WHERE ".$Where[0]."";
         }
      }
      return $this->query($code);
   }
   public function __destruct(){
      $this->close();
   }
}
   
?>