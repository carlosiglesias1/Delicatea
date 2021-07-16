<?php
$menu = $_GET['menu'];
switch ($menu) {

    case 1:
        require_once("../cabecera.php");
        areUAllowed([1, 2]);
        require_once("../Modelos/Mmarcas.php");
        if (isset($_POST['cancelar'])) {
            header('Location: BCcontrol.php?menu=2&lang=' . $_GET['lang']);
        }
        //Llamar a la clase Marcas
        $marca = new Marcas('marca');
        //Llamamos a la funcion de la clase y almacenamos el return en una variable
        if (isset($_POST['submit']))
            $marca->NewMark();
        require_once("../Vistas/Marcas/VCrearMarca.php");
        break;

    case 2:
        require_once("../cabecera.php");
        areUAllowed([1, 2]);
        require_once("../Modelos/Mmarcas.php");
        $marca = new Marcas('marca');
        $id = intval($_GET['id']);
        try {
            $marca->deleteByID($id);
            header('Location: BCcontrol.php?menu=2&lang=' . $_GET['lang']);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        break;

    case 3:
        require_once("../cabecera.php");
        areUAllowed([1]);
        require_once("../../Funciones/funciones.php");
        require_once("../Modelos/Mmarcas.php");
        if (isset ($_POST['cancelar'])){
            header("Location: ".$_SESSION['INDEX_PATH']."Back/Controladores/BCcontrol.php?menu=2&lang=".$_GET['lang']);
        }
        $marca = new Marcas('marca');
        //Llamamos a la funcion de la clase y almacenamos el return en una variable
        $id = $_GET['id'];
        $campos = $marca->getById($id)->fetch(PDO::FETCH_ASSOC);
        if (isset($_POST['submit']))
            try {
                $marca->updateMark($id);
                header('Location: BCcontrol.php?menu=2&lang=' . $_GET['lang']);
            } catch (PDOException $ex) {
                echo $ex->getMessage();
            }
        require_once("../Vistas/Marcas/VCrearMarca.php");
        break;

    default:
        require_once("./BCcontrol.php");
        break;
}
