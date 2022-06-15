<?php 

require "./bibliotecas/PHPMailer/Exception.php";
require "./bibliotecas/PHPMailer/OAuth.php";
require "./bibliotecas/PHPMailer/PHPMailer.php";
require "./bibliotecas/PHPMailer/POP3.php";
require "./bibliotecas/PHPMailer/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Mensagem {
    private $para = null;
    private $assunto = null;
    private $mensagem = null;

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function mensagemValida(){
        if(empty($this->para) || empty($this->assunto) || empty($this->mensagem) ){
            return false;
        }
        return true;
    }

}

$mensagem = new Mensagem();

$mensagem->__set('para', $_POST['para']);
$mensagem->__set('assunto', $_POST['assunto']);
$mensagem->__set('mensagem', $_POST['mensagem']);

//print_r($mensagem);

if(!$mensagem->mensagemValida()){
    echo 'Mensagem não é válida';
    
}


$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 2;                                        //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp-relay.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'phpmaileradami@gmail.com';                     //SMTP username
    $mail->Password   = 'phpmaileradami96';                               //SMTP password
    $mail->SMTPSecure = 'tls';                       //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    $mail->oauthUserEmail = "[Redacted]@gmail.com";
    $mail->oauthClientId = "[Redacted]";
    $mail->oauthClientSecret = "[Redacted]";
    $mail->oauthRefreshToken = "[Redacted]";
    //Recipients
    $mail->setFrom('phpmaileradami@gmail.com', 'PHP MAILER');
    $mail->addAddress($mensagem->__get('para'));     //Add a recipient
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
   // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'oi eu sou o assunto';
    $mail->Body    = '<strong>Eu sou o conteúdo</strong>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Não foi possível enviar o e-mail! Em breve será solucionado. Detalhes do erro: {$mail->ErrorInfo}";
    }