<?php

include(dirname(__FILE__).'/unit.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'test', true);

new sfDatabaseManager($configuration);

/*
 * Datos de Prueba : para la BD de pruebas (jobeet_test), tenemos que llenarla
 * con datos de pruebas, pero es necesario volver a cargar los datos cada vez 
 * que ejecutamos las pruebas para conocer el estado inicial de la BD.
 * La tarea doctrine:data-load internamente utiliza el método 
 * Doctrine_Core::loadData() para cargar los datos y El objeto sfConfig puede
 * ser utilizado para obtener la ruta completa de un sub-directorio del proyecto.
 */
Doctrine_Core::loadData(sfConfig::get('sf_test_dir').'/fixtures');
?>
