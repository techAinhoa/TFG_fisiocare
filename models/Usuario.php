<?php
namespace Model;
include_once __DIR__."/../vendor/autoload.php";

class Usuario extends ActiveRecord{
    //base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id','nombre','apellido', 'email','password','telefono','admin','confirmado','token'];
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []){
        
        $this-> id = $args['id'] ?? null;
        $this-> nombre = $args['nombre'] ?? '';
        $this-> apellido = $args['apellido'] ?? '';
        $this-> email = $args['email'] ?? '';
        $this-> password = $args['password'] ?? '';
        $this-> telefono = $args['telefono'] ?? '';
        $this-> admin = $args['admin'] ?? '0';
        $this-> confirmado = $args['confirmado'] ?? '0';
        $this-> token = $args['token'] ?? '';
    }
        //Mensajes de validación  para la creación de una nueva cuenta
        public function validarNuevaCuenta(){
           if(!$this->nombre){
            self::$alertas['error'][]='El nombre es obligatorio';
           } 
           if(!$this->apellido){
            self::$alertas['error'][]='El apellido es obligatorio';
           } 
           if(!$this->email){
            self::$alertas['error'][]='El email es obligatorio';
           } 
           if(!$this->password){
            self::$alertas['error'][]='La contraseña es obligatoria';
           }elseif(strlen($this->password < 6)){
               self::$alertas['error'][]="El password debe contener al menos 6 carateres" ;
            } elseif (!preg_match('/[A-Z]/', $this->password)) {
                self::$alertas['error'][] = 'La contraseña debe contener al menos una letra mayúscula';
            } 
           if(!$this->telefono){
            self::$alertas['error'][]='El telefono es obligatorio';
           } 
           
           return self::$alertas;
    }

    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][] = 'El email es Obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'El password es Obligatorio';
        }

        return self::$alertas;
    }

    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][] = 'El email es Obligatorio';
        }
        return self::$alertas;
    }

    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][]='La contraseña es obligatoria';
        }
        if(strlen($this->password) < 6){
            self::$alertas['error'][]='La contraseña debe de tener al menos 6 caracteres';

        }elseif (!preg_match('/[A-Z]/', $this->password)) {
                self::$alertas['error'][] = 'La contraseña debe contener al menos una letra mayúscula';
            } 
        return self::$alertas;
}

   // comprobar si ya existe ese email en la base de datos 
    public function existeUsuario(){
        $query ="SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);
        if($resultado->num_rows){
            self::$alertas['error'][]='El usuario ya esta registrado';
        }
        return $resultado;
       
    }
  
    //hashear la contraseña para guardarla en la base de datos
    public function hashPassword() {

        $this->password = password_hash($this->password,PASSWORD_BCRYPT);
    }
    //crear un token para comprobar el email
    public function crearToken() {
        $this->token = uniqid();
    }
    public function comprobarPassVerificacion($password){
    
        $resultado = password_verify($password, $this->password);
        if(!$resultado || !$this->confirmado){
           self::$alertas['error'][]='Password Incorrecto o tu cuenta todavía no ha sido confirmada';
        } else {
            return true;
        }
    }
}

?>