# SEVD
# Informe de Evaluación de Calidad y Cobertura

## 1. Herramientas utilizadas
- PHPUnit 11.5.23
- PHP 8.2.12 con Xdebug 3.4.4

## 2. Proceso realizado
- Desarrollo de tests unitarios para funcionalidades clave.
- Ejecución de tests y generación de reporte de cobertura.

## 3. Problemas encontrados y solución

### 3.1 Mensaje de error "Debes iniciar sesión para ver las mesas."

**Qué pasó:**  
Durante la ejecución de los tests para la preinscripción, los tests fallaban o terminaban con el mensaje  
*"Debes iniciar sesión para ver las mesas."*, ya que el código requiere que exista una sesión iniciada con el usuario.

**Por qué pasó:**  
Esto ocurre porque los tests de PHPUnit corren de manera aislada, sin variables de sesión ni contexto web real.

**Cómo lo resolví:**  
Para resolver esto, simulé la sesión iniciada dentro del test, inicializando la variable `$_SESSION['idusuario']` con un valor válido antes de ejecutar el código que depende de ella.

## 4. Resultados
- Tests ejecutados: 5
- Aserciones realizadas: 8
- Cobertura general: XX% (ver reporte en carpeta `coverage`)

## 5. Evidencias
- Capturas de pantalla de la consola mostrando tests exitosos.
- Capturas del reporte de cobertura en `coverage/index.html`.
