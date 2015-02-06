<?php
include_once MODULESROOT . DS . 'core' . DS . 'includes' . DS . 'classes' . DS . 'DBObject.class.php';

/**
 * DB fields
 * - id
 * - search_title
 * - title
 * - year
 * - rated
 * - released
 * - runtime
 * - genre
 * - director
 * - writer
 * - actors
 * - plot
 * - language
 * - country
 * - awards
 * - poster
 * - metascore
 * - imdbrating
 * - imdbvotes
 * - imdbid
 * - type
 * - created_at
 * - updated_at
 */
class Movie extends DBObject {
  /**
   * Implement parent abstract functions
   */
  protected function setPrimaryKeyName() {
    $this->primary_key = array(
      'id'
    );
  }
  protected function setPrimaryKeyAutoIncreased() {
    $this->pk_auto_increased = TRUE;
  }
  protected function setTableName() {
    $this->table_name = 'movie';
  }
  
  /**
   * Setters and getters
   */
  public function setId($id) {
    $this->setDbFieldId($id);
  }
  public function getId() {
    return $this->getDbFieldId();
  }
  public function setSearchTitle($t) {
    $this->setDbFieldSearch_title($t);
  }
  public function getSearchTitle() {
    return $this->getDbFieldSearch_title();
  }
  public function setTitle($t) {
    $this->setDbFieldTitle($t);
  }
  public function getTitle() {
    return $this->getDbFieldTitle();
  }
  public function setYear($y) {
    $this->setDbFieldYear($y);
  }
  public function getYear() {
    return $this->getDbFieldYear();
  }
  public function setRated($r) {
    $this->setDbFieldRated($r);
  }
  public function getRated() {
    return $this->getDbFieldRated();
  }
  public function setReleased($r) {
    $this->setDbFieldReleased($r);
  }
  public function getReleased($format = false) {
    if ($format) {
      return date($format, $this->getDbFieldReleased());
    }
    
    return $this->getDbFieldReleased();
  }
  public function setRuntime($r) {
    $this->setDbFieldRuntime($r);
  }
  public function getRuntime() {
    return $this->getDbFieldRuntime();
  }
  public function setGenre($g) {
    $this->setDbFieldGenre($g);
  }
  public function getGenre() {
    return $this->getDbFieldGenre();
  }
  public function setDirector($d) {
    $this->setDbFieldDirector($d);
  }
  public function getDirector() {
    return $this->getDbFieldDirector();
  }
  public function setWriter($w) {
    $this->setDbFieldWriter($w);
  }
  public function getWriter() {
    return $this->getDbFieldWriter();
  }
  public function setActors($a) {
    $this->setDbFieldActors($a);
  }
  public function getActors() {
    return $this->getDbFieldActors();
  }
  public function setPlot($p) {
    $this->setDbFieldPlot($p);
  }
  public function getPlot() {
    return $this->getDbFieldPlot();
  }
  public function setLanguage($l) {
    $this->setDbFieldLanguage($l);
  }
  public function getLanguage() {
    return $this->getDbFieldLanguage();
  }
  public function setCountry($c) {
    $this->setDbFieldCountry($c);
  }
  public function getCountry() {
    return $this->getDbFieldCountry();
  }
  public function setAwards($a) {
    $this->setDbFieldAwards($a);
  }
  public function getAwards() {
    return $this->getDbFieldAwards();
  }
  public function setPoster($p) {
    $this->setDbFieldPoster($p);
  }
  public function getPoster() {
    return $this->getDbFieldPoster();
  }
  public function setMetascore($m) {
    $this->setDbFieldMetascore($m);
  }
  public function getMetascore() {
    return $this->getDbFieldMetascore();
  }
  public function setIMDBRating($r) {
    $this->setDbFieldImdbrating($r);
  }
  public function getIMDBRating() {
    return $this->getDbFieldImdbrating();
  }
  public function setIMDBVotes($i) {
    $this->setDbFieldImdbvotes($i);
  }
  public function getIMDBVotes() {
    return $this->getDbFieldImdbvotes();
  }
  public function setIMDBId($id) {
    $this->setDbFieldImdbid($id);
  }
  public function getIMDBId() {
    return $this->getDbFieldImdbid();
  }
  public function setType($t) {
    $this->setDbFieldType($t);
  }
  public function getType() {
    return $this->getDbFieldType();
  }
  public function setCreatedAt($c) {
    $this->setDbFieldCreated_at($c);
  }
  public function getCreatedAt() {
    return $this->getDbFieldCreated_at();
  }
  public function setUpdatedAt($t) {
    $this->setDbFieldUpdated_at($t);
  }
  public function getUpdatedAt($format = null) {
    if ($format) {
      return date($format, $this->getDbFieldUpdated_at());
    }
    return $this->getDbFieldUpdated_at();
  }
  
  
  /**
   * self functions
   */
  static function dropTable() {
    return parent::dropTableByName('movie');
  }
  
  static function tableExist() {
    return parent::tableExistByName('movie');
  }
  
