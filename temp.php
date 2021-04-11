<?php
#to test db connection on heroku
try{

$db = parse_url(getenv("DATABASE_URL"));

$pdo = new PDO("pgsql:" . sprintf(
    "host=%s;port=%s;user=%s;password=%s;dbname=%s",
    $db["host"],
    $db["port"],
    $db["user"],
    $db["pass"],
    ltrim($db["path"], "/")
));

echo 'success';
var_dump($pdo);

} catch (PDOException $e){
	
	      print_r($e);
	}