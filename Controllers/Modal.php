<?php
class Modal extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
        getPermisos(10);
    }

    public function modal($params)
    {
        $data['page_id'] = 10;
        $data['page_tag'] =  "Avisos Modal - MDESV";
        $data['page_title'] =  "Avisos Modal - MDESV";
        $data['page_name'] =  "Avisos Modal";
        $data['page_functions_js'] = "functions_modal.js";
        $this->views->getView($this, "modal", $data);
    }

    public function saveModal()
    {
        if ($_SESSION['permisosMod']['w']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $titulo = strClean($_POST["txtTitulo"]);
            $contenido = strClean($_POST["txtContenido"]);
            $sizeAviso = strClean($_POST["tamanoAviso"]);
            $fechaInicio = "";
            $fechaFin = "";
            $incrustacion = strClean($_POST["urls"]);
            $idPersona = $_SESSION['idUser'];
            $estatico = isset($_POST["modalEstatico"]) ? "static" : "";
            $escrolable = isset($_POST["modalEscrolable"]) ? "modal-dialog-scrollable" : "";
            if ($idPersona == "" || $titulo == ""  || $sizeAviso == "") {
                $arrResponse = array('status' => false, 'msg' => 'Campos vacios');
                json($arrResponse);
                die();
            }
            if (isset($_POST["activarFechas"])) {
                $fechaInicio = strClean(str_replace("T", " ", $_POST["fechaInicio"]));
                $fechaFin = strClean(str_replace("T", " ", $_POST["fechaFin"]));
                if ($fechaInicio == "" || $fechaFin == "") {
                    $arrResponse = array('status' => false, 'msg' => 'Los campos de fechas se encuentran vacios');
                    json($arrResponse);
                    die();
                }
            }
            // ——— Manejo de imagen ———
            $imagenRuta = "";
            if (isset($_FILES['imagenAviso']) && $_FILES['imagenAviso']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['imagenAviso']['tmp_name'];
                if (!esImagenValida($tmpName)) {
                    $arrResponse = array('status' => false, 'msg' => 'El archivo de imagen no es válido.');
                    json($arrResponse);
                    die();
                }
                if ($_FILES['imagenAviso']['size'] > 10097152) {
                    $arrResponse = array('status' => false, 'msg' => 'La imagen supera el límite de 10MB.');
                    json($arrResponse);
                    die();
                }
                $extension = pathinfo($_FILES['imagenAviso']['name'], PATHINFO_EXTENSION);
                $nombreArchivo = 'aviso_' . uniqid() . '.' . strtolower($extension);
                $destino = path_upload() . 'images/' . $nombreArchivo;
                if (move_uploaded_file($tmpName, $destino)) {
                    $imagenRuta = $nombreArchivo;
                }
            }
            $request = $this->model->insertModal(
                $titulo,
                $contenido,
                $sizeAviso,
                $fechaInicio,
                $fechaFin,
                $incrustacion,
                $idPersona,
                $estatico,
                $escrolable,
                $imagenRuta
            );
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Registro completado correctamente');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio un error inesperado');
                json($arrResponse);
                die();
            }
        }
    }

    public function getAvisos($params)
    {
        if ($_SESSION['permisosMod']['r']) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            $request = $this->model->selectAvisos();
            $cont = 1;
            foreach ($request as $key => $value) {
                if ($value["a_Estado"] == 1) {
                    $btnToggle = '<button class="btn btn-primary btn-sm btnEstatus" data-id="' . $value["idAviso"] . '" data-nombre="' . $value["a_Titulo"] . '" data-estado="0"  ><i class="fa fa-toggle-on" aria-hidden="true"></i></button>';
                } else if ($value["a_Estado"] == 0) {
                    $btnToggle = '<button class="btn btn-danger btn-sm btnEstatus"  data-id="' . $value["idAviso"] . '" data-nombre="' . $value["a_Titulo"] . '" data-estado="1" ><i class="fa fa-toggle-off" aria-hidden="true"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit =  $btnToggle . '
                    <button class="btn btn-primary btn-sm btnEdit" data-id="' . $value['idAviso'] . '" data-titulo="' . $value["a_Titulo"] . '" data-description="' . $value["a_Descripcion"] . '" title="Editar Datos"><i class="fas fa-pencil-alt"></i></button>
                    <button class="btn btn-primary btn-sm btnEditEmbed" data-id="' . $value['idAviso'] . '" data-incrustacion="' . $value["a_Incrustacion"] . '" title="Editar Embed"><i class="fa fa-link" aria-hidden="true"></i></button>
                    <button class="btn btn-primary btn-sm btnEditConfig" data-id="' . $value['idAviso'] . '"data-sizeA="' . $value['a_sizeAviso'] . '" data-estatic="' . $value['a_Estatico'] . '" data-escrol="' . $value['a_Escrollable'] . '"  title="Editar Config"><i class="fa fa-wrench" aria-hidden="true"></i></button>
                    <button class="btn btn-primary btn-sm btnEditFecha" data-id="' . $value['idAviso'] . '" data-fechaIni="' . $value["a_fechaInicio"] . '" data-fechaFinn="' . $value["a_fechaFin"] . '"  title="Editar Fechas"><i class="fa fa-calendar" aria-hidden="true"></i></button>
                    <button class="btn btn-info btn-sm btnEditImagen" data-id="' . $value['idAviso'] . '" title="Editar Imagen"><i class="fa fa-image" aria-hidden="true"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm btnDel"  title="Eliminar" data-id="' . $value["idAviso"] . '" data-nombre="' . $value["a_Titulo"] . '" ><i class="far fa-trash-alt"></i></button>
                                    </div>';
                }
                $request[$key]["acciones"] = '<div class="text-center">' .  $btnView . ' '  . $btnEdit . ' ' . $btnDelete . '</div>';
                $request[$key]["cont"] = $cont;
                $cont++;
            }
            json($request);
        }
    }

    public function estadoAviso()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $id = strClean($_POST["id"]);
            $estado = strClean($_POST["estado"]);
            if ($id == "" ||  $estado == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->updateEstado($id, $estado);
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

    public function deleteModal()
    {
        if ($_SESSION['permisosMod']['d']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $id = strClean($_POST["id"]);
            if ($id == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->deleteAviso($id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Aviso eliminado correctamente');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se completo la eliminacion del registro');
                json($arrResponse);
                die();
            }
        }
    }

    public function updateInfo()
    {

        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $titulo = strClean($_POST["tituloEditModal"]);
            $contenido = strClean($_POST["txtDescripcion_upd"]);
            $id = intval($_POST["id_upd"]);
            if ($id == "" || $titulo == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            //validar campo título

            $request = $this->model->updateInfo($titulo, $contenido, $id);
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
    public function updateEmbed()
    {

        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $incrustacion = strClean($_POST["url"]);
            $id = intval($_POST["id_upde"]);
            if ($id == "" || $incrustacion == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }

            $request = $this->model->updateEmbed($incrustacion, $id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Registro actualizado correctamente');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se completo el actualizado del registro');
                json($arrResponse);
                die();
            }
        }
    }
    public function updateSize()
    {

        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Método no encontrado');
                json($arrResponse);
                die();
            }
            $sizeAviso = strClean(str_replace("T", " ", $_POST["tamAvi"]));
            $estatico = isset($_POST["modalEstatic"]) ? "static" : "";
            $escrolable = isset($_POST["modalEscrol"]) ? "modal-dialog-scrollable" : "";
            $id = intval($_POST["id_upds"]);
            if ($id == "" || $sizeAviso == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }

            $request = $this->model->updateSize($sizeAviso, $estatico, $escrolable, $id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Registro actualizado correctamente');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se completo el actualizado del registro');
                json($arrResponse);
                die();
            }
        }
    }
    public function updateFecha()
    {

        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Método no encontrado');
                json($arrResponse);
                die();
            }

            $id = intval($_POST["id_updfh"]);
            if ($id == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }

            $fechaInicio = strClean(str_replace("T", " ", $_POST["fechaIni"]));
            $fechaFin = strClean(str_replace("T", " ", $_POST["fechaEnd"]));
            if ($fechaInicio == "" || $fechaFin == "") {
                $fechaInicio = null;
                $fechaFin = null;
            }

            $request = $this->model->updateFecha($fechaInicio, $fechaFin, $id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Registro actualizado correctamente');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se completo el actualizado del registro');
                json($arrResponse);
                die();
            }
        }
    }

    public function updateImagen()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Método no encontrado');
                json($arrResponse);
                die();
            }
            $id = intval($_POST["id_updimg"]);
            if ($id == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            if (!isset($_FILES['imagenAvisoEdit']) || $_FILES['imagenAvisoEdit']['error'] !== UPLOAD_ERR_OK) {
                $arrResponse = array('status' => false, 'msg' => 'Debe seleccionar una imagen válida');
                json($arrResponse);
                die();
            }
            $tmpName = $_FILES['imagenAvisoEdit']['tmp_name'];
            if (!esImagenValida($tmpName)) {
                $arrResponse = array('status' => false, 'msg' => 'El archivo de imagen no es válido.');
                json($arrResponse);
                die();
            }
            if ($_FILES['imagenAvisoEdit']['size'] > 10097152) {
                $arrResponse = array('status' => false, 'msg' => 'La imagen supera el límite de 10MB.');
                json($arrResponse);
                die();
            }
            $extension = pathinfo($_FILES['imagenAvisoEdit']['name'], PATHINFO_EXTENSION);
            $nombreArchivo = 'aviso_' . uniqid() . '.' . strtolower($extension);
            $destino = path_upload() . 'images/' . $nombreArchivo;
            if (!move_uploaded_file($tmpName, $destino)) {
                $arrResponse = array('status' => false, 'msg' => 'No se pudo guardar la imagen en el servidor.');
                json($arrResponse);
                die();
            }
            $request = $this->model->updateImagen($nombreArchivo, $id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Imagen actualizada correctamente');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se completó la actualización de la imagen');
                json($arrResponse);
                die();
            }
        }
    }
}
