<?php

/**
 * Trabajo
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    PROYECTO_PRUEBA
 * @subpackage model
 * @author     ROSMAN_TORRES
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Trabajo extends BaseTrabajo
{
  /*
   * Cuando necesitas hacer algo automáticamente antes que un objeto Doctrine 
   * sea guardado en la base de datos, puedes sobreescribir el método save() 
   * de la clase del modelo:
   */

  public function save(Doctrine_Connection $conn = null)
  {
    // El método isNew() devuelve true cuando el objeto no ha sido serializado 
    // aún en la base de datos,
    if ($this->isNew() && !$this->getExpiraEl()) {
      $now = $this->getCreatedAt() ? $this->getDateTimeObject('created_at')->format('U') : time();
      $this->setExpiraEl(date('Y-m-d H:i:s', $now + 86400 * sfConfig::get('app_dias_activo')));
    }

    if (!$this->getToken()) {
      $this->setToken(sha1($this->getCorreo() . rand(11111, 99999)));
    }

    return parent::save($conn);
  }

  /*
   * "Slugeando" valores de columnas mediante la sustitución de todos los 
   * caracteres no ASCII por un -. 
   */

  public function getCompaniaSlug()
  {
    return Jobeet::slugear($this->getCompania());
  }

  public function getPosicionSlug()
  {
    return Jobeet::slugear($this->getPosicion());
  }

  public function getLocalizacionSlug()
  {
    return Jobeet::slugear($this->getLocalizacion());
  }

}