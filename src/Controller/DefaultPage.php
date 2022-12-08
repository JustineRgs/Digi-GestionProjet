<?php

namespace Formation\MonApp\Controller;

use Formation\MonApp\Core\Model;
use Formation\MonApp\Core\Security;
use Formation\MonApp\Core\Views;
use Formation\MonApp\Model\Projets;


class DefaultPage extends Model
{

    public function __construct()
    {
        $view = new Views('DefaultPage', '');
        if (isset($_POST['connect'])) {
            Security::ConnectUser();
        }
        if (Security::isConnected()) {
            // Si User est connecté : page d'acceuil projets/taches
            $view->setVar('connected', true);
            $view->setVar('message', 'Vos réalisations en cours');
        } else {
            // Si User n'est pas connecté : page de connexion
            $view->setVar('connected', false);
            $view->setVar('message', 'Bienvenue sur MyProject');
        }

        $pro = Projets::GetProject();
        $affec = Projets::GetAffectation();
        $view->setVar('pro', $pro);
        $view->setVar('affec', $affec);

        // Affichage des tâches
        $tasks = Projets::GetTaches();
        $view->setVar('tasks', $tasks);

        if (Security::isConnected()) {
            $id_user = $_SESSION['id'];
            if (isset($_GET['delete'])) { //Si $_GET contient 'delete'
                Model::DelUser($id_user); //Classe 'Model' appel sa fonction Delete via l'ID user
                session_destroy(); //La session se ferme
                header('location: index.php'); //Retour à l'acceuil
            }
            if (isset($_GET['deleteU'])) { //Si $_GET contient 'delete'
                Projets::DelUserProject(); //Classe 'Projet' appel sa fonction Delete 
                $modifp = $_GET['pagemodif']; //$modifp : index.php modifier sans le projet
                header("location: index.php?page=project&update=$modifp");
            }
        }
        $view->render();
    }
}