<?php
session_start();
include_once("../DAO/Dao.class.php");
include_once("../HtmlLayout/HtmlLayout.class.php");
include_once("../Modelo/Usuario.class.php");

$layout =  new HtmlLayout("html/".str_replace("php", "html", basename($_SERVER['PHP_SELF'])),TRUE);

echo $layout->getLayout();

?>