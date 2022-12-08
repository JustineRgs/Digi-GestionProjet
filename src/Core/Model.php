<?php

namespace Formation\MonApp\Core;

class Model
{
    public static $instance = null;
public static $onaffect = false;
    private static $dsn = 'mysql:dbname=gestion_projet;host=localhost';
    private static $username = 'gestion';
        private static $password = '123456'; // Variable pour définir si on affecte ou non (agis sur la fonction clear)

    private function __construct()
    {
        try {
            self::$instance = new \PDO(self::$dsn, self::$username, self::$password);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }


    //SELECT

    public static function getAll()
    {
        $query = self::getInstance()->query('select * from '.self::getClass());

        return $query->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            new Model();
        }

        return self::$instance;
    }

    private static function getClass()
    {
        $classe = get_called_class();
        $classeTab = explode('\\', $classe);

        return $classeTab[count($classeTab) - 1];
    }

    public static function getSession($table, $id)
    {
        $query = self::getInstance()->query('select * from '.$table.' where id_users='.$id);

        return $query->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }

    public static function getById($id)
    {
        $query = self::getInstance()->query('select * from '.self::getClass().' where id='.$id);

        return $query->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }

    public static function getId($select, $table, $search, $user)
    { // Fonction pour récupérer un ID précisement avec une comparaison sur une donnée précise
        $sql = "select id_".$select." from ".$table." where ".$search."='".$user."'";
        $return = self::getInstance()->query($sql)->fetchAll(
        ); // Assignation à la variable $return du retour de la requête SQL

        return $return[0][0]; // Renvoie de l'ID;
    }

    public static function getByAttribute($name, $value)
    {
        $query = self::getInstance()->query('select * from '.self::getClass().' where '.$name.'='."'".$value."'");

        return $query->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }

    public static function GetAffectation()
    {
        if (Security::isConnected()) {
            $user = $_SESSION['id'];
            $query = self::getInstance()->query(
                "SELECT * FROM projets p JOIN affectation a ON p.id_projet = a.id_projet WHERE a.id_users = $user ORDER BY a.administrateur DESC"
            );

            return $query->fetchAll();
        }
    }

    public static function GetAffectationProject()
    {
        if (Security::isConnected()) {
            if (isset($_GET['show'])) {
                $project = $_GET['show'];
            }
            if (isset($_GET['update'])) {
                $project = $_GET['update'];
            }
            $query = self::getInstance()->query(
                "SELECT * FROM projets p JOIN affectation a ON p.id_projet = a.id_projet WHERE a.id_projet = $project"
            );

            return $query->fetchAll();
        }
    }

    public static function GetProject()
    {
        if (Security::isConnected()) {
            $query = self::getInstance()->query("SELECT * FROM projets");

            return $query->fetchAll();
        }
    }

    public static function GetTaches()
    {
        if (Security::isConnected()) {
            $user = $_SESSION['id'];
            $query = self::getInstance()->query(
                "SELECT *, taches.nom as 'task_name', u.nom as 'lastname' FROM taches JOIN users u ON taches.id_users = u.id_users JOIN projets p ON taches.id_projet = p.id_projet JOIN cycle_vie c ON taches.id_cycle = c.id_cycle WHERE taches.id_users = $user ORDER BY priorite DESC"
            );

            return $query->fetchAll();
        }
    }

    public static function GetTachesProject()
    {
        if (Security::isConnected()) {
            $user = $_SESSION['id'];
            $query = self::getInstance()->query(
                "SELECT *, taches.nom as 'task_name', u.nom as 'lastname' FROM taches JOIN users u ON taches.id_users = u.id_users JOIN projets p ON taches.id_projet = p.id_projet JOIN cycle_vie c ON taches.id_cycle = c.id_cycle"
            );

            return $query->fetchAll();
        }
    }

