<?php
class Packanticorrupcion extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
        getPermisos(21);
    }

    public function packanticorrupcion()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
            die();
        }
        $data['page_id'] = 21;
        $data['page_tag'] = "Pack Anticorrupción - MDESV";
        $data['page_title'] = "Pack Anticorrupción";
        $data['page_name'] = "Pack Anticorrupción";
        $data['page_functions_js'] = "functions_packanticorrupcion.js";
        $this->views->getView($this, "packanticorrupcion", $data);
    }

    public function getPackanticorrupcion()
    {
        if ($_SESSION['permisosMod']['r']) {
            $btnEdit = '';
            $btnDelete = '';
            $request = $this->model->selectPackanticorrupcion();
            $cont = 1;
            foreach ($request as $key => $value) {
                if ($value["pa_estado"] == 1) {
                    $status = '<span class="badge badge-primary">Activo</span>';
                    $btnEstado = '<button class="btn btn-primary btn-sm btnEstado"
                    data-id="' . $value["id"] . '"
                    data-nombre="' . $value["pa_nombre"] . '"
                    data-estado="' . (($value["pa_estado"] == 1) ? 0 : 1) . '" ><i class="fa fa-toggle-on"></i></button>';
                } else if ($value["pa_estado"] == 0) {
                    $status = '<span class="badge badge-danger">Inactivo</span>';
                    $btnEstado = '<button class="btn btn-danger btn-sm btnEstado"
                    data-id="' . $value["id"] . '"
                    data-nombre="' . $value["pa_nombre"] . '"
                    data-estado="' . (($value["pa_estado"] == 1) ? 0 : 1) . '"
                    ><i class="fa fa-toggle-off"></i></button>';
                }
                $request[$key]["pa_estado"] = $status;

                $archivoBtn = '<a href="' . base_url() . '/Assets/upload/documentos/' . $value["pa_archivo"] . '" target="_blank" class="btn btn-info btn-sm" title="Ver archivo"><i class="fas fa-file-pdf"></i></a>';

                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = $btnEstado . '
                    <button class="btn btn-primary btn-sm btnEditFile"
                    data-id="' . $value["id"] . '"
                    data-file="' . $value["pa_archivo"] . '"
                    title="Editar archivo"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
                    <button class="btn btn-primary btn-sm btnEdit"
                    data-id="' . $value["id"] . '"
                    data-nombre="' . $value["pa_nombre"] . '"
                    data-orden="' . $value["pa_orden"] . '"
                    title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm btnDel" data-id="' . $value["id"] . '" data-file="' . $value["pa_archivo"] . '" data-nombre="' . $value["pa_nombre"] . '"  title="Eliminar"><i class="far fa-trash-alt"></i></button>';
                }
                $request[$key]["acciones"] = '<div class="text-center">' . $archivoBtn . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
                $request[$key]["cont"] = $cont;
                $cont++;
            }
            json($request);
        }
    }

    public function savePackanticorrupcion()
    {
        if ($_SESSION['permisosMod']['w']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Método no encontrado');
                json($arrResponse);
                die();
            }
            if (!isset($_FILES["flArchivo"])) {
                $arrResponse = array('status' => false, 'msg' => 'Por favor seleccione un archivo PDF');
                json($arrResponse);
                die();
            }

            // Validar que sea PDF
            $fileTmpPath = $_FILES["flArchivo"]["tmp_name"];
            $fileName = $_FILES["flArchivo"]["name"];
            $fileSize = $_FILES["flArchivo"]["size"];
            $fileType = $_FILES["flArchivo"]["type"];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            if ($fileExtension != 'pdf') {
                $arrResponse = array('status' => false, 'msg' => 'Solo se permiten archivos PDF');
                json($arrResponse);
                die();
            }

            // Validar tamaño máximo (10MB)
            if ($fileSize > 10485760) {
                $arrResponse = array('status' => false, 'msg' => 'El archivo no debe superar los 10MB');
                json($arrResponse);
                die();
            }

            $txtNombre = strClean($_POST["txtNombre"]);
            $txtOrden = strClean($_POST["txtOrden"]);
            $idPersona = $_SESSION['idUser'];
            $estado = 1;

            $datetime = date("YmdHis");
            $file = $datetime . '_' . $idPersona . '_' . $fileName;
            $ruta = path_upload() . "documentos/";
            $urlFile = $ruta . $file;

            if ($txtNombre == "" || $idPersona == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }

            verifyFolder($ruta);
            $request_moveFile = move_uploaded_file($_FILES["flArchivo"]["tmp_name"], $urlFile);
            if (!$request_moveFile) {
                $arrResponse = array('status' => false, 'msg' => 'Archivo no movido');
                json($arrResponse);
                die();
            }

            $request = $this->model->insertPackanticorrupcion(
                $idPersona,
                $txtNombre,
                $file,
                $fileName,
                $txtOrden,
                $estado
            );

            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Documento registrado correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrió un error al registrar el documento');
            }
            json($arrResponse);
        }
    }

    public function updatePackanticorrupcion()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Método no encontrado');
                json($arrResponse);
                die();
            }
            $id = intval(strClean($_POST["id_upd"]));
            $txtNombre = strClean($_POST["txtNombre_upd"]);
            $txtOrden = strClean($_POST["txtOrden_upd"]);
            $idPersona = $_SESSION['idUser'];

            if ($id == "" || $txtNombre == "" || $idPersona == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }

            $request = $this->model->updatePackanticorrupcion(
                $idPersona,
                $txtNombre,
                $txtOrden,
                $id
            );

            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Documento actualizado correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrió un error al actualizar el documento');
            }
            json($arrResponse);
        }
    }

    public function updateFilePackanticorrupcion()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Método no encontrado');
                json($arrResponse);
                die();
            }
            if (!isset($_FILES["flArchivo_upd"])) {
                $arrResponse = array('status' => false, 'msg' => 'Archivo no seleccionado');
                json($arrResponse);
                die();
            }

            $fileTmpPath = $_FILES["flArchivo_upd"]["tmp_name"];
            $fileName = $_FILES["flArchivo_upd"]["name"];
            $fileSize = $_FILES["flArchivo_upd"]["size"];
            $fileExtension = strtolower(end(explode(".", $fileName)));

            if ($fileExtension != 'pdf') {
                $arrResponse = array('status' => false, 'msg' => 'Solo se permiten archivos PDF');
                json($arrResponse);
                die();
            }

            if ($fileSize > 10485760) {
                $arrResponse = array('status' => false, 'msg' => 'El archivo no debe superar los 10MB');
                json($arrResponse);
                die();
            }

            $id = intval(strClean($_POST["id_updFil"]));
            $idPersona = $_SESSION['idUser'];
            $fileOld = strClean($_POST["fileOld_updFil"]);

            if ($id == "") {
                $arrResponse = array('status' => false, 'msg' => 'Complete los campos obligatorios');
                json($arrResponse);
                die();
            }

            $datetime = date("YmdHis");
            $file = $datetime . '_' . $idPersona . '_' . $fileName;
            $ruta = path_upload() . "documentos/";
            $urlFile = $ruta . $file;

            verifyFolder($ruta);
            $request_moveFile = move_uploaded_file($_FILES["flArchivo_upd"]["tmp_name"], $urlFile);
            if (!$request_moveFile) {
                $arrResponse = array('status' => false, 'msg' => 'Archivo no movido');
                json($arrResponse);
                die();
            }

            // Eliminar archivo anterior
            if (is_file($ruta . $fileOld) && !unlink($ruta . $fileOld)) {
                // No es crítico si no se puede eliminar
            }

            $request = $this->model->updateFilePackanticorrupcion($id, $file, $fileName);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Archivo actualizado correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se pudo actualizar el archivo');
            }
            json($arrResponse);
        }
    }

    public function updateEstadoPackanticorrupcion()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Método no encontrado');
                json($arrResponse);
                die();
            }
            $id = intval(strClean($_POST["id"]));
            $estado = intval(strClean($_POST["estado"]));

            if ($id == "" || $estado == "") {
                $arrResponse = array('status' => false, 'msg' => 'Campos vacíos');
                json($arrResponse);
                die();
            }

            $request = $this->model->updateEstadoPackanticorrupcion($id, $estado);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Estado actualizado correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrió un error al actualizar el estado');
            }
            json($arrResponse);
        }
    }

    public function deletePackanticorrupcion()
    {
        if ($_SESSION['permisosMod']['d']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Método no encontrado');
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

            if (is_file(path_upload() . 'documentos/' . $file)) {
                unlink(path_upload() . 'documentos/' . $file);
            }

            $request = $this->model->deletePackanticorrupcion($id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Datos eliminados correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrió problemas al eliminar los datos');
            }
            json($arrResponse);
        }
    }
}
