<?php

class Database
{
  private $host = DB_HOST;
  private $user = DB_USER;
  private $pass = DB_PASS;
  private $dbname = DB_NAME;

  private $dbh;
  private $stmt;
  private $error;

  public function __construct()
  {
    // Veritabanı bağlantı DSN'si
    $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
    $options = [
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    // PDO örneği oluşturma
    try {
      $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
      $this->dbh->exec('set names utf8');
    } catch (PDOException $e) {
      $this->error = $e->getMessage();
      echo $this->error;
    }
  }

  // Sorgu hazırlama
  public function query($sql)
  {
    $this->stmt = $this->dbh->prepare($sql);
  }

  // Değerleri bağlama
  public function bind($param, $value, $type = null)
  {
    if (is_null($type)) {
      switch (true) {
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
      }
    }
    $this->stmt->bindValue($param, $value, $type);
  }

  // Deyimi yürütme
  public function execute()
  {
    return $this->stmt->execute();
  }

  // Çoklu kayıt kümesi döndürme
  public function resultSet()
  {
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Tek kayıt döndürme
  public function single()
  {
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Satır sayısını döndürme
  public function rowCount()
  {
    return $this->stmt->rowCount();
  }

  // Belirli bir tablo ve kimliğe göre veri çekme
  public function getById($table, $id)
  {
    $this->query("SELECT * FROM $table WHERE id = :id");
    $this->bind(':id', $id);
    return $this->single();
  }

  // Tüm verileri seçme
  public function select($table)
  {
    $this->query("SELECT * FROM $table");
    return $this->resultSet();
  }

  // Veri ekleme
  public function insert($table, $data)
  {
    $fields = implode(', ', array_keys($data));
    $placeholders = ':' . implode(', :', array_keys($data));
    $this->query("INSERT INTO $table ($fields) VALUES ($placeholders)");
    foreach ($data as $key => $value) {
      $this->bind(':' . $key, $value);
    }
    return $this->execute();
  }

  // Veri güncelleme
  public function update($table, $id, $data)
  {
    $set = '';
    foreach ($data as $key => $value) {
      $set .= "$key = :$key, ";
    }
    $set = rtrim($set, ', ');
    $this->query("UPDATE $table SET $set WHERE id = :id");
    $this->bind(':id', $id);
    foreach ($data as $key => $value) {
      $this->bind(':' . $key, $value);
    }
    return $this->execute();
  }

  // Veri silme
  public function delete($table, $id)
  {
    $this->query("DELETE FROM $table WHERE id = :id");
    $this->bind(':id', $id);
    return $this->execute();
  }

  // Özel sorgu yürütme
  public function executeQuery($sql, $params = [])
  {
    $this->query($sql);
    foreach ($params as $param => $value) {
      $this->bind($param, $value);
    }
    $this->execute();
    return $this->stmt;
  }
} 