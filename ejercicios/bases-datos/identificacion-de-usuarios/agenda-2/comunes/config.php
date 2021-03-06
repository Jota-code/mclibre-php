<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

// Base de datos utilizada por la aplicación: MYSQL o SQLITE

$dbMotor = SQLITE;                   // Valores posibles: MYSQL o SQLITE

// Configuración Tabla Agenda

define("MAX_REG_TABLE_AGENDA", 20);  // Número máximo de registros en la tabla Agenda
$tamAgendaNombre    = 40;            // Tamaño de la columna Agenda > Nombre
$tamAgendaApellidos = 60;            // Tamaño de la columna Agenda > Apellidos
$tamAgendaTelefono  = 10;            // Tamaño de la columna Agenda > Teléfono
$tamAgendaCorreo    = 50;            // Tamaño de la columna Agenda > Correo

// Usuario inicial

$tamUsuarioNombre   = 20;            // Tamaño del Nombre de Usuario
$tamUsuarioPassword = 20;            // Tamaño de la Contraseña de Usuario
define("ROOT_NAME", "root");                                                                  // Usuario inicial: Nombre
define("ROOT_PASSWORD", "4813494d137e1631bba301d5acab6e7bb7aa74ce1185d456565ef51d737677b2");  // Usuario inicial: Contraseña

// Método de envío de formularios

define("FORM_METHOD", GET);          // Valores posibles: GET o POST

// Hoja de estilo

define("COLOR", 27);                 // Color básico de la aplicación (0 - 360)

// Nombre de sesión

define("SESSION_NAME", "agenda-2");  // Nombre de sesión

// Algoritmo hash para encriptar la contraseña de usuario

define("HASH_ALGORITHM", "sha256");  // Algoritmo hash: Nombre
