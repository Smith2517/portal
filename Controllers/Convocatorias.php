<?php

class Convocatorias extends Controllers
{
    public function __construct()
{
    parent::__construct();

    // Detectar método actual
    $url = $_GET['url'] ?? '';

    // Permitir acceso público SOLO a getEstructuraConvocatorias
    if (stripos($url, 'convocatorias/getEstructuraConvocatorias') === false) {
        isLogin();
    }
}


    /* =====================================================
       VISTA PRINCIPAL
    ====================================================== */
    public function convocatorias()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
            die();
        }

        $data = [
            'page_tag'          => "Convocatorias",
            'page_id'           => 14,
            'page_title'        => "Convocatorias",
            'page_name'         => "convocatorias",
            'page_functions_js' => "functions_convocatorias.js"
        ];

        $this->views->getView($this, "convocatorias", $data);
    }

    /* =====================================================
       HELPERS
    ====================================================== */
    private function jsonResponse(array $arr, int $code = 200): void
    {
        http_response_code($code);
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        die();
    }

    private function requirePerm(string $key, string $msg = 'No tiene permiso.'): void
    {
        if (empty($_SESSION['permisosMod'][$key])) {
            $this->jsonResponse(['status' => false, 'msg' => $msg], 403);
        }
    }

    /* =====================================================
       CONVOCATORIAS
    ====================================================== */
    public function getConvocatorias()
    {
        $this->requirePerm('r', 'No tiene permiso para ver convocatorias.');

        $arrData = $this->model->selectConvocatorias();
        $this->jsonResponse(['status' => true, 'data' => $arrData]);
    }

    public function getConvocatoria($idConvocatoria)
    {
        $this->requirePerm('r');

        $id = intval($idConvocatoria);
        if ($id <= 0) {
            $this->jsonResponse(['status' => false, 'msg' => 'ID inválido.'], 400);
        }

        $arrData = $this->model->selectConvocatoria($id);
        if (empty($arrData)) {
            $this->jsonResponse(['status' => false, 'msg' => 'Datos no encontrados.'], 404);
        }

        $this->jsonResponse(['status' => true, 'data' => $arrData]);
    }

    public function setConvocatoria()
    {
        if (!$_POST) {
            $this->jsonResponse(['status' => false, 'msg' => 'Método no encontrado'], 405);
        }

        if (
            trim($_POST['txtTitulo'] ?? '') === '' ||
            trim($_POST['txtFechaInicio'] ?? '') === '' ||
            trim($_POST['txtFechaFin'] ?? '') === '' ||
            !isset($_POST['listEstado']) || $_POST['listEstado'] === ''
        ) {
            $this->jsonResponse(['status' => false, 'msg' => 'Los campos son obligatorios'], 400);
        }

        $idConvocatoria    = intval($_POST['idConvocatoria'] ?? 0);
        $strTitulo         = strClean($_POST['txtTitulo']);
        $strDescripcion    = strClean($_POST['txtDescripcion'] ?? '');
        $strFechaInicio    = $_POST['txtFechaInicio'];
        $strFechaFin       = $_POST['txtFechaFin'];
        $intEstado         = intval($_POST['listEstado']);

        if ($idConvocatoria === 0) {
            $this->requirePerm('w', 'No tiene permiso para crear convocatorias.');

            $request = $this->model->insertConvocatoria(
                $strTitulo,
                $strDescripcion,
                $strFechaInicio,
                $strFechaFin,
                $intEstado,
                $_SESSION['idUser']
            );

            $this->jsonResponse(
                $request > 0
                    ? ['status' => true, 'msg' => 'Convocatoria creada correctamente.']
                    : ['status' => false, 'msg' => 'No se pudo crear la convocatoria.']
            );
        } else {
            $this->requirePerm('u', 'No tiene permiso para actualizar convocatorias.');

            $request = $this->model->updateConvocatoria(
                $idConvocatoria,
                $strTitulo,
                $strDescripcion,
                $strFechaInicio,
                $strFechaFin,
                $intEstado
            );

            $this->jsonResponse(
                $request
                    ? ['status' => true, 'msg' => 'Convocatoria actualizada correctamente.']
                    : ['status' => false, 'msg' => 'No se pudo actualizar la convocatoria.']
            );
        }
    }

    public function delConvocatoria()
    {
        if (!$_POST) $this->jsonResponse(['status' => false, 'msg' => 'Método no encontrado'], 405);

        $this->requirePerm('d');

        $intId = intval($_POST['idConvocatoria'] ?? 0);
        if ($intId <= 0) {
            $this->jsonResponse(['status' => false, 'msg' => 'ID inválido.'], 400);
        }

        $request = $this->model->deleteConvocatoria($intId);

        $this->jsonResponse(
            $request
                ? ['status' => true, 'msg' => 'Convocatoria eliminada correctamente.']
                : ['status' => false, 'msg' => 'Error al eliminar la convocatoria.']
        );
    }

    /* =====================================================
       ITEMS
    ====================================================== */
    public function getItemsByConvocatoria($idConvocatoria)
    {
        $this->requirePerm('r');

        $convocatoriaId = intval($idConvocatoria);
        if ($convocatoriaId <= 0) {
            $this->jsonResponse(['status' => false, 'msg' => 'ID inválido.'], 400);
        }

        $arrData = $this->model->selectItemsByConvocatoria($convocatoriaId);

        // Normalización de rutas viejas si tu query trae archivo_ruta por join
        if (is_array($arrData)) {
            foreach ($arrData as &$row) {
                if (!empty($row['archivo_ruta'])) {
                    $row['archivo_ruta'] = str_replace('Assets/files/', 'Assets/upload/', $row['archivo_ruta']);
                    $row['archivo_ruta'] = str_replace('\\', '/', $row['archivo_ruta']);
                }
            }
            unset($row);
        }

        $this->jsonResponse(['status' => true, 'data' => $arrData]);
    }

    public function getItem($idItem)
    {
        $this->requirePerm('r');

        $id = intval($idItem);
        if ($id <= 0) {
            $this->jsonResponse(['status' => false, 'msg' => 'ID inválido.'], 400);
        }

        $arrData = $this->model->selectItem($id);
        if (empty($arrData)) {
            $this->jsonResponse(['status' => false, 'msg' => 'Datos no encontrados.'], 404);
        }

        $this->jsonResponse(['status' => true, 'data' => $arrData]);
    }

    public function setItem()
    {
        if (!$_POST) {
            $this->jsonResponse(['status' => false, 'msg' => 'Método no encontrado'], 405);
        }

        if (
            empty($_POST['txtConvocatoriaIdItem']) ||
            empty($_POST['txtNombreItem']) ||
            empty($_POST['listEstadoItem'])
        ) {
            $this->jsonResponse(['status' => false, 'msg' => 'Los campos son obligatorios'], 400);
        }

        $idItem            = intval($_POST['idItem'] ?? 0);
        $intConvocatoriaId = intval($_POST['txtConvocatoriaIdItem']);
        $strNombre         = strClean($_POST['txtNombreItem']);
        $strDesc           = strClean($_POST['txtDescripcionItem'] ?? '');
        $intOrden          = intval($_POST['txtOrdenItem'] ?? 0);
        $intEstado         = intval($_POST['listEstadoItem']);

        if ($idItem === 0) {
            $this->requirePerm('w', 'No tiene permiso para crear items.');

            $request = $this->model->insertItem(
                $intConvocatoriaId,
                $strNombre,
                $strDesc,
                $intOrden,
                $intEstado,
                $_SESSION['idUser']
            );

            $this->jsonResponse(
                $request
                    ? ['status' => true, 'msg' => 'Item guardado correctamente.']
                    : ['status' => false, 'msg' => 'Error al guardar item.']
            );
        } else {
            $this->requirePerm('u', 'No tiene permiso para actualizar items.');

            $request = $this->model->updateItem(
                $idItem,
                $intConvocatoriaId,
                $strNombre,
                $strDesc,
                $intOrden,
                $intEstado
            );

            $this->jsonResponse(
                $request
                    ? ['status' => true, 'msg' => 'Item actualizado correctamente.']
                    : ['status' => false, 'msg' => 'Error al actualizar item.']
            );
        }
    }

    public function delItem()
    {
        if (!$_POST) $this->jsonResponse(['status' => false, 'msg' => 'Método no encontrado'], 405);

        $this->requirePerm('d', 'No tiene permiso para eliminar items.');

        $id = intval($_POST['idItem'] ?? 0);
        if ($id <= 0) {
            $this->jsonResponse(['status' => false, 'msg' => 'ID inválido.'], 400);
        }

        $request = $this->model->deleteItem($id);

        $this->jsonResponse(
            $request
                ? ['status' => true, 'msg' => 'Item eliminado correctamente.']
                : ['status' => false, 'msg' => 'Error al eliminar el item.']
        );
    }

    /* =====================================================
       DOCUMENTOS
    ====================================================== */
    public function getDocumentosByItem($idItem)
    {
        $this->requirePerm('r');

        $itemId = intval($idItem);
        if ($itemId <= 0) {
            $this->jsonResponse(['status' => false, 'msg' => 'ID inválido.'], 400);
        }

        $arrData = $this->model->selectDocumentosByItem($itemId);

        // Normaliza rutas viejas
        if (is_array($arrData)) {
            foreach ($arrData as &$row) {
                if (!empty($row['archivo_ruta'])) {
                    $row['archivo_ruta'] = str_replace('Assets/files/', 'Assets/upload/', $row['archivo_ruta']);
                    $row['archivo_ruta'] = str_replace('\\', '/', $row['archivo_ruta']);
                }
            }
            unset($row);
        }

        $this->jsonResponse(['status' => true, 'data' => $arrData]);
    }

    public function getDocumento($idDocumento)
    {
        $this->requirePerm('r');

        $id = intval($idDocumento);
        if ($id <= 0) {
            $this->jsonResponse(['status' => false, 'msg' => 'ID inválido.'], 400);
        }

        $arrData = $this->model->selectDocumento($id);
        if (empty($arrData)) {
            $this->jsonResponse(['status' => false, 'msg' => 'Datos no encontrados.'], 404);
        }

        if (!empty($arrData['archivo_ruta'])) {
            $arrData['archivo_ruta'] = str_replace('Assets/files/', 'Assets/upload/', $arrData['archivo_ruta']);
            $arrData['archivo_ruta'] = str_replace('\\', '/', $arrData['archivo_ruta']);
        }

        $this->jsonResponse(['status' => true, 'data' => $arrData]);
    }

    public function setDocumento()
    {
        if (!$_POST) {
            $this->jsonResponse(['status' => false, 'msg' => 'Método no encontrado'], 405);
        }

        if (
            empty($_POST['txtItemIdDocumento']) ||
            empty($_POST['txtTituloDocumento']) ||
            empty($_POST['listEstadoDocumento'])
        ) {
            $this->jsonResponse(['status' => false, 'msg' => 'Los campos son obligatorios'], 400);
        }

        $idDocumento = intval($_POST['idDocumento'] ?? 0);
        $intItemId   = intval($_POST['txtItemIdDocumento']);
        $strTitulo   = strClean($_POST['txtTituloDocumento']);
        $strDesc     = strClean($_POST['txtDescripcionDocumento'] ?? '');
        $intOrden    = intval($_POST['txtOrdenDocumento'] ?? 0);
        $intEstado   = intval($_POST['listEstadoDocumento']);

        $rutaRelativa = "";

        // Subida (opcional)
        if (!empty($_FILES['archivoDocumento']) && !empty($_FILES['archivoDocumento']['name'])) {

            if ($_FILES['archivoDocumento']['error'] !== UPLOAD_ERR_OK) {
                $this->jsonResponse([
                    'status' => false,
                    'msg' => 'Error en subida (PHP).',
                    'php_upload_error_code' => $_FILES['archivoDocumento']['error']
                ], 400);
            }

            $original = basename($_FILES['archivoDocumento']['name']);
            $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
            if (!in_array($ext, ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'gif'])) {
                $this->jsonResponse(['status' => false, 'msg' => 'Formato de archivo no permitido.'], 400);
            }

            // Nombre limpio
            $base = pathinfo($original, PATHINFO_FILENAME);
            $base = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $base);
            $base = preg_replace('/[^A-Za-z0-9_-]+/', '-', $base);
            $base = trim($base, '-_');
            if ($base === '') $base = 'documento';

            $nombre = 'conv_' . time() . '_' . $base . '.' . $ext;

            // Ruta guardada en BD
            $destino = 'Assets/upload/convocatorias/' . $nombre;

            // Ruta absoluta real (soporta que base_url esté en /portal)
            $docRoot  = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\');
            $basePath = parse_url(base_url(), PHP_URL_PATH);
            $basePath = rtrim($basePath ?: '', '/');

            $destinoAbs = $docRoot . $basePath . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $destino);

            $dir = dirname($destinoAbs);
            if (!is_dir($dir)) {
                if (!@mkdir($dir, 0777, true) && !is_dir($dir)) {
                    $this->jsonResponse(['status' => false, 'msg' => 'No se pudo crear la carpeta destino.', 'dir' => $dir], 500);
                }
            }

            if (!move_uploaded_file($_FILES['archivoDocumento']['tmp_name'], $destinoAbs)) {
                $this->jsonResponse([
                    'status' => false,
                    'msg' => 'No se pudo mover el archivo al destino.',
                    'destinoAbs' => $destinoAbs,
                    'document_root' => $_SERVER['DOCUMENT_ROOT'],
                    'basePath' => $basePath
                ], 500);
            }

            $rutaRelativa = $destino;
        }

        if ($idDocumento === 0) {
            $this->requirePerm('w', 'No tiene permiso para crear documentos.');

            $request = $this->model->insertDocumento(
                $intItemId,
                $strTitulo,
                $strDesc,
                $rutaRelativa,
                $intOrden,
                $intEstado,
                $_SESSION['idUser']
            );

            $this->jsonResponse(
                $request
                    ? ['status' => true, 'msg' => 'Documento guardado correctamente.']
                    : ['status' => false, 'msg' => 'Error al guardar documento.']
            );
        } else {
            $this->requirePerm('u', 'No tiene permiso para actualizar documentos.');

            $request = $this->model->updateDocumento(
                $idDocumento,
                $intItemId,
                $strTitulo,
                $strDesc,
                $rutaRelativa,
                $intOrden,
                $intEstado
            );

            $this->jsonResponse(
                $request
                    ? ['status' => true, 'msg' => 'Documento actualizado correctamente.']
                    : ['status' => false, 'msg' => 'Error al actualizar documento.']
            );
        }
    }

    public function delDocumento()
    {
        if (!$_POST) $this->jsonResponse(['status' => false, 'msg' => 'Método no encontrado'], 405);

        $this->requirePerm('d', 'No tiene permiso para eliminar documentos.');

        $id = intval($_POST['idDocumento'] ?? 0);
        if ($id <= 0) {
            $this->jsonResponse(['status' => false, 'msg' => 'ID inválido.'], 400);
        }

        $request = $this->model->deleteDocumento($id);

        $this->jsonResponse(
            $request
                ? ['status' => true, 'msg' => 'Documento eliminado correctamente.']
                : ['status' => false, 'msg' => 'Error al eliminar el documento.']
        );
    }

    /* =====================================================
       ESTRUCTURA COMPLETA (si tu model ya la construye)
    ====================================================== */
    public function getEstructuraConvocatorias()
{
    // 🔓 Método público (sin permisos)
    $arrData = $this->model->getEstructuraConvocatorias();
    $this->jsonResponse(['status' => true, 'data' => $arrData]);
}

}
