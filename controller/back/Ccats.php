<?php
ob_start();

require_once("../../view/back/cabecera.php");
require_once("../../Funciones/funciones.php");
$menu = $_GET['menu'];
switch ($menu) {

    case 1:
        areUAllowed([4]);
        //Llamar a la clase Categorias
        $marca = new CategoriaDAO();
        //Llamamos a la funcion de la clase y almacenamos el return en una variable
        if (isset($_POST['submit'])) {
            $valores = [
                "nombre" => $_POST["name"],
                "descripcion" => $_POST["descripcion"]
            ];
            $marca->addElement($valores);
        }
        if (isset($_POST['cancelar'])) {
            header('Location: BCcontrol.php?menu=5&lang=' . $_GET['lang']);
        }
        require_once("../Vistas/Categorias/VCrearCategoria.php");
        break;

    case 2:
        areUAllowed([4]);
        $marca = new CategoriaDAO();
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
            header("Location: " . $_SESSION['INDEX_PATH'] . "Back/Controladores/BCcontrol.php?menu=5&lang=" . $_GET['lang']);
        }
        $categoria = new CategoriaDAO();
        //Llamamos a la funcion de la clase y almacenamos el return en una variable
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
        require_once("../Vistas/Categorias/VCrearCategoria.php");
        break;
    case 4:
        areUAllowed([4]);
        header("Location: BCcontrol.php?menu=4&lang=es&idCat=" . $_GET['idCat']);
        break;
    default:
        require_once("./BCcontrol.php");
        break;
}
ob_end_flush();
