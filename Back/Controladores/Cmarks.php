<?php
ob_start();
$menu = $_GET['menu'];
switch ($menu) {

    case 1:
        require_once("../cabecera.php");
        areUAllowed([1, 2]);
        require_once("../Modelos/DAO/MarcaDAO.php");
        if (isset($_POST['cancelar'])) {
            header('Location: BCcontrol.php?menu=2&lang=' . $_GET['lang']);
        }
        //Llamar a la clase Marcas
        $marca = new MarcaDAO('marca');

        //Llamamos a la funcion de la clase y almacenamos el return en una variable
        if (isset($_POST['submit'])) {
            $valores = array(
                "name" => $_POST['name']
            );
            $marca->NewMark($valores);
        }
        require_once("../Vistas/Marcas/VCrearMarca.php");
        break;

    case 2:
        require_once("../cabecera.php");
        areUAllowed([1, 2]);
        require_once("../Modelos/DAO/MarcasDAO.php");
        $marca = new MarcaDAO();
        $selected = unserialize($_GET['selected']);
        try {
            foreach ($selected as $fila) {
                $marca->delete($fila);
            }
            header("Location:" . $_SESSION['INDEX_PATH'] . "Back/Controladores/BCcontrol.php?menu=2&lang=" . $_GET['lang']);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        break;

    case 3:
        require_once("../cabecera.php");
        areUAllowed([1]);
        require_once("../Modelos/DAO/MarcaDAO.php");
        if (isset($_POST['cancelar'])) {
            header("Location:" . $_SESSION['INDEX_PATH'] . "Back/Controladores/BCcontrol.php?menu=2&lang=" . $_GET['lang']);
        }
        $marca = new MarcaDAO('marca');
        //Llamamos a la funcion de la clase y almacenamos el return en una variable
        $id = intval($_GET['id']);
        $campos = $marca->searchRow($id);
        if (isset($_POST['submit'])) {
            try {
                $valores = [
                    "nombre" => $_POST['name']
                ];
                $marca->update($id, $valores);
                header('Location: BCcontrol.php?menu=2&lang=' . $_GET['lang']);
            } catch (PDOException $ex) {
                echo $ex->getMessage();
            }
        }
        require_once("../Vistas/Marcas/VCrearMarca.php");
        break;

    default:
        require_once("./BCcontrol.php");
        break;
}
ob_end_flush();
