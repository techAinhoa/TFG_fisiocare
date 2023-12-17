<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($nombre, $email, $token){

        $this->nombre=$nombre;
        $this->email=$email;
        $this->token=$token;
    }

    public function enviarConfirmacion(){
    
        $mail = new PHPMailer();

        //Configurar el SMTP
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->SMTPSecure = 'tls';
        
        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        //Contenido del mail

        $mail->setFrom('tech.ainhoa@gmail.com');
        $mail->addAddress('tech.ainhoa@gmail.com','FisioCare.com');
        $mail->Subject ='Confirma tu cuenta';
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola "  . $this->nombre . "</strong>";
        $contenido .= "<p> Bienvenido a FisioCare tu portal de citas, para empezar 
        a disfrutar de los servicios que te ofrecemos solo debes confirmar tu cuenta en el siguiente enlace -> </p>";
        $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar cuenta</a></p>";
        $contenido .= "<p>Si no solicitates esta cuenta, por favor ignora este mensaje.</p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;

        //Enviar email

        $mail->send();
    }
public function enviarInstrucciones(){

        $mail = new PHPMailer();
        //Configurar el SMTP
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->SMTPSecure = 'tls';
        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        //Contenido del mail

        $mail->setFrom('tech.ainhoa@gmail.com');
        $mail->addAddress('tech.ainhoa@gmail.com','FisioCare.com');
        $mail->Subject ='Restablece tu cuenta';
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola "  . $this->nombre . "</strong>";
        $contenido .= "<p> Has solicitado restablecer tu password </p>";
        $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "'>Restablece tu cuenta</a></p>";
        $contenido .= "<p>Si no solicitates este restablecimiento de cuenta, por favor ignora este mensaje.</p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;

        //Enviar email

        $mail->send();
    }
}
?>