<?php
include_once("../Objetos/Controle/ProdutoControle.class.php");

class Produto implements IModelo{
	private $produto_id;
	private $produto_titulo;
	private $item_de_produto_codigo;
	private $produto_final;
	
	/*
	 * Controle
	 */
	private $controle;
	
	/*
	 * Construtor, Obrigatoriamente deverá ter chamar o método buscar
	 */
	function __construct($id) {
		$this->produto_id = $id;
		$this->controle = new ProdutoControle();
		$this->Buscar();
	}
	
	/*
	 * Propriedades
	 */
	 public function getProdutoID(){
	 	return $this->produto_id;
	 }
	 
	 public function getProdutoTitulo(){
	 	return $this->produto_titulo;
	 }
	 
	 public function setProdutoTitulo($value){
	 	$this->produto_titulo = $value;
	 }
	 
	 public function getItemDeProdutoCodigo(){
	 	return $this->item_de_produto_codigo;
	 }
	 
	 public function setItemDeProdutoCodigo($value){
	 	$this->item_de_produto_codigo = $value;
	 }
	 
	 public function getProdutoFinal(){
	 	return $this->produto_final;
	 }

	/*
	 * Métodos
	 */
	 public function Buscar(){
	 	$obj = $this->controle->Buscar($this);
	 }
}

?>