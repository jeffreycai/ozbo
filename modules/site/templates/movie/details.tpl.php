<div class="container">
  <div class="row">
    <div class="col-sm-6 col-xs-12 poster">
      <a href="#" class="play"><img class="img-responsive" src="<?php echo $movie->getPosterUri() ?>" alt="<?php echo i18n(array(
          'en' => 'Movie poster: ',
          'zh' => '电影海报: '
      )) . $movie->getSearchTitle(); ?>" />
      <!--<span class="glyphicon glyphicon-play"></span>-->
      </a>
    </div>
    <div class="col-sm-6 col-xs-12 details">
      <h2><?php echo i18n(array(
          'en' => 'Movie information',
          'zh' => '电影信息'
      )) ?></h2>
      <div class="loading"><?php echo i18n(array(
          'en' => 'Loading ...',
          'zh' => '加载中 。。。'
      )) ?></div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 plot">
      <h2><?php echo i18n(array(
          'en' => 'Plot',
          'zh' => '剧情简介'
      )) ?></h2>
      <div class="loading"><?php echo i18n(array(
          'en' => 'Loading ...',
          'zh' => '加载中 。。。'
      )) ?></div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-4 col-sm-offset-4">
      <a class="btn btn-lg btn-danger" href="<?php echo uri("booking") ?>"><?php echo i18n(array(
          'en' => 'Book ticket',
          'zh' => '预订电影票'
      )) ?></a>
      <br /><br />
    </div>
  </div>
</div>


<script type="text/javascript">

  /// populate movie details
  populateMovieDetails($("body.movie-details .details"));
  
  function populateMovieDetails(target) {
    var html = '<table class="table table-striped">';
    <?php if ($movie->getYear()): ?>
      html += '<tr><th width="110"><?php echo i18n(array(
          'en' => 'Year',
          'zh' => '年份'
      )) ?></th><td><?php echo str_replace("'", "\'", $movie->getYear()); ?></td></tr>';
    <?php endif; ?>
    <?php if ($movie->getRated()): ?>
      html += '<tr><th><?php echo i18n(array(
          'en' => 'Rated',
          'zh' => '等级'
      )) ?></th><td><?php echo str_replace("'", "\'", $movie->getRated()); ?></td></tr>';
    <?php endif; ?>
    <?php if ($movie->getReleased()): ?>
      html += '<tr><th><?php echo i18n(array(
          'en' => 'Release date',
          'zh' => '发布日期'
      )) ?></th><td><?php echo str_replace("'", "\'", $movie->getReleased('jS M o')) ?></td></tr>';
    <?php endif; ?>
    <?php if ($movie->getRuntime()): ?>
      html += '<tr><th><?php echo i18n(array(
          'en' => 'Runtime',
          'zh' => '影片时间'
      )) ?></th><td><?php echo str_replace("'", "\'", $movie->getRuntime()) ?></td></tr>';
    <?php endif; ?>
    <?php if ($movie->getGenre()): ?>
      html += '<tr><th><?php echo i18n(array(
          'en' => 'Genre',
          'zh' => '类型'
      )) ?></th><td><?php echo str_replace("'", "\'", $movie->getGenre()); ?></td></tr>';
    <?php endif ?>
    <?php if ($movie->getDirector()): ?>
      html += '<tr><th><?php echo i18n(array(
          'en' => 'Director',
          'zh' => '导演'
      )) ?></th><td><?php echo str_replace("'", "\'", $movie->getDirector()) ?></td></tr>';
    <?php endif; ?>
    <?php if ($movie->getWriter()): ?>
      html += '<tr><th><?php echo i18n(array(
          'en' => 'Writer',
          'zh' => '作者'
      )) ?></th><td><?php echo str_replace("'", "\'", $movie->getWriter()) ?></td></tr>';
    <?php endif; ?>
    <?php if ($movie->getActors()): ?>
      html += '<tr><th><?php echo i18n(array(
          'en' => 'Actors',
          'zh' => '演员'
      )) ?></th><td><?php echo str_replace("'", "\'", $movie->getActors()) ?></td></tr>';
    <?php endif; ?>
    <?php if ($movie->getLanguage()): ?>
      html += '<tr><th><?php echo i18n(array(
          'en' => 'Language',
          'zh' => '语言'
      )) ?></th><td><?php echo str_replace("'", "\'", $movie->getLanguage()); ?></td></tr>';
    <?php endif; ?>
    <?php if ($movie->getCountry()): ?>
      html += '<tr><th><?php echo i18n(array(
          'en' => 'Country',
          'zh' => '国家'
      )) ?></th><td><?php echo str_replace("'", "\'", $movie->getCountry()) ?></td></tr>';
    <?php endif; ?>
    <?php if ($movie->getAwards()): ?>
      html += '<tr><th><?php echo i18n(array(
          'en' => 'Awards',
          'zh' => '获奖情况'
      )) ?></th><td><?php echo str_replace("'", "\'", $movie->getAwards()); ?></td></tr>';
    <?php endif; ?>
    <?php if ($movie->getIMDBRating()): ?>
      html += '<tr><th><?php echo i18n(array(
          'en' => 'IMDB Rating',
          'zh' => 'IMDB评分'
      )) ?></th><td><?php echo str_replace("'", "\'", $movie->getIMDBRating()); ?></td></tr>';
    <?php endif; ?>
      
    html += "</table>";
    

    
    target.append(html);
    $("body.movie-details .loading").hide();
  }
  
  
  //// populate movie plot
  populateMoviePlot($("body.movie-details .plot"));
  
  function populateMoviePlot(target) {
    var html = '<blockquote><p>';
    html += '<?php echo str_replace("'", "\'", $movie->getPlot()); ?>';
    html += '</p></blockquote>';
    
    target.append(html);
    $("body.movie-details .plot .loading").hide();
  }
</script>