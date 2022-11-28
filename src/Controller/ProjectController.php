<?php

namespace Formation\MonApp\Controller;

use Formation\MonApp\Core\Security;
use Formation\MonApp\Core\Views;
use Formation\MonApp\Model\Projets;
use Formation\MonApp\Model\Taches;
use Formation\MonApp\Model\Users;

class ProjectController{

    public function __construct()
    {
        $this->CreateProject();
        // if(isset($_GET['page'])){
        //     switch($_GET['page']){
        //         case 'CreateProject':
        //             $this->CreateProject();
        //             break;
        //         default:
        //             $this->CreateProject();
        //             break;
        //     }
        // }
    }
    
    public function CreateProject(){
        $view = new Views('CreateProject', 'Créer un projet');
        if (Security::isConnected()) {
            $view->setVar('connected', true);
        } else {
            header('location: index.php');
        }
        if (isset($_POST['submitPro'])){
            unset($_POST['submitPro']);
            if (Projets::affect()) {
                $view->setVar('message',"Le projet a bien été créé");
            } else {
                $view->setVar('message', "Une erreur est survenue");
            }
        }
        $view->render();
    }
}