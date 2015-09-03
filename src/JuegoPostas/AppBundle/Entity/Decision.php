<?php

namespace JuegoPostas\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Decision
 *
 * @ORM\Table(name="decision")
 * @ORM\Entity
 */
class Decision {
	/**
	 *
	 * @var integer @ORM\Column(name="id", type="integer")
	 *      @ORM\Id
	 *      @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 *
	 * @var string @ORM\Column(name="justificacion", type="string", length=150, nullable=false)
	 */
	private $justificacion;
	
	/**
	 *
	 * @var boolean @ORM\Column(name="cumple_consigna", type="boolean", nullable=false)
	 */
	private $cumpleConsigna;
	
	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Set justificacion
	 *
	 * @param string $justificacion        	
	 * @return Decision
	 */
	public function setJustificacion($justificacion) {
		$this->justificacion = $justificacion;
		
		return $this;
	}
	
	/**
	 * Get justificacion
	 *
	 * @return string
	 */
	public function getJustificacion() {
		return $this->justificacion;
	}
	
	/**
	 * Set cumpleConsigna
	 *
	 * @param boolean $cumpleConsigna        	
	 * @return Decision
	 */
	public function setCumpleConsigna($cumpleConsigna) {
		$this->cumpleConsigna = $cumpleConsigna;
		
		return $this;
	}
	
	/**
	 * Get cumpleConsigna
	 *
	 * @return boolean
	 */
	public function getCumpleConsigna() {
		return $this->cumpleConsigna;
	}
	
	/**
	 * Metodo toString
	 *
	 * @return string
	 */
	public function __toString() {
		return ($this->getCumpleConsigna () ? 'Cumple: ' : 'No cumple: ') . $this->getJustificacion ();
	}
	
	/*
	 * Metodo toArray
	 *
	 * @return array
	 */
	public function toArray($deep = true) {
		$array = get_object_vars ( $this );
		return $array;
	}
}
