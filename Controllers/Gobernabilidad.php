<?php

class Gobernabilidad extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
        // getPermisos(ID_MODULO_GOBERNABILIDAD);
    }

    /* =====================================================
       VISTA PRINCIPAL
    ====================================================== */
    public function gobernabilidad()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
            die();
        }

        $data = [
            'page_tag'          => "Gobernabilidad",
            'page_id'           => 12,
            'page_title'        => "Gobernabilidad",
            'page_name'         => "gobernabilidad",
            'page_functions_js' => "functions_gobernabilidad.js"
        ];

        $this->views->getView($this, "gobernabilidad", $data);
    }

    /* =====================================================
       ITEMS
    ====================================================== */
    public function getItems()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectItems();
            $arrResponse = ['status' => true, 'data' => $arrData];
        } else {
            $arrResponse = ['status' => false, 'msg' => 'No tiene permiso para ver items.'];
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getItem($idItem)
    {
        if (!$_SESSION['permisosMod']['r']) {
            echo json_encode(['status' => false, 'msg' => 'No tiene permiso.'], JSON_UNESCAPED_UNICODE);
            die();
        }

        $id = intval($idItem);
        if ($id <= 0) {
            echo json_encode(['status' => false, 'msg' => 'ID inválido.'], JSON_UNESCAPED_UNICODE);
            die();
        }

        $arrData = $this->model->selectItem($id);
        $arrResponse = empty($arrData)
            ? ['status' => false, 'msg' => 'Datos no encontrados.']
            : ['status' => true, 'data' => $arrData];

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function setItem()
    {
        if (!$_POST) {
            json(['status' => false, 'msg' => 'Método no encontrado']);
            die();
        }

        if (empty($_POST['txtNombre']) || empty($_POST['listEstado'])) {
            json(['status' => false, 'msg' => 'Los campos son obligatorios']);
            die();
        }

        $idItem         = intval($_POST['idItem']);
        $strNombre      = strClean($_POST['txtNombre']);
        $strDescripcion = strClean($_POST['txtDescripcion']);
        $intOrden       = intval($_POST['txtOrden']);
        $intEstado      = intval($_POST['listEstado']);

        if ($idItem == 0) {
            if (!$_SESSION['permisosMod']['w']) {
                json(['status' => false, 'msg' => 'No tiene permiso para crear items.']);
                die();
            }

            $request = $this->model->insertItem(
                $strNombre,
                $strDescripcion,
                $intOrden,
                $intEstado,
                $_SESSION['idUser']
            );

            $arrResponse = $request > 0
                ? ['status' => true, 'msg' => 'Item creado correctamente.']
                : ['status' => false, 'msg' => 'No se pudo crear el item.'];
        } else {
            if (!$_SESSION['permisosMod']['u']) {
                json(['status' => false, 'msg' => 'No tiene permiso para actualizar items.']);
                die();
            }

            $request = $this->model->updateItem(
                $idItem,
                $strNombre,
                $strDescripcion,
                $intOrden,
                $intEstado
            );

            $arrResponse = $request
                ? ['status' => true, 'msg' => 'Item actualizado correctamente.']
                : ['status' => false, 'msg' => 'No se pudo actualizar el item.'];
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function delItem()
    {
        if (!$_POST) die();

        if (!$_SESSION['permisosMod']['d']) {
            echo json_encode(['status' => false, 'msg' => 'No tiene permiso.'], JSON_UNESCAPED_UNICODE);
            die();
        }

        $intId = intval($_POST['idItem']);
        $request = $this->model->deleteItem($intId);

        $arrResponse = $request
            ? ['status' => true, 'msg' => 'Item eliminado correctamente.']
            : ['status' => false, 'msg' => 'Error al eliminar el item.'];

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    /* =====================================================
       INDICADORES
    ====================================================== */
    public function getIndicadoresByItem($idItem)
    {
        if (!$_SESSION['permisosMod']['r']) {
            echo json_encode(['status' => false, 'msg' => 'No tiene permiso.'], JSON_UNESCAPED_UNICODE);
            die();
        }

        $itemId = intval($idItem);
        if ($itemId <= 0) {
            echo json_encode(['status' => false, 'msg' => 'ID inválido.'], JSON_UNESCAPED_UNICODE);
            die();
        }

        $arrData = $this->model->selectIndicadoresByItem($itemId);
        echo json_encode(['status' => true, 'data' => $arrData], JSON_UNESCAPED_UNICODE);
        die();
    }

    public function setIndicador()
    {
        if (!$_POST) {
            json(['status' => false, 'msg' => 'Método no encontrado']);
            die();
        }

        if (empty($_POST['txtItemIdIndicador']) || empty($_POST['txtNombreIndicador']) || empty($_POST['listEstadoIndicador'])) {
            json(['status' => false, 'msg' => 'Los campos son obligatorios']);
            die();
        }

        $idIndicador = intval($_POST['idIndicador']);
        $intItemId   = intval($_POST['txtItemIdIndicador']);
        $strNombre   = strClean($_POST['txtNombreIndicador']);
        $strDesc     = strClean($_POST['txtDescripcionIndicador']);
        $intOrden    = intval($_POST['txtOrdenIndicador']);
        $intEstado   = intval($_POST['listEstadoIndicador']);

        if ($idIndicador == 0) {
            $request = $this->model->insertIndicador(
                $intItemId,
                $strNombre,
                $strDesc,
                $intOrden,
                $intEstado,
                $_SESSION['idUser']
            );
        } else {
            $request = $this->model->updateIndicador(
                $idIndicador,
                $intItemId,
                $strNombre,
                $strDesc,
                $intOrden,
                $intEstado
            );
        }

        echo json_encode(
            $request ? ['status' => true, 'msg' => 'Indicador guardado correctamente.']
                     : ['status' => false, 'msg' => 'Error al guardar indicador.'],
            JSON_UNESCAPED_UNICODE
        );
        die();
    }

    /* =====================================================
       ESTRUCTURA COMPLETA
    ====================================================== */
    public function getEstructuraGobernabilidad()
    {
        $arrData = $this->model->getEstructuraGobernabilidad();
        echo json_encode(['status' => true, 'data' => $arrData], JSON_UNESCAPED_UNICODE);
        die();
    }

    /* =====================================================
   INDICADORES (FALTANTES)
====================================================== */
public function getIndicador($idIndicador)
{
    if (!$_SESSION['permisosMod']['r']) {
        echo json_encode(['status' => false, 'msg' => 'No tiene permiso.'], JSON_UNESCAPED_UNICODE);
        die();
    }

    $id = intval($idIndicador);
    if ($id <= 0) {
        echo json_encode(['status' => false, 'msg' => 'ID inválido.'], JSON_UNESCAPED_UNICODE);
        die();
    }

    // OJO: el modelo debe tener selectIndicador($id)
    $arrData = $this->model->selectIndicador($id);

    echo json_encode(
        empty($arrData) ? ['status' => false, 'msg' => 'Datos no encontrados.']
                        : ['status' => true, 'data' => $arrData],
        JSON_UNESCAPED_UNICODE
    );
    die();
}

public function delIndicador()
{
    if (!$_POST) die();

    if (!$_SESSION['permisosMod']['d']) {
        echo json_encode(['status' => false, 'msg' => 'No tiene permiso.'], JSON_UNESCAPED_UNICODE);
        die();
    }

    $id = intval($_POST['idIndicador'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['status' => false, 'msg' => 'ID inválido.'], JSON_UNESCAPED_UNICODE);
        die();
    }

    // OJO: el modelo debe tener deleteIndicador($id)
    $request = $this->model->deleteIndicador($id);

    echo json_encode(
        $request ? ['status' => true, 'msg' => 'Indicador eliminado correctamente.']
                 : ['status' => false, 'msg' => 'Error al eliminar el indicador.'],
        JSON_UNESCAPED_UNICODE
    );
    die();
}

/* =====================================================
   ARCHIVOS (FALTANTES)
====================================================== */
public function getArchivosByIndicador($idIndicador)
{
    if (!$_SESSION['permisosMod']['r']) {
        echo json_encode(['status' => false, 'msg' => 'No tiene permiso.'], JSON_UNESCAPED_UNICODE);
        die();
    }

    $id = intval($idIndicador);
    if ($id <= 0) {
        echo json_encode(['status' => false, 'msg' => 'ID inválido.'], JSON_UNESCAPED_UNICODE);
        die();
    }

    $arrData = $this->model->selectArchivosByIndicador($id);

    // ✅ NORMALIZA RUTAS VIEJAS files -> upload
    if (is_array($arrData)) {
        foreach ($arrData as &$row) {
            if (!empty($row['archivo_ruta'])) {
                $row['archivo_ruta'] = str_replace('Assets/files/', 'Assets/upload/', $row['archivo_ruta']);
                $row['archivo_ruta'] = str_replace('\\', '/', $row['archivo_ruta']);
            }
        }
        unset($row);
    }

    echo json_encode(['status' => true, 'data' => $arrData], JSON_UNESCAPED_UNICODE);
    die();
}


public function getArchivo($idArchivo)
{
    if (!$_SESSION['permisosMod']['r']) {
        echo json_encode(['status' => false, 'msg' => 'No tiene permiso.'], JSON_UNESCAPED_UNICODE);
        die();
    }

    $id = intval($idArchivo);
    if ($id <= 0) {
        echo json_encode(['status' => false, 'msg' => 'ID inválido.'], JSON_UNESCAPED_UNICODE);
        die();
    }

    $arrData = $this->model->selectArchivo($id);

    if (!empty($arrData) && !empty($arrData['archivo_ruta'])) {
        // ✅ NORMALIZA RUTA
        $arrData['archivo_ruta'] = str_replace('Assets/files/', 'Assets/upload/', $arrData['archivo_ruta']);
        $arrData['archivo_ruta'] = str_replace('\\', '/', $arrData['archivo_ruta']);
    }

    echo json_encode(
        empty($arrData) ? ['status' => false, 'msg' => 'Datos no encontrados.']
                        : ['status' => true, 'data' => $arrData],
        JSON_UNESCAPED_UNICODE
    );
    die();
}


public function setArchivo()
{
    if (!$_POST) {
        echo json_encode(['status' => false, 'msg' => 'Método no encontrado'], JSON_UNESCAPED_UNICODE);
        die();
    }

    if (empty($_POST['txtIndicadorIdArchivo']) || empty($_POST['txtTituloArchivo']) || empty($_POST['listEstadoArchivo'])) {
        echo json_encode(['status' => false, 'msg' => 'Los campos son obligatorios'], JSON_UNESCAPED_UNICODE);
        die();
    }

    $idArchivo    = intval($_POST['idArchivo'] ?? 0);
    $indicadorId  = intval($_POST['txtIndicadorIdArchivo']);
    $titulo       = strClean($_POST['txtTituloArchivo']);
    $descripcion  = strClean($_POST['txtDescripcionArchivo'] ?? '');
    $orden        = intval($_POST['txtOrdenArchivo'] ?? 0);
    $estado       = intval($_POST['listEstadoArchivo']);

    $rutaRelativa = "";

    if (!empty($_FILES['archivoPdf']) && !empty($_FILES['archivoPdf']['name'])) {

        if ($_FILES['archivoPdf']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode([
                'status' => false,
                'msg' => 'Error en subida (PHP).',
                'php_upload_error_code' => $_FILES['archivoPdf']['error']
            ], JSON_UNESCAPED_UNICODE);
            die();
        }

        $original = basename($_FILES['archivoPdf']['name']);
        $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
        if ($ext !== 'pdf') {
            echo json_encode(['status' => false, 'msg' => 'Solo se permiten PDF.'], JSON_UNESCAPED_UNICODE);
            die();
        }

        // Nombre limpio
        $base = pathinfo($original, PATHINFO_FILENAME);
        $base = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $base);
        $base = preg_replace('/[^A-Za-z0-9_-]+/', '-', $base);
        $base = trim($base, '-_');
        if ($base === '') $base = 'archivo';

        $nombre = 'gob_' . time() . '_' . $base . '.pdf';

        // ✅ Lo que se guarda en BD
        $destino = 'Assets/upload/gobernabilidad/' . $nombre;

        // ✅ Ruta absoluta REAL (incluye /portal)
        $docRoot = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\'); // public_html (hostinger) o htdocs (local)
        $basePath = parse_url(base_url(), PHP_URL_PATH);    // "/portal"
        $basePath = rtrim($basePath ?: '', '/');            // "/portal"

        $destinoAbs = $docRoot . $basePath . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $destino);

        // Crear carpeta
        $dir = dirname($destinoAbs);
        if (!is_dir($dir)) {
            if (!@mkdir($dir, 0777, true) && !is_dir($dir)) {
                echo json_encode(['status' => false, 'msg' => 'No se pudo crear la carpeta destino.', 'dir' => $dir], JSON_UNESCAPED_UNICODE);
                die();
            }
        }

        // Mover archivo
        if (!move_uploaded_file($_FILES['archivoPdf']['tmp_name'], $destinoAbs)) {
            echo json_encode([
                'status' => false,
                'msg' => 'No se pudo mover el archivo al destino.',
                'destinoAbs' => $destinoAbs,
                'document_root' => $_SERVER['DOCUMENT_ROOT'],
                'basePath' => $basePath
            ], JSON_UNESCAPED_UNICODE);
            die();
        }

        $rutaRelativa = $destino;
    }

    if ($idArchivo == 0) {
        $request = $this->model->insertArchivo($indicadorId, $titulo, $descripcion, $rutaRelativa, $orden, $estado, $_SESSION['idUser']);
        echo json_encode(
            $request ? ['status' => true, 'msg' => 'Archivo guardado correctamente.']
                     : ['status' => false, 'msg' => 'Error al guardar archivo.'],
            JSON_UNESCAPED_UNICODE
        );
    } else {
        $request = $this->model->updateArchivo($idArchivo, $indicadorId, $titulo, $descripcion, $rutaRelativa, $orden, $estado);
        echo json_encode(
            $request ? ['status' => true, 'msg' => 'Archivo actualizado correctamente.']
                     : ['status' => false, 'msg' => 'Error al actualizar archivo.'],
            JSON_UNESCAPED_UNICODE
        );
    }

    die();
}


public function delArchivo()
{
    if (!$_POST) die();

    if (!$_SESSION['permisosMod']['d']) {
        echo json_encode(['status' => false, 'msg' => 'No tiene permiso.'], JSON_UNESCAPED_UNICODE);
        die();
    }

    $id = intval($_POST['idArchivo'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['status' => false, 'msg' => 'ID inválido.'], JSON_UNESCAPED_UNICODE);
        die();
    }

    // OJO: el modelo debe tener deleteArchivo($id)
    $request = $this->model->deleteArchivo($id);

    echo json_encode(
        $request ? ['status' => true, 'msg' => 'Archivo eliminado correctamente.']
                 : ['status' => false, 'msg' => 'Error al eliminar el archivo.'],
        JSON_UNESCAPED_UNICODE
    );
    die();
}



}
