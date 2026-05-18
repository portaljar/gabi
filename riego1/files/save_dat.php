<?php
// Respuesta en JSON
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');
header('Expires: 0');

// Conexión
$db = new mysqli('localhost', 'u809392818_esp', 'Casalola22+', 'u809392818_esp');

if ($db->connect_error) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error de conexión a la base de datos',
        'details' => $db->connect_error
    ]);
    exit;
}

// Obtener datos enviados
$json = file_get_contents('php://input');

// Validar que es JSON válido y que es un objeto
$decoded = json_decode($json, true);
if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'JSON inválido recibido',
        'json_error' => json_last_error_msg()
    ]);
    exit;
}

// Preparar y ejecutar la consulta
$stmt = $db->prepare("UPDATE riego_config SET config_json = ? WHERE id = 1");

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error al preparar la consulta',
        'db_error' => $db->error
    ]);
    exit;
}

$stmt->bind_param("s", $json);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'updated' => $stmt->affected_rows > 0,
        'message' => 'Configuración guardada correctamente'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error al ejecutar la consulta',
        'db_error' => $stmt->error
    ]);
}

$stmt->close();
$db->close();
?>
