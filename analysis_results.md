# 🔍 Análisis Completo del Sistema Portal — EPS Rioja

Análisis realizado sobre la totalidad del código fuente en `c:\xampp\htdocs\portal`.

---

## Resumen Ejecutivo

| Categoría | Críticos | Altos | Medios | Bajos |
|---|---|---|---|---|
| 🔴 Seguridad | 6 | 3 | 2 | — |
| 🟠 Arquitectura | — | 4 | 3 | 2 |
| 🟡 Rendimiento | — | 1 | 3 | 1 |
| 🔵 Mantenibilidad | — | 2 | 4 | 3 |
| 🟢 Buenas Prácticas | — | 1 | 3 | 2 |

---

## 🔴 1. SEGURIDAD (Prioridad Máxima)

### 1.1 🚨 CRÍTICO — Inyección SQL en múltiples modelos

La mayoría de las consultas `SELECT` y `DELETE` concatenan variables directamente en el SQL **sin usar parámetros preparados**.

**Archivos afectados:**
- [LoginModel.php](file:///c:/xampp/htdocs/portal/Models/LoginModel.php#L18-L21) — `loginUser()` concatena email y password
- [LoginModel.php](file:///c:/xampp/htdocs/portal/Models/LoginModel.php#L52-L54) — `getUserEmail()`
- [LoginModel.php](file:///c:/xampp/htdocs/portal/Models/LoginModel.php#L71-L74) — `getUsuario()`
- [UsuariosModel.php](file:///c:/xampp/htdocs/portal/Models/UsuariosModel.php#L73-L77) — `selectUsuario()`
- [UsuariosModel.php](file:///c:/xampp/htdocs/portal/Models/UsuariosModel.php#L153) — `deleteUsuario()` — DELETE con interpolación directa
- [UsuariosModel.php](file:///c:/xampp/htdocs/portal/Models/UsuariosModel.php#L214) — `selectUsuarioDNI()`
- [UsuariosModel.php](file:///c:/xampp/htdocs/portal/Models/UsuariosModel.php#L221) — `selectUsuarioEmail()`
- [BlogModel.php](file:///c:/xampp/htdocs/portal/Models/BlogModel.php#L33-L36) — `selectBlogs()`
- [BlogModel.php](file:///c:/xampp/htdocs/portal/Models/BlogModel.php#L93) — `deleteCategoria()`
- [BlogModel.php](file:///c:/xampp/htdocs/portal/Models/BlogModel.php#L100) — `deleteBlog()`
- [PermisosModel.php](file:///c:/xampp/htdocs/portal/Models/PermisosModel.php#L27) — `selectPermisosRol()`
- [PermisosModel.php](file:///c:/xampp/htdocs/portal/Models/PermisosModel.php#L35) — `deletePermisos()`

**Ejemplo del problema** (LoginModel.php, línea 18-21):
```php
// ❌ VULNERABLE a SQL Injection
$sql = "SELECT idpersona,status FROM persona WHERE 
        email_user = '{$this->strUsuario}' and 
        password = '{$this->strPassword}' and 
        status != 0 ";
$request = $this->select($sql);
```

**Solución propuesta:**
```php
// ✅ Usar parámetros preparados
$sql = "SELECT idpersona,status FROM persona WHERE 
        email_user = ? AND password = ? AND status != 0";
$request = $this->selectOne($sql, [$this->strUsuario, $this->strPassword]);
```

> [!CAUTION]
> Esta vulnerabilidad permite a un atacante acceder, modificar o eliminar toda la base de datos. Es la amenaza más crítica del sistema. Los métodos `select()`, `select_all()` y `delete()` en [Mysql.php](file:///c:/xampp/htdocs/portal/Libraries/Core/Mysql.php#L31-L73) **no aceptan parámetros**, forzando la concatenación.

---

### 1.2 🚨 CRÍTICO — Capa de base de datos insegura por diseño

La clase [Mysql.php](file:///c:/xampp/htdocs/portal/Libraries/Core/Mysql.php) tiene métodos `select()`, `select_all()` y `delete()` que **no aceptan arrays de parámetros**, lo que obliga a concatenar valores en las consultas SQL.

```php
// ❌ Solo acepta string, sin parámetros
public function select(string $query) { ... }
public function select_all(string $query) { ... }
public function delete(string $query) { ... }
```

**Solución:** Agregar un segundo parámetro `array $arrValues = []` a estos métodos y ejecutar con `$result->execute($arrValues)`.

---

### 1.3 🚨 CRÍTICO — Esquema de contraseñas débil e inconsistente

El sistema usa **tres métodos distintos** para hash de contraseñas:

| Ubicación | Método | Problema |
|---|---|---|
| [Login.php:37](file:///c:/xampp/htdocs/portal/Controllers/Login.php#L37) | `encryption()` (AES-256-CBC) | Encriptación reversible, NO es hash |
| [Login.php:170](file:///c:/xampp/htdocs/portal/Controllers/Login.php#L170) | `hash("SHA256", ...)` | Sin salt, vulnerable a rainbow tables |
| [Usuarios.php:264](file:///c:/xampp/htdocs/portal/Controllers/Usuarios.php#L264) | `hash("SHA256", ...)` | Inconsistente con el login |

> [!WARNING]
> - `encryption()` usa AES-256-CBC que es **reversible** — las contraseñas se pueden descifrar si se obtiene la key
> - SHA256 sin salt es vulnerable a ataques de diccionario y rainbow tables
> - El login usa `encryption()` pero el cambio de contraseña usa `SHA256` — **las contraseñas no coincidirán**

**Solución:** Usar `password_hash()` y `password_verify()` de PHP en todo el sistema.

---

### 1.4 🚨 CRÍTICO — Claves de encriptación hardcodeadas y débiles

En [Config.php](file:///c:/xampp/htdocs/portal/Config/Config.php#L41-L43):

```php
const METHOD = "AES-256-CBC";
const SECRET_KEY = "MDESV2023..@";          // Clave débil y expuesta
const SECRET_IV = "PAGEWEB2023MDESVOIE..";  // IV estático (debe ser único por operación)
```

> [!CAUTION]
> - Las claves están en el código fuente (si el repo es público, están expuestas)
> - El IV es **estático** — debe ser único y aleatorio por cada operación de cifrado
> - La clave es demasiado corta y predecible

---

### 1.5 🚨 CRÍTICO — Credenciales de BD expuestas

En [Config.php](file:///c:/xampp/htdocs/portal/Config/Config.php#L10-L15):

```php
const DB_HOST = "localhost";
const DB_NAME = "portal";
const DB_USER = "root";
const DB_PASSWORD = "";    // Sin contraseña
```

**Solución:** Usar variables de entorno (`.env`) y nunca versionar credenciales.

---

### 1.6 🚨 CRÍTICO — Sanitización XSS ineficaz

La función [strClean()](file:///c:/xampp/htdocs/portal/Helpers/Helpers.php#L163-L195) intenta prevenir XSS e inyección SQL mediante **listas negras manuales** — un enfoque fundamentalmente roto:

```php
$string = str_ireplace("<script>", "", $string);
$string = str_ireplace("SELECT * FROM", "", $string);
$string = str_ireplace("DROP TABLE", "", $string);
// ... muchas más reglas que se pueden evadir fácilmente
```

**Problemas:**
- Se puede evadir con `<scr<script>ipt>` (tras remover el interior queda `<script>`)
- No cubre `<img onerror=...>`, `<svg onload=...>`, ni miles de vectores XSS
- No es un sustituto de consultas parametrizadas
- Elimina `--`, `[`, `]`, `^`, `==` que podrían ser caracteres legítimos en contenido

**Solución:** Usar `htmlspecialchars()` al renderizar y consultas preparadas para la BD.

---

### 1.7 ⚠️ ALTO — CORS completamente abierto

En [.htaccess](file:///c:/xampp/htdocs/portal/.htaccess#L8-L10):

```apache
Header set Access-Control-Allow-Origin "*"
```

Permite que **cualquier dominio** haga peticiones al backend. Debería restringirse al dominio propio.

---

### 1.8 ⚠️ ALTO — Sin protección CSRF

Ningún formulario ni petición AJAX incluye tokens CSRF. Un atacante podría crear una página que envíe formularios a nombre del usuario autenticado.

---

### 1.9 ⚠️ ALTO — Exposición de errores en producción

En [Login.php:64](file:///c:/xampp/htdocs/portal/Controllers/Login.php#L64):
```php
error_reporting(0);  // Silencia errores en vez de manejarlos
```

En [Conexion.php:13](file:///c:/xampp/htdocs/portal/Libraries/Core/Conexion.php#L13):
```php
echo "ERROR: " . $e->getMessage();  // Expone detalles internos al usuario
```

---

### 1.10 ⚠️ MEDIO — Archivos subidos sin validación robusta

Los controladores como [Blog.php](file:///c:/xampp/htdocs/portal/Controllers/Blog.php#L131-L135) mueven archivos sin validar:
- Tipo MIME real (solo nombre)
- Tamaño máximo
- Extensiones peligrosas (.php, .phtml, etc.)

**Riesgo:** Subida de shells PHP que permiten ejecución remota de código.

---

### 1.11 ⚠️ MEDIO — Permisos de directorio excesivos

En [Helpers.php:237](file:///c:/xampp/htdocs/portal/Helpers/Helpers.php#L237):
```php
mkdir($ruta, 0777, true);  // Permisos de lectura/escritura/ejecución para todos
```

**Solución:** Usar `0755` para directorios y `0644` para archivos.

---

## 🟠 2. ARQUITECTURA

### 2.1 ⚠️ ALTO — Framework MVC artesanal sin namespaces ni autoload PSR-4

El sistema implementa un MVC artesanal en [Libraries/Core/](file:///c:/xampp/htdocs/portal/Libraries/Core). Sin Composer, sin namespaces, sin estándar PSR-4.

**Consecuencias:**
- No se pueden usar librerías de terceros modernas (PHPMailer, Monolog, etc.)
- Colisiones de nombres probables al crecer el proyecto
- `require_once` manual en decenas de lugares

---

### 2.2 ⚠️ ALTO — Router primitivo e inseguro

El [index.php](file:///c:/xampp/htdocs/portal/index.php#L5-L30) usa un router basado en la URL con mínima validación:

```php
$url = !empty($_GET['url']) ? $_GET['url'] : 'home/home';
$arrUrl = explode("/", $url);
$controller = $arrUrl[0];
```

**Problemas:**
- No hay lista blanca de controladores permitidos
- Un atacante podría intentar cargar archivos arbitrarios
- No hay separación de rutas públicas vs. autenticadas a nivel de router
- El parámetro `$method = $arrUrl[0]` (línea 8) es un bug: inicializa method = controller

---

### 2.3 ⚠️ ALTO — Clase Mysql hereda de Conexion pero también la instancia

En [Mysql.php](file:///c:/xampp/htdocs/portal/Libraries/Core/Mysql.php#L3-L12):
```php
class Mysql extends Conexion  // Hereda
{
    function __construct() {
        $this->conexion = new Conexion();  // Y también instancia (?!)
        $this->conexion = $this->conexion->conect();
    }
}
```

Mysql hereda de Conexion pero nunca llama a `parent::__construct()`. En cambio, crea una nueva instancia. Esto rompe la herencia y crea confusión.

---

### 2.4 ⚠️ ALTO — HTML generado dentro de controladores

Los controladores generan HTML directamente para los botones de acción de las tablas. Ejemplo en [Usuarios.php:160-205](file:///c:/xampp/htdocs/portal/Controllers/Usuarios.php#L160-L205):

```php
$btnView = '<button class="btn btn-info btn-sm btnView" ...>';
$btnEdit = '<button class="btn btn-primary btn-sm btnEdit" ...>';
```

**Esto viola la separación de responsabilidades del patrón MVC.** El controlador no debería generar vistas.

---

### 2.5 ⚠️ MEDIO — Sin capa de servicios ni validación centralizada

Toda la lógica de negocio está en los controladores. Cada acción CRUD repite el mismo patrón de validación:

```php
if (!$_POST) { ... die(); }
if (empty($_POST['campo1']) || ...) { ... die(); }
$campo = strClean($_POST['campo']);
```

Este patrón se repite **más de 30 veces** a lo largo de los controladores.

---

### 2.6 ⚠️ MEDIO — Sesiones sin configuración de seguridad

En [index.php:2](file:///c:/xampp/htdocs/portal/index.php#L2):
```php
session_start();
```

Falta configurar:
- `session.cookie_httponly = true` (previene robo de cookies vía JS)
- `session.cookie_secure = true` (solo HTTPS)
- `session.use_strict_mode = true`
- Regeneración de ID de sesión tras login

---

### 2.7 ⚠️ MEDIO — Helpers con funciones sueltas y acoplamiento alto

[Helpers.php](file:///c:/xampp/htdocs/portal/Helpers/Helpers.php) es un archivo de 447 líneas con funciones globales que:
- Instancian modelos directamente (`new PageModel()`, `new PermisosModel()`)
- Acceden a `$_SESSION` directamente
- Mezclan lógica de negocio con utilidades

---

### 2.8 BAJO — Múltiples versiones de jQuery incluidas

Existen [jquery-3.3.1.min.js](file:///c:/xampp/htdocs/portal/Assets/js/jquery-3.3.1.min.js) y [jquery-3.7.0.min.js](file:///c:/xampp/htdocs/portal/Assets/js/jquery-3.7.0.min.js). Debería usarse solo una versión (la más reciente).

---

### 2.9 BAJO — CDNs externos sin integridad (SRI)

En [footer_admin.php](file:///c:/xampp/htdocs/portal/Views/Template/Panel/footer_admin.php#L20-L23) se cargan scripts de CDN sin atributo `integrity`:

```html
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
```

Si el CDN se compromete, el atacante podría inyectar código malicioso.

---

## 🟡 3. RENDIMIENTO

### 3.1 ⚠️ ALTO — Nueva conexión a BD en cada instanciación de modelo

Cada vez que se crea un modelo (en cada request), se crea una nueva conexión PDO en [Conexion.php](file:///c:/xampp/htdocs/portal/Libraries/Core/Conexion.php). No hay patrón Singleton ni pool de conexiones.

En Helpers.php se instancian modelos como `new PageModel()` en múltiples funciones, generando múltiples conexiones por request.

---

### 3.2 ⚠️ MEDIO — `SELECT *` en la mayoría de consultas

Muchos modelos usan `SELECT *` lo que trae columnas innecesarias:

```php
$query = "SELECT*FROM categorias;";
$query = "SELECT*FROM rol AS r WHERE r.`status`=1";
$query = "SELECT*FROM persona AS p WHERE p.identificacion='{...}'";
```

---

### 3.3 ⚠️ MEDIO — Sin caché de ningún tipo

No hay caché a ningún nivel:
- No hay caché de consultas frecuentes
- No hay cabeceras de caché para assets estáticos (más allá de versionado manual)
- No hay caché de resultados de funciones repetidas como `optFuncionario()`, `normasmunicipales()`, etc.

---

### 3.4 ⚠️ MEDIO — Helpers carga modelos redundantemente

Funciones como `optFuncionario()`, `optIntegrantesSci()`, `optMarconormativo()`, etc. en [Helpers.php:299-361](file:///c:/xampp/htdocs/portal/Helpers/Helpers.php#L299-L361) todas hacen:

```php
require_once("Models/PageModel.php");
$objLogin = new PageModel();  // Variable nombrada "$objLogin" pero es PageModel
```

Cada una crea una nueva instancia y nueva conexión a BD.

---

### 3.5 BAJO — Múltiples scripts externos bloqueantes

El footer carga 12+ scripts JavaScript de forma secuencial sin `defer` ni `async`.

---

## 🔵 4. MANTENIBILIDAD Y CALIDAD DE CÓDIGO

### 4.1 ⚠️ ALTO — Nombrado inconsistente y confuso

| Problema | Ejemplo |
|---|---|
| Variable nombrada como otro tipo | `$objLogin = new PageModel()` en múltiples helpers |
| Mezcla inglés/español | `namecompay()`, `NOMBRE_EMPESA` (typo), `getDaysTranscurridos()` |
| Typos en constantes | `NOMBRE_EMPESA` debería ser `NOMBRE_EMPRESA` |
| Métodos sin convención clara | `putDFical()`, `regUsuario()`, `updUsuario()` |
| Funciones sin tipo de retorno | Ninguna función helper declara return type |

---

### 4.2 ⚠️ ALTO — Sin logging ni auditoría

No existe ningún sistema de logging. Los errores se silencian con `error_reporting(0)` o se muestran al usuario con `echo`. No hay registro de:
- Intentos de login fallidos
- Acciones administrativas (crear/editar/eliminar)
- Errores de la aplicación

---

### 4.3 ⚠️ MEDIO — Código muerto y comentado

Hay código comentado disperso por todo el sistema:
- [Login.php:7](file:///c:/xampp/htdocs/portal/Controllers/Login.php#L7): `// session_start(name_sesion());`
- [Login.php:24](file:///c:/xampp/htdocs/portal/Controllers/Login.php#L24): `// json($_POST); die;`
- [Blog.php:392-396](file:///c:/xampp/htdocs/portal/Controllers/Blog.php#L392-L396): Bloques completos comentados
- [index.php:26](file:///c:/xampp/htdocs/portal/index.php#L26): `# code...`
- [Conexion.php:10](file:///c:/xampp/htdocs/portal/Libraries/Core/Conexion.php#L10): `//echo "conexión exitosa";`

---

### 4.4 ⚠️ MEDIO — Función `dep()` rota

En [Helpers.php:88-94](file:///c:/xampp/htdocs/portal/Helpers/Helpers.php#L88-L94):
```php
function dep($data) {
    $format = print_r('<pre>');      // print_r() retorna 1, no el string
    $format .= print_r($data);       // Imprime directamente, no captura
    $format .= print_r('</pre>');
    return $format;                   // Retorna "111", no los datos
}
```

La función está rota: `print_r()` sin `true` como segundo argumento imprime directamente y retorna `1`.

---

### 4.5 ⚠️ MEDIO — URL hardcodeada en lógica de negocio

En [Blog.php:540](file:///c:/xampp/htdocs/portal/Controllers/Blog.php#L540):
```php
if (strpos($embed, 'http://localhost/portal/blog/blog/') === 0) {
    $embed = '';
}
```

URL de localhost hardcodeada en producción.

---

### 4.6 ⚠️ MEDIO — Eliminación física de registros

`deleteUsuario()`, `deleteCategoria()`, `deleteBlog()` ejecutan `DELETE FROM` real. Debería usarse **soft delete** (cambio de status) para mantener la integridad referencial y permitir auditoría.

---

### 4.7 BAJO — IDs de usuario hardcodeados

En [UsuariosModel.php:60](file:///c:/xampp/htdocs/portal/Models/UsuariosModel.php#L60):
```php
$whereAdmin = " and p.idpersona != 1 and p.idpersona != 13";
```

IDs mágicos que se romperán si cambia la base de datos.

---

### 4.8 BAJO — Sin paginación en consultas

Métodos como `selectUsuarios()`, `selectBlogs()`, etc. traen **todos los registros** sin límite. Con el crecimiento de datos esto será problemático.

---

### 4.9 BAJO — Generador de contraseñas débil

En [Helpers.php:206](file:///c:/xampp/htdocs/portal/Helpers/Helpers.php#L206):
```php
$pos = rand(0, $longitudCadena - 1);  // rand() no es criptográficamente seguro
```

Debería usar `random_int()` en vez de `rand()`.

---

## 🟢 5. BUENAS PRÁCTICAS

### 5.1 ⚠️ ALTO — Sin gestión de dependencias (Composer)

No hay `composer.json`. Todo es código manual. Esto impide:
- Usar PHPMailer (el envío de correo usa `mail()` nativo, poco confiable)
- Usar un ORM o query builder seguro
- Usar librerías de validación, logging, etc.
- Autoload PSR-4

---

### 5.2 ⚠️ MEDIO — Sin tests de ningún tipo

No hay tests unitarios, de integración, ni funcionales. Cualquier cambio es "a ciegas".

---

### 5.3 ⚠️ MEDIO — Sin manejo de errores centralizado

No hay try/catch en controladores ni modelos. Si una consulta falla, el sistema puede mostrar errores PHP al usuario o simplemente fallar silenciosamente.

---

### 5.4 ⚠️ MEDIO — Envío de correo con `mail()` nativo

En [Helpers.php:114](file:///c:/xampp/htdocs/portal/Helpers/Helpers.php#L114):
```php
$send = mail($emailDestino, $asunto, $mensaje, $de);
```

`mail()` nativo:
- No soporta SMTP autenticado
- Alta probabilidad de caer en spam
- Sin TLS/SSL
- Sin manejo de errores detallado

**Solución:** Usar PHPMailer con SMTP.

---

### 5.5 BAJO — Metatags genéricos e incompletos

En [header_admin.php](file:///c:/xampp/htdocs/portal/Views/Template/Panel/header_admin.php#L6-L9):
```html
<meta name="description" content="Tienda Virtual Abel OSH">
<meta name="author" content="Abel OSH">
```

Contenido genérico que no refleja el proyecto actual (EPS Rioja). Faltan metatags de Open Graph para compartir en redes sociales.

---

### 5.6 BAJO — Mezcla de idiomas en la interfaz

El panel usa una mezcla de inglés y español:
- "Settings", "Profile", "Logout" en el menú (debería ser "Configuración", "Perfil", "Cerrar sesión")
- Nombres de funciones mezclan idiomas: `getDaysTranscurridos()`, `namecompay()`

---

## 📋 Plan de Acción Recomendado (por prioridad)

### Fase 1 — Seguridad Urgente (1-2 semanas)
1. Modificar `Mysql.php` para que `select()`, `select_all()` y `delete()` acepten parámetros
2. Migrar **todas** las consultas a parámetros preparados
3. Implementar `password_hash()` / `password_verify()` con migración gradual
4. Mover credenciales a `.env`
5. Restringir CORS al dominio propio
6. Validar tipo MIME y extensión de archivos subidos

### Fase 2 — Arquitectura Base (2-3 semanas)
7. Integrar Composer con autoload PSR-4
8. Crear capa de validación centralizada
9. Implementar tokens CSRF
10. Configurar sesiones seguras
11. Implementar logging básico (Monolog)

### Fase 3 — Calidad y Rendimiento (2-3 semanas)
12. Implementar Singleton para conexión a BD
13. Mover HTML de controladores a las vistas
14. Reemplazar `mail()` por PHPMailer
15. Agregar paginación a las consultas
16. Implementar soft delete
17. Corregir nombrado e inconsistencias

### Fase 4 — Mejora Continua (ongoing)
18. Agregar tests unitarios
19. Implementar caché básico
20. Documentar API interna
21. Configurar CI/CD básico

---

> [!IMPORTANT]
> **Los puntos de seguridad (Fase 1) deben atenderse antes de cualquier deploy a producción.** La inyección SQL y el esquema de contraseñas son vulnerabilidades explotables activamente.

¿Quieres que comience a implementar alguna de estas mejoras? Puedo empezar por la más crítica (securizar la capa de base de datos) o por la que tú consideres prioritaria.
