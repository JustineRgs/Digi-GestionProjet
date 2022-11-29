<?php

namespace Formation\MonApp\Controller;

use Formation\MonApp\Core\Model;
use Formation\MonApp\Core\Views;
use Formation\MonApp\Core\Security;
use Formation\MonApp\Model\Projets;
use Formation\MonApp\Controller\UserController;
use Formation\MonApp\Model\Users;

class DefaultPage extends Model{

    public function __construct(){
        $view = new Views('DefaultPage', '');
        if (isset($_POST['connect'])) {
            Security::ConnectUser();
        }
        // if (isset($_POST['create'])) {
        //     UserController->createUser();
        // }
        if (Security::isConnected()) {
            $view->setVar('connected', true);
        } else {
            $view->setVar('connected', false);
        }
        $pro = Projets::GetProject();
        $view->setVar('pro', $pro);
        $view->setVar('message','Vos réalisations en cours');
        $view->render();
    }

}