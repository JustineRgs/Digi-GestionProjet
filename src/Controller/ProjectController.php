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
        if (isset($_GET['update']) || isset($_GET['update_project'])){
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
                header("location: index.php");
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
        $tasks = Projets::GetTachesProject();
        $in_project = Users::GetUsersList('in');
        $not_in_project = Users::GetUsersList('out');
        if (Security::isConnected()) {
            $view->setVar('connected', true);
        } else {
            header('location: index.php');
        }
        $project_name = Projets::getByAttribute('id_projet', $_GET['update']);
        foreach ($project_name[0] as $key => $value){
            if ($key === 'nom'){
                $project_name = $value;
            }
        }
        if (isset($_POST['add_user'])){
            unset($_POST['add_user']);
            if (Users::AddUserToProject()){
                $id_projet = $_GET['update'];
                header("location: index.php?page=project&update=$id_projet");
            }
        }
        if (isset($_POST['delete_project'])){
            $id_projet = $_GET['update'];
            header("location: index.php?page=project&update=$id_projet");
        }
        if (isset($_POST['create_task'])){
            header("location: index.php?page=project&create_task=".$_GET['update']);
        }
        if (isset($_POST['create_user'])){
            $project = $_GET['update'];
            header("location: index.php?page=profile&user=register&project=$project");
        }
        $admin = Users::GetAffectationProject();
        $view -> setVar('project_name', $project_name);
        $view -> setVar('tasks', $tasks);
        $view -> setVar('in_project', $in_project);
        $view -> setVar('not_in_project', $not_in_project);
        $view -> render();
    }
    
    public function AfficheProject(){
        $view = new Views('AfficheProject', 'Détails du Projet');
        $tasks = Projets::GetTachesProject();
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
        if (isset($_POST['changeEtat'])){
            if(Taches::changeTaskEtat()){
                header('location: index.php?page=project&show='.$_GET['show']);
            }
        }
        if (isset($_POST['update_project'])){
            header("location: index.php?page=project&update=".$_GET['show']);
        }
        $admin = Users::GetAffectationProject();
        $view -> setVar('project_title', $project_title);
        $view -> setVar('tasks', $tasks);
        $view -> setVar('admin', $admin[0]);
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
                header("location: index.php?page=project&show=".$_GET['create_task']);
            } else {
                $view->setVar('message', "Une erreur est survenue");
            }
        }
        $view->render();
    }
}