<?php

/**
 * categoria_module actions.
 *
 * @package    PROYECTO_PRUEBA
 * @subpackage categoria_module
 * @author     ROSMAN_TORRES
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class categoria_moduleActions extends sfActions
{

  public function executeShow(sfWebRequest $request)
  {
    $this->category = $this->getRoute()->getObject();

    /*
     * Para paginar una lista de un Objetos Doctrine, symfony proporciona una 
     * clase dedicada: sfDoctrinePager. En lugar de pasar los objetos (jobs) 
     * de los puestos de trabajo a la plantilla, pasamos un paginador.
     */
    $this->pager = new sfDoctrinePager('Trabajo', sfConfig::get('app_max_trabajo_en_categoria'));

    $this->pager->setQuery($this->category->getActiveJobsQuery());
    
    /*
     * El método sfRequest::getParameter() toma un valor por defecto como 
     * segundo argumento. Si el parámetro de la petición page no existe, 
     * entonces getParameter() devolverá 1.
     */
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

}
