<?php
session_start();
include_once("../DAO/Dao.class.php");
include_once("../HtmlLayout/HtmlLayout.class.php");
include_once("../Modelo/Grupo.class.php");
include_once("../Modelo/Usuario.class.php");
include_once("../Modelo/Aluno.class.php");
include_once("../Modelo/Integrante.class.php");

$layout = new HtmlLayout("html/integrantesGrupo.html",TRUE);

$integrantes = new Integrante();
$integrantes->grupo = new Grupo();
$integrantes->grupo->id = $_GET["id"];
$integrantes->grupo = $integrantes->grupo->buscar($integrantes->grupo);

$layout->changeAllValue("nomeGrupo", $integrantes->grupo->nome);
$layout->changeAllValue("idGrupo", $integrantes->grupo->id);

$integrantes = $integrantes->ListarPorGrupo($integrantes);

if(count($integrantes) <= 0){
	$layout->cutText("Tabela");
}else{
	foreach ($integrantes as $key => $value) {
		$layout->listItem("listarIntegrantes");
		$value->aluno = $value->aluno->buscar($value->aluno);
		$layout->changeValue("nome", $value->aluno->nome);
		$layout->changeValue("ra", $value->aluno->idaluno);
		$layout->changeValue("status", ($value->status == 0 ? "Pendente" : "Ativo"));
		$layout->changeValue("cargo", $value->cargo);
	}
	
	$layout->cutText("nada");
	$layout->cutText("listarIntegrantes");
}

echo $layout->getLayout();

?>