<?php
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = "es";
} else if (isset($_GET['lang']) && $_SESSION['lang'] != $_GET['lang'] && !empty($_GET['lang'])) {
    if ($_GET['lang'] == "es")
        $_SESSION['lang'] = "es";
    else if ($_GET['lang']  == "en")
        $_SESSION['lang'] = "en";
    else if ($_GET['lang']  == "it")
        $_SESSION['lang'] = "it";
    else if ($_GET['lang']  == "gl")
        $_SESSION['lang'] = "gl";
}
require_once  $_SESSION['lang'] . ".php";
