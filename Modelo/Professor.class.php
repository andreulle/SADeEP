<?php
include_once("../Interface/IModelo.class.php");
/**
 * 
 */
class Professor extends Usuario {
	public $id_professor;
	public $nome;
	private $db;
	
	function __construct() {
		$this->db = new DAO();
	}
	
	public function buscar($obj){
		$query = "select * from professor where id_professor = :id_professor";
		$params = array(':id_professor' => $obj->id_professor);
		$retorno = $this->db->selectInClass($query, $params, "Professor");
		
		return $retorno[0];
	}
	
	public function buscarLogin($_login){
		$query = "select p.* from professor p inner join usuario u ON u.id_usuario = p.id_usuario where u.login = :login";
		$params = array(':login' => $_login);
		$retorno = $this->db->selectInClass($query, $params, "Professor");
		
		return $retorno[0];
	}
	
	public function buscarNome($obj){
		$query = "SELECT * FROM professor WHERE nome = :nome";
		$params = array(':nome' => $obj->Nome());
		$retorno = $this->db->selectInClass($query, $params, "Professor");
		
		return $this->montarObjeto($obj, $retorno[0]);
	}
	

	function listar($numeroRegistros,$pagina,$order){
		$query = "SELECT * FROM professor ORDER BY :order LIMIT :limit OFFSET :offset ";
		$params[":order"] = $order;
		$params[":limit"] = $numeroRegistros;
		$params[":offset"] = ($pagina - 1) * $numeroRegistros;
		$list = $this->db->selectInClass($query, $params, "Professor");
		/*$usuarioList = array();
		$count = 0;
		foreach($list as $usuario){
			$usuarioList[$count] = new Usuario();
			$this->montarObjeto($usuarioList[$count], $usuario);
			$count++;
		}*/
		
		return $list;
	}
	
	function listarPorInstituicao($instituicao,$numeroRegistros,$pagina,$order){
		$query = "SELECT * FROM professor WHERE id_instituicao = :id_instituicao ORDER BY :order LIMIT :limit OFFSET :offset ";
		$params[":id_instituicao"] = $instituicao;
		$params[":order"] = $order;
		$params[":limit"] = $numeroRegistros;
		$params[":offset"] = ($pagina - 1) * $numeroRegistros;
		$list = $this->db->selectInClass($query, $params, "Professor");
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
		$query = "select * from professor where nome ilike :nome order by nome limit 10 ";
		$params[":nome"] = "%".$nome."%";
		
		$list = $this->db->selectInClass($query, $params, "Professor");
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
		
		$query = "insert into professor (id_professor, nome, email, status, grupoid, dadoscurso)
			    SELECT COALESCE(MAX(id_professor),0) + 1, :nome, :email, :status, :grupoid, :dadoscurso FROM professor ";
			    
		$params[":nome"] = $this->nome;
		$params[":email"] = $this->email;
		$params[":status"] = $this->status;
		$params[":grupoid"] = $this->grupoid;
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