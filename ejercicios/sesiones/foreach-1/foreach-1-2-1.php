<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <title>Palabras repetidas (Formulario 1). foreach (1). Sesiones.
    Ejercicios. PHP. Bartolomé Sintes Marco</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="mclibre-php-soluciones.css" rel="stylesheet" type="text/css" title="Color" />
</head>

<body>
<h1>Palabras repetidas (Formulario 1)</h1>

  <form action="foreach-1-2-2.php" method="get">
    <p>Escriba un número (0 &lt; número &le; 10) y dibujaré una tabla de una
    columna de ese tamaño con cajas de texto en cada celda.</p>

    <p>Tamaño de la tabla: <input type="number" name="numero" min="1" max="10" value="7" /></p>

    <p>
      <input type="submit" value="Mostar" />
      <input type="reset" value="Borrar" />
    </p>
  </form>

  <footer>
    <p class="ultmod">
      Última modificación de esta página:
      <time datetime="2017-11-07">7 de noviembre de 2017</time></p>

    <p class="licencia">
      Este programa forma parte del curso <a href="http://www.mclibre.org/consultar/php/">
      Programación web en PHP</a> por <a href="http://www.mclibre.org/">Bartolomé
      Sintes Marco</a>.<br />
      El programa PHP que genera esta página está bajo
      <a rel="license" href="http://www.gnu.org/licenses/agpl.txt">licencia AGPL 3 o posterior</a>.</p>
  </footer>
</body>
</html>