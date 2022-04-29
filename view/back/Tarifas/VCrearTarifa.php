<?php
csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}
?>

<body>
    <?php require_once $_SESSION['WORKING_PATH'] . "view/back/cabecera.php"; ?>
    <div class="sidebar">
        <?php include $_SESSION['WORKING_PATH'] . "view/back/menu.php"; ?>
    </div>
    <div class="contenedor">
        <div class="breadcrumb">
            <ul>
                <li><a href="<?= $_SESSION['INDEX_PATH'] . "controller/back/BCcontrol.php?menu=3&lang=" . $_GET['lang'] ?>"><?= $lang['Inicio'] ?></a></li>
                <li><a href="<?= $_SESSION['INDEX_PATH'] . "controller/back/BCcontrol.php?menu=8&lang=" . $_GET['lang'] ?>"><?= $lang['Tabla Tarifas']['Titulo'] ?></a></li>
                <li><?= $lang['Nueva Tarifa']['Boton'] ?></li>
            </ul>
        </div>
        <form method="POST" class="FormNewObject">
            <?php if ($_GET['menu'] == 1) { ?>
                <label for="nombre"><?php echo $lang['Nueva Tarifa']['Nombre'] ?></label>
                <input type="text" name="nombre" required>
                <div class="formula">
                    <p>Coste de la tarifa</p>
                    <ul class="tarifaList">
                        <li><label for="costeFinal">Coste Final</label>
                            <input type="radio" name="coste" id="costeFinal" value="0" onclick="changeclass('tarifas', 'otraTarifa', this); changeclass('destino', 'costeFinal', this)" required>
                            <ul class="nested" id='destino'>
                                <span style="text-decoration: underline; cursor: default;">Filtros</span>
                                <li>
                                    <label for="marca">Marcas</label>
                                    <select name="marca" id="marca">
                                        <option selected value="0">Todas</option>
                                        <?php
                                        $marca = $tarifa->getForeignValue('marca');
                                        foreach ($marca as $fila) {
                                        ?>
                                            <option value="<?= $fila['idMarca'] ?>"><?= $fila['nombre'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </li>
                                <li><label for="categoria">Categoria</label>
                                    <select name="categoria" id="cat">
                                        <option selected value="0">Todas</option>
                                        <?php
                                        $categorias = $tarifa->getForeignValue('categoria');
                                        foreach ($categorias as $fila) {
                                        ?>
                                            <option value="<?= $fila['idCategoria'] ?>"><?= $fila['nombre'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </li>
                                <li><label for="subcategoria">Subcategoria</label>
                                    <select name="subcategoria" id="subcategoria">
                                        <option selected value="0">Todas</option>
                                        <?php
                                        $subcategorias = $tarifa->getForeignValue('subcategoria');
                                        foreach ($subcategorias as $fila) {
                                        ?>
                                            <option value="<?= $fila['idSubCategoria'] ?>"><?= $fila['nombre'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label for="otraTarifa">Otra tarifa</label>
                            <input type="radio" name="coste" id="otraTarifa" value="-1" onclick="changeclass('tarifas', 'otraTarifa', this); changeclass('destino', 'costeFinal', this)" required>
                            <ul class="nested" id="tarifas">
                                <li>
                                    <select name="tarifa" id="tarifa" onchange="changeValue('otraTarifa', 'tarifa')">
                                        <option value="-1" selected>Todas</option>
                                        <?php
                                        $tarifas = $tarifa->getAll();
                                        foreach ($tarifas as $fila) {
                                        ?>
                                            <option value="<?= $fila['idTarifa'] ?>"><?= $fila['nombre'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </li>
                            </ul>
                        </li>
                        <li>
                            Operaciones:
                            <ul class="options">
                                <li>
                                    <select name="opera" id="">
                                        <option value="1">Incrementar</option>
                                        <option value="0">Rebajar</option>
                                    </select>
                                </li>
                                <li>
                                    <select name="opc" id="">
                                        <option value="0">Precio Fijo</option>
                                        <option value="1">Porcentaje</option>
                                    </select>
                                    <label for="incremento">Introduce cantidad</label>
                                    <input type="number" name="incremento" id="incremento" required step="0.01">
                                </li>
                                <li>
                                    <label for="redondeo">Redondeo</label>
                                    <select name="redondeo" id="redondeo">
                                        <option value="0">0 Decimales</option>
                                        <option value="1">1 Decimales</option>
                                        <option value="2" selected>2 Decimales</option>
                                        <option value="3">3 Decimales</option>
                                    </select>
                                </li>
                                <li>
                                    <label for="ajuste">Ajuste</label>
                                    <select name="ajuste" id="ajuste">
                                        <option value="4" selected>0.99</option>
                                        <option value="8">0.95</option>
                                    </select>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
                <label for="precioManual">Precio Fijo</label>
                <input type="text" name="precioManual" id="">
            <?php } else {
            ?>
                <label for="nombre"><?php echo $lang['Nueva Tarifa']['Nombre'] ?></label>
                <input type="text" name="nombre" value="<?= $campos['nombre'] ?>" required>
                <div class="formula">
                    <ul>
                        <li>Aplicada sobre : <?php if ($campos['origen'] != 0) {
                                                    if ($campos['origen'] != -1) {
                                                        $nombre = $tarifa->getById($campos['origen'])[0]['nombre'];
                                                        echo $nombre;
                                                    } else {
                                                        echo "Todas las tarifas";
                                                    }
                                                } else {
                                                    echo "Coste final <br>";
                                                    echo "Filtros: <ul><li>Marca: " . $campos['marca'] . " </li><li>Categoría:" . $campos['categoria'] . " </li> <li>Subcategoría: " . $campos['subcategoria'] . " </li> </ul>";
                                                } ?></li>
                        <li><?php if (substr($campos['formula'], 0, 1) != '0') {
                                if (substr($campos['formula'], strlen($campos['formula']) - 1) != '0') {
                                    echo "Incrementar: <input type='number' step='0.001' name='importe' value='" . substr($campos['formula'], 1, strlen($campos['formula']) - 2) . "%";
                                } else {
                                    echo "Incrementar: <input type='number' step='0.001' name='importe' value='" . substr($campos['formula'], 1, strlen($campos['formula']) - 2) . "'>€";
                                }
                            } else {
                                if (substr($campos['formula'], strlen($campos['formula']) - 1) != '0') {
                                    echo "Rebajar: <input type='number' step='0.001' name='importe' value='" . substr($campos['formula'], 1, strlen($campos['formula']) - 2) . "%";
                                } else {
                                    echo "Rebajar: <input type='number' step='0.001' name='importe' value='" . substr($campos['formula'], 1, strlen($campos['formula']) - 2) . "'>€";
                                }
                            } ?></li>
                    </ul>
                </div>
                <label for="precioManual">Precio Fijo</label>
                <input type="text" name="precioManual" id="">
            <?php } ?>
            <input type="submit" name="submit" value="<?php if ($_GET['menu'] == 1) {
                                                            echo $lang["Nueva Marca"]["Registrarse"];
                                                        } else {
                                                            echo "Actualizar";
                                                        } ?>">
            <button name="cancelar"><?php echo $lang['Nuevo Usuario']['Cancelar'] ?></button>
        </form>
    </div>
</body>

</html>