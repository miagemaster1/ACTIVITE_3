<?php
// ** configuration de MySQL  ** //
define('DB_NAME', 'gestion_cinema');    // ne nom de la base de données
define('DB_HOST', 'localhost');    // serveur mysql
define('DB_DSN','mysql:host='.DB_HOST.';dbname='.DB_NAME);
define('DB_USER', 'root');     // utilisateur MySQL 
define('DB_PASSWORD', ''); // password MySQL

// definir le separateur generique des chemins sur l'application
define('ABSPATH', dirname(__FILE__).'/'); 
//require_once(ABSPATH.'tabs.php');
$conn = new PDO(DB_DSN, DB_USER, DB_PASSWORD);	
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>