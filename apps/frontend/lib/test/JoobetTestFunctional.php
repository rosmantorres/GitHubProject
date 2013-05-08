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
}

?>
