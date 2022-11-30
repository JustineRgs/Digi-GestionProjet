<?php

namespace Formation\MonApp\Core;

use Formation\MonApp\Model\Users;

class Model {
    private static $dsn = 'mysql:dbname=gestion_projet;host=localhost';
    private static $username = 'gestion';
    private static $password = '123456';
    public static $instance=NULL;
    public static $onaffect = false; // Variable pour définir si on affecte ou non (agis sur la fonction clear)

    private function __construct() {
        try {
            self::$instance = new \PDO(self::$dsn,self::$username,self::$password);
        } catch(\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getInstance() {
        if (self::$instance === NULL) {
            new Model();
        }
        return self::$instance;
    }

    private static function getClass() {
        $classe = get_called_class();
        $classeTab = explode('\\',$classe);
        return $classeTab[count($classeTab)-1];
    }

    // public static function getSession(){
    //     $query = self::getInstance()->query('SELECT * FROM users');
    //     return $query->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    //     $_SESSION['auth'] = $query;
    // }

    public static function getAll() {
        $query = self::getInstance()->query('select * from '.self::getClass());
        return $query->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }

    public static function getSession($table, $id) {
        $query = self::getInstance()->query('select * from '.$table .' where id_users='.$id);
        return $query->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }

    public static function getById($id) {
        $query = self::getInstance()->query('select * from '.self::getClass().' where id='.$id);
        return $query->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }

    public static function deleteById($id) {
        $sql = "delete from ".self::getClass()." where id=".$id;
        $query = self::getInstance()->exec($sql);
    }

    public static function create() {
        self::$onaffect === false;
        $vars = self::clear();
        // if (self::getByAttribute('projets', $vars[1]['ProjectName'])){
        //     return;
        // }
        $sql = 'insert into '.self::getClass()." values(".$vars[0].")";
        return self::getInstance()->prepare($sql)->execute($vars[1]);
    }

    

    public static function affect(){ // Fonction permettant de créer et d'affecter un projet et un utilisateur
        self::create(); // Utilisation de la fonction create
        self::$onaffect = true; // Changement de la variable onaffect en true (agis sur la fonction clear)
        $vars = self::clear(); // Utilisation de la fonction create
        self::$onaffect = false; // Changement de la variable onaffect en false (agis sur la fonction clear)
        $vars[1][] = true; // = administrateur dans bdd
        $push = ''; // Déclaration de la variable push afin de convertir l'array en string
        foreach ($vars[1] as $value){ // Foreach pour que chaque valeur soit ajouter en string
        $push .= $value.',';
        }
        $push = substr($push, 0, strlen($push)-1); // On retire la dernière virgule
        $sql = "insert into affectation (id_users, id_projet, administrateur) values(".$push.")"; // Définition de la commande SQL
        return self::getInstance()->prepare($sql)->execute(); // Préparation et éxecution de la commande SQL
    }

    public static function updateById() {
        $sql = "update ".self::getClass()." set ";
        foreach ($_POST as $key=>$value) {
            if ($key === 'create') {
                continue;
            }
            $sql .= $key.'= :'.$key.',';
        }
        $sql = substr($sql,0,strlen($sql)-1);
        $sql .= " where id=".$_GET['update'];
        $vars = self::clear();
        unset($vars[1]['id']);
        return self::getInstance()->prepare($sql)->execute($vars[1]);
    }

    public static function getId($select ,$table, $search, $user){ // Fonction pour récupérer un ID précisement avec une comparaison sur une donnée précise
        $sql = "select id_".$select." from ".$table." where ".$search."='".$user."'";
        $return = self::getInstance()->query($sql)->fetchAll(); // Assignation à la variable $return du retour de la requête SQL
        return $return[0][0]; // Renvoie de l'ID;
    }
    
    // public static function getAllb(){
    //     $sql = 'SELECT * FROM users';
    //     $sql = self::getInstance()->prepare($sql)->execute();
    //     return $sql;
    // }

    public static function getByAttribute($name,$value) {
        $query = self::getInstance()->query('select * from '.self::getClass().' where '.$name.'='."'".$value."'");
        return $query->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }

    private static function clear() {
        unset($_POST['create']);
        if (self::$onaffect === true){ // Condition pour séparer la fonction de base et son utilisation lors de l'affection
            $return[] = ''; // Déclaration et affectation vide du tableau $return
            if ($_GET['page'] === 'project' && !isset($_GET['create_task'])) {
                $return[1][0] = $_SESSION['id']; // Utilisation de l'ID utilisateur stocker dans la session
            }
            foreach ($_POST as $key=>$value) {
                $return[1][] = self::getId('projet', 'projets','nom', htmlspecialchars($value)); // Attribution de l'ID projet dans le tableau $return
            }
        } else {
            $return[] = ':id';
            if (isset($_GET['page'])) {
                if (isset($_GET['user']) || $_GET['page'] === 'project')
                $return[1]['id'] = null;
            }
            foreach ($_POST as $key=>$value) {
                $return[0] .= ',:'.$key;
                $return[1][$key] = htmlspecialchars($value); 
            }
        }
        return $return;
    }

    // Project

    public static function UserProject(){
        $query = self::getInstance()->query('SELECT * FROM '.self::getClass().' where id_user='.$_SESSION['id']);
        return $query->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }

    public static function ChangeProfil(){
        $user = $_SESSION['id'];
        foreach($_POST as $row=>$key){
            // echo 'row' . $row . ' as ' . $key;

            if(isset($row)){
                self::getInstance()->prepare("UPDATE users SET $row = '$key' WHERE id_users = $user ")->execute();
            }else{
                echo 'test';
            }  
        }      
    }

    public static function ChangeAvatar($avatar){
        $user = $_SESSION['id'];
        if(isset($_POST['avatar'])){
                return self::getInstance()->prepare("UPDATE users SET avatar = '$avatar' WHERE id_users=$user")->execute();
        }
    }

    public static function GetAffectation(){
        if (Security::isConnected()){
            $user = $_SESSION['id'];
            $query = self::getInstance()->query("SELECT * FROM projets JOIN affectation ON projets.id_projet = affectation.id_projet WHERE affectation.id_users = $user");
            return $query->fetchAll();
        }
    }
    public static function GetProject(){
        if (Security::isConnected()){
            $query = self::getInstance()->query("SELECT * FROM projets");
            return $query->fetchAll();
        }
    }
    public static function GetTaches(){
        if (Security::isConnected()){
            $user = $_SESSION['id'];
            $query = self::getInstance()->query("SELECT *, taches.nom as 'task_name', u.nom as 'lastname' FROM taches JOIN users u ON taches.id_users = u.id_users JOIN projets p ON taches.id_projet = p.id_projet JOIN cycle_vie c ON taches.id_cycle = c.id_cycle WHERE taches.id_users = $user");
            return $query->fetchAll();
        }
    }
    // DELETE
    public static function DelProjet($id_pro){
        if (Security::isConnected()){
            return self::getInstance()->prepare("DELETE FROM projets WHERE id_projet = $id_pro")->execute();
        }
    }
}