<?php
/**
 * Compraventa - anyadir2.php
 *
 * @author    Bartolomé Sintes Marco <bartolome.sintes+mclibre@gmail.com>
 * @copyright 2008 Bartolomé Sintes Marco
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @version   2008-02-27
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

session_start();
if (!isset($_SESSION["compraventaUsuario"])) {
    header("Location:index.php");
    exit();
} else {
    include("biblioteca.php");
    $db = conectaDb();
    cabecera("Venta - Añadir 2", "venta");

    $articulo = recogeParaConsulta($db, "articulo");
    $precio   = recogeParaConsulta($db, "precio");

    if ($articulo == "''" || $precio == "''") {
        print "    <p>Hay que rellenar los dos campos. No se ha guardado el registro.</p>\n";
        print "\n";
    } else {
// FALTA: que la consulta no cuente los artículos vendidos
        $consulta = "SELECT COUNT(*) FROM $dbArticulos
            WHERE id_vendedor='$_SESSION[compraventaUsuario]'";
        $result = $db->query($consulta);
        if (!$result) {
            print "    <p>Error en la consulta.</p>\n";
            print "\n";
        } elseif ($result->fetchColumn()>=$maxRegArticulos) {
            print "    <p>Se ha alcanzado el número máximo de registros que se pueden guardar.</p>\n";
            print "\n";
            print "    <p>Por favor, borre algún registro antes.</p>\n";
            print "\n";
        } else {
            $consulta = "SELECT COUNT(*) FROM $dbArticulos
                WHERE id_vendedor='$_SESSION[compraventaUsuario]'
                AND articulo=$articulo
                AND precio=$precio";
            $result = $db->query($consulta);
            if (!$result) {
                print "    <p>Error en la consulta.</p>\n";
                print "\n";
            } elseif ($result->fetchColumn()==1) {
                print "    <p>El registro ya existe.</p>\n";
                print "\n";
            } else {
                $consulta = "INSERT INTO $dbArticulos
                    VALUES (NULL, $articulo, '$precio',
                    '$_SESSION[compraventaIdUsuario]', NULL, 'false',
                    '0000-00-00 00:00:00', 'false', '0000-00-00')";
                if ($db->query($consulta)) {
                    print "    <p>Registro creado correctamente.</p>\n";
                    print "\n";
                } else {
                    print "    <p>Error al crear el registro.<p>\n";
                    print "\n";
                }
            }
        }
    }
    $db = NULL;
    pie();
}
?>
