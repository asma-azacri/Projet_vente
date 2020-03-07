<?php
define('SQLServer', 'localhost');
define('SQLLogin', 'u21714898');
define('SQLPwd', 'pP6Pu7IZXPdN');
define('SQLDB', 'u21714898');

function dbConnect() {
  global $sqlLogin, $sqlPwd, $sqlDB;
  try {
    $db = new PDO('mysql:host='.SQLServer.';dbname='.SQLDB, SQLLogin, SQLPwd);
    return $db;
  } catch (PDOException $e) {
    die('Connexion échouée : ' . $e->getMessage());
  }
}

