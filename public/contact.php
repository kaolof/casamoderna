<?php
/**
 * Contact Form Handler
 * 
 * Este script maneja el envío de formularios de contacto desde la aplicación Vue.
 * Recibe datos POST, los valida, sanitiza y envía un correo electrónico.
 * 
 * CONFIGURACIÓN IMPORTANTE:
 * - Cambia el valor de $to_email con tu dirección de correo real
 * - Asegúrate de que tu hosting tenga la función mail() habilitada
 */

// Configuración de cabeceras para permitir CORS y respuestas JSON
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *'); // En producción, considera especificar tu dominio exacto
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Manejo de solicitudes preflight (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Solo aceptar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido. Use POST.'
    ]);
    exit();
}

// ============================================================================
// CONFIGURACIÓN - Cambia estos valores según tus necesidades
// ============================================================================

// Dirección de correo donde recibirás los mensajes
$to_email = 'info@construcasamoderna.com';

// Asunto del correo
$email_subject = 'Nuevo mensaje de contacto desde Construservicios Casamoderna';

// ============================================================================
// VALIDACIÓN Y SANITIZACIÓN DE DATOS
// ============================================================================

// Función para sanitizar datos de entrada
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Obtener y sanitizar los datos del formulario
$name = isset($_POST['name']) ? sanitize_input($_POST['name']) : '';
$email = isset($_POST['email']) ? sanitize_input($_POST['email']) : '';
$phone = isset($_POST['phone']) ? sanitize_input($_POST['phone']) : '';
$message = isset($_POST['message']) ? sanitize_input($_POST['message']) : '';

// Array para almacenar errores
$errors = [];

// Validar nombre (mínimo 2 caracteres)
if (empty($name)) {
    $errors[] = 'El nombre es obligatorio.';
} elseif (strlen($name) < 2) {
    $errors[] = 'El nombre debe tener al menos 2 caracteres.';
}

// Validar email
if (empty($email)) {
    $errors[] = 'El correo electrónico es obligatorio.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'El correo electrónico no es válido.';
}

// Validar teléfono (opcional pero si se proporciona debe tener formato válido)
if (!empty($phone) && !preg_match('/^[0-9+\-\s()]{7,20}$/', $phone)) {
    $errors[] = 'El número de teléfono no es válido.';
}

// Validar mensaje (mínimo 10 caracteres)
if (empty($message)) {
    $errors[] = 'El mensaje es obligatorio.';
} elseif (strlen($message) < 10) {
    $errors[] = 'El mensaje debe tener al menos 10 caracteres.';
}

// Si hay errores de validación, devolver respuesta con errores
if (!empty($errors)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Error de validación.',
        'errors' => $errors
    ]);
    exit();
}

// ============================================================================
// PREPARAR Y ENVIAR EL CORREO
// ============================================================================

// Construir el cuerpo del correo en formato HTML
$email_body = "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f97316; color: white; padding: 20px; text-align: center; }
        .content { background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
        .field { margin-bottom: 15px; }
        .label { font-weight: bold; color: #555; }
        .value { margin-top: 5px; padding: 10px; background-color: white; border-left: 3px solid #f97316; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h2>Nuevo Mensaje de Contacto</h2>
        </div>
        <div class='content'>
            <div class='field'>
                <div class='label'>Nombre:</div>
                <div class='value'>" . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "</div>
            </div>
            <div class='field'>
                <div class='label'>Correo Electrónico:</div>
                <div class='value'>" . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "</div>
            </div>
            <div class='field'>
                <div class='label'>Teléfono:</div>
                <div class='value'>" . htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') . "</div>
            </div>
            <div class='field'>
                <div class='label'>Mensaje:</div>
                <div class='value'>" . nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')) . "</div>
            </div>
        </div>
    </div>
</body>
</html>
";

// Preparar cabeceras del correo
// IMPORTANTE: Usar un email del mismo dominio del hosting para evitar spam
$from_email = 'noreply@construcasamoderna.com'; 
$from_name = 'Formulario Contacto - Casamoderna';

$headers = [];
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=utf-8';
$headers[] = 'From: ' . $from_name . ' <' . $from_email . '>';
$headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';
$headers[] = 'X-Mailer: PHP/' . phpversion();

// Convertir array de cabeceras a string
$headers_string = implode("\r\n", $headers);

// Intentar enviar el correo
$mail_sent = @mail($to_email, $email_subject, $email_body, $headers_string);

// ============================================================================
// RESPUESTA AL CLIENTE
// ============================================================================

if ($mail_sent) {
    // Éxito: el correo se envió correctamente
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => '¡Gracias por contactarnos! Hemos recibido tu mensaje y te responderemos pronto.'
    ]);
} else {
    // Error: no se pudo enviar el correo
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Lo sentimos, hubo un error al enviar tu mensaje. Por favor, intenta nuevamente más tarde o contáctanos directamente por teléfono.'
    ]);
}

// Registro de logs (opcional - útil para debugging en desarrollo)
// Descomenta las siguientes líneas para habilitar el registro de intentos
/*
$log_message = date('Y-m-d H:i:s') . " - Email: $email, Name: $name, Status: " . ($mail_sent ? 'SUCCESS' : 'FAILED') . "\n";
file_put_contents('contact_logs.txt', $log_message, FILE_APPEND);
*/

exit();
