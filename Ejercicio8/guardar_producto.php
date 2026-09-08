<?php
// Archivo donde se guardarán los datos
$file = 'productos.csv';

// Función auxiliar para escapar campos CSV
function escapeCSV($field) {
    if (strpos($field, '"') !== false || strpos($field, ',') !== false) {
        $field = '"' . str_replace('"', '""', $field) . '"';
    }
    return $field;
}

// Solo manejar solicitudes POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitizar entradas
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $precio = isset($_POST['precio']) ? trim($_POST['precio']) : '';
    $cantidad = isset($_POST['cantidad']) ? trim($_POST['cantidad']) : '';

    $error = '';
    $success = '';

    // Validar entradas
    if ($nombre === '' || $precio === '' || $cantidad === '') {
        $error = "Por favor completa todos los campos.";
    } elseif (!is_numeric($precio) || !is_numeric($cantidad) || $precio < 0 || $cantidad < 0) {
        $error = "Precio y cantidad deben ser números no negativos.";
    } else {
        // Preparar línea CSV
        $line = implode(',', [
            escapeCSV($nombre),
            escapeCSV($precio),
            escapeCSV($cantidad)
        ]) . "\n";

        if (file_put_contents($file, $line, FILE_APPEND | LOCK_EX) !== false) {
            $success = "Datos guardados correctamente en productos.csv.";
        } else {
            $error = "Error al guardar los datos en el archivo.";
        }
    }
} else {
    $error = "Método no permitido.";
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
      background: #764ba2;
      color: white;
      padding: 12px 24px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: background 0.3s ease;
    }
    a.button:hover {
      background: #5a3580;
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
    <a href="formulario_productos.html" class="button">Volver al formulario</a>
  </div>
</body>
</html>
