<?php
header('Content-Type: application/json');

// Configuración BD
$db = new mysqli('localhost', 'u809392818_esp', 'Casalola22+', 'u809392818_esp');

if ($db->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Conexión fallida']));
}

// Recibir JSON
$json = file_get_contents('php://input');

// Validar JSON
if (!json_decode($json)) {
    die(json_encode(['success' => false, 'error' => 'JSON inválido']));
}

// Actualizar siempre el registro con ID=1
$stmt = $db->prepare("UPDATE aire_config SET config_json = ? WHERE id = 1");
$stmt->bind_param("s", $json);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'updated' => $stmt->affected_rows > 0]);
} else {
    echo json_encode(['success' => false, 'error' => $db->error]);
}

$stmt->close();
$db->close();
?>