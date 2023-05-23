<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Server Config
require './config-mail.php';

// Load Composer's autoloader
require  '../../../../vendor/autoload.php';

// Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

// Google Capcha
$token = $_POST['token'];
$action = $_POST['action'];

try {
    //Envío de Email
    if (!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["subject"]) && !empty($_POST["msg"])) {

        // Comprobamos que acepta la politica de privacidad
        $politic = (bool)$_POST["politic"];
        if (!$_POST["politic"]) {
            echo MSG_POLITIC;
            exit;
        } else {

            // call curl to POST request
            // Verificamos el capcha Google
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => SECRET_KEY_RECAPCHA, 'response' => $token)));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $arrResponse = json_decode($response, true);

            //Recojo los datos
            $name = ucwords(mb_convert_case($_POST["name"], MB_CASE_LOWER, "UTF-8"));
            $email = mb_convert_case($_POST["email"], MB_CASE_LOWER, "UTF-8");
            $phone = mb_convert_case($_POST["phone"], MB_CASE_LOWER, "UTF-8");
            $subject = mb_convert_case($_POST["subject"], MB_CASE_LOWER, "UTF-8");
            $message = mb_convert_case($_POST["msg"], MB_CASE_LOWER, "UTF-8");
            //
            $form = "";
            $form .= "<strong>Nombre:</strong> " . $name . "<br/>";
            $form .= "<strong>Email:</strong> " . $email . "<br/>";
            $form .= "<strong>Teléfono:</strong> " . $phone . "<br/>";
            $form .= "<strong>Asunto:</strong> " . $subject . "<br/>";
            $msg_format = str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br />", $message);
            $form .= "<strong>Mensaje:</strong> " . $msg_format . "<br/>";



            if ($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.5) {

                // Server settings
                $mail->isSMTP();
                $mail->SMTPDebug  = (MAIL_TEST) ? SMTP::DEBUG_SERVER : SMTP::DEBUG_OFF;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable implicit TLS encryption
                //
                $mail->Host       = MAIL_HOST;                              // Set the SMTP server to send through
                $mail->SMTPAuth   = MAIL_SMTPAUTH;                          // Enable SMTP authentication
                $mail->Username   = MAIL_USERNAME;                          // SMTP username
                $mail->Password   = MAIL_PASSWORD;                          // SMTP password
                $mail->Port       = MAIL_PORT;                              // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                $mail->CharSet    = MAIL_CHARSET;

                // Recipients
                $mail->setFrom(MAIL_SETFROM['to'], MAIL_SETFROM['name']);
                $sentAddress = (MAIL_TEST) ? MAIL_TEST_ADDADRESS : MAIL_ADDADRESS;
                $mail->addAddress($sentAddress['to'], $sentAddress['name']);

                // Content
                $mail->isHTML(true);
                $headers = "Content-Type: text/html; charset=UTF-8";                      // Set email format to HTML
                $mail->Subject = MAIL_SUBJECT;

                // Template
                $html5 = MAIL_TEMPLATE_HEADER;

                // Contenido Capturado
                $html5 .= $form;

                // Template
                $html5 .= MAIL_TEMPLATE_FOOTER;

                // Send
                $mail->Body = $html5;

                try {
                    $mail->send();
                    echo MSG_SUCCESS;
                    exit;
                } catch (Exception $e) {
                    echo MSG_ERROR500;
                    exit;
                }
            } else {
                echo MSG_SPAM;
                exit;
            }
        }
    } else {
        echo MSG_INCOMPLETE;
        exit;
    }
} catch (Exception $e) {
    echo MSG_ERROR501;
    exit;
}
