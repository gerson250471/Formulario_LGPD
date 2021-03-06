<?php

// Gerar Nº do envio

if (file_exists('contagem.php')) {
    include('contagem.php');
}
// Salva o proximo número no contagem.php (apagando a informação anterior e salvando o proximo número).
file_put_contents('contagem.php', '<?php $contagem=' . ((int)$contagem + 1) . ' ?>');

$os = 'OS: ' . date("Ymd") . str_pad($gerador = (int)$contagem, 5, '0', STR_PAD_LEFT);

// Obtendo os Dados do Formulário
$req = utf8_decode($_POST['txtreq']);
$vce = utf8_decode($_POST['txtvc']);
$nome  = utf8_decode($_POST['txtnome']);
$cpf  = utf8_decode($_POST['txtCPF']);
$email  = utf8_decode($_POST['txtemail']);
$tipo  = utf8_decode($_POST['txtTipo']);
$detalhe = utf8_decode($_POST['txtDetalhe']);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);               // Faz o disparo das exceções
if (ValidarCPF($cpf)) {
    try {
        //Configuração de Serviço
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                     
        $mail->isSMTP();
        $mail->Host       = 'seu host aqui';
        $mail->SMTPAuth   = "xxxx";
        $mail->Username   = 'seu username aqui';
        $mail->Password   = 'sua senha aqui';
        $mail->SMTPSecure = 'XXXX';
        $mail->Port       = 'XXXXX';

        // Configuração de Remetente
        $mail->setFrom('gerson@wcore.com.br', 'Gerson Bernardo');

        // Configuração do Destinatário
        $mail->addAddress('gerson@wcore.com.br', 'Gerson Bernardo');     //Add a recipient
        $mail->addCC("gbds2515@outlook.com", utf8_decode("Gerson Bernardo"));

        // Conteúdo
        $mail->isHTML(true);
        $mail->Subject = utf8_decode('Formulário LGPD');
        $mail->Body    = utf8_decode("
    <br>
    Requisição Nº $os<br>
    =====================================<br>
    FORMULÁRIO LGPD <br>
    =====================================<br>
    Requisitando =          $req      <br>
    Você é ou foi? =        $vce      <br>
    Nome =                  $nome     <br>
    CPF=                    $cpf      <br>
    Email =                 $email    <br>
    Tipo de Requisição =    " . utf8_encode($tipo) . "     <br>
    Detalhe =               " . utf8_encode($detalhe) . " <br>
    ");

        $mail->send();
        echo 'Mensagem Enviada com Sucesso';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    print "Número do CPF inválido! <br/><br/>";
    print "<a href='javascript:history.go(-1)'>Clique aqui para corrigir o Nº do CPF</a>";
}


function validarCPF($number)
{

    $cpf = preg_replace('/[^0-9]/', "", $number);

    if (strlen($cpf) != 11 || preg_match('/([0-9])\1{10}/', $cpf)) {
        return false;
    }

    $number_quantity_to_loop = [9, 10];

    foreach ($number_quantity_to_loop as $item) {

        $sum = 0;
        $number_to_multiplicate = $item + 1;

        for ($index = 0; $index < $item; $index++) {

            $sum += $cpf[$index] * ($number_to_multiplicate--);
        }

        $result = (($sum * 10) % 11);

        if ($cpf[$item] != $result) {
            return false;
        }
    }
    return true;
}
