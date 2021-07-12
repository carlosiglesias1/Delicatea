<?php
    include '../Back/cabecera.php';
    echo getcwd()."<br>";
    echo __FILE__ . "<br>";
    echo $_SERVER['HTTP_HOST'] . "<br>";
    echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']. "<br>";
    echo $_SERVER['PHP_SELF'];
