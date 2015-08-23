<?php

namespace JuegoPostas\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Posta
 *
 * @ORM\Table(name="posta")
 * @ORM\Entity
 */
class Posta
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
	 * @var \JuegoPostas\AppBundle\Entity\Posta
	 * 
     * @ORM\OneToOne(targetEntity="JuegoPostas\AppBundle\Entity\Posta")
     * @ORM\JoinColumn(name="id_posta_siguiente", referencedColumnName="id")
     **/
    private $postaSiguiente;

    /**
     * @var \JuegoPostas\AppBundle\Entity\Decision
     *
     * @ORM\ManyToOne(targetEntity="JuegoPostas\AppBundle\Entity\Decision")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_decision_final", referencedColumnName="id")
     * })
     */
    private $decisionFinal;

    /**
     * @var \JuegoPostas\AppBundle\Entity\Poi
     *
     * @ORM\ManyToOne(targetEntity="JuegoPostas\AppBundle\Entity\Poi")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_poi", referencedColumnName="id")
     * })
     */
    private $poi;

    /**
     * @var \JuegoPostas\AppBundle\Entity\Subgrupo
     *
     * @ORM\ManyToOne(targetEntity="JuegoPostas\AppBundle\Entity\Subgrupo")
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
     * @return Posta
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
     * Set postaSiguiente
     *
     * @param \JuegoPostas\AppBundle\Entity\Posta $postaSiguiente
     * @return Posta
     */
    public function setPostaSiguiente(\JuegoPostas\AppBundle\Entity\Posta $postaSiguiente = null)
    {
        $this->postaSiguiente = $postaSiguiente;

        return $this;
    }

    /**
     * Get postaSiguiente
     *
     * @return \JuegoPostas\AppBundle\Entity\Posta 
     */
    public function getPostaSiguiente()
    {
        return $this->postaSiguiente;
    }

    /**
     * Set decisionFinal
     *
     * @param \JuegoPostas\AppBundle\Entity\Decision $decisionFinal
     * @return Posta
     */
    public function setDecisionFinal(\JuegoPostas\AppBundle\Entity\Decision $decisionFinal = null)
    {
        $this->decisionFinal = $decisionFinal;

        return $this;
    }

    /**
     * Get decisionFinal
     *
     * @return \JuegoPostas\AppBundle\Entity\Decision 
     */
    public function getDecisionFinal()
    {
        return $this->decisionFinal;
    }

    /**
     * Set poi
     *
     * @param \JuegoPostas\AppBundle\Entity\Poi $poi
     * @return Posta
     */
    public function setPoi(\JuegoPostas\AppBundle\Entity\Poi $poi = null)
    {
        $this->poi = $poi;

        return $this;
    }

    /**
     * Get poi
     *
     * @return \JuegoPostas\AppBundle\Entity\Poi 
     */
    public function getPoi()
    {
        return $this->poi;
    }

    /**
     * Set subgrupo
     *
     * @param \JuegoPostas\AppBundle\Entity\Subgrupo $subgrupo
     * @return Posta
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
    
    /**
     * Metodo toString
     *
     * @return string
     */
    public function __toString()
    {
    	return 'Posta ' . $this->getNombre();
    }
	
	/*
	 * Metodo toArray
	 * 
	 * @return array
	 */
	 public function toArray($deep = true){
	 	$array = get_object_vars($this);
		if($this->postaSiguiente != null){
			$array['postaSiguiente'] = $deep ? $this->postaSiguiente->toArray(false) : $this->postaSiguiente->getId();	
		}else{
			$array['postaSiguiente'] = null;
		}
		$array['decisionfinal'] = ($this->decisionFinal =! null) ? $this->decisionFinal : null;
		$array['poi'] = $deep ? $this->poi->toArray() : $this->poi->getId();
		$array['subgrupo'] = $deep ? $this->subgrupo->toArray() : $this->subgrupo->getId();
		return $array;
	 }
}
