<?php
class Carousel extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
        getPermisos(5);
    }

    public function carousel($params)
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_id'] = 5;
        $data['page_tag'] =  "Carousel - MDESV";
        $data['page_title'] =  "Carousel - MDESV";
        $data['page_name'] =  "Carousel";
        $data['page_functions_js'] = "functions_carousel.js";
        $this->views->getView($this, "carousel", $data);
    }
    public function getCarousel()
    {
        if ($_SESSION['permisosMod']['r']) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            $request = $this->model->selectCarousel();
            foreach ($request as $key => $value) {
                if ($value["c_estado"] == 1) {
                    $status = '<span class="badge badge-primary">Publicado</span>';
                    $btnEstado = '
                    <button class="btn btn-primary btn-sm btnEditFile"
                    data-id="' . $value["id"] . '"
                    data-image="' . $value["c_archivo"] . '" >
                        <i class="fa fa-picture-o" aria-hidden="true"></i>
                    </button>
                    <button class="btn btn-primary btn-sm btnEstado" 
                    data-id="' . $value["id"] . '" 
                    data-titulo="' . $value["c_titulo"] . '" 
                    data-estado="' . (($value["c_estado"] == 1) ? 0 : 1) . '" 
                    title="Cambiar estado"> <i class="fa fa-toggle-on" aria-hidden="true"></i> </button>';
                } else if ($value["c_estado"] == 0) {
                    $status = '<span class="badge badge-danger">No publicado</span>';
                    $btnEstado = '
                    <button class="btn btn-primary btn-sm btnEditFile"
                    data-id="' . $value["id"] . '"
                    data-image="' . $value["c_archivo"] . '" >
                        <i class="fa fa-picture-o" aria-hidden="true"></i>
                    </button>
                    <button class="btn btn-danger btn-sm btnEstado" 
                    data-id="' . $value["id"] . '" 
                    data-titulo="' . $value["c_titulo"] . '" 
                    data-estado="' . (($value["c_estado"] == 1) ? 0 : 1) . '" 
                    title="Cambiar estado"><i class="fa fa-toggle-off" aria-hidden="true"></i></button>';
                }
                $request[$key]["c_estado"] = $status;
                /* if ($_SESSION['permisosMod']['r']) {
                 $btnView = '<button class="btn btn-secondary btn-sm btnPermisosRol"  title="Permisos"><i class="fas fa-eye"></i></button>';
                    }*/
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '  
                    ' . $btnEstado . '
                    
                    <button class="btn btn-primary btn-sm btnEdit" 
                    data-id="' . $value["id"] . '" 
                    data-titulo="' . $value["c_titulo"] . '" 
                    data-colorTitulo="' . $value["c_colorTitulo"] . '" 
                    data-descripcion="' . $value["c_descripcion"] . '" 
                    data-colorDescripcion="' . $value["c_colorDescripcion"] . '" 
                    data-estado="' . $value["c_estado"] . '"
                    data-estadoBtn="' . $value["c_botonOculto"] . '"
                    data-estadoContent="' . $value["c_textoOculto"] . '"
                    data-nameBtn="' . $value["c_nombreBoton"] . '"
                    data-colorBtn="' . $value["c_colorBoton"] . '"
                    data-linkBtn="' . $value["c_linkBoton"] . '" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm btnDel" data-id="' . $value["id"] . '"  data-titulo="' . $value["c_titulo"] . '" data-file="' . $value["c_archivo"] . '"  title="Eliminar"><i class="far fa-trash-alt"></i></button>';
                }
                $request[$key]["acciones"] = '<div class="text-center">' . $btnView . ' '  . $btnEdit . ' ' . $btnDelete  . '</div>';
            }
            json($request);
        }
    }
    public function saveCarousel()
    {
        if ($_SESSION['permisosMod']['w']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            if (!isset($_FILES["flArchivo"])) {
                $arrResponse = array('status' => false, 'msg' => 'Por favor seleccione una imagen');
                json($arrResponse);
                die();
            }
            $arrSize = getimagesize($_FILES["flArchivo"]["tmp_name"]);
            if ($arrSize[0] < 2046 || $arrSize[0] > 2059) {
                $arrResponse = array('status' => false, 'msg' => 'El ancho de la imagen no cumple con el rango permitido [2046 - 2059]px, Medida Actual : ' . $arrSize[0] . "px");
                json($arrResponse);
                die();
            }
            if ($arrSize[1] < 746 || $arrSize[1] > 789) {
                $arrResponse = array('status' => false, 'msg' => 'El alto de la imagen no cumple con el rango permitido [746 - 789]px, Medida Actual : ' . $arrSize[1] . "px");
                json($arrResponse);
                die();
            }
            $txtTitulo = strClean($_POST["txtTitulo"]);
            $flArchivo = $_FILES["flArchivo"]["name"];
            $txtDescripcion = strClean($_POST["txtDescripcion"]);
            $txtBtn = strClean($_POST["txtBtn"]);
            $txtUrlBtn = strClean($_POST["txtUrlBtn"]);
            $clrBtn = strClean($_POST["clrBtn"]);
            $idPersona = $_SESSION['idUser'];
            $clrTitulo = strClean($_POST["clrTitulo"]);
            $clrDescripcion = strClean($_POST["clrDescripcion"]);
            $textoOculo = 1;
            $botonOculto = 1;
            $datetime = date("YmdHis");
            $file = $datetime . $idPersona . $flArchivo;
            $ruta = path_upload() . "images/";
            $urlFile = $ruta . $file;
            if (!isset($_POST["chcbxTexto"])) {
                $textoOculo = 0;
                $txtTitulo = $file;
                $txtDescripcion = "";
            } else {
                if ($txtTitulo == "" || $txtDescripcion == "" || $clrTitulo == "" || $clrDescripcion == "") {
                    $arrResponse = array('status' => false, 'msg' => 'LLene los campos que son obligatorios de la descripción');
                    json($arrResponse);
                    die();
                }
            }
            if (!isset($_POST["chbxBtn"])) {
                $botonOculto = 0;
                $txtBtn = "";
                $txtUrlBtn = "";
                $clrBtn = "";
                $txtUrlBtn = "";
                $clrBtn = "";
            } else {
                if ($txtBtn == "" || $txtUrlBtn == "" || $clrBtn == "") {
                    $arrResponse = array('status' => false, 'msg' => 'LLene los campos que son obligatorios del boton');
                    json($arrResponse);
                    die();
                }
            }
            verifyFolder($ruta);
            $request_moveFile = move_uploaded_file($_FILES["flArchivo"]["tmp_name"], $urlFile);
            if (!$request_moveFile) {
                $arrResponse = array('status' => false, 'msg' => 'Archivo no movido');
                json($arrResponse);
                die();
            }
            $request = $this->model->insertCarousel($txtTitulo, $clrTitulo,  $txtDescripcion, $clrDescripcion,  $file,  $textoOculo, $botonOculto,  $txtBtn,  $clrBtn,  $txtUrlBtn,  $idPersona);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Carousel registro y publicado correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio un error al registrar el carousel');
            }
            json($arrResponse);
        }
    }
    public function deleteCarousel()
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
            if (is_file(path_upload() . 'images/' . $file)) {
                unlink(path_upload()  . 'images/' . $file);
            }
            $request = $this->model->deleteCarousel($id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Datos eliminados correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio problemas al eliminar los datos');
            }
            json($arrResponse);
            die();
        }
    }
    public function updateCarouselContent()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $idCarousel = intval($_POST["idCarousel"]);
            $txtTitulo = strClean($_POST["txtTituloEdit"]);
            $txtDescripcion = strClean($_POST["txtDescripcionEdit"]);
            $txtBtn = strClean($_POST["txtBtnEdit"]);
            $txtUrlBtn = strClean($_POST["txtUrlBtnEdit"]);
            $clrBtn = strClean($_POST["clrBtnEdit"]);
            $clrTitulo = strClean($_POST["clrTituloEdit"]);
            $clrDescripcion = strClean($_POST["clrDescripcionEdit"]);
            $idPersona = $_SESSION['idUser'];
            $textoOculo = 1;
            $botonOculto = 1;
            if (!isset($_POST["chbxConetenidoEdit"])) {
                $textoOculo = 0;
            } else {
                if ($txtTitulo == "" || $txtDescripcion == "" || $clrTitulo == "" || $clrDescripcion == "") {
                    $arrResponse = array('status' => false, 'msg' => 'LLene los campos que son obligatorios de la descripción');
                    json($arrResponse);
                    die();
                }
            }
            if (!isset($_POST["chbxBtnEdit"])) {
                $botonOculto = 0;
            } else {
                if ($txtBtn == "" || $txtUrlBtn == "" || $clrBtn == "") {
                    $arrResponse = array('status' => false, 'msg' => 'LLene los campos que son obligatorios del boton');
                    json($arrResponse);
                    die();
                }
            }
            $request = $this->model->updateCarouselConten(
                $txtTitulo,
                $clrTitulo,
                $txtDescripcion,
                $clrDescripcion,
                $textoOculo,
                $botonOculto,
                $txtBtn,
                $clrBtn,
                $txtUrlBtn,
                $idPersona,
                $idCarousel
            );
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Información carousel actualizada correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio un error al actualizar el carousel');
            }
            json($arrResponse);
        }
    }
    public function updateEstadoCarousel()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $id = intval(strClean($_POST["id"]));
            $estado = intval(strClean($_POST["estadoCarusel"]));
            if ($id == "" || $estado == "") {
                $arrResponse = array('status' => false, 'msg' => 'Campos vacios por favor llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            $request = $this->model->updateCarouselEstado($id, $estado);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Información carousel actualizada correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio un error al actualizar el carousel');
            }
            json($arrResponse);
        }
    }
    public function updateFileCarousel()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $arrSize = getimagesize($_FILES["flArchivo_updFil"]["tmp_name"]);
            if ($arrSize[0] < 2046 || $arrSize[0] > 2059) {
                $arrResponse = array('status' => false, 'msg' => 'El ancho de la imagen no cumple con el rango permitido [2046 - 2059]px, Medida Actual : ' . $arrSize[0] . "px");
                json($arrResponse);
                die();
            }
            if ($arrSize[1] < 746 || $arrSize[1] > 789) {
                $arrResponse = array('status' => false, 'msg' => 'El alto de la imagen no cumple con el rango permitido [746 - 789]px, Medida Actual : ' . $arrSize[1] . "px");
                json($arrResponse);
                die();
            }
            $id = intval(strClean($_POST["ip_updFil"]));
            $file = $_FILES["flArchivo_updFil"]["name"];
            $idPersona = $_SESSION['idUser'];

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
            $request = $this->model->updateFotoCarousel($id, $file);

            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Foto de carousel actualizada');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se pudo actualizar le registro');
                json($arrResponse);
                die();
            }
        }
    }
}
