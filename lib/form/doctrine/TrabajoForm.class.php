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
      $this['esta_activado'],
      $this['token']
    );
    
    /* 
     * Reemplar el validador por defecto no siempre es la mejor solución
     * $this->validatorSchema['correo'] = new sfValidatorEmail();
     * por eso es mejor agregar validadores con new sfValidatorAnd con el and 
     * se obliga a pasar todos los validadores pero con el or obliga a pasar al
     * menos uno. Ambos se pueden mezclar segun lo que se desee, creando complejos
     * validadores basados en booleanos
    */
    
    // Agregandole un validador al widget del correo
    $this->validatorSchema['correo'] = new sfValidatorAnd(
            array($this->validatorSchema['correo'],new sfValidatorEmail(),));
    
    // Cambiando el widget del tipo de trabajo a un widget choice (select) 
    $this->widgetSchema['tipo'] = new sfWidgetFormChoice(
            array('choices'  => Doctrine_Core::getTable('Trabajo')->getTypes(),
                  'expanded' => false,
                  'multiple' => false,));
    
    // Creandole un validador al widget anterior
    $this->validatorSchema['tipo'] = new sfValidatorChoice(
            array('choices' => array_keys(Doctrine_Core::getTable('Trabajo')->getTypes()),));
    
    // Cambiando el widget del logo a un widget de tipo file (archivo)
    $this->widgetSchema['logo'] = new sfWidgetFormInputFile(
            array('label' => 'Logo compañia',));
    
    $this->widgetSchema['logo'] = new sfWidgetFormInputFileEditable(array(
      'label'     => 'Company logo',
      'file_src'  => '/uploads/logos_compania/'.$this->getObject()->getLogo(),
      'is_image'  => true,
      'edit_mode' => !$this->isNew(),
      'template'  => '<div>%file%<br />%input%<br />%delete% %delete_label%</div>',
    ));
 
    $this->validatorSchema['logo_delete'] = new sfValidatorPass();
    
    /*
     * Creandole un validador al widget anterior. sfValidatorFile es muy 
     * interesante ya que hace una serie de cosas: 
     *    Valida que el archivo subido es una imagen en un formato web (mime_types)
     *    Cambia el nombre del archivo a algo único
     *    Almacena el archivo en un path dado
     *    Actualiza la columna logo con el nombre generado
     */
    $this->validatorSchema['logo'] = new sfValidatorFile(
            array('required'   => false,
                  'path'       => sfConfig::get('sf_upload_dir').'/logos_compania',
                  'mime_types' => 'web_images',));
    
    // Agregando un msj de ayuda
    $this->widgetSchema->setHelp('esta_publicado', 
            'El trabajo puede ser publicado o no en la pag web afiliada.');
    
    // Cambiando el nombre al formulario para que sea mas limpio a la hora de
    // obtener los campos -> se puede ver viendo el codigo fuente en el navegador
    //$this->widgetSchema->setNameFormat('campo[%s]_trabajo');
  }  
}
