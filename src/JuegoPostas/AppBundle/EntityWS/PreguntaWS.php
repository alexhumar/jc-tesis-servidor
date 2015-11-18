<?php

namespace JuegoPostas\AppBundle\EntityWS;

use BeSimple\SoapBundle\ServiceDefinition\Annotation as Soap;

class PreguntaWS {
	
	/**
	 * @Soap\ComplexType("int")
	 */
	private $id;
	
	/**
	 * @Soap\ComplexType("string")
	 */
	private $nombrePieza;
	
	/**
	 * @Soap\ComplexType("string")
	 */
	private $descripcionPieza;
	
	/**
	 * @Soap\ComplexType("int")
	 */
	private $cumple;
	
	/**
	 * @Soap\ComplexType("string")
	 */
	private $justificacion;
	
	/**
	 * @Soap\ComplexType("int")
	 */
	private $idSubgrupoConsultado;
	
	/**
	 * Constructor
	 */
	public function __construct($id, $nombrePieza, $descripcionPieza, $cumple, $justificacion, $idSubgrupoConsultado) {
		$this->id = $id;
		$this->nombrePieza = $nombrePieza;
		$this->descripcionPieza = $descripcionPieza;
		$this->cumple = $cumple;
		$this->justificacion = $justificacion;
		$this->idSubgrupoConsultado = $idSubgrupoConsultado;
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
	 * Set nombrePieza
	 *
	 * @param string $nombrePieza        	
	 * @return PreguntaWS
	 */
	public function setNombrePieza($nombrePieza) {
		$this->nombrePieza = $nombrePieza;
		
		return $this;
	}
	
	/**
	 * Get nombrePieza
	 *
	 * @return string
	 */
	public function getNombrePieza() {
		return $this->nombrePieza;
	}
	
	/**
	 * Set descripcionPieza
	 *
	 * @param string $descripcionPieza        	
	 * @return PreguntaWS
	 */
	public function setDescripcionPieza($descripcionPieza) {
		$this->descripcionPieza = $descripcionPieza;
		
		return $this;
	}
	
	/**
	 * Get descripcionPieza
	 *
	 * @return string
	 */
	public function getDescripcionPieza() {
		return $this->descripcionPieza;
	}
	
	/**
	 * Set cumple
	 *
	 * @param int $cumple        	
	 * @return PreguntaWS
	 */
	public function setCumple($cumple) {
		$this->cumple = $cumple;
		
		return $this;
	}
	
	/**
	 * Get cumple
	 *
	 * @return int
	 */
	public function getCumple() {
		return $this->cumple;
	}
	
	/**
	 * Set justificacion
	 *
	 * @param string $justificacion        	
	 * @return PreguntaWS
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
	 * Set idSubgrupoConsultado
	 *
	 * @param integer $idSubgrupoConsultado        	
	 * @return PreguntaWS
	 */
	public function setIdSubgrupoConsultado($idSubgrupoConsultado) {
		$this->idSubgrupoConsultado = $idSubgrupoConsultado;
		
		return $this;
	}
	
	/**
	 * Get idSubgrupoConsultado
	 *
	 * @return integer
	 */
	public function getIdSubgrupoConsultado() {
		return $this->idSubgrupoConsultado;
	}
	
	/**
	 * Metodo toString
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getNombrePieza () . ' - ' . $this->getDescripcionPieza ();
	}
}
