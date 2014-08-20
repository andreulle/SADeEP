<?php
include_once("../Interface/IModelo.class.php");
/**
 * 
 */
class Maquina implements IModelo {
	public $id;
	public $nome;
	public $potencia;
	public $valor;
	public $tamanho;
	public $status;
	private $db;
	
	function __construct() {
		$this->db = new DAO();
	}
	
	public function buscar($obj){
		$query = "select * from maquina where id = :id";
		$params = array(':id' => $obj->id);
		$retorno = $this->db->selectInClass($query, $params, "Maquina");
		
		return $retorno[0];
	}
	
	public function ListarPorNome($obj){
		$query = "select * from maquina where nome = :nome";
		$params = array(':nome' => $obj->nome());
		$retorno = $this->db->selectInClass($query, $params, "Maquina");
		
		return $retorno;
	}
	

	function listar($numeroRegistros,$pagina,$order){
		$query = "SELECT * FROM Maquina ORDER BY :order LIMIT :limit OFFSET :offset ";
		$params[":order"] = $order;
		$params[":limit"] = $numeroRegistros;
		$params[":offset"] = ($pagina - 1) * $numeroRegistros;
		$list = $this->db->selectInClass($query, $params, "Maquina");
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
		$query = "insert into maquina (
			            id, nome, potencia, valor, tamanho, status)
			    select max(id) + 1, :nome, :potencia, :valor, :tamanho, :status from jogo";
			    
		$params[":nome"] = $obj->nome;
		$params[":potencia"] = $obj->potencia;
		$params[":valor"] = $obj->valor;
		$param[":tamanho"] = $obj->tamanho;
		$params[":status"] = $obj->status;
				
		return $this->db->execute($query, $params);	
	}
	
	function Update(){
		$query = "update maquina set nome = :nome, potencia = :potencia, tamanho =:tamanho, valor = :valor, status = :status
				  where id = :id";
		$params[":nome"] = $this->nome;
		$params[":potencia"] = $this->potencia;
		$params[":valor"] = $this->valor;
		$param[":tamanho"] = $obj->tamanho;
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