<?php 
session_start();
include_once("../DAO/Dao.class.php");
include_once("../Modelo/Grupo.class.php");
include_once("../HtmlLayout/HtmlLayout.class.php");
include_once("_header.php");

$layout = new HtmlLayout("html/grupoListar.html",TRUE);
$layout->includes('header', $incHeader->getLayout());
$layout->includesJs("footerIncludes");
$layout->cutText("footerIncludes");

$grupo = new Grupo();
$grupos = $grupo->listarPorEmpresa($_SESSION["idaluno"], 10, ($_GET["pag"] == ""? 1:$_GET["pag"]), "nome");


if(count($grupos) == 0){
	$layout->cutText("Tabela");
}else{
	foreach ($grupos as $key => $value) {
		$layout->listItem("listarGrupos");
		$layout->changeValue("nome", $value->nome);
		$layout->changeValue("id", $value->id);
		$layout->changeValue("id", $value->id);
	}
	$layout->cutText("nada");
	$layout->cutText("listarGrupos");
}

echo $layout->getLayout();


 ?>