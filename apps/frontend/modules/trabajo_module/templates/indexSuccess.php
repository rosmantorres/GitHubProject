<!-- apps/frontend/modules/job/templates/indexSuccess.php -->
<?php use_stylesheet('jobs.css') ?> 

<div id="jobs">
  <?php foreach ($categorias as $category): ?>
    <div class="category_<?php echo Jobeet::slugear($category->getNombre()) ?>">
      <div class="category">
        <div class="feed">
          <a href="">Feed</a>
        </div>
        <h1><?php echo link_to($category, 'mostrar_categoria', $category) ?></h1>
      </div>
 
      <table class="jobs">
        <?php foreach ($category->getTrabajosActivos(
                sfConfig::get('app_max_trabajo_en_homepage')) as $i => $job): ?>
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
      <?php if (($count = $category->countActiveJobs() - sfConfig::get('app_max_trabajo_en_homepage')) > 0): ?>
        <div class="more_jobs">
          y <?php echo link_to($count, 'mostrar_categoria', $category) ?>
          mas...
        </div>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>



<?php /*
<div id="jobs">
  <table class="jobs">  
    <?php foreach ($trabajos as $i => $job): ?>
      <tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
        <td class="location"><?php echo $job->getLocalizacion() ?></td>
        <td class="position">
          <!-- 1era Opcion = Es mucho más rápido ya que el enrutamiento no tiene
                             que analizar todas las rutas para encontrar el mejor
                             patrón coincidente. Busca directamente. --> 
 */?>
          <?php /*  echo link_to($job->getPosicion(),
                  url_for('@mostrar_trabajo?module=trabajo_module&action=show&id='.
                          $job->getId().'&compania='.$job->getCompania().'&posicion='.
                          $job->getPosicion().'&localizacion='.$job->getLocalizacion())) */ ?>
          <!-- 2da Opcion = Muy parecida a la manera tradicional y tambien a la
                            1era opcion, solo que esta si busca la ruta que coincida. -->
          <?php /* echo link_to($job->getPosicion(),
                  url_for('trabajo_module/show?id='.
                          $job->getId().'&compania='.$job->getCompania().'&posicion='.
                          $job->getPosicion().'&localizacion='.$job->getLocalizacion())) */ ?>
          <!-- 3ra Opcion = Es la misma que la 2da opcion pero con un array. -->
          <?php /* echo link_to($job->getPosicion(),
                                url_for(array('module'   => 'trabajo_module',
                                              'action'   => 'show',
                                              'id'       => $job->getId(),
                                              'compania'  => $job->getCompania(),
                                              'localizacion' => $job->getLocalizacion(),
                                              'posicion' => $job->getPosicion(),))
                  ) */ ?>        
          <!-- Opcion Extra = Solo si la ruta fue definida con sfDoctrineRoute en routing.yml -->
<!-- este si va descomentado -->         <?php /* echo link_to($job->getPosicion(), url_for('mostrar_trabajo', $job)) */ ?>
          <!-- Nota = Si no indicamos la ruta especifica -->         
          <?php /* echo link_to($job->getPosicion(), url_for('acciones_trabajo_show',$job)) */ ?>          
<?php /*          
        </td>
        <td class="company"><?php echo $job->getCompania() ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>
*/ ?>
<?php /*
<?php use_stylesheet('jobs.css') ?>
<h1>Lista de Trabajo</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Categoria</th>
      <th>Tipo</th>
      <th>Compania</th>
      <th>Logo</th>
      <th>Url</th>
      <th>Posicion</th>
      <th>Localizacion</th>
      <th>Descripcion</th>
      <th>Como aplicar</th>
      <th>Token</th>
      <th>Esta publicado</th>
      <th>Esta activado</th>
      <th>Correo</th>
      <th>Expira el</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($trabajos as $trabajo): ?>
    <tr>
      <td>
          <a href="<?php echo url_for('trabajo_module/show?id='.$trabajo->getId()) ?>">
          <?php echo $trabajo->getId() ?>
          </a>
      </td>
      <td><?php echo $trabajo->getCategoria().' - Id('.$trabajo->getCategoriaId().')' ?></td>
      <td><?php echo $trabajo->getTipo() ?></td>
      <td><?php echo $trabajo->getCompania() ?></td>
      <td><?php echo $trabajo->getLogo() ?></td>
      <td><?php echo $trabajo->getUrl() ?></td>
      <td><?php echo $trabajo->getPosicion() ?></td>
      <td><?php echo $trabajo->getLocalizacion() ?></td>
      <td><?php echo $trabajo->getDescripcion() ?></td>
      <td><?php echo $trabajo->getComoAplicar() ?></td>
      <td><?php echo $trabajo->getToken() ?></td>
      <td><?php echo $trabajo->getEstaPublicado() ?></td>
      <td><?php echo $trabajo->getEstaActivado() ?></td>
      <td><?php echo $trabajo->getCorreo() ?></td>
      <td><?php echo $trabajo->getExpiraEl() ?></td>
      <td><?php echo $trabajo->getCreatedAt() ?></td>
      <td><?php echo $trabajo->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<a href="<?php echo url_for('trabajo_module/new') ?>">New</a>

 */ ?>