<?php
include_once("../Interface/IModelo.class.php");


/**
 * 
 */
class Integrante implements IModelo {
	public $aluno;
	public $grupo;
	public $status;
	public $cargo;
	private $db;
	
	public function __construct(){
		$this->db = new DAO();
	}
	
	public function buscar($obj){
		$query = "select * from alunogrupo where ra = :ra AND grupoid = :id";
		$params = array(':ra' => $obj->aluno->ra);
		$params = array(':id' => $obj->grupo->id);
		$retorno = $this->db->selectInClass($query, $params, "Integrante");
		
		return $retorno[0];
	}
	
	public function ListarPorRa($obj){
		$query = "select * from alunogrupo where ra = :ra";
		$params = array(':ra' => $obj->aluno->ra);
		$retorno = $this->db->selectInClass($query, $params, "Integrante");
		
		return $retorno;
	}
	
	public function ListarPorGrupo($obj){
		$query = "select * from alunogrupo where grupoid = :id";
		$params = array(':id' => $obj->grupo->id);
		$retorno = $this->db->selectInClass($query, $params, "Integrante");
		foreach ($retorno as $key => $value) {
			$value->aluno =  new Aluno();
			$value->aluno->idaluno = $value->idaluno;
			
			$value->grupo =  new Grupo();
			$value->grupo->id = $value->grupoid;
		}
		return $retorno;
	}
	function Insert(){
		
		$query = "insert into alunogrupo (grupoid, idaluno, cargo, status)
			    values (:id, :idaluno, :cargo, :status) ";
			    
		$params[":id"] = $this->grupo->id;
		$params[":idaluno"] = $this->aluno->idaluno;
		$params[":status"] = $this->status;
		$params[":cargo"] = $this->cargo;
		
		return $this->db->execute($query, $params);	
	}
	
	function Update(){
		$query = "update alunogrupo set status = :status, cargo = :cargo
				  where ra = :ra and grupoid = :id";
		$params[":ra"] = $this->aluno->ra;
		$params[":id"] = $this->grupo->ra;
		$params[":status"] = $this->status;
		$params[":cargo"] = $this->cargo;
		
		return $this->db->execute($query, $params);	
	}
	 
	function delete(){
		
	}
	
	 public function setFromPostbackForm(){
	 	foreach($_POST as $name => $value){
	 		$this->$name = $value;
		}
		foreach($_POST as $name => $value){
	 		$this->grupo->$name = $value;
		}
		$this->grupo->id = $_POST["grupoid"];
		foreach($_POST as $name => $value){
	 		$this->aluno->$name = $value;
		}
	 }
	
	
}
?>