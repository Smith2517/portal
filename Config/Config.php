<?php

// Función simple para cargar variables de entorno
function loadEnv($path) {
    if (!file_exists($path)) return;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            putenv(sprintf('%s=%s', $name, $value));
        }
    }
}
loadEnv(dirname(__DIR__) . '/.env');

// Detectar automáticamente la BASE_URL
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$script_name = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$script_name = rtrim($script_name, '/'); // Eliminar trailing slash si existe
define("BASE_URL", $protocol . "://" . $host . $script_name);

// const BASE_URL = "https://web.epsrioja.com.pe/portal";

//Zona horaria
date_default_timezone_set('America/Lima');

//Datos de conexión a Base de Datos
define("DB_HOST", getenv('DB_HOST') !== false ? getenv('DB_HOST') : "localhost");
define("DB_NAME", getenv('DB_NAME') !== false ? getenv('DB_NAME') : "portal");
define("DB_USER", getenv('DB_USER') !== false ? getenv('DB_USER') : "root");
define("DB_PASSWORD", getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : "");
define("DB_CHARSET", getenv('DB_CHARSET') !== false ? getenv('DB_CHARSET') : "utf8mb4");
define("DB_PORT", getenv('DB_PORT') !== false ? getenv('DB_PORT') : 3306);

//Deliminadores decimal y millar Ej. 24,1989.00
const SPD = ".";
const SPM = ",";

//Simbolo de moneda
const SMONEY = "S/.";

//Datos envio de correo
const NOMBRE_REMITENTE = "EPS-RIOJA";
const EMAIL_REMITENTE = "no-reply@abelosh.com";
const NOMBRE_EMPESA = "PANEL-EPS-RIOJA";
const WEB_EMPRESA = "www.abelosh.com";

//Datos de la pagina web

const PW_NAME = "Empresa Prestadora de Servicios Rioja S.A.";
const PW_ABREV = "EPSRIOJA";

//directorios de subida de archivos
const PATH_UPLOAD = "./Assets/upload/";
//nombre de la session
const OPTION_SESIONCPANEL = array('name' => 'CPANELMDESV');

//Variables de encriptacion
const METHOD = "AES-256-CBC";
const SECRET_KEY = "MDESV2023..@";
const SECRET_IV = "PAGEWEB2023MDESVOIE..";

//Version 
define("VER_MEDIA", "1.0.0.3");
