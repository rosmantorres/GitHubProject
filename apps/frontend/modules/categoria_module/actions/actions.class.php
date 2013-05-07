<?php

/**
 * categoria_module actions.
 *
 * @package    PROYECTO_PRUEBA
 * @subpackage categoria_module
 * @author     ROSMAN_TORRES
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class categoria_moduleActions extends sfActions {

  public function executeShow(sfWebRequest $request)
  {
    $this->category = $this->getRoute()->getObject();
  }
}
