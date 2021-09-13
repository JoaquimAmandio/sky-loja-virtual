<?php

namespace core\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EnviarEmail
{
    public function enviar_email_de_confirmacao($email_cliente, $purl)
    {
        $mail = new PHPMailer(true);
        //constroi o purl (link para validação do email)
        $link = BASE_URL . '?a=confirmar_email&purl=' . $purl;

        try {
            //Opções do servidor
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_FROM;
            $mail->Password   = EMAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet = 'utf-8';

            //Emissor e receptor
            $mail->setFrom(EMAIL_FROM);
            $mail->addAddress($email_cliente);

            // Assunto
            $mail->isHTML(true);
            $mail->Subject = APP_NAME . '- Confirmação de email.';
            //mensagem
            $html = '<p> ola ' . '<b>' . $_POST['text_nome_completo'] . '</b>' . ' seja bem-vindo ao   ' . APP_NAME . '</p>';
            $html .= '<p> para poder entrar no nosso site, necessita confirmar o seu email </p>';
            $html .= '<p>para confirmar o seu email clique no link abaixo:</p>';
            $html .= '<p> <a href="' . $link . '">Confirmar Email </a></p>';
            $html .= '<p><i><small>' . APP_NAME . ' </small></i></p>';

            $mail->Body    = $html;


            $mail->send();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function enviar_email_confirmacao_encomenda($email_cliente, $dados_encomenda)
    {
        $mail = new PHPMailer(true);


        try {
            //Opções do servidor
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_FROM;
            $mail->Password   = EMAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet = 'utf-8';

            //Emissor e receptor
            $mail->setFrom(EMAIL_FROM);
            $mail->addAddress($email_cliente);

            // Assunto
            $mail->isHTML(true);
            $mail->Subject = APP_NAME . '- Confirmação de encomenda -' . $dados_encomenda['dados_pagamento']['codigo_encomenda'];
            //mensagem
            $html = '<p>Este email serve para confirmar a sua encomenda</p>';
            $html .= '<p>Dados da encomenda:</p>';
            //lista dos produtos
            $html .= '<ul>';
            foreach ($dados_encomenda['lista_produtos'] as $produto) {
                $html .= '<li>' . $produto . '</li>';
            }
            $html .= '</ul>';
            //total
            $html .= '<p>Total:<strong> ' . $dados_encomenda['total'] . ' </strong></p>';

            //dados pagamento
            $html .= '<hr>';
            $html .= '<p>Dados de Pagamento</p>';
            $html .= '<p>Banco Atlantico Iban:<strong>' . iBAN_CONTA . '</strong></p>';
            $html .= '<p>Código da Encomenda:<strong>' .  $dados_encomenda['dados_pagamento']['codigo_encomenda'] . '</strong></p>';
            $html .= '<p>Valor a pagar:<strong>' . $dados_encomenda['total'] . '</strong></p>';
            $html .= '<hr>';
            //nota importante
            $html .= '<p>Nota a sua encomenda só será processada após pagamento.</p>';



            $mail->Body = $html;


            $mail->send();

            return true;
        } catch (\Throwable $th) {

            return false;
        }
    }
}
