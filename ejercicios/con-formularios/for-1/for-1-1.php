<?php
/**
 * Sucesiones aritméticas 1 - for-1-1.php
 *
 * @author    Bartolomé Sintes Marco <bartolome.sintes+mclibre@gmail.com>
 * @copyright 2016 Bartolomé Sintes Marco
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @version   2016-11-04
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
  <title>Sucesiones aritméticas (1). for (1).
    Ejercicios. PHP. Bartolomé Sintes Marco</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="mclibre-php-soluciones.css" title="Color" />
</head>

<body>
  <h1>Sucesiones aritméticas (1)</h1>

  <p>Valores generados por bucles que empiezan en 1 y suben de 1 en 1:</p>

<?php
print "  <pre>\n";

for ($i = 1; $i <= 10; $i++) {
    printf("%6d", $i + 1);
}
print "\n";

for ($i = 1; $i <= 9; $i++) {
    printf("%6d", 2 * $i);
}
print "\n";

for ($i = 1; $i <= 10; $i++) {
    printf("%6d", 3 * $i + 2);
}
print "\n";

for ($i = 1; $i <= 6; $i++) {
    printf("%6d", 5 * $i - 5);
}
print "\n";

for ($i = 1; $i <= 10; $i++) {
    printf("%6d", 10 - 2 * $i);
}
print "\n";

for ($i = 1; $i <= 7; $i++) {
    printf("%6d", 45 - 5 * $i);
}
print "\n";

for ($i = 1; $i <= 8; $i++) {
    printf("%6d", -1 - 6 * $i);
}
print "\n";

print "</pre>\n";
?>

  <footer>
    <p class="ultmod">
      Última modificación de esta página:
      <time datetime="2016-11-04">4 de noviembre de 2016</time>
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
