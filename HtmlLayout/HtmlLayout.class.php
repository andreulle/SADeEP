<?php
/*
 .---------------------------------------------------------------------------.
|  Software: HtmlLayout PHP Html Manipulate Class                           |
|   Version: 1.0                                                            |
|   Contact: http://cargocollective.com/ulle							    |
| ------------------------------------------------------------------------- |
|    Author: André Ulle          								            |
| ------------------------------------------------------------------------- |
|   License: Distributed under the Lesser General Public License (LGPL)     |
|            http://www.gnu.org/copyleft/lesser.html                        |
| This program is distributed in the hope that it will be useful - WITHOUT  |
| ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or     |
| FITNESS FOR A PARTICULAR PURPOSE.                                         |
'---------------------------------------------------------------------------'
 * 
 */

class HtmlLayout {
	private $_getLayout;
	
	function __construct($_myLayout,$MasterLayout){
		
		$file = fopen(realpath($_myLayout), "r");
		if($MasterLayout){
			if(empty($_SESSION["logado"])){
				header("location: index.php");
				echo basename($_SERVER['PHP_SELF']);
			}
			$this->myTopIncludes();
		}
		
		$this->_getLayout = $this->_getLayout.stream_get_contents($file);
		
		if($MasterLayout){
			$this->myBotIncludes();
		}
		
		$this->context();
		
		fclose($file);
		//$this->includes();
		
	
	}
	
	function myTopIncludes(){
		$file = fopen(realpath("../ENG/html/include/_head.html"), "r");
		$incHeadLayout = stream_get_contents($file);
		$incHeadLayout = str_replace('%title%',"Sistema de Engenharia de Produção", $incHeadLayout);
		$incHeadLayout = str_replace('%url%',"html/" , $incHeadLayout);
		$incHeadLayout = str_replace('%nomeUser%',$_SESSION["nome"], $incHeadLayout);
		
		$this->includes("head", $incHeadLayout);
		fclose($file);
		$this->_getLayout = $incHeadLayout;
	}

	function context(){
		if(!empty($_SESSION["tipo"])){
			switch($_SESSION["tipo"]){
					case "Aluno":
						$this->cutText("professorMenu");
						$this->cutText("admMenu");
						break;
					case "Professor":
						$this->cutText("alunoMenu");
						$this->cutText("admMenu");
						break;
					case "Adm":
						$this->cutText("professorMenu");
						$this->cutText("alunoMenu");
						break;
					default:
						$this->cutText("professorMenu");
						$this->cutText("alunoMenu");
						$this->cutText("admMenu");
				}
		}else{
			//header("location: index.php");
		}
	}
	
	function myBotIncludes(){
		$file = fopen(realpath("../ENG/html/include/_footer.html"), "r");
		$incBotLayout = stream_get_contents($file);
		$incBotLayout = str_replace('%url%',"html/" , $incBotLayout);
		//$incHeadLayout = str_replace('%title%',"Sistema de Engenharia de Produção", $incHeadLayout);
		//$incHeadLayout = str_replace('%url%',"html/" , $incHeadLayout);
		$this->includes("head", $incBotLayout);
		
		fclose($file);
		$this->_getLayout = $this->_getLayout.$incBotLayout;
	}
	
	//Altera o Valor da pseudoVariável para cada ocorrência
	function changeValue($param,$replace){
		$this->_getLayout = preg_replace('/%'.$param.'%/' , $replace, $this->_getLayout,1);
	}
	
	//Altera o Valor da pseudoVariável em todas as ocorrências
	function changeAllValue($param,$replace){
		$this->_getLayout = str_replace("%".$param."%", $replace, $this->_getLayout);
	}
	
	//Cria um laço de repetição
	function listItem($param){
		preg_match('/(<!--%'.$param.'%-->)[\s\S]*(\<!--%'.$param.'%-->)/',$this->_getLayout,$matches);
		$list = str_replace('<!--%'.$param.'%-->',"",$matches[0]);
		$this->_getLayout = str_replace($matches[0], $list.$matches[0], $this->_getLayout);
	}
	
	function parcialList($param){
		$parcial = "";
		preg_match('/(<!--%'.$param.'%-->)(.|\\n)*(<!--%'.$param.'%-->)/',$this->_getLayout,$matches);
		$list = str_replace('<!--%'.$param.'%-->',"",$matches[0]);
		$parcial = str_replace($matches[0], $list.$matches[0],$list);
		return $parcial;
	}
	
	
	//Inclui arquivos comuns
	function includes($param,$inlcude){
		$this->_getLayout = preg_replace('(<!--%'.$param.'%-->)' , $inlcude, $this->_getLayout,1);
	}
	
	//Inclui arquivos comuns
	function htmlIncludes($param,$page){
		$file = fopen(realpath($page), "r");
		$subject = stream_get_contents($file);
		$this->_getLayout = preg_replace('(<!--%'.$param.'%-->)' , $subject, $this->_getLayout,1);
		fclose($file);
	}
	
	//Remove o encadeamento
	function cutText($param){
		preg_match('/(\<!--%'.$param.'%-->)[\s\S]*(\<!--%'.$param.'%-->)/',$this->_getLayout,$matches);
		$this->_getLayout = str_replace($matches[0], "", $this->_getLayout);
	}
	
	function includesJs($param){
		preg_match('/(\<!--%'.$param.'%-->)[\s\S]*(\<!--%'.$param.'%-->)/',$this->_getLayout,$matches);
		$this->_getLayout = str_replace($matches[0], "", $this->_getLayout);
		$this->_getLayout = str_replace("%jsSection%",$matches[0], $this->_getLayout);
	}
	
	function getLayout(){
		$this->changeAllValue("jsSection", "");
		return $this->_getLayout;
	}
	
}
?>