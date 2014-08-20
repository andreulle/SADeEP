<?php 
session_start();
include_once("../DAO/Dao.class.php");
include_once("../Modelo/Usuario.class.php");
include_once("../Modelo/Professor.class.php");
include_once("../HtmlLayout/HtmlLayout.class.php");
include_once("_header.php");

$layout = new HtmlLayout("html/professorListar.html", TRUE);
$layout->includes('header', $incHeader->getLayout());
$layout->includesJs("footerIncludes");
$layout->cutText("footerIncludes");

$professor = new Professor();
$professores = $professor->listarPorInstituicao($_GET["id"], 10, ($_GET["pag"] == ""? 1:$_GET["pag"]), "nome");

$layout->changeAllValue("id_instituicao", $_GET["id"]);

if(count($professores) == 0){
	$layout->cutText("Tabela");
}else{
	foreach ($professores as $key => $value) {
		$layout->listItem("listarProfessores");
		$layout->changeValue("nome", $value->nome);
		$layout->changeValue("id_professor", $value->id_professor);
		$layout->changeValue("id_professor", $value->id_professor);
	}
	$layout->cutText("nada");
	$layout->cutText("listarProfessores");
}

echo $layout->getLayout();


 ?>