<?php use_stylesheet('jobs.css') ?>
 
<?php slot('title', sprintf('Jobs in the %s category', $category->getNombre())) ?>
 
<div class="category">
  <div class="feed">
    <a href="">Feed</a>
  </div>
  <h1><?php echo $category ?></h1>
</div>
 
<?php include_partial('trabajo_module/listarTrabajosActivos', 
        array('jobs' => $category->getTrabajosActivos())) ?>