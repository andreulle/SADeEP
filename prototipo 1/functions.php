<?php

$url = getConfig("url_admin");
$temp_files = "../media/temp/";
$configuracoes = getAllConfigs();

function conecta() {
	$conexao = mysql_pconnect("localhost", "apta", "apta9630");
	mysql_select_db("banco_de_dados", $conexao);
	return $conexao;
}

$connect = conecta();

function getConfig($nome) {
	$q = mysql_query("SELECT parametro FROM config WHERE nome = '$nome'", conecta());
	$d = mysql_fetch_array($q);
	return $d['parametro'];
}

function getAllConfigs() {
	$q = mysql_query("SELECT nome, parametro FROM config", conecta());
	while($d = mysql_fetch_array($q, MYSQL_ASSOC)){
		$conf[$d['nome']] = $d['parametro'];
	}
	return $conf;
}

function autorizar($acao) {
	if($_SESSION['id_usuario'] == 0){
		return;
	}else{
		$sql = "SELECT up.id FROM usuarios_permissoes up
				INNER JOIN tabelas t ON t.id = up.tabelas_id
				WHERE t.tabela = '$acao' AND up.usuarios_id = {$_SESSION['id_usuario']}";
		$query = mysql_query($sql,conecta());
		if(mysql_num_rows($query)>0){
			return;
		}else{
			header("Location: {$url}acessonegado");
		}
	}
}

function EspeciaUpper($char) {
	return strtr($char, "áàãâéêíóôõúüç", "ÁÀÃÂÉÊÍÓÔÕÚÜÇ");
}

function upperAll($string){
	$string = utf8_encode(strtoupper($string));
	$low = array("á","à","ã","â","é","è","ê","í","ì","î","ó","ò","õ","ô","ú","ù","û","ç","ª","º","°");
	$up =  array("Á","À","Ã","Â","É","È","Ê","Í","Ì","Î","Ó","Ò","Õ","Ô","Ú","Ù","Û","Ç","ª","º","°");
	$string = str_replace($low, $up, $string);
	return $string;
}

function removeAndLowerSpecialChars($imageName) {
	$remove = array(
		"á"=>"a", "à"=>"a", "ã"=>"a", "â"=>"a", "ä"=>"a", "Á"=>"a", "À"=>"a", "Ã"=>"a", "Â"=>"a", "Ä"=>"a", "é"=>"e", "è"=>"e", "ê"=>"e", "ë"=>"e", "É"=>"e", "È"=>"e", "Ê"=>"e", "Ë"=>"e",
		"í"=>"i", "ì"=>"i", "î"=>"i", "ï"=>"i", "Í"=>"i", "Ì"=>"i", "Î"=>"i", "Ï"=>"i", "ó"=>"o", "ò"=>"o", "õ"=>"o", "ô"=>"o", "ö"=>"o", "Ó"=>"o", "Ò"=>"o", "Õ"=>"o", "Ô"=>"o", "Ö"=>"o",
		"ú"=>"u", "ù"=>"u", "û"=>"u", "ü"=>"u", "Ú"=>"u", "Ù"=>"u", "Û"=>"u", "Ü"=>"u", "ç"=>"c", "Ç"=>"c", "ñ"=>"n", "Ñ"=>"n", " "=>"_", "&"=>"_", "%"=>"_", "$"=>"_",
		"A"=>"a", "B"=>"b", "C"=>"c", "D"=>"d", "E"=>"e", "F"=>"f", "G"=>"g", "H"=>"h", "I"=>"i", "J"=>"j", "K"=>"k", "L"=>"l", "M"=>"m", "N"=>"n", "O"=>"o", "P"=>"p", "Q"=>"q", "R"=>"r",
		"S"=>"s", "T"=>"t", "U"=>"u", "V"=>"v", "W"=>"w", "X"=>"x", "Y"=>"y", "Z"=>"z", "/"=>"-", "º"=>"_", "ª"=>"_", "°"=>"_", "," => "", "." => ""
	);
	return strtr($imageName, $remove);
}

