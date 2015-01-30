<div class="container">
  <h2><?php echo i18n(array(
      'en' => 'Latest movies in cinema',
      'zh' => '最新上映的影片'
  )) ?></h2>

  <div class="loading"><?php echo i18n(array(
      'en' => 'Loading ...',
      'zh' => '加载中 。。。'
  )) ?></div>
  
  <section id="movies"></section>
  
  <div class="sr-only">
    <ul>
      <?php foreach ($movies as $movie): ?>
      <li>
        <h3><?php echo $movie->getSearchTitle(); ?></h3>
        <p><a href="<?php echo uri('movie/' . $movie->getIMDBId()) ?>"><?php echo i18n(array(
            'en' => 'Check details',
            'zh' => '查看详情'
        )) ?></a></p>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>

<script type="text/javascript">
  var movies = <?php echo json_encode($movies); ?>;
  
  // render movies section and hide "loading" text
  populateMovieCards($("#movies"), movies);
  
  /**
   * function to create HTML markup inside of "target" element
   * 
   * @param {jquery var} target
   * @param {json class} target
   */
  function populateMovieCards(target, movies) {
    var html = "";
    var last_i;

    html += "<div class='row'>";
    for (i in movies) {
      last_i = i;
      var movie = movies[i];

      var poster = "/modules/movie/posters/" + (movie.db_field_poster ? movie.db_field_poster : 'default.jpg');

  //    if (i % 3 == 0) {
  //      html += "<div class='row'>";
  //    }
  //    console.log(movie);
  //    var col = i % 3 + 1;

      html += "<div class='col-xs-6 col-sm-4'>";
  //    html += "<p>" + movie.db_field_search_title + "</p>";
      html += "<a class='card' href='/movie/" + movie.db_field_imdbid + "'>";
      html += "<img class='img-responsive' src='" + poster + "' alt='" + movie.db_field_search_title + "'/>";
      if (movie.db_field_poster == null) {
        html += "<div class='icon'><span class='glyphicon glyphicon-film'></span></div>";
      }
      html += "<div class='overlay'>" + movie.db_field_search_title + "</div>";
      html += "</div>";
      html += "</a>";


  //    if (i % 3 == 2) {
  //      html += "</div>";
  //    }
    }
    html += "</div>";

  //  if (last_i % 3 != 2) {
  //    html += "</div>";
  //  }

    target.html(html);
    $("body.home .loading").hide();
  }
</script>