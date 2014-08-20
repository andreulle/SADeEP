<?php
include_once("../DAO/Dao.class.php");
include_once("../Modelo/Usuario.class.php");
include_once("../HtmlLayout/HtmlLayout.class.php");

$layout =  new HtmlLayout("html/".str_replace("php", "html", basename($_SERVER['PHP_SELF'])));
$usuario = new Usuario();



$layout->htmlIncludes("html_static_include", "html/include/base_header.html");
$layout->htmlIncludes("nav_bar", "html/include/nav_bar.html");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$usuario->setFromPostbackForm();
	if(!empty($_POST["usuarioId"]) && $_POST["usuarioId"] != "new"){
		if($usuario->Update()){
			$layout->cutText("aInserir");
			$layout->cutText("NaoInserido");
		}else{
			$layout->cutText("aInserir");
			$layout->cutText("InseridoComSucesso");
		}
	}else{
		if($usuario->Insert()){
			$layout->cutText("aInserir");
			$layout->cutText("NaoInserido");
		}else{
			$layout->cutText("aInserir");
			$layout->cutText("InseridoComSucesso");
		}
	}
}else{
	$layout->cutText("Inserido");
	if(!empty($_GET["id"]) && $_GET["id"] != "new"){
			$usuario->setUsuarioId($_GET["id"]);
			$layout->changeValue("UserAction", "Edição de Usuário");
			$usuario->Buscar($usuario);
			$layout->changeValue("usuarioId", $usuario->getUsuarioId());
			$layout->changeValue("usuarioNome", $usuario->getUsuarioNome());
			$layout->changeValue("usuarioEmail", $usuario->getUsuarioEmail());
			$layout->changeValue("usuarioRa", $usuario->getUsuarioRa());
	}else{
		$layout->changeValue("UserAction", "Inclusão de Usuário");
		$layout->changeValue("usuarioId", "new");
		$layout->changeValue("usuarioNome", "");
		$layout->changeValue("usuarioEmail",  "");
		$layout->changeValue("usuarioRa",  "");
	}
	
}
echo $layout->getLayout();
?>