<?php
class Integrantessci extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
        getPermisos(16);
    }

    public function integrantessci()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
            die();
        }
        $data['page_id'] = 16;
        $data['page_tag'] = "Integrantes SCI - MDESV";
        $data['page_title'] = "Integrantes del Sistema de Control Interno";
        $data['page_name'] = "Integrantes SCI";
        $data['page_functions_js'] = "functions_integrantessci.js";
        $this->views->getView($this, "integrantessci", $data);
    }

    public function getIntegrantesSci()
    {
        if ($_SESSION['permisosMod']['r']) {
            $btnEdit = '';
            $btnDelete = '';
            $request = $this->model->selectIntegrantesSci();
            $cont = 1;
            foreach ($request as $key => $value) {
                if ($value["i_estado"] == 1) {
                    $status = '<span class="badge badge-primary">Activo</span>';
                    $btnEstado = '<button class="btn btn-primary btn-sm btnEstado"
                    data-id="' . $value["id"] . '"
                    data-nombre="' . $value["i_nombres"] . ' ' . $value["i_apellidos"] . '"
                    data-estado="' . (($value["i_estado"] == 1) ? 0 : 1) . '" ><i class="fa fa-toggle-on"></i></button>';
                } else if ($value["i_estado"] == 0) {
                    $status = '<span class="badge badge-danger">Inactivo</span>';
                    $btnEstado = '<button class="btn btn-danger btn-sm btnEstado"
                    data-id="' . $value["id"] . '"
                    data-nombre="' . $value["i_nombres"] . ' ' . $value["i_apellidos"] . '"
                    data-estado="' . (($value["i_estado"] == 1) ? 0 : 1) . '"
                    ><i class="fa fa-toggle-off"></i></button>';
                }
                $request[$key]["i_estado"] = $status;
                
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = $btnEstado . '
                    <button class="btn btn-primary btn-sm btnEditFile"
                    data-id="' . $value["id"] . '"
                    data-image="' . $value["i_foto"] . '"
                    title="Editar foto"><i class="fa fa-file-image-o" aria-hidden="true"></i></button>
                    <button class="btn btn-primary btn-sm btnEdit"
                    data-id="' . $value["id"] . '"
                    data-nombres="' . $value["i_nombres"] . '"
                    data-apellidos="' . $value["i_apellidos"] . '"
                    data-cargo="' . $value["i_cargo"] . '"
                    data-dependencia="' . $value["i_dependencia"] . '"
                    data-correo="' . $value["i_correo"] . '"
                    data-celular="' . $value["i_celular"] . '"
                    title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm btnDel" data-id="' . $value["id"] . '" data-file="' . $value["i_foto"] . '" data-nombre="' . $value["i_nombres"] . ' ' . $value["i_apellidos"] . '"  title="Eliminar"><i class="far fa-trash-alt"></i></button>';
                }
                $request[$key]["acciones"] = '<div class="text-center">' . $btnEdit . ' ' . $btnDelete . '</div>';
                $request[$key]["cont"] = $cont;
                $cont++;
            }
            json($request);
        }
    }

    public function saveIntegranteSci()
    {
        if ($_SESSION['permisosMod']['w']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Método no encontrado');
                json($arrResponse);
                die();
            }
            if (!isset($_FILES["flArchivo"])) {
                $arrResponse = array('status' => false, 'msg' => 'Por favor seleccione una imagen');
                json($arrResponse);
                die();
            }
            
            // Validar que sea una imagen
            $arrSize = getimagesize($_FILES["flArchivo"]["tmp_name"]);
            if ($arrSize === false) {
                $arrResponse = array('status' => false, 'msg' => 'El archivo seleccionado no es una imagen válida');
                json($arrResponse);
                die();
            }

            $txtNombres = strClean($_POST["txtNombres"]);
            $txtApellidos = strClean($_POST["txtApellidos"]);
            $txtCargo = strClean($_POST["txtCargo"]);
            $txtDependencia = strClean($_POST["txtDependencia"]);
            $txtCorreo = strClean($_POST["txtCorreo"]);
            $txtCelular = strClean($_POST["txtCelular"]);
            $idPersona = $_SESSION['idUser'];
            $estado = 1;

            // Redimensionar imagen a 413x531px
            $datetime = date("YmdHis");
            $flArchivo = $_FILES["flArchivo"]["name"];
            $file = $datetime . $idPersona . '.jpg';
            $ruta = path_upload() . "images/";
            $urlFile = $ruta . $file;

            if ($txtNombres == "" || $txtApellidos == "" || $txtCargo == "" || $idPersona == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }

            verifyFolder($ruta);
            
            // Redimensionar y guardar la imagen
            $request_resize = resizeImage($_FILES["flArchivo"]["tmp_name"], $urlFile, 413, 531);
            if (!$request_resize) {
                $arrResponse = array('status' => false, 'msg' => 'Error al procesar la imagen');
                json($arrResponse);
                die();
            }

            $request = $this->model->insertIntegranteSci(
                $idPersona,
                $txtNombres,
                $txtApellidos,
                $txtCargo,
                $txtDependencia,
                $txtCorreo,
                $txtCelular,
                $file,
                $estado
            );
            
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Integrante registrado correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrió un error al registrar el integrante');
            }
            json($arrResponse);
        }
    }

    public function updateIntegranteSci()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Método no encontrado');
                json($arrResponse);
                die();
            }
            $id = intval(strClean($_POST["id_upd"]));
            $txtNombres = strClean($_POST["txtNombres_upd"]);
            $txtApellidos = strClean($_POST["txtApellidos_upd"]);
            $txtCargo = strClean($_POST["txtCargo_upd"]);
            $txtDependencia = strClean($_POST["txtDependencia_upd"]);
            $txtCorreo = strClean($_POST["txtCorreo_upd"]);
            $txtCelular = strClean($_POST["txtCelular_upd"]);
            $idPersona = $_SESSION['idUser'];
            
            if ($id == "" || $txtNombres == "" || $txtApellidos == "" || $txtCargo == "" || $idPersona == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            
            $request = $this->model->updateIntegranteSci(
                $idPersona,
                $txtNombres,
                $txtApellidos,
                $txtCargo,
                $txtDependencia,
                $txtCorreo,
                $txtCelular,
                $id
            );
            
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Integrante actualizado correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrió un error al actualizar el integrante');
            }
            json($arrResponse);
        }
    }

    public function updateFileIntegranteSci()
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
            
            // Validar que sea una imagen
            $arrSize = getimagesize($_FILES["flArchivo_upd"]["tmp_name"]);
            if ($arrSize === false) {
                $arrResponse = array('status' => false, 'msg' => 'El archivo seleccionado no es una imagen válida');
                json($arrResponse);
                die();
            }

            $id = intval(strClean($_POST["id_updFil"]));
            $idPersona = $_SESSION['idUser'];
            $fileOld = strClean($_POST["photoOld_updFil"]);

            if ($id == "") {
                $arrResponse = array('status' => false, 'msg' => 'Complete los campos obligatorios');
                json($arrResponse);
                die();
            }

            $datetime = date("YmdHis");
            $file = $datetime . $idPersona . '.jpg';
            $ruta = path_upload() . "images/";
            $urlFile = $ruta . $file;

            verifyFolder($ruta);

            // Redimensionar y guardar la imagen
            $request_resize = resizeImage($_FILES["flArchivo_upd"]["tmp_name"], $urlFile, 413, 531);
            if (!$request_resize) {
                $arrResponse = array('status' => false, 'msg' => 'Error al procesar la imagen');
                json($arrResponse);
                die();
            }

            if (is_file($ruta . $fileOld) && !unlink($ruta . $fileOld)) {
                $arrResponse = array('status' => false, 'msg' => 'Archivo no eliminado');
                json($arrResponse);
                die();
            }
            
            $request = $this->model->updateFileIntegranteSci($id, $file);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Foto actualizada correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se pudo actualizar la foto');
            }
            json($arrResponse);
        }
    }

    public function updateEstadoIntegranteSci()
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
            
            $request = $this->model->updateEstadoIntegranteSci($id, $estado);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Estado actualizado correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrió un error al actualizar el estado');
            }
            json($arrResponse);
        }
    }

    public function deleteIntegranteSci()
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
            
            if (is_file(path_upload() . 'images/' . $file)) {
                unlink(path_upload() . 'images/' . $file);
            }
            
            $request = $this->model->deleteIntegranteSci($id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Datos eliminados correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrió problemas al eliminar los datos');
            }
            json($arrResponse);
        }
    }
}