    public static function GetUsersList($inout)
    {
        if (Security::isConnected()) {
            $user = $_SESSION['id'];
            if (isset($_GET['update'])) {
                $project = $_GET['update'];
            }
            if (isset($_GET['create_task'])) {
                $project = $_GET['create_task'];
            }
            if ($inout === 'in') {
                $query = self::getInstance()->query(
                    "SELECT nom, prenom, u.id_users, u.mail FROM users u JOIN affectation a ON u.id_users = a.id_users WHERE a.id_projet = $project"
                );
            } else {
                $query = self::getInstance()->query(
                    "SELECT DISTINCT nom, prenom, u.id_users, u.mail FROM users u JOIN affectation a where (u.id_users = a.id_users AND a.id_projet != $project AND a.id_users NOT IN (SELECT u.id_users FROM users u JOIN affectation a ON u.id_users = a.id_users where a.id_projet = $project)) OR u.id_users not in (SELECT id_users FROM affectation)"
                );
            }

            return $query->fetchAll();
        }
    }


    //CREATE

    public static function UserProject()
    {
        $query = self::getInstance()->query('SELECT * FROM '.self::getClass().' where id_user='.$_SESSION['id']);

        return $query->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }

    // Récupèration de l'information user par la class getClass

    public static function AddUserToProject()
    {
        if (Security::isConnected()) {
            if (isset($_GET['update'])) {
                $project_id = $_GET['update'];
                $user_id = $_POST['user_id'];
            }
            if (isset($_GET['project'])) {
                $project_id = $_GET['project'];
                $user_id = self::getInstance()->lastInsertId();
            }
            $admin = 0;
            $sql = "insert into affectation (id_users, id_projet, administrateur) values($user_id, $project_id, $admin)";

            return self::getInstance()->prepare($sql)->execute();
        }
    }

    // Ajout d'un utilisateur sur un projet existant

    public static function updateById()
    {
        $sql = "update ".self::getClass()." set ";
        foreach ($_POST as $key => $value) {
            if ($key === 'create') {
                continue;
            }
            $sql .= $key.'= :'.$key.',';
        }
        $sql = substr($sql, 0, strlen($sql) - 1);
        $sql .= " where id=".$_GET['update'];
        $vars = self::clear();
        unset($vars[1]['id']);

        return self::getInstance()->prepare($sql)->execute($vars[1]);
    }


    //UPDATE

    private static function clear()
    {
        unset($_POST['create']);
        if (self::$onaffect === true) { // Condition pour séparer la fonction de base et son utilisation lors de l'affection
            $return[] = ''; // Déclaration et affectation vide du tableau $return
            if ($_GET['page'] === 'project' && !isset($_GET['create_task'])) {
                $return[1][0] = $_SESSION['id']; // Utilisation de l'ID utilisateur stocker dans la session
            }
        } else {
            $return[] = ':id';
            if (isset($_GET['page'])) {
                if (isset($_GET['user']) || $_GET['page'] === 'project') {
                    $return[1]['id'] = null;
                }
            }
            foreach ($_POST as $key => $value) {
                $return[0] .= ',:'.$key;
                $return[1][$key] = htmlspecialchars($value);
            }
        }

        return $return;
    }

    //Update Etat des tâches

    public static function changeEtat($etat_id)
    {
        switch ($etat_id) {
            case 1:
                return 'Commencer';
                break;
            case 2:
                return 'Terminer';
                break;
            case 3:
                return '';
                break;
            default:
                return 'Commencer';
                break;
        }
    }

    public static function changeTaskEtat()
    {
        $id_cycle = $_POST['id_cycle'];
        if ($id_cycle !== 3) {
            $id_cycle++;
        }
        $sql = "update taches set id_cycle='".$id_cycle."' where id_taches='".$_POST['id_taches']."'";

        return self::getInstance()->prepare($sql)->execute();
    }

    // Changement du profil par variable
    public static function ChangeProfil()
    {
        $user = $_SESSION['id'];
        foreach ($_POST as $row => $key) {
            if (isset($row)) {
                self::getInstance()->prepare("UPDATE users SET $row = '$key' WHERE id_users = $user ")->execute();
            }
        }
    }

