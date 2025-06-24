<?php
use PHPUnit\Framework\TestCase;

// Incluí el archivo con las funciones que querés testear
require_once __DIR__ . '/../php/inscripcion_mesas.php';

class PreinscripcionTest extends TestCase
{
    protected function setUp(): void
    {
        // Iniciar sesión si no está activa
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        // Simular usuario logueado con idusuario = 1 (ajustá según tu DB)
        $_SESSION['idusuario'] = 1;
    }

    public function testPeriodoAbierto()
    {
        $this->assertTrue(periodoAbierto());
    }

    public function testAlumnoSinRestricciones()
    {
        // Podés pasar cualquier id de alumno válido o simulado
        $this->assertTrue(alumnoSinRestricciones(1));
    }

    public function testFormularioHabilitado()
    {
        $this->assertTrue(formularioHabilitado());
    }
}
