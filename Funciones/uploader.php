<?php
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
