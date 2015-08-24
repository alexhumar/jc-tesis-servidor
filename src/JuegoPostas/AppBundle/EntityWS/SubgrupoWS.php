<?php

namespace JuegoPostas\AppBundle\EntityWS;

class SubgrupoWS
{

    private $id;
    private $nombre;
    
    /**
     * Constructor
     */
    public function __construct($id, $nombre)
    {
    	$this->id = $id;
    	$this->nombre = $nombre;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return SubgrupoWS
     */
    public function setId($id)
    {
    	$this->id = $id;
    
    	return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return SubgrupoWS
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }
    
    /**
     * Metodo toString
     *
     * @return string
     */
    public function __toString()
    {
    	return $this->getNombre();
    }
}
