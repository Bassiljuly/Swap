<?php


// Creation de la fonction qui indique si l'utilisateur est connecte

function user_is_connected() {
    if(empty($_SESSION['membre'])) {
        return false;
    } else {
        return true;
    }
}



// Verifier si l'utilisateur est admin


function user_is_admin() {
    if(user_is_connected() && $_SESSION['membre']['statut'] == 2) {
        return true;
    } else {
    return false;
    }
}