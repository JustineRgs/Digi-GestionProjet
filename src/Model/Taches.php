<?php

namespace Formation\MonApp\Model;

use Formation\MonApp\Core\Model;

class Taches  extends Model {
    private $id_taches;
    public $nom;
    public $description;
    public $priorite;
    private $id_users;
    private $id_projet;
    private $id_cycle;


    /**
     * Get the value of id_taches
     */ 
    public function getId_taches()
    {
        return $this->id_taches;
    }

    /**
     * Set the value of id_taches
     *
     * @return  self
     */ 
    public function setId_taches($id_taches)
    {
        $this->id_taches = $id_taches;

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

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of priorite
     */ 
    public function getPriorite()
    {
        return $this->priorite;
    }

    /**
     * Set the value of priorite
     *
     * @return  self
     */ 
    public function setPriorite($priorite)
    {
        $this->priorite = $priorite;

        return $this;
    }
}