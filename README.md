# Bookmanager

## Módulo de Tiendas

El CRUD de tiendas usa PHP con PDO y MySQL. La clase de conexión está en
`config/Database.php`, el modelo en `models/Tienda.php` y las vistas en `tiendas/`.
La tabla se define en `database/schema.sql`.

### Puesta en marcha

1. Crea la base de datos MySQL `dblibreria` y ejecuta `database/schema.sql`
   dentro de ella.
2. Configura las variables de entorno `DB_HOST`, `DB_NAME`, `DB_USER` y
   `DB_PASSWORD` para las credenciales de tu entorno. Si no las configuras, se
   usan `127.0.0.1`, `dblibreria`, `root` y contraseña vacía.
3. Configura `APP_USERNAME` y `APP_PASSWORD_HASH` para proteger el acceso.
   Genera el hash con `php -r 'echo password_hash(trim(fgets(STDIN)), PASSWORD_DEFAULT), PHP_EOL;'`
   y escribe la contraseña cuando el comando la solicite.
4. Desde la raíz del proyecto, inicia el servidor local con
   `php -S localhost:8000` y abre `http://localhost:8000/`.

Se requiere PHP con las extensiones PDO y pdo_mysql habilitadas. En un sitio
público, usa HTTPS y guarda las variables en la configuración privada del hosting;
no las subas al repositorio.

Creando CRUD de gestión de biblioteca.

Generando contenido con PHP

Proyecto Final
Aquí tienes los requerimientos completos y estructurados para el Proyecto Final Grupal. Está diseñado para ser entregado durante 3 semanas, asegurando el uso de POO, buenas prácticas y despliegue real.

CRUD Conexión a Bases De datos y Consulta a Bases de Datos

Sistema de Gestión de Librería “BookManager”
Objetivo General
Desarrollar e implementar una aplicación completa utilizando Programación Orientada a Objetos (POO) en PHP, y MySQL, que permita gestionar el inventario de libros (titulos) y la red de distribución (tiendas). El proyecto deberá ser estilizado con una plantilla de Bootstrap Dashboard y publicado finalmente en un servidor remoto gratuito (InfinityFree).

Tecnologías Requeridas
Backend: PHP 8.x (Estrictamente Orientado a Objetos, uso de PDO con sentencias preparadas).
Base de Datos: MySQL (Esquema proporcionado: dblibreria).
Frontend: Utilizar una plantilla de Dashboard basada en Bootstrap 5 (ej. SB Admin 2 o AdminLTE).
Despliegue: InfinityFree (o similar).
Cronograma de Entregas (3 Semanas)
Semana 1: Fundamentos, Conexión y CRUD de “Tiendas”
Objetivo: Configurar el entorno, la arquitectura POO y completar el primer módulo funcional. Entregables:

Carpeta del proyecto local con estructura de archivos organizada.
Clase de conexión a la base de datos (Database.php) usando PDO.
Clase Modelo Tienda.php con sus propiedades y métodos (crear, leer, actualizar, eliminar).
Vistas en Bootstrap para el CRUD de Tiendas:
tiendas/index.php (Listado con tabla).
tiendas/crear.php (Formulario).
tiendas/editar.php (Formulario precargado).
tiendas/eliminar.php (Confirmación y ejecución).
Capturas de pantalla del funcionamiento local.
Semana 2: CRUD de “Títulos” (Libros) y Unificación del Dashboard
Objetivo: Implementar el segundo módulo, manejar relaciones básicas y unificar la interfaz.

Entregables:

Clase Modelo Titulo.php (Libro).
Vistas en Bootstrap para el CRUD de Títulos (Listado, Crear, Editar, Eliminar).
Reto: En el formulario de “Crear/Editar Título”, el campo id_pub (Editorial) debe ser un <select> que cargue las editoriales desde la tabla publicadores (usando un método en el modelo).
Integración de todas las vistas dentro de la plantilla Bootstrap (Sidebar funcional que navegue entre “Inicio”, “Tiendas” y “Títulos”).
Validaciones básicas en PHP (ej. que el precio no sea negativo, que el nombre de la tienda no esté vacío).
Semana 3: Despliegue en Servidor Remoto y Documentación
Objetivo: Migrar el proyecto local a un entorno de producción real y documentar. Entregables:

Base de datos importada exitosamente en el phpMyAdmin de InfinityFree.
Archivos subidos al servidor remoto.
Archivo de configuración de base de datos actualizado con las credenciales del servidor remoto.
Código subido a un repositorio de github.
URL pública funcional del proyecto.
Documento PDF breve (2-3 páginas) con: Capturas del panel de InfinityFree, la URL del proyecto, y una breve explicación de la arquitectura POO utilizada.
📚 Guía Paso a Paso para el Estudiante
Parte A: Estructura del Proyecto (Arquitectura POO)
Organiza tu carpeta bookmanager de la siguiente manera:

📂 bookmanager/
 ├── 📂 assets/          (CSS, JS, imágenes de la plantilla Bootstrap)
 ├── 📂 config/
 │    └── database.php   (Clase de conexión PDO)
 ├── 📂 models/
 │    ├── Tienda.php     (Clase con métodos CRUD para tiendas)
 │    └── Titulo.php     (Clase con métodos CRUD para títulos)
 ├── 📂 views/
 │    ├── 📂 tiendas/    (index.php, crear.php, editar.php, eliminar.php)
 │    └── 📂 titulos/    (index.php, crear.php, editar.php, eliminar.php)
 ├── 📂 includes/
 │    ├── header.php     (Menú lateral y head de Bootstrap)
 │    └── footer.php     (Cierre de HTML y scripts)
 └── index.php           (Página de inicio del dashboard)
