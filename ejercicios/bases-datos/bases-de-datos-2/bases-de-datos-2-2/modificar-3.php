<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "biblioteca.php";

$db = conectaDb();
cabecera("Modificar 3", MENU_VOLVER);

$nombre    = recoge("nombre");
$apellidos = recoge("apellidos");
$id        = recoge("id");

$nombreOk    = false;
$apellidosOk = false;

if (mb_strlen($nombre, "UTF-8") > $tamAgendaNombre) {
    print "    <p class=\"aviso\">El nombre no puede tener más de $tamAgendaNombre caracteres.</p>\n";
    print "\n";
} else {
    $nombreOk = true;
}

if (mb_strlen($apellidos, "UTF-8") > $tamAgendaApellidos) {
    print "    <p class=\"aviso\">Los apellidos no pueden tener más de $tamAgendaApellidos caracteres.</p>\n";
    print "\n";
} else {
    $apellidosOk = true;
}

if ($nombreOk && $apellidosOk) {
    if ($id == "") {
        print "    <p class=\"aviso\">No se ha seleccionado ningún registro.</p>\n";
    } elseif ($nombre == "" && $apellidos == "") {
        print "    <p class=\"aviso\">Hay que rellenar al menos uno de los campos. No se ha guardado la modificación.</p>\n";
    } else {
        $consulta = "SELECT COUNT(*) FROM $tablaAgenda
            WHERE id=:id";
        $result = $db->prepare($consulta);
        $result->execute([":id" => $id]);
        if (!$result) {
            print "    <p class=\"aviso\">Error en la consulta.</p>\n";
        } elseif ($result->fetchColumn() == 0) {
            print "    <p class=\"aviso\">Registro no encontrado.</p>\n";
        } else {
            // La consulta cuenta los registros con un id diferente porque MySQL no distingue
            // mayúsculas de minúsculas y si en un registro sólo se cambian mayúsculas por
            // minúsculas MySQL diría que ya hay un registro como el que se quiere guardar.
            $consulta = "SELECT COUNT(*) FROM $tablaAgenda
                WHERE nombre=:nombre
                AND apellidos=:apellidos
                AND id<>:id";
            $result = $db->prepare($consulta);
            $result->execute([":nombre" => $nombre, ":apellidos" => $apellidos,
                ":id"                   => $id, ]);
            if (!$result) {
                print "    <p class=\"aviso\">Error en la consulta.</p>\n";
            } elseif ($result->fetchColumn() > 0) {
                print "    <p class=\"aviso\">Ya existe un registro con esos mismos valores. "
                    . "No se ha guardado la modificación.</p>\n";
            } else {
                $consulta = "UPDATE $tablaAgenda
                    SET nombre=:nombre, apellidos=:apellidos
                    WHERE id=:id";
                $result = $db->prepare($consulta);
                if ($result->execute([":nombre" => $nombre, ":apellidos" => $apellidos,
                    ":id" => $id, ])) {
                    print "    <p>Registro modificado correctamente.</p>\n";
                } else {
                    print "    <p class=\"aviso\">Error al modificar el registro.</p>\n";
                }
            }
        }
    }
}

$db = null;
pie();
