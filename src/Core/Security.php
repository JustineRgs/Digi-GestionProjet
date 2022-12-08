<?php

namespace Formation\MonApp\Core;

use Formation\MonApp\Model\Users;

class Security
{
    public static function isConnected()
    {
        if (session_status(
            ) !== 2) { // Condition -> Si le statut de session n'est pas égale à 2, alors on SESSION -> START
            session_start();
        }
        if (isset($_SESSION['connected']) && $_SESSION['connected'] === true) {
            return true;
        }

        return false;
    }

    public static function ConnectUser()
    {
        $user = $_POST['mail'];
        $pwd = $_POST['pwd'];
        $searchUser = Users::getByAttribute('mail', $user);
        if (count($searchUser) >= 1) {
            $id = Model::getId('users', 'users', 'mail', $user); // Récupération de l'ID de l'utilisateur connecté
            if ($user === $searchUser[0]->getMail() && password_verify(
                    $pwd,
                    $searchUser[0]->getPwd()
                )) { // Vérification de la ressemblance des mdp et mail
                session_start(); // Lancement de la session
                $use = Model::getSession('users', $id);  // Récupération des données de session user connecté
                $tab = $use[0]; //Récupération des valeurs de use dans tab;
                foreach ($tab as $key => $value) {  // Parcours du tableau
                    if ($key == 'prenom') {  // Récupération des valeurs de key et vérification de ressemblance
                        $_SESSION['prenom'] = $value; // Assignation de la valeur aux SESSION
                    }
                    if ($key == 'nom') {
                        $_SESSION['nom'] = $value;
                    }
                    if ($key == 'mail') {
                        $_SESSION['mail'] = $value;
                    }
                    if ($key == 'avatar') {
                        $_SESSION['avatar'] = $value;
                    }
                }
                $_SESSION['connected'] = true;
                $_SESSION['id'] = $id;
                $_SESSION['pwd'] = $pwd;
            } else {
                echo '<p class = "erreur erreur_co">Votre mot de passe est incorrect</p>';
            }
        } else {
            echo '<p class = "erreur erreur_co">Votre mail ou votre mot de passe est incorrect</p>';
        }
    }
}
