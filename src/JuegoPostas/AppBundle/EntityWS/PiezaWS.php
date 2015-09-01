<?php

namespace JuegoPostas\AppBundle\EntityWS;

use BeSimple\SoapBundle\ServiceDefinition\Annotation as Soap;

class PiezaWS
{

	/**
	 * @Soap\ComplexType("int")
	 */
    private $id;

    /**
     * @Soap\ComplexType("string")
     */
    private $nombre;

    /**
     * @Soap\ComplexType("string")
     */
    private $descripcion;
	
    /**
     * @Soap\ComplexType("JuegoPostas\AppBundle\EntityWS\PoiWS")
     */
	private $poi;
	
	
	/**
     * Constructor
     */
	public function __construct($id, $nombre, $descripcion, $poi) {
		$this->id = $id;
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
		$this->poi = $poi;
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
     * @return PiezaWS
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return PiezaWS
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
	
    /**
     * Set poi
     *
     * @param \JuegoPostas\AppBundle\EntityWS\PoiWS $poi
     * @return PiezaWS
     */
    public function setPoi(\JuegoPostas\AppBundle\EntityWS\PoiWS $poi = null)
    {
    	$this->poi = $poi;
    
    	return $this;
    }
    
    /**
     * Get poi
     *
     * @return \JuegoPostas\AppBundle\EntityWS\PoiWS
     */
    public function getPoi()
    {
    	return $this->poi;
    }
    
    /**
     * Metodo toString
     *
     * @return string
     */
    public function __toString()
    {
    	return $this->getNombre() . ' - ' . $this->getDescripcion();
    }
}
