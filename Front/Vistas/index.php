<body>
    <?php
    require $_SESSION['WORKING_PATH'] . 'Back/Modelos/DAO/CategoriaDAO.php';
    $cats = (new CategoriaDAO())->getList();
    ?>
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th> <label for="selectAll"><?= $lang['seleccionarTodos'] ?></label><input type="checkbox" id="selectAll"></th>
                <th><?= $lang['Tabla Categorias']['Nombre']; ?></th>
                <th><?= $lang['Tabla Categorias']['Descripcion']; ?></th>
                <th>Ver Subcategorias</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($cats && sizeof($cats) > 0) {
                foreach ($cats as $fila) {
            ?>
                    <tr>
                        <td><input type="checkbox" name="<?= escapar($fila->getIdCategoria()); ?>" id="<?= escapar($fila->getIdCategoria()); ?>" class="option"></td>
                        <td><label for="<?= escapar($fila->getIdCategoria()); ?>"><?= escapar($fila->getNombre()); ?></label>
                        </td>
                        <td><label for="<?= escapar($fila->getIdCategoria()); ?>"><?= escapar($fila->getDescripcion()) ?></label>
                        </td>
                        <td><a href="<?= 'Ccats.php?menu=4&idCat=' . escapar($fila->getIdCategoria()) . "&lang=" . $_GET['lang']  ?>" class="Special"><i class="icofont-list"></i> Ver</a></td>
                    </tr>
            <?php
                }
            }
            ?>
        <tbody>
    </table>
</body>

</html>
<script>
    dataTableInit();
</script>