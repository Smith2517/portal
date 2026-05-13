<?php
class Tiponorma extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
        getPermisos(4);
    }

    public function tiponorma($params)
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_id'] = 4;
        $data['page_tag'] = "Tipo Norma - MDESV";
        $data['page_title'] = "Tipo Norma - MDESV";
        $data['page_name'] = "Tipo Norma";
        $data['page_functions_js'] = "functions_tiponorma.js";
        $this->views->getView($this, "tiponorma", $data);
    }
    public function getTipoNorma()
    {
        if ($_SESSION['permisosMod']['r']) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            $request = $this->model->selectTipoNormas();
            foreach ($request as $key => $value) {
                if ($value["tn_estado"] == 1) {
                    $status = '<span class="badge badge-primary">Activo</span>';
                } else if ($value["tn_estado"] == 0) {
                    $status = '<span class="badge badge-danger">Inactivo</span>';
                }
                $request[$key]["tn_estado"] = $status;
                $request[$key]["link"] = '<a href="' . base_url() . '/page/normasmunicipales/' . $value['id'] . '"  target="_blank" rel="noopener noreferrer">' . base_url() . '/page/normasmunicipales/' . $value['id'] . '</a>';
                /* if ($_SESSION['permisosMod']['r']) {
                 $btnView = '<button class="btn btn-secondary btn-sm btnPermisosRol"  title="Permisos"><i class="fas fa-eye"></i></button>';
             }*/
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '
                    <button class="btn btn-primary btn-sm btnEditFile" 
                    data-id="' . $value["id"] . '"
                    data-image="' . $value["tn_foto"] . '"
                    title="Editar"><i class="fa fa-file-image-o" aria-hidden="true"></i></button>
                    <button class="btn btn-primary btn-sm btnEdit" 
                    data-id="' . $value["id"] . '" 
                    data-nombre="' . $value["tn_nombre"] . '" 
                    data-descripcion="' . $value["tn_descripcion"] . '" 
                    data-estado="' . $value["tn_estado"] . '" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm btnDel" data-id="' . $value["id"] . '" data-file="' . $value["tn_foto"] . '" data-nombre="' . $value["tn_nombre"] . '"  title="Eliminar"><i class="far fa-trash-alt"></i></button>';
                }
                $request[$key]["acciones"] = '<div class="text-center">' /* $btnView . ' ' */ . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            json($request);
        }
    }
    public function saveTipoNorma()
    {
        if ($_SESSION['permisosMod']['w']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $nombre = strClean($_POST["txtNombre"]);
            $descripcion = strClean($_POST["txtDescripcion"]);
            $nameFile = $_FILES["flArchivo"]["name"];
            $idPersona = $_SESSION['idUser'];
            if ($nombre == "" ||  $nameFile == "" || $idPersona == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            $datetime = date("YmdHis");
            $file = $datetime . $idPersona . $nameFile;
            $ruta = path_upload() . "images/";
            $urlFile = $ruta . $file;
            verifyFolder($ruta);
            $request_moveFile = move_uploaded_file($_FILES["flArchivo"]["tmp_name"], $urlFile);
            if (!$request_moveFile) {
                $arrResponse = array('status' => false, 'msg' => 'Archivo no movido');
                json($arrResponse);
                die();
            }
            $request = $this->model->insertTipoNorma($nombre,  $descripcion,  $file, $idPersona);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Registro completado correctamente');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se completo el registro');
                json($arrResponse);
                die();
            }
        }
    }
    public function updateTipoNorma()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $nombre = strClean($_POST["txtNombre_upd"]);
            $descripcion = strClean($_POST["txtDescripcion_upd"]);
            $estado = intval(strClean($_POST["cbxEstado_upd"]));
            $idpersona = $_SESSION['idUser'];
            $id = intval(strClean($_POST["id_upd"]));
            if ($nombre == "" ||  $estado == "" || $idpersona == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->updateTipoNorma($nombre, $descripcion, $estado, $idpersona, $id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Registro actualidado correctamente');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se completo el actualizado del registro');
                json($arrResponse);
                die();
            }
        }
    }
    public function updateFileTipoNorma()
    {
        if ($_SESSION['permisosMod']['w']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $id = intval(strClean($_POST["ip_updFil"]));
            $file = $_FILES["flArchivo_updFil"]["name"];
            $idPersona = $_SESSION['idUser'];
            $arrSize = getimagesize($_FILES["flArchivo_updFil"]["tmp_name"]);
            if ($arrSize[0] < 2046 || $arrSize[0] > 2059) {
                $arrResponse = array('status' => false, 'msg' => 'El ancho de la imagen no cumple con el rango permitido [2046 - 2059]px, Medida Actual : ' . $arrSize[0] . "px");
                json($arrResponse);
                die();
            }
            $fileOld = strClean($_POST["photoOld_updFil"]);
            if ($id == "" || $file == "" || $fileOld == "") {
                $arrResponse = array('status' => false, 'msg' => 'Complete los campos obligatorios');
                json($arrResponse);
                die();
            }

            $datetime = date("YmdHis");
            $file = $datetime . $idPersona . $file;
            $ruta = path_upload() . "images/";
            $urlFile = $ruta . $file;
            verifyFolder($ruta);
            $request_moveFile = move_uploaded_file($_FILES["flArchivo_updFil"]["tmp_name"], $urlFile);
            if (!$request_moveFile) {
                $arrResponse = array('status' => false, 'msg' => 'Archivo no movido');
                json($arrResponse);
                die();
            }
            if (is_file($ruta . $fileOld) && !unlink($ruta . $fileOld)) {
                $arrResponse = array('status' => false, 'msg' => 'Archivo no eliminado');
                json($arrResponse);
                die();
            }
            $request = $this->model->updateFotoTipoNorma($id, $file);

            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Foto de portada actualizada');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se pudo actualizar le registro');
                json($arrResponse);
                die();
            }
        }
    }
    public function deleteTipoNorma()
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
            $request = $this->model->selectNormasMunicipales($id);
            if ($request) {
                $arrResponse = array('status' => false, 'msg' => 'Este tipo de norma ya tiene vinculado a otros registros');
                json($arrResponse);
                die();
            }
            if (is_file(path_upload() . 'images/' . $file)) {
                unlink(path_upload()  . 'images/' . $file);
            }
            $request = $this->model->deleteTipoNorma($id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Datos eliminados correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio problemas al eliminar los datos');
            }
            json($arrResponse);
            die();
        }
    }
}
