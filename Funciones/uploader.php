<?php
switch ($menu) {
    case 1:
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['images']['name'][$key]) {
                $filename = $_FILES['images']['name'][$key];
                $temporal = $_FILES['images']['tmp_name'][$key];
            }

            if (!file_exists($directorio)) {
                mkdir($directorio, 0777);
            }

            if (file_exists($directorio . "/" . $filename)) {
                $contador = 1;
                if ($handler = opendir($directorio)) {
                    while (false !== ($file = readdir($handler))) {
                        if (substr($file, 0, 1) == "(") {
                            if (substr($file, strpos($file, ")") + 1) == $filename) {
                                $contador++;
                            }
                        }
                    }
                    closedir($handler);
                }
                $target = "$directorio/(" . ($contador) . ")$filename";
            } else {
                $target = "$directorio/$filename";
            }

            if (move_uploaded_file($temporal, $target)) {
                echo "El archivo $filename ha sido subido <br>";
            } else {
                echo "Ha ocurrido un error";
            }
        }
        break;
    case 3:
        /*Compruebo que no ha cambiado las imágenes que ya tenía puestas en el producto
         *que en este caso, con el plugin que usamos estan en la seccion de $_POST['preloaded'],
         *si ha quitado alguna imagen del array de preloaded, se borrará de la carpeta y se enviará al controlador
         *en un array para borrarla de la BD
        */
        $deleteDB = [];
        $insertDb = [];
        if (isset($_POST['preloaded'])) {
            if (sizeof($_POST['preloaded']) < sizeof($imagenes)) {
                for ($i = 0; $i < sizeof($imagenes); $i++) {
                    if (in_array($i, $_POST['preloaded']) == false) {
                        $deleteLink = $imagenes[$i]['path'];
                        $deletePath = substr($deleteLink, 27);
                        $deletePath = $_SESSION['WORKING_PATH'] . $deletePath;
                        array_push($deleteDB, $deleteLink);
                        if (unlink($deletePath)) {
                            echo "exito<br>";
                        }
                        echo $deletePath;
                    }
                }
            }
        } else {
            for ($i = 0; $i < sizeof($imagenes); $i++) {
                $deleteLink = $imagenes[$i]['path'];
                $deletePath = substr($deleteLink, 27);
                $deletePath = $_SESSION['WORKING_PATH'] . $deletePath;
                $deleteDB = [];
                array_push($deleteDB, $deleteLink);
                if (unlink($deletePath)) {
                    echo "exito";
                }
                echo $deletePath;
            }
        }
        print_r($deleteDB);
        /**
         * Con las fotos nuevas (si las hay) realizamos la misma accion que en el caso 1
         */
        if (!empty($_FILES['images']['name'][0])) {
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['images']['name'][$key]) {
                    $filename = $_FILES['images']['name'][$key];
                    $temporal = $_FILES['images']['tmp_name'][$key];
                }

                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777);
                }

                if (file_exists($directorio . "/" . $filename)) {
                    $contador = 1;
                    if ($handler = opendir($directorio)) {
                        while (false !== ($file = readdir($handler))) {
                            if (substr($file, 0, 1) == "(") {
                                if (substr($file, strpos($file, ")") + 1) == $filename) {
                                    $contador++;
                                }
                            }
                        }
                        closedir($handler);
                    }
                    $target = "$directorio/(" . ($contador) . ")$filename";
                } else {
                    $contador = 0;
                    $target = "$directorio/$filename";
                }
                if (move_uploaded_file($temporal, $target)) {
                    echo "exito";
                    if ($contador != 0) {
                        $insertDb[$key] = "($contador)$filename";
                    } else {
                        $insertDb[$key] = $filename;
                    }
                }
            }
        }
        break;
}
