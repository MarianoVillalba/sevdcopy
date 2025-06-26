<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../php/carga_notas.php';

class CargaNotasTest extends TestCase
{
    public function testValidarNota() {
        $this->assertTrue(validarNota(8));
        $this->assertFalse(validarNota(12));
    }

    public function testRolDocente() {
        $this->assertTrue(esRolDocente("docente"));
        $this->assertFalse(esRolDocente("alumno"));
    }
}
