<?php

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
  public function executeIndex(sfWebRequest $request)
  {
    $this->trabajos = Doctrine_Core::getTable('Trabajo')
      ->createQuery('a')
      ->execute();
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
    $this->forward404Unless($trabajo = Doctrine_Core::getTable('Trabajo')->find(array($request->getParameter('id'))), sprintf('Object trabajo does not exist (%s).', $request->getParameter('id')));
    $this->form = new TrabajoForm($trabajo);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($trabajo = Doctrine_Core::getTable('Trabajo')->find(array($request->getParameter('id'))), sprintf('Object trabajo does not exist (%s).', $request->getParameter('id')));
    $this->form = new TrabajoForm($trabajo);

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
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $trabajo = $form->save();

      $this->redirect('trabajo_module/edit?id='.$trabajo->getId());
    }
  }
}
