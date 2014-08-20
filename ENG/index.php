<?php
session_start();
include_once("../DAO/Dao.class.php");
include_once("../HtmlLayout/HtmlLayout.class.php");
include_once("../Modelo/Usuario.class.php");
include_once("../Modelo/Aluno.class.php");
include_once("../Modelo/Adm.class.php");

$layout =  new HtmlLayout("html/".str_replace("php", "html", basename($_SERVER['PHP_SELF'])),FALSE);

$layout->changeAllValue("title", "SADeEP - Login de Usuário");

if($_POST){
	$usuario = new Usuario();
	$usuario = $usuario->Valida($_POST["login"], $_POST["senha"]);
	if($usuario[0]['validar_usuario'] != null){
		
		switch($usuario[0]['validar_usuario']){
			case "Aluno":
				$aluno =  new Aluno();
				$aluno = $aluno->buscarLogin($_POST["login"]);
				$layout->cutText("errorMessage");
				$_SESSION["logado"] = true;	
				$_SESSION["idUsuario"] = $aluno->id;
				$_SESSION["idaluno"] = $aluno->idaluno;
				$_SESSION["login"] = $_POST["login"];
				$_SESSION["nome"] = $aluno->nome;
				$_SESSION["tipo"] = "Aluno";
				header("location: principal.php");
				break;
			case "Professor":
				echo "oioioi";
				break;
			case "Adm":
				$adm = new Adm();
				$adm = $adm->buscarLogin($_POST["login"]);
				$layout->cutText("errorMessage");
				$_SESSION["logado"] = true;	
				$_SESSION["idUsuario"] = $adm->id_usuario;
				$_SESSION["idadm"] = $adm->idAdm;
				$_SESSION["login"] = $_POST["login"];
				$_SESSION["nome"] = $adm->nome;
				$_SESSION["tipo"] = "Adm";
				header("location: principal.php");
				break;
			default:
				$layout->changeAllValue("errorMessage", "");
		}
		
		
	}
	$layout->changeAllValue("errorMessage", "");
}else{
	$layout->cutText("errorMessage");
}

echo $layout->getLayout();

?>