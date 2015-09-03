<?php

namespace JuegoPostas\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estrategia
 *
 * @ORM\Table(name="estrategia")
 * @ORM\Entity
 */
class Estrategia {
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
	 * @var string @ORM\Column(name="descripcion", type="string", length=255, nullable=false)
	 */
	private $descripcion;
	
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
	 * @return Estrategia
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
	 * Set descripcion
	 *
	 * @param string $descripcion        	
	 * @return Estrategia
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
	 * Metodo toString
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getNombre () . ' - ' . $this->getDescripcion ();
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