function proxID($tabela, $where='') {
	$s = "Select max(id) from $tabela $where";
	$connect = conecta();
	$query = mysql_query($s, $connect);
	if($dados = mysql_fetch_array($query)) {
		if($dados['max(id)'] < 1) {
			$proxID = 1;
		} else {
			$proxID = $dados['max(id)'] + 1;
		}
	} else {
		$proxID = 1;
	}
	return $proxID;
}

function maxID($tabela) {
	$sqlid = "Select max(id) from $tabela";
	$connect = conecta();
	$query = mysql_query($sqlid, $connect);
	$dados = mysql_fetch_array($query);
	$maxID = $dados['max(id)'];

	return $maxID;
}

function logado() {
	if((!isset($_SESSION['nome']) or empty($_SESSION['nome'])) or (!isset($_SESSION['logado']) or empty($_SESSION['logado'])))
		return false;
	else
		return true;
}

function is_valid_youtube($link) {
	if(preg_match('/youtube.com\\/watch\\?.*v=.*$/', $link)) {
		return true;
	} else {
		return false;
	}
}

function is_date($str) {
	$stamp = strtotime($str);
	if(!is_numeric($stamp)) {
		return FALSE;
	}
	$month = date('m', $stamp);
	$day = date('d', $stamp);
	$year = date('Y', $stamp);

	if(checkdate($month, $day, $year)) {
		return TRUE;
	}
	return FALSE;
}

function right($value, $count) {
	$value = substr($value, (strlen($value) - $count), strlen($value));
	return $value;
}

function retirar_caracteres_especiais($frase) {
	$a = 'áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ &%$QWERTYUIOPASDFGHJKLZXCVBNM';
	$b = 'aaaaeeiooouucaaaaeeiooouuc____qwertyuiopasdfghjklzxcvbnm';
	$frase = utf8_decode($frase);
	$frase = strtr($frase, utf8_decode($a), $b);
	return (utf8_decode($frase));
}

function removeSpecialChars($imageName) {
	$remove = array(
		"á"=>"a", "à"=>"a", "ã"=>"a", "â"=>"a", "ä"=>"a", "Á"=>"A", "À"=>"A", "Ã"=>"A", "Â"=>"A", "Ä"=>"A",
		"é"=>"e", "è"=>"e", "ê"=>"e", "ë"=>"e", "É"=>"E", "È"=>"E", "Ê"=>"E", "Ë"=>"E",
		"í"=>"i", "ì"=>"i", "î"=>"i", "ï"=>"i", "Í"=>"I", "Ì"=>"I", "Î"=>"I", "Ï"=>"I",
		"ó"=>"o", "ò"=>"o", "õ"=>"o", "ô"=>"o", "ö"=>"o", "Ó"=>"O", "Ò"=>"O", "Õ"=>"O", "Ô"=>"O", "Ö"=>"O",
		"ú"=>"u", "ù"=>"u", "û"=>"u", "ü"=>"u", "Ú"=>"U", "Ù"=>"U", "Û"=>"U", "Ü"=>"U",
		"ç"=>"c", "Ç"=>"C",
		"ñ"=>"n", "Ñ"=>"N",
		" "=>"_",
		"&"=>"_",
		"%"=>"_",
		"$"=>"_"
	);
	return strtr($imageName, $remove);
}

function tempFiles() {
	return 'media/temp/';
}

function formatDate($date, $format) {
	return $date != '' ? date($format, strtotime(str_replace('/', '-', $date))) : '';
}

function translateDay($day) {
	if($day == "Monday") {
		$day = "Segunda-feira";
	} elseif($day == "Tuesday") {
		$day = "Terça-feira";
	} elseif($day == "Wednesday") {
		$day = "Quarta-feira";
	} elseif($day == "Thursday") {
		$day = "Quinta-feira";
	} elseif($day == "Friday") {
		$day = "Sexta-feira";
	} elseif($day == "Saturday") {
		$day = "Sábado";
	} elseif($day == "Sunday") {
		$day = "Domingo";
	}
	return $day;
}

