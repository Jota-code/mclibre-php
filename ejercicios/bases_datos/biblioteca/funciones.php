<?php
/**
 * Biblioteca - funciones.php
 *
 * @author    Bartolom� Sintes Marco <bartolome.sintes+mclibre@gmail.com>
 * @copyright 2009 Bartolom� Sintes Marco
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @version   2009-05-21
 * @link      http://www.mclibre.org
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

define('CABECERA_CON_CURSOR',    TRUE);   // Para funci�n cabecera()
define('CABECERA_SIN_CURSOR',    FALSE);  // Para funci�n cabecera()
define('FORM_METHOD',            'get');  // Formularios se env�an con GET
//define('FORM_METHOD',            'post'); // Formularios se env�an con POST
define ('MYSQL', 'MySQL');
define ('SQLITE', 'SQLite');
$dbMotor = SQLITE;                        // Base de datos empleada
if ($dbMotor==MYSQL) {
    define('MYSQL_HOST', 'mysql:host=localhost'); // Nombre de host MYSQL
    define('MYSQL_USUARIO', 'root');      // Nombre de usuario de MySQL
    define('MYSQL_PASSWORD', '');         // Contrase�a de usuario de MySQL
    $dbDb        = 'mclibre_biblioteca';  // Nombre de la base de datos
    $dbObras     = $dbDb.'.obras';        // Nombre de la tabla Obras
    $dbUsuarios  = $dbDb.'.usuarios';     // Nombre de la tabla Ususarios
    $dbPrestamos = $dbDb.'.prestamos';    // Nombre de la tabla de Pr�stamos
} elseif ($dbMotor==SQLITE) {
    $dbDb        = '/home/barto/mclibre/tmp/mclibre/mclibre_biblioteca.sqlite';  // Nombre de la base de datos
    $dbObras     = 'obras';               // Nombre de la tabla Obras
    $dbUsuarios  = 'usuarios';            // Nombre de la tabla Ususarios
    $dbPrestamos = 'prestamos';           // Nombre de la tabla de Pr�stamos
}

define('ZONA_HORARIA',      'Europe/Madrid');  // Zona horaria del servidor
define('TAM_TITULO',        50);  // Tama�o del campo Obras > T�tulo
define('TAM_AUTOR',         50);  // Tama�o del campo Obras > Autor
define('TAM_EDITORIAL',     50);  // Tama�o del campo Obras > Editorial
define('TAM_NOMBRE',        50);  // Tama�o del campo Usuarios > Nombre
define('TAM_APELLIDOS',     50);  // Tama�o del campo Usuarios > Apellidos
define('TAM_DNI',           10);  // Tama�o del campo Usuarios > DNI
define('TAM_FECHA',         10);  // Tama�o del campo Pr�stamo > Fecha
define('MAX_REG_OBRAS',     20);  // N�mero m�ximo de registros en la tabla Obras
define('MAX_REG_USUARIOS',  20);  // N�mero m�ximo de registros en la tabla Usuarios
define('MAX_REG_PRESTAMOS', 20);  // N�mero m�ximo de registros en la tabla Pr�stamos

$recorta = array(
    'titulo'    => TAM_TITULO,
    'autor'     => TAM_AUTOR,
    'editorial' => TAM_EDITORIAL,
    'nombre'    => TAM_NOMBRE,
    'apellidos' => TAM_APELLIDOS,
    'dni'       => TAM_DNI,
    'fecha'     => TAM_FECHA);

function conectaDb()
{
    global $dbMotor, $dbDb;

    try {
        if ($dbMotor==MYSQL) {
            $db = new PDO(MYSQL_HOST, MYSQL_USUARIO, MYSQL_PASSWORD);
            $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, TRUE);
        } elseif ($dbMotor==SQLITE) {
            $db = new PDO('sqlite:'.$dbDb);
        }
        return($db);
    } catch (PDOException $e) {
        cabecera('Error grave', FALSE);
        print "<p>Error: No puede conectarse con la base de datos.</p>\n";
//        print "<p>Error: " . $e->getMessage() . "</p>\n";
        pie();
        exit();
    }
}

function recorta($campo, $cadena)
{
    global $recorta;

    $tmp = isset($recorta[$campo]) ? substr($cadena, 0, $recorta[$campo]) : $cadena;
    return $tmp;
}

function recogeParaConsulta($db, $var, $var2='')
{
    $tmp = (isset($_REQUEST[$var]) && ($_REQUEST[$var]!='')) ?
        trim(strip_tags($_REQUEST[$var])) : trim(strip_tags($var2));
    if (get_magic_quotes_gpc()) {
        $tmp = stripslashes($tmp);
    }
    $tmp = str_replace('&', '&amp;',  $tmp);
    $tmp = str_replace('"', '&quot;', $tmp);
    $tmp = recorta($var, $tmp);
    if (!is_numeric($tmp)) {
        $tmp = $db->quote($tmp);
    }
    return $tmp;
}

function recogeMatrizParaConsulta($db, $var)
{
    $tmpMatriz = array();
    if (isset($_REQUEST[$var]) && is_array($_REQUEST[$var])) {
        foreach ($_REQUEST[$var] as $indice => $valor) {
            $tmp = trim(strip_tags($indice));
            if (get_magic_quotes_gpc()) {
                $tmp = stripslashes($tmp);
            }
            $tmp = str_replace('&', '&amp;',  $tmp);
            $tmp = str_replace('"', '&quot;', $tmp);
            $tmp = recorta($var, $tmp);
            if (!is_numeric($tmp)) {
                $tmp = $db->quote($tmp);
            }
            $indiceLimpio = $tmp;

            $tmp = trim(strip_tags($valor));
            if (get_magic_quotes_gpc()) {
                $tmp = stripslashes($tmp);
            }
            $tmp = str_replace('&', '&amp;',  $tmp);
            $tmp = str_replace('"', '&quot;', $tmp);
            $tmp = recorta($var, $tmp);
            if (!is_numeric($tmp)) {
                $tmp = $db->quote($tmp);
            }
            $valorLimpio  = $tmp;

            $tmpMatriz[$indiceLimpio] = $valorLimpio;
        }
    }
    return $tmpMatriz;
}

function quitaComillasExteriores($var)
{
    if (is_string($var)) {
        if (isset($var[0]) && ($var[0]=="'")) {
            $var = substr($var, 1, strlen($var)-1);
        }
        if (isset($var[strlen($var)-1]) && ($var[strlen($var)-1]=="'")) {
            $var = substr($var, 0, strlen($var)-1);
        }
    }
    return $var;
}

function fechaDma($amd)
{
    return substr($amd, 8, 2)."-".substr($amd, 5, 2)."-".substr($amd, 0, 4);
}

function fechaAmd($dma)
{
    return substr($dma, 7, 4)."-".substr($dma, 4, 2)."-".substr($dma, 1, 2);
}

function cabecera($texto, $conCursor=CABECERA_SIN_CURSOR, $menu='menuPrincipal')
{
    print "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"
       \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
  <title>www.mclibre.org - Biblioteca - $texto</title>
  <link href=\"mclibre-php-soluciones-proyectos-comun.css\" rel=\"stylesheet\" type=\"text/css\" />
</head>\n\n";
    if ($conCursor) {
        print "<body onload=\"document.getElementById('cursor').focus()\">\n";
    } else {
        print "<body>\n";
    }
    print "<h1>Biblioteca - $texto</h1>
<div id=\"menu\">
<ul>\n";
    if ($menu=='menuObras') {
        print "  <li><a href=\"index.php\">Inicio</a></li>
  <li><a href=\"obr-anyadir-1.php\">A�adir</a></li>
  <li><a href=\"obr-listar.php\">Listar</a></li>
  <li><a href=\"obr-buscar-1.php\">Buscar</a></li>
  <li><a href=\"obr-modificar-1.php\">Modificar</a></li>
  <li><a href=\"obr-borrar-1.php\">Borrar</a></li>
  <li><a href=\"obr-borrar-todo-1.php\">Borrar todo</a></li>";
    } elseif ($menu=='menuUsuarios') {
        print "  <li><a href=\"index.php\">Inicio</a></li>
  <li><a href=\"usu-anyadir-1.php\">A�adir</a></li>
  <li><a href=\"usu-listar.php\">Listar</a></li>
  <li><a href=\"usu-buscar-1.php\">Buscar</a></li>
  <li><a href=\"usu-modificar-1.php\">Modificar</a></li>
  <li><a href=\"usu-borrar-1.php\">Borrar</a></li>
  <li><a href=\"usu-borrar-todo-1.php\">Borrar todo</a></li>";
    } elseif ($menu=='menuPrestamos') {
        print "  <li><a href=\"index.php\">Inicio</a></li>
  <li><a href=\"pre-anyadir-1.php\">Pr�stamo</a></li>
  <li><a href=\"pre-devolucion-1.php\">Devoluci�n</a></li>
  <li><a href=\"pre-listar.php\">Listar</a></li>
  <li><a href=\"pre-borrar-1.php\">Borrar</a></li>
  <li><a href=\"pre-borrar-todo-1.php?\">Borrar todo</a></li>";
    } else {
        print "  <li><a href=\"obr-index.php\">Obras</a></li>
  <li><a href=\"usu-index.php\">Usuarios</a></li>
  <li><a href=\"pre-index.php\">Pr�stamos</a></li>
  <li><a href=\"com-borrar-todo-1.php\">Borrar todo</a></li>";
    }
    print "\n</ul>\n</div>\n\n<div id=\"contenido\">\n";
}

function pie()
{
    print '</div>

<div id="pie">
<address>
  Este programa forma parte del curso "P�ginas web con PHP" disponible en <a
  href="http://www.mclibre.org/">http://www.mclibre.org</a><br />
  Autor: Bartolom� Sintes Marco<br />
  �ltima modificaci�n de este programa: 21 de mayo de 2009
</address>
<p class="licencia">El programa PHP que genera esta p�gina est� bajo
<a rel="license" href="http://www.gnu.org/licenses/agpl.txt">licencia AGPL 3 o
posterior</a>.</p>
</div>
</body>
</html>';
}
