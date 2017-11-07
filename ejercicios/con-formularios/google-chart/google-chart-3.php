<?php
/**
 * Google Chart 3 - google-chart-3.php
 *
 * @author    Bartolomé Sintes Marco <bartolome.sintes+mclibre@gmail.com>
 * @copyright 2008 Bartolomé Sintes Marco
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @version   2008-02-10
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

function cabecera($texto)
{
    print "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"
  \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
  <title>Crea gráfica
  ($texto). Google Chart. Ejercicios. PHP. Bartolomé Sintes Marco</title>
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />
  <link href=\"mclibre-php-soluciones.css\" rel=\"stylesheet\" type=\"text/css\"
  title=\"Color\" />
</head>\n\n<body>
<h1>Crea gráfica ($texto)</h1>\n";
}

function limpia($var)
{
    return trim(strip_tags($var));
}

function recoge($var)
{
    return (isset($_REQUEST[$var])) ? limpia($_REQUEST[$var]) : "";
}

function recogeMatriz($var)
{
    $resul = array();
    if (isset($_REQUEST[$var]) && is_array($_REQUEST[$var])) {
        foreach ($_REQUEST[$var] as $indice => $valor) {
            $resul[limpia($indice)] = limpia($valor);
        }
    }
    return $resul;
}

function recogeNumero($var, $inicial, $minimo, $maximo) {
    $tmp = recoge($var);
    if (!is_numeric($tmp)) {
        return($inicial);
    } elseif ($tmp < $minimo) {
        return($minimo);
    } elseif ($tmp > $maximo) {
        return($maximo);
    } else {
        return($tmp);
    }
}

function recogeTexto($var, $inicial, $valores) {
    $tmp = recoge($var);
    foreach ($valores as $valor) {
        if ($tmp==$valor) {
            return($tmp);
        }
    }
    return($inicial);
}

// Recoge configuración de la gráfica
$tamanyoGraficaXInicial = 400;
$tamanyoGraficaXMinimo  = 200;
$tamanyoGraficaXMaximo  = 600;
$tamanyoGraficaX = recogeNumero('tamanyoGraficaX', $tamanyoGraficaXInicial,
    $tamanyoGraficaXMinimo, $tamanyoGraficaXMaximo);

$tamanyoGraficaYInicial = 200;
$tamanyoGraficaYMinimo  = 100;
$tamanyoGraficaYMaximo  = 300;
$tamanyoGraficaY = recogeNumero('tamanyoGraficaY', $tamanyoGraficaYInicial,
$tamanyoGraficaYMinimo, $tamanyoGraficaYMaximo);

$tipoGraficaValores = array("lc", "p", "p3");
$tipoGrafica = recogeTexto("tipoGrafica", "lc", $tipoGraficaValores);

// Recoge el núemro de datos y lo valida, aumenta o reduce
$numeroValoresInicial = 4;
$numeroValoresMinimo  = 2;
$numeroValoresMaximo  = 15;
$numeroValores = recogeNumero('numeroValores', $numeroValoresInicial,
    $numeroValoresMinimo, $numeroValoresMaximo);
if (isset($_REQUEST['anyadir']) && ($numeroValores<$numeroValoresMaximo)) {
    $numeroValores++;
} elseif (isset($_REQUEST['quitar']) && ($numeroValores>$numeroValoresMinimo)) {
    $numeroValores--;
}


// Recoge valores numéricos y los valida
$valores = recogeMatriz('valores');
$okValores = true;
for ($i=1; $i<=$numeroValores; $i++) {
    if (!isset($valores[$i])) {
        $okValores = false;
    } elseif (($valores[$i]!="")&&!(is_numeric($valores[$i]))) {
        $okValores = false;
    }
}

// Si no se ha hecho clic en Enviar o los valores no son correctos
if (!isset($_REQUEST['enviar']) || !$okValores) {
    if (isset($_REQUEST['enviar'])) {
        cabecera("Resultado inválido");
        print"<p class=\"aviso\">Por favor corrige los datos:</p>\n";
    } else {
        cabecera("Formulario");
        print"<p>Escribe los valores numéricos (puedes escribir entre ".
        "$numeroValoresMinimo y $numeroValoresMaximo valores):</p>\n";
            }
    print "<form action=\"$_SERVER[PHP_SELF]\" method=\"get\">\n";
    print "  <table>\n    <tbody valign=\"top\">\n      <tr>\n        <td>\n";
    print "          <table>\n";

    print "            <tr>\n              <td>Tamaño gráfica (ancho, entre ".
        "$tamanyoGraficaXMinimo y $tamanyoGraficaXMaximo):</td>\n";
    print "              <td><input type=\"text\" name=\"tamanyoGraficaX\" ".
        "value=\"$tamanyoGraficaX\" size=\"5\" /> px</td>\n            </tr>\n";

    print "            <tr>\n              <td>Tamaño gráfica (alto, entre ".
        "$tamanyoGraficaYMinimo y $tamanyoGraficaYMaximo):</td>\n";
    print "              <td><input type=\"text\" name=\"tamanyoGraficaY\" ".
        "value=\"$tamanyoGraficaY\" size=\"5\" /> px</td>\n            </tr>\n";

    print "            <tr>\n              <td>Tipo de gráfica:</td>\n";
    print "              <td><select name=\"tipoGrafica\">\n".
        "                  <option value=\"lc\">Línea</option>\n".
        "                  <option value=\"p\">Tarta</option>\n".
        "                  <option value=\"p3\">Tarta 3D</option>\n".
    "                </select>\n              </td>\n            </tr>\n";

    print "          </table>\n";
    print "        </td>\n        <td style=\"border-left: black solid 1px\">\n";

    print "          <table>\n";
    for ($i=1; $i<=$numeroValores; $i++) {
        print "            <tr><td>Número $i:</td><td><input type=\"text\" ".
              "name=\"valores[$i]\" size=\"10\" value=\"$valores[$i]\" /></td></tr>\n";
    }
    print "          </table>\n";
    print "        </td>\n      </tr>\n    </tbody>\n  </table>\n";
    print "  <p class=\"der\">\n".
          "    <input type=\"hidden\" name=\"numeroValores\" value=\"$numeroValores\" />\n".
          "    <input type=\"submit\" name=\"anyadir\" value=\"Añadir valor\" />\n".
          "    <input type=\"submit\" name=\"quitar\" value=\"Quitar valor\" />\n".
          "    <input type=\"reset\" value=\"Borrar\" />\n".
          "    <input type=\"submit\" name=\"enviar\" value=\"Enviar\" />\n  </p>\n</form>\n";
} else {
// Si los valores son correctos se convierten a cadena
    cabecera("Resultado válido");
    print"<p>Los datos introducidos son correctos.</p>\n";
    print "<p>Datos introducidos (* si falta un dato): ";
    for ($i=1; $i<=$numeroValores; $i++) {
        if ($valores[$i]=="") {
            print "* ";
        } else {
            print "$valores[$i] ";
        }
    }
    print "</p>\n";

    $simpleEncoding = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    // Empiezo buscando un valor cualquiera en la lista de valores
    $minimo = $maximo = 0;
    $patronValores = '/^[+-]?[0-9]{1,6}$/'; // Este patrón NO admite la cadena vacía
    foreach ($valores as $valor) {
        if (preg_match($patronValores, $valor)) {
            $minimo = $maximo = $valor;
        }
    }
    // Después busco el máximo y el mínimo (las funciones min y max
    // no sirven porque puede haber valores vacíos
    foreach ($valores as $valor) {
        if ($valor!="") {
            if ($valor>$maximo) {
                $maximo = $valor;
            }
            if ($valor<$minimo) {
                $minimo = $valor;
            }
        }
    }
    // En los gráficos de tartas hay que contar desde cero
    if (($tipoGrafica=="p") || ($tipoGrafica=="p3")) {
        $minimo = 0;
    }

    // Por último se convierten a la cadena
    $cadena = "";
    if ($maximo==$minimo) {
        foreach ($valores as $valor) {
            // En los gráficos de tartas no pueden haber huecos en la cadena
            if (($tipoGrafica=="p") || ($tipoGrafica=="p3")) {
                if (!($valor=="")) {
                   $cadena .= "f";
                }
            } else {
                if ($valor=="") {
                    $cadena .= "_";
                } else {
                  $cadena .= "f";
                }
            }
        }
    } else {
        foreach ($valores as $valor) {
            // En los gráficos de tartas no pueden haber huecos en la cadena
            if (($tipoGrafica=="p") || ($tipoGrafica=="p3")) {
                if (!($valor=="")) {
                    $letra = round(($valor-$minimo)/($maximo-$minimo)*61);
                    $cadena .= $simpleEncoding[$letra];
                }
            } else {
                if ($valor=="") {
                    $cadena .= "_";
                } else {
                    $letra = round(($valor-$minimo)/($maximo-$minimo)*61);
                    $cadena .= $simpleEncoding[$letra];
                }
            }
        }
    }
    print "<p>La cadena correspondiente a estos valores es: $cadena</p>\n";
    print "<p><a href=\"$_SERVER[PHP_SELF]\">Volver al principio</a></p>\n";

    $cadenaGrafica = "http://chart.apis.google.com/chart?chs={$tamanyoGraficaX}".
        "x{$tamanyoGraficaY}&amp;chd=s:{$cadena}&amp;cht=$tipoGrafica";
    print "<p>Gráfica correspondiente:</p\n";
    print "<p style=\"text-align:center; border: black solid 1px\"><img ".
        "src=\"$cadenaGrafica\" alt=\"Ejemplo\" title=\"Ejemplo\" /></p>";
}

// Pie de página común a todas las páginas
print '<address>
  Esta página forma parte del curso "Páginas web con PHP" disponible en <a
  href="http://www.mclibre.org/">http://www.mclibre.org</a><br />
  Autor: Bartolomé Sintes Marco<br />
  Última modificación de esta página: 10 de febrero de 2008
</address>
<p class="licencia">El programa PHP que genera esta página está bajo
<a rel="license" href="http://www.gnu.org/licenses/agpl.txt">licencia AGPL 3 o
posterior</a>.</p>
</body>
</html>';
?>