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
        } else if (isset($_GET['modif'])) {
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

    public function AfficheUsers()
    {
        $view = new Views('Profile', 'Bienvenue sur ton profil');
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

        // Upload de l'avatar
        
        if (isset($_POST['avatar'])) {

            // Vérification de l'existance d'un dossier upload et id_users
            $dossier = "upload/" . $_SESSION['id'] . "/";
            if (!is_dir($dossier)) {
                mkdir($dossier);
            }

            $dossier .= "album/";
            if (!is_dir($dossier)) {
                mkdir($dossier);
            }

            // Vérification de l'extension de l'image
            $ext = ['.jpg', '.jpeg', '.png'];
            $fichier = basename($_FILES['file']['name']);
            // On coupe le mot le met en minuscule et on recup la fin apres le point
            $fichier_extension = strtolower(substr(strrchr($fichier, '.'), 1));

            // Vérification de la taille de l'image
            $poidsMax = 524288000;
            if ($poidsMax <= $_FILES['file']['size']) {
                $view->setVar('message', 'Cette image est trop grosse');
                die;
            }

            // On vérifie si l'extension de notre fichier
            // correspond au tableau d'extension autorisé
            foreach($ext as $value){
                if(!$value = $fichier_extension){
                    $view->setVar('message', 'L\'extesion n\'est pas valide');
                    die;
                }
            }

            $fichier = md5(uniqid(rand(), true));
            $fichier .= '.'.$fichier_extension;
            $resultat = move_uploaded_file($_FILES['file']['tmp_name'], $dossier.$fichier);
            // var_dump($_FILES['file']['tmp_name'], $dossier.$fichier);
            Users::ChangeAvatar($fichier);

            if(!$resultat){
               $view->setVar('message', 'L\'image ne s\'est pas enregistrer');
            }else{
                $view->setVar('message', 'Votre image est bien upload et enregistrer en tant que photo de profil');
            }
            // Création de la colone avatar dans user et creation du SESSION Avatar dans connect_user et ici aussi    
        }
        // Création si pas d'existance du dossier
        // Upload de l'image dans le dossier
        // Création en base de données de la colonne avatar dans users avec nom de l'image
        $view->setVar('users', Users::getAll());
        $view->render();
    }

    // Photo de profil, creation d'un dossier, verif de lextension et update de avatar users

    public function createUser()
    {
        $view = new Views('CreateUser', 'Création d\'un utilisateur');
        if (isset($_POST['create'])) {
            if (($message = $this->isValid()) === '') {
                unset($_POST['create']);
                unset($_POST['confirmpwd']);
                $_POST['pwd'] = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
                if (Users::create()) {
                    echo 'L\'utilisateur a bien été créé';
                } else {
                    echo "Une erreur est survenue";
                }
            } else {
                $view->setVar('message', $message);
            }
        }
        $view->render();
    }

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
}
