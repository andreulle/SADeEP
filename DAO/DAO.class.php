<?php

/**
 * 
 */
class DAO {
	
	private $con;
	private $pass = "m35tr3j3d1";
	private $user =  "enjedi";
	
	function __construct() {
		$this->openDB();
	}
	
	private function openDB(){
		$this->con = new PDO('pgsql:dbname=SADEP; host=localhost', $this->user, $this->pass);
		$this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	$this->con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	}
	
	/*public function select($query){
		return $this->con->query($query);
	}*/
	
	public function select($query,$params){
		try{
		   $stmte = $this->con->prepare($query);
		   foreach ($params as $key => $value) {
		   	$type = gettype($value);
			   switch ($type) {
				   case 'string':
					   $stmte->bindValue($key, $value , PDO::PARAM_STR);
					  break;
				   case 'integer':
					   $stmte->bindValue($key, $value, PDO::PARAM_INT);
					   break;
				   default:
					   
					   break;
			   } 
		   }
		
	       $executa = $stmte->execute();
	 			      
	       if($executa){
			$reg = $stmte->fetchAll(PDO::FETCH_ASSOC);
	       }else{
	       	$reg = NULL;
	       }
		   return $reg;
	   }
	   catch(PDOException $e){
	      echo $e->getMessage();
	   }
	   
	}
	
	/*
	 * Retornar um Array de objetos de acordo com o retorno do SELECT
	 */
	public function selectInClass($query,$params,$className){
		try{
		   $stmte = $this->con->prepare($query);
		   foreach ($params as $key => $value) {
		   	$type = gettype($value);
			   switch ($type) {
				   case 'string':
					   $stmte->bindValue($key, $value , PDO::PARAM_STR);
				   		break;
				   case 'integer':
					   $stmte->bindValue($key, $value, PDO::PARAM_INT);
					   break;
				   default:
					   
					   break;
			   } 
		   }
		
	       $executa = $stmte->execute();
	 			      
	       if($executa){
			$reg = $stmte->fetchAll(PDO::FETCH_CLASS,$className);
	       }else{
	       	$reg = NULL;
	       }
		   return $reg;
	   }
	   catch(PDOException $e){
	      echo $e->getMessage();
	   }
	   
	}
	
	public function execute($query,$params){
		try{
		$stmte = $this->con->prepare($query);
		
			foreach($params as $key => $value){
				$type = gettype($value);
				switch ($type) {
					   case 'string':
						   $stmte->bindValue($key, $value , PDO::PARAM_STR);
					   		break;
					   case 'integer':
						   $stmte->bindValue($key, $value, PDO::PARAM_INT);
						   break;
					   default:
						   break;
				   } 
			}
			
		   $executa = $stmte->execute();
	 
	       if($executa){
			$reg = $executa;
	       }else{
	       	$reg = NULL;
			
	       }
		   return $reg;
			
		} catch(PDOException $e){
	      	echo $e->getMessage();
	   	}
	   }
}


?>