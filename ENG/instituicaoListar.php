<?php 
session_start();
include_once("../DAO/Dao.class.php");
include_once("../Modelo/Instituicao.class.php");
include_once("../HtmlLayout/HtmlLayout.class.php");
include_once("_header.php");

$layout = new HtmlLayout("html/instituicaoListar.html", TRUE);
$layout->includes('header', $incHeader->getLayout());
$layout->includesJs("footerIncludes");
$layout->cutText("footerIncludes");

$instituicao = new Instituicao();
$instituicao = $instituicao->listar(10, ($_GET["pag"] == ""? 1:$_GET["pag"]), "nome");


if(count($instituicao) == 0){
	$layout->cutText("Tabela");
}else{
	foreach ($instituicao as $key => $value) {
		$layout->listItem("listarInstituicao");
		$layout->changeValue("nome", $value->nome);
		$layout->changeValue("id_instituicao", $value->id_instituicao);
		$layout->changeValue("id_instituicao", $value->id_instituicao);
	}
	$layout->cutText("nada");
	$layout->cutText("listarInstituicao");
}

echo $layout->getLayout();


 ?>