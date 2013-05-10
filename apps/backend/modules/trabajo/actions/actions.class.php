<?php

require_once dirname(__FILE__).'/../lib/trabajoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/trabajoGeneratorHelper.class.php';

/**
 * trabajo actions.
 *
 * @package    PROYECTO_PRUEBA
 * @subpackage trabajo
 * @author     ROSMAN_TORRES
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class trabajoActions extends autoTrabajoActions
{
  public function executeBatchCambiarNombresCompania(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
 
    $q = Doctrine_Query::create()
      ->from('Trabajo j')
      ->whereIn('j.id', $ids);
 
    foreach ($q->execute() as $job)
    {
      $job->setCompania('Todos_Nombres_Cambiados');
      $job->save();
    }
 
    $this->getUser()->setFlash('notice', 'Los nombres de compañia fueron cambiados exitosamente.');
 
    $this->redirect('trabajo');
  }
  
  public function executeListRosman(sfWebRequest $request)
  {
    $job = $this->getRoute()->getObject();
    $job->setCompania('Solo_Este_Nombre_Cambiado');
    $job->save();
   
    $this->getUser()->setFlash('notice', 'El nombre de la compañia fue cambiado exitosamente.');
 
    $this->redirect('trabajo');
  }
}
