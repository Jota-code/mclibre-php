<?php
/**
 * Matrices (1) 16 - matrices-1-16.php
 *
 * @author    Bartolomé Sintes Marco <bartolome.sintes+mclibre@gmail.com>
 * @copyright 2018 Bartolomé Sintes Marco
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @version   2018-10-22
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <title>Cambio de bits. Matrices (1).
    Ejercicios. Programación web en PHP. Bartolomé Sintes Marco. www.mclibre.org</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="mclibre-php-ejercicios.css" title="Color" />
</head>

<body>
  <h1>Cambio de bits</h1>

  <p>Actualice la página para mostrar una secuencia aleatoria de bits y la detección de cambios de bits consecutivos en la secuencia.</p>

<?php
$numero = 10;

// Creamos la matriz de bits aleatorios
$inicial = [];
for ($i = 0; $i < $numero; $i++) {
    $inicial[$i] = rand(0, 1);
}

// Mostramos los bits aleatorios de la matriz
print "  <pre style=\"font-size: 300%\">\n";
print " A: ";
foreach ($inicial as $bit) {
    print "$bit ";
}
print "\n";
print "\n";

// Creamos la matriz con la detección de los cambios
$resultado = [];
for ($i = 0; $i < $numero - 1; $i++) {
    if ($inicial[$i] == $inicial[$i+1]) {
        $resultado[$i] = 0;
    } else {
        $resultado[$i] = 1;
    }
}

// Mostramos los valores calculados
print "&Delta;A:  ";
foreach ($resultado as $bit) {
    print "$bit ";
}
print "\n";
print "</pre>\n";
?>

  <footer>
    <p class="ultmod">
      Última modificación de esta página:
      <time datetime="2018-10-22">22 de octubre de 2018</time>
    </p>

    <p class="licencia">
      Este programa forma parte del curso <strong><a href="http://www.mclibre.org/consultar/php/">Programación
      web en PHP</a></strong> de <a href="http://www.mclibre.org/" rel="author" >Bartolomé Sintes Marco</a>.<br />
      El programa PHP que genera esta página se distribuye bajo
      <a rel="license" href="http://www.gnu.org/licenses/agpl.txt">licencia AGPL 3 o posterior</a>.
    </p>
  </footer>
</body>
</html>