<table class="jobs">
  <?php foreach ($jobs as $i => $job): ?>
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