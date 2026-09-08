<?php
// Archivo donde se guardarán los datos
$file = 'DB_sonidos.csv';

// Función auxiliar para escapar campos CSV
function escapeCSV($field) {
    if (strpos($field, '"') !== false || strpos($field, ',') !== false) {
        $field = '"' . str_replace('"', '""', $field) . '"';
    }
    return $field;
}

  //  Función getAtributos
  //   function getAtributos() {
  //     // trim = elimina los espacios adyacentes
  //     // const searchQuery = document.getElementById("webSearchQuery").value.trim();
  //     // if (!searchQuery) {
  //     //     alert("Introduce un término de búsqueda.");
  //     //     return;
  //     // }

  //     const checkboxes = document.querySelectorAll('input[name="atributos"]:checked');
  //     if (checkboxes.length === 0) {
  //         alert("Selecciona al menos un Atributo.");
  //         return;
  //     }

  //     // Añadir value's de atributos a lista de Atributos
  //     checkboxes.forEach(checkbox => {
  //         const atr_item = checkbox.value;
  //         const atr_list = atr_list.[atr_item];
  //     });
  // }

// Solo manejar solicitudes POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitizar entradas
    $tipo = isset($_POST['tipo']) ? trim($_POST['tipo']) : '';
    $numero = isset($_POST['numero']) ? trim($_POST['numero']) : '';
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $decay = isset($_POST['decay']) ? trim($_POST['decay']) : '';
    $vibrato = isset($_POST['vibrato']) ? trim($_POST['vibrato']) : '';
    $chords = isset($_POST['chords']) ? trim($_POST['chords']) : '';
    $melody = isset($_POST['melody']) ? trim($_POST['melody']) : '';
    $sens = isset($_POST['sens']) ? trim($_POST['sens']) : '';
    $delay = isset($_POST['delay']) ? trim($_POST['delay']) : '';
    $pedal = isset($_POST['pedal']) ? trim($_POST['pedal']) : '';
    $fxVib = isset($_POST['fxVib']) ? trim($_POST['fxVib']) : '';
    $fxFil = isset($_POST['fxFil']) ? trim($_POST['fxFil']) : '';
    $sample = isset($_POST['sample']) ? trim($_POST['sample']) : '';
    $atributos = isset($_POST['atributos']) ? trim($_POST['atributos']) : '';
    //$clases = isset($_POST['clases']) ? trim($_POST['clases']) : '';
    //$lista = isset($_POST['lista']) ? trim($_POST['lista']) : '';

    // $xxxxx3 = isset($_POST['xxxxx3']) ? trim($_POST['xxxxx3']) : '';
    // $xxxxx4 = isset($_POST['xxxxx4']) ? trim($_POST['xxxxx4']) : '';
    // $xxxxx5 = isset($_POST['xxxxx5']) ? trim($_POST['xxxxx5']) : '';

    $error = '';
    $success = '';

    // Validar entradas
    if ($tipo === '' || $numero === '' || $nombre === '' || $chords === '' || $melody === '' ) {
        $error = "❌️  Por favor completa todos los campos. ⁉️";
    } elseif ( !is_numeric($numero) || !is_numeric($fxVib) || !is_numeric($fxFil) || $numero < 1 || $fxVib < 0 || $fxFil < 0) {
        $error = "❌️  Número, FX-Vib y FX-Fil deben ser números no negativos. ⁉️";
    } else {
        // Preparar línea CSV
        $line = implode(',', [
          escapeCSV($tipo),
          escapeCSV($numero),
          escapeCSV($nombre),
          escapeCSV($decay),
          escapeCSV($vibrato),
          escapeCSV($chords),
          escapeCSV($melody),
          escapeCSV($sens),
          escapeCSV($delay),
          escapeCSV($pedal),
          escapeCSV($fxVib),
          escapeCSV($fxFil),
          escapeCSV($sample)
          // escapeCSV($atributos)
          //escapeCSV($clases)
          //escapeCSV($lista)
        ]) . "\n";
        // **¿?comentar if 
        if (file_put_contents($file, $line, FILE_APPEND | LOCK_EX) !== false) {
            $success = "✅️ Datos guardados correctamente en DB_sonidos.csv.";
        } else {
            $error = "❌️ Error al guardar los datos en el archivo.";
        }
    }
} else {
    $error = "❌️ Método no permitido.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Guardar Producto</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      color: #fff;
    }
    .container {
      background: rgba(255,255,255,0.1);
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 8px 32px 0 rgba(31,38,135,0.37);
      max-width: 400px;
      width: 100%;
      backdrop-filter: blur(8px);
      text-align: center;
    }
    .message {
      padding: 15px 20px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 1.1rem;
    }
    .success {
      background-color: #2ecc71;
      color: white;
    }
    .error {
      background-color: #e74c3c;
      color: white;
    }
    a.button {
      display: inline-block;
      margin-top: 20px;
      background:rgb(139, 31, 31);
      color: white;
      padding: 12px 24px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: background 0.3s ease;
    }
    a.button:hover {
      background:rgb(69, 94, 42);
    }
  </style>
</head>
<body>
  <div class="container">
    <?php if (!empty($success)) : ?>
      <div class="message success"><?php echo htmlspecialchars($success); ?></div>
    <?php else: ?>
      <div class="message error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <a href="index.html" class="button">Crear otro sonido</a>
  </div>
</body>
</html>