  static function createTableIfNotExist() {
    global $mysqli;

    if (!self::tableExist()) {
      return $mysqli->query('
CREATE TABLE IF NOT EXISTS `movie` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `search_title` VARCHAR(255) NOT NULL ,
  `title` VARCHAR(255) NOT NULL ,
  `year` VARCHAR(4) ,
  `rated` VARCHAR(4) ,
  `released` INT ,
  `runtime` VARCHAR(32) ,
  `genre` VARCHAR(128) ,
  `director` VARCHAR(128) ,
  `writer` VARCHAR(256) ,
  `actors` VARCHAR(1280) ,
  `plot` TEXT ,
  `language` VARCHAR(20) ,
  `country` VARCHAR(15) ,
  `awards` VARCHAR(512) ,
  `poster` VARCHAR(256) ,
  `metascore` TINYINT ,
  `imdbrating` VARCHAR(4) ,
  `imdbvotes` VARCHAR(10) ,
  `imdbid` VARCHAR(10) ,
  `type` VARCHAR(10) ,
  `created_at` INT ,
  `updated_at` INT ,
  PRIMARY KEY (`id`) ,
  INDEX `search_title` (`search_title` ASC) ,
  INDEX `imdbid` (`imdbid` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;
      ');
    }
    
    return true;
  }
  
  static function findById($id, $instance = 'Movie') {
    global $mysqli;
    $query = 'SELECT * FROM movie WHERE id=' . $id;
    $result = $mysqli->query($query);
    if ($result && $b = $result->fetch_object()) {
      $movie = new $instance();
      DBObject::importQueryResultToDbObject($b, $movie);
      return $movie;
    }
    return null;
  }
  
  static function findBySearchTitle($t, $instance = 'Movie') {
    global $mysqli;
    $query = 'SELECT * FROM movie WHERE search_title=' . DBObject::prepare_val_for_sql($t);
    $result = $mysqli->query($query);
    if ($result && $b = $result->fetch_object()) {
      $movie = new $instance();
      DBObject::importQueryResultToDbObject($b, $movie);
      return $movie;
    }
    return null;
  }
  
  static function findAll() {
    global $mysqli;
    $query = "SELECT * FROM movie";
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $movie = new Movie();
      DBObject::importQueryResultToDbObject($b, $movie);
      $rtn[] = $movie;
    }
    
    return $rtn;
  }
  
  static function findAllWithPage($page, $entries_per_page, $order_by = 'updated_at', $order = 'DESC') {
    global $mysqli;
    $query = "SELECT * FROM movie ORDER BY $order_by $order LIMIT " . ($page - 1) * $entries_per_page . ", " . $entries_per_page;
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $movie = new Movie();
      DBObject::importQueryResultToDbObject($b, $movie);
      $rtn[] = $movie;
    }
    
    return $rtn;
  }
  
  static function countAll() {
    global $mysqli;
    $query = "SELECT COUNT(*) as 'count' FROM movie";
    if ($result = $mysqli->query($query)) {
      return $result->fetch_object()->count;
    }
  }
  
  static function logAMovieForLaterAPICrawl($search_title) {
    if (Movie::findBySearchTitle($search_title) == null) {
      $movie = new Movie();
      $movie->setSearchTitle($search_title);
      $movie->setCreatedAt(time());
      $movie->save();
    }
  }
  
  static function findAllToPopulate() {
    global $mysqli;
    $query = "SELECT * FROM movie WHERE updated_at IS NULL";
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $movie = new Movie();
      DBObject::importQueryResultToDbObject($b, $movie);
      $rtn[] = $movie;
    }
    
    return $rtn;
  }
  
  static function findAllValid($how_long_ago = null) {
    global $mysqli;
    $query = "SELECT * FROM movie WHERE title != '' AND title IS NOT NULL AND poster IS NOT NULL " . ($how_long_ago ? "AND released > " . $how_long_ago : "") . " ORDER BY released DESC";
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $movie = new Movie();
      DBObject::importQueryResultToDbObject($b, $movie);
      $rtn[] = $movie;
    }
    
    return $rtn;
  }
  
  static function findAllIMDBId($id) {
    global $mysqli;
    $query = "SELECT * FROM movie WHERE imdbid = " . $id;
    $result = $mysqli->query($query);
    
    if ($result && $b = $result->fetch_object()) {
      $movie = new Movie();
      DBObject::importQueryResultToDbObject($b, $movie);
      return $movie;
    }
    return null;
  }
  
  static function findByIMDBId($id) {
    global $mysqli;
    $query = 'SELECT * FROM movie WHERE imdbid=' . DBObject::prepare_val_for_sql($id);
    $result = $mysqli->query($query);
    if ($result && $b = $result->fetch_object()) {
      $movie = new Movie();
      DBObject::importQueryResultToDbObject($b, $movie);
      return $movie;
    }
    return null;
  }
  
  public function isPopulated() {
    $title = $this->getDbFieldTitle();
    return !empty($title);
  }
  
  public function delete() {
    // we delete the poster file first
    $local_poster_path = MOVIE_POST_PATH . DS . $this->getPoster();
    if (is_file($local_poster_path)) {
      unlink($local_poster_path);
    }
    
    return parent::delete();
  }
  
  public function getPosterUri() {
    return "/modules/movie/posters/" . ($this->getPoster() ? $this->getPoster() : 'default.jpg');
  }
}