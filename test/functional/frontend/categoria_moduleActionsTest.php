<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');
 
$browser = new JobeetTestFunctional(new sfBrowser());
$browser->loadData();
 
$browser->info('1 - Pagina de la categoria especifica')->
  info('  1.1 - Las categorias son clickable')->
  get('/')->
  click('Programacion')->
  with('request')->begin()->
    isParameter('module', 'categoria_module')->
    isParameter('action', 'show')->
    isParameter('slug', 'programacion')->
  end()->
 
  info(sprintf('  1.2 - Categorias con mas de %s trabajos siempre tienen un link "mas"',
          sfConfig::get('app_max_trabajo_en_homepage')))->
  get('/')->
  click('11')->
  with('request')->begin()->
    isParameter('module', 'categoria_module')->
    isParameter('action', 'show')->
    isParameter('slug', 'programacion')->
  end()->

  info(sprintf('  1.3 - Solo %s trabajos son listados en la categoria',
          sfConfig::get('app_max_trabajo_en_categoria')))->        
  with('response')->checkElement('.jobs tr', sfConfig::get('app_max_trabajo_en_homepage'))->
  
  info('  1.4 - Los trabajos listados estan paginados')->
  with('response')->begin()->
    checkElement('.pagination_desc', '/21 trabajos en esta categoria/')->
    checkElement('.pagination_desc', '#page 1/2#')->
  end()->
 
  click('2')->
  with('request')->begin()->
    isParameter('page', 2)->
  end()->
  with('response')->checkElement('.pagination_desc', '#page 2/2#')

;
