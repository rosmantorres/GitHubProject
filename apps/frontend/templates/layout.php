<!-- apps/frontend/templates/layout.php -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>
      <?php if (!include_slot('title')): ?>
        Proyecto JOBEET
      <?php endif; ?>
    </title>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_javascripts() ?>
    <?php include_stylesheets() ?>
  </head>
  <body>
    <div id="container">
      <div id="header">
        <div class="content">
          <h1>
            <?php echo link_to(image_tag('logo.jpg'), url_for('@homepage')) ?>
          </h1>

          <div id="sub_header">
            <div class="post">
              <h2>Pregunte a las personas</h2>
              <div>
                <?php echo link_to('Postear un trabajo',url_for('@acciones_trabajo_new')) ?>
              </div>
            </div>

            <div class="search">
              <h2>Pregunte por un trabajo</h2>
              <form action="" method="get">
                <input type="text" name="keywords" id="search_keywords" />
                <input type="submit" value="search" />
                <div class="help">
                  Enter some keywords (city, country, position, ...)
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div id="job_history">
        Trabajos vistos recientemente:
        <ul>
          <?php foreach ($sf_user->getHistorialTrabajo() as $job): ?>
            <li>
              <?php echo link_to($job->getPosicion() . ' - ' . $job->getCompania(), 'acciones_trabajo_show', $job) ?>
            </li>
          <?php endforeach ?>
        </ul>
      </div>
      
      <div id="content">
        <?php if ($sf_user->hasFlash('notice')): ?>
          <div class="flash_notice">
            <?php echo $sf_user->getFlash('notice') ?>
          </div>
        <?php endif; ?>

        <?php if ($sf_user->hasFlash('error')): ?>
          <div class="flash_error">
            <?php echo $sf_user->getFlash('error') ?>
          </div>
        <?php endif; ?>

        <div class="content">
          <?php echo $sf_content ?>
        </div>
      </div>

      <div id="footer">
        <div class="content">
          <span class="symfony">
            <?php echo image_tag('jobeet-mini.png') ?>
            powered by 
            <?php echo link_to(image_tag('symfony.gif'),  url_for('@homepage')) ?>
          </span>
          <ul>
            <li><a href="">Acerca de Jobeet</a></li>
            <li class="feed"><a href="">Full feed</a></li>
            <li><a href="">Jobeet API</a></li>
            <li class="last"><a href="">Affiliates</a></li>
          </ul>
        </div>
      </div>
    </div>
  </body>
</html>