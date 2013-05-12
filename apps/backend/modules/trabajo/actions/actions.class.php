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
  
  public function executeListEnviarCorreo(sfWebRequest $request)
  {
    $trabajo = $this->getRoute()->getObject();
 
    $remitente = 'rosman_torres@hotmail.com';
    $para = array (
        $trabajo->getCorreo() => 'Sr. Compañia',
        'rosman_torres@gmail.com' => 'Rosman Torres',
    );
    $asunto = 'Mensaje enviado desde Symfony';
    $cuerpo = 'Esta es una prueba enviada desde la lista de trabajos del backend';
    
    // Creando el mensaje
    $mensaje = $this->getMailer()->compose($remitente,$para,$asunto,$cuerpo);
    
    // Enviando el mensaje
    $this->getMailer()->send($mensaje);
 
    $this->redirect('trabajo');
  }
}
