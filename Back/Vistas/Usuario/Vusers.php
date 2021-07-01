<?php
include '../../Funciones/funciones.php';
require_once '../../Lenguajes/config.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}
$usuario = new Usuarios('usuarios');
$users = $usuario->getAll()->fetchAll();

$titulo = isset($_POST['apellido']) ? 'Usuarios: (' . $_POST['apellido'] . ')' : 'Usuarios:';
?>

<?php
include "../../Includes/headUsers.php";
?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="Cusers.php?menu=1" class="New_User"><?php echo $lang['Nuevo usuario']?></a>
                <hr>
                <form method="post" class="form-inline">
                    <div class="form-group mr-3">
                        <input type="text" id="apellido" name="apellido" placeholder="Buscar por nickname" class="form-control">
                    </div>
                    <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
                    <button type="submit" name="submit" class="btn btn-primary">Ver resultados</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-3"><?= $titulo ?></h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NickName</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($users && $usuario->getAll()->rowCount() > 0) {
                            foreach ($users as $fila) {
                        ?>
                                <tr>
                                    <td><?php echo escapar($fila["idUsr"]); ?></td>
                                    <td><?php echo escapar($fila["nick"]); ?></td>
                                    <td>
                                        
                                        <a href="<?= 'Cusers.php?menu=2&campo=idUsr&id=' . escapar($fila["idUsr"]) ?>" onclick="return confirmar('<?php echo $lang['confirmacion']; ?>')">🗑️Borrar</a>
                                        <a href="<?= 'Cusers.php?menu=3&id=' . escapar($fila["idUsr"]) ?>">✏️Editar</a>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    <tbody>
                </table>
            </div>
        </div>
    </div>
</body>
