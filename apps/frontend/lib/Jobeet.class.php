<?php
/*
 * El concepto de Slug es un término adaptado del periodismo anglosajón y hace 
 * referencia al título de una noticia o artículo en el que se han sustituido 
 * los espacios en blanco por guiones y se han eliminado todos los caracteres 
 * que no sean letras o números.
 * ¿Que es Slug?, Slugeandolo queda como -> que-es-slug
 * 
 */
class Jobeet
{
  static public function slugear($text)
  {
    // Remplazar todo lo que no sea letras o digitos por -
    $text = preg_replace('/\W+/', '-', $text);
 
    // recortar y cambiar a minusculas
    $text = strtolower(trim($text, '-'));
 
    return $text;
  }
}
?>
