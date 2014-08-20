<?php
include_once("../DAO/Dao.class.php");
include_once("../HtmlLayout/HtmlLayout.class.php");
include_once("../Modelo/Usuario.class.php");
include_once("_header.php");

$layout =  new HtmlLayout("html/".str_replace("php", "html", basename($_SERVER['PHP_SELF'])),TRUE);
$user =  new Usuario();

$layout->includes("header", $incHeader->getLayout());


echo $layout->getLayout();

?>