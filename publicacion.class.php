<?php
 class publicacion{
   private $codigo;
   private $titulo;
   private $texto;
   private $multimedia;
   private $dataPublicacion;
   private $codUsuario;

   public function getCodigo() {
	return $this->codigo;
}


public function setCodigo($codigo): self {
	$this->codigo = $codigo;
	return $this;
}
   
   public function getDataPublicacion() {
		return $this->dataPublicacion;
	}
	

	public function setDataPublicacion($dataPublicacion): self {
		$this->dataPublicacion = $dataPublicacion;
		return $this;
	}

   public function getMultimedia() {
		return $this->multimedia;;
	}
	

	public function setMultimedia($multimedia): self {
		$this->multimedia = $multimedia;
		return $this;
	}


   public function getTexto() {
		return $this->texto;
	}
	

	public function setTexto($texto): self {
		$this->texto = $texto;
		return $this;
	}

   public function getTitulo() {
		return $this->titulo;
	}
	

	public function setTitulo($titulo): self {
		$this->titulo = $titulo;
		return $this;
	}


   public function getCodUsuario() {
		return $this->codUsuario;
	}
	

	public function setCodUsuario($codUsuario): self {
		$this->codUsuario = $codUsuario;
		return $this;
	}

	

   public function __construct( $codigo, $titulo ,$texto, $multimedia, $dataPublicacion,$codUsuario){
      $this->codigo= $codigo;
	  $this->titulo = $titulo;
      $this->texto = $texto;
      $this->multimedia = $multimedia;
      $this->dataPublicacion = $dataPublicacion;
      $this->codUsuario= $codUsuario;
   }
   
   
   public function publicado($fechaProg){
	if($fechaProg>time()){
			return false;
	}else{
		return true;
	}
   }

   public function seguridadHTML($nivel){
	if($nivel==0){
		$this->texto=strip_tags($this->texto);
	 }else{
		$this->texto=strip_tags($this->texto, "<b><p><h1><h2>");
	  } 
   }

   public function moderacion($texto){
	$block=['tonto','feo'];
	$nuevoTexto = $texto;
	for ($i=0; $i <count($block) ; $i++) { 
		if(strstr($texto,$block[$i])){
		$nuevoTexto=str_replace($block[$i],$texto,'******');	
	}
	}
	return $nuevoTexto;
   }
 

}
