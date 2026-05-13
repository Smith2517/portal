<?php
class Norma extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
        getPermisos(3);
    }

    public function norma($params)
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        if (!isset($params) || empty($params)) {
            header("Location:" . base_url() . '/dashboard');
        }
        $params = explode(",", $params)[0];
        $request = $this->model->selectTipoNorma($params);
        $data['page_id'] = 3;
        $data['page_tag'] = $request['tn_nombre'] . " - MDESV";
        $data['page_title'] = $request['tn_nombre'] . " - MDESV";
        $data['page_name'] = $request['tn_nombre'] . "";
        $data['page_functions_js'] = "functions_norma.js";
        $data['page_year'] = $this->model->selectYear();
        $data['page_tipoNorma'] = $request;
        $this->views->getView($this, "norma", $data);
    }
    public function getNorma($params)
    {
        if ($_SESSION['permisosMod']['r']) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            $id = strClean($params);
            $request = $this->model->selectNormas($id);
            $cont = 1;
            foreach ($request as $key => $value) {
                $request[$key]["publicador"] = $value["nombres"] . " " . $value["apellidos"];
                $request[$key]["nm_descripcion"] = limitar_cadena($value["nm_descripcion"], 200, "...");
                if ($value["nm_estado"] == 1) {
                    $status = '<span class="badge badge-primary">Publicado</span>';
                } else if ($value["nm_estado"] == 0) {
                    $status = '<span class="badge badge-danger">No publicado</span>';
                }
                $request[$key]["nm_estado"] = $status;
                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<a class="btn btn-danger btn-sm" href="' . media() . "/upload/" . $value["nm_file"] . '" target="_blank" rel="noopener noreferrer" ><i class="fa fa-file-pdf"></i></a>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '
                    <button class="btn btn-primary btn-sm btnUploadFile" data-id="' . $value["id"] . '" data-file="' . $value["nm_file"] . '" data-nombre="' . $value["nm_nombre"] . '" ><i class="fa fa-upload" aria-hidden="true"></i></button>
                    <button class="btn btn-primary btn-sm btnEdit" data-numDoc="' . $value["nm_numeroDocumento"] . '" data-id="' . $value["id"] . '" data-nombre="' . $value["nm_nombre"] . '" data-descripcion="' . str_replace('"', "«", $value["nm_descripcion"]) . '" data-year="' . $value["a_anio"] . '" data-idYear="' . $value["anio_id"] . '" data-estado="' . $value["nm_estado"] . '" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm btnDel" data-id="' . $value["id"] . '" data-nombre="' . $value["nm_nombre"] . '" data-file="' . $value["nm_file"] . '"  title="Eliminar"><i class="far fa-trash-alt"></i></button>
                                    </div>';
                }
                $request[$key]["acciones"] = '<div class="text-center">' .  $btnView . ' '  . $btnEdit . ' ' . $btnDelete . '</div>';
                $request[$key]["nm_numeroDocumento"] = ($value["nm_numeroDocumento"] == 0) ? "S/N" : $value["nm_numeroDocumento"];
                $request[$key]["cont"] = $cont;
                $cont++;
            }
            json($request);
        }
    }
    public function saveNorma()
    {
        if ($_SESSION['permisosMod']['w']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            if (!isset($_FILES["flArchivo"])) {
                $arrResponse = array('status' => false, 'msg' => 'No a seleccionado ningun archivo');
                json($arrResponse);
                die();
            }
            if ($_FILES["flArchivo"]["type"] != "application/pdf") {
                $arrResponse = array('status' => false, 'msg' => 'Solo se permite subir archivos PDF');
                json($arrResponse);
                die();
            }
            $numeroDoc = intval(strClean($_POST["intNumeroDoc"]));
            $year = strClean($_POST["cbxYear"]);
            $descripcion = strClean($_POST["txtDescripcion"]);
            $nombre = strClean($_POST["txtNombre"]);
            $idPersona = $_SESSION['idUser'];
            $file = $_FILES["flArchivo"]["name"];
            $tiponorma_id = strClean($_POST["tiponorma_id"]);

            if ($numeroDoc == "" || $year == "" || $nombre == "" || $descripcion == "" || $idPersona == "") {
                $arrResponse = array('status' => false, 'msg' => 'Complete los campos que son obligatorios');
                json($arrResponse);
                die();
            }
            $ruta = path_upload() . "NORMASMUNICIPALES/" . $tiponorma_id . "-IDTIPONORMA/" . $year . "-IDYEAR/";
            $urlFile = $ruta . $tiponorma_id . " - " . $file;
            verifyFolder($ruta);
            $request_moveFile = move_uploaded_file($_FILES["flArchivo"]["tmp_name"], $urlFile);
            if (!$request_moveFile) {
                $arrResponse = array('status' => false, 'msg' => 'Archivo no movido');
                json($arrResponse);
                die();
            }
            $file = "NORMASMUNICIPALES/" . $tiponorma_id . "-IDTIPONORMA/" . $year . "-IDYEAR/" . $tiponorma_id . " - " . $file;
            $request = $this->model->insertNorma(
                $numeroDoc,
                $year,
                $tiponorma_id,
                $nombre,
                $descripcion,
                $file,
                $idPersona
            );
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Norma registrada y publicada correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio un error inesperado');
            }
            json($arrResponse);
        }
    }
    public function deleteNorma()
    {
        if ($_SESSION['permisosMod']['d']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $id = strClean($_POST["id"]);
            $file = strClean($_POST["file"]);
            if ($id == "" || $file == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            if (is_file(path_upload() . $file)) {
                unlink(path_upload() . $file);
            }
            $request = $this->model->deleteNorma($id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Datos eliminados correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio problemas al eliminar los datos');
            }
            json($arrResponse);
        }
    }
    public function updateNorma()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $numeroDoc = intval(strClean($_POST["intNumeroDoc_upd"]));
            $year = strClean($_POST["cbxYear_upd"]);
            $nombre = strClean($_POST["txtNombre_upd"]);
            $descripcion = strClean($_POST["txtDescripcion_upd"]);
            $estado = strClean($_POST["cbxEstado_upd"]);
            $id = strClean($_POST["id_upd"]);
            $iduser = $_SESSION['idUser'];
            if ($year == "" || $nombre == "" || $descripcion == "" || $estado == "" || $id == "" || $iduser == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llenes los campos obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->updateNorma($numeroDoc, $year, $nombre, $descripcion, $estado, $iduser, $id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio problemas al actualizar los datos');
            }
            json($arrResponse);
        }
    }
    public function updateNormaFile()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            if (!is_numeric($_POST["idFile_upd"])) {
                $arrResponse = array('status' => false, 'msg' => 'Refresque la pagina, id del registro fue alterado');
                json($arrResponse);
                die();
            }
            if (!isset($_FILES["flArchivoFile_upd"])) {
                $arrResponse = array('status' => false, 'msg' => 'Archvio no cargado, por favor seleccione un archivo para subir');
                json($arrResponse);
                die();
            }
            if ($_FILES["flArchivoFile_upd"]["type"] != "application/pdf") {
                $arrResponse = array('status' => false, 'msg' => 'Solo se permite subir archivos PDF');
                json($arrResponse);
                die();
            }
            $id = intval(strClean($_POST["idFile_upd"]));
            $idpersona = $_SESSION['idUser'];
            $nameFile = strClean($_FILES["flArchivoFile_upd"]["name"]);
            if ($id == "" || $nameFile == "" || $idpersona == "") {
                $arrResponse = array('status' => false, 'msg' => 'Complete los campos obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->selectNorma($id);
            if (!$request) {
                $arrResponse = array('status' => false, 'msg' => 'Complete los campos obligatorios');
                json($arrResponse);
                die();
            }
            //var de mover archivos
            $tiponorma_id = $request["tiponorma_id"];
            $year = $request["anio_id"];
            $datetime = date("Ymdhis");
            $rutaFile = "NORMASMUNICIPALES/" . $tiponorma_id . "-IDTIPONORMA/" . $year . "-IDYEAR/";
            $rutamove = path_upload() . $rutaFile;
            $file = $rutaFile . $datetime . ".pdf";
            $urlFile = path_upload() . $file;
            verifyFolder($rutamove);
            $request_moveFile = move_uploaded_file($_FILES["flArchivoFile_upd"]["tmp_name"], $urlFile);
            if (!$request_moveFile) {
                $arrResponse = array('status' => false, 'msg' => 'Archivo no movido');
                json($arrResponse);
                die();
            }
            //var de eliminacion
            $fileOld = $request["nm_file"];
            $ruta = path_upload();
            verifyFolder($ruta);
            if (is_file($ruta . $fileOld) && !unlink($ruta . $fileOld)) {
                $arrResponse = array('status' => false, 'msg' => 'Archivo no eliminado');
                json($arrResponse);
                die();
            }
            $request = $this->model->updatefilenorma($id,  $file,  $idpersona);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Archivo modificado corretamente');
                json($arrResponse);
                die();
            }
        }
    }
}
