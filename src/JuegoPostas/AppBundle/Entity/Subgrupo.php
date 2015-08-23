<?php

namespace JuegoPostas\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Subgrupo
 *
 * @ORM\Table(name="subgrupo")
 * @ORM\Entity(repositoryClass="JuegoPostas\AppBundle\Repository\SubgrupoRepository")
 */
class Subgrupo
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
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     */
    private $nombre;

    /**
     * @var \JuegoPostas\AppBundle\Entity\EstadoSubgrupo
     *
     * @ORM\ManyToOne(targetEntity="JuegoPostas\AppBundle\Entity\EstadoSubgrupo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estado", referencedColumnName="id")
     * })
     */
    private $estado;

    /**
     * @var \JuegoPostas\AppBundle\Entity\Grupo
     *
     * @ORM\ManyToOne(targetEntity="JuegoPostas\AppBundle\Entity\Grupo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_grupo", referencedColumnName="id")
     * })
     */
    private $grupo;
	
	//, orphanRemoval=true)
	
	/**
     * @ORM\OneToMany(targetEntity="JuegoPostas\AppBundle\Entity\Participante", mappedBy="subgrupo", cascade={"persist"}) 
     */
	private $participantes;

	/**
	 * Constructor
	 */
	public function __construct()
    {
        $this->participantes = new ArrayCollection();
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
     * @return Subgrupo
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
     * Set estado
     *
     * @param \JuegoPostas\AppBundle\Entity\EstadoSubgrupo $estado
     * @return Subgrupo
     */
    public function setEstado(\JuegoPostas\AppBundle\Entity\EstadoSubgrupo $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \JuegoPostas\AppBundle\Entity\EstadoSubgrupo 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set grupo
     *
     * @param \JuegoPostas\AppBundle\Entity\Grupo $grupo
     * @return Subgrupo
     */
    public function setGrupo(\JuegoPostas\AppBundle\Entity\Grupo $grupo = null)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo
     *
     * @return \JuegoPostas\AppBundle\Entity\Grupo 
     */
    public function getGrupo()
    {
        return $this->grupo;
    }
	
	/**
     * Add participante
     *
     * @param \JuegoPostas\AppBundle\Entity\Participante $participante
     */
    public function addParticipante(\JuegoPostas\AppBundle\Entity\Participante $participante)
    {
    	$participante->setSubgrupo($this);
    	
        $this->participantes->add($participante);
    }
    
    /**
     * Remove participante
     *
     * @param \JuegoPostas\AppBundle\Entity\Participante $participante
     */
    public function removeParticipante(\JuegoPostas\AppBundle\Entity\Participante $participante)
    {
    	$this->getParticipantes()->removeElement($participante);
		$participante->setSubgrupo(null);
    }
    
    /**
     * Set participantes
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function setParticipantes($participantes)
    {
    	if (count($participantes) > 0) {
        	foreach ($participantes as $p) {
            	$this->addParticipante($p);
        	}
    	}
    	
    	return $this;
    }

    /**
     * Get participantes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getParticipantes()
    {
        return $this->participantes;
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
