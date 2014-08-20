<?php
include_once("../DAO/Dao.class.php");
include_once("../Modelo/Aluno.class.php");
include_once("../HtmlLayout/HtmlLayout.class.php");
include_once("_header.php");

$layout = new HtmlLayout("html/alunoEdit.html",TRUE);
$layout->includes("header", $incHeader->getLayout());

if($_POST){
	$aluno = new Aluno();
	$aluno->setFromPostbackForm();
	
	$verifica = new Aluno();
	$verifica = $verifica->buscar($aluno);
	
	
	if($verifica->ra != null){
		$aluno->Update();
	}else{
		$aluno->Insert();
	}
}

echo $layout->getLayout();

?>