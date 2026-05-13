<?php

class Login extends Controllers
{
	public function __construct()
	{
		// session_start(name_sesion());
		exist_login();
		// session_start();
		parent::__construct();
	}

	public function login()
	{
		$data['page_tag'] = "Login - MDESV";
		$data['page_title'] = "CPANEL - MDESV";
		$data['page_name'] = "login";
		$data['page_functions_js'] = "functions_login.js";
		$this->views->getView($this, "login", $data);
	}

	public function loginUser()
	{
		// json($_POST); die;
		if (!$_POST) {
			$arrResponse = array('status' => false, 'msg' => 'Error de datos, metodo no encontrado');
			json($arrResponse);
			die();
		}
		if (empty($_POST['txtEmail']) || empty($_POST['txtPassword'])) {
			$arrResponse = array('status' => false, 'msg' => 'Los campos son obligatorios');
			json($arrResponse);
			die();
		}

		$strUsuario = strtolower(strClean($_POST['txtEmail']));
		$strPasswordRaw = $_POST['txtPassword']; // No limpiar caracteres en passwords
		$requestUser = $this->model->loginUser($strUsuario);
		if (empty($requestUser)) {
			$arrResponse = array('status' => false, 'msg' => 'El usuario o la contraseña es incorrecto.');
			json($arrResponse);
			die();
		}

		$arrData = $requestUser;
		$password_hash = $arrData['password'];
		$password_correct = false;

		if (password_verify($strPasswordRaw, $password_hash)) {
			$password_correct = true;
		} else {
			// Fallback a encriptación antigua
			$strPasswordOld = encryption($strPasswordRaw);
			if ($strPasswordOld === $password_hash) {
				$password_correct = true;
				// Migración silenciosa a bcrypt
				$new_hash = password_hash($strPasswordRaw, PASSWORD_DEFAULT);
				$this->model->updatePasswordDirect($arrData['idpersona'], $new_hash);
			} else {
			    // Intentar también con SHA256 que se usaba en recuperar cuenta
			    $strPasswordSha = hash("SHA256", $strPasswordRaw);
			    if ($strPasswordSha === $password_hash) {
			        $password_correct = true;
			        $new_hash = password_hash($strPasswordRaw, PASSWORD_DEFAULT);
				    $this->model->updatePasswordDirect($arrData['idpersona'], $new_hash);
			    }
			}
		}

		if (!$password_correct) {
			$arrResponse = array('status' => false, 'msg' => 'El usuario o la contraseña es incorrecto.');
			json($arrResponse);
			die();
		}

		$arrData = $requestUser;
		if ($arrData['status'] == 1) {
			$_SESSION['idUser'] = $arrData['idpersona'];
			$_SESSION['login'] = true;
			$arrData = $this->model->sessionLogin($_SESSION['idUser']);
			sessionUser($_SESSION['idUser']);
			$arrResponse = array('status' => true, 'msg' => 'ok', 'session' => $_SESSION);
			json($arrResponse);
			die();
		} else {
			$arrResponse = array('status' => false, 'msg' => 'El usuario se encuentra inactivo.');
			json($arrResponse);
			die();
		}
	}

	public function resetPass()
	{
		if ($_POST) {
			error_reporting(0);

			if (empty($_POST['txtEmailReset'])) {
				$arrResponse = array('status' => false, 'msg' => 'Error de datos');
			} else {
				$token = token();
				$strEmail = strtolower(strClean($_POST['txtEmailReset']));
				$arrData = $this->model->getUserEmail($strEmail);

				if (empty($arrData)) {
					$arrResponse = array('status' => false, 'msg' => 'Usuario no existente.');
				} else {
					$idpersona = $arrData['idpersona'];
					$nombreUsuario = $arrData['nombres'] . ' ' . $arrData['apellidos'];

					$url_recovery = base_url() . '/login/confirmUser/' . $strEmail . '/' . $token;
					$requestUpdate = $this->model->setTokenUser($idpersona, $token);

					$dataUsuario = array(
						'nombreUsuario' => $nombreUsuario,
						'email' => $strEmail,
						'asunto' => 'Recuperar cuenta - ' . NOMBRE_REMITENTE,
						'url_recovery' => $url_recovery
					);
					if ($requestUpdate) {
						$sendEmail = sendEmail($dataUsuario, 'email_cambioPassword');

						if ($sendEmail) {
							$arrResponse = array(
								'status' => true,
								'msg' => 'Se ha enviado un email a tu cuenta de correo para cambiar tu contraseña.'
							);
						} else {
							$arrResponse = array(
								'status' => false,
								'msg' => 'No es posible realizar el proceso, intenta más tarde.'
							);
						}
					} else {
						$arrResponse = array(
							'status' => false,
							'msg' => 'No es posible realizar el proceso, intenta más tarde.'
						);
					}
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function confirmUser(string $params)
	{

		if (empty($params)) {
			header('Location: ' . base_url());
		} else {
			$arrParams = explode(',', $params);
			$strEmail = strClean($arrParams[0]);
			$strToken = strClean($arrParams[1]);
			$arrResponse = $this->model->getUsuario($strEmail, $strToken);
			if (empty($arrResponse)) {
				header("Location: " . base_url());
			} else {
				$data['page_tag'] = "Cambiar contraseña";
				$data['page_name'] = "cambiar_contrasenia";
				$data['page_title'] = "Cambiar Contraseña";
				$data['email'] = $strEmail;
				$data['token'] = $strToken;
				$data['idpersona'] = $arrResponse['idpersona'];
				$data['page_functions_js'] = "functions_login.js";
				$this->views->getView($this, "cambiar_password", $data);
			}
		}
		die();
	}

	public function setPassword()
	{

		if (empty($_POST['idUsuario']) || empty($_POST['txtEmail']) || empty($_POST['txtToken']) || empty($_POST['txtPassword']) || empty($_POST['txtPasswordConfirm'])) {

			$arrResponse = array(
				'status' => false,
				'msg' => 'Error de datos'
			);
		} else {
			$intIdpersona = intval($_POST['idUsuario']);
			$strPassword = $_POST['txtPassword'];
			$strPasswordConfirm = $_POST['txtPasswordConfirm'];
			$strEmail = strClean($_POST['txtEmail']);
			$strToken = strClean($_POST['txtToken']);

			if ($strPassword != $strPasswordConfirm) {
				$arrResponse = array(
					'status' => false,
					'msg' => 'Las contraseñas no son iguales.'
				);
			} else {
				$arrResponseUser = $this->model->getUsuario($strEmail, $strToken);
				if (empty($arrResponseUser)) {
					$arrResponse = array(
						'status' => false,
						'msg' => 'Erro de datos.'
					);
				} else {
					$strPasswordHash = password_hash($strPassword, PASSWORD_DEFAULT);
					$requestPass = $this->model->insertPassword($intIdpersona, $strPasswordHash);

					if ($requestPass) {
						$arrResponse = array(
							'status' => true,
							'msg' => 'Contraseña actualizada con éxito.'
						);
					} else {
						$arrResponse = array(
							'status' => false,
							'msg' => 'No es posible realizar el proceso, intente más tarde.'
						);
					}
				}
			}
		}
		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
	}
}
