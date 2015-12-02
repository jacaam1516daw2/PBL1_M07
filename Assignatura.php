<?php

class Assignatura {

    private $idAssignatura;
    private $nomProfessor;
    private $nomAssignatura;
    private $cursId;

    public function getCursId()
    {
        return $this->cursId;
    }
    public function setCursId($cursId)
    {
        $this->cursId=$cursId;
    }

    public function getIdAssignatura()
    {
        return $this->idAssignatura;
    }
    public function setIdAssignatura($idAssignatura)
    {
        $this->idAssignatura=$idAssignatura;
    }

     public function getNomProfessor()
    {
        return $this->nomProfessor;
    }
    public function setNomProfessor($nomProfessor)
    {
        $this->nomProfessor=$nomProfessor;
    }
     public function getNomAssignatura()
    {
        return $this->nomAssignatura;
    }
    public function setNomAssignatura($nomAssignatura)
    {
        $this->nomAssignatura=$nomAssignatura;
    }

    public function __construct($idAssignatura, $nomProfessor, $nomAssignatura, $cursId)
    {
        $this->idAssignatura=$idAssignatura;
        $this->nomProfessor=$nomProfessor;
        $this->nomAssignatura=$nomAssignatura;
        $this->cursId=$cursId;
    }
}

?>
