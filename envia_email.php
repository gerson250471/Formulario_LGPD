<?php

// Obtendo os Dados do Formulário
$req =utf8_decode($_POST['txtreq']);
$vce =utf8_decode($_POST['txtvc']);
$nome  =utf8_decode($_POST['txtnome']); 
$cpf  =utf8_decode($_POST['txtCPF']) ;
$email  =utf8_decode($_POST['txtemail']);
$tipo  =utf8_decode($_POST['txtTipo']) ;
$detalhe =utf8_decode($_POST['txtDetalhe']); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);               // Faz o disparo das exceções

try
{
    //Configuração de Serviço
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                     
    $mail->isSMTP();                                           
    $mail->Host       = 'SEU HOST AQUI';                    
    $mail->SMTPAuth   = true;                                  
    $mail->Username   = 'SEU EMAIL AQUI';                    
    $mail->Password   = 'SUA SENHA AQUI';                              
    $mail->SMTPSecure = 'tls';           
    $mail->Port       = 587;
       
    // Configuração de Remetente
    $mail->setFrom('gerson@wcore.com.br', 'Gerson Bernardo');

    // Configuração do Destinatário
    $mail->addAddress('gerson@wcore.com.br', 'Gerson Bernardo');     //Add a recipient
    $mail -> addCC ( "gbds2515@outlook.com",utf8_decode("Gerson Bernardo"));

    // Conteúdo
    $mail->isHTML(true);                              
    $mail->Subject = utf8_decode('Formulário LGPD');
    $mail->Body    = utf8_decode("
    FORMULÁRIO LGPD <br>
    Requisitando =          $req      <br>
    Você é ou foi? =        $vce      <br>
    Nome =                  $nome     <br>
    CPF=                    $cpf      <br>
    Email =                 $email    <br>
    Tipo de Requisição =    " . utf8_encode($tipo) ."     <br>
    Detalhe =               " . utf8_encode($detalhe) ." <br>
    ");
    
    $mail->send();

    echo 'Mensagem Enviada com Sucesso';
} 
catch (Exception $e)
{
   echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}