<?php
csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}
?>
<head>
    <script src="<?= $_SESSION['INDEX_PATH'] . 'Funciones/image-uploader.js' ?>"></script>
</head>

<body>
    <div class="cabecera">
        <?php require_once $_SESSION['WORKING_PATH'] . 'view/back/cabecera.php'; ?>
    </div>
    <div class="sidebar">
        <?php include $_SESSION['WORKING_PATH'] . 'view/back/menu.php'; ?>
    </div>
    <div class="contenedor">
        <div class="breadcrumb">
            <ul>
                <li><a href="<?= $_SESSION['INDEX_PATH'] . "controller/back/BCcontrol.php?menu=3&lang=" . $_GET['lang'] ?>"><?= $lang['Inicio'] ?></a></li>
                <li><a href="<?= $_SESSION['INDEX_PATH'] . "controller/back/BCcontrol.php?menu=6&lang=" . $_GET['lang'] ."&idTarifa=".$_GET['idTarifa']?>"><?= $lang['Tabla Articulos']['Titulo'] ?></a></li>
                <li><?= $lang['Nuevo Articulo']['Boton'] ?></li>
            </ul>
        </div>
        <form method="POST" class="FormNewObject" enctype="multipart/form-data">
            <?php if ($_GET['menu'] == 1) { ?>
                <ul>
                    <li>
                        <label for="name"><?php echo $lang['Nuevo Articulo']['Nombre'] ?></label>
                        <input type="text" name="name" id="name">
                    </li>
                    <li>
                        <label for="descripcion"><?php echo $lang['Nuevo Articulo']['Descripcion'] ?></label>
                        <input type="text" name="descripcion" id="descripcion">
                    </li>
                    <li>
                        <label for="descripcion2"><?php echo $lang['Nuevo Articulo']['DescripcionL'] ?></label>
                        <input type="text" name="descripcion2" id="descripcion2">
                    </li>
                    <li>
                        <label for="marca">Marca</label>
                        <select name="marca" id="marca">
                            <?php
                            $marca = $articulo->getForeignValue(null, 'marca')->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($marca as $fila) {
                            ?>
                                <option value="<?= $fila['idMarca'] ?>"><?= $fila['nombre'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        <label for="categoria">Categoria</label>
                        <select name="categoria" id="categoria">
                            <?php
                            $categoria = $articulo->getForeignValue(null, 'categoria')->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($categoria as $fila) {
                            ?>
                                <option value="<?= $fila['idCategoria'] ?>"><?= $fila['nombre'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </li>
                    <li><label for="subcategoria">Subcategoria</label>
                        <select name="subcategoria" id="subcategoria">
                            <?php
                            $subcategoria = $articulo->getForeignValue(null, 'subcategoria')->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($subcategoria as $fila) {
                            ?>
                                <option value="<?= $fila['idSubCategoria'] ?>"><?= $fila['nombre'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        <label for="coste">Coste</label>
                        <input type="number" name="coste" id="coste" step="0.01">
                    </li>
                    <li>
                        <label for="images">Imágenes</label>
                        <div class="input-images">
                            <script type="text/javascript">
                                $(".input-images").imageUploader({
                                    label: "<?= 'Haz click aqui para examinar o arrastra las imágenes' ?>"
                                })
                            </script>
                        </div>
                    </li>
                </ul>
            <?php } else {
            ?>
                <ul>
                    <li>
                        <input type="text" name="name" value="<?= escapar($campos['nombre']) ?>">
                    </li>
                    <li>
                        <label for="name"><?php echo $lang['Nuevo Articulo']['Descripcion'] ?></label>
                        <input type="text" name="descripcion" value="<?= escapar($campos['descripcionCorta']) ?>">
                    </li>
                    <li>
                        <label for="name"><?php echo $lang['Nuevo Articulo']['DescripcionL'] ?></label>
                        <input type="text" name="descripcion2" value="<?= escapar($campos['descripcionLarga']) ?>">
                    </li>
                    <li>
                        <label for="marca">Marca</label>
                        <select name="marca" id="marca">
                            <?php
                            $marca = $articulo->getForeignValue(null, 'marca')->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($marca as $fila) {
                            ?>
                                <option value="<?= $fila['idMarca'] ?>"><?= $fila['nombre'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        <label for="categoria">Categoria</label>
                        <select name="categoria" id="categoria">
                            <?php
                            $categoria = $articulo->getForeignValue(null, 'categoria')->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($categoria as $fila) {
                            ?>
                                <option value="<?= $fila['idCategoria'] ?>"><?= $fila['nombre'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        <label for="subcategoria">Subcategoria</label>
                        <select name="subcategoria" id="subcategoria">
                            <?php
                            $subcategoria = $articulo->getForeignValue(null, 'subcategoria')->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($subcategoria as $fila) {
                            ?>
                                <option value="<?= $fila['idSubCategoria'] ?>"><?= $fila['nombre'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        <label for="coste">Coste</label>
                        <input type="number" name="coste" id="coste" step="0.01" value="<?= $campos['coste'] ?>">
                    </li>
                    <li>
                        <label for="images">Imágenes</label>
                        <div class="input-images">
                            <script type="text/javascript">
                                let preloaded = [
                                    <?php
                                    for ($i = 0; $i < sizeof($imagenes); $i++) {
                                        if ($i + 1 != sizeof($imagenes)) {
                                            $path = $imagenes[$i]['path'];
                                            echo ("{id: $i, src: '$path'},");
                                        } else {
                                            $path = $imagenes[$i]['path'];
                                            echo ("{id: $i, src: '$path'}");
                                        }
                                    }
                                    ?>
                                ];
                                $(".input-images").imageUploader({
                                    preloaded: preloaded,
                                    label: "<?= 'Haz click aqui para examinar o arrastra las imágenes' ?>"
                                })
                            </script>
                        </div>
                    </li>
                </ul>
            <?php } ?>
            <button name=" submit" type="submit"><?php if ($_GET['menu'] == 1) {
                                                        echo $lang["Nuevo Articulo"]["Registrarse"];
                                                    } else {
                                                        echo "Actualizar";
                                                    } ?></button>
            <button name="cancelar"><?php echo $lang['Nuevo Usuario']['Cancelar'] ?></button>
        </form>
    </div>
</body>

</html>