<?php session_start(); ?>
<?php #include("admin/functions.php"); ?>
<?php $page = $_GET['page']? $_GET['page']: 'home'; ?>
<?php #$url = getConfig("url_site"); ?>
<?php $url = "http://localhost:8080/ENJEDI/prototipo%201/"; ?>
<?php

ob_start(); // Novo buffer
include("$page.php");
$content = ob_get_contents(); // Armazena o content
ob_end_clean(); // Limpa o bffer e fecha
?>
<?php ob_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php include("_head.php"); ?>
</head>

<body>
<div id="wrapper">
<div class="bgWrap">
	<?php
	include("_header.php");
	$top = ob_get_contents(); // Armazena até o momento
	ob_end_clean(); // Limpa o buffer e fecha
	
	ob_start(); // Novo Buffer
	echo $top; // Monta o Top
	echo $content; // Monta o Conteudo
	?>
</div>
</div>
<?php include("_footer.php"); ?>
</body>
</html>
<?php
ob_flush();
ob_end_clean();
?>
