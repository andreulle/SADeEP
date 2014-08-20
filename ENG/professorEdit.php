<?php 
session_start();
include_once("../DAO/Dao.class.php");
include_once("../Modelo/Grupo.class.php");
include_once("../HtmlLayout/HtmlLayout.class.php");
include_once("_header.php");

$layout = new HtmlLayout("html/professorEdit.html", TRUE);
$layout->includes('header', $incHeader->getLayout());


if($_POST){
	$professor = new Professor();
	$professor->setFromPostbackForm();
	$layout->changeValue("id_professor",$professor->id_professor);
	
	
	if($grupo->id !="new"){
		$grupo->Update();
	}else{
	    $grupo->Insert();
	}
	header("location: professorListar.php");
}else{	
	$layout->changeValue("id_professor", $_GET['id'] != "" ? $_GET['id'] : "new");
	$layout->changeValue("id_instituicao", $_GET['id_instituicao']);
	$layout->changeValue("responsavel",$_SESSION['ra']);
	if($_GET['id']!= "new"){
		$grupo = new Grupo();
		$grupo->id = $_GET['id'];
		$grupo = $grupo->buscar($grupo);
		$layout->changeValue("nome", $grupo->nome);
		$layout->changeValue("selected".$grupo->status, "selected='selected'");
		
	}else{
		$layout->changeValue("nome", "");
	}
	
	echo $layout->getLayout();
}





 ?>