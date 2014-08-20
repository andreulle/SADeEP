<?php
session_start();
include_once("../DAO/Dao.class.php");
include_once("../HtmlLayout/HtmlLayout.class.php");
include_once("../Modelo/Grupo.class.php");
include_once("../Modelo/Usuario.class.php");
include_once("../Modelo/Aluno.class.php");
include_once("../Modelo/Integrante.class.php");

$layout = new HtmlLayout("html/integrantesEdit.html",TRUE);
$layout->includesJs("footerIncludes");

$integrantes = new Integrante();
$integrantes->grupo = new Grupo();
$integrantes->grupo->id = $_GET["idgrupo"];
$integrantes->grupo = $integrantes->grupo->buscar($integrantes->grupo);

$layout->changeAllValue("nomeGrupo", $integrantes->grupo->nome);
$layout->changeAllValue("grupoid", $integrantes->grupo->id);


if($_POST){
		$integrantes->grupo = new Grupo();
		$integrantes->aluno = new Aluno();
		$integrantes->setFromPostbackForm();
		$integrantes->status = 0;
		$integrantes->Insert();
		header("location: integrantesGrupo.php?id=".$_POST["grupoid"]);
			
}else{
		$layout->changeAllValue("nome", "");
		$layout->changeAllValue("cargo", "");
		$integrantes = $integrantes->ListarPorGrupo($integrantes);
		
		echo $layout->getLayout();
}
?>