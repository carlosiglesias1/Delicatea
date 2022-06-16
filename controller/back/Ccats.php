<?php
ob_start();

require("../../paths/AbsolutePaths.php");
require_once("../../view/back/cabecera.php");
require_once("../../Funciones/funciones.php");
require_once("../../model/DAO//factory/MySQLDAOFactory.php");
$menu = $_GET['menu'];
$factory = new MySQLDAOFactory();
switch ($menu) {
    case 1:
        areUAllowed([4]);
        $marca = $factory->getCategoriaDAO();
        if (isset($_POST['submit'])) {
            $valores = [
                "nombre" => $_POST["name"],
                "descripcion" => $_POST["descripcion"]
            ];
            $marca->addElement($valores);
            header('Location: BCcontrol.php?menu=5&lang=es');
        }
        if (isset($_POST['cancelar'])) {
            header('Location: BCcontrol.php?menu=5&lang=' . $_GET['lang']);
        }
        require_once("../../view/back/Categorias/VCrearCategoria.php");
        break;

    case 2:
        areUAllowed([4]);
        $marca = $factory->getCategoriaDAO();
        $selected = unserialize($_GET['selected']);
        try {
            foreach ($selected as $fila) {
                $marca->delete($fila);
            }
            header('Location: BCcontrol.php?menu=5&lang=' . $_GET['lang']);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        break;

    case 3:
        areUAllowed([4]);
        if (isset($_POST['cancelar'])) {
            header("Location: " . $_SESSION['INDEX_PATH'] . "controller/back/BCcontrol.php?menu=5&lang=" . $_GET['lang']);
        }
        $categoria = $factory->getCategoriaDAO();
        $id = $_GET['id'];
        $campos = $categoria->searchRow($id);
        if (isset($_POST['submit'])) {
            try {
                $valores = [
                    "nombre" => $_POST["name"],
                    "descripcion" => $_POST["descripcion"]
                ];
                $categoria->update($id, $valores);
                header('Location: BCcontrol.php?menu=5&lang=' . $_GET['lang']);
            } catch (PDOException $ex) {
                echo $ex->getMessage();
            }
        }
        require_once("../../view/back/Categorias/VCrearCategoria.php");
        break;
    case 4:
        areUAllowed([4]);
        header("Location: BCcontrol.php?menu=4&idCat=" . $_GET['idCat'] . "&lang=" . $_GET['lang']);
        break;
    default:
        require_once("./BCcontrol.php");
        break;
}
ob_end_flush();
