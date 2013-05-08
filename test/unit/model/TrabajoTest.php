<?php

/*
 * Para ejecutar las pruebas:
 * $ php test/unit/model/TrabajoTest.php
 * $ php symfony test:unit model/Trabajo
 * $ php symfony test:unit model/*
 */

/*
 * Estas pruebas son para el modelo Trabajo directamente con la base dedatos de
 * de prueba jobeet_test
 */

/*
 * http://ecapy.com/instalar-xdebug-en-windows-7-y-xampp/
 */

include(dirname(__FILE__) . '/../../bootstrap/Doctrine.php');

$t = new lime_test(3);

// 1era Prueba
$t->comment('::getCompaniaSlug()');
$trabajo = Doctrine_Core::getTable('Trabajo')->createQuery()->fetchOne();
$t->is($trabajo->getCompaniaSlug(), Jobeet::slugear($trabajo->getCompania()), '::getCompaniaSlug() return el slug para la compania ' . $trabajo->getCompania());

// 2da Prueba
$t->comment('::save()');
$job = create_job();
$job->save();
$expiresAt = date('Y-m-d', time() + 86400 * sfConfig::get('app_dias_activo'));
$t->is($job->getDateTimeObject('expira_el')->format('Y-m-d'), $expiresAt, 
        '::save() comprobando que el metodo save actualiza el campo expira_el');

// 3era Prueba
$job = create_job(array('expires_at' => '2008-08-08'));
$job->save();
$t->is($job->getDateTimeObject('expira_el')->format('Y-m-d'), '2013-06-07', '::save() comprobado si el save() funciona bien');

function create_job($defaults = array())
{
  static $category = null;

  if (is_null($category)) {
    $category = Doctrine_Core::getTable('Categoria')
            ->createQuery()
            ->limit(1)
            ->fetchOne();
  }

  $job = new Trabajo();
  $job->fromArray(array_merge(array(
      'categoria_id' => $category->getId(),
      'compania' => 'Sensio Labs',
      'posicion' => 'Senior Tester',
      'localizacion' => 'Paris, France',
      'descripcion' => 'Testing is fun',
      'como_aplicar' => 'Send e-Mail',
      'correo' => 'job@example.com',
      'token' => rand(1111, 9999),
      'esta_activado' => true,
                  ), $defaults));
  return $job;
}

?>
