<?php
//Devuelve el nombre de la empresa
function namecompay()
{
    return NOMBRE_EMPESA;
}
function getVersion()
{
    return VER_MEDIA;
}
function nameWeb()
{
    return PW_NAME;
}
//Retorla la url del proyecto
function base_url()
{
    return BASE_URL;
}
//path upload
function path_upload()
{
    return PATH_UPLOAD;
}
//Configuracion de inicio de sesion
function name_sesion()
{
    return OPTION_SESIONCPANEL;
}


// Validación NORMAL (vistas)
function isLogin()
{
    if (empty($_SESSION['login'])) {
        header('Location: ' . base_url() . '/login');
        exit;
    }
}

// Validación AJAX (JSON seguro)
function isLoginAjax()
{
    if (empty($_SESSION['login'])) {
        echo json_encode([
            'status'  => false,
            'session' => 'expired',
            'msg'     => 'Tu sesión ha expirado'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}


//funcion que valida si existe el inicion
function exist_login()
{
    if (isset($_SESSION['login'])) {
        header('Location: ' . base_url() . '/dashboard');
    }
}
//Retorla la url de Assets
function media()
{
    return BASE_URL . "/Assets";
}
function headerAdmin($data = "")
{
    $view_header = "Views/Template/Panel/header_admin.php";
    require_once($view_header);
}
function headerWeb($data = "")
{
    $view_header = "Views/Template/Web/header_web.php";
    require_once($view_header);
}
function footerAdmin($data = "")
{
    $view_footer = "Views/Template/Panel/footer_admin.php";
    require_once($view_footer);
}
function footerWeb($data = "")
{
    $view_footer = "Views/Template/Web/footer_web.php";
    require_once($view_footer);
}
//Muestra información formateada
function dep($data)
{
    $format = print_r('<pre>');
    $format .= print_r($data);
    $format .= print_r('</pre>');
    return $format;
}
function getModal(string $nameModal, $data)
{
    $view_modal = "Views/Template/Modals/{$nameModal}.php";
    require_once $view_modal;
}
//Envio de correos
function sendEmail($data, $template)
{
    $asunto = $data['asunto'];
    $emailDestino = $data['email'];
    $empresa = NOMBRE_REMITENTE;
    $remitente = EMAIL_REMITENTE;
    //ENVIO DE CORREO
    $de = "MIME-Version: 1.0\r\n";
    $de .= "Content-type: text/html; charset=UTF-8\r\n";
    $de .= "From: {$empresa} <{$remitente}>\r\n";
    ob_start();
    require_once("Views/Template/Email/" . $template . ".php");
    $mensaje = ob_get_clean();
    $send = mail($emailDestino, $asunto, $mensaje, $de);
    return $send;
}

function getPermisos(int $idmodulo)
{
    require_once("Models/PermisosModel.php");
    $objPermisos = new PermisosModel();
    $idrol = $_SESSION['userData']['idrol'];
    $arrPermisos = $objPermisos->permisosModulo($idrol);
    $permisos = '';
    $permisosMod = '';
    if (count($arrPermisos) > 0) {
        $permisos = $arrPermisos;
        $permisosMod = isset($arrPermisos[$idmodulo]) ? $arrPermisos[$idmodulo] : "";
    }
    $_SESSION['permisos'] = $permisos;
    $_SESSION['permisosMod'] = $permisosMod;
}

function sessionUser(int $idpersona)
{
    require_once("Models/LoginModel.php");
    $objLogin = new LoginModel();
    $request = $objLogin->sessionLogin($idpersona);
    return $request;
}
function normasmunicipales(): array
{
    require_once("Models/PageModel.php");
    $objLogin = new PageModel();
    $request = $objLogin->selectNormasMunicipales();
    return $request;
}
function categorias(): array
{
    require_once("Models/BlogModel.php");
    $objLogin = new BlogModel();
    $request = $objLogin->selectcategoria();
    return $request;
}
function getAvisos()
{
    require_once("Models/ModalModel.php");
    $objAviso = new PageModel();
    $request = $objAviso->getAvisos();
    return $request;
}
//Elimina exceso de espacios entre palabras
function strClean($strCadena)
{
    $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
    $string = trim($string); //Elimina espacios en blanco al inicio y al final
    $string = stripslashes($string); // Elimina las \ invertidas
    $string = str_ireplace("<script>", "", $string);
    $string = str_ireplace("</script>", "", $string);
    $string = str_ireplace("<script src>", "", $string);
    $string = str_ireplace("<script type=>", "", $string);
    $string = str_ireplace("SELECT * FROM", "", $string);
    $string = str_ireplace("DELETE FROM", "", $string);
    $string = str_ireplace("INSERT INTO", "", $string);
    $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
    $string = str_ireplace("DROP TABLE", "", $string);
    $string = str_ireplace("OR '1'='1", "", $string);
    $string = str_ireplace('OR "1"="1"', "", $string);
    $string = str_ireplace('OR ´1´=´1´', "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("LIKE '", "", $string);
    $string = str_ireplace('LIKE "', "", $string);
    $string = str_ireplace("LIKE ´", "", $string);
    $string = str_ireplace("OR 'a'='a", "", $string);
    $string = str_ireplace('OR "a"="a', "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("--", "", $string);
    $string = str_ireplace("^", "", $string);
    $string = str_ireplace("[", "", $string);
    $string = str_ireplace("]", "", $string);
    $string = str_ireplace("==", "", $string);
    return $string;
}
//Genera una contraseña de 10 caracteres
function passGenerator($length = 10)
{
    $pass = "";
    $longitudPass = $length;
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $longitudCadena = strlen($cadena);

    for ($i = 1; $i <= $longitudPass; $i++) {
        $pos = rand(0, $longitudCadena - 1);
        $pass .= substr($cadena, $pos, 1);
    }
    return $pass;
}
//Genera un token
function token()
{
    $r1 = bin2hex(random_bytes(10));
    $r2 = bin2hex(random_bytes(10));
    $r3 = bin2hex(random_bytes(10));
    $r4 = bin2hex(random_bytes(10));
    $token = $r1 . '-' . $r2 . '-' . $r3 . '-' . $r4;
    return $token;
}
//Formato para valores monetarios
function formatMoney($cantidad)
{
    $cantidad = number_format($cantidad, 2, SPD, SPM);
    return $cantidad;
}

//formate json
function json(array $arrData)
{
    // echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
}
//Funcion que valida la creacion de rutas
function verifyFolder(string $ruta)
{
    if (!file_exists($ruta)) {
        mkdir($ruta, 0777, true);
        return false;
    } else {
        return true;
    }
}
/**Encriptar texto plano ah hash*/
function encryption($string)
{
    $output = FALSE;
    $key = hash('sha256', SECRET_KEY);
    $iv = substr(hash('sha256', SECRET_IV), 0, 16);
    $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
    $output = base64_encode($output);
    return $output;
}
/**Desencripta de hash a texto plano */
function decryption($string): string
{
    $key = hash('sha256', SECRET_KEY);
    $iv = substr(hash('sha256', SECRET_IV), 0, 16);
    $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
    return $output;
}

function limitar_cadena($value, $limit = 100, $end = '...')
{
    if (mb_strwidth($value, 'UTF-8') <= $limit) {
        return $value;
    }
    return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')) . $end;
}

function getDaysTranscurridos($fechaactual,  $fecharegistro)
{
    $fechaActual = $fechaactual;
    $fechaRegistro = $fecharegistro;
    $segundosFechaActual = strtotime($fechaActual);
    $segundosFechaRegistro = strtotime($fechaRegistro);
    $segundosTranscurridos = $segundosFechaActual - $segundosFechaRegistro;
    $diasTranscurridos = $segundosTranscurridos / 86400;
    return $diasTranscurridos;
}
function getCarousel(): array
{
    require_once("Models/PageModel.php");
    $objLogin = new PageModel();
    $request = $objLogin->selectCarouselActive();
    return $request;
}
function optionActivo(int $idComparacion, int $idEstatica)
{
    if ($idComparacion == $idEstatica) {
        return "active";
    }
}
function isExapded(int $idComparacion, int $idEstatica)
{
    if ($idComparacion == $idEstatica) {
        return "is-expanded";
    }
}
function optFuncionario()
{
    require_once("Models/PageModel.php");
    $objLogin = new PageModel();
    $request = $objLogin->selectGrupoFuncionario();
    return $request;
}

function optIntegrantesSci()
{
    require_once("Models/PageModel.php");
    $objLogin = new PageModel();
    $request = $objLogin->selectIntegrantesSciActivos();
    return $request;
}

function optMarconormativo()
{
    require_once("Models/PageModel.php");
    $objLogin = new PageModel();
    $request = $objLogin->selectMarconormativoActivos();
    return $request;
}

function optGobiernocorporativo()
{
    require_once("Models/PageModel.php");
    $objLogin = new PageModel();
    $request = $objLogin->selectGobiernoCorporativoActivos();
    return $request;
}

function optImplementacionsci()
{
    require_once("Models/PageModel.php");
    $objLogin = new PageModel();
    $request = $objLogin->selectImplementacionsciActivos();
    return $request;
}

function optMaterialdidactico()
{
    require_once("Models/PageModel.php");
    $objLogin = new PageModel();
    $request = $objLogin->selectMaterialdidacticoActivos();
    return $request;
}

function optVideosdidacticos()
{
    require_once("Models/PageModel.php");
    $objLogin = new PageModel();
    $request = $objLogin->selectVideosdidacticosActivos();
    return $request;
}

function optPackanticorrupcion()
{
    require_once("Models/PageModel.php");
    $objLogin = new PageModel();
    $request = $objLogin->selectPackanticorrupcionActivos();
    return $request;
}

function webBarras(int $id, string $orderSection = "ASC", string $orderItems = "ASC")
{
    $id = intval(strClean($id));
    $orderSection = strClean($orderSection);
    $orderItems = strClean($orderItems);
    require_once("Models/PageModel.php");
    $obj = new PageModel();
    $request = $obj->selectBarras($id, $orderSection, $orderItems);
    
    // Interceptar y reemplazar dinámicamente el dominio de producción
    $prod_urls = [
        'https://web.epsrioja.com.pe/portal',
        'http://web.epsrioja.com.pe/portal'
    ];
    if ($request && isset($request['sections'])) {
        foreach ($request['sections'] as &$section) {
            if (isset($section['sbn_url'])) {
                $section['sbn_url'] = str_replace($prod_urls, base_url(), $section['sbn_url']);
            }
            if (isset($section['items'])) {
                foreach ($section['items'] as &$item) {
                    if (isset($item['is_link'])) {
                        $item['is_link'] = str_replace($prod_urls, base_url(), $item['is_link']);
                    }
                }
            }
        }
    }
    
    return $request;
}
function notFound()
{
    require_once("Controllers/Error.php");
}

/**
 * Redimensiona una imagen y la guarda en la ruta especificada
 * @param string $tmp_name Ruta temporal de la imagen original
 * @param string $destination Ruta donde se guardará la imagen redimensionada
 * @param int $width Ancho deseado en píxeles
 * @param int $height Alto deseado en píxeles
 * @return bool true si se completó correctamente, false en caso contrario
 */
function resizeImage($tmp_name, $destination, $width, $height)
{
    // Obtener información de la imagen original
    $imageInfo = getimagesize($tmp_name);
    if ($imageInfo === false) {
        return false;
    }
    
    $imageType = $imageInfo[2];
    $originalWidth = $imageInfo[0];
    $originalHeight = $imageInfo[1];
    
    // Crear imagen desde el origen según el tipo
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($tmp_name);
            break;
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($tmp_name);
            break;
        case IMAGETYPE_GIF:
            $sourceImage = imagecreatefromgif($tmp_name);
            break;
        default:
            return false;
    }
    
    if (!$sourceImage) {
        return false;
    }
    
    // Crear una nueva imagen con las dimensiones deseadas
    $resizedImage = imagecreatetruecolor($width, $height);
    
    // Rellenar con fondo blanco (para evitar bordes negros en PNG/GIF)
    $white = imagecolorallocate($resizedImage, 255, 255, 255);
    imagefill($resizedImage, 0, 0, $white);
    
    // Redimensionar la imagen
    imagecopyresampled(
        $resizedImage,
        $sourceImage,
        0,
        0,
        0,
        0,
        $width,
        $height,
        $originalWidth,
        $originalHeight
    );
    
    // Guardar la imagen redimensionada (siempre como JPEG)
    $result = imagejpeg($resizedImage, $destination, 90);
    
    // Liberar memoria
    imagedestroy($sourceImage);
    imagedestroy($resizedImage);
    
    return $result;
}

/**
 * Valida que el archivo subido sea realmente una imagen según su tipo MIME real.
 */
function esImagenValida($tmp_name) {
    if (!file_exists($tmp_name)) {
        return false;
    }
    $mime_types_permitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($fileInfo, $tmp_name);
    finfo_close($fileInfo);

    return in_array($mime_type, $mime_types_permitidos);
}
