<?php
ob_start();
require_once("../../paths/AbsolutePaths.php");
require_once($_SESSION['WORKING_PATH'] . "model/DAO/factory/MySQLDAOFactory.php");
require_once($_SESSION['WORKING_PATH'] . "Funciones/funciones.php");
$tarifa = (new MySQLDAOFactory())->getTarifaDAO();
$menu = $_GET['menu'];
switch ($menu) {
    case 1:
        areUAllowed([11]);
        if (isset($_POST['cancelar'])) {
            header('Location: BCcontrol.php?menu=8&lang=' . $_GET['lang']);
        }
        if (isset($_POST['submit'])) {
            try {
                $formula = $_POST['opera'] . $_POST['incremento'] . $_POST['opc'];
                //Esta variable es la suma de las opciones del redondeo y el ajuste, así puedo crear un switch desde el que gestiono todo
                $RA = $_POST['redondeo'] + $_POST['ajuste'];
                $incremento = $_POST['incremento'];
                $insert = $tarifa->addElement($_POST);
                //calculoCostes($_POST, $incremento, $RA, $tarifa,  $insert);
                header('Location: BCcontrol.php?menu=8&lang=' . $_GET['lang']);
            } catch (PDOException $ex) {
                echo "error" . $ex->getMessage();
            }
        }
        require_once($_SESSION['WORKING_PATH'] . "view/back/Tarifas/VCrearTarifa.php");
        break;

    case 2:
        areUAllowed([11]);
        $selected = unserialize($_GET['selected']);
        try {
            foreach ($selected as $fila)
                $tarifa->delete($fila);
            header('Location: BCcontrol.php?menu=8&lang=' . $_SESSION['lang']);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        break;

    case 3:
        require_once("../cabecera.php");
        areUAllowed([11]);
        require_once("../Modelos/Mtarifas.php");
        if (isset($_POST['cancelar'])) {
            header("Location: " . $_SESSION['INDEX_PATH'] . "Back/Controladores/BCcontrol.php?menu=8&lang=" . $_GET['lang']);
        }
        //Llamamos a la funcion de la clase y almacenamos el return en una variable
        $id = $_GET['id'];
        $campos = $tarifa->searchRow($id);
        $RA = $campos['redondeo'] + $campos['ajuste'];
        $campos['opera'] = substr($campos['formula'], 0, 1);
        $campos['opc'] = substr($campos['formula'], strlen($campos['formula']) - 1);
        $campos['coste'] = $campos['origen'];
        if (isset($_POST['submit'])) {
            $formula = substr($campos['formula'], 0, 1) . $_POST['importe'] . substr($campos['formula'], strlen($campos['formula']) - 1);
            try {
                $tarifa->update($id, $formula);
                $tarifa->foreignDelete('tarifasproductos', 'idTarifa', $campos['idTarifa']);
                calculoCostes($campos, $_POST['importe'], $RA, $tarifa, $id);
                header('Location: BCcontrol.php?menu=8&lang=' . $_GET['lang']);
            } catch (PDOException $ex) {
                echo $ex->getMessage();
            }
        }
        require_once("../Vistas/Tarifas/VCrearTarifa.php");
        break;
    case 4:
        areUAllowed([11]);
        $articulo = $tarifa;
        //$tarifaName = $tarifa->searchRow($_GET['idTarifa']);
        $conditional = "idArticulo IN (SELECT idPrd FROM tarifasproductos WHERE idTarifa = " . $_GET['idTarifa'] . ")";
        $prods = $tarifa->getForeignValueString('articulo', $conditional);
        $costeFinal = $tarifa->getForeignValue('tarifasproductos', 'costeFinal', $_GET['idTarifa'], 'idTarifa', 'idPrd');
        if ($prods != null) {
            for ($i = 0; $i < sizeof($prods); $i++) {
                $prods[$i]['costeFinal'] =  $costeFinal[$i]['costeFinal'];
            }
        }
        require_once($_SESSION['WORKING_PATH'] . "view/back/Productos/VProductos.php");
        break;
    default:
        require_once("./BCcontrol.php");
        break;
}
ob_end_flush();
