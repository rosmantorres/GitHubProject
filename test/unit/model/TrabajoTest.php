<?php
/*
 * Para ejecutar las pruebas:
 * $ php test/unit/model/TrabajoTest.php
 * $ php symfony test:unit 'model/Trabajo'
 */

/*
 * Estas pruebas son para el modelo Trabajo directamente con la base dedatos de
 * de prueba jobeet_test
 */

/*
 * http://ecapy.com/instalar-xdebug-en-windows-7-y-xampp/
 */
$t = new lime_test(1);

$t->pass('Esta prueba siempre pasa.');
?>
