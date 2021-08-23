<?php
/*csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}*/
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="cabecera">
        <?php require_once "../cabecera.php"; ?>
    </div>
    <div class="sidebar">
        <?php include "../menu.php"; ?>
    </div>
    <div class="contenedor">
        <div class="breadcrumb">
            <ul>
                <li><a href="<?= $_SESSION['INDEX_PATH'] . "Back/Controladores/BCcontrol.php?menu=3&lang=" . $_GET['lang'] ?>"><?= $lang['Inicio'] ?></a></li>
                <li><a href="<?= $_SESSION['INDEX_PATH'] . "Back/Controladores/BCcontrol.php?menu=5&lang=" . $_GET['lang'] ?>"><?= $lang['Tabla Articulos']['Titulo'] ?></a></li>
                <li><?= $lang['Nuevo Articulo']['Boton'] ?></li>
            </ul>
        </div>
        <form method="POST" class="FormNewObject">
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
                </ul>
            <?php } else {
            ?>
                <input type="text" name="name" value="<?= escapar($campos['nombre']) ?>">
                <label for="name"><?php echo $lang['Nuevo Articulo']['Descripcion'] ?></label>
                <input type="text" name="descripcion" value="<?= escapar($campos['descripcionCorta']) ?>">
                <label for="name"><?php echo $lang['Nuevo Articulo']['DescripcionL'] ?></label>
                <input type="text" name="descripcion2" value="<?= escapar($campos['descripcionLarga']) ?>">
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
                <input type="number" name="coste" id="coste" step="0.01" value="<?= $campos['coste']?>">
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