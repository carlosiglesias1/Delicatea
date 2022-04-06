<?php
ob_start();

require_once("../../paths/AbsolutePaths.php");
require_once("../../view/back/cabecera.php");
require_once "../../Funciones/funciones.php";
require_once("../../model/DAO/factory/MySQLDAOFactory.php");
$menu = $_GET['menu'];
$factory = new MySQLDAOFactory();
switch ($menu) {
    case 1:
        areUAllowed([1, 2]);
        if (isset($_POST['cancelar'])) {
            header('Location: BCcontrol.php?menu=2&lang=' . $_GET['lang']);
        }
        $marca = $factory->getMarcaDAO();
        if (isset($_POST['submit'])) {
            $valores = array(
                "name" => $_POST['name']
            );
            $marca->addElement($valores);
        }
        require_once("../../view/back/Marcas/VCrearMarca.php");
        break;

    case 2:
        areUAllowed([1, 2]);
        $marca = $factory->getMarcaDAO();
        $selected = unserialize($_GET['selected']);
        try {
            foreach ($selected as $fila) {
                $marca->delete($fila);
            }
            header("Location:" . $_SESSION['INDEX_PATH'] . "controller/back/BCcontrol.php?menu=2&lang=" . $_GET['lang']);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        break;
    case 3:
        areUAllowed([1]);
        if (isset($_POST['cancelar'])) {
            header("Location:" . $_SESSION['INDEX_PATH'] . "controller/back/BCcontrol.php?menu=2&lang=" . $_GET['lang']);
        }
        $marca = $factory->getMarcaDAO();
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
        require_once("../../view/back/Marcas/VCrearMarca.php");
        break;

    default:
        require_once("./BCcontrol.php");
        break;
}
ob_end_flush();
