<?php

namespace JuegoPostas\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Respuesta
 *
 * @ORM\Table(name="respuesta")
 * @ORM\Entity(repositoryClass="JuegoPostas\AppBundle\Repository\RespuestaRepository")
 */
class Respuesta
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
     * @var boolean
     *
     * @ORM\Column(name="acuerdo_propuesta", type="boolean", nullable=false)
     */
    private $acuerdoPropuesta;

    /**
     * @var string
     *
     * @ORM\Column(name="justificacion", type="string", length=255, nullable=false)
     */
    private $justificacion;

	/**
     * @var \JuegoPostas\AppBundle\Entity\Consulta
     *
     * @ORM\ManyToOne(targetEntity="JuegoPostas\AppBundle\Entity\Consulta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_consulta", referencedColumnName="id")
     * })
     */
    private $consulta;
	
    /**
     * @var \JuegoPostas\AppBundle\Entity\Subgrupo
     *
     * @ORM\ManyToOne(targetEntity="JuegoPostas\AppBundle\Entity\Subgrupo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_subgrupo_consultado", referencedColumnName="id")
     * })
     */
    private $subgrupoConsultado;



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
     * Set acuerdoPropuesta
     *
     * @param boolean $acuerdoPropuesta
     * @return Respuesta
     */
    public function setAcuerdoPropuesta($acuerdoPropuesta)
    {
        $this->acuerdoPropuesta = $acuerdoPropuesta;

        return $this;
    }

    /**
     * Get acuerdoPropuesta
     *
     * @return boolean 
     */
    public function getAcuerdoPropuesta()
    {
        return $this->acuerdoPropuesta;
    }

    /**
     * Set justificacion
     *
     * @param string $justificacion
     * @return Respuesta
     */
    public function setJustificacion($justificacion)
    {
        $this->justificacion = $justificacion;

        return $this;
    }

    /**
     * Get justificacion
     *
     * @return string 
     */
    public function getJustificacion()
    {
        return $this->justificacion;
    }

    /**
     * Set consulta
     *
     * @param \JuegoPostas\AppBundle\Entity\Consulta $consulta
     * @return Respuesta
     */
    public function setConsulta(\JuegoPostas\AppBundle\Entity\Consulta $consulta = null)
    {
        $this->consulta = $consulta;

        return $this;
    }

    /**
     * Get consulta
     *
     * @return \JuegoPostas\AppBundle\Entity\Consulta 
     */
    public function getConsulta()
    {
        return $this->consulta;
    }

    /**
     * Set subgrupoConsultado
     *
     * @param \JuegoPostas\AppBundle\Entity\Subgrupo $subgrupoConsultado
     * @return Respuesta
     */
    public function setSubgrupoConsultado(\JuegoPostas\AppBundle\Entity\Subgrupo $subgrupoConsultado = null)
    {
        $this->subgrupoConsultado = $subgrupoConsultado;

        return $this;
    }

    /**
     * Get subgrupoConsultado
     *
     * @return \JuegoPostas\AppBundle\Entity\Subgrupo 
     */
    public function getSubgrupoConsultado()
    {
        return $this->subgrupoConsultado;
    }
    
    /**
     * Metodo toString
     *
     * @return string
     */
    public function __toString()
    {
    	return ($this->getAcuerdoPropuesta() ? 'De acuerdo: ' : 'En desacuerdo: ') . $this->getJustificacion();
    }
	
	/*
	 * Metodo toArray
	 * 
	 * @return array
	 */
	 public function toArray($deep = true){
	 	$array = get_object_vars($this);
		$array['consulta'] = $this->consulta->toArray();
		$array['subgrupoConsultado'] = $this->subgrupoConsultado->toArray();
		return $array;
	 }
}
