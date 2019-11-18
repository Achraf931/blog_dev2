<?php
$dotenv = Dotenv\Dotenv::create(dirname(dirname(__DIR__)));
$dotenv->load();
$db = getenv('DB');
$host = getenv('DB_HOST');
$username = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');
try {
    $db = new PDO('mysql:host=' . $host . ';dbname=' . $db . ';charset=utf8', $username, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $exception) {
    die('Erreur : ' . $exception->getMessage());
}

$whoops = new \Whoops\Run;
$whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();
$faker = Faker\Factory::create('fr_FR');
$Parsedown = new Parsedown();

use Carbon\Carbon;

date_default_timezone_set('Europe/Paris');
