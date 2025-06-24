<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/carga_notas.php';  // Asegurate que la ruta sea correcta

class CargaNotasTest extends TestCase
{
    public function testNotaValida()
    {
        $this->assertTrue(validarNota(8));
        $this->assertFalse(validarNota(11));
    }

    public function testAccesoAutorizado()
    {
        $this->assertTrue(esRolDocente("docente"));
        $this->assertFalse(esRolDocente("alumno"));
    }
}
