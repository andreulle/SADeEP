<?php
session_start();
include_once("../DAO/Dao.class.php");
include_once("../HtmlLayout/HtmlLayout.class.php");
include_once("../Modelo/Usuario.class.php");
include_once("../Modelo/Aluno.class.php");

$layout =  new HtmlLayout("html/_assyncAlunos.html", FALSE);
$aluno = new Aluno();
$alunos = $aluno->listarAssync($_POST["nome"]);

if(count($alunos) <=0 ){
	$layout->cutText("tabela");
	$layout->changeValue("msg", "Nenhum aluno foi encontrado!");
}else{
	foreach ($alunos as $key => $value) {
		$layout->listItem("listarGrupos");
		$layout->changeValue("ra", $value->idaluno);
		$layout->changeValue("nome", $value->nome);
	}
	$layout->cutText("mensagem");
}
$layout->cutText("listarGrupos");


echo $layout->getLayout();
?>