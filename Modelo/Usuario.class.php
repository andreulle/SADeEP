<?php
include_once("../Interface/IModelo.class.php");
/**
 * 
 */
class Usuario implements IModelo {
	public $id_usuario;
	public $login;
	public $senha;
	public $aluno;
	public $status;
	private $db;
	
	function __construct() {
		$this->db = new DAO();
	}
	
	
	/*
	 * Controle
	 */
	private $controle;
	
	/*
	 * Propriedades
	 */
	 public function getUsuarioId(){return $this->usuarioId;} 
	 public function setUsuarioId($value){ $this->usuarioId = $value;}
	 
	 public function getUsuarioNome(){return $this->usuarioNome;}
	 public function setUsuarioNome($value){ $this->usuarioNome = $value;}
	 
	 public function getUsuarioEmail(){return $this->usuarioEmail;}
	 public function setUsuarioEmail($value){ $this->usuarioEmail = $value;}
	 
	 public function getUsuarioRa(){return $this->usuarioRa;}
	 public function setUsuarioRa($value){ $this->usuarioRa = $value;}
	 
	 /*
	  * Métodos
	  */
	 public function buscar($obj){
		$query = "SELECT * FROM usuario WHERE id = :id";
		$params = array(':id' => $obj->id);
		$retorno = $this->db->selectInClass($query, $params, "Usuario");
		
		return $retorno[0];
	}
	
	/*public function buscarRa($obj){
		$query = "SELECT * FROM usuario WHERE ra = :ra";
		$params = array(':ra' => $obj->aluno->ra);
		$retorno = $this->db->selectInClass($query, $params, "Usuario");
		
		return $retorno[0];
	}*/
	
	public function Valida($_login,$_senha){
		$query = "SELECT validar_usuario(:login::VARCHAR,:senha::VARCHAR)";
		$params = array();
		$params[':login'] = $_login;
		$params[':senha'] = $_senha;
		
		$retorno = $this->db->select($query, $params);
		
		return $retorno;
	}


	function listarUsuarios($numeroRegistros,$pagina,$order){
		$query = "SELECT * FROM usuario ORDER BY :order LIMIT :limit OFFSET :offset ";
		$params[":order"] = $order;
		$params[":limit"] = $numeroRegistros;
		$params[":offset"] = ($pagina - 1) * $numeroRegistros;
		$list = $this->db->selectInClass($query, $params, "Usuario");
		$usuarioList = array();
		$count = 0;
		foreach($list as $usuario){
			$usuarioList[$count] = new Usuario();
			$this->montarObjeto($usuarioList[$count], $usuario);
			$count++;
		}
		
		return $usuarioList;
	}
	
	function InsertAluno(){
		$this->aluno->status = 0;
		$this->aluno->grupo = 0;
		$this->aluno->Insert();
		
		$this->status = 0;
		$query = "INSERT INTO usuario (
			            id, ra, senha, status)
			    SELECT COALESCE(MAX(id),0) + 1, :id_aluno, :senha, :status FROM usuario";
			    
		$params[":id_aluno"] = $this->aluno->ra;
		$params[":senha"] = $this->senha;
		$params[":status"] = $this->status;

		return $this->db->execute($query, $params);	
	}
	
	function Update(){
		$query = "UPDATE usuario SET senha = :senha, status = :status
				  WHERE id = :id";
		$params[":senha"] = $this->senha;
		$params[":id"] = $this->id;
		$params[":status"] = $this->status;
		
		return $this->db->execute($query, $params);	
	}
	 
	 
	 
	 public function setFromPostbackForm(){
	 	foreach($_POST as $name => $value){
	 		$this->$name = $value;
		}
		
		foreach($_POST as $name => $value){
	 		$this->aluno->$name = $value;
		}
	 }
	 
	 
	 
}

?>