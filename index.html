<?php
$usuarioCorrecto = "admin";  // Cambia por tu usuario
$passwordCorrecta = "esp12";   // Cambia por tu contraseña

if (!isset($_SERVER['PHP_AUTH_USER']) || 
    !isset($_SERVER['PHP_AUTH_PW']) || 
    $_SERVER['PHP_AUTH_USER'] !== $usuarioCorrecto || 
    $_SERVER['PHP_AUTH_PW'] !== $passwordCorrecta) {
    header('WWW-Authenticate: Basic realm="Acceso Restringido"');
    header('HTTP/1.0 401 Unauthorized');
    die("Usuario o contraseña incorrectos");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Portal de Control de Riego</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #2c2c2c;
            color: #f0f0f0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .portal-container {
            max-width: 500px;
            width: 100%;
            background-color: #3b3b3b;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
            overflow: hidden;
            text-align: center;
            padding: 30px 20px 40px;
            position: relative;
        }

        /* Botón de ayuda flotante */
        .help-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #9b59b6;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            border: none;
            z-index: 10;
        }

        .help-button:hover {
            background-color: #8e44ad;
            transform: scale(1.05);
        }

        h1 {
            color: #00bcd4;
            font-size: 2rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        h1 .icon {
            font-size: 2rem;
        }

        .subtitle {
            color: #cccccc;
            margin-bottom: 40px;
            font-size: 1rem;
            border-bottom: 1px solid #555;
            display: inline-block;
            padding-bottom: 8px;
        }

        .options {
            display: flex;
            flex-direction: column;
            gap: 25px;
            margin-bottom: 40px;
        }

        .riego-card {
            background-color: #4a4a4a;
            border-radius: 16px;
            padding: 20px;
            transition: all 0.3s ease;
            display: block;
            border: 1px solid #5a5a5a;
            text-decoration: none;
            color: #f0f0f0;
        }

        /* Estilo para tarjeta ONLINE */
        .riego-card.online {
            cursor: pointer;
        }

        .riego-card.online:hover {
            transform: translateY(-5px);
            background-color: #555;
            border-color: #00bcd4;
            box-shadow: 0 12px 20px rgba(0,0,0,0.3);
        }

        /* Estilo para tarjeta OFFLINE */
        .riego-card.offline {
            opacity: 0.6;
            cursor: not-allowed;
            filter: grayscale(0.3);
            pointer-events: none;
        }

        .riego-card h2 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: #ffd700;
        }

        .riego-card p {
            font-size: 0.9rem;
            color: #bbbbbb;
        }

        .status-badge {
            display: inline-block;
            margin-top: 15px;
            font-size: 0.8rem;
            background-color: #2c2c2c;
            padding: 5px 12px;
            border-radius: 20px;
        }

        .status-badge.online {
            background-color: #2ecc71;
            color: #1a1a1a;
        }

        .status-badge.offline {
            background-color: #e74c3c;
            color: white;
        }

        .status-badge.checking {
            background-color: #f39c12;
            color: #1a1a1a;
        }

        .footer-links {
            margin-top: 20px;
            font-size: 0.8rem;
            border-top: 1px solid #555;
            padding-top: 20px;
        }

        .footer-links a {
            color: #00ffae;
            text-decoration: none;
        }

        /* MODAL DE AYUDA */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.8);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #3b3b3b;
            max-width: 500px;
            width: 90%;
            border-radius: 20px;
            padding: 25px;
            position: relative;
            max-height: 80vh;
            overflow-y: auto;
            border: 1px solid #00bcd4;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #555;
            padding-bottom: 10px;
        }

        .modal-header h2 {
            color: #ffd700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .close-modal {
            background-color: #e74c3c;
            color: white;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .close-modal:hover {
            background-color: #c0392b;
            transform: scale(1.05);
        }

        .help-section {
            margin-bottom: 25px;
        }

        .help-section h3 {
            color: #00bcd4;
            margin-bottom: 10px;
            font-size: 1.2rem;
        }

        .help-section p {
            color: #cccccc;
            line-height: 1.5;
            margin-bottom: 8px;
        }

        .help-section ul {
            margin-left: 20px;
            color: #cccccc;
        }

        .help-section li {
            margin-bottom: 5px;
        }

        .help-tip {
            background-color: #2c2c2c;
            padding: 10px;
            border-radius: 10px;
            margin-top: 10px;
            border-left: 3px solid #ffd700;
        }

        .help-tip span {
            color: #ffd700;
            font-weight: bold;
        }

        @media (max-width: 480px) {
            .portal-container {
                padding: 20px 15px 30px;
            }
            .riego-card h2 {
                font-size: 1.5rem;
            }
            .help-button {
                width: 35px;
                height: 35px;
                font-size: 1.2rem;
                top: 15px;
                right: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="portal-container">
        <!-- Botón de ayuda flotante -->
        <button class="help-button" id="helpButton">❔</button>

        <h1>
            <span class="icon">🌱</span>
            Control de Riego
        </h1>
        <div class="subtitle">Selecciona el sistema a gestionar</div>

        <div class="options">
            <!-- Zona de Riego 1 -->
            <a href="index.php" class="riego-card" id="card1">
                <h2>💧 Zona de Riego 1</h2>
                <p>Jardín Principal | Maceteros Este</p>
                <div class="status-badge checking" id="status1">● Comprobando...</div>
            </a>

            <!-- Zona de Riego 2 -->
            <a href="/riego2/" class="riego-card" id="card2">
                <h2>💧 Zona de Riego 2</h2>
                <p>Huerta Trasera | Frutales</p>
                <div class="status-badge checking" id="status2">● Comprobando...</div>
            </a>
        </div>

        <div class="footer-links">
            <span id="pie">Portal de control unificado</span><br>
            <a href="https://esp12.fun" target="_blank">esp12.fun</a> | 
            <a href="mailto:portaljar@gmail.com">Contacto</a><br>
            <span style="font-size: 0.7rem;">Selecciona el área que deseas administrar</span>
        </div>
    </div>

    <!-- MODAL DE AYUDA -->
    <div id="helpModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>📖 Manual de uso</h2>
                <button class="close-modal" id="closeModal">✕</button>
            </div>
            
            <div class="help-section">
                <h3>🌿 ¿Qué es esto?</h3>
                <p>Este portal te permite elegir qué zona de riego quieres controlar. Cada zona tiene su propio panel de control.</p>
            </div>

            <div class="help-section">
                <h3>🚿 Cómo regar manualmente</h3>
                <p>1. Haz clic en la tarjeta de la zona que quieras regar</p>
                <p>2. Se abrirá el panel de control de esa zona</p>
                <p>3. Pulsa el botón de la zona que quieras activar</p>
                <div class="help-tip">
                    <span>💡 Tip:</span> El botón se pone VERDE cuando está regando y ROJO cuando está apagado.
                </div>
            </div> 

            <div class="help-section">
                <h3>⏰ Riego automático (Temporizador)</h3>
                <p>0. Si el reloj no esta con la hora correcta pulsa "Act Reloj"</p>
                <p>1. Dentro del panel de control, pulsa "Tempo"</p>
                <p>2. Configura la hora de INICIO y FIN para cada zona</p>
                <p>3. Selecciona los días de la semana que quieres que riegue</p>
                <p>4. Pulsa "Guardar""</p>
                <div class="help-tip">
                    <span>💡 Tip:</span> El temporizador debe estar en "ON" (verde) para que funcione.
                </div>
            </div>

            <div class="help-section">
                <h3>📡 Estado de las zonas</h3>
                <ul>
                    <li><span style="color:#2ecc71;">● Verde</span> = Zona conectada y disponible</li>
                    <li><span style="color:#e74c3c;">● Rojo</span> = Zona desconectada (revisa que esté encendida)</li>
                    <li><span style="color:#f39c12;">● Amarillo</span> = Comprobando...</li>
                </ul>
                <div class="help-tip">
                    <span>⚠️ Importante:</span> Si una zona está en rojo, no podrás seleccionarla hasta que se reconecte.
                </div>
            </div>

            <div class="help-section">
                <h3>🔧 Solución de problemas</h3>
                <p><strong>No puedo entrar al control:</strong> Asegúrate de estar conectado a la misma red WiFi que los dispositivos de riego.</p>
                <p><strong>La zona aparece en rojo:</strong> Revisa que el dispositivo esté encendido y conectado a la red.</p>
                <p><strong>El temporizador no riega:</strong> Verifica que está en "ON" y que los días/horas están bien configurados.</p>
            </div>

            <div class="help-section">
                <h3>📞 ¿Necesitas ayuda?</h3>
                <p>Si algo no funciona como esperas, contacta con quien te instaló el sistema.</p>
            </div>
        </div>
    </div>

    <script>
        // Configuración de las zonas (ajusta las URL según tu caso)
        const zonas = [
            {
                nombre: 'Zona 1',
                url: 'index.php',  // Ruta relativa para Zona 1
                fullUrl: window.location.origin + '/riego/index.php',
                cardId: 'card1',
                statusId: 'status1'
            },
            {
                nombre: 'Zona 2',
                url: '/riego2/',   // Ruta para Zona 2
                fullUrl: window.location.origin + '/riego2/',
                cardId: 'card2',
                statusId: 'status2'
            }
        ];

        // Modal de ayuda
        const modal = document.getElementById('helpModal');
        const helpButton = document.getElementById('helpButton');
        const closeModal = document.getElementById('closeModal');

        // Abrir modal
        helpButton.addEventListener('click', () => {
            modal.style.display = 'flex';
        });

        // Cerrar modal
        closeModal.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Cerrar modal al hacer clic fuera
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Función para comprobar si una zona está online
        async function checkDeviceStatus(zona) {
            const card = document.getElementById(zona.cardId);
            const statusElement = document.getElementById(zona.statusId);
            
            // Estado "comprobando"
            statusElement.innerHTML = '● Comprobando...';
            statusElement.className = 'status-badge checking';
            card.classList.remove('online', 'offline');
            
            try {
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 3000);
                
                // Intentamos con fetch (HEAD es más ligero)
                await fetch(zona.fullUrl, {
                    method: 'HEAD',
                    mode: 'no-cors',
                    signal: controller.signal
                });
                
                clearTimeout(timeoutId);
                
                // Éxito: zona ONLINE
                statusElement.innerHTML = '● Online';
                statusElement.className = 'status-badge online';
                card.classList.add('online');
                card.classList.remove('offline');
                card.href = zona.url;  // Aseguramos el enlace
                
                console.log(`✅ ${zona.nombre} está ONLINE`);
                
            } catch (error) {
                // Error: zona OFFLINE
                statusElement.innerHTML = '● Offline';
                statusElement.className = 'status-badge offline';
                card.classList.add('offline');
                card.classList.remove('online');
                card.href = 'javascript:void(0);';  // Desactivar enlace
                
                console.log(`❌ ${zona.nombre} está OFFLINE`);
            }
        }

        // Comprobar todas las zonas
        async function checkAllDevices() {
            for (const zona of zonas) {
                await checkDeviceStatus(zona);
            }
        }

        // Inicializar: comprobar al cargar y cada 15 segundos
        window.addEventListener('DOMContentLoaded', () => {
            checkAllDevices();
            setInterval(checkAllDevices, 45000);
        });
    </script>
</body>
</html>