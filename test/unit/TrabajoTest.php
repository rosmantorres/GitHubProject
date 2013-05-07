<?php

/*
 * Para ejecutar las pruebas:
 * $ php test/unit/TrabajoTest.php
 * $ php symfony test:unit Trabajo
 */

// Si se llama un metodo de otro lado, hay que incluirlo
require_once dirname(__FILE__) . '/../bootstrap/unit.php';
require_once dirname(__FILE__) . '/../../apps/frontend/lib/Jobeet.class.php';

/*
 * Es importante la descripción de cada prueba, para saber realmente lo que deseas
 * probar. Sirve tambien como documentación para el comportamiento esperado
 * del método. Es importante colocar en la descripcion el metodo (::slugear)
 */
$t = new lime_test(7);

$t->pass('Esta prueba siempre pasa.');
$t->is(Jobeet::slugear('Sensio'), 'sensio', '::slugear() convierte todos los caracteres a minusculas');
$t->is(Jobeet::slugear('sensio labs'), 'sensio-labs', 'reemplaza espacios en blancos por -');
$t->is(Jobeet::slugear('sensio   labs'), 'sensio-labs');
$t->is(Jobeet::slugear('paris,france'), 'paris-france', 'reemplaza caracteres no ascii');
$t->is(Jobeet::slugear('  sensio'), 'sensio');
$t->is(Jobeet::slugear('sensio  '), 'sensio');
$t->is(Jobeet::slugear(''), 'n-a', '::slugear() convierte el string vacio a n-a');
$t->is(Jobeet::slugear(' - '), 'n-a', '::slugear() convierte um string que solo caracteres no-ASCII');
if (function_exists('iconv'))
{  
  $t->is(Jobeet::slugear('Développeur Web'), 'developpeur-web', '::slugear() remover acentos');
}
else
{
  $t->skip('::slugify() remover acentos - iconv no instalado');
}

/*
 * Para ayudarte a comprobar que todo el código está bien probado, symfony 
 * proporciona la tarea test:coverage. Para esta tarea pasale un archivo o 
 * directorio test y un archivo o directorio lib un directorio como argumentos 
 * y te dirá el porcentaje de código de tu sistema que la prueba cubre:
 * 
 * $ php symfony test:coverage test/unit/TrabajoTest.php lib/Jobeet.class.php
 */

/*
 * Si quieres saber que líneas no están cubiertos por tus pruebas, usa la opción
 * --detailed:
 * 
 * $ php symfony test:coverage --detailed test/unit/TrabajoTest.php lib/Jobeet.class.php
 */
?>
