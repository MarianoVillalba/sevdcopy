1. Herramientas utilizadas
•	PHPUnit 11.5.23: Framework para pruebas unitarias en PHP.
•	PHP 8.2.12: Versión del lenguaje usada para el desarrollo y pruebas.
•	Xdebug 3.4.4: Herramienta para generación de reportes de cobertura de código.
2. Proceso realizado
•	Se desarrollaron tests unitarios para las funcionalidades principales del módulo de pre-inscripción a mesas de examen.
•	Se configuró PHPUnit para la ejecución de las pruebas.
•	Se corrigieron errores relacionados con la dependencia del estado de sesión ($_SESSION['idusuario']) durante las pruebas, simulando una sesión activa en el entorno de testeo.
•	Se ejecutaron los tests y se generó el reporte de cobertura de código para medir qué porcentaje del código fue cubierto por las pruebas.
3. Resultados
•	Tests ejecutados: 3 tests unitarios para validar el estado del periodo, las restricciones del alumno y la habilitación del formulario.
•	Aserciones realizadas: 3 aserciones realizadas, todas exitosas.
•	Cobertura de código: Cobertura general del 100% para las funciones testeadas (periodoAbierto, alumnoSinRestricciones y formularioHabilitado).
•	Errores detectados: Inicialmente, las pruebas fallaban debido a que el código dependía de una sesión activa, la cual no existía en el entorno de pruebas. Este problema fue resuelto simulando la sesión en el setup de los tests.
4. Dificultades encontradas y soluciones
•	Dependencia de sesión:
o	Problema: Al ejecutar PHPUnit, el código requería que el usuario estuviera logueado, mostrando el mensaje "Debes iniciar sesión para ver las mesas."
o	Solución: Se modificó el test para iniciar la sesión y establecer una variable $_SESSION['idusuario'] simulada antes de ejecutar el código, garantizando así un contexto válido para las pruebas.
•	Organización del código:
o	Problema: La lógica dependía de código ejecutado directamente en el archivo global, dificultando su prueba.
o	Solución: Se refactorizó la lógica para encapsular funcionalidades dentro de funciones, facilitando su llamada y prueba independiente en PHPUnit.
5. Herramientas y recursos usados
•	XAMPP para el entorno local de desarrollo.
•	Composer para la instalación de PHPUnit.
•	PHPUnit configurado mediante archivo phpunit.xml.
6. Evidencias
•	Capturas de pantalla con la ejecución exitosa de los tests.
•	Reportes de cobertura generados y guardados en la carpeta coverage/.
•	Código fuente comentado y organizado para facilitar mantenimiento y pruebas.
