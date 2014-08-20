<?php 
session_start();
include_once("../DAO/Dao.class.php");
include_once("../Modelo/Instituicao.class.php");
include_once("../HtmlLayout/HtmlLayout.class.php");
include_once("_header.php");

$layout = new HtmlLayout("html/instituicaoEdit.html", TRUE);
$layout->includes('header', $incHeader->getLayout());


if($_POST){
	$instituicao = new Instituicao();
	$instituicao->setFromPostbackForm();
	$layout->changeValue("id_instituicao",$instituicao->id_instituicao);
	
	if($instituicao->id_instituicao !="new"){
		$instituicao->Update();
	}else{
	    $instituicao->Insert();
	}
	header("location: instituicaoListar.php");
}else{	
	$layout->changeValue("id_instituicao", $_GET['id'] != "" ? $_GET['id'] : "new");
	if($_GET['id']!= "new"){
		$instituicao = new Instituicao();
		$instituicao->id_instituicao = $_GET['id'];
		$instituicao = $instituicao->buscar($instituicao);
		$layout->changeValue("nome", $instituicao->nome);
		$layout->changeValue("selected".$instituicao->status, "selected='selected'");
		
	}else{
		$layout->changeValue("nome", "");
	}
	
	echo $layout->getLayout();
}





 ?>