    // Update Photo de profil
    public static function ChangeAvatar($avatar)
    {
        $user = $_SESSION['id'];
        $_SESSION['avatar'] = $avatar;
        if (isset($_POST['avatar'])) {
            return self::getInstance()->prepare("UPDATE users SET avatar = '$avatar' WHERE id_users=$user")->execute();
        }
    }

    // Update Mot de Passe
    public static function ChangePwd($newPwd)
    {
        $user = $_SESSION['id'];

        return self::getInstance()->prepare("UPDATE users SET pwd = '$newPwd' WHERE id_users = $user")->execute();
    }

    // Update Taches 
    public static function UpdateTask($priorite, $titre, $description, $user_id, $task_id)
    {
        $sql = "UPDATE taches set priorite = '$priorite', nom = '$titre', description = '$description', id_users = $user_id WHERE id_taches = $task_id";

        return self::getInstance()->prepare($sql)->execute();
    }

    // Update Nom du Projet
    public static function UpdateProjectName($project_name, $id_projet)
    {
        $sql = "UPDATE projets set nom = '$project_name' where id_projet = $id_projet";

        return self::getInstance()->prepare($sql)->execute();
    }


    // DELETE
    public static function deleteById($id)
    {
        $sql = "delete from ".self::getClass()." where id=".$id;
        $query = self::getInstance()->exec($sql);
    }

    // Delete : Projet 
    public static function DelProjet($id_pro)
    {
        if (Security::isConnected()) {
            return self::getInstance()->prepare("DELETE FROM projets WHERE id_projet = $id_pro")->execute();
        }
    }

    // Delete : Utilisateur
    public static function DelUser($id_user)
    {
        echo 'okey';
        if (Security::isConnected()) {
            return self::getInstance()->prepare("DELETE FROM users WHERE id_users = $id_user")->execute();
        }
    }

    // Delete : Utilisateur d'une tache)
    public static function DelUserProject()
    {
        if (isset($_GET['deleteU'])) {
            $id_user = $_GET['deleteU'];
            $id_projet = $_GET['pagemodif'];
            if (Security::isConnected()) {
                return self::getInstance()->prepare(
                    "DELETE FROM affectation WHERE id_users = $id_user AND id_projet = $id_projet"
                )->execute();
            }
        }
    }

    // Delete : Taches
    public static function DelTask($id_tache, $id_projet)
    {
        if (Security::isConnected()) {
            return self::getInstance()->prepare(
                "DELETE FROM taches WHERE id_projet = $id_projet AND id_taches = $id_tache"
            )->execute();
        }
    }


    //OTHER


    public static function affect()
    { // Fonction permettant de créer et d'affecter un projet et un utilisateur
        self::create(); // Utilisation de la fonction create
        $id_projet = self::getInstance()->lastInsertId(); // Récupération de l'ID du projet
        self::$onaffect = true; // Changement de la variable onaffect en true (agis sur la fonction clear)
        $vars = self::clear(); // Utilisation de la fonction create
        self::$onaffect = false; // Changement de la variable onaffect en false (agis sur la fonction clear)
        $vars[1][] = $id_projet; // ID du projet
        $vars[1][] = true; // = administrateur dans bdd
        $push = ''; // Déclaration de la variable push afin de convertir l'array en string
        foreach ($vars[1] as $value) { // Foreach pour que chaque valeur soit ajouter en string
            $push .= $value.',';
        }
        $push = substr($push, 0, strlen($push) - 1); // On retire la dernière virgule
        $sql = "insert into affectation (id_users, id_projet, administrateur) values(".$push.")"; // Définition de la commande SQL

        return self::getInstance()->prepare($sql)->execute(); // Préparation et éxecution de la commande SQL
    }

    public static function create()
    {
        self::$onaffect === false;
        $vars = self::clear();
        // if (self::getByAttribute('projets', $vars[1]['ProjectName'])){
        //     return;
        // }
        $sql = 'insert into '.self::getClass()." values(".$vars[0].")";
        var_dump($sql);
        var_dump($vars[1]);

        return self::getInstance()->prepare($sql)->execute($vars[1]);
    }
}