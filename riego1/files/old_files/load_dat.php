<?php
header('Content-Type: application/json');

$db = new mysqli('localhost', 'u809392818_esp', 'Casalola22+', 'u809392818_esp');

// 2. Verificar conexión
if ($db->connect_error) {
    http_response_code(500);
    die(json_encode([
        'success' => false,
        'error' => 'Error de conexión: ' . $db->connect_error,
        'timestamp' => time()
    ]));
}

// 3. Consulta segura con sentencia preparada
$stmt = $db->prepare("SELECT config_json FROM aire_config WHERE id = 1");
if (!$stmt) {
    http_response_code(500);
    die(json_encode([
        'success' => false,
        'error' => 'Error al preparar consulta: ' . $db->error,
        'query_error' => true
    ]));
}

// 4. Ejecutar y obtener resultados
$stmt->execute();
$stmt->bind_result($config_json);

if (!$stmt->fetch()) {
    // Si no hay resultados, crear configuración por defecto
    $defaultConfig = [
        'status' => 'default',
        'message' => 'Configuración inicial automática',
        'timestamp' => time()
    ];
    
    $jsonDefault = json_encode($defaultConfig);
    
    // Intentar insertar
    $insert = $db->prepare("INSERT INTO aire_config (id, config_json) VALUES (1, ?)");
    $insert->bind_param("s", $jsonDefault);
    
    if ($insert->execute()) {
        echo $jsonDefault;
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'No se pudo crear registro inicial',
            'db_error' => $db->error
        ]);
    }
    $insert->close();
} else {
    // Verificar si el JSON es válido
    $decoded = json_decode($config_json);
    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'JSON corrupto en base de datos',
            'raw_data' => $config_json, // Para diagnóstico
            'json_error' => json_last_error_msg()
        ]);
    } else {
        // Todo correcto, devolver JSON
        echo $config_json;
    }
}

$stmt->close();
$db->close();
?>