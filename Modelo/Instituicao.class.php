<?php

include_once("../Interface/IModelo.class.php");
/**
 * 
 */
class Instituicao implements IModelo {
	public $id_instituicao;
	public $nome;
	public $status;
	private $db;
	
	function __construct() {
		$this->db = new DAO();
	}
	
	public function buscar($obj){
		$query = "SELECT * FROM instituicao WHERE id_instituicao = :id_instituicao";
		$params = array(':id_instituicao' => $obj->id_instituicao);
		$retorno = $this->db->selectInClass($query, $params, "Instituicao");
		
		return $retorno[0];
	}
	
	public function ListarPorNome($obj){
		$query = "SELECT * FROM instituicao WHERE nome = :nome";
		$params = array(':nome' => $obj->nome());
		$retorno = $this->db->selectInClass($query, $params, "Instituicao");
		
		return $retorno;
	}

	function listar($numeroRegistros,$pagina,$order){
		$query = "SELECT * FROM instituicao ORDER BY :order LIMIT :limit OFFSET :offset ";
		$params[":order"] = $order;
		$params[":limit"] = $numeroRegistros;
		$params[":offset"] = ($pagina - 1) * $numeroRegistros;
		$list = $this->db->selectInClass($query, $params, "Instituicao");
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
		$query = "insert into instituicao (
			            id_instituicao, nome, status)
			    select COALESCE(MAX(id_instituicao),0) + 1, :nome, :status from instituicao";
			    
		$params[":nome"] = $this->nome;
		$params[":status"] = $this->status;
		
		return $this->db->execute($query, $params);	
	}
	
	function Update(){
		$query = "update instituicao set nome = :nome, status = :status
				  where id_instituicao = :id_instituicao";
		$params[":nome"] = $this->nome;
		$params[":status"] = $this->status;
		$params[":id_instituicao"] = $this->id_instituicao;
		
		return $this->db->execute($query, $params);	
	}
	 
	 public function setFromPostbackForm(){
	 	foreach($_POST as $name => $value){
	 		$this->$name = $value;
		}
	 }
	
}

?>