<?php

namespace Formation\MonApp\Core;

use Formation\MonApp\Controller\DefaultPage;
use Formation\MonApp\Controller\ProjectController;
use Formation\MonApp\Controller\UserController;

class Dispatcher
{

    public function __construct()
    {
        if (isset($_GET['session'])) {
            session_start();
            session_destroy();
            header('location: index.php');
        }
        if (isset($_GET['page'])) {
            switch ($_GET['page']) {
                case 'project':
                    new ProjectController();
                    break;
                case 'profile':
                    new UserController();
                    break;
                default:
                    new DefaultPage();
                    break;
            }
        } else {
            new DefaultPage();
        }
    }
}