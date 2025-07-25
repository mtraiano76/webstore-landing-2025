<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mensaje_estado = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = strip_tags($_POST['nombre']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $telefono = strip_tags($_POST['telefono']);
    $mensaje = strip_tags($_POST['mensaje']);

    $mail = new PHPMailer(true);
    try {
        // Configuración SMTP
        $mail->isSMTP();
        $mail->Host = 'cva12.toservers.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'desarrollo@web-store.com.ar';
        $mail->Password = 'migyshe101723';
        $mail->Port = 26;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        // Remitente y destinatario
        $mail->setFrom('desarrollo@web-store.com.ar', 'Formulario Web Store');
        $mail->addAddress('desarrollo@web-store.com.ar');
        $mail->addReplyTo($email, $nombre);

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje de la web';
        $mail->Body    = "<b>Nombre:</b> $nombre<br><b>Email:</b> $email<br><b>Teléfono:</b> $telefono<br><b>Mensaje:</b> $mensaje";
        $mail->AltBody = "Nombre: $nombre\nEmail: $email\nTeléfono: $telefono\nMensaje: $mensaje";

        $mail->send();
        $mensaje_estado = "exito";
    } catch (Exception $e) {
        $mensaje_estado = "error";
        $error = $mail->ErrorInfo;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contacto - Web Store</title>
    <link rel="stylesheet" href="style.css">
    <style>
      body {background: linear-gradient(to right, #2c5364, #203a43, #0f2027);color: white;}
      .container-mensaje{max-width: 520px;margin: 80px auto 0 auto;padding: 48px 24px;background: #101d24d4;border-radius: 18px;box-shadow: 0 8px 32px #0005;text-align:center;}
      .msg-exito{color:#fff;background:#38b000;padding:18px 0;font-weight:600;font-size:1.3rem;border-radius:9px;margin-bottom:32px;}
      .msg-error{color:#fff;background:#d90429;padding:18px 0;font-weight:600;font-size:1.2rem;border-radius:9px;margin-bottom:32px;}
      a {color:#00c6ff;font-size:1.1rem;text-decoration:underline;}
      a:hover {color:#fff;}
    </style>
</head>
<body>
<div class="container-mensaje">
    <?php if($mensaje_estado=="exito"): ?>
        <div class="msg-exito">Mensaje enviado correctamente.</div>
        <a href="index.html">Volver al sitio</a>
    <?php elseif($mensaje_estado=="error"): ?>
        <div class="msg-error">Error al enviar el mensaje: <?php echo htmlspecialchars($error); ?></div>
        <a href="index.html">Volver al sitio</a>
    <?php endif; ?>
</div>
</body>
</html>
