<?php
include_once("../Interface/IModelo.class.php");
/**
 * 
 */
class Jogo implements IModelo {
	public $id;
	public $descricao;
	public $datainicio;
	public $datatermino;
	public $numerojogadas;
	public $status;
	private $db;
	
	function __construct() {
		$this->db = new DAO();
	}
	
	public function buscar($obj){
		$query = "select * from jogo where id = :id";
		$params = array(':id' => $obj->id);
		$retorno = $this->db->selectInClass($query, $params, "Jogo");
		
		return $retorno[0];
	}
	
	public function ListarPorNome($obj){
		$query = "select * from jogo where descricao = :descricao";
		$params = array(':descricao' => $obj->nome());
		$retorno = $this->db->selectInClass($query, $params, "Jogo");
		
		return $retorno;
	}
	

	function listar($numeroRegistros,$pagina,$order){
		$query = "SELECT * FROM Jogo ORDER BY :order LIMIT :limit OFFSET :offset ";
		$params[":order"] = $order;
		$params[":limit"] = $numeroRegistros;
		$params[":offset"] = ($pagina - 1) * $numeroRegistros;
		$list = $this->db->selectInClass($query, $params, "Jogo");
		/*$usuarioList = array();
		$count = 0;
		foreach($list as $usuario){
			$usuarioList[$count] = new Usuario();
			$this->montarObjeto($usuarioList[$count], $usuario);
			$count++;
		}*/
		
		return $list;
	}
	
	function Insert($obj){
		$query = "insert into jogo (
			            id, descricao, datainicio, datatermino, numerojogadas, status)
			    select max(id) + 1, :descricao, :datainicio, :datatermino, :numerojogadas, :status from jogo";
			    
		$params[":descricao"] = $obj->descricao;
		$params[":datainicio"] = $obj->datainicio;
		$params[":datatermino"] = $obj->datatermino;
		$params[":status"] = $obj->status;
				
		return $this->db->execute($query, $params);	
	}
	
	function Update(){
		$query = "update jogo set descricao = :descricao, datainicio = :datainicio, numerojogadas = :numerojogadas, status = :status
				  where id = :id";
		$params[":descricao"] = $this->descricao;
		$params[":datainicio"] = $this->datainicio;
		$params[":datatermino"] = $this->datatermino;
		$params[":numerojogadas"] = $this->numerojogadas;
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