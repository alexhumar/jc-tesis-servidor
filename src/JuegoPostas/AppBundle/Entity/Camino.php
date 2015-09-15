<?php

namespace JuegoPostas\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Camino
 *
 * @ORM\Table(name="camino")
 * @ORM\Entity
 */
class Camino {
	/**
	 *
	 * @var integer @ORM\Column(name="id", type="integer")
	 *      @ORM\Id
	 *      @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 *
	 * @var string @ORM\Column(name="descripcion", type="text", nullable=false)
	 */
	private $descripcion;
	
	/**
	 *
	 * @var \JuegoPostas\AppBundle\Entity\Posta @ORM\ManyToOne(targetEntity="JuegoPostas\AppBundle\Entity\Posta", cascade={"persist", "remove"})
	 *      @ORM\JoinColumns({
	 *      @ORM\JoinColumn(name="id_primer_posta", referencedColumnName="id", onDelete="CASCADE")
	 *      })
	 */
	private $primerPosta;
	
	/**
	 * @var \JuegoPostas\AppBundle\Entity\Grupo @ORM\OneToOne(targetEntity="JuegoPostas\AppBundle\Entity\Grupo", mappedBy="camino")
	 **/
	private $grupo;
	
	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Set descripcion
	 *
	 * @param string $descripcion        	
	 * @return Camino
	 */
	public function setDescripcion($descripcion) {
		$this->descripcion = $descripcion;
		
		return $this;
	}
	
	/**
	 * Get descripcion
	 *
	 * @return string
	 */
	public function getDescripcion() {
		return $this->descripcion;
	}
	
	/**
	 * Set primerPosta
	 *
	 * @param \JuegoPostas\AppBundle\Entity\Posta $primerPosta        	
	 * @return Camino
	 */
	public function setPrimerPosta(\JuegoPostas\AppBundle\Entity\Posta $primerPosta = null) {
		$this->primerPosta = $primerPosta;
		
		return $this;
	}
	
	/**
	 * Get primerPosta
	 *
	 * @return \JuegoPostas\AppBundle\Entity\Posta
	 */
	public function getPrimerPosta() {
		return $this->primerPosta;
	}
	
	/**
	 * Set grupo
	 *
	 * @param \JuegoPostas\AppBundle\Entity\Grupo $grupo
	 * @return Camino
	 */
	public function setGrupo(\JuegoPostas\AppBundle\Entity\Grupo $grupo = null)
	{
		$this->grupo = $grupo;
		$grupo->setCamino($this);
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
	 * Metodo toString
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getDescripcion ();
	}
	
	public function isNew(){
		return ($this->getId() == null);
	}
	
	/*
	 * Metodo toArray
	 *
	 * @return array
	 */
	public function toArray($deep = true) {
		$array = get_object_vars ( $this );
		$array ['primerPosta'] = $this->primerPosta->toArray ( $deep );
		return $array;
	}
}
