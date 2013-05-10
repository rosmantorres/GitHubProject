<?php

class myUser extends sfBasicSecurityUser
{
  public function addTrabajoAlHistorial(Trabajo $job)
  {    
    // Buscar trabajo ya almacenados en el historial de trabajo del usuario
    $ids = $this->getAttribute('historial_trabajo', array());
 
    // Un Trabajo no se puede almacenar dos veces en el historial
    if (!in_array($job->getId(), $ids))
    {
      // Añadir el trabajo actual en el principio de la matriz
      array_unshift($ids, $job->getId());
      
      // Almacenar el nuevo historial de trabajo, de nuevo en el período de sesiones
      // Sólo los 3 últimos puestos de trabajo vistos por el usuario se muestran
      $this->setAttribute('historial_trabajo', array_slice($ids, 0, 3));
    }
  }
  
  public function getHistorialTrabajo()
  {
    $ids = $this->getAttribute('historial_trabajo', array());
 
    if (!empty($ids))
    {
      return Doctrine_Core::getTable('Trabajo')
        ->createQuery('a')
        ->whereIn('a.id', $ids)
        ->execute()
      ;
    }
 
    return array();
  }
  
  public function resetHistorialTrabajo()
  {
    $this->getAttributeHolder()->remove('historial_trabajo');
  }
}
