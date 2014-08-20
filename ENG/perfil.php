<?php
session_start();
include_once("../DAO/Dao.class.php");
include_once("../HtmlLayout/HtmlLayout.class.php");
include_once("../Modelo/Usuario.class.php");
include_once("../Modelo/Aluno.class.php");

$layout =  new HtmlLayout("html/perfil.html", TRUE);

$aluno = new Aluno();
$aluno->ra = $_SESSION["ra"];
$aluno = $aluno->buscar($aluno);

$layout->changeValue("nome", $aluno->nome);
$layout->changeValue("email", $aluno->email);

echo $layout->getLayout();

?>