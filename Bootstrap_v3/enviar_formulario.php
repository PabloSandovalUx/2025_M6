<?php
// Activar errores para depuración (quítalo en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Comprobar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitizar datos del formulario
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $correo = filter_var(trim($_POST['mail']), FILTER_SANITIZE_EMAIL);
    $mensaje = htmlspecialchars(trim($_POST['mensaje']));

    // Validar campos
    if (empty($nombre) || empty($correo) || empty($mensaje)) {
        echo "Por favor completa todos los campos.";
        exit;
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo "El correo ingresado no es válido.";
        exit;
    }

    // Configuración del correo
    $destinatario = "pablosandoval.ux@gmail.com";
    $asunto = "Nuevo mensaje desde el formulario web";

    $contenido = "
    Has recibido un nuevo mensaje desde tu sitio web:

    Nombre: $nombre
    Email: $correo
    Mensaje:
    $mensaje
    ";

    $headers = "From: $nombre <$correo>\r\n";
    $headers .= "Reply-To: $correo\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Enviar correo
    if (mail($destinatario, $asunto, $contenido, $headers)) {
        echo "✅ Tu mensaje fue enviado correctamente. ¡Gracias por contactarme!";
    } else {
        echo "❌ Ocurrió un error al enviar tu mensaje. Intenta nuevamente más tarde.";
    }
} else {
    echo "Acceso no permitido.";
}
?>