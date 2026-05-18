<?php

// Define la ruta donde se guardará el archivo de log.
// Asegúrate de que el directorio 'logs/' exista y tenga permisos de escritura.
$upload_dir = __DIR__ . '/logs/';
$upload_file = $upload_dir . 'log.txt';

// Verifica si la solicitud es un método POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // El ESP8266 envía el contenido del log directamente en el cuerpo de la solicitud POST.
    // file_get_contents('php://input') lee el cuerpo crudo de la solicitud HTTP.
    $log_content = file_get_contents('php://input');

    // Si se recibió algún contenido...
    if ($log_content !== false && !empty($log_content)) {
        // Guarda el contenido en el archivo de log.
        // FILE_APPEND: para añadir al final del archivo.
        // LOCK_EX: para evitar que otros procesos escriban al mismo tiempo.
        if (file_put_contents($upload_file, $log_content . PHP_EOL, LOCK_EX) !== false) {
            // Envía una respuesta de éxito al ESP8266.
            http_response_code(200);
            echo "Archivo de log guardado correctamente.\n";
        } else {
            // Si hubo un error al escribir el archivo.
            http_response_code(500);
            echo "Error: No se pudo escribir en el archivo.\n";
        }
    } else {
        // Si el cuerpo de la solicitud estaba vacío.
        http_response_code(400);
        echo "Error: No se recibió contenido.\n";
    }
} else {
    // Si la solicitud no es POST (por ejemplo, es GET).
    http_response_code(405);
    echo "Método no permitido. Solo se acepta POST.\n";
}

?>