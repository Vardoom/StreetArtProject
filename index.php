<?php

session_name("SessionTest");
// ne pas mettre d'espace dans le nom de session !
session_start();
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id();
    $_SESSION['initiated'] = true;
    $_SESSION['login'] = null;
    $_SESSION['admin'] = false;
}

require('utilities/phpsqlajax_dbinfo.php');
require('utilities/printForms.php');
require('utilities/logInOut.php');
require('database/database.php');
require('utilities/utilisateur.php');
require('utilities/image.php');
require('utilities/utils.php');

$dbh = Database::connect();

//traitement des contenus de formulaires
if (isset($_GET["todo"])) {
    if ($_GET["todo"] == "login") {
        logIn($dbh);
    }
}
if (isset($_GET["todo"])) {
    if ($_GET["todo"] == "logout") {
        logOut($dbh);
    }
}

//Verification de la nécessité d'afficher la page de préaccueil
$prewlcm = TRUE;
if (!isset($_GET['page'])) {
    require('content/content_prewelcome.php');
    $prewlcm = FALSE; // Mettre cette variable à True pour travailler sans la page de pré-accueil
    $_GET['page'] = htmlspecialchars('welcome');
}

//Verification que la page est bien autorisée: utilities/utils.php/checkPage
$askedPage = htmlspecialchars($_GET['page']);
//var_dump($askedPage);
$authorized = htmlspecialchars(checkPage($askedPage));
//var_dump($authorized);
if ($authorized) {
    $pageTitle = htmlspecialchars(getPageTitle($askedPage));
} else {
    $askedPage = 'erreur';
    $pageTitle = "erreur";
}

//Génération du Header de la page
generateHTMLHeader($pageTitle, $askedPage);

//Affichage du contenu de la page
if ($prewlcm) {
    $adm = false;
    if (isset($_SESSION['admin']) and $_SESSION['admin'] == true) {
        $adm = true;
    }

    //Génération des menus
    generateMenuConnexion($askedPage);
    generateMenuGeneral($adm);

    echo<<<CHAINE_DE_FIN
            <div id="content">
CHAINE_DE_FIN;

    if ($askedPage == 'changePassword') {
        require("formulaire/changePassword.php");
    } else {
        if ($askedPage == 'deleteUser') {
            require("formulaire/deleteUser.php");
        } else {
            if ($askedPage == 'register') {
                require("formulaire/register.php");
            } else {
                if ($askedPage == 'signin') {
                    require("formulaire/signin.php");
                } else {
                    require("content/content_".htmlspecialchars($askedPage).".php");
                }
            }
        }
    }

    //generateMenuFooter();

    echo "</div>";
}
$dbh = null;

//Génération de la fin de page
generateHTMLFooter();
