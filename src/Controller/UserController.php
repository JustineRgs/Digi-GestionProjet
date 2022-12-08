<?php

namespace Formation\MonApp\Controller;

use Formation\MonApp\Core\Security;
use Formation\MonApp\Core\Validate;
use Formation\MonApp\Core\Views;
use Formation\MonApp\Model\Users;

class UserController
{
    public function __construct()
    {
        if (isset($_GET['user'])) {
            switch ($_GET['user']) {
                case 'register':
                    $this->createUser();
                    break;
                case 'profile':
                    $this->AfficheUsers();
                    break;
                default:
                    $this->AfficheUsers();
                    break;
            }
        } else {
            if (isset($_GET['modif'])) {
                switch ($_GET['modif']) {
                    case 'mod':
                        $this->AfficheUsers();
                        break;
                    default:
                        $this->AfficheUsers();
                        break;
                }
            } else {
                $this->AfficheUsers();
            }
        }
    }

    //READ

    public function createUser()
    {
        $view = new Views('CreateUser', 'Création d\'un utilisateur');
        if (isset($_POST['create'])) {
            if ($_POST['pwd'] === $_POST['confirmpwd']) {
                if (($message = $this->isValid()) === '') {
                    unset($_POST['create']);
                    unset($_POST['confirmpwd']);
                    $_POST['pwd'] = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
                    if (Users::create()) {
                        if (isset($_GET['project'])) {
                            Users::AddUserToProject();
                        }
                        header('Location: index.php');
                        echo 'L\'utilisateur a bien été créé';
                    } else {
                        $view->setVar('message', 'Echec de la création de l\'utilisateur');
                    }
                } else {
                    $view->setVar('message', $message);
                }
            } else {
                $view->setVar('message', 'Les mots de passe ne sont pas identique');
            }
        }
        $view->render();
    }


    // CREATE : USER

    private function isValid()
    {
        $return = '';
        $return .= Validate::ValidateEmail($_POST['mail']);
        $return .= Validate::verifyConfirmPassword($_POST['pwd'], $_POST['confirmpwd']);
        $user = Users::getByAttribute('mail', $_POST['mail']);
        if (count($user) > 0) {
            $return .= "L'utilisateur existe déjà";
        }

        return $return;
    }

    //Validation de formulaire

    public function AfficheUsers()
    {
        $view = new Views('Profile', 'Votre profil');
        if (Security::isConnected()) {
            $view->setVar('connected', true);
        } else {
            header('location: index.php');
        }
        if (isset($_POST['submit'])) {
            unset($_POST['submit']);
            if (isset($_POST['nom'])) {
                $_SESSION['nom'] = $_POST['nom'];
            }
            if (isset($_POST['prenom'])) {
                $_SESSION['prenom'] = $_POST['prenom'];
            }
            if (isset($_POST['mail'])) {
                $_SESSION['mail'] = $_POST['mail'];
            }

            Users::ChangeProfil();
        }

        // Si le formulaire de changement de mot de passe est détecté
        if (isset($_POST['submitPwd'])) {
            unset($_POST['submitPwd']);
            if (isset($_POST['password']) && isset($_POST['newpassword']) && isset($_POST['newvrfpassword'])) {
                // Verif du password actuel
                $user_id = $_SESSION['id'];
                $user = Users::getByAttribute('id_users', $user_id); // Recuperation De l'utilisateur
                foreach ($user as $users => $value) { // parcours du tableau user
                    foreach ($value as $val => $key) {
                        if ($val === 'pwd') { // Vérification de lexstance de pwd
                            $mdpBdd = $key; // Attribution de la valeur de pwd a mdpBdd
                        }
                    }
                }
                if (!password_verify(
                    $_POST['password'],
                    $mdpBdd
                )) { // Fonction permettant de vérifier le nouveau mot de passe a l'actuel
                    $view->setVar('messagepwd', 'Votre mot de passe n\'est pas le même que l\'actuel');
                    $view->render();
                    die;
                }
                if ($_POST['newpassword'] === $_POST['newvrfpassword']) {
                    $newpassword_hash = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
                    if (Users::ChangePwd($newpassword_hash)) {
                        header('location: index.php?page=profile');
                    } else {
                        $view->setVar('messagepwd', 'Erreur dans le changement de mot de passe');
                    }
                }
            }
        }
        // UPLOAD : AVATAR Photo de profil, creation d'un dossier, verif de lextension et update de avatar users
        if (isset($_POST['avatar'])) {

            // Vérification de l'existance d'un dossier upload et id_users
            $dossier = "upload/".$_SESSION['id']."/";
            if (!is_dir($dossier)) {
                mkdir($dossier);
            }

            $dossier .= "album/";
            if (!is_dir($dossier)) {
                mkdir($dossier);
            }

            //Vérification de l'extension de l'image
            $ext = ['.jpg', '.jpeg', '.png'];
            $fichier = basename($_FILES['file']['name']);
            //On coupe le mot - On le met en minuscule - On recup la fin apres le point
            $fichier_extension = strtolower(substr(strrchr($fichier, '.'), 1));

            // Vérification de la taille de l'image
            $poidsMax = 524288000;
            if ($poidsMax <= $_FILES['file']['size']) {
                $view->setVar('message', 'Cette image est trop grosse');
                $view->setVar('users', Users::getAll());
                $view->render();
                die;
            }

            // On vérifie si extension fichier = extension autorisé
            foreach ($ext as $value) {
                if (!$value = $fichier_extension) {
                    $view->setVar('message', 'L\'extension n\'est pas valide');
                    $view->setVar('users', Users::getAll());
                    $view->render();
                    die;
                }
            }

            $fichier = 'avatar_'.$_SESSION['id'];
            $fichierext = $fichier.'.'.$fichier_extension;
            $resultat = move_uploaded_file($_FILES['file']['tmp_name'], $dossier.$fichierext);

            Users::ChangeAvatar($fichierext);

            if (!$resultat) {
                $view->setVar('message', 'L\'image ne s\'est pas enregistrer');
            } else {
                $view->setVar('message', 'Votre avatar est maintenant à jour!');
            }
            // Création de la colone avatar dans user et creation du SESSION Avatar dans connect_user et ici aussi
        }
        $view->setVar('users', Users::getAll());
        $view->render();
    }
}
