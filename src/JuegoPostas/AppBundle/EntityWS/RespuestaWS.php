<?php

namespace JuegoPostas\AppBundle\EntityWS;

use BeSimple\SoapBundle\ServiceDefinition\Annotation as Soap;

class RespuestaWS {
	
	/**
	 * @Soap\ComplexType("int")
	 */
	private $id;
	
	/**
	 * @Soap\ComplexType("int")
	 */
	private $acuerdoPropuesta;
	
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
	public function __construct($id, $acuerdoPropuesta, $justificacion, $idSubgrupoConsultado) {
		$this->id = $id;
		$this->acuerdoPropuesta = $acuerdoPropuesta;
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
	 * Set acuerdoPropuesta
	 *
	 * @param int $acuerdoPropuesta        	
	 * @return RespuestaWS
	 */
	public function setAcuerdoPropuesta($acuerdoPropuesta) {
		$this->acuerdoPropuesta = $acuerdoPropuesta;
		
		return $this;
	}
	
	/**
	 * Get acuerdoPropuesta
	 *
	 * @return int
	 */
	public function getAcuerdoPropuesta() {
		return $this->acuerdoPropuesta;
	}
	
	/**
	 * Set justificacion
	 *
	 * @param string $justificacion        	
	 * @return RespuestaWS
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
	 * @return RespuestaWS
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
		return ($this->getAcuerdoPropuesta () ? 'De acuerdo: ' : 'En desacuerdo: ') . $this->getJustificacion ();
	}
}
