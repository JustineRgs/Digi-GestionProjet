<?php

namespace Formation\MonApp\Controller;

use Formation\MonApp\Core\Model;
use Formation\MonApp\Core\Views;
use Formation\MonApp\Core\Security;
use Formation\MonApp\Model\Projets;
use Formation\MonApp\Controller\UserController;
use Formation\MonApp\Model\Users;
use Formation\MonApp\Model\Taches;

class DefaultPage extends Model{

    public function __construct(){
        $view = new Views('DefaultPage', '');
        if (isset($_POST['connect'])) {
            Security::ConnectUser();
        }
        if (Security::isConnected()) {
            $view->setVar('connected', true);
            $view->setVar('message','Vos réalisations en cours');
        } else {
            $view->setVar('connected', false);
            $view->setVar('message','Bienvenue sur MyProject');
        }
        $pro = Projets::GetProject();
        $affec = Projets::GetAffectation();
        $view->setVar('pro', $pro);
        $view->setVar('affec', $affec);

        // Afficher taches
        $tasks = Projets::GetTaches();
        $view -> setVar('tasks', $tasks);
        // Fin taches

        if(Security::isConnected()){
            $id_user = $_SESSION['id'];
            if(isset($_GET['delete'])){
                Model::DelUser($id_user);
                session_destroy();
                header('location: index.php');
            }
            if(isset($_GET['deleteU'])){ // recup de la $_GET deteleU
                Projets::DelUserProject(); // fonction creer dans Model
                $modifp = $_GET['pagemodif'];
                header("location: index.php?page=project&update=$modifp");
            }
        }
        

        $view->render();
    }

    

}