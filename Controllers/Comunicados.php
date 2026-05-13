<?php

class Comunicados extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
    }

    /* =====================================================
       VISTA PRINCIPAL
    ====================================================== */
    public function comunicados()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
            die();
        }

        $data = [
            'page_tag'          => "Comunicados",
            'page_id'           => 15,
            'page_title'        => "Comunicados",
            'page_name'         => "comunicados",
            'page_functions_js' => "functions_comunicados.js"
        ];

        $this->views->getView($this, "comunicados", $data);
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
       COMUNICADOS
    ====================================================== */
    public function getComunicados()
    {
        $this->requirePerm('r', 'No tiene permiso para ver comunicados.');

        $arrData = $this->model->selectComunicados();
        $this->jsonResponse(['status' => true, 'data' => $arrData]);
    }

    public function getComunicado($idComunicado)
    {
        $this->requirePerm('r');

        $id = intval($idComunicado);
        if ($id <= 0) {
            $this->jsonResponse(['status' => false, 'msg' => 'ID inválido.'], 400);
        }

        $arrData = $this->model->selectComunicado($id);
        if (empty($arrData)) {
            $this->jsonResponse(['status' => false, 'msg' => 'Datos no encontrados.'], 404);
        }

        $this->jsonResponse(['status' => true, 'data' => $arrData]);
    }

    public function setComunicado()
    {
        if (!$_POST) {
            $this->jsonResponse(['status' => false, 'msg' => 'Método no encontrado'], 405);
        }

        if (
            trim($_POST['txtTitulo'] ?? '') === '' ||
            trim($_POST['txtFechaComunicado'] ?? '') === '' ||
            !isset($_POST['listEstado']) || $_POST['listEstado'] === ''
        ) {
            $this->jsonResponse(['status' => false, 'msg' => 'Los campos marcados con * son obligatorios'], 400);
        }

        $idComunicado       = intval($_POST['idComunicado'] ?? 0);
        $strTitulo          = strClean($_POST['txtTitulo']);
        $strFechaComunicado = $_POST['txtFechaComunicado'];
        $strDescripcion     = strClean($_POST['txtDescripcion'] ?? '');
        $intEstado          = intval($_POST['listEstado']);

        $imagenRuta = "";
        $pdfRuta = "";

        // ============================================
        // SUBIDA DE IMAGEN
        // ============================================
        if (!empty($_FILES['imagenComunicado']) && !empty($_FILES['imagenComunicado']['name'])) {
            if ($_FILES['imagenComunicado']['error'] !== UPLOAD_ERR_OK) {
                $this->jsonResponse([
                    'status' => false,
                    'msg' => 'Error en subida de imagen.',
                    'error_code' => $_FILES['imagenComunicado']['error']
                ], 400);
            }

            $original = basename($_FILES['imagenComunicado']['name']);
            $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $this->jsonResponse(['status' => false, 'msg' => 'Formato de imagen no permitido. Solo JPG, JPEG, PNG, GIF, WEBP.'], 400);
            }

            // Validar tamaño (max 5MB)
            if ($_FILES['imagenComunicado']['size'] > 5 * 1024 * 1024) {
                $this->jsonResponse(['status' => false, 'msg' => 'La imagen no debe superar los 5MB.'], 400);
            }

            // Nombre limpio
            $base = pathinfo($original, PATHINFO_FILENAME);
            $base = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $base);
            $base = preg_replace('/[^A-Za-z0-9_-]+/', '-', $base);
            $base = trim($base, '-_');
            if ($base === '') $base = 'imagen';

            $nombre = 'com_' . time() . '_' . $base . '.' . $ext;
            $destino = 'Assets/upload/comunicados/' . $nombre;

            // Ruta absoluta
            $docRoot  = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\');
            $basePath = parse_url(base_url(), PHP_URL_PATH);
            $basePath = rtrim($basePath ?: '', '/');
            $destinoAbs = $docRoot . $basePath . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $destino);

            $dir = dirname($destinoAbs);
            if (!is_dir($dir)) {
                if (!@mkdir($dir, 0777, true) && !is_dir($dir)) {
                    $this->jsonResponse(['status' => false, 'msg' => 'No se pudo crear la carpeta destino.'], 500);
                }
            }

            if (!move_uploaded_file($_FILES['imagenComunicado']['tmp_name'], $destinoAbs)) {
                $this->jsonResponse(['status' => false, 'msg' => 'No se pudo mover la imagen al destino.'], 500);
            }

            $imagenRuta = $destino;
        }

        // ============================================
        // SUBIDA DE PDF (OPCIONAL)
        // ============================================
        if (!empty($_FILES['pdfComunicado']) && !empty($_FILES['pdfComunicado']['name'])) {
            if ($_FILES['pdfComunicado']['error'] !== UPLOAD_ERR_OK) {
                $this->jsonResponse([
                    'status' => false,
                    'msg' => 'Error en subida de PDF.',
                    'error_code' => $_FILES['pdfComunicado']['error']
                ], 400);
            }

            $original = basename($_FILES['pdfComunicado']['name']);
            $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
            if ($ext !== 'pdf') {
                $this->jsonResponse(['status' => false, 'msg' => 'Solo se permiten archivos PDF.'], 400);
            }

            // Validar tamaño (max 10MB)
            if ($_FILES['pdfComunicado']['size'] > 10 * 1024 * 1024) {
                $this->jsonResponse(['status' => false, 'msg' => 'El PDF no debe superar los 10MB.'], 400);
            }

            // Nombre limpio
            $base = pathinfo($original, PATHINFO_FILENAME);
            $base = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $base);
            $base = preg_replace('/[^A-Za-z0-9_-]+/', '-', $base);
            $base = trim($base, '-_');
            if ($base === '') $base = 'documento';

            $nombre = 'com_pdf_' . time() . '_' . $base . '.pdf';
            $destino = 'Assets/upload/comunicados/' . $nombre;

            // Ruta absoluta
            $docRoot  = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\');
            $basePath = parse_url(base_url(), PHP_URL_PATH);
            $basePath = rtrim($basePath ?: '', '/');
            $destinoAbs = $docRoot . $basePath . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $destino);

            $dir = dirname($destinoAbs);
            if (!is_dir($dir)) {
                if (!@mkdir($dir, 0777, true) && !is_dir($dir)) {
                    $this->jsonResponse(['status' => false, 'msg' => 'No se pudo crear la carpeta destino.'], 500);
                }
            }

            if (!move_uploaded_file($_FILES['pdfComunicado']['tmp_name'], $destinoAbs)) {
                $this->jsonResponse(['status' => false, 'msg' => 'No se pudo mover el PDF al destino.'], 500);
            }

            $pdfRuta = $destino;
        }

        // ============================================
        // INSERTAR O ACTUALIZAR
        // ============================================
        if ($idComunicado === 0) {
            $this->requirePerm('w', 'No tiene permiso para crear comunicados.');

            // Si es nuevo, la imagen es obligatoria
            if ($imagenRuta === '') {
                $this->jsonResponse(['status' => false, 'msg' => 'La imagen es obligatoria para nuevos comunicados.'], 400);
            }

            $request = $this->model->insertComunicado(
                $strTitulo,
                $strFechaComunicado,
                $strDescripcion,
                $imagenRuta,
                $pdfRuta,
                $intEstado,
                $_SESSION['idUser']
            );

            $this->jsonResponse(
                $request > 0
                    ? ['status' => true, 'msg' => 'Comunicado creado correctamente.']
                    : ['status' => false, 'msg' => 'No se pudo crear el comunicado.']
            );
        } else {
            $this->requirePerm('u', 'No tiene permiso para actualizar comunicados.');

            // Obtener rutas actuales si no se suben nuevos archivos
            if ($imagenRuta === '' || $pdfRuta === '') {
                $comunicadoActual = $this->model->selectComunicado($idComunicado);
                if ($imagenRuta === '' && !empty($comunicadoActual['imagen_ruta'])) {
                    $imagenRuta = $comunicadoActual['imagen_ruta'];
                }
                if ($pdfRuta === '' && !empty($comunicadoActual['pdf_ruta'])) {
                    $pdfRuta = $comunicadoActual['pdf_ruta'];
                }
            }

            $request = $this->model->updateComunicado(
                $idComunicado,
                $strTitulo,
                $strFechaComunicado,
                $strDescripcion,
                $imagenRuta,
                $pdfRuta,
                $intEstado
            );

            $this->jsonResponse(
                $request
                    ? ['status' => true, 'msg' => 'Comunicado actualizado correctamente.']
                    : ['status' => false, 'msg' => 'No se pudo actualizar el comunicado.']
            );
        }
    }

    public function delComunicado()
    {
        if (!$_POST) {
            $this->jsonResponse(['status' => false, 'msg' => 'Método no encontrado'], 405);
        }

        $this->requirePerm('d', 'No tiene permiso para eliminar comunicados.');

        $intId = intval($_POST['idComunicado'] ?? 0);
        if ($intId <= 0) {
            $this->jsonResponse(['status' => false, 'msg' => 'ID inválido.'], 400);
        }

        $request = $this->model->deleteComunicado($intId);

        $this->jsonResponse(
            $request
                ? ['status' => true, 'msg' => 'Comunicado eliminado correctamente.']
                : ['status' => false, 'msg' => 'Error al eliminar el comunicado.']
        );
    }
}
