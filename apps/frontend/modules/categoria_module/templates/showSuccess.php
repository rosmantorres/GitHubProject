<?php use_stylesheet('jobs.css') ?>
 
<?php slot('title', sprintf('Jobs in the %s category', $category->getNombre())) ?>
 
<div class="category">
  <div class="feed">
    <a href="">Feed</a>
  </div>
  <h1><?php echo $category ?></h1>
</div>
 
<table class="jobs">
  <?php foreach ($category->getTrabajosActivos() as $i => $job): ?>
    <tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
      <td class="location">
        <?php echo $job->getLocalizacion() ?>
      </td>
      <td class="position">
        <?php echo link_to($job->getPosicion(), 'mostrar_trabajo', $job) ?>
      </td>
      <td class="company">
        <?php echo $job->getCompania() ?>
      </td>
    </tr>
  <?php endforeach; ?>
</table>