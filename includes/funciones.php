<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function esUltimo(String $actual,String $proximo): bool {
    if($actual !== $proximo){
    return true;
}else{
    return false;
}
}

//función que revisa que el usuario esta autenticado

function estaAuth(): void{
    if(!isset($_SESSION['login'])){
        header('Location: /');
    }
}

//funcion para proteger la cuenta de admin mediante la variable de session
function isAdmin(): void{
    if(!isset($_SESSION['admin'])){
        header('Location: /');
    }
}