<?php

class Usuarios extends Controllers
{
	public function __construct()
	{
		parent::__construct();
		isLogin();
		getPermisos(2);
	}

	public function Usuarios()
	{
		if (empty($_SESSION['permisosMod']['r'])) {
			header("Location:" . base_url() . '/dashboard');
		}
		$data['page_tag'] = "Usuarios";
		$data['page_id'] = 2;
		$data['page_title'] = "USUARIOS <small>Tienda Virtual</small>";
		$data['page_name'] = "usuarios";
		$data['page_roles'] = $this->model->selectRoles();
		$data['page_functions_js'] = "functions_usuarios.js";
		$this->views->getView($this, "usuarios", $data);
	}
	public function regUsuario()
	{
		if (!$_POST) {
			$arrResponse = array("status" => false, "msg" => 'Metodo no encontrado');
			json($arrResponse);
			die();
		}
		if (
			empty($_POST['txtIdentificacion']) ||
			empty($_POST['txtNombre']) ||
			empty($_POST['txtApellido']) ||
			empty($_POST['txtTelefono']) ||
			empty($_POST['txtEmail']) ||
			empty($_POST['listRolid']) ||
			empty($_POST['listStatus']) ||
			empty($_POST['txtPassword'])
		) {
			$arrResponse = array("status" => false, "msg" => 'Los campos son obligatorios');
			json($arrResponse);
			die();
		}
		$strIdentificacion = strClean($_POST['txtIdentificacion']);
		$strNombre = ucwords(strClean($_POST['txtNombre']));
		$strApellido = ucwords(strClean($_POST['txtApellido']));
		$intTelefono = intval(strClean($_POST['txtTelefono']));
		$strEmail = strtolower(strClean($_POST['txtEmail']));
		$intTipoId = intval(strClean($_POST['listRolid']));
		$intStatus = intval(strClean($_POST['listStatus']));
		$strPassword = strClean($_POST['txtPassword']);
		//validacion de atributos duplicados
		$request = $this->model->selectUsuarioDNI($strIdentificacion);
		if ($request) {
			$arrResponse = array("status" => false, "msg" => 'DNI ya se encuentra registrado');
			json($arrResponse);
			die();
		}
		$request = $this->model->selectUsuarioEmail($strEmail);
		if ($request) {
			$arrResponse = array("status" => false, "msg" => 'Email ya se encuentra registrado');
			json($arrResponse);
			die();
		}
		//end validacion
		$strPassword = password_hash($strPassword, PASSWORD_DEFAULT);
		$request = $this->model->insertUsuario(
			$strIdentificacion,
			$strNombre,
			$strApellido,
			$intTelefono,
			$strEmail,
			$strPassword,
			$intTipoId,
			$intStatus
		);
		if ($request) {
			$arrResponse = array("status" => true, "msg" => 'Registro de usuario correcto');
			json($arrResponse);
			die();
		} else {
			$arrResponse = array("status" => false, "msg" => 'No se completo el registro del usuario');
			json($arrResponse);
			die();
		}
	}
	public function updUsuario()
	{
		if (!$_POST) {
			$arrResponse = array("status" => false, "msg" => 'Metodo no encontrado');
			json($arrResponse);
			die();
		}
		if (
			empty($_POST["idEdit"]) ||
			empty($_POST['txtIdentificacionEdit']) ||
			empty($_POST['txtNombreEdit']) ||
			empty($_POST['txtApellidoEdit']) ||
			empty($_POST['txtTelefonoEdit']) ||
			empty($_POST['txtEmailEdit']) ||
			empty($_POST['listRolidEdit']) ||
			$_POST['listStatusEdit'] == ""
		) {
			$arrResponse = array(
				"status" => false,
				"msg" => 'Complete los campos obligatorios'
			);
			json($arrResponse);
			die();
		}
		$intId = strClean($_POST["idEdit"]);
		$strIdentificacion = strClean($_POST['txtIdentificacionEdit']);
		$strNombre = ucwords(strClean($_POST['txtNombreEdit']));
		$strApellido = ucwords(strClean($_POST['txtApellidoEdit']));
		$intTelefono = intval(strClean($_POST['txtTelefonoEdit']));
		$strEmail = strtolower(strClean($_POST['txtEmailEdit']));
		$intTipoId = intval(strClean($_POST['listRolidEdit']));
		$intStatus = intval(strClean($_POST['listStatusEdit']));
		$strPassword = strClean($_POST['txtPasswordEdit']);

		$strPassword = password_hash($strPassword, PASSWORD_DEFAULT);
		$request = $this->model->updateUsuario(
			$intId,
			$strIdentificacion,
			$strNombre,
			$strApellido,
			$intTelefono,
			$strEmail,
			$strPassword,
			$intTipoId,
			$intStatus
		);
		if ($request) {
			$arrResponse = array("status" => true, "msg" => 'Registro de usuario  actualizado correcto');
			json($arrResponse);
			die();
		} else {
			$arrResponse = array("status" => false, "msg" => 'No se completo la actualizacion del registro de usuario');
			json($arrResponse);
			die();
		}
	}
	public function getUsuarios()
	{
		if ($_SESSION['permisosMod']['r']) {
			$arrData = $this->model->selectUsuarios();
			foreach ($arrData as $key => $value) {
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';

				if ($arrData[$key]['status'] == 1) {
					$arrData[$key]['status'] = '<span class="badge badge-success">Activo</span>';
				} else {
					$arrData[$key]['status'] = '<span class="badge badge-danger">Inactivo</span>';
				}

				if ($_SESSION['permisosMod']['r']) {
					$btnView = '<button class="btn btn-info btn-sm btnView"
						data-dni="' . $value["identificacion"] . '"
						data-nombre="' . $value["nombres"] . '"
						data-apellidos="' . $value["apellidos"] . '"
						data-telefono="' . $value["telefono"] . '"
						data-email="' . $value["email_user"] . '"
						data-estado="' . $value["status"] . '"
						data-idRol="' . $value["idrol"] . '"
						data-nombreRol="' . $value["nombrerol"] . '" 
						data-fechaRegistro="' . $value["datecreated"] . '" 
						title="Ver usuario"><i class="far fa-eye"></i></button>';
				}
				if ($_SESSION['permisosMod']['u']) {
					if (
						($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrol'] == 1) ||
						($_SESSION['userData']['idrol'] == 1 and $arrData[$key]['idrol'] != 1)
					) {
						$btnEdit = '<button 
						class="btn btn-primary btn-sm btnEdit"  
						title="Editar usuario" 
						data-id="' . $value["idpersona"] . '"
						data-dni="' . $value["identificacion"] . '"
						data-nombre="' . $value["nombres"] . '"
						data-apellidos="' . $value["apellidos"] . '"
						data-telefono="' . $value["telefono"] . '"
						data-email="' . $value["email_user"] . '"
						data-estado="' . $value["status"] . '"
						data-idRol="' . $value["idrol"] . '"
						data-nombreRol="' . $value["nombrerol"] . '" ><i class="fas fa-pencil-alt"></i></button>';
					} else {
						$btnEdit = '<button class="btn btn-secondary btn-sm" disabled ><i class="fas fa-pencil-alt"></i></button>';
					}
				}
				if ($_SESSION['permisosMod']['d']) {
					if (
						($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrol'] == 1) ||
						($_SESSION['userData']['idrol'] == 1 and $arrData[$key]['idrol'] != 1) and
						($_SESSION['userData']['idpersona'] != $arrData[$key]['idpersona'])
					) {
						$btnDelete = '<button class="btn btn-danger btn-sm btnDel" data-nombre="' . $value["nombres"] . '" data-id="' . $value["idpersona"] . '" title="Eliminar usuario"><i class="far fa-trash-alt"></i></button>';
					} else {
						$btnDelete = '<button class="btn btn-secondary btn-sm" disabled ><i class="far fa-trash-alt"></i></button>';
					}
				}
				$arrData[$key]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
			}
			json($arrData);
		}
		die();
	}
	public function getUsuario($idpersona)
	{
		if ($_SESSION['permisosMod']['r']) {
			$idusuario = intval($idpersona);
			if ($idusuario > 0) {
				$arrData = $this->model->selectUsuario($idusuario);
				if (empty($arrData)) {
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				} else {
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}
	public function delUsuario()
	{
		if ($_POST) {
			if ($_SESSION['permisosMod']['d']) {
				$intIdpersona = intval($_POST['idUsuario']);
				$requestDelete = $this->model->deleteUsuario($intIdpersona);
				if ($requestDelete) {
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario');
				} else {
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario.');
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}
	public function perfil()
	{
		$data['page_tag'] = "Perfil";
		$data['page_title'] = "Perfil de usuario";
		$data['page_name'] = "perfil";
		$data['page_functions_js'] = "functions_usuarios.js";
		$this->views->getView($this, "perfil", $data);
	}
	public function putPerfil()
	{
		if ($_POST) {
			if (empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono'])) {
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			} else {
				$idUsuario = $_SESSION['idUser'];
				$strIdentificacion = strClean($_POST['txtIdentificacion']);
				$strNombre = strClean($_POST['txtNombre']);
				$strApellido = strClean($_POST['txtApellido']);
				$intTelefono = intval(strClean($_POST['txtTelefono']));
				$strPassword = "";
				if (!empty($_POST['txtPassword'])) {
					$strPassword = password_hash($_POST['txtPassword'], PASSWORD_DEFAULT);
				}
				$request_user = $this->model->updatePerfil(
					$idUsuario,
					$strIdentificacion,
					$strNombre,
					$strApellido,
					$intTelefono,
					$strPassword
				);
				if ($request_user) {
					sessionUser($_SESSION['idUser']);
					$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
				} else {
					$arrResponse = array("status" => false, "msg" => 'No es posible actualizar los datos.');
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}
	public function putDFical()
	{
		if ($_POST) {
			if (empty($_POST['txtNit']) || empty($_POST['txtNombreFiscal']) || empty($_POST['txtDirFiscal'])) {
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			} else {
				$idUsuario = $_SESSION['idUser'];
				$strNit = strClean($_POST['txtNit']);
				$strNomFiscal = strClean($_POST['txtNombreFiscal']);
				$strDirFiscal = strClean($_POST['txtDirFiscal']);
				$request_datafiscal = $this->model->updateDataFiscal(
					$idUsuario,
					$strNit,
					$strNomFiscal,
					$strDirFiscal
				);
				if ($request_datafiscal) {
					sessionUser($_SESSION['idUser']);
					$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
				} else {
					$arrResponse = array("status" => false, "msg" => 'No es posible actualizar los datos.');
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}
}
