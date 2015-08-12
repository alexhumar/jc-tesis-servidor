<?php

namespace JuegoPostas\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participante
 *
 * @ORM\Table(name="participante")
 * @ORM\Entity
 */
class Participante
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
     * @ORM\Column(name="nombre", type="string", length=150, nullable=false)
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="edad", type="integer", nullable=false)
     */
    private $edad;

    /**
     * @var \JuegoPostas\AppBundle\Entity\Subgrupo
     *
     * @ORM\ManyToOne(targetEntity="JuegoPostas\AppBundle\Entity\Subgrupo", inversedBy="participantes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_subgrupo", referencedColumnName="id")
     * })
     */
    private $subgrupo;



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
     * @return Participante
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
     * Set edad
     *
     * @param integer $edad
     * @return Participante
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return integer 
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Set subgrupo
     *
     * @param \JuegoPostas\AppBundle\Entity\Subgrupo $subgrupo
     * @return Participante
     */
    public function setSubgrupo(\JuegoPostas\AppBundle\Entity\Subgrupo $subgrupo = null)
    {
        $this->subgrupo = $subgrupo;

        return $this;
    }

    /**
     * Get subgrupo
     *
     * @return \JuegoPostas\AppBundle\Entity\Subgrupo 
     */
    public function getSubgrupo()
    {
        return $this->subgrupo;
    }
}
