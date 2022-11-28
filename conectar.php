<?php
 $database = "webgenerator";
 $password = 'webgenerator2020';
 $username = "adm_webgenerator";
 $server = "localhost";

try {
  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
  return $conn;
} catch (PDOException $e) {
  die('Connection Failed: ' . $e->getMessage());
}
?>