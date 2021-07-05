<!--PHP-->
<?php
function escapar($html)
{
  return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

function csrf()
{
  if (empty($_SESSION['csrf'])) {
    if (function_exists('random_bytes')) {
      $_SESSION['csrf'] = bin2hex(random_bytes(32));
    } else if (function_exists('mcrypt_create_iv')) {
      $_SESSION['csrf'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
    } else {
      $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
    }
  }
}

function concatenar(array $array)
{
  $cadena = "";
  reset($array);
  foreach ($array as $key => $value) {
    $cadena .= $key . " = '" . $value . "',";
  }
  return substr($cadena, 0, strlen($cadena) - 1);
}

function orderBy(array $array, string $campo)
{
  //La idea es que le pases el array de la consulta SQL y lo ordene en base a un entero
  //(id, precio, edad,...) del que le hay que pasar el nombre
  $aux = array();
  foreach ($array as $key => $fila) {
    $aux[$key]  = $fila[$campo];
  }
  array_multisort($aux, SORT_ASC, $array);
}


?>
<!--SCRIPTS-->
<script>
  function confirmar(message) {
    return confirm(message);
  }
</script>

<script>
  function selectLng() {
    var lng = "<?php echo $_GET['lang']; ?>";
    return "../../Lenguajes/" + lng + ".json";
  }
</script>