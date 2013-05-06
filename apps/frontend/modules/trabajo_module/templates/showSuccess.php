<!-- apps/frontend/modules/job/templates/showSuccess.php -->
<?php use_stylesheet('job.css') ?>
<?php use_helper('Text') ?>
 
<?php slot('title') ?>
  <?php echo $job->getCompania().' '.$job->getPosicion() ?>
<?php end_slot(); ?>

<div id="job">
  <h1><?php echo $job->getCompania() ?></h1>
  <h2><?php echo $job->getLocalizacion() ?></h2>
  <h3>
    <?php echo $job->getPosicion() ?>
    <small> - <?php echo $job->getTipo() ?></small>
  </h3>
 
  <?php if ($job->getLogo()): ?>
    <div class="logo">
      <?php echo link_to(image_tag($job->getLogo(),'size=160x50'),$job->getUrl()) ?>      
    </div>
  <?php endif; ?>
 
  <div class="description">
    <?php echo simple_format_text($job->getDescripcion()) ?>
  </div>
 
  <h4>Como Aplica?</h4>
 
  <p class="how_to_apply"><?php echo $job->getComoAplicar() ?></p>
 
  <div class="meta">
    <small>posted on <?php echo $job->getDateTimeObject('created_at')->format('m/d/Y') ?></small>
  </div>
 
  <div style="padding: 20px 0">
    <?php echo link_to('Editar',  url_for('trabajo_module/edit?id='.$job->getId())) ?>    
  </div>
</div>

<?php /*
<?php use_stylesheet('job.css') ?>
<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $trabajo->getId() ?></td>
    </tr>
    <tr>
      <th>Categoria:</th>
      <td><?php echo $trabajo->getCategoriaId() ?></td>
    </tr>
    <tr>
      <th>Tipo:</th>
      <td><?php echo $trabajo->getTipo() ?></td>
    </tr>
    <tr>
      <th>Compania:</th>
      <td><?php echo $trabajo->getCompania() ?></td>
    </tr>
    <tr>
      <th>Logo:</th>
      <td><?php echo $trabajo->getLogo() ?></td>
    </tr>
    <tr>
      <th>Url:</th>
      <td><?php echo $trabajo->getUrl() ?></td>
    </tr>
    <tr>
      <th>Posicion:</th>
      <td><?php echo $trabajo->getPosicion() ?></td>
    </tr>
    <tr>
      <th>Localizacion:</th>
      <td><?php echo $trabajo->getLocalizacion() ?></td>
    </tr>
    <tr>
      <th>Descripcion:</th>
      <td><?php echo $trabajo->getDescripcion() ?></td>
    </tr>
    <tr>
      <th>Como aplicar:</th>
      <td><?php echo $trabajo->getComoAplicar() ?></td>
    </tr>
    <tr>
      <th>Token:</th>
      <td><?php echo $trabajo->getToken() ?></td>
    </tr>
    <tr>
      <th>Esta publicado:</th>
      <td><?php echo $trabajo->getEstaPublicado() ?></td>
    </tr>
    <tr>
      <th>Esta activado:</th>
      <td><?php echo $trabajo->getEstaActivado() ?></td>
    </tr>
    <tr>
      <th>Correo:</th>
      <td><?php echo $trabajo->getCorreo() ?></td>
    </tr>
    <tr>
      <th>Expira el:</th>
      <td><?php echo $trabajo->getExpiraEl() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $trabajo->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $trabajo->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('trabajo_module/edit?id='.$trabajo->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('trabajo_module/index') ?>">List</a>
 * 
 */ ?>
