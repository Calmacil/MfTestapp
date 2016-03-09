<?php
require_once __DIR__.'/vendor/autoload.php';

use \Calma\Mf\PdoProvider as DB;

$app = new \Calma\Mf\Application(__DIR__.'/', 'dev');

class TestTable extends \Calma\Mf\DataObject
{
  protected $_id;
  protected $_key;
  protected $_value;
  
  public static function selectAll()
  {
    try {
      $dbh = DB::getConnector('master', [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
      
      $stmt = $dbh->prepare('SELECT `id`, `key`, `value` FROM `test_table`');
      
      if (!$stmt) {
        echo "KO: Could not prepare statement\n";
      }
      
      $stmt->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
      
      $rs = $stmt->execute();
      if (!($rs && $stmt->rowCount())) {
        var_dump($stmt);
        var_dump($dbh);
        echo "KO: Query failed\n";
        print_r(error_get_last());
        exit;
      }
      
      return $stmt->fetchAll();
    } catch (\Exception $e) {
      var_dump($e);
    }
  }
}

$data = TestTable::selectAll();

foreach ($data as $row) {
  echo "{$row->id}: a {$row->key} is called a {$row->value} in french.\n";
}
