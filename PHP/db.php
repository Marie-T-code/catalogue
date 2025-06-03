<?php
$host = 'db'; 
$dbname = 'lyon_autrement_db';
$user = 'test';
$password = 'test';

try{
    $pdo = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $user, $password);
    $pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("erreur de connexion : " . $e->getMessage());
}
?>