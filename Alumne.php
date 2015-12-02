<?php

class Alumne {

    private $idAlumne;
    private $nomAlumne;
    private $cognomAlumne1;
    private $cognomAlumne2;
    private $cursId;

    public function getCursId()
    {
        return $this->cursId;
    }
    public function setCursId($cursId)
    {
        $this->cursId=$cursId;
    }

    public function getIdAlumne()
    {
        return $this->idAlumne;
    }
    public function setIdAlumne($idAlumne)
    {
        $this->idAlumne=$idAlumne;
    }

     public function getNomAlumne()
    {
        return $this->nomAlumne;
    }
    public function setNomAlumne($nomAlumne)
    {
        $this->nomAlumne=$nomAlumne;
    }
     public function getCognomAlumne1()
    {
        return $this->cognomAlumne1;
    }
    public function setCognomAlumne1($cognomAlumne1)
    {
        $this->cognomAlumne1=$cognomAlumne1;
    }
     public function getCognomAlumne2()
    {
        return $this->cognomAlumne2;
    }
    public function setCognomAlumne2($cognomAlumne2)
    {
        $this->cognomAlumne2=$cognomAlumne2;
    }

    public function __construct($idAlumne, $nomAlumne, $cognomAlumne1, $cognomAlumne2, $cursId)
    {
        $this->idAlumne=$idAlumne;
        $this->nomAlumne=$nomAlumne;
        $this->cognomAlumne1=$cognomAlumne1;
        $this->cognomAlumne2=$cognomAlumne2;
        $this->cursId=$cursId;
    }
}

?>
