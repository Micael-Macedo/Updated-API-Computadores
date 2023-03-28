<?php
include_once('C:/xampp/htdocs/AlatechMachines/helper/jwt/senha.php');
include_once('C:/xampp/htdocs/AlatechMachines/helper/jwt/token.php');
include_once('C:/xampp/htdocs/AlatechMachines/helper/db/DataBase.php');
include_once('C:/xampp/htdocs/AlatechMachines/helper/compatibilidadePC.php');

$header = getallheaders();
$jwt = new MyJWT();
if($header['Authorization'] != ''){
    if($jwt->decode($header['Authorization'], SENHA) != false){
        $autenticado = true;
    }
}

