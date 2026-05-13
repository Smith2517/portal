<?php
class Gobiernocorporativo extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
        getPermisos(22);
    }

    public function gobiernocorporativo()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
            die();
        }
        $data['page_id'] = 22;
        $data['page_tag'] = "Gobierno Corporativo - MDESV";
        $data['page_title'] = "Gobierno Corporativo";
        $data['page_name'] = "Gobierno Corporativo";
        $data['page_functions_js'] = "functions_gobiernocorporativo.js";
        $this->views->getView($this, "gobiernocorporativo", $data);
    }

    public function getGobiernocorporativo()
    {
        if ($_SESSION['permisosMod']['r']) {
            $btnEdit = '';
            $btnDelete = '';
            $request = $this->model->selectGobiernocorporativo();
            $cont = 1;
            foreach ($request as $key => $value) {
                if ($value["gc_estado"] == 1) {
                    $status = '<span class="badge badge-primary">Publicado</span>';
                    $btnEstado = '<button class="btn btn-primary btn-sm btnEstado"
                    data-id="' . $value["id"] . '"
                    data-titulo="' . $value["gc_titulo"] . '"
                    data-estado="' . (($value["gc_estado"] == 1) ? 0 : 1) . '" ><i class="fa fa-toggle-on"></i></button>';
                } else if ($value["gc_estado"] == 0) {
                    $status = '<span class="badge badge-danger">No publicado</span>';
                    $btnEstado = '<button class="btn btn-danger btn-sm btnEstado"
                    data-id="' . $value["id"] . '"
                    data-titulo="' . $value["gc_titulo"] . '"
                    data-estado="' . (($value["gc_estado"] == 1) ? 0 : 1) . '"
                    ><i class="fa fa-toggle-off"></i></button>';
                }
                $request[$key]["gc_estado"] = $status;

                $archivoBtn = '<a href="' . base_url() . '/Assets/upload/documentos/' . $value["gc_archivo"] . '" target="_blank" class="btn btn-info btn-sm" title="Ver documento"><i class="fas fa-file-pdf"></i></a>';

                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = $btnEstado . '
                    <button class="btn btn-primary btn-sm btnEditFile"
                    data-id="' . $value["id"] . '"
                    data-file="' . $value["gc_archivo"] . '"
                    title="Editar archivo"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
                    <button class="btn btn-primary btn-sm btnEdit"
                    data-id="' . $value["id"] . '"
                    data-titulo="' . $value["gc_titulo"] . '"
                    data-numero="' . $value["gc_numero"] . '"
                    data-fecha="' . $value["gc_fecha"] . '"
                    data-categoria="' . $value["gc_categoria"] . '"
                    data-descripcion="' . str_replace('"', '«', $value["gc_descripcion"]) . '"
                    title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm btnDel" data-id="' . $value["id"] . '" data-file="' . $value["gc_archivo"] . '" data-titulo="' . $value["gc_titulo"] . '"  title="Eliminar"><i class="far fa-trash-alt"></i></button>';
                }
                $request[$key]["acciones"] = '<div class="text-center">' . $archivoBtn . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
                $request[$key]["cont"] = $cont;
                $cont++;
            }
            json($request);
        }
    }

    public function saveGobiernocorporativo()
    {
        if ($_SESSION['permisosMod']['w']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Método no encontrado');
                json($arrResponse);
                die();
            }
            if (!isset($_FILES["flArchivo"])) {
                $arrResponse = array('status' => false, 'msg' => 'Por favor seleccione un documento PDF');
                json($arrResponse);
                die();
            }

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

            if ($fileSize > 10485760) {
                $arrResponse = array('status' => false, 'msg' => 'El archivo no debe superar los 10MB');
                json($arrResponse);
                die();
            }

            $txtTitulo = strClean($_POST["txtTitulo"]);
            $txtNumero = strClean($_POST["txtNumero"]);
            $txtFecha = strClean($_POST["txtFecha"]);
            $txtCategoria = strClean($_POST["txtCategoria"]);
            $txtDescripcion = strClean($_POST["txtDescripcion"]);
            $idPersona = $_SESSION['idUser'];
            $estado = 1;

            $datetime = date("YmdHis");
            $file = $datetime . '_' . $idPersona . '_' . $fileName;
            $ruta = path_upload() . "documentos/";
            $urlFile = $ruta . $file;

            if ($txtTitulo == "" || $idPersona == "") {
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

            $request = $this->model->insertGobiernocorporativo(
                $idPersona,
                $txtTitulo,
                $txtNumero,
                $txtFecha,
                $txtCategoria,
                $txtDescripcion,
                $file,
                $fileName,
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

    public function updateGobiernocorporativo()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Método no encontrado');
                json($arrResponse);
                die();
            }
            $id = intval(strClean($_POST["id_upd"]));
            $txtTitulo = strClean($_POST["txtTitulo_upd"]);
            $txtNumero = strClean($_POST["txtNumero_upd"]);
            $txtFecha = strClean($_POST["txtFecha_upd"]);
            $txtCategoria = strClean($_POST["txtCategoria_upd"]);
            $txtDescripcion = strClean($_POST["txtDescripcion_upd"]);
            $idPersona = $_SESSION['idUser'];

            if ($id == "" || $txtTitulo == "" || $idPersona == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }

            $request = $this->model->updateGobiernocorporativo(
                $idPersona,
                $txtTitulo,
                $txtNumero,
                $txtFecha,
                $txtCategoria,
                $txtDescripcion,
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

    public function updateFileGobiernocorporativo()
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

            if (is_file($ruta . $fileOld) && !unlink($ruta . $fileOld)) {
                // No es crítico si no se puede eliminar
            }

            $request = $this->model->updateFileGobiernocorporativo($id, $file, $fileName);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Archivo actualizado correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se pudo actualizar el archivo');
            }
            json($arrResponse);
        }
    }

    public function updateEstadoGobiernocorporativo()
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

            $request = $this->model->updateEstadoGobiernocorporativo($id, $estado);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Estado actualizado correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrió un error al actualizar el estado');
            }
            json($arrResponse);
        }
    }

    public function deleteGobiernocorporativo()
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

            $request = $this->model->deleteGobiernocorporativo($id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Datos eliminados correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrió problemas al eliminar los datos');
            }
            json($arrResponse);
        }
    }
}
