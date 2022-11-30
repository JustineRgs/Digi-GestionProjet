<?php

namespace Formation\MonApp\Model;

use Formation\MonApp\Core\Model;

class Projets  extends Model {

    private $id_projets;

    public $nom;   



    /**
     * Get the value of id_projets
     */ 
    public function getId_projets()
    {
        return $this->id_projets;
    }

    /**
     * Set the value of id_projets
     *
     * @return  self
     */ 
    public function setId_projets($id_projets)
    {
        $this->id_projets = $id_projets;

        return $this;
    }

    /**
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }
}