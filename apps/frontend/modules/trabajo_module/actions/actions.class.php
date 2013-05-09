<?php

/* Lic pegy freiter 2pm 0212-9935058 */

/**
 * trabajo_module actions.
 *
 * @package    PROYECTO_PRUEBA
 * @subpackage trabajo_module
 * @author     ROSMAN_TORRES
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class trabajo_moduleActions extends sfActions
{

  public function executePDO(sfWebRequest $request)
  {
    $this->consulta = Doctrine_Core::getTable('Trabajo')->getAlgo();
  }

  public function executeIndex(sfWebRequest $request)
  {
    /*
     * Selecciona todos los puestos de trabajo.
     */
    /* $this->trabajos = Doctrine_Core::getTable('Trabajo')
      ->createQuery('a')
      ->execute(); */

    /*
     * Selecciona solo los puestos de trabajos acivos Doctrine_Query::create()
     */
    /* $this->trabajos = Doctrine_Query::create()
      ->from('Trabajo t')
      ->where('t.expira_el > ?', date('Y-m-d h:i:s', time()))
      ->execute(); */

    /*
     * Selecciona solo los puestos de trabajos acivos pero con 
     * Doctrine_Core::getTable('Trabajo'). Mejor manera
     */
    /* $this->trabajos = Doctrine_Core::getTable('Trabajo')
      ->createQuery('t')
      ->where('t.expira_el > ?', date('Y-m-d h:i:s', time()))
      ->execute(); */

    /*
     * Las acciones (Controlador) no debe contener codigo del modelo, como se 
     * hizo en las consultas de arriba. En el modelo MVC, el modelo define toda 
     * la lógica de negocios, y el Controlador solo invoca al o los metodos 
     * del modelo para obtener los datos de éste.
     */
    //$this->trabajos = Doctrine_Core::getTable('Trabajo')->getTrabajosActivos();


    $this->categorias = Doctrine_Core::getTable('Categoria')->getConTrabajos();
  }

  public function executeShow(sfWebRequest $request)
  {
// El sub-framework de rutas tambien 
// es capaz de encontrar el objeto en relación con una determinada URL
    $this->job = $this->getRoute()->getObject();
    /*
      $this->trabajo = Doctrine_Core::getTable('Trabajo')->find($request->getParameter('id'));
      $this->job = $this->trabajo;
     * 
     */
    $this->forward404Unless($this->job);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new TrabajoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new TrabajoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    //$this->forward404Unless($trabajo = Doctrine_Core::getTable('Trabajo')->find(array($request->getParameter('id'))), sprintf('Object trabajo does not exist (%s).', $request->getParameter('id')));
    $this->forward404Unless($this->getRoute()->getObject());
    $this->form = new TrabajoForm($this->getRoute()->getObject());
  }

  public function executeUpdate(sfWebRequest $request)
  {
    //$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    //$this->forward404Unless($trabajo = Doctrine_Core::getTable('Trabajo')->find(array($request->getParameter('id'))), sprintf('Object trabajo does not exist (%s).', $request->getParameter('id')));
    $this->form = new TrabajoForm($this->getRoute()->getObject());

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($trabajo = Doctrine_Core::getTable('Trabajo')->find(array($request->getParameter('id'))), sprintf('Object trabajo does not exist (%s).', $request->getParameter('id')));
    $trabajo->delete();

    $this->redirect('trabajo_module/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind(
            $request->getParameter($form->getName()), $request->getFiles($form->getName())
    );

    if ($form->isValid()) {
      $trabajo = $form->save();
      //$this->redirect('trabajo_module/edit?id=' . $trabajo->getId());
      $this->redirect($this->generateUrl('acciones_trabajo_show', $trabajo));
    }
  }  
  
  public function executePublish(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $job = $this->getRoute()->getObject();
    $job->publish();

    $this->getUser()->setFlash('notice', sprintf('Tu trabajo esta ahora en linea por %s dias.', sfConfig::get('app_dias_activo')));

    $this->redirect($this->generateUrl('@mostrar_trabajo', $job));
  }
  
  public function publish()
  {
    $this->setEstaActivado(true);
    $this->save();  
  }
}

