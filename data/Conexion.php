<?php
    error_reporting(E_ALL);
    define("cServidor", "localhost");
    define("cUsuario", "root");
    define("cPass","");
    define("cBd","bdpruebatecnica");
    $conectar = mysqli_connect(cServidor, cUsuario, cPass, cBd);
    mysqli_query($conectar,"SET NAMES 'utf8'");
?>