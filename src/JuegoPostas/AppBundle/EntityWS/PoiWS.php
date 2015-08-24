<?php

namespace JuegoPostas\AppBundle\EntityWS;

class PoiWS
{
    private $id;
    private $coordenadaX;
    private $coordenadaY;
    
    /*Constructor*/
    public function __construct($id, $coordX, $coordY) {
    	$this->id = $id;
    	$this->coordenadaX = $coordX;
    	$this->coordenadaY = $coordY;
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
     * Set coordenadaX
     *
     * @param float $coordenadaX
     * @return Poi
     */
    public function setCoordenadaX($coordenadaX)
    {
        $this->coordenadaX = $coordenadaX;

        return $this;
    }

    /**
     * Get coordenadaX
     *
     * @return float 
     */
    public function getCoordenadaX()
    {
        return $this->coordenadaX;
    }

    /**
     * Set coordenadaY
     *
     * @param float $coordenadaY
     * @return Poi
     */
    public function setCoordenadaY($coordenadaY)
    {
        $this->coordenadaY = $coordenadaY;

        return $this;
    }

    /**
     * Get coordenadaY
     *
     * @return float 
     */
    public function getCoordenadaY()
    {
        return $this->coordenadaY;
    }
    
    /**
     * Metodo toString
     *
     * @return string
     */
    public function __toString()
    {
    	return 'CoordX: ' . strval($this->getCoordenadaX()) . ' CoordY: ' . strval($this->getCoordenadaY());
    }
}
