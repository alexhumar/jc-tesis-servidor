<?php

namespace JuegoPostas\AppBundle\EntityWS;

use BeSimple\SoapBundle\ServiceDefinition\Annotation as Soap;

class ConsignaWS {
	
	/**
	 * @Soap\ComplexType("int")
	 */
	private $id;
	
	/**
	 * @Soap\ComplexType("string")
	 */
	private $nombre;
	
	/**
	 * @Soap\ComplexType("string")
	 */
	private $descripcion;
	
	/**
	 * @Soap\ComplexType("string")
	 */
	private $nombreGrupo;
	
	/**
	 * Constructor
	 */
	public function __construct($id, $nombre, $descripcion, $nombreGrupo) {
		$this->id = $id;
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
		$this->nombreGrupo = $nombreGrupo;
	}
	
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
	 * @return ConsignaWS
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
	 * @return ConsignaWS
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
	 * Set nombreGrupo
	 *
	 * @param string $nombreGrupo        	
	 * @return ConsignaWS
	 */
	public function setNombreGrupo($nombreGrupo) {
		$this->nombreGrupo = $nombreGrupo;
		
		return $this;
	}
	
	/**
	 * Get nombreGrupo
	 *
	 * @return string
	 */
	public function getNombreGrupo() {
		return $this->nombreGrupo;
	}
	
	/**
	 * Metodo toString
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getDescripcion ();
	}
}
