<?php

namespace JuegoPostas\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consulta
 *
 * @ORM\Table(name="consulta")
 * @ORM\Entity(repositoryClass="JuegoPostas\AppBundle\Repository\ConsultaRepository")
 */
class Consulta
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
     * @var \JuegoPostas\AppBundle\Entity\Decision
     *
     * @ORM\ManyToOne(targetEntity="JuegoPostas\AppBundle\Entity\Decision")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_decision_parcial", referencedColumnName="id")
     * })
     */
    private $decisionParcial;

    /**
     * @var \JuegoPostas\AppBundle\Entity\Posta
     *
     * @ORM\ManyToOne(targetEntity="JuegoPostas\AppBundle\Entity\Posta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_posta", referencedColumnName="id")
     * })
     */
    private $posta;



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
     * Set decisionParcial
     *
     * @param \JuegoPostas\AppBundle\Entity\Decision $decisionParcial
     * @return Consulta
     */
    public function setDecisionParcial(\JuegoPostas\AppBundle\Entity\Decision $decisionParcial = null)
    {
        $this->decisionParcial = $decisionParcial;

        return $this;
    }

    /**
     * Get decisionParcial
     *
     * @return \JuegoPostas\AppBundle\Entity\Decision 
     */
    public function getDecisionParcial()
    {
        return $this->decisionParcial;
    }

    /**
     * Set posta
     *
     * @param \JuegoPostas\AppBundle\Entity\Posta $posta
     * @return Consulta
     */
    public function setPosta(\JuegoPostas\AppBundle\Entity\Posta $posta = null)
    {
        $this->posta = $posta;

        return $this;
    }

    /**
     * Get posta
     *
     * @return \JuegoPostas\AppBundle\Entity\Posta 
     */
    public function getPosta()
    {
        return $this->posta;
    }
    
    /**
     * Metodo toString
     *
     * @return string
     */
    public function __toString()
    {
    	if (null !== $this->getDecisionParcial()) {
    		return $this->getDecisionParcial()->__toString();
    	} else {
    		return get_class($this) . $this->getId();
    	}
    	
    }
	
	/*
	 * Metodo toArray
	 * 
	 * @return array
	 */
	 public function toArray($deep = true){
	 	$array = get_object_vars($this);
		$array['decisionParcial'] = $this->decisionParcial->toArray(false);
		$array['posta'] = $this->posta->toArray(false);
		return $array;
	 }
}
