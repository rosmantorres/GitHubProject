<?php

include(dirname(__FILE__) . '/../../bootstrap/functional.php');

// variables
$max = sfConfig::get('app_max_trabajo_en_homepage');

// Instancia de objeto de prueba funcional
$browser = new JobeetTestFunctional(new sfBrowser()); //$browser = new sfTestFunctional(new sfBrowser());
$browser->loadData();

// Como el tester de Doctrine no está registrado por defecto, vamos a añadirlo ahora al navegador:
$browser->setTester('doctrine', 'sfTesterDoctrine');

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
          checkElement(sprintf('.category_programacion tr:first a[href*="/%d/"]', $browser->getMostRecentProgrammingJob()->getId()))->
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
        
        info('  2.2 - La ruta no es conocida -> ver ruta mostrar_trabajo')->
        get('/job/foo-inc/milano-italy/0/painter')->
        with('response')->isStatusCode(404)->
        
        info('  2.3 - La ruta si es conocida -> ver ruta mostrar_trabajo')->        
        get(sprintf('/trabajo/compania/localizacion/%d/puesto', $job->getId()))->
        with('response')->isStatusCode(200)
        ;

$browser->info('3 - Pagina de postear un trabajo')->
        info('  3.1 - Entrando a la pagina de crear un trabajo')->
        get('/acciones_trabajo/new')->
        with('request')->begin()->
          isParameter('module', 'trabajo_module')->
          isParameter('action', 'new')->
        end()->
        
        info('  3.2 - Clickeamos y comprobamos que se envia el formulario')->
        click('Vista previa del trabajo', array(
            'job' => array(
                'company'        => 'Sensio Labs',               
                'correo'         => 'sincorreo.',
                'esta_publicado' => false,)))->
        
        info('  3.3 - Despues de enviar el formularios comprobamos que la accion ejecutada es create')->
        with('request')->begin()->
          isParameter('module', 'trabajo_module')->
          isParameter('action', 'create')->
        end()->        
        
        info('  3.4 - Comprobamos que el formulario que enviamos es invalido, conteniendo errores')->
        with('form')->begin()->
          hasErrors(true)->
        end()->        
        
        /*
         * El método hasErrors() puede poner a prueba el número de errores si 
         * se pasa un entero. El método isError() prueba el código de error 
         * para un determinado campo.
         */
        info('  3.4.1 - Comprobamos que el formulario que enviamos es invalido, conteniendo errores')->
        with('form')->begin()->
          hasErrors(3)->
          isError('descripcion', 'required')->
          isError('como_aplicar', 'required')->
          isError('correo', 'invalid')->
        end()->
        
        info('  3.5 - Clickeamos ')->
        click('Vista previa del trabajo', array(
            'trabajo' => array(
                'compania'      => 'Sensio Labs',
                'url'           => 'http://www.sensio.com/',
                'logo'          => sfConfig::get('sf_upload_dir').'/jobs/sensio-labs.gif',
                'posicion'      => 'Developer',
                'localizacion'  => 'Atlanta, USA',
                'descripcion'   => 'You will work with symfony to develop websites for our customers.',
                'como_aplicar'  => 'Send me an email',
                'correo'        => 'for.a.job@example.com',
                'esta_publicado'=> false,)))->
        
        info('  3.6 - comprobamos que se envia el formulario ')->
        with('request')->begin()->
          isParameter('module', 'trabajo_module')->
          isParameter('action', 'create')->
        end()->
        
        info('  3.7 - Comprobamos que el formulario que enviamos es valido, sin errores')->
        with('form')->begin()->
          hasErrors(false)->
        end()->               
        
        /*
         * El método isRedirected() prueba si la página se ha redireccionado y 
         * el método followRedirect() sigue la redirección.
         */
        //isRedirected()->
        //followRedirect()->

        /*
        info('  3.8 - Como el formulario es válido, el puesto de trabajo debería haber sido creado y el usuario se redirige a la página show:')->
        with('request')->begin()->
          isParameter('module', 'trabajo_module')->
          isParameter('action', 'show')->
        end()->
        */
        
        // Si queremos debugear tiene que ser al final
        //info('  3.9 - Debugeamos')->
        //with('form')->debug()   
        
        with('doctrine')->begin()->
          check('Trabajo', array(
            'localizacion'   => 'Atlanta, USA',
            'esta_activado'  => false,
            'esta_publicado' => false,))->
        end()->
        
        /*
         * Forzando al Método HTTP de un Enlace
         * El enlace "Publish" se ha configurado para ser llamado con el método 
         * HTTP PUT. Como los navegadores no entienden peticiones PUT, el helper
         * link_to() convierte el enlace en un formulario con algun JavaScript. 
         * Como el test browser no ejecuta JavaScript, es necesario forzar el 
         * método a PUT pasandolo como una tercera opción del método click(). 
         * Por otra parte, la helper link_to() también incluye un CSRF token ya 
         * que hemos habilitado la protección CSRF durante el día 1; la opción 
         * _with_csrf simula este token
         */
        info('  3.10 - En la pag previa, se puede publicar el trabajo')->
        crearTrabajo(array('posicion' => 'FOO1'))->
        click('Publicar', array(), array('method' => 'put', '_with_csrf' => true))->

        with('doctrine')->begin()->
          check('Trabajo', array(
            'posicion'     => 'FOO1',
            'esta_activado' => true,
          ))->
        end()
        
        /*
        click('Borrar', array(), array('method' => 'delete', '_with_csrf' => true))->
 
        with('doctrine')->begin()->
          check('Trabajo', array(
            'position' => 'FOO2',
          ), false)->
        end()
         * 
         */
        ;

$browser->
        info('4 - Historial de trabajos visto de un usuario')->

        loadData()->
        restart()->

        info('  4.1 - Cuando el usuario accede a un trabajo este es guardardo en su historial')->
        get('/')->
        click('Desarrollo Web', array(), array('position' => 1))->
        get('/')->
        with('user')->begin()->
          isAttribute('historial_trabajo', array($browser->getMostRecentProgrammingJob()->getId()))->
        end()->

        info('  4.2 - Un trabajo no es agregado dos veces')->
        click('Desarrollo Web', array(), array('position' => 1))->
        get('/')->
        with('user')->begin()->
          isAttribute('historial_trabajo', array($browser->getMostRecentProgrammingJob()->getId()))->
        end()
      ;