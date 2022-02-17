<?php
ob_start();
$menu = $_GET['menu'];
switch ($menu) {

    case 1:
        require_once("../cabecera.php");
        areUAllowed([4]);
        require_once("../Modelos/DAO/CategoriaDAO.php");
        if (isset($_POST['cancelar'])) {
            header('Location: BCcontrol.php?menu=5&lang=' . $_GET['lang']);
        }
        //Llamar a la clase Categorias
        $categoria = new CategoriaDAO();
        //Llamamos a la funcion de la clase y almacenamos el return en una variable
        if (isset($_POST['submit']))
            $categoria->;
        require_once("../Vistas/Categorias/VCrearCategoria.php");
        break;

    case 2:
        require_once("../cabecera.php");
        areUAllowed([4]);
        require_once("../Modelos/Mcategorias.php");
        $marca = new Categorias();
        $selected = unserialize($_GET['selected']);
        try {
            foreach($selected as $fila)
                $marca->deleteByID($fila);
            header('Location: BCcontrol.php?menu=5&lang=' . $_GET['lang']);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        break;

    case 3:
        require_once("../cabecera.php");
        areUAllowed([4]);
        require_once("../../Funciones/funciones.php");
        require_once("../Modelos/DAO/CategoriaDAO.php");
        if (isset ($_POST['cancelar'])){
            header("Location: ".$_SESSION['INDEX_PATH']."Back/Controladores/BCcontrol.php?menu=5&lang=".$_GET['lang']);
        }
        $categoria = new CategoriaDAO();
        //Llamamos a la funcion de la clase y almacenamos el return en una variable
        $id = $_GET['id'];
        $campos = $categoria->searchRow($id);
        if (isset($_POST['submit']))
            try {
                $categoria->update($id);
                header('Location: BCcontrol.php?menu=5&lang=' . $_GET['lang']);
            } catch (PDOException $ex) {
                echo $ex->getMessage();
            }
        require_once("../Vistas/Categorias/VCrearCategoria.php");
        break;
    case 4:
        require_once("../cabecera.php");
        areUAllowed([4]);
        require_once("../../Funciones/funciones.php");
        require_once("../Modelos/DAO/CategoriaDAO.php");
        $categoria = new CategoriaDAO();
        //Llamamos a la funcion de la clase y almacenamos el return en una variable
        $id = $_GET['idCat'];
        $nombreCat = $categoria->searchRow($id);
        $subcats = $categoria->getSubcategorias($id);
        require_once("../Vistas/Subcategorias/VSubCategorias.php");
        break;

    default:
        require_once("./BCcontrol.php");
        break;
}
ob_end_flush();