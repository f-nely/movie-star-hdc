<?php

$host = 'mysql';
$dbname = 'movie_star';
$user = 'root';
$pass = 'root';

try {
  $conn = new PDO("mysql:host=$host; dbname=$dbname", $user, $pass);

  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch(PDOException $e) {
  echo $e->getCode() . '<br>';
  echo $e->getMessage();
}