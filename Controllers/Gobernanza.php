<?php

class Gobernanza extends Controllers
{
	public function __construct()
	{
		parent::__construct();
		isLogin();
		// Verificar permisos si es necesario
		// getPermisos(ID_MODULO_GOBERNANZA);
	}

	public function gobernanza()
	{
		if (empty($_SESSION['permisosMod']['r'])) {
			header("Location:" . base_url() . '/dashboard');
		}
		$data['page_tag'] = "Gobernanza";
		$data['page_id'] = 13; // Asignar ID correspondiente
		$data['page_title'] = "Gobernanza";
		$data['page_name'] = "gobernanza";
		$data['page_functions_js'] = "functions_gobernanza.js";
		$this->views->getView($this, "gobernanza", $data);
	}

	// Métodos para Items
	public function getItems()
	{
		if ($_SESSION['permisosMod']['r']) {
			$arrData = $this->model->selectItems();
			$arrResponse = array('status' => true, 'data' => $arrData);
		} else {
			$arrResponse = array('status' => false, 'msg' => 'No tiene permiso para ver items.');
		}
		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
	}

	public function getItem($idItem)
	{
		if ($_SESSION['permisosMod']['r']) {
			$id = intval($idItem);
			if ($id > 0) {
				$arrData = $this->model->selectItem($id);
				if (empty($arrData)) {
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				} else {
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
			} else {
				$arrResponse = array('status' => false, 'msg' => 'ID inválido.');
			}
		} else {
			$arrResponse = array('status' => false, 'msg' => 'No tiene permiso para ver el item.');
		}
		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
	}

	public function setItem()
	{
		$option = "";
		if (!$_POST) {
			$arrResponse = array("status" => false, "msg" => 'Metodo no encontrado');
			json($arrResponse);
			die();
		}

		if (
			empty($_POST['txtNombre']) ||
			empty($_POST['listEstado'])
		) {
			$arrResponse = array("status" => false, "msg" => 'Los campos son obligatorios');
			json($arrResponse);
			die();
		}

		$idItem = intval($_POST['idItem']);
		$strNombre = strClean($_POST['txtNombre']);
		$strDescripcion = strClean($_POST['txtDescripcion']);
		$intOrden = intval($_POST['txtOrden']);
		$intEstado = intval($_POST['listEstado']);

		if ($idItem == 0) {
			// Crear nuevo item
			if ($_SESSION['permisosMod']['w']) {
				$request = $this->model->insertItem(
					$strNombre,
					$strDescripcion,
					$intOrden,
					$intEstado,
					$_SESSION['idUser']
				);

				if ($request > 0) {
					$arrResponse = array('status' => true, 'msg' => 'Item creado correctamente.');
				} else {
					$arrResponse = array('status' => false, 'msg' => 'No se pudo crear el item.');
				}
			} else {
				$arrResponse = array('status' => false, 'msg' => 'No tiene permiso para crear items.');
			}
		} else {
			// Actualizar item existente
			if ($_SESSION['permisosMod']['u']) {
				$request = $this->model->updateItem(
					$idItem,
					$strNombre,
					$strDescripcion,
					$intOrden,
					$intEstado
				);

				if ($request) {
					$arrResponse = array('status' => true, 'msg' => 'Item actualizado correctamente.');
				} else {
					$arrResponse = array('status' => false, 'msg' => 'No se pudo actualizar el item.');
				}
			} else {
				$arrResponse = array('status' => false, 'msg' => 'No tiene permiso para actualizar items.');
			}
		}

		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
	}

	public function delItem()
	{
		if ($_POST) {
			if ($_SESSION['permisosMod']['d']) {
				$intId = intval($_POST['idItem']);
				$requestDelete = $this->model->deleteItem($intId);

				if ($requestDelete) {
					$arrResponse = array('status' => true, 'msg' => 'Item eliminado correctamente.');
				} else {
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el item.');
				}
			} else {
				$arrResponse = array('status' => false, 'msg' => 'No tiene permiso para eliminar items.');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	// Métodos para Indicadores
	public function getIndicadoresByItem($idItem)
	{
		if ($_SESSION['permisosMod']['r']) {
			$itemId = intval($idItem);
			if ($itemId > 0) {
				$arrData = $this->model->selectIndicadoresByItem($itemId);
				$arrResponse = array('status' => true, 'data' => $arrData);
			} else {
				$arrResponse = array('status' => false, 'msg' => 'ID de item inválido.');
			}
		} else {
			$arrResponse = array('status' => false, 'msg' => 'No tiene permiso para ver indicadores.');
		}
		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
	}

	public function getIndicador($idIndicador)
	{
		if ($_SESSION['permisosMod']['r']) {
			$id = intval($idIndicador);
			if ($id > 0) {
				$arrData = $this->model->selectIndicador($id);
				if (empty($arrData)) {
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				} else {
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
			} else {
				$arrResponse = array('status' => false, 'msg' => 'ID inválido.');
			}
		} else {
			$arrResponse = array('status' => false, 'msg' => 'No tiene permiso para ver el indicador.');
		}
		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
	}

	public function setIndicador()
	{
		if (!$_POST) {
			$arrResponse = array("status" => false, "msg" => 'Metodo no encontrado');
			json($arrResponse);
			die();
		}

		if (
			empty($_POST['txtItemIdIndicador']) ||
			empty($_POST['txtNombreIndicador']) ||
			empty($_POST['listEstadoIndicador'])
		) {
			$arrResponse = array("status" => false, "msg" => 'Los campos son obligatorios');
			json($arrResponse);
			die();
		}

		$idIndicador = intval($_POST['idIndicador']);
		$intItemId = intval($_POST['txtItemIdIndicador']);
		$strNombre = strClean($_POST['txtNombreIndicador']);
		$strDescripcion = strClean($_POST['txtDescripcionIndicador']);
		$intOrden = intval($_POST['txtOrdenIndicador']);
		$intEstado = intval($_POST['listEstadoIndicador']);

		if ($idIndicador == 0) {
			// Crear nuevo indicador
			if ($_SESSION['permisosMod']['w']) {
				$request = $this->model->insertIndicador(
					$intItemId,
					$strNombre,
					$strDescripcion,
					$intOrden,
					$intEstado,
					$_SESSION['idUser']
				);

				if ($request > 0) {
					$arrResponse = array('status' => true, 'msg' => 'Indicador creado correctamente.');
				} else {
					$arrResponse = array('status' => false, 'msg' => 'No se pudo crear el indicador.');
				}
			} else {
				$arrResponse = array('status' => false, 'msg' => 'No tiene permiso para crear indicadores.');
			}
		} else {
			// Actualizar indicador existente
			if ($_SESSION['permisosMod']['u']) {
				$request = $this->model->updateIndicador(
					$idIndicador,
					$intItemId,
					$strNombre,
					$strDescripcion,
					$intOrden,
					$intEstado
				);

				if ($request) {
					$arrResponse = array('status' => true, 'msg' => 'Indicador actualizado correctamente.');
				} else {
					$arrResponse = array('status' => false, 'msg' => 'No se pudo actualizar el indicador.');
				}
			} else {
				$arrResponse = array('status' => false, 'msg' => 'No tiene permiso para actualizar indicadores.');
			}
		}

		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
	}

	public function delIndicador()
	{
		if ($_POST) {
			if ($_SESSION['permisosMod']['d']) {
				$intId = intval($_POST['idIndicador']);
				$requestDelete = $this->model->deleteIndicador($intId);

				if ($requestDelete) {
					$arrResponse = array('status' => true, 'msg' => 'Indicador eliminado correctamente.');
				} else {
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el indicador.');
				}
			} else {
				$arrResponse = array('status' => false, 'msg' => 'No tiene permiso para eliminar indicadores.');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	// Métodos para Archivos
	public function getArchivosByIndicador($idIndicador)
	{
		if ($_SESSION['permisosMod']['r']) {
			$indicadorId = intval($idIndicador);
			if ($indicadorId > 0) {
				$arrData = $this->model->selectArchivosByIndicador($indicadorId);
				$arrResponse = array('status' => true, 'data' => $arrData);
			} else {
				$arrResponse = array('status' => false, 'msg' => 'ID de indicador inválido.');
			}
		} else {
			$arrResponse = array('status' => false, 'msg' => 'No tiene permiso para ver archivos.');
		}
		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
	}

	public function getArchivo($idArchivo)
	{
		if ($_SESSION['permisosMod']['r']) {
			$id = intval($idArchivo);
			if ($id > 0) {
				$arrData = $this->model->selectArchivo($id);
				if (empty($arrData)) {
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				} else {
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
			} else {
				$arrResponse = array('status' => false, 'msg' => 'ID inválido.');
			}
		} else {
			$arrResponse = array('status' => false, 'msg' => 'No tiene permiso para ver el archivo.');
		}
		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
	}

	public function setArchivo()
	{
		if (!$_POST) {
			$arrResponse = array("status" => false, "msg" => 'Metodo no encontrado');
			json($arrResponse);
			die();
		}

		if (
			empty($_POST['txtIndicadorIdArchivo']) ||
			empty($_POST['txtTituloArchivo']) ||
			empty($_POST['listEstadoArchivo'])
		) {
			$arrResponse = array("status" => false, "msg" => 'Los campos son obligatorios');
			json($arrResponse);
			die();
		}

		$idArchivo = intval($_POST['idArchivo']);
		$intIndicadorId = intval($_POST['txtIndicadorIdArchivo']);
		$strTitulo = strClean($_POST['txtTituloArchivo']);
		$strDescripcion = strClean($_POST['txtDescripcionArchivo']);
		$intOrden = intval($_POST['txtOrdenArchivo']);
		$intEstado = intval($_POST['listEstadoArchivo']);
		$requestFile = "";

		// Subida de archivo
		if (isset($_FILES['archivoPdf']) && $_FILES['archivoPdf']['name'] != "") {
			$fileName = $_FILES['archivoPdf']['name'];
			$tempName = $_FILES['archivoPdf']['tmp_name'];
			$fileSize = $_FILES['archivoPdf']['size'];
			$fileType = $_FILES['archivoPdf']['type'];

			// Validar tipo de archivo
			$allowedTypes = ['application/pdf'];
			if (!in_array($fileType, $allowedTypes)) {
				$arrResponse = array('status' => false, 'msg' => 'Solo se permiten archivos PDF.');
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				die();
			}

			// Validar tamaño (máximo 10MB)
			if ($fileSize > 10485760) {
				$arrResponse = array('status' => false, 'msg' => 'El archivo es demasiado grande. Máximo 10MB.');
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				die();
			}

			// Crear directorio si no existe
			$uploadDir = PATH_UPLOAD . "gobernanza/";
			if (!file_exists($uploadDir)) {
				mkdir($uploadDir, 0755, true);
			}

			// Generar nombre único para el archivo
			$fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
			$uniqueFileName = date("YmdHis") . $_SESSION['idUser'] . "_" . bin2hex(random_bytes(8)) . "." . $fileExtension;
			$filePath = $uploadDir . $uniqueFileName;

			if (move_uploaded_file($tempName, $filePath)) {
				$requestFile = $filePath;
			} else {
				$arrResponse = array('status' => false, 'msg' => 'Error al subir el archivo.');
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				die();
			}
		}

		if ($idArchivo == 0) {
			// Crear nuevo archivo
			if ($_SESSION['permisosMod']['w']) {
				$request = $this->model->insertArchivo(
					$intIndicadorId,
					$strTitulo,
					$strDescripcion,
					$requestFile,
					$intOrden,
					$intEstado,
					$_SESSION['idUser']
				);

				if ($request > 0) {
					$arrResponse = array('status' => true, 'msg' => 'Archivo creado correctamente.', 'archivo_ruta' => $requestFile);
				} else {
					$arrResponse = array('status' => false, 'msg' => 'No se pudo crear el archivo.');
				}
			} else {
				$arrResponse = array('status' => false, 'msg' => 'No tiene permiso para crear archivos.');
			}
		} else {
			// Actualizar archivo existente
			if ($_SESSION['permisosMod']['u']) {
				$request = $this->model->updateArchivo(
					$idArchivo,
					$intIndicadorId,
					$strTitulo,
					$strDescripcion,
					$requestFile,
					$intOrden,
					$intEstado
				);

				if ($request) {
					$arrResponse = array('status' => true, 'msg' => 'Archivo actualizado correctamente.', 'archivo_ruta' => $requestFile);
				} else {
					$arrResponse = array('status' => false, 'msg' => 'No se pudo actualizar el archivo.');
				}
			} else {
				$arrResponse = array('status' => false, 'msg' => 'No tiene permiso para actualizar archivos.');
			}
		}

		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
	}

	public function delArchivo()
	{
		if ($_POST) {
			if ($_SESSION['permisosMod']['d']) {
				$intId = intval($_POST['idArchivo']);
				$archivoData = $this->model->selectArchivo($intId);

				if ($archivoData) {
					// Eliminar archivo físico si existe
					if (file_exists($archivoData['archivo_ruta'])) {
						unlink($archivoData['archivo_ruta']);
					}

					$requestDelete = $this->model->deleteArchivo($intId);

					if ($requestDelete) {
						$arrResponse = array('status' => true, 'msg' => 'Archivo eliminado correctamente.');
					} else {
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el archivo.');
					}
				} else {
					$arrResponse = array('status' => false, 'msg' => 'Archivo no encontrado.');
				}
			} else {
				$arrResponse = array('status' => false, 'msg' => 'No tiene permiso para eliminar archivos.');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	// Método para obtener la estructura completa de gobernanza
	public function getEstructuraGobernanza()
	{
		$arrData = $this->model->getEstructuraGobernanza();
		$arrResponse = array('status' => true, 'data' => $arrData);
		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
	}
}

?>