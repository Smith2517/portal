<?php

class LoginModel extends Mysql
{
	private $intIdUsuario;
	private $strUsuario;
	private $strPassword;
	private $strToken;
	public function __construct()
	{
		parent::__construct();
	}
	public function loginUser(string $usuario)
	{
	    
		$this->strUsuario = $usuario;
		$sql = "SELECT idpersona, status, password FROM persona WHERE 
					email_user = ? and 
					status != 0 ";
		$request = $this->select($sql, [$this->strUsuario]);
		return $request;
	}
	public function sessionLogin(int $iduser)
	{
		$this->intIdUsuario = $iduser;
		//BUSCAR ROLE 
		$sql = "SELECT p.idpersona,
							p.identificacion,
							p.nombres,
							p.apellidos,
							p.telefono,
							p.email_user,
							p.nit,
							p.nombrefiscal,
							p.direccionfiscal,
							r.idrol,r.nombrerol,
							p.status 
					FROM persona p
					INNER JOIN rol r
					ON p.rolid = r.idrol
					WHERE p.idpersona = ?";
		$request = $this->select($sql, [$this->intIdUsuario]);
		$_SESSION['userData'] = $request;
		return $request;
	}
	public function getUserEmail(string $strEmail)
	{
		$this->strUsuario = $strEmail;
		$sql = "SELECT idpersona,nombres,apellidos,status FROM persona WHERE 
					email_user = ? and  
					status = 1 ";
		$request = $this->select($sql, [$this->strUsuario]);
		return $request;
	}
	public function setTokenUser(int $idpersona, string $token)
	{
		$this->intIdUsuario = $idpersona;
		$this->strToken = $token;
		$sql = "UPDATE persona SET token = ? WHERE idpersona = ? ";
		$arrData = array($this->strToken, $this->intIdUsuario);
		$request = $this->update($sql, $arrData);
		return $request;
	}
	public function getUsuario(string $email, string $token)
	{
		$this->strUsuario = $email;
		$this->strToken = $token;
		$sql = "SELECT idpersona FROM persona WHERE 
					email_user = ? and 
					token = ? and 					
					status = 1 ";
		$request = $this->select($sql, [$this->strUsuario, $this->strToken]);
		return $request;
	}
	public function insertPassword(int $idPersona, string $password)
	{
		$this->intIdUsuario = $idPersona;
		$this->strPassword = $password;
		$sql = "UPDATE persona SET password = ?, token = ? WHERE idpersona = ? ";
		$arrData = array($this->strPassword, "", $this->intIdUsuario);
		$request = $this->update($sql, $arrData);
		return $request;
	}
    public function updatePasswordDirect(int $idPersona, string $password)
	{
		$this->intIdUsuario = $idPersona;
		$this->strPassword = $password;
		$sql = "UPDATE persona SET password = ? WHERE idpersona = ? ";
		$arrData = array($this->strPassword, $this->intIdUsuario);
		$request = $this->update($sql, $arrData);
		return $request;
	}
}
?>