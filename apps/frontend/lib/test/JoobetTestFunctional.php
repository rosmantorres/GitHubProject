<?php

/**
 * Description of TrabajoTestFunctional
 *
 * @author rt999
 */
class JobeetTestFunctional extends sfTestFunctional
{
  public function loadData()
  {
    Doctrine_Core::loadData(sfConfig::get('sf_test_dir').'/fixtures');
 
    return $this;
  }
  
  public function getMostRecentProgrammingJob()
  {
    $q = Doctrine_Query::create()
      ->select('j.*')
      ->from('Trabajo j')
      ->leftJoin('j.Categoria c')
      ->where('c.slug = ?', 'programacion');
    $q = Doctrine_Core::getTable('Trabajo')->addActiveJobsQuery($q);
 
    return $q->fetchOne();
  }
  
  /*
   * El método crea un puesto de trabajo, sigue la redirección y regresa al 
   * navegador para no romper la fluidez de la navegación. Puedes también 
   * pasar un array de valores que se fusionará con algunos valores por defecto.
   */
  public function crearTrabajo($values = array())
  {
    return $this->
      get('/acciones_trabajo/new')->
      click('Vista previa del trabajo', array('trabajo' => array_merge(array(
                'compania'      => 'Sensio Labs',
                'url'           => 'http://www.sensio.com/',                
                'posicion'      => 'Developer',
                'localizacion'  => 'Atlanta, USA',
                'descripcion'   => 'You will work with symfony to develop websites for our customers.',
                'como_aplicar'  => 'Send me an email',
                'correo'        => 'for.a.job@example.com',
                'esta_publicado'=> false,
          ), $values)))->
            followRedirect()
          ;
  }
  
}

