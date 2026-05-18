<?php
// Forzar respuesta en JSON
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');
header('Expires: 0');

// Conexión a la base de datos
$db = new mysqli('localhost', 'u809392818_esp', 'Casalola22+', 'u809392818_esp');

if ($db->connect_error) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error de conexión: ' . $db->connect_error
    ]);
    exit;
}

// Preparar la consulta
$stmt = $db->prepare("SELECT config_json FROM riego_config WHERE id = 2");

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error al preparar la consulta',
        'db_error' => $db->error
    ]);
    exit;
}

$stmt->execute();
$stmt->bind_result($config_json);

if ($stmt->fetch()) {
    // Validar que el JSON guardado sea válido
    $decoded = json_decode($config_json);
    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'JSON corrupto en base de datos',
            'json_error' => json_last_error_msg(),
            'raw_data' => $config_json
        ]);
    } else {
        // JSON válido → devolver tal cual
        echo $config_json;
    }
}

$stmt->close();
$db->close();
?>
