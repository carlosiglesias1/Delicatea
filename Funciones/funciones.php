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

/**
 * Comprueba si el usuario está autorizado a entrar en el sitio web, 
 * @ignore Protegerá de posibles intentos de "saltarse" los protocolos de inicio de 
 * sesión e intentar acceder desde la url a las opciones de gestión que estén restringidas
 * para ese usuario.
 * @param array<Integer>
 */
function areUAllowed(array $PermisosRequeridos)
{
  if (isset($_SESSION['ventanasMenu'])) {
    $usrRol = array_column($_SESSION['ventanasMenu'], 'permiso');
  } else {
    echo '<p>No tienes permiso para acceder a este sitio</p> <br> <a href="' . $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=0&lang=es' . '">Volver al Login</a>';
    exit;
  }
  if (array_intersect($usrRol, $PermisosRequeridos) == null) {
    echo '<p>No tienes permiso para acceder a este sitio</p> <br> <a href="' . $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=0&lang=es' . '">Volver al Login</a>';
    exit;
  }
}

function getArticulos(Tarifa $tarifa, array $campos)
{
  //Si opero sobre el coste final
  if ($campos['coste'] == 0 || $campos['origen'] == 0) {
    /*
    *Creo una cadena con todas las condiciones que quiero para aplicarlas en la consulta
    *Las condiciones deben variar segun los filtros
    */
    if ($campos["marca"] == 0 && $campos['categoria'] == 0 && $campos['subcategoria'] == 0) {
      $articulos = $tarifa->getForeignValue('articulo');
    } else if ($campos["marca"] != 0 && $campos['categoria'] == 0 && $campos['subcategoria'] == 0) {
      $conditional = 'marca = ' . $campos["marca"];
      $articulos = $tarifa->getForeignValueString('articulo', $conditional)->fetchAll(PDO::FETCH_ASSOC);
    } else if ($campos["marca"] == 0 && $campos['categoria'] != 0 && $campos['subcategoria'] == 0) {
      $conditional = 'categoria = ' . $campos['categoria'];
      $articulos = $tarifa->getForeignValueString('articulo', $conditional)->fetchAll(PDO::FETCH_ASSOC);
    } else if ($campos["marca"] == 0 && $campos['categoria'] == 0 && $campos['subcategoria'] != 0) {
      $conditional = 'subcategoria = ' . $campos['subcategoria'];
      $articulos = $tarifa->getForeignValueString('articulo', $conditional)->fetchAll(PDO::FETCH_ASSOC);
    } else if ($campos["marca"] != 0 && $campos['categoria'] != 0 && $campos['subcategoria'] == 0) {
      $conditional = 'marca = ' . $campos["marca"] . ' AND categoria = ' . $campos['categoria'] . ' AND subcategoria = ' . $campos['subcategoria'];
      $articulos = $tarifa->getForeignValueString('articulo', $conditional)->fetchAll(PDO::FETCH_ASSOC);
    } else if ($campos["marca"] != 0 && $campos['categoria'] == 0 && $campos['subcategoria'] != 0) {
      $conditional = 'marca = ' . $campos["marca"] . ' AND subcategoria = ' . $campos['subcategoria'];
      $articulos = $tarifa->getForeignValueString('articulo', $conditional)->fetchAll(PDO::FETCH_ASSOC);
    } else if ($campos["marca"] == 0 && $campos['categoria'] != 0 && $campos['subcategoria'] != 0) {
      $conditional = 'categoria = ' . $campos['categoria'] . ' AND subcategoria = ' . $campos['subcategoria'];
      $articulos = $tarifa->getForeignValueString('articulo', $conditional)->fetchAll(PDO::FETCH_ASSOC);
    } else {
      $conditional = 'marca = ' . $campos["marca"] . ' AND categoria = ' . $campos['categoria'] . ' AND subcategoria = ' . $campos['subcategoria'];
      $articulos = $tarifa->getForeignValueString('articulo', $conditional)->fetchAll(PDO::FETCH_ASSOC);
    }
  } //Si actualizo una tarifa sobre otra
  else {
    if ($campos['coste'] == -1 || $campos['origen'] == -1) {
      $productos = $tarifa->getForeignValue('tarifasproductos');
      foreach ($productos as $fila => $campo) {
        $articulos[$fila]['coste'] = $campo['costeFinal'];
        $articulos[$fila]['idArticulo'] = $campo['idPrd'];
      }
    } else {
      $productos = $tarifa->getForeignValue('tarifasproductos', $campos['coste'], 'idTarifa');
      foreach ($productos as $fila => $campo) {
        $articulos[$fila]['coste'] = $campo['costeFinal'];
        $articulos[$fila]['idArticulo'] = $campo['idPrd'];
      }
    }
  }
  return $articulos;
}

