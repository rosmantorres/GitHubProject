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
    // No reemplazar letras o digitos por
    $text = preg_replace('#[^\\pL\d]+#u', '-', $text);

    // recortar
    $text = trim($text, '-');

    // transliterate -> transcribir
    if (function_exists('iconv')) {
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    }

    // minuscula
    $text = strtolower($text);

    // Eliminar caracteres no deseados
    $text = preg_replace('#[^-\w]+#', '', $text);

    if (empty($text)) {
      return 'n-a';
    }

    return $text;
  }

}

?>
