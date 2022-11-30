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
       if (isset($_GET['create'])){
        $this->CreateProject();
       }
       if (isset($_GET['show'])){
        $this->AfficheProject();
       }
       if (isset($_GET['update'])){
        $this->ModifProject();
       }
       if (isset($_GET['create_task'])) {
        $this->CreateTask();
       }
       if(isset($_GET['delete'])){
        $this->deleteProject();
       }
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
                header('location: index.php');
            } else {
                $view->setVar('message', "Oups, ce projet existe déjà!");
            }
        }
        $view->render();
    }

    public function deleteProject(){
        $id_pro = $_GET['delete'];
        Projets::DelProjet($id_pro);
        header('Location: index.php');
    }


    public function ModifProject(){
        $view = new Views('ModifProject', 'Modifier un projet');
        if (Security::isConnected()) {
            $view->setVar('connected', true);
        } else {
            header('location: index.php');
        }
        if (isset($_POST['submitPro'])){
            unset($_POST['submitPro']);
            if (Projets::updateById()) {
                header('location: index.php');
            }
        }
        $view->render();
    }

    public function AfficheProject(){
        $view = new Views('AfficheProject', 'Détails du Projet');
        $tasks = Projets::GetTaches();
        if (Security::isConnected()) {
            $view->setVar('connected', true);
        } else {
            header('location: index.php');
        }
        $project_title = Projets::getByAttribute('id_projet', $_GET['show']);
        foreach ($project_title[0] as $key => $value){
            if ($key === 'nom'){
                $project_title = $value;
            }
        }
        $view -> setVar('project_title', $project_title);
        $view -> setVar('tasks', $tasks);
        $view -> render();
    }

    public function CreateTask(){
        $view = new Views('CreateTask', 'Création d\'une tâche');
        if (Security::isConnected()) {
            $view->setVar('connected', true);
        } else {
            header('location: index.php');
        }
        if (isset($_POST['create'])){
            unset($_POST['create']);
            $id_user = Users::getByAttribute('mail', $_POST['mail']);
            foreach ($id_user[0] as $key => $value){
                if ($key === 'id_users') {
                    $id_user = $value;
                }
            }
            unset($_POST['mail']);
            $_POST['id_users'] = $id_user;
            $_POST['id_projet'] = $_GET['create_task'];
            $_POST['id_cycle'] = 1;
            if (Taches::create()) {
                header('location: index.php');
            } else {
                $view->setVar('message', "Une erreur est survenue");
            }
        }
        $view->render();
    }
}