function translateDayShort($day) {
	if($day == "Monday") {
		$day = "Seg";
	} elseif($day == "Tuesday") {
		$day = "Ter";
	} elseif($day == "Wednesday") {
		$day = "Qua";
	} elseif($day == "Thursday") {
		$day = "Qui";
	} elseif($day == "Friday") {
		$day = "Sex";
	} elseif($day == "Saturday") {
		$day = "Sáb";
	} elseif($day == "Sunday") {
		$day = "Dom";
	}
	return $day;
}

function translateMonth($month) {
	if($month == "January") {
		$month = "Janeiro";
	} elseif($month == "February") {
		$month = "Fevereiro";
	} elseif($month == "March") {
		$month = "Março";
	} elseif($month == "April") {
		$month = "Abril";
	} elseif($month == "May") {
		$month = "Maio";
	} elseif($month == "June") {
		$month = "Junho";
	} elseif($month == "July") {
		$month = "Julho";
	} elseif($month == "August") {
		$month = "Agosto";
	} elseif($month == "September") {
		$month = "Setembro";
	} elseif($month == "October") {
		$month = "Outubro";
	} elseif($month == "November") {
		$month = "Novembro";
	} elseif($month == "December") {
		$month = "Dezembro";
	}
	return $month;
}

function translateShortMonth($month) {
	if($month == "Jan") {
		$month = "Jan";
	} elseif($month == "Feb") {
		$month = "Fev";
	} elseif($month == "March") {
		$month = "Mar";
	} elseif($month == "Apr") {
		$month = "Abr";
	} elseif($month == "May") {
		$month = "Mai";
	} elseif($month == "Jun") {
		$month = "Jun";
	} elseif($month == "Jul") {
		$month = "Jul";
	} elseif($month == "Aug") {
		$month = "Ago";
	} elseif($month == "Sep") {
		$month = "Set";
	} elseif($month == "Oct") {
		$month = "Out";
	} elseif($month == "Nov") {
		$month = "Nov";
	} elseif($month == "Dec") {
		$month = "Dez";
	}
	return $month;
}

function getBaseUrl() {
	$folder = substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);
	$pageURL = 'http';
	if($_SERVER["SERVER_PORT"] == 443) {$pageURL .= "s";}
	$pageURL .= "://";
	$pageURL .= $_SERVER['SERVER_NAME'] . $folder;
	return $pageURL;
}

function upper($str) {
	$LATIN_UC_CHARS = “ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝ;
	$LATIN_LC_CHARS = “àáâãäåæçèéêëìíîïðñòóôõöøùúûüý;
	$str = strtr($str, $LATIN_LC_CHARS, $LATIN_UC_CHARS);
	$str = strtoupper($str);
	return $str;
}

if(!function_exists('imageconvolution')) {
	function imageconvolution($src, $filter, $filter_div, $offset) {
		if($src == NULL) {
			return 0;
		}

		$sx = imagesx($src);
		$sy = imagesy($src);
		$srcback = ImageCreateTrueColor($sx, $sy);
		ImageCopy($srcback, $src, 0, 0, 0, 0, $sx, $sy);

		if($srcback == NULL) {
			return 0;
		}

		#FIX HERE
		#$pxl array was the problem so simply set it with very low values
		$pxl = array(1, 1);
		#this little fix worked for me as the undefined array threw out errors

		for($y = 0; $y < $sy; ++$y) {
			for($x = 0; $x < $sx; ++$x) {
				$new_r = $new_g = $new_b = 0;
				$alpha = imagecolorat($srcback, $pxl[0], $pxl[1]);
				$new_a = $alpha>>24;

				for($j = 0; $j < 3; ++$j) {
					$yv = min(max($y - 1 + $j, 0), $sy - 1);
					for($i = 0; $i < 3; ++$i) {
						$pxl = array(min(max($x - 1 + $i, 0), $sx - 1), $yv);
						$rgb = imagecolorat($srcback, $pxl[0], $pxl[1]);
						$new_r += (($rgb>>16) & 0xFF) * $filter[$j][$i];
						$new_g += (($rgb>>8) & 0xFF) * $filter[$j][$i];
						$new_b += ($rgb & 0xFF) * $filter[$j][$i];
					}
				}

				$new_r = ($new_r / $filter_div) + $offset;
				$new_g = ($new_g / $filter_div) + $offset;
				$new_b = ($new_b / $filter_div) + $offset;

				$new_r = ($new_r > 255) ? 255 : (($new_r < 0) ? 0 : $new_r);
				$new_g = ($new_g > 255) ? 255 : (($new_g < 0) ? 0 : $new_g);
				$new_b = ($new_b > 255) ? 255 : (($new_b < 0) ? 0 : $new_b);

				$new_pxl = ImageColorAllocateAlpha($src, (int)$new_r, (int)$new_g, (int)$new_b, $new_a);
				if($new_pxl == -1) {
					$new_pxl = ImageColorClosestAlpha($src, (int)$new_r, (int)$new_g, (int)$new_b, $new_a);
				}
				if(($y >= 0) && ($y < $sy)) {
					imagesetpixel($src, $x, $y, $new_pxl);
				}
			}
		}
		imagedestroy($srcback);
		return 1;
	}

}

