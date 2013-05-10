<?php

/*
 * se tuvo que cambiar de sfBasicSecurityUser a sfGuardSecurityUser ya que 
 * sfDoctrineGuardPlugin agrega varios métodos a la clase de usuario, por lo tanto
 * es necesario cambiar la de herencia de la clase myUser
 */
class myUser extends sfGuardSecurityUser
{
}
