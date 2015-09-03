<?php

namespace JuegoPostas\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Grupo
 *
 * @ORM\Table(name="grupo")
 * @ORM\Entity
 */
class Grupo {
	/**
	 *
	 * @var integer @ORM\Column(name="id", type="integer")
	 *      @ORM\Id
	 *      @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 *
	 * @var string @ORM\Column(name="nombre", type="string", length=255, nullable=false)
	 */
	private $nombre;
	
	/**
	 *
	 * @var \JuegoPostas\AppBundle\Entity\Camino @ORM\ManyToOne(targetEntity="JuegoPostas\AppBundle\Entity\Camino")
	 *      @ORM\JoinColumns({
	 *      @ORM\JoinColumn(name="id_camino", referencedColumnName="id")
	 *      })
	 */
	private $camino;
	
	/**
	 *
	 * @var \JuegoPostas\AppBundle\Entity\Consigna @ORM\ManyToOne(targetEntity="JuegoPostas\AppBundle\Entity\Consigna")
	 *      @ORM\JoinColumns({
	 *      @ORM\JoinColumn(name="id_consigna", referencedColumnName="id")
	 *      })
	 */
	private $consigna;
	
	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Set nombre
	 *
	 * @param string $nombre        	
	 * @return Grupo
	 */
	public function setNombre($nombre) {
		$this->nombre = $nombre;
		
		return $this;
	}
	
	/**
	 * Get nombre
	 *
	 * @return string
	 */
	public function getNombre() {
		return $this->nombre;
	}
	
	/**
	 * Set camino
	 *
	 * @param \JuegoPostas\AppBundle\Entity\Camino $camino        	
	 * @return Grupo
	 */
	public function setCamino(\JuegoPostas\AppBundle\Entity\Camino $camino = null) {
		$this->camino = $camino;
		
		return $this;
	}
	
	/**
	 * Get camino
	 *
	 * @return \JuegoPostas\AppBundle\Entity\Camino
	 */
	public function getCamino() {
		return $this->camino;
	}
	
	/**
	 * Set consigna
	 *
	 * @param \JuegoPostas\AppBundle\Entity\Consigna $consigna        	
	 * @return Grupo
	 */
	public function setConsigna(\JuegoPostas\AppBundle\Entity\Consigna $consigna = null) {
		$this->consigna = $consigna;
		
		return $this;
	}
	
	/**
	 * Get consigna
	 *
	 * @return \JuegoPostas\AppBundle\Entity\Consigna
	 */
	public function getConsigna() {
		return $this->consigna;
	}
	
	/**
	 * Metodo toString
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getNombre ();
	}
	
	/*
	 * Metodo toArray
	 *
	 * @return array
	 */
	public function toArray($deep = true) {
		$array = get_object_vars ( $this );
		$array ['camino'] = $this->camino->toArray ( false );
		$array ['consigna'] = $this->consigna->toArray ( true );
		return $array;
	}
}
