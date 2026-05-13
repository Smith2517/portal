<?php

class UsuariosModel extends Mysql
{
	private $intIdUsuario;
	private $strIdentificacion;
	private $strNombre;
	private $strApellido;
	private $intTelefono;
	private $strEmail;
	private $strPassword;
	private $strToken;
	private $intTipoId;
	private $intStatus;
	private $strNit;
	private $strNomFiscal;
	private $strDirFiscal;

	public function __construct()
	{
		parent::__construct();
	}
	public function insertUsuario(
		string $identificacion,
		string $nombre,
		string $apellido,
		int $telefono,
		string $email,
		string $password,
		int $tipoid,
		int $status
	) {
		$this->strIdentificacion = $identificacion;
		$this->strNombre = $nombre;
		$this->strApellido = $apellido;
		$this->intTelefono = $telefono;
		$this->strEmail = $email;
		$this->strPassword = $password;
		$this->intTipoId = $tipoid;
		$this->intStatus = $status;
		$query  = "INSERT INTO `persona` (`identificacion`, `nombres`, `apellidos`, `telefono`, `email_user`, `password`, `rolid`, `status`) 
					VALUES (?,?,?,?,?,?,?,?);";
		$arrData = array(
			$this->strIdentificacion,
			$this->strNombre,
			$this->strApellido,
			$this->intTelefono,
			$this->strEmail,
			$this->strPassword,
			$this->intTipoId,
			$this->intStatus
		);
		$request = $this->insert($query, $arrData);
		return $request;
	}
	public function selectUsuarios()
	{
		$whereAdmin = "";
		if ($_SESSION['idUser'] != 1) {
			$whereAdmin = " and p.idpersona != 1 and p.idpersona != 13";
		}
		$sql = "SELECT p.idpersona,p.identificacion,p.nombres,p.apellidos,p.telefono,p.email_user,p.status,r.idrol,r.nombrerol,p.datecreated 
					FROM persona p 
					INNER JOIN rol r
					ON p.rolid = r.idrol
					WHERE p.status != 2 " . $whereAdmin;
		$request = $this->select_all($sql);
		return $request;
	}
	public function selectUsuario(int $idpersona)
	{
		$this->intIdUsuario = $idpersona;
		$sql = "SELECT p.idpersona,p.identificacion,p.nombres,p.apellidos,p.telefono,p.email_user,p.nit,p.nombrefiscal,p.direccionfiscal,r.idrol,r.nombrerol,p.status, DATE_FORMAT(p.datecreated, '%d-%m-%Y') as fechaRegistro 
					FROM persona p
					INNER JOIN rol r
					ON p.rolid = r.idrol
					WHERE p.idpersona = ?";
		$request = $this->select($sql, [$this->intIdUsuario]);
		return $request;
	}
	public function updateUsuario(
		int $idUsuario,
		string $identificacion,
		string $nombre,
		string $apellido,
		int $telefono,
		string $email,
		string $password,
		int $tipoid,
		int $status
	) {

		$this->intIdUsuario = $idUsuario;
		$this->strIdentificacion = $identificacion;
		$this->strNombre = $nombre;
		$this->strApellido = $apellido;
		$this->intTelefono = $telefono;
		$this->strEmail = $email;
		$this->strPassword = $password;
		$this->intTipoId = $tipoid;
		$this->intStatus = $status;
		if ($this->strPassword == "") {
			$query = "UPDATE `persona` SET 
			`identificacion`=?, 
			`nombres`=?, 
			`apellidos`=?, 
			`telefono`=?, 
			`email_user`=?, 
			`rolid`=?, 
			`status`=? 
			WHERE  
			`idpersona`=?;";
			$arrData = array(
				$this->strIdentificacion,
				$this->strNombre,
				$this->strApellido,
				$this->intTelefono,
				$this->strEmail,
				$this->intTipoId,
				$this->intStatus,
				$this->intIdUsuario
			);
		} else {
			$query = "UPDATE `persona` SET 
			`identificacion`=?, 
			`nombres`=?, 
			`apellidos`=?, 
			`telefono`=?, 
			`email_user`=?, 
			`password`=?, 
			`rolid`=?, 
			`status`=? 
			WHERE  
			`idpersona`=?;";
			$arrData = array(
				$this->strIdentificacion,
				$this->strNombre,
				$this->strApellido,
				$this->intTelefono,
				$this->strEmail,
				$this->strPassword,
				$this->intTipoId,
				$this->intStatus,
				$this->intIdUsuario
			);
		}
		$resquest = $this->update($query, $arrData);
		return $resquest;
	}
	public function deleteUsuario(int $intIdpersona)
	{
		$this->intIdUsuario = $intIdpersona;
		$sql = "DELETE FROM `persona` WHERE  `idpersona`= ?;";
		$request = $this->delete($sql, [$this->intIdUsuario]);
		return $request;
	}
	public function updatePerfil(int $idUsuario, string $identificacion, string $nombre, string $apellido, int $telefono, string $password)
	{
		$this->intIdUsuario = $idUsuario;
		$this->strIdentificacion = $identificacion;
		$this->strNombre = $nombre;
		$this->strApellido = $apellido;
		$this->intTelefono = $telefono;
		$this->strPassword = $password;

		if ($this->strPassword != "") {
			$sql = "UPDATE persona SET identificacion=?, nombres=?, apellidos=?, telefono=?, password=? 
						WHERE idpersona = ?";
			$arrData = array(
				$this->strIdentificacion,
				$this->strNombre,
				$this->strApellido,
				$this->intTelefono,
				$this->strPassword,
                $this->intIdUsuario
			);
		} else {
			$sql = "UPDATE persona SET identificacion=?, nombres=?, apellidos=?, telefono=? 
						WHERE idpersona = ?";
			$arrData = array(
				$this->strIdentificacion,
				$this->strNombre,
				$this->strApellido,
				$this->intTelefono,
                $this->intIdUsuario
			);
		}
		$request = $this->update($sql, $arrData);
		return $request;
	}
	public function updateDataFiscal(int $idUsuario, string $strNit, string $strNomFiscal, string $strDirFiscal)
	{
		$this->intIdUsuario = $idUsuario;
		$this->strNit = $strNit;
		$this->strNomFiscal = $strNomFiscal;
		$this->strDirFiscal = $strDirFiscal;
		$sql = "UPDATE persona SET nit=?, nombrefiscal=?, direccionfiscal=? 
						WHERE idpersona = ?";
		$arrData = array(
			$this->strNit,
			$this->strNomFiscal,
			$this->strDirFiscal,
            $this->intIdUsuario
		);
		$request = $this->update($sql, $arrData);
		return $request;
	}
	public function selectRoles()
	{
		$query = "SELECT*FROM rol AS r WHERE r.`status`=1";
		$request = $this->select_all($query);
		return $request;
	}
	public function selectUsuarioDNI(string $dni)
	{
		$this->strIdentificacion = $dni;
		$query = "SELECT*FROM persona AS p WHERE p.identificacion= ?;";
		$request = $this->select_all($query, [$this->strIdentificacion]);
		return $request;
	}
	public function selectUsuarioEmail(string $email)
	{
		$this->strEmail = $email;
		$query = "SELECT*FROM persona AS p WHERE p.email_user= ?;";
		$request = $this->select_all($query, [$this->strEmail]);
		return $request;
	}
}
?>
