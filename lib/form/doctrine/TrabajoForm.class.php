<?php

/**
 * Trabajo form.
 *
 * @package    PROYECTO_PRUEBA
 * @subpackage form
 * @author     ROSMAN_TORRES
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TrabajoForm extends BaseTrabajoForm
{
  public function configure()
  {
    unset(
      $this['created_at'], 
      $this['updated_at'],
      $this['expira_el'], 
      $this['esta_activado']      
    );
    
    /* 
     * Reemplar el validador por defecto no siempre es la mejor solución
     * $this->validatorSchema['correo'] = new sfValidatorEmail();
     * por eso es mejor agregar validadores con new sfValidatorAnd con el and 
     * se obliga a pasar todos los validadores pero con el or obliga a pasar al
     * menos uno. Ambos se pueden mezclar segun lo que se desee, creando complejos
     * validadores basados en booleanos
    */
    $this->validatorSchema['correo'] = new sfValidatorAnd(
            array($this->validatorSchema['correo'],new sfValidatorEmail(),));
    
    $this->widgetSchema['tipo'] = new sfWidgetFormChoice(
            array('choices'  => Doctrine_Core::getTable('Trabajo')->getTypes(),'expanded' => true,'multiple' => true));
  }  
}
