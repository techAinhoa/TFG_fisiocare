<?php

namespace Controllers;

include_once __DIR__ . "/../vendor/autoload.php";

use Classes\Email;
use Model\Usuario;
use MVC\Router;


class LoginController

{
    
    //comprobando los datos introducidos por el login    
    public static function login(Router $router)
    {
        $alertas = [];
        //le pasamos los datos por post 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //instanciamos un nuevo objeto de usuario con los datos recibidos por post
            $auth = new Usuario($_POST);
            //validamos que no esten los campos vacios
            $alertas =  $auth->validarLogin();

            //si no existen mensajes de alerta
            if (empty($alertas)) {
                //comprobamos que existe el usuario
                $usuario =  Usuario::where('email', $auth->email);

                if ($usuario) {
                    //verficar contraseña
                    if ($usuario->comprobarPassVerificacion($auth->password)) {

                        //auth de usuario
                        session_start();

                        $_SESSION['id'] =  $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        
                        if ($usuario->admin === "1") {
                            $_SESSION['admin'] = $usuario->admin ==  null;  
                            header('Location: /admin');
                        } else {
                            header('Location:/cita');
                        }
                    }
                } else {
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/login',
                                 [
            'alertas' => $alertas
        ]);
    }
    public static function logout()
    {
    estaAuth();
        session_start();
        $_SESSION=[];
        header('Location: /');
    }
    public static function olvidarPass(Router $router)
    {

        $alertas = [];
        //recibimos el email mediante post he instanciamos el objeto para que nos lo devuelva
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            $alertas = $auth->validarEmail();

            //si no existe la alerta de que el campo email está vacio 
            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);
                //compruebame y el email que ha llegado por post existe o esta confirmado 
                if ($usuario && $usuario->confirmado === "1") {
                    //generamos un token nuevo para recuprar la contraseña

                    $usuario->crearToken();
                    $usuario->guardar();

                    //Enviar el email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarInstrucciones();

                    //alerta de existo
                    Usuario::setAlerta('exito', 'Revisa tu email');
                    $alertas = Usuario::getAlertas();
                } else {
                    Usuario::setAlerta('error', 'El usuario no esta confirmado');
                    $alertas = Usuario::getAlertas();
                }
            }
        }


        $router->render('auth/olvidarPass', ['alertas' => $alertas]);
    }

    public static function recuperar(Router $router)
    {

        $alertas = [];
        $error = false;
        $token = s($_GET['token']);

        //Buscar usuario por su token
        $usuario = Usuario::where('token', $token);
        //si usuario esta vacio o el token es erroneo
        if (empty($usuario)) {

            //enviamos la alerta a la vista
            Usuario::setAlerta('error', 'Token no válido');
            $error = true;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Leer el nuevo password y guardarlo

            //pasamos los datos de la contraseña mediante post
            $password = new Usuario($_POST);
            //comprobamos con la validaciones 
            $alertas = $password->validarPassword();
            //si alertas esta vacio
            if(empty($alertas)){
                //ponemos la contraseña a null
                $usuario->password =null;
                //le pasamos la contraseña que recibimos por post
                $usuario->password = $password->password;
                //la hasheamos
                $usuario->hashPassword();
                //ponemos el token a null
                $usuario->token=null;
                //y guardamos los datos actulizados en la base de datos
               $resultado = $usuario->guardar();  
                if($resultado) {
                   
                    header('Location: /');
                     Usuario::setAlerta('exito', 'Contraseña cambiada correctamente');

                }  

            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }
    public static function crearCuenta(Router $router)
    {
        $usuario = new Usuario;
        //alertas vacias
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            //Validación correctas no hay alertas que mostrar
            if (empty($alertas)) {
                //verifica que el usuario no esta vacío

                $resultado = $usuario->existeUsuario();

                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    $usuario->hashPassword();

                    $usuario->crearToken();

                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);

                    $email->enviarConfirmacion();

                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                    //debuguear($usuario);
                }
            }
        }


        $router->render('auth/crearCuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
    public static function mensaje(Router $router)
    {

        $router->render('auth/mensaje');
    }
    public static function confirmar(Router $router)
    {

        $alertas = [];

        //sanitizamos y obtenemos el token
        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);


        if (empty($usuario)) {
            //Mensaje de error si el token no es válido
            Usuario::setAlerta('error', 'Token no válido');
        } else {
            $usuario->confirmado = '1';
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente');
        }

        //cargamos las alertas para mostrarlas por la vista
        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}