/**
 * CALCULO LOS COSTES FINALES DE LOS ARTICULOS SEGUN SU TARIFA
 */
function calculoCostes(array $campos, float $incremento, int $RA, Tarifa $tarifa, int $index)
{
  $articulos = getArticulos($tarifa, $campos);
  //Si escogí incrementar el precio
  if ($campos['opera'] == '1') {
    //Compruebo que lo incremento en un importe fijo
    if ($campos['opc'] == '0') {
      foreach ($articulos as $fila) {
        switch ($RA) {
          case 4:
          case 8:
            $resultado = round($fila['coste'] + $incremento, 0);
            break;
          case 5:
          case 9:
            $resultado = round($fila['coste'] + $incremento, 1, PHP_ROUND_HALF_UP);
            break;
          case 6:
            $resultado = round((float)($fila['coste']) + (float)$incremento, 1, PHP_ROUND_HALF_UP) - (float)0.01;
            break;
          case 7:
            $resultado = round($fila['coste'] + $incremento, 2, PHP_ROUND_HALF_UP) - 0.001;
            break;
          case 10:
            $resultado = round($fila['coste'] + $incremento, 1, PHP_ROUND_HALF_UP) - 0.05;
            break;
          case 11:
            $resultado = round($fila['coste'] + $incremento, 2, PHP_ROUND_HALF_UP) - 0.005;
            break;
        }
        if ($resultado < 0)
          $resultado = 0;
        $tarifa->foreignInsert('tarifasproductos', ['idPrd', 'idTarifa', 'costeFinal'], ["idProd" => $fila['idArticulo'], "idTarifa" => $index, "resultado" => $resultado]);
      }
      //Si incremento en un porcentaje
    } else {
      foreach ($articulos as $fila) {
        switch ($RA) {
          case 4:
          case 8:
            $resultado = round($fila['coste'] + ($fila['coste'] * $incremento / 100), 0);
            break;
          case 5:
          case 9:
            $resultado = round($fila['coste'] + ($fila['coste'] * $incremento / 100), 1, PHP_ROUND_HALF_UP);
            break;
          case 6:
            $resultado = round($fila['coste'] + ($fila['coste'] * $incremento / 100), 1, PHP_ROUND_HALF_UP) - 0.01;
            break;
          case 7:
            $resultado = round($fila['coste'] + ((float) ($fila['coste']) * $incremento / 100), 2, PHP_ROUND_HALF_UP) - 0.001;
            break;
          case 10:
            $resultado = round($fila['coste'] + ((float) ($fila['coste']) * $incremento / 100), 1, PHP_ROUND_HALF_UP) - 0.05;
            break;
          case 11:
            $resultado = round($fila['coste'] + ((float) ($fila['coste']) * $incremento / 100), 2, PHP_ROUND_HALF_UP) - 0.005;
            break;
        }
        if ($resultado < 0)
          $resultado = 0;
        $tarifa->foreignInsert('tarifasproductos', ['idPrd', 'idTarifa', 'costeFinal'], ["idProd" => $fila['idArticulo'], "idTarifa" => $index, "resultado" => $resultado]);
      }
    }
    //Si decremento en importe fijo
  } else {
    if ($campos['opc'] == '0') {
      foreach ($articulos as $fila) {
        switch ($RA) {
          case 4:
          case 8:
            $resultado = round($fila['coste'] - $incremento, 0);
            break;
          case 5:
          case 9:
            $resultado = round($fila['coste'] - $incremento, 1, PHP_ROUND_HALF_UP);
            break;
          case 6:
            $resultado = round(($fila['coste']) - $incremento, 1, PHP_ROUND_HALF_UP) - 0.01;
            break;
          case 7:
            $resultado = round($fila['coste'] - $incremento, 2, PHP_ROUND_HALF_UP) - 0.001;
            break;
          case 10:
            $resultado = round($fila['coste'] - $incremento, 1, PHP_ROUND_HALF_UP) - 0.05;
            break;
          case 11:
            $resultado = round($fila['coste'] - $incremento, 2, PHP_ROUND_HALF_UP) - 0.005;
            break;
        }
        if ($resultado < 0)
          $resultado = 0;
        $tarifa->foreignInsert('tarifasproductos', ['idPrd', 'idTarifa', 'costeFinal'], ["idProd" => $fila['idArticulo'], "idTarifa" => $index, "resultado" => $resultado]);
      }
      //Si decremento en porcentaje
    } else {
      foreach ($articulos as $fila) {
        switch ($RA) {
          case 4:
          case 8:
            $resultado = round($fila['coste'] - ($fila['coste'] * $incremento / 100), 0);
            break;
          case 5:
          case 9:
            $resultado = round($fila['coste'] - ($fila['coste'] * $incremento / 100), 1, PHP_ROUND_HALF_UP);
            break;
          case 6:
            $resultado = round($fila['coste'] - ($fila['coste'] * $incremento / 100), 1, PHP_ROUND_HALF_UP) - 0.01;
            break;
          case 7:
            $resultado = round($fila['coste'] - ((float) ($fila['coste']) * $incremento / 100), 2, PHP_ROUND_HALF_UP) - 0.001;
            break;
          case 10:
            $resultado = round($fila['coste'] - ((float) ($fila['coste']) * $incremento / 100), 1, PHP_ROUND_HALF_UP) - 0.05;
            break;
          case 11:
            $resultado = round($fila['coste'] - ((float) ($fila['coste']) * $incremento / 100), 2, PHP_ROUND_HALF_UP) - 0.005;
            break;
        }
        if ($resultado < 0)
          $resultado = 0;
        $tarifa->foreignInsert('tarifasproductos', ['idPrd', 'idTarifa', 'costeFinal'], ["idProd" => $fila['idArticulo'], "idTarifa" => $index, "resultado" => $resultado]);
      }
    }
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
      $("#myTable").dataTable({
        language: {
          url: selectLng()
        },
        "scrollY": "580px",
        "scrollCollapse": true,
        "info": false,
        "columnDefs": [{
          "width": "10%",
          "type": "html-num",
          "targets": [0]
        }]
      });
    });
  }

  function changeclass(elementID, eventElementID, actualElement) {
    /**
     * Cambia la clase de un elemento -> Para las listas ocultas, 
     * está pensado para alternar entre "nested" y "active"
     */
    var element = document.getElementById(elementID);
    if (actualElement.id !== eventElementID) {
      element.className = 'nested';
    } else {
      element.className = 'active';
    }
  }

  function changeValue(changeElementID, elementID) {
    /**
     * Cambia el valor de un elemento por el valor del elemento que se pase en el segundo parametro
     */
    change = document.getElementById(changeElementID);
    change.value = document.getElementById(elementID).value;
  }

  function selectInit() {
    let checkboxes = document.querySelectorAll('input.option'),
      checkall = document.getElementById('selectAll');

    for (var i = 0; i < checkboxes.length; i++) {
      checkboxes[i].onclick = function() {
        let checkedCount = document.querySelectorAll('input.option:checked').length;
        if (!checkall.checked) {
          checkall.checked = checkedCount > 0;
          checkall.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
        } else {
          checkall.checked = checkedCount > 0;
          checkall.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
        }
      }
    }

    checkall.onclick = function() {
      let checkedCount = -1;
      for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = this.checked;
      }
    }
  }

  function changeModal() {
    var modal = document.getElementById("modal");
    if (!modal.classList.contains("abrir")) {
      modal.classList.add("abrir");
    } else {
      modal.classList.remove("abrir");
    }
  }

  function cargarModal(modo) {
    $.ajax({
      url: "<?= $_SESSION['INDEX_PATH'] ?>" + "Includes/modal.php?modo=" + modo + "&lang=" + "<?= $_GET['lang'] ?>",
      success: function(data) {
        $('#modal').html(data);
      }
    })
  }

  function handleFiles(files) {
    var d = document.getElementById("fileList");
    var list = document.getElementById("imgList");
    while (list.getElementsByTagName("li").length > 0) {
      list.removeChild(list.getElementsByTagName("li")[0]);
    }
    for (var i = 0; i < files.length; i++) {
      var li = document.createElement("li");
      list.appendChild(li);

      var img = document.createElement("img");
      img.src = window.URL.createObjectURL(files[i]);
      img.height = 100;
      img.onload = function() {
        window.URL.revokeObjectURL(this.src);
      }
      li.appendChild(img);

      var info = document.createElement("span");
      info.innerHTML = files[i].name;
      li.appendChild(info);
    }
  }
</script>

<!--HTML-->