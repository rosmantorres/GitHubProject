<div id="job_actions">
  <h3>Administrador</h3>
  <ul>
    <?php if (!$job->getEstaActivado()): ?>
      <li><?php echo link_to('Editiar', 'acciones_trabajo_edit', $job) ?></li>
      <li>
        <?php // echo link_to('Publicar', 'acciones_trabajo_edit', $job) ?>
        <?php echo link_to('Publicar', 'acciones_trabajo_publish', $job, array('method' => 'put')) ?>
      </li>
    <?php endif ?>
    <li>
      <?php echo link_to('Borrar', 'acciones_trabajo_delete', $job, 
            array('method' => 'delete', 'confirm' => 'Estás seguro?')) ?>
    </li>
    <?php if ($job->getEstaActivado()): ?>
      <li<?php $job->expiresSoon() and print ' class="expires_soon"' ?>>
        <?php if ($job->isExpired()): ?>
          Expirado
        <?php else: ?>
          Expira en <strong><?php echo $job->getDaysBeforeExpires() ?></strong> days
        <?php endif ?>

        <?php if ($job->expiresSoon()): ?>
          - <a href="">Extender</a> for another <?php echo sfConfig::get('app_active_days') ?> days
        <?php endif ?>
      </li>
    <?php else: ?>
      <li>
        [Bookmark this <?php echo link_to('URL', 'acciones_trabajo_show', $job, true) ?> to manage this job in the future.]
      </li>
    <?php endif ?>
  </ul>
</div>
