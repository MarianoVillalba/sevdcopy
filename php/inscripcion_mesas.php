<?php
session_start();

// **Recibí la conexión $con como parámetro en funciones o global** 
// (o asegurate de que $con esté accesible en el scope global)

// Función para verificar si el usuario está logueado y obtener el idestudiante
function obtenerIdEstudiante(mysqli $con) {
    if (!isset($_SESSION['idusuario'])) {
        // Podés lanzar una excepción o devolver null para manejarlo mejor
        throw new Exception("Debes iniciar sesión para ver las mesas.");
    }

    $idusuario = $_SESSION['idusuario'];
    $sql = "SELECT e.idestudiante FROM estudiantes e WHERE e.idusuario = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $idusuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $fila = $result->fetch_assoc();
    $stmt->close();

    if (!$fila) {
        throw new Exception("Estudiante no encontrado para el usuario.");
    }

    return $fila['idestudiante'];
}

// Función para obtener mesas disponibles para inscribir
function obtenerMesasDisponibles(mysqli $con, int $idestudiante) {
    $sql = "SELECT m.idmesa, m.fechahora, ma.nombre AS materia 
            FROM mesas m 
            JOIN materias ma ON m.idmateria = ma.idmateria 
            WHERE m.fechahora >= NOW()
              AND ma.idcarrera = (SELECT idcarrera FROM estudiantes WHERE idestudiante = ?) 
              AND m.idmesa NOT IN (SELECT idmesa FROM inscripciones WHERE idestudiante = ?) 
            ORDER BY m.fechahora";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $idestudiante, $idestudiante);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $mesas = $resultado->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $mesas;
}

// Función para inscribir un estudiante a una mesa
function preinscribirMesa(mysqli $con, int $idestudiante, int $idmesa) {
    // Obtener idmateria de la mesa
    $sql = "SELECT idmateria FROM mesas WHERE idmesa = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $idmesa);
    $stmt->execute();
    $result = $stmt->get_result();
    $fila = $result->fetch_assoc();
    $stmt->close();

    if (!$fila) {
        throw new Exception("No se encontró la materia para la mesa seleccionada.");
    }
    $idmateria = $fila['idmateria'];

    // Verificar si ya está inscrito
    $sql = "SELECT * FROM inscripciones WHERE idestudiante = ? AND idmesa = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $idestudiante, $idmesa);
    $stmt->execute();
    $result = $stmt->get_result();
    $existe = $result->num_rows > 0;
    $stmt->close();

    if ($existe) {
        throw new Exception("Ya estás pre-inscripto en esta mesa.");
    }

    // Insertar inscripción
    $sql = "INSERT INTO inscripciones (idestudiante, idmesa, idmateria, fechainscripcion, estado) 
            VALUES (?, ?, ?, NOW(), 'Pendiente')";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("iii", $idestudiante, $idmesa, $idmateria);

    if (!$stmt->execute()) {
        $stmt->close();
        throw new Exception("Error al realizar la pre-inscripción.");
    }
    $stmt->close();

    return true;
}

// Función para eliminar inscripción
function eliminarInscripcion(mysqli $con, int $idestudiante, int $idmesa) {
    $sql = "DELETE FROM inscripciones WHERE idestudiante = ? AND idmesa = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $idestudiante, $idmesa);

    if (!$stmt->execute()) {
        $stmt->close();
        throw new Exception("Error al eliminar la inscripción.");
    }
    $stmt->close();

    return true;
}

// Función para obtener inscripciones del estudiante
function obtenerInscripciones(mysqli $con, int $idestudiante) {
    $sql = "SELECT ma.nombre AS materia, m.fechahora, em.idmesa, em.estado 
            FROM inscripciones em 
            JOIN mesas m ON em.idmesa = m.idmesa 
            JOIN materias ma ON em.idmateria = ma.idmateria 
            WHERE em.idestudiante = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $idestudiante);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $inscripciones = $resultado->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $inscripciones;
}

// Tus funciones para testear
function periodoAbierto() {
    return true;
}

function alumnoSinRestricciones($alumnoId) {
    return true;
}

function formularioHabilitado() {
    return periodoAbierto() && alumnoSinRestricciones(123);
}

