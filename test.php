<?php
require_once __DIR__.'/vendor/autoload.php';

use \Calma\Mf\PdoProvider as DB;

$app = new \Calma\Mf\Application(__DIR__.'/', 'dev');

class ExtTable extends \Calma\Mf\DataObject
{
  protected $_id;
  protected $_value;
  
  public static function getById($id)
  {
    echo "GETTING EXTERNAL !!!\n";
    
    try {
      $dbh = DB::getConnector('master', [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
      
      $stmt = $dbh->prepare('SELECT `id`, `value` FROM `ext_table` WHERE `id` = :id');
      if (!$stmt) {
        echo "KO: Could not prepare statement\n";
      }
      
      $stmt->bindValue(':id', $id);
      $stmt->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
      
      $rs = $stmt->execute();
      if (!($rs && $stmt->rowCount())) {
        var_dump($stmt);
        echo "KO: Query failed\n";
        print_r(error_get_last());
        exit;
      }
      
      $all = $stmt->fetchAll();
      if (count($all) == 1) return $all[0];
      return $all;
      
    } catch (PDOException $e) {
      var_dump($e);
    }
  }
}

class TestTable extends \Calma\Mf\DataObject
{
  protected $relations = [
    'Ext' => 'loadExt',
  ];
  
  protected $_id;
  protected $_key;
  protected $_value;
  
  protected $__Ext;
  
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
  
  protected function loadExt()
  {
    return ExtTable::getById($this->id);
  }
}

$data = TestTable::selectAll();

foreach ($data as $row) {
  echo "{$row->id}: a {$row->key} is called a {$row->value} in french and a {$row->Ext->value} in spanish.\n";
}
