<?php
include_once("../Interface/IModelo.class.php");
/**
 * 
 */
class Adm extends Usuario {
	public $idadm;
	public $nome;
	private $db;
	
	function __construct() {
		$this->db = new DAO();
	}
	
	public function buscar($obj){
		$query = "select * from adm_sistema where idadm = :idadm";
		$params = array(':idadm' => $obj->idadm);
		$retorno = $this->db->selectInClass($query, $params, "Adm");
		
		return $retorno[0];
	}
	
	public function buscarLogin($_login){
		$query = "select a.* from adm_sistema a inner join usuario u ON u.id_usuario = a.id_usuario where u.login = :login";
		$params = array(':login' => $_login);
		$retorno = $this->db->selectInClass($query, $params, "Adm");
		
		return $retorno[0];
	}
	
	public function buscarNome($obj){
		$query = "SELECT * FROM Aluno WHERE Nome = :Nome";
		$params = array(':Nome' => $obj->Nome());
		$retorno = $this->db->selectInClass($query, $params, "Aluno");
		
		return $this->montarObjeto($obj, $retorno[0]);
	}
	

	function listar($numeroRegistros,$pagina,$order){
		$query = "SELECT * FROM Aluno ORDER BY :order LIMIT :limit OFFSET :offset ";
		$params[":order"] = $order;
		$params[":limit"] = $numeroRegistros;
		$params[":offset"] = ($pagina - 1) * $numeroRegistros;
		$list = $this->db->selectInClass($query, $params, "Aluno");
		/*$usuarioList = array();
		$count = 0;
		foreach($list as $usuario){
			$usuarioList[$count] = new Usuario();
			$this->montarObjeto($usuarioList[$count], $usuario);
			$count++;
		}*/
		
		return $list;
	}
	
	function listarAssync($nome){
		$query = "select * from aluno where nome ilike :nome order by nome limit 10 ";
		$params[":nome"] = "%".$nome."%";
		
		$list = $this->db->selectInClass($query, $params, "Aluno");
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
		
		$query = "insert into aluno (ra, nome, email, status, grupoid, dadoscurso)
			    values (:ra, :nome, :email, :status, :grupoid, :dadoscurso) ";
			    
		$params[":nome"] = $this->nome;
		$params[":email"] = $this->email;
		$params[":status"] = $this->status;
		$params[":grupoid"] = $this->grupoid;
		$params[":ra"] = $this->ra;
		$params[":dadoscurso"] = $this->dadoscurso;
		
		return $this->db->execute($query, $params);	
	}
	
	function Update(){
		$query = "update aluno set nome = :nome, email = :email, status = :status, dadoscurso = :dadoscurso
				  where ra = :ra";
		$params[":ra"] = $this->ra;
		$params[":nome"] = $this->nome;
		$params[":email"] = $this->email;
		$params[":status"] = $this->status;
		$params[":dadoscurso"] = $this->dadoscurso;
		
		return $this->db->execute($query, $params);	
	}
	 
	 public function setFromPostbackForm(){
	 	foreach($_POST as $name => $value){
	 		$this->$name = $value;
		}
	 }
	
}
?>