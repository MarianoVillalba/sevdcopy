<?php
session_start();

// ✅ 1. FUNCIONES PARA CARGA DE NOTAS

function validarNota($nota) {
    return is_numeric($nota) && $nota >= 1 && $nota <= 10;
}

function esRolDocente($rol = null) {
    // Si se pasa el rol como parámetro (para tests), úsalo
    if ($rol !== null) return $rol === 'docente';
    return isset($_SESSION['rol']) && $_SESSION['rol'] === 'docente';
}

function cargarNota($idestudiante, $idmateria, $nota, mysqli $con, $rol = null) {
    if (!validarNota($nota)) {
        return ['error' => 'La nota no es válida'];
    }

    if (!esRolDocente($rol)) {
        return ['error' => 'Acceso no autorizado'];
    }

    $sql = "INSERT INTO notas (idestudiante, idmateria, nota, fecha) VALUES (?, ?, ?, NOW())";
    $stmt = $con->prepare($sql);
    if (!$stmt) {
        return ['error' => 'Error en la preparación de la consulta'];
    }

    $stmt->bind_param("iid", $idestudiante, $idmateria, $nota);

    if ($stmt->execute()) {
        return ['success' => 'Nota cargada correctamente'];
    } else {
        return ['error' => 'Error al cargar la nota'];
    }
}

// ✅ 2. BLOQUE PARA EJECUCIÓN NORMAL (NO TEST)

if (php_sapi_name() !== 'cli') {
    $_SESSION['rol'] = 'docente'; // Simula docente logueado
    $mensaje = "";

    // Conexión real
    $con = new mysqli('localhost', 'usuario', 'password', 'basededatos');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idestudiante = (int)$_POST['idestudiante'];
        $idmateria = (int)$_POST['idmateria'];
        $nota = $_POST['nota'];

        $resultado = cargarNota($idestudiante, $idmateria, $nota, $con);
        $mensaje = $resultado['success'] ?? $resultado['error'];
    }
    ?>

    <!-- ✅ FORMULARIO HTML -->
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Cargar Nota</title>
    </head>
    <body>
        <h2>Cargar Nota</h2>
        <?php if (!empty($mensaje)): ?>
            <p><strong><?php echo htmlspecialchars($mensaje); ?></strong></p>
        <?php endif; ?>
        <form method="post" action="">
            <label>Estudiante:
                <select name="idestudiante" required>
                    <option value="">Seleccione estudiante</option>
                    <option value="1">Estudiante 1</option> <!-- Simulado -->
                </select>
            </label><br><br>

            <label>Materia:
                <select name="idmateria" required>
                    <option value="">Seleccione materia</option>
                    <option value="1">Matemática</option> <!-- Simulado -->
                </select>
            </label><br><br>

            <label>Nota:
                <input type="number" name="nota" min="1" max="10" step="0.01" required>
            </label><br><br>

            <button type="submit">Cargar Nota</button>
        </form>
    </body>
    </html>
<?php } ?>