function rrmdir($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
			}
		}
		reset($objects);
		rmdir($dir);
	}
}

function eco($el){
	echo utf8_encode($el);
}

function numFBR($numero) {
	return number_format($numero, 2, ',', '.');
}

function save($data, $table, $id=null, $where=''){
	$tipo = $id==null? 1: 2;
	
	if ($id==null){
		$id = proxID($table, $where);
		$sql .= "INSERT INTO $table (id, ";
		$fields = count ($data);
		$i=0;
		foreach ($data as $key => $value) {
			$i++;
			$sql .= $key;
			$sql .= $i < $fields ? ', ' : '';
		}
		$sql .= ") VALUES ($id, ";
		
		$i=0;
		foreach ($data as $key => $value) {
			$i++;
			$sql .= '"' . $value . '"';
			$sql .= $i < $fields ? ',' : '';
		}
		$sql .= ')';
	} else {
		$sql .= "UPDATE $table SET ";
		$fields = count ($data);
		$i=0;
		foreach ($data as $key => $value) {
			$i++;
			$sql .= $key . " = '$value'";
			$sql .= $i < $fields ? ', ' : '';
		}
		$sql .= " WHERE id = $id";
	}
	
	if($table != "log") makeLog($data, $table, $id, $tipo);
	
	$connect = conecta();
	$query = mysql_query($sql, $connect);
	return $id;
}

function excluir($table, $where){
	$q = mysql_query("SELECT * FROM $table WHERE $where", conecta());
	while($d = mysql_fetch_array($q, MYSQL_ASSOC)){
		$data[] = $d;
	}
	makeLog($data, $table, $where, 3);
	mysql_query("DELETE FROM $table WHERE $where", conecta());
}

function removeWordChars($string) {
	if(!is_array($string)){
		$search = array('“'=>'\"','”'=>'\"',"‘"=>"\'","’"=>"\'","–"=>"-","'"=>"\'","•"=>"&bull;", "\"" => "\\\"");
		$string = strtr($string, $search);
	}
	return $string;
}

function breakTitleB($title){
	$tituloArray = explode(" ", $title);
	$titleB = "<b>";
	$i = 1;
	$c = 1;
	$r = count($tituloArray);
	foreach($tituloArray as $t){
		$titleB .= $t." ";
		if($i == 5){
			if($c <> $r) $titleB .= "</b><b>";
			$i = 1;
		}
		$i++;
		$c++;
	}
	$titleB .= "</b>";
	return $titleB;
}

function antiInjection($string){
	$string = str_replace("\\", "\\\\", $string);
	$string = str_replace("'", "\'", $string);
	$string = str_replace('"', '\"', $string);
	return $string;
}

function shortenText($string, $size=50, $ret='...'){
	$text = explode(" ", $string);
	$c = 0;
	$a = count(str_split($string));
	foreach ($text as $s){
		$nC = str_split($s, 1);
		$n = count($nC);
		if($c + $n > $size) {$c--; break;}
		else $c += $n + 1;
	}
	if($a <= $size) $ret = "";
	return substr($string, 0, $c).$ret;
}

function getYoutubeVideoId($link){
	parse_str(parse_url($link, PHP_URL_QUERY), $yt);
	return $yt['v'];
}

