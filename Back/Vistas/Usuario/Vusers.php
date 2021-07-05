<?php
include '../../Funciones/funciones.php';
require_once '../../Lenguajes/config.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}
$usuario = new Usuarios('usuarios');
$users = $usuario->getAll()->fetchAll(PDO::FETCH_ASSOC);
/*print_r($users);
echo "<br>";
orderBy($users, 'nick');
print_r($users);*/
?>

<?php
//include "../../Includes/headUsers.php";
?>
<html>

<head>
    <link href="../Estilos/Bestilo.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#myTable").DataTable({
                language: {
                    url: selectLng()
                }
            });
        });
    </script>
<body>
    <div class="container">
        <div class="row">
        <a href="Cusers.php?menu=1" class="New_User"><?php echo $lang['Nuevo usuario'] ?></a>
        <hr>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-3"><?= $lang['Tabla Usuarios']['Titulo'];?></h2>
                <table id="myTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th><?= $lang['Tabla Usuarios']['ID'];?></th>
                            <th><?= $lang['Tabla Usuarios']['Nickname'];?></th>
                            <th><?= $lang['Tabla Usuarios']['Acciones'];?></th>
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
                                    <td class="options">
                                        <a href="<?= 'Cusers.php?menu=2&campo=idUsr&id=' . escapar($fila["idUsr"]) ?>" onclick="return confirmar('<?php echo $lang['confirmacion']; ?>')">🗑️<?= $lang['Tabla Usuarios']['Borrar'];?></a>
                                        <a href="<?= 'Cusers.php?menu=3&id=' . escapar($fila["idUsr"]) ?>">✏️<?= $lang['Tabla Usuarios']['Editar'];?></a>
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

</html>