<?php
include_once MODULESROOT . DS . 'core' . DS . 'includes' . DS . 'classes' . DS . 'DBObject.class.php';

/**
 * DB fields
 * - token
 * - state
 * - cinema
 * - movie
 * - session
 * - num_ticket
 * - prices
 * - our_price
 * - total
 * - email
 * - processed
 * - ip
 * - language
 * - created_at
 */
class TicketOrder extends DBObject {
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
    $this->table_name = 'ticket_order';
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
  public function setToken($t) {
    $this->setDbFieldToken($t);
  }
  public function getToken() {
    return $this->getDbFieldToken();
  }
  public function setState($s) {
    $this->setDbFieldState($s);
  }
  public function getState() {
    return $this->getDbFieldState();
  }
  public function setCinema($c) {
    $this->setDbFieldCinema($c);
  }
  public function getCinema() {
    return $this->getDbFieldCinema();
  }
  public function setMovie($m) {
    $this->setDbFieldMovie($m);
  }
  public function getMovie() {
    return $this->getDbFieldMovie();
  }
  public function setSession($s) {
    $this->setDbFieldSession($s);
  }
  public function getSession() {
    return $this->getDbFieldSession();
  }
  public function setNumTicket($n) {
    $this->setDbFieldNum_ticket($n);
  }
  public function getNumTicket() {
    return $this->getDbFieldNum_ticket();
  }
  public function setPrices($p) {
    $this->setDbFieldPrices($p);
  }
  public function getPrices() {
    return $this->getDbFieldPrices();
  }
  public function setOurPrice($o) {
    $this->setDbFieldOur_price($o);
  }
  public function getOurPrice() {
    return $this->getDbFieldOur_price();
  }
  public function setTotal($t) {
    $this->setDbFieldTotal($t);
  }
  public function getTotal() {
    return $this->getDbFieldTotal();
  }
  public function setProcessed($p) {
    $this->setDbFieldProcessed($p);
  }
  public function getProcessed () {
    return $this->getDbFieldProcessed();
  }
  public function setIp($i) {
    $this->setDbFieldIp($i);
  }
  public function getIp() {
    return $this->getDbFieldIp();
  }
  public function setEmail($e) {
    $this->setDbFieldEmail($e);
  }
  public function getEmail() {
    return $this->getDbFieldEmail();
  }
  public function setLanguage($l) {
    $this->setDbFieldLanguage($l);
  }
  public function getLanguage() {
    return $this->getDbFieldLanguage();
  }
  public function setCreatedAt($c) {
    $this->setDbFieldCreated_at($c);
  }
  public function getCreatedAt($verbal = false, $format = 'Y-m-d H:i:s') {
    if ($verbal) {
      return date($format, $this->getDbFieldCreated_at());
    }
    return $this->getDbFieldCreated_at();
  }
  
  /**
   * self functions
   */
  static function dropTable() {
    return parent::dropTableByName('ticket_order');
  }
  
  static function tableExist() {
    return parent::tableExistByName('ticket_order');
  }
  
  static function createTableIfNotExist() {
    global $mysqli;

    if (!self::tableExist()) {
      return $mysqli->query('
CREATE  TABLE `ticket_order` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `token` VARCHAR(60) ,
  `state` VARCHAR(10) ,
  `cinema` VARCHAR (60) ,
  `movie` VARCHAR (128) ,
  `session` VARCHAR (32) ,
  `num_ticket` TINYINT (2) ,
  `prices` TEXT ,
  `our_price` VARCHAR (5) ,
  `total` VARCHAR (10) ,
  `email` VARCHAR (255) ,
  `language` VARCHAR (2) ,
  `processed` TINYINT DEFAULT 0 ,
  `ip` VARCHAR (15) ,
  `created_at` INT ,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;
      ');
    }
    
    return true;
  }
  
  static function findById($id) {
    global $mysqli;
    $query = 'SELECT * FROM ticket_order WHERE id=' . $id;
    $result = $mysqli->query($query);
    if ($result && $c = $result->fetch_object()) {
      $order = new self();
      DBObject::importQueryResultToDbObject($c, $order);
      return $order;
    }
    return null;
  }
  
  static function findAll() {
    global $mysqli;
    $query = "SELECT * FROM ticket_order";
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $order = new TicketOrder();
      DBObject::importQueryResultToDbObject($b, $order);
      $rtn[] = $order;
    }
    
    return $rtn;
  }
  
  static function findAllWithPage($page, $entries_per_page) {
    global $mysqli;
    $query = "SELECT * FROM ticket_order LIMIT " . ($page - 1) * $entries_per_page . ", " . $entries_per_page;
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $order = new TicketOrder();
      DBObject::importQueryResultToDbObject($b, $order);
      $rtn[] = $order;
    }
    
    return $rtn;
  }
  
  static function countAll() {
    global $mysqli;
    $query = "SELECT COUNT(*) as 'count' FROM ticket_order";
    if ($result = $mysqli->query($query)) {
      return $result->fetch_object()->count;
    }
  }
  
  static function findAllProcessed() {
    global $mysqli;
    $query = "SELECT * FROM ticket_order WHERE processed=1";
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $order = new TicketOrder();
      DBObject::importQueryResultToDbObject($b, $order);
      $rtn[] = $order;
    }
    
    return $rtn;
  }
  
  static function findAllProcessedWithPage($page, $entries_per_page) {
    global $mysqli;
    $query = "SELECT * FROM ticket_order WHERE processed=1 LIMIT " . ($page - 1) * $entries_per_page . ", " . $entries_per_page;
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $order = new TicketOrder();
      DBObject::importQueryResultToDbObject($b, $order);
      $rtn[] = $order;
    }
    
    return $rtn;
  }
  
  static function countAllProcessed() {
    global $mysqli;
    $query = "SELECT COUNT(*) as 'count' FROM ticket_order WHERE processed=1";
    $result = $mysqli->query($query)->fetch_object();
    return $result->count;
  }
}