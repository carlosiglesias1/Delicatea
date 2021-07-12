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

function logIn(string $name, string $password)
{
  require_once '../Modelos/Musers.php';
  $usuario = new Usuarios('usuarios');
  try {
    $query = $usuario->getByName($name);
    $array = $query->fetchAll(PDO::FETCH_ASSOC);
    if ($query->rowCount() == 0) {
      header('Location: BCcontrol.php?menu=0&lang=es');
    } else {
      if ($array[0]['pass'] == $password) {
        session_start();
        $_SESSION['menu'] = $array[0]['rol'];
        $_SESSION['id'] = $array[0]['idUsr'];
        header('Location: BCcontrol.php?menu=3&lang=es');
      }
    }
  } catch (PDOException $e) {
    throw $e;
  }
}

/** AreUAllowed: Comprueba si el usuario está autorizado a entrar en el sitio web, 
 * Nota: protegerá de posibles intentos de "saltarse" los protocolos de inicio de 
 * sesión e intentar acceder desde la url a las opciones de gestión que estén restringidas
 * para ese usuario
 */
function areUAllowed(array $rolesPermitidos)
{
  if (isset($_SESSION['menu']))
    $usrRol = $_SESSION['menu'];
  else {
    echo '<p>No tienes permiso para acceder a este sitio</p> <br> <a href="' . $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=0&lang=es' . '">Volver al Login</a>';
    exit;
  }

  if (!in_array($usrRol, $rolesPermitidos)) {
    echo '<p>No tienes permiso para acceder a este sitio</p> <br> <a href="' . $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=0&lang=es' . '">Volver al Login</a>';
    exit;
  }
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

<script>
  function dataTableInit() {
    $(document).ready(function() {
      $("#myTable").DataTable({
        language: {
          url: selectLng()
        },
        "scrollY": "400px",
        "scrollCollapse": true,
      });
    });
  }
</script>