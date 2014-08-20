<?php

include_once("../Interface/IModelo.class.php");
/**
 * 
 */
class Grupo implements IModelo {
	public $id;
	public $nome;
	public $status;
	public $responsavel;
	private $db;
	
	function __construct() {
		$this->db = new DAO();
	}
	
	public function buscar($obj){
		$query = "SELECT * FROM grupo WHERE id = :id";
		$params = array(':id' => $obj->id);
		$retorno = $this->db->selectInClass($query, $params, "Grupo");
		
		return $retorno[0];
	}
	
	public function ListarPorNome($obj){
		$query = "SELECT * FROM Grupo WHERE Nome = :nome";
		$params = array(':nome' => $obj->nome());
		$retorno = $this->db->selectInClass($query, $params, "Grupo");
		
		return $retorno;
	}

	function listar($numeroRegistros,$pagina,$order){
		$query = "SELECT * FROM Grupo ORDER BY :order LIMIT :limit OFFSET :offset ";
		$params[":order"] = $order;
		$params[":limit"] = $numeroRegistros;
		$params[":offset"] = ($pagina - 1) * $numeroRegistros;
		$list = $this->db->selectInClass($query, $params, "Grupo");
		/*$usuarioList = array();
		$count = 0;
		foreach($list as $usuario){
			$usuarioList[$count] = new Usuario();
			$this->montarObjeto($usuarioList[$count], $usuario);
			$count++;
		}*/
		
		return $list;
	}
	
	function listarPorEmpresa($idaluno,$numeroRegistros,$pagina,$order){
		$query = "SELECT nome, id FROM view_grupo WHERE id_aluno = :idAluno OR responsavel = :idAluno  GROUP BY nome, id ORDER BY :order LIMIT :limit OFFSET :offset ";
		$params[":idAluno"] = $idaluno;
		$params[":order"] = $order;
		$params[":limit"] = $numeroRegistros;
		$params[":offset"] = ($pagina - 1) * $numeroRegistros;
		$list = $this->db->selectInClass($query, $params, "Grupo");
		/*$usuarioList = array();
		$count = 0;
		foreach($list as $usuario){
			$usuarioList[$count] = new Usuario();
			$this->montarObjeto($usuarioList[$count], $usuario);
			$count++;
		}*/
		
		if(count($list) > 0){
			return $list;
		}else{
			return array();
		}
	}
	
	function Insert(){
		$query = "insert into grupo (
			            id, nome, status, responsavel)
			    select COALESCE(MAX(id),0) + 1, :nome, :status, :responsavel from grupo";
			    
		$params[":nome"] = $this->nome;
		$params[":email"] = $this->email;
		$params[":status"] = $this->status;
		$params[":grupoid"] = $this->grupoid;
		$params[":responsavel"] = $this->responsavel;
		
		return $this->db->execute($query, $params);	
	}
	
	function Update(){
		$query = "update grupo set nome = :nome, status = :status
				  where id = :id";
		$params[":nome"] = $this->nome;
		$params[":email"] = $this->email;
		$params[":status"] = $this->status;
		$params[":id"] = $this->id;
		
		return $this->db->execute($query, $params);	
	}
	 
	 public function setFromPostbackForm(){
	 	foreach($_POST as $name => $value){
	 		$this->$name = $value;
		}
	 }
	
}

?>