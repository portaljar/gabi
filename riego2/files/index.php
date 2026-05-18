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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Control de Riego</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 50vh;
            background-color: #2c2c2c; /* Fondo oscuro */
            color: #f0f0f0; /* Texto claro */
            margin: 0;
            height: 90%;
        }
        .container {
            background-color: #3b3b3b; /* Contenedor más oscuro */
            padding: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 100%;
            flex: 1; /* Esto empuja el footer al fondo */
        }
        h1 {
            color: #00bcd4; /* Color de título más vibrante */
            margin-bottom: 25px;
            font-size: 2.2rem;
        }
        .control-group {
            display: flex;
			flex-direction: row;
            align-items: center;
            gap: 10px;
            background-color: #4a4a4a; /* Fondo para grupos de control */
            padding: 10px;
            border-radius: 10px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.2);
            justify-content: center; /* Centra horizontalmente */
        }
        label {
            font-weight: bold;
            color: #cccccc;
            font-size: 1.1rem;
        }
        button {
            padding: 18px 20px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
            width: 100%;
            color: white;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        .power-button {
            background-color: #e74c3c; /* Rojo para Apagar */
            grid-column: 1 / -1; /* Ocupa todas las columnas */
        }
        .power-button.on {
            background-color: #2ecc71; /* Verde para Encender */
        }
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        .power-button:hover {
            filter: brightness(1.1); /* Ligeramente más brillante al pasar el ratón */
        }

        .display {
            
             background: var(--glass-bg);
            backdrop-filter: blur(70px);
            webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--glass-border);
            padding: 15px 25px;
            position: sticky;
            top: 0;
            z-index: 10;

			border-radius: 10px;
			border-radius: 10px;
            
		
		
		
			margin-top: 20px;
			margin-bottom: 25px;
			font-size: 1.3rem; /* Este tamaño ahora será para los valores de AC, no para statusTemp */
			font-weight: bold;
			color: #00bcd4;
			display: flex;
			flex-direction: column; /* Organiza los elementos en una columna */
			align-items: center; /* Centra los elementos horizontalmente */
		
			box-shadow: inset 0 0 8px rgba(0, 0, 0, 0.4);
		}
        hr {
            border: 0;
            height: 1px;
            background: #555;
            margin: 10px 0;
        }
        .status-message {
            margin-top: 20px;
            font-size: 0.9rem;
            color: #ccc;
            min-height: 20px; /* Para evitar saltos de diseño */
        }
	

        .contenedor { /* Contenedor para los elementos */
            background-color: #4a4a4a;
            padding: 10px;
            border-radius: 10px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .contenedor table {
            width: 100%;
            border-collapse: collapse; /* Eliminar el espacio entre celdas */
            margin-bottom: 10px;
        }
        .contenedor th {
            padding: 5px 0; /* Espaciado dentro de las celdas de la tabla */
        }

        .contenedor .input-time { /* Estilo para el input type="time" */
            width: calc(100% - 30px); /* Ajustar para padding */
            padding: 10px;
            border: 1px solid #555;
            border-radius: 8px;
            background-color: #252525;
            color: #f0f0f0;
            font-size: 1.1rem; /* Un poco más grande para la hora */
            outline: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .contenedor .input-time:focus {
            border-color: #00bcd4;
            box-shadow: 0 0 0 2px rgba(0, 188, 212, 0.5);
        }

        .contenedor .day-checkboxes { /* Contenedor para los checkboxes de los días */
            display: flex;
            justify-content: space-around; /* Distribuir los checkboxes uniformemente */
            flex-wrap: wrap; /* Permitir que los checkboxes se envuelvan en pantallas pequeñas */
            gap: 5px; /* Espacio entre los checkboxes */
            margin-top: 10px;
        }

        .contenedor .day-checkboxes input[type="checkbox"] {
            /* Ocultar el checkbox nativo */
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .contenedor .day-checkboxes input[type="checkbox"] + label {
            background-color: #6c757d;
            color: white;
            padding: 6px 9px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-size: 0.85rem;
            min-width: 17px; /* Asegurar un ancho mínimo para cada día */
            display: inline-block; /* Para que padding y width funcionen */
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .contenedor .day-checkboxes input[type="checkbox"]:checked + label {
            background-color: #28a745; /* Verde cuando está seleccionado */
            box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.5); /* Sombra para indicar selección */
        }
		
        .contenedor .save-button { /* Estilo para el botón Guardar */
            background-color: #007bff; /* Azul primario */
            width: 100%;
        }
        .contenedor .save-button:hover {
            background-color: #0056b3;
        }

		
    </style>
</head>
<body>

	<div class="container">
		
        <div class="display">
			<div style="font-size: 1.1rem; margin-bottom: 10px; color: #f0f0f0;">
				<h1>Control de riego</h1>
			</div>
			<div style="display: flex; justify-content: space-around; width: 100%;">
			<span class="status-message" id="statusMessage"></span>
			</div>
		</div>
		

        <hr>
		
	
		<div class="contenedor" id="confi_temp" style="display:none;">
			<h2>Temporizador</h2>

			<div class="zona-temporizador" id="timerZone1">
				<h3>Zona 1</h3>
				<div class="control-group">
					<label for="startTime0">ON:</label> <input type="time" class="input-time" id="startTime0" value="00:00">
					<label for="endTime0">OFF:</label> <input type="time" class="input-time" id="endTime0" value="00:00">
				</div>
				<div class="day-checkboxes">
					<input type="checkbox" id="day_lu0" class="check"><label for="day_lu0">Lu</label>
					<input type="checkbox" id="day_ma0" class="check"><label for="day_ma0">Ma</label>
					<input type="checkbox" id="day_mi0" class="check"><label for="day_mi0">Mi</label>
					<input type="checkbox" id="day_ju0" class="check"><label for="day_ju0">Ju</label>
					<input type="checkbox" id="day_vi0" class="check"><label for="day_vi0">Vi</label>
					<input type="checkbox" id="day_sa0" class="check"><label for="day_sa0">Sa</label>
					<input type="checkbox" id="day_do0" class="check"><label for="day_do0">Do</label>
				</div>
			</div>

			<div class="zona-temporizador" id="timerZone2">
				<h3>Zona 2</h3>
				<div class="control-group">
					<label for="startTime1">ON:</label> <input type="time" class="input-time" id="startTime1" value="00:00">
					<label for="endTime1">OFF:</label> <input type="time" class="input-time" id="endTime1" value="00:00">
				</div>
				<div class="day-checkboxes">
					<input type="checkbox" id="day_lu1" class="check"><label for="day_lu1">Lu</label>
					<input type="checkbox" id="day_ma1" class="check"><label for="day_ma1">Ma</label>
					<input type="checkbox" id="day_mi1" class="check"><label for="day_mi1">Mi</label>
					<input type="checkbox" id="day_ju1" class="check"><label for="day_ju1">Ju</label>
					<input type="checkbox" id="day_vi1" class="check"><label for="day_vi1">Vi</label>
					<input type="checkbox" id="day_sa1" class="check"><label for="day_sa1">Sa</label>
					<input type="checkbox" id="day_do1" class="check"><label for="day_do1">Do</label>
				</div>
			</div>

			<div class="zona-temporizador" id="timerZone3">
				<h3>Zona 3</h3>
				<div class="control-group">
					<label for="startTime2">ON:</label> <input type="time" class="input-time" id="startTime2" value="00:00">
					<label for="endTime2">OFF:</label> <input type="time" class="input-time" id="endTime2" value="00:00">
				</div>
				<div class="day-checkboxes">
					<input type="checkbox" id="day_lu2" class="check"><label for="day_lu2">Lu</label>
					<input type="checkbox" id="day_ma2" class="check"><label for="day_ma2">Ma</label>
					<input type="checkbox" id="day_mi2" class="check"><label for="day_mi2">Mi</label>
					<input type="checkbox" id="day_ju2" class="check"><label for="day_ju2">Ju</label>
					<input type="checkbox" id="day_vi2" class="check"><label for="day_vi2">Vi</label>
					<input type="checkbox" id="day_sa2" class="check"><label for="day_sa2">Sa</label>
					<input type="checkbox" id="day_do2" class="check"><label for="day_do2">Do</label>
				</div>
			</div>

			<div class="zona-temporizador" id="timerZone4">
				<h3>Zona 4</h3>
				<div class="control-group">
					<label for="startTime3">ON:</label> <input type="time" class="input-time" id="startTime3" value="00:00">
					<label for="endTime3">OFF:</label> <input type="time" class="input-time" id="endTime3" value="00:00">
				</div>
				<div class="day-checkboxes">
					<input type="checkbox" id="day_lu3" class="check"><label for="day_lu3">Lu</label>
					<input type="checkbox" id="day_ma3" class="check"><label for="day_ma3">Ma</label>
					<input type="checkbox" id="day_mi3" class="check"><label for="day_mi3">Mi</label>
					<input type="checkbox" id="day_ju3" class="check"><label for="day_ju3">Ju</label>
					<input type="checkbox" id="day_vi3" class="check"><label for="day_vi3">Vi</label>
					<input type="checkbox" id="day_sa3" class="check"><label for="day_sa3">Sa</label>
					<input type="checkbox" id="day_do3" class="check"><label for="day_do3">Do</label>
				</div>
			</div>
		
			<div class="control-group">
				<button id="TimerToggleButton" onclick="send_data(9)">-----</button>
				<button style=" background-color: #9b59b6;" onclick="input_out()">Guardar</button>
			</div>
		

			<div class="control-group">
				<button style=" background-color: #9b59b6;" onclick="estado_button(document.getElementById('confi_temp'));">Salir</button>
			</div>

		</div>
		
		<div class="contenedor" id="confi_log" style="display:none;">
			<h2>Registro Log</h2>
			<div class="control-group" >
				<h4  id='log'>...</h4>
			</div>
			<div class="control-group">
				<button style=" background-color: #9b59b6;" onclick="send_data(5)">Borrar Log</button>
				<button style=" background-color: #9b59b6;" onclick="estado_button(document.getElementById('confi_log'));">Salir</button>
			</div>
		</div>	

		
        <div id="control_buton" class="contenedor">
            
				<div class="control-group">           
					<button id="boton_0"  onclick="send_data(0)">Zona 1</button>
					<button id="boton_1"  onclick="send_data(1)">Zona 2</button>
				</div>
				
				<div class="control-group" >
					<button id="boton_2" onclick="send_data(2)">Zona 3</button>
					<button id="boton_3" onclick="send_data(3)">Zona 4</button>
				</div>
			    <div class="control-group">
					<button style=" background-color: #9b59b6;" onclick="estado_button(document.getElementById('confi_temp'));">Tempo</button>
					<button style=" background-color: #9b59b6;" onclick="estado_button(document.getElementById('confi_log'));">Log</button>
				</div>
			
        </div>
	
	
</div>
 
<footer style="text-align: center; padding: 1rem; background-color: #2c2c2c;  font-size: 0.9rem; line-height: 1.6;">
  <p>
    <span id="pie">Versión del proyecto</span><br>
    Sitio web: 
    <a href="https://esp12.fun" target="_blank" style="color: #00ffae; text-decoration: none;">esp12.fun</a><br>
    Contacto: 
    <a href="mailto:portaljar@gmail.com" style="color: #00ffae; text-decoration: none;">portaljar@gmail.com</a><br>
    Con la ayuda de 
    <a href="https://chat.openai.com/" target="_blank" style="color: #00ffae; text-decoration: none;">
      <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/ChatGPT_logo.svg" alt="ChatGPT" style="height: 1em; vertical-align: middle; margin-right: 5px;">
      ChatGPT
    </a>
  </p>
</footer>
<script>
       
	let acState = {}, tempo_old = "", in_input, case_num, ck = [], timer = 1000, b_conexion = false, txt_conexion = "Conectando con el dispositivo", log_state = true, sen_tem = {};
	var myInterval = window.setInterval(myTimer, timer);
	const statusMessage = document.getElementById('statusMessage');
	const modes = ["Auto", "Frio", "Seco", "Calor"];
	const fanSpeeds = ["Auto", "Baja", "Media", "Alta"];
	
//function myTimer() { send_data(13); }
function myTimer() { load_datos(); }

     // Realiza la solicitud al archivo PHP
async function load_datos() {
        timer = 15000;
        window.clearInterval(myInterval);
        myInterval = window.setInterval(myTimer, timer);
        statusMessage.innerText = 'Actualizando...';
        statusMessage.style.color = '#f1c40f'; // Amarillo para "enviando"
        try {
            const response = await fetch('files/load_dat.php?t=' + new Date().getTime());
            const config = await response.json();
            acState = config;
            statusMessage.innerText = acState.reloj;
            statusMessage.style.color = '#2ecc71'; // Verde para éxito
           
            console.log("JSON recibido:", acState);
            datos_act(); 
            } catch (error) {
                console.error('Error cargando configuración:', error);
            }
       
 }

async function save_datos() {
    
    console.log('Enviado acState:', acState); 
    
	statusMessage.innerText = 'Actualizando...';
	statusMessage.style.color = '#f1c40f'; // Amarillo para "enviando"

        try {
            const response = await fetch('files/save_dat.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(acState)
            });
            const result = await response.json();
            //console.log(acState.tempo_zones);
            console.log (result.success ? 'Guardado!' : 'Error: ' + result.error);
            datos_act();
            statusMessage.innerText = acState.out_server;
			statusMessage.style.color = '#2ecc71'; // Verde para éxito
			console.log('Estado recibido del backend:', acState); 
            } catch (error) {
                console.error('Error guardando:', error);
                //const errorText = await response.text();
                statusMessage.innerText = `Error al actualizar`;
                statusMessage.style.color = '#e74c3c'; // Rojo para error
            }
        }

function input_out() {

    acState.tempo_zones = acState.tempo_zones || {};


    for (let zoneNum = 0; zoneNum < 4; zoneNum++) {
        const startTimeInput = document.getElementById(`startTime${zoneNum}`);
        const endTimeInput = document.getElementById(`endTime${zoneNum}`);

        const selectedStartTime = startTimeInput.value;
        const selectedEndTime = endTimeInput.value;

        const daysOfWeek = ["lu", "ma", "mi", "ju", "vi", "sa", "do"];
        let dayArray = [];

        daysOfWeek.forEach((day) => {
            const checkbox = document.getElementById(`day_${day}${zoneNum}`);
            dayArray.push(checkbox.checked ? 1 : 0);
        });

        const confArray = [...dayArray, selectedStartTime, selectedEndTime];
        acState.tempo_zones[zoneNum] = acState.tempo_zones[zoneNum] || {};
        acState.tempo_zones[zoneNum].conf = confArray; // Asigna el array directamente

        // Actualiza sen_tem con el formato deseado para cada zona
        sen_tem[zoneNum] = { conf: confArray }; // Estructura idéntica a data_send.tempo_zones
        
        console.log(`Configuración de Zona ${zoneNum}:`, confArray); // Esto mostrará el array
    }
    
    console.log("sen_tem final:", sen_tem);
    acState.tempo_zones = sen_tem;

    send_data(8);
}

function updateAlarmDisplay(confStringData, zoneNum) {
  
    const startTimeInput = document.getElementById(`startTime${zoneNum}`);
    const endTimeInput = document.getElementById(`endTime${zoneNum}`);

    if (startTimeInput) { startTimeInput.value = confStringData[7]; }
    if (endTimeInput) { endTimeInput.value = confStringData[8]; }

    const daysOfWeek = ["lu", "ma", "mi", "ju", "vi", "sa", "do"];

    daysOfWeek.forEach((day, index) => {
        const checkbox = document.getElementById(`day_${day}${zoneNum}`);
        if (checkbox) {
            checkbox.checked = confStringData[index] === 1;
        }
    });
    }

function send_data(case_num) {
    if(!b_conexion)  return;
    	acState.case_sen = case_num;
    	
        switch(case_num) {
            case 5://Reset log
    			//acState.del_log = true;
    			acState.out_server = "Log borrado OK";
    		break;
    		
    	
    		case 8://Actualizar Temporizador
    		    acState.tempo_zones = sen_tem;
    			acState.out_server = "Temporizador actualizado OK";
    		break;
    		case 9:// TEMPO ON/OFF
    		    acState.b_tempo = !acState.b_tempo;
    		    acState.out_server = "Temporizador actualizado OK";
    		break; 
    		
    		case 10://act. reloj
    			var d = new Date();
    			var diff = d.getTimezoneOffset();
    			var n =parseInt(d.valueOf()/1000);
    			console.log(diff);  
    			acState['reloj'] = n;   
    		break;
    
    		case 13://actualizar Web auto
    			//timer = 30000;
    		break; 
    		default:
              acState.rele[case_num] = !acState.rele[case_num];
              acState.out_server = "Zona " + String(case_num + 1) + " actualizada OK";
            break;
    	}
    	
    	
    	if(case_num != 13)save_datos();
    }

function datos_act(){
    //comprobar conexion ESP12 
        b_conexion = true;
		var d = new Date();
		var diff = d.getTimezoneOffset();
		var n =parseInt(d.valueOf()/1000);
		console.log("d  :", acState.time, "-  n :", n);
        if((acState.time + 120 ) < (Date.now()/1000)){
            b_conexion = false;
           // txt_conexion = "Conectando con el dispositivo";
            statusMessage.innerText = txt_conexion;
            statusMessage.style.color = '#e74c3c'; // Rojo para error
             return;
        } 
        // Ocultar el mensaje después de un tiempo
	    setTimeout(() => {statusMessage.innerText = acState.reloj;}, 10000);
   
    //document.getElementById('oup_ip').innerHTML =  acState.oup_ip;
	if (log_state && !acState.del_log) log_fun();
	const newTempoJSON = JSON.stringify(acState.tempo_zones);
	if (newTempoJSON !== tempo_old) {
		tempo_old = newTempoJSON;
		console.log(tempo_old)
		for (let i = 0; i < 4; i++) {
			//const zoneKey = `zone${i}`;
			if (acState.tempo_zones[i]) {
				const zoneData = acState.tempo_zones[i];
				//console.log(zoneData.conf);
				updateAlarmDisplay(zoneData.conf, i); // Solo pasamos la conf y el número de zo
			}
		}
	}
	for (var i = 0; i < 4; i++) {
		acState.rele[i] == false ? document.getElementById("boton_"+ i).style.background="lime" : document.getElementById("boton_"+ i).style.background="red";
	}
	
	const timerButton = document.getElementById('TimerToggleButton');
	const estado = acState.b_tempo;
	timerButton.innerText = `Tempo ${estado ? ' ON' : ' OFF'}`;
	timerButton.style.backgroundColor =(estado ? '#2ecc71' : '#e74c3c');
	document.getElementById('pie').innerHTML = acState.pie;
	log_fun();

}

function estado_button (o){
    o.style.display = o.style.display == '' ? 'none' : '';
    document.getElementById('control_buton').style.display = o.style.display === '' ? 'none' : '';

}   


function log_fun(){
  var iframe = document.createElement('iframe');
  iframe.src = "files/logs/log.txt";
  document.getElementById("log").innerHTML = '';
  document.getElementById("log").appendChild(iframe);
 
 }

 
</script>

</body>
</html> 