<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// variables
$max = sfConfig::get('app_max_trabajo_en_homepage');  
 
// Instancia de objeto de prueba funcional
$browser = new JobeetTestFunctional(new sfBrowser()); //$browser = new sfTestFunctional(new sfBrowser());
$browser->loadData();
 
// Pruebas
$browser->info('1 - The homepage')->
        get('/')->
        with('request')->begin()->
          isParameter('module', 'trabajo_module')->
          isParameter('action', 'index')->
        end()->
        with('response')->begin()->
          info('  1.1 - Trabajos expirados no son listados')->
          checkElement('.jobs td.position:contains("expired")', false)->
        end()->
        info(sprintf('  1.2 - Solo %s trabajos son listados para una categoria', $max))->
        with('response')->
          checkElement('.category_programacion tr', $max)->
        info('  1.3 - Una categoria tiene un link para su pagina solo si hay mas... trabajos')->
        with('response')->begin()->
          checkElement('.category_deseno .more_jobs', false)->
          checkElement('.category_programacion .more_jobs')->
        end()->
        info('  1.4 - Trabajos son ordenados por fecha ')->
        with('response')->begin()->
          checkElement(sprintf('.category_programacion tr:first a[href*="/%d/"]',
            $browser->getMostRecentProgrammingJob()->getId()))->
        end()
        ;

/*
 * Para probar el vínculo de un puesto en la página de inicio, simularemos un 
 * clic en el texto "Desarrollo Web". Como hay muchos de ellos en la página, 
 * hemos pedido explícitamente al navegador que haga clic en el primero 
 * (array('position' => 1)).Cada parámetro de la petición se prueba para 
 * asegurarte que la ruta ha hecho su trabajo correctamente.
 */
$job = $browser->getMostRecentProgrammingJob();
 
$browser->info('2 - La pagina de Trabajo')->
        get('/')->
        info('  2.1 - Cada puesto de trabajo en la página principal es cliqueable y da la informacion detallada')->
        click('Desarrollo Web', array(), array('position' => 1))->
        with('request')->begin()->
          isParameter('module', 'trabajo_module')->
          isParameter('action', 'show')->
          isParameter('compania_slug', $job->getCompaniaSlug())->
          isParameter('localizacion_slug', $job->getLocalizacionSlug())->
          isParameter('posicion_slug', $job->getPosicionSlug())->
          isParameter('id', $job->getId())->
        end()->
        
        info('  2.2 - A non-existent job forwards the user to a 404')->
        get('/job/foo-inc/milano-italy/0/painter')->
        with('response')->isStatusCode(404)->

        info('  2.3 - An expired job page forwards the user to a 404')->
        get(sprintf('/trabajo/compania/localizacion/%d/puesto', $job->getId()))->
        with('response')->isStatusCode(200)
      ;