Parte B: Pasos para crear el CRUD (Ejemplo con Tienda)
Conexión (config/database.php): Crea una clase que devuelva una instancia de PDO. Usa variables para el host, dbname, user y password.
Modelo (models/Tienda.php):
Define las propiedades privadas ($id_tienda, $nombre_tienda, etc.).
Crea el __construct que reciba la instancia de la base de datos.
Crea métodos: getAll(), getById($id), create($datos), update($id, $datos), delete($id).
⚠️ Obligatorio: Usa sentencias preparadas ($stmt = $this->db->prepare(...)) para evitar inyección SQL.
Controlador/Vista (views/tiendas/index.php):
Incluye header.php, database.php y Tienda.php.
Instancia el modelo: $tiendaModel = new Tienda($db);
Obtiene los datos: $tiendas = $tiendaModel->getAll();
Usa un ciclo foreach para pintar la tabla de Bootstrap con los datos.
Formularios (crear.php / editar.php):
Usa el método POST. Al enviar, instancia el modelo y llama a $tiendaModel->create($_POST).
Redirige de vuelta al index.php usando header("Location: index.php");.
Parte C: Pasos para Publicar en InfinityFree
Crear la cuenta:
Ve a infinityfree.net y regístrate con un correo válido.
Crea un nuevo sitio web (“Create Account”) y elige un subdominio gratuito (ej. milibreria.rf.gd).
Preparar la Base de Datos Remota:
En el panel de control de InfinityFree (Vista Panel), busca “MySQL Databases”.
Crea una nueva base de datos. Anota el MySQL Host Name, Database Name, Username y Password.
Abre phpMyAdmin desde el panel, selecciona tu base de datos, ve a la pestaña “Importar” y sube el archivo .sql de la librería (puedes extraer solo las tablas tiendas, titulos, publicadores y sus datos para que sea más ligero).
Configurar las Credenciales:
Configura en el hosting las variables DB_HOST, DB_NAME, DB_USER y DB_PASSWORD
con los valores que proporciona el panel. Configura también APP_USERNAME y
APP_PASSWORD_HASH para el acceso al sistema. Genera el hash de la contraseña
localmente con el comando indicado en “Puesta en marcha”; no uses la contraseña
en texto plano ni la subas a GitHub.
Subir los Archivos:
En el panel de InfinityFree, abre el “Online File Manager”.
Entra a la carpeta htdocs.
Sube todas las carpetas y archivos del proyecto dentro de htdocs.
Prueba Final:
Visita tu URL usando HTTPS (ej. https://milibreria.rf.gd) e inicia sesión.
Navega a Tiendas y Títulos. Crea un registro nuevo para verificar que la escritura en la base de datos remota funciona.
✅ Rúbrica de Evaluación (Total: 20 puntos)
Criterio	Puntos	Detalle
Arquitectura POO	5	Uso correcto de clases, propiedades privadas, constructores, encapsulamiento y métodos separados para la lógica de negocio.
Seguridad (PDO)	3	Uso exclusivo de sentencias preparadas (Prepared Statements) en todas las consultas SQL. No hay concatenación directa de variables en el SQL.
Funcionalidad CRUD	5	Las 4 operaciones (Crear, Leer, Actualizar, Eliminar) funcionan sin errores para tiendas y titulos.
Interfaz (UI/UX)	2	Uso correcto de la plantilla Bootstrap. Tablas legibles, formularios ordenados y menú de navegación funcional.
Despliegue y Entrega	5	El enlace público funciona correctamente, la base de datos está conectada en el servidor remoto y se entrega la documentación solicitada.
💡 Consejos Clave para el Estudiante
No subas archivos locales de configuración: Si usas Git, asegúrate de que tu archivo de base de datos no tenga contraseñas reales de tu máquina local antes de subirlo.
Rutas relativas: Al subir a InfinityFree, asegúrate de que tus include y require usen rutas relativas (ej. __DIR__ . '/../config/database.php') para evitar errores de “File not found”.
Materiala Didcático Adicional
Creación y gestión de formularios con PHP

## Estado de avance y pendientes

- **Semana 1:** conexión PDO, modelo encapsulado de tiendas, CRUD con formularios
  validados, consultas preparadas y token CSRF.
- **Semana 2:** modelo y CRUD de títulos, selector de editoriales, validación de
  precio y navegación común entre Inicio, Tiendas y Títulos.
- **Base local:** `database/schema.sql` crea las tablas `tiendas`,
  `publicadores` y `titulos`, y agrega una editorial de ejemplo para probar el
  formulario. El modelo de títulos espera las columnas `publicadores.id_pub`,
  `publicadores.nombre_pub`, `titulos.id_titulo`, `titulos.titulo`,
  `titulos.precio` y `titulos.id_pub`. Si se importa el esquema entregado por el
  curso, verifica que use esos nombres o adapta el modelo a sus columnas.
- **Verificación local pendiente:** este entorno no tiene el driver PDO MySQL
  (`pdo_mysql`), así que no puede conectarse a una instancia MySQL real. El
  servidor local y los CRUD necesitan PHP con `pdo_mysql` y una base de datos
  configurada.
- **Semana 3 pendiente:** la importación en phpMyAdmin/InfinityFree, la carga de
  archivos, la URL pública y las capturas/PDF requieren una cuenta, credenciales
  y una dirección del servidor. No se incluyen credenciales en el repositorio.
- El repositorio tiene configurado el remoto `origin`; publica los cambios con
  Git cuando estén revisados y se autorice la publicación.