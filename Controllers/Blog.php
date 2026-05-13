<?php
class Blog extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
        getPermisos(10);
    }
    public function blog($params)
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        if (!isset($params) || empty($params)) {
            header("Location:" . base_url() . '/dashboard');
        }
        $params = explode(",", $params)[0];
        $request = $this->model->selectCategoriaInfo($params);
        if (empty($request)) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_id'] = 11;
        $data['page_tag'] = $request['c_Categoria'] . " - MDESV";
        $data['page_title'] = $request['c_Categoria'] . " - MDESV";
        $data['page_name'] = $request['c_Categoria'] . "";
        $data['page_functions_js'] = "functions_blog.js";
        $data['page_categoria'] = $request;
        $this->views->getView($this, "blog", $data);
    }
    public function categorias($params)
    {
        $data['page_id'] = 11;
        $data['page_tag'] =  "Categorias - MDESV";
        $data['page_title'] =  "Categorias - MDESV";
        $data['page_name'] =  "Categorias";
        $data['page_functions_js'] = "functions_categorias.js";
        $this->views->getView($this, "categorias", $data);
    }
    public function getCategorias()
    {
        if ($_SESSION['permisosMod']['r']) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            $request = $this->model->selectCategorias();
            $cont = 1;
            foreach ($request as $key => $value) {
                $request[$key]["link"] = "<a target='_Blank' href='" . base_url() . "/page/b/" . $value["idCategoria"] . "' >Link</a>";

                if ($value["c_Estado"] == 1) {

                    $status = '<span class="badge badge-primary">Activo</span>';
                    $btnToggle = '<button class="btn btn-primary btn-sm btnEstatus" data-id="' . $value["idCategoria"] . '"  data-nombre="' . $value["c_Categoria"] . '"  data-estado="0"  ><i class="fa fa-toggle-on" aria-hidden="true"></i></button>';
                } else if ($value["c_Estado"] == 0) {
                    $status = '<span class="badge badge-danger">Desactivado</span>';
                    $btnToggle = '<button class="btn btn-danger btn-sm btnEstatus"  data-id="' . $value["idCategoria"] . '"  data-nombre="' . $value["c_Categoria"] . '"  data-estado="1" ><i class="fa fa-toggle-off" aria-hidden="true"></i></button>';
                }
                $request[$key]["c_Estado"] = $status;
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit =  $btnToggle . '
                    <button class="btn btn-primary btn-sm btnEdit" data-id="' . $value['idCategoria'] . '" data-nombre="' . $value["c_Categoria"] . '" data-description="' . $value["c_Descripcion"] . '" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                    <button class="btn btn-primary btn-sm btnEditFile" data-id="' . $value["idCategoria"] . '" data-image="' . $value["c_Imagen"] . '" title="Editar"><i class="fa fa-file-image-o" aria-hidden="true"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm btnDel"  title="Eliminar" data-id="' . $value["idCategoria"] . '" data-file="' . $value["c_Imagen"] . '"  data-nombre="' . $value["c_Categoria"] . '" ><i class="far fa-trash-alt"></i></button>
                                    </div>';
                }
                $request[$key]["acciones"] = '<div class="text-center">' .  $btnView . ' '  . $btnEdit . ' ' . $btnDelete . '</div>';
                $request[$key]["cont"] = $cont;
                $cont++;
            }
            json($request);
        }
    }
    public function getBlog($params)
    {
        if ($_SESSION['permisosMod']['r']) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            $id = strClean($params);
            $request = $this->model->selectBlogs($id);
            $cont = 1;
            foreach ($request as $key => $value) {
                $request[$key]["link"] = "<a target='_Blank' href='" . base_url() . "/page/b/" . $value["idCategoria"] . "/" . $value["b_tituloGuion"] . "' >Link</a>";
                $request[$key]["publicador"] = $value["nombres"] . " " . $value["apellidos"];
                if ($value["b_Estado"] == 1) {
                    $status = '<span class="badge badge-primary">Activo</span>';
                    $btnToggle = '<button class="btn btn-primary btn-sm btnEstatus" data-id="' . $value["idBlog"] . '"  data-titulo="' . $value["b_Titulo"] . '"  data-estado="0"  ><i class="fa fa-toggle-on" aria-hidden="true"></i></button>';
                } else if ($value["b_Estado"] == 0) {
                    $status = '<span class="badge badge-danger">Desactivado</span>';
                    $btnToggle = '<button class="btn btn-danger btn-sm btnEstatus"  data-id="' . $value["idBlog"] . '"  data-titulo="' . $value["b_Titulo"] . '"  data-estado="1" ><i class="fa fa-toggle-off" aria-hidden="true"></i></button>';
                }
                $request[$key]["b_Estado"] = $status;
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit =  $btnToggle . '
                    <button class="btn btn-primary btn-sm btnEdit" data-id="' . $value['idBlog'] . '" data-titulo="' . $value["b_Titulo"] . '" data-subtitulo="' . $value["b_subTitulo"] . '" data-contenido="' . $value["b_Contenido"] . '" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                    <button class="btn btn-primary btn-sm btnEditImg" data-id="' . $value['idBlog'] . '" data-imagen="' . $value["b_Imagen"] . '" data-descripcionI="' . $value["b_descripcionImagen"] . '" title="Editar"><i class="fa fa-file-image-o" aria-hidden="true"></i></button>
                    <button class="btn btn-primary btn-sm btnEditEmbed" data-id="' . $value['idBlog'] . '" data-enlace="' . $value["b_Embed"] . '" title="Editar"><i class="fa fa-link" aria-hidden="true"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm btnDel"  title="Eliminar" data-id="' . $value["idBlog"] . '" data-Img="' . $value["b_Imagen"] . '"  data-titulo="' . $value["b_Titulo"] . '" ><i class="far fa-trash-alt"></i></button>
                                    </div>';
                }
                $request[$key]["acciones"] = '<div class="text-center">' .  $btnView . ' '  . $btnEdit . ' ' . $btnDelete . '</div>';
                $request[$key]["cont"] = $cont;
                $cont++;
            }
            json($request);
        }
    }
    public function saveCategoria()
    {
        if ($_SESSION['permisosMod']['w']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $txtNombre = strClean($_POST["txtNombreCategoria"]);
            $txtDescripcion = strClean($_POST["txtDescripcionCategoria"]);
            $nameFile = $_FILES["ImgArchiv"]["name"];
            $idPersona = $_SESSION['idUser'];
            if ($txtNombre == ""  || $idPersona == "") {
                $arrResponse = array('status' => false, 'msg' => 'Campos vacios, llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            $datetime = date("YmdHis");
            $file = $datetime . $idPersona . $nameFile;
            $ruta = path_upload() . "images/";
            $urlFile = $ruta . $file;
            verifyFolder($ruta);

            if (!esImagenValida($_FILES["ImgArchiv"]["tmp_name"])) {
                $arrResponse = array('status' => false, 'msg' => 'El archivo no es una imagen válida.');
                json($arrResponse);
                die();
            }

            $request_moveFile = move_uploaded_file($_FILES["ImgArchiv"]["tmp_name"], $urlFile);
            if (!$request_moveFile) {
                $arrResponse = array('status' => false, 'msg' => 'Archivo no movido');
                json($arrResponse);
                die();
            }

            $existingCategoria = $this->model->getCategoriaByName($txtNombre);
            if ($existingCategoria) {
                $arrResponse = array('status' => false, 'msg' => 'Ya existe una categoría con este nombre');
                json($arrResponse);
                die();
            }

            $request = $this->model->insertCategoria($txtNombre, $txtDescripcion, $file, $idPersona);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Registro completado correctamente');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se completo de manera correcta el registro');
                json($arrResponse);
                die();
            }
        }
    }
    public function saveBlog()
    {
        if ($_SESSION['permisosMod']['w']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            if (!isset($_FILES["ImgBlog"])) {
                $arrResponse = array('status' => false, 'msg' => 'No ha seleccionado ninguna imagen');
                json($arrResponse);
                die();
            }
            $tituloBlog = strClean($_POST["tituloBlog"]);
            $subtitulo = strClean($_POST["subTituloBlog"]);
            $contenido = strClean($_POST["contenidoBlog"]);
            $descripcionImg = strClean($_POST["descripcionImg"]);
            $idPersona = $_SESSION['idUser'];
            $imagen = $_FILES["ImgBlog"]["name"];
            $txtfile = strClean($_POST["urls"]);
            $categoria_id = strClean($_POST["categoria_id"]);

            if ($tituloBlog == "" || $subtitulo == "" || $contenido == "" || $imagen == "" || $idPersona == "") {
                $arrResponse = array('status' => false, 'msg' => 'Complete los campos que son obligatorios');
                json($arrResponse);
                die();
            }

            $file = $imagen;
            $ruta = path_upload() . "images/";
            $urlFile = $ruta . $file;
            verifyFolder($ruta);
            
            if (!esImagenValida($_FILES["ImgBlog"]["tmp_name"])) {
                $arrResponse = array('status' => false, 'msg' => 'El archivo no es una imagen válida.');
                json($arrResponse);
                die();
            }
            
            $request_moveFile = move_uploaded_file($_FILES["ImgBlog"]["tmp_name"], $urlFile);
            if (!$request_moveFile) {
                $arrResponse = array('status' => false, 'msg' => 'Archivo no movido');
                json($arrResponse);
                die();
            }

            $request = $this->model->insertBlog(
                $tituloBlog,
                $subtitulo,
                $contenido,
                $imagen,
                $descripcionImg,
                $txtfile,
                $categoria_id,
                $idPersona
            );
            if ($request>0) {
                $arrResponse = array('status' => true, 'msg' => 'Blog registrado y publicado correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio un error inesperado');
            }
            json($arrResponse);
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
    public function estadoBlog()
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
            $request = $this->model->updateEstadoBlog($id, $estado);
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

    public function deleteCategoria()
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
            $request = $this->model->verificarRegVinculadosBlog($id);
            if ($request) {
                $arrResponse = array('status' => false, 'msg' => 'Este categoría tiene blogs registrados');
                json($arrResponse);
                die();
            }
            if (is_file(path_upload() . 'images/' . $file)) {
                unlink(path_upload()  . 'images/' . $file);
            }
            $request = $this->model->deleteCategoria($id);
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
    public function deleteBlog()
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
            $request = $this->model->deleteBlog($id);
            if ($request) {
                $arrResponse = array('status' => true, 'msg' => 'Datos eliminados correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Ocurrio problemas al eliminar los datos');
            }
            json($arrResponse);
        }
    }

    public function editCategoria()
    {

        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $name = strClean($_POST["txtNombCat"]);
            $descripcion = strClean($_POST["txtDescCat"]);
            $id = intval($_POST['id_Catupd']);
            if ($id == "" || $name == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }

            $existingCategoria = $this->model->getCategoriaByName($name);
            if (!empty($existingCategoria)) {
                if ($existingCategoria["idCategoria"] != $id && $existingCategoria) {
                    $arrResponse = array('status' => false, 'msg' => 'Ya existe una categoría con este nombre');
                    json($arrResponse);
                    die();
                }
            }

            $request = $this->model->editCategoria($name, $descripcion, $id);
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
    public function editFileCategoria()
    {
        if ($_SESSION['permisosMod']['w']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $id = intval(strClean($_POST["ip_updFil"]));
            $file = $_FILES["ImgArchivo"]["name"];
            $idPersona = $_SESSION['idUser'];
            $arrSize = getimagesize($_FILES["ImgArchivo"]["tmp_name"]);
            // if ($arrSize[0] < 2046 || $arrSize[0] > 2059) {
            //     $arrResponse = array('status' => false, 'msg' => 'El ancho de la imagen no cumple con el rango permitido [2046 - 2059]px, Medida Actual : ' . $arrSize[0] . "px");
            //     json($arrResponse);
            //     die();
            // }
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
            
            if (!esImagenValida($_FILES["ImgArchivo"]["tmp_name"])) {
                $arrResponse = array('status' => false, 'msg' => 'El archivo no es una imagen válida.');
                json($arrResponse);
                die();
            }
            
            $request_moveFile = move_uploaded_file($_FILES["ImgArchivo"]["tmp_name"], $urlFile);
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
            $request = $this->model->editFileCategoria($id, $file);

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
    public function editarInfoBlog()
    {

        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $titulo = strClean($_POST["editTitulo"]);
            $subtitulo = strClean($_POST["editSubtitulo"]);
            $contenido = strClean($_POST["editContenido"]);
            $id = intval($_POST["id_upd"]);
            if ($id == "" || $titulo == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }
            //validar campo título
            $request = $this->model->editarInfoBlog($titulo, $subtitulo, $contenido, $id);
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
    public function editarImgBlog()
    {
        if ($_SESSION['permisosMod']['w']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $id = intval(strClean($_POST["id_updImg"]));
            $file = $_FILES["editImg"]["name"];
            $descripcion = strClean($_POST["editDescImg"]);
            $idPersona = $_SESSION['idUser'];
            // $arrSize = getimagesize($_FILES["editImg"]["tmp_name"]);
            // if ($arrSize[0] < 2046 || $arrSize[0] > 2059) {
            //     $arrResponse = array('status' => false, 'msg' => 'El ancho de la imagen no cumple con el rango permitido [2046 - 2059]px, Medida Actual : ' . $arrSize[0] . "px");
            //     json($arrResponse);
            //     die();
            // }
            $fileOld = strClean($_POST["photoOld_updFil"]);
            if ($id == "" || $fileOld == "") {
                $arrResponse = array('status' => false, 'msg' => 'Complete los campos obligatorios');
                json($arrResponse);
                die();
            }

            $datetime = date("YmdHis");
            $file = $datetime . $idPersona . $file;
            $ruta = path_upload() . "images/";
            $urlFile = $ruta . $file;
            verifyFolder($ruta);
            if (!empty($_FILES["editImg"]["tmp_name"])) {
                if (!esImagenValida($_FILES["editImg"]["tmp_name"])) {
                    $arrResponse = array('status' => false, 'msg' => 'El archivo no es una imagen válida.');
                    json($arrResponse);
                    die();
                }
                $request_moveFile = move_uploaded_file($_FILES["editImg"]["tmp_name"], $urlFile);
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
                $file = $file;
            } else {
                $file = $fileOld;
            }
            $request = $this->model->editarImgBlog($id, $file, $descripcion);

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
    public function editarEmbedBlog()
    {
        if ($_SESSION['permisosMod']['u']) {
            if (!$_POST) {
                $arrResponse = array('status' => false, 'msg' => 'Metodo no encontrado');
                json($arrResponse);
                die();
            }
            $embed = strClean($_POST["link"]);
            $id = intval($_POST["id_updEmbed"]);
            if ($id == "") {
                $arrResponse = array('status' => false, 'msg' => 'Llene los campos obligatorios');
                json($arrResponse);
                die();
            }

            // Verifica si el enlace es igual a la URL de la página
            if (strpos($embed, 'http://localhost/portal/blog/blog/') === 0) {
                $embed = '';
            }

            $request = $this->model->editarEmbedBlog($embed, $id);
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
}