function debug($texto){
	mysql_query("INSERT INTO debug(id,log) VALUES(".proxID('debug').", '$texto')", conecta());
}

function logadoSite($tipo){
	switch ($tipo) {
		case 'modelos':
			if($_SESSION['site']['modelo_id']) return true;
			else return false;
		break;
		case 'contratantes':
			if($_SESSION['site']['contratantes_id']) return true;
			else return false;
		break;
	}
}

function getAge($birthday){
	$dN = explode("-", formatDate($birthday, "m-d-Y"));
	return (date("md", date("U", mktime(0, 0, 0, $dN[0], $dN[1], $dN[2]))) > date("md") ? ((date("Y")-$dN[2])-1) : (date("Y")-$dN[2]));
}

function getUf($uf=''){
	$ufs = array("AC","AL","AP","AM","BA","CE","DF","ES","GO","MA","MT","MS","MG","PA","PB","PR","PE","PI","RJ","RN","RS","RO","RR","SC","SP","SE","TO");
	foreach($ufs as $u){
		$estados .= "<option value=\"$u\""; if($uf==$u) $estados .= ' selected="selected"';	$estados .= ">$u</option>\n";
	}
	return $estados;
}

function getFirstThumb($id, $tabela){
	$q = mysql_query("SELECT imagem FROM {$tabela}_imagens WHERE {$tabela}_id = $id ORDER BY ordem ASC LIMIT 1");
	$d = mysql_fetch_array($q);
	return $d['imagem'];
}

function retirar_caracteres_mapa($frase) {
	$a = 'áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ';
	$b = 'aaaaeeiooouucAAAAEEIOOOUUC+';
	$frase = strtr($frase, utf8_decode($a), $b);
	return (utf8_decode($frase));
}

function formatDecimal($value){
	$value = str_replace(".", "", $value);
	$value = str_replace(",", ".", $value);
	return $value;
}

function getField($campo, $tabela, $where){
	$q = mysql_query("SELECT $campo FROM $tabela WHERE $where LIMIT 1");
	$d = mysql_fetch_array($q);
	return utf8_encode($d["$campo"]);
}

function generateSelect($campo, $titulo, $query, $compare=null){
	$select = "<select name=\"$campo\" id=\"$campo\">";
	$select .= "<option value=\"\"></option>";
	while($dados = mysql_fetch_array($query)){
		$select .= "<option";
		if($dados["id"] == $compare) $select .= ' selected="selected"';
		$select .= " value=\"{$dados["id"]}\">".$dados[$titulo]."</option>";
	}
	$select .= "</select>";
	return utf8_encode($select);
}

function anti_sql_injection($str) {
    if (!is_numeric($str)) {
        $str = get_magic_quotes_gpc() ? stripslashes($str) : $str;
        $str = function_exists('mysql_real_escape_string') ? mysql_real_escape_string($str) : mysql_escape_string($str);
    }
    return $str;
}

function makeLog($dadosAtual=array(), $tabela, $id_where, $tipo=1){
	$new = str_replace('"', '\"', json_encode($dadosAtual));
	$data = array(
		"usuarios_id" => $_SESSION['id_usuario'],
		"data" => date('Y-m-d H:i:s'),
		"tabela" => $tabela,
		"tipo" => $tipo,
		"json_pos" => $new,
		"browser" => $_SERVER['HTTP_USER_AGENT']
	);
	if($tipo==1){
		$data["observacoes"] = "INSERT na tabela: $tabela, id: $id_where";
	}elseif($tipo==2){
		$q = mysql_query("SELECT * FROM $tabela WHERE id = $id_where");
		$dadosAntigos = mysql_fetch_array($q, MYSQL_ASSOC);
		$old = str_replace('"', '\"', json_encode($dadosAntigos));
		$data["json_pre"] = $old;
		$data["observacoes"] = "UPDATE na tabela: $tabela, id: $id_where";
	}elseif($tipo==3){
		$data['json_pre'] = $data['json_pos'];
		unset($data['json_pos']);
		$data["observacoes"] = utf8_decode("DELETE na tabela: $tabela, where: $id_where");
	}
	save($data, "log");
}


?>