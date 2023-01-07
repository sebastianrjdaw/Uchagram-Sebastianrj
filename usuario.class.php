<?php 
// Clase - Usuario 
// Uchagram

class usuario
{
    private $rol;
    private $username;
    private $password;

	private $codigo;


	public function getRol() {
		return $this->rol;
	}
	

	public function setRol($rol): self {
		$this->rol = $rol;
		return $this;
	}

	public function getUsername() {
		return $this->username;
	}
	

	public function setUsername($username): self {
		$this->username = $username;
		return $this;
	}


	public function getPassword() {
		return $this->password;
	}
	

	public function setPassword($password): self {
		$this->password = $password;
		return $this;
	}

	public function getCodigo() {
		return $this->codigo;
	}
	

	public function setCodigo($codigo): self {
		$this->codigo = $codigo;
		return $this;
	}
	

    public function __construct($rol,$username,$password,$codigo)
    {
        $this->rol = $rol;
        $this->username = $username;
        $this->password= $password;
		$this->codigo = $codigo;
    }
	public function obtenerNombre($codigo)
	{
		if ($codigo == $this->codigo) {
			return $this->username;
		}
	}
	public function obtenerCodigo($username)
	{
		if ($username == $this->username) {
			return $this->codigo;
		}
	}
}


?>