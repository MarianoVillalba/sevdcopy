<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function periodoAbierto() {
    return true;
}

function alumnoSinRestricciones($alumnoId) {
    return true;
}

function formularioHabilitado() {
    return periodoAbierto() && alumnoSinRestricciones(123);
}
