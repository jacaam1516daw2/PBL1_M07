<?php

class Curs {

    private $idCurs;
    private $nomCurs;
    private $nomResponsable;

    public function getIdCurs()
    {
        return $this->idCurs;
    }
    public function setIdCurs($idCurs)
    {
        $this->idCurs=$idCurs;
    }

    public function getNomCurs()
    {
        return $this->nomCurs;
    }
    public function setNomCurs($nomCurs)
    {
        $this->nomCurs=$nomCurs;
    }

     public function getNomResponsable()
    {
        return $this->nomResponsable;
    }
    public function setNomResponsable($nomResponsable)
    {
        $this->nomResponsable=$nomResponsable;
    }

    public function __construct($idCurs, $nomCurs, $nomResponsable)
    {
        $this->idCurs=$idCurs;
        $this->nomCurs=$nomCurs;
        $this->nomResponsable=$nomResponsable;
    }
}

?>
