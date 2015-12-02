<?php

spl_autoload_register(function ($classe) {
    include $classe . '.php';
});

class Nota {

    private $idNota;
    private $assignturaId;
    private $cursId;
    private $alumneId;
    private $nota;

    public function getIdNota()
    {
        return $this->idNota;
    }
    public function setIdNota($idNota)
    {
        $this->idNota=$idNote;
    }

    public function getAssignturaId()
    {
        return $this->assignturaId;
    }
    public function setAssignturaId($assignturaId)
    {
        $this->assignturaId=$assignturaId;
    }

     public function getCursId()
    {
        return $this->cursId;
    }
    public function setCursId($cursId)
    {
        $this->cursId=$cursId;
    }

     public function getAlumneId()
    {
        return $this->alumneId;
    }
    public function setAlumneId($alumneId)
    {
        $this->alumneId=$alumneId;
    }

      public function getNota()
    {
        return $this->nota;
    }
    public function setNota($nota)
    {
        $this->nota=$nota;
    }
    public function __construct($idNota, $assignturaId, $cursId, $alumneId)
    {
        $this->idNota=$idNota;
        $this->assignturaId=$assignturaId;
        $this->cursId=$cursId;
        $this->alumneId=$alumneId;
    }
}
