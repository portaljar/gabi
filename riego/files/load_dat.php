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
$stmt = $db->prepare("SELECT config_json FROM riego_config WHERE id = 1");

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
} else {
    // No existe el registro con ID=1 → crear uno por defecto
    $defaultConfig = [
        'power' => 0,
        'mode' => 0,
        'temp' => 24,
        'fanSpeed' => 1,
        'swing' => 0,
        'out_server' => 'Datos por defecto',
        'timestamp' => time()
    ];

    $jsonDefault = json_encode($defaultConfig);

    // Intentar insertar nuevo registro
    $insert = $db->prepare("INSERT INTO riego_config (id, config_json) VALUES (1, ?)");
    if ($insert) {
        $insert->bind_param("s", $jsonDefault);
        if ($insert->execute()) {
            echo $jsonDefault;
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'No se pudo crear registro inicial',
                'db_error' => $insert->error
            ]);
        }
        $insert->close();
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'No se pudo preparar inserción',
            'db_error' => $db->error
        ]);
    }
}

$stmt->close();
$db->close();
?>
