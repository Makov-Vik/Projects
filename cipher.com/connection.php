<?php
  $serverMySQL="cipher.com"; # имя сервера
  $db="cipher_db"; # база данных
  $dblog="mysql"; # логин
  $dbpass=""; # пароль
  $table="history"; # таблица
  
  $connection = mysqli_connect($serverMySQL, $dblog, $dbpass, $db);
?>