<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../comunes/biblioteca.php";

session_name(SESSION_NAME);
session_start();
if (!isset($_SESSION["conectado"])) {
    header("Location:../index.php");
    exit;
}

$db = conectaDb();
cabecera("Usuarios - Listar", MENU_USUARIOS, 1);

$ordena = recogeValores("ordena", $columnasUsuariosOrden, "usuario ASC");

$consulta = "SELECT COUNT(*) FROM $tablaUsuarios";
$result   = $db->query($consulta);
if (!$result) {
    print "    <p class=\"aviso\">Error en la consulta.</p>\n";
} elseif ($result->fetchColumn() == 0) {
    print "    <p>No se ha creado todavía ningún registro.</p>\n";
} else {
    $consulta = "SELECT * FROM $tablaUsuarios
        ORDER BY $ordena";
    $result = $db->query($consulta);
    if (!$result) {
        print "    <p class=\"aviso\">Error en la consulta.</p>\n";
    } else {
        print "    <p>Listado completo de registros:</p>\n";
        print "\n";
        print "    <form action=\"$_SERVER[PHP_SELF]\" method=\"" . FORM_METHOD . "\">\n";
        print "      <table class=\"conborde franjas\">\n";
        print "        <thead>\n";
        print "          <tr>\n";
        print "            <th>\n";
        print "              <button name=\"ordena\" value=\"usuario ASC\" class=\"boton-invisible\">\n";
        print "                <img src=\"../img/abajo.svg\" alt=\"A-Z\" title=\"A-Z\" width=\"15\" height=\"12\">\n";
        print "              </button>\n";
        print "              Usuario\n";
        print "              <button name=\"ordena\" value=\"usuario DESC\" class=\"boton-invisible\">\n";
        print "                <img src=\"../img/arriba.svg\" alt=\"Z-A\" title=\"Z-A\" width=\"15\" height=\"12\">\n";
        print "              </button>\n";
        print "            </th>\n";
        print "            <th>\n";
        print "              <button name=\"ordena\" value=\"password ASC\" class=\"boton-invisible\">\n";
        print "                <img src=\"../img/abajo.svg\" alt=\"A-Z\" title=\"A-Z\" width=\"15\" height=\"12\">\n";
        print "              </button>\n";
        print "              Contraseña\n";
        print "              <button name=\"ordena\" value=\"password DESC\" class=\"boton-invisible\">\n";
        print "                <img src=\"../img/arriba.svg\" alt=\"Z-A\" title=\"Z-A\" width=\"15\" height=\"12\">\n";
        print "              </button>\n";
        print "            </th>\n";
        print "          </tr>\n";
        print "        </thead>\n";
        print "        <tbody>\n";
        foreach ($result as $valor) {
            print "          <tr>\n";
            print "            <td>$valor[usuario]</td>\n";
            print "            <td>$valor[password]</td>\n";
            print "          </tr>\n";
        }
        print "        </tbody>\n";
        print "      </table>\n";
        print "    </form>\n";
    }
}

$db = null;
pie();
