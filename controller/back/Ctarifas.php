<?php
ob_start();
$menu = $_GET['menu'];
switch ($menu) {

    case 1:
        require_once("../cabecera.php");
        areUAllowed([11]);
        require_once("../Modelos/Mtarifas.php");
        if (isset($_POST['cancelar'])) {
            header('Location: BCcontrol.php?menu=8&lang=' . $_GET['lang']);
        }
        //Llamar a la clase Tarifas
        $tarifa = new Tarifa();
        //Llamamos a la funcion de la clase y almacenamos el return en una variable
        if (isset($_POST['submit'])) {
            try {
                $formula = $_POST['opera'] . $_POST['incremento'] . $_POST['opc'];
                //Esta variable es la suma de las opciones del redondeo y el ajuste, así puedo crear un switch desde el que gestiono todo
                $RA = $_POST['redondeo'] + $_POST['ajuste'];
                $incremento = $_POST['incremento'];
                $insert = $tarifa->newTarifa($formula);
                calculoCostes($_POST, $incremento, $RA, $tarifa,  $insert);
                header('Location: BCcontrol.php?menu=8&lang=' . $_GET['lang']);
            } catch (PDOException $ex) {
                echo "error" . $ex->getMessage();
            }
        }
        require_once("../Vistas/Tarifas/VCrearTarifa.php");
        break;

    case 2:
        require_once("../cabecera.php");
        areUAllowed([11]);
        require_once("../Modelos/Mtarifas.php");
        $tarifa = new Tarifa();
        $selected = unserialize($_GET['selected']);
        try {
            foreach($selected as $fila)
                $tarifa->deleteByID($fila);
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
        $tarifa = new Tarifa();
        //Llamamos a la funcion de la clase y almacenamos el return en una variable
        $id = $_GET['id'];
        $campos = $tarifa->getById($id);
        $RA = $campos['redondeo'] + $campos['ajuste'];
        $campos['opera'] = substr($campos['formula'], 0, 1);
        $campos['opc'] = substr($campos['formula'], strlen($campos['formula']) - 1);
        $campos['coste'] = $campos['origen'];
        if (isset($_POST['submit'])) {
            $formula = substr($campos['formula'], 0, 1) . $_POST['importe'] . substr($campos['formula'], strlen($campos['formula']) - 1);
            try {
                $tarifa->updateTarifa($id, $formula);
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
        require_once("../cabecera.php");
        areUAllowed([11]);
        require_once("../Modelos/Mtarifas.php");
        $articulo = new Tarifa();
        $conditional = "idArticulo IN (SELECT idPrd FROM tarifasproductos WHERE idTarifa = " . $_GET['idTarifa'] . ")";
        $prods = $articulo->getForeignValueString('articulo', $conditional)->fetchAll(PDO::FETCH_ASSOC);
        $costeFinal = $articulo->getForeignValue('costeFinal', 'tarifasproductos', $_GET['idTarifa'], 'idTarifa', 'idPrd');
        for ($i = 0; $i < sizeof($prods); $i++) {
            $prods[$i]['costeFinal'] =  $costeFinal[$i]['costeFinal'];
        }
        require_once("../Vistas/Productos/VProductos.php");
        break;
    default:
        require_once("./BCcontrol.php");
        break;
}
ob_end_flush();
