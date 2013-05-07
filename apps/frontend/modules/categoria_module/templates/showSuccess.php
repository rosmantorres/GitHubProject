<?php use_stylesheet('jobs.css') ?>
 
<?php slot('title', sprintf('Trabajos de la categoria %s', $category->getNombre())) ?>
 
<div class="category">
  <div class="feed">
    <a href="">Feed</a>
  </div>
  <h1><?php echo $category ?></h1>
</div>
 
<?php include_partial('trabajo_module/listarTrabajosActivos', 
        array('jobs' => $category->getTrabajosActivos())) ?>


<!-- Bloque de la paginacion -->
<?php if ($pager->haveToPaginate()): ?>
  <div class="pagination">  
    <?php // echo link_to(image_tag('first.png'),url_for('mostrar_categoria', $category)) ?>
    <a href="<?php echo url_for('mostrar_categoria', $category) ?>?page=1">
      <img src="/images/first.png" alt="First page" title="1era página" />
    </a>
 
    <a href="<?php echo url_for('mostrar_categoria', $category) ?>?page=<?php echo $pager->getPreviousPage() ?>">
      <img src="/images/previous.png" alt="Previous page" title="Previous page" />
    </a>
 
    <?php foreach ($pager->getLinks() as $page): ?>
      <?php if ($page == $pager->getPage()): ?>
        <?php echo $page ?>
      <?php else: ?>
        <a href="<?php echo url_for('mostrar_categoria', $category) ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
 
    <a href="<?php echo url_for('mostrar_categoria', $category) ?>?page=<?php echo $pager->getNextPage() ?>">
      <img src="/images/next.png" alt="Next page" title="Next page" />
    </a>
 
    <a href="<?php echo url_for('mostrar_categoria', $category) ?>?page=<?php echo $pager->getLastPage() ?>">
      <img src="/images/last.png" alt="Last page" title="Last page" />
    </a>
  </div>
<?php endif; ?>
 
<div class="pagination_desc">
  <strong><?php echo $pager->getNbResults() ?></strong> trabajos en esta categoria
 
  <?php if ($pager->haveToPaginate()): ?>
    - page <strong><?php echo $pager->getPage() ?>/<?php echo $pager->getLastPage() ?></strong>
  <?php endif; ?>
</div>