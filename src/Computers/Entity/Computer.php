<?php

namespace App\Computers\Entity;

class Computer
{
    protected $id;

    protected $marque;

    protected $prix;

    protected $idUser;

    public function __construct($id, $marque, $prix, $idUser)
    {
        $this->id = $id;
        $this->marque = $marque;
        $this->prix = $prix;
        $this->idUser = $idUser;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setMarque($marque)
    {
        $this->marque = $marque;
    }

    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }



    public function getId()
    {
        return $this->id;
    }
    public function getPrix()
    {
        return $this->prix;
    }
    public function getMarque()
    {
        return $this->marque;
    }

    public function getIdUser()
    {
        return $this->idUser;
    }

    public function toArray()
    {
        $array = array();
        $array['id'] = $this->id;
        $array['marque'] = $this->marque;
        $array['prix'] = $this->prix;
        $array['isUser'] = $this->idUser;

        return $array;
    }
}
