<?php

// CONNEXION BDD
$host = 'mysql:host=cl1-sql11;dbname=grs33582'; 
$login = 'grs33582'; // login
$password = 'cxLqhyNAl2yM'; // mdp
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, 
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' 
);
$pdo = new PDO($host, $login, $password, $options);



// Création d'une variable vide que l'on appelle sur toutes nos pages en dessous du titre de la page. Cette variable nous permet de mettre des messages utilisateur dedans, ils s'afficheront naturellement ensuite. 
$msg = '';

// Création/ouverture de la session
session_start();


// Déclaration de constantes
// url absolue
define('URL', 'https://swap.juliebassil.fr/');
// Chemin racine serveur pour l'enregistrement des fichiers chargés via le formulaire
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']); // Cette info est recuperee dans la superglobale $_SERVER // /Library/WebServer/Documents
// Chemin depuis le serveur vers notre site
define('PROJECT_PATH', '//'); // à modifier lors de la mise en ligne

// exemple : echo ROOT_PATH . PROJECT_PATCH;
