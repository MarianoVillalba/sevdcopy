<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/inscripcion_mesas.php';

class PreinscripcionTest extends TestCase
{
    protected function setUp(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $_SESSION['idusuario'] = 1;
    }

    public function testPeriodoAbierto()
    {
        $this->assertTrue(periodoAbierto());
    }

    public function testAlumnoSinRestricciones()
    {
        $this->assertTrue(alumnoSinRestricciones(1));
    }

    public function testFormularioHabilitado()
    {
        $this->assertTrue(formularioHabilitado());
    }
}
