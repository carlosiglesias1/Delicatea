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


?>
<!--SCRIPTS-->
<script>
  function confirmar(message) {
    return confirm(message);
  }
</script>