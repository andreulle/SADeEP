<?php
include_once("../DAO/Dao.class.php");
include_once("../HtmlLayout/HtmlLayout.class.php");
include_once("../Modelo/Usuario.class.php");
include_once("../Modelo/Aluno.class.php");

$layout =  new HtmlLayout("html/".str_replace("php", "html", basename($_SERVER['PHP_SELF'])),FALSE);

$layout->changeAllValue("title", "SADeEP - Novo Usuário");

if($_POST){
	$usuario =  new Usuario();
	$usuario->aluno = new Aluno();
	
	$usuario->setFromPostbackForm();
	
	$verifica =  new Usuario();
	$verifica = $verifica->buscarRa($usuario);
	
	echo $verifica->id;
	if($verifica->id != null){
		$layout->changeValue("message", "O RA informado já está cadastrado!");
	}else{
		if($usuario->Insert()){
			$layout->changeValue("message", "Você foi cadastrado com sucesso!<br/> Aguarde a aprovação do administrador do sistema!");
		}else{
			$layout->changeValue("message", "Houve um erro ao tentar inserir!");
		} 
	}
	
	$layout->cutText("formEdit");
}else{
	$layout->cutText("msgReturn");
}

echo $layout->getLayout();

?>