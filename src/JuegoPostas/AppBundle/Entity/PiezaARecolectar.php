<?php

namespace JuegoPostas\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PiezaARecolectar
 *
 * @ORM\Table(name="pieza_a_recolectar")
 * @ORM\Entity
 */
class PiezaARecolectar
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=false)
     */
    private $descripcion;
	
	/**
     * @ORM\ManyToOne(targetEntity="JuegoPostas\AppBundle\Entity\Consigna", inversedBy="piezasARecolectar")
     * @ORM\JoinColumn(name="id_consigna", referencedColumnName="id")
     */
	private $consigna;



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
     * @return PiezaARecolectar
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
     * @return PiezaARecolectar
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
     * Set consigna
     *
     * @param \JuegoPostas\AppBundle\Entity\Consigna $consigna
     */
    public function setConsigna(\JuegoPostas\AppBundle\Entity\Consigna $consigna)
    {
        $this->consigna = $consigna;
    }

    /**
     * Get consigna
     *
     * @return \JuegoPostas\AppBundle\Entity\Consigna 
     */
    public function getConsigna()
    {
        return $this->consigna;
    }
}
