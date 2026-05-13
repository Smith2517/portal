<?php
class Administradorfile extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
        getPermisos(9);
    }

    public function administradorfile($params)
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
            die();
        }
        $data['page_id'] = 9;
        $data['page_tag'] =  "Administrador de Archivos - MDESV";
        $data['page_title'] = "Administrador de Archivos - MDESV";
        $data['page_name'] = "Administrador de Archivos";
        $data['page_functions_js'] = "functions_administradorfile.js";
        $data['page_contenidoFile'] = self::listarContenidoCarpeta();
        $this->views->getView($this, "administradorfile", $data);
    }
    public function listarContenidoCarpeta()
    {
        // Ruta de la carpeta que quieres listar
        $ruta_carpeta = path_upload() . 'files';

        // Obtener el contenido de la carpeta
        $contenido_carpeta = scandir($ruta_carpeta);
        $output = '<div class="row justify-content-center">';

        // Definir un array asociativo de extensiones de archivo y sus correspondientes iconos FontAwesome y colores
        $tipos_archivo = [
            'jpg' => ['fa-file-image', 'text-primary'],
            'png' => ['fa-file-image', 'text-primary'],
            'gif' => ['fa-file-image', 'text-primary'],
            'pdf' => ['fa-file-pdf', 'text-danger'],
            'doc' => ['fa-file-word', 'text-success'],
            'docx' => ['fa-file-word', 'text-success'],
            'xls' => ['fa-file-excel', 'text-success'],
            'xlsx' => ['fa-file-excel', 'text-success'],
            // Agrega más extensiones y sus iconos y colores según sea necesario
        ];
        //Variables de los botones
        $btnView = '';
        $btnEdit = '';
        $btnDelete = '';

        // Variable de control para verificar si se encontraron archivos
        $archivosEncontrados = false;

        // Iterar a través del contenido de la carpeta y mostrarlo
        foreach ($contenido_carpeta as $archivo) {
            // Excluir los directorios "." y ".."
            if ($archivo != '.' && $archivo != '..') {
                $archivosEncontrados = true; // Se ha encontrado al menos un archivo
                // Obtener la extensión del archivo
                $extension = pathinfo($archivo, PATHINFO_EXTENSION);

                // Determinar el icono FontAwesome y el color del texto según la extensión del archivo
                $icono_color = isset($tipos_archivo[$extension]) ? $tipos_archivo[$extension] : ['fa-file', 'text-secondary'];

                // Mostrar el nombre del archivo o carpeta junto con el icono y el color correspondiente
                $output .= '<div class="col-6 col-md-3 p-2">
                <div class="card custom-card text-center">
                <i class="fa ' . $icono_color[0] . ' fa-4x ' . $icono_color[1] . '"></i>
                <div class="card-body">
                  <h5 class="card-title">' . $archivo . '</h5>
                  <p class="card-text"></p>';
                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-primary openDetail" data-nombre="' . $archivo . '" data-extension="' . explode(".", $archivo)[1] . '"><i class="fa fa-eye"></i></button>';
                };
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btnDel" data-file="' . $archivo . '"><i class="fa fa-trash"></i></button>';
                }
                $output .= $btnView . " " . $btnEdit . " " . $btnDelete . ' 
                </div>
              </div> </div>';
            }
        }

        // Verificar si no se encontraron archivos y mostrar un mensaje en ese caso
        if (!$archivosEncontrados) {
            $output .= '<div class="col-12 text-center empty-directory-message my-5 py-5 animated fadeIn">
                          <i class="fa fa-frown-o fa-2x mb-3"></i>
                          <p class="h2">¡Oops!</p>
                          <p class="lead">El directorio se encuentra vacío.</p>
                        </div>';
        }

        $output .= '</div>';
        return $output;
    }

    public function uploadFiles()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener el nombre personalizado del archivo (si se ha proporcionado)
            $nombre_personalizado = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
            // Verificar si se han producido errores durante la subida del archivo
            if ($_FILES["archivo"]["error"] > 0) {
                $arrResponse = array('status' => false, 'msg' => 'Error: ' . $_FILES["archivo"]["error"]);
                json($arrResponse);
                die();
            } else {
                // Directorio donde se almacenarán los archivos subidos
                $directorio_destino = path_upload() . 'files/';
                // Obtener el nombre original del archivo y su extensión
                $nombre_archivo_original = $_FILES["archivo"]["name"];
                $extension_archivo = pathinfo($nombre_archivo_original, PATHINFO_EXTENSION);

                // Crear el nombre final del archivo (usando el nombre personalizado si se proporcionó, manteniendo la extensión original)
                $nombre_archivo_final = !empty($nombre_personalizado) ? $nombre_personalizado : pathinfo($nombre_archivo_original, PATHINFO_FILENAME);
                $nombre_archivo_final .= '.' . $extension_archivo;
                $ruta_archivo = $directorio_destino . $nombre_archivo_final;
                if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $ruta_archivo)) {
                    $arrResponse = array('status' => true, 'msg' => "El archivo ha sido subido correctamente con el nombre: " . $nombre_archivo_final);
                    json($arrResponse);
                    die();
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Hubo un error al subir el archivo.');
                    json($arrResponse);
                    die();
                }
            }
        } else {
            $arrResponse = array('status' => false, 'msg' => 'Acceso no permitido.');
            json($arrResponse);
            die();
        }
    }
    public function eliminarArchivo()
    {
        $rutaArchivo = path_upload() . "files/" . $_POST["file"];
        if (file_exists($rutaArchivo)) {
            if (unlink($rutaArchivo)) {
                $arrResponse = array('status' => true, 'msg' => 'El archivo ha sido eliminado correctamente.');
                json($arrResponse);
                die();
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se pudo eliminar el archivo. Por favor, verifica los permisos.');
                json($arrResponse);
                die();
            }
        } else {
            $arrResponse = array('status' => false, 'msg' => 'El archivo no existe.');
            json($arrResponse);
            die();
        }
    }
}
