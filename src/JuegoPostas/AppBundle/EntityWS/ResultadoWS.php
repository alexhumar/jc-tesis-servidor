<?php

namespace JuegoPostas\AppBundle\EntityWS;

use BeSimple\SoapBundle\ServiceDefinition\Annotation as Soap;

class ResultadoWS {
	
	/**
	 * @Soap\ComplexType("int")
	 */
	private $idGrupo;
	
	/**
	 * @Soap\ComplexType("string")
	 */
	private $nombreGrupo;
	
	/**
	 * @Soap\ComplexType("int")
	 */
	private $idSubgrupo;
	
	/**
	 * @Soap\ComplexType("string")
	 */
	private $nombrePieza;
	
	/**
	 * @Soap\ComplexType("boolean")
	 */
	private $decisionFinalCumple;
	
	/**
	 * @Soap\ComplexType("int")
	 */
	private $decisionCorrecta;
	
	/**
	 * Constructor
	 */
	public function __construct($idGrupo, $nombreGrupo, $idSubgrupo, $nombrePieza, $decisionFinalCumple, $decisionCorrecta) {
		$this->idGrupo = $idGrupo;
		$this->nombreGrupo = $nombreGrupo;
		$this->idSubgrupo = $idSubgrupo;
		$this->nombrePieza = $nombrePieza;
		$this->decisionFinalCumple = $decisionFinalCumple;
		$this->decisionCorrecta = $decisionCorrecta;
	}
	
	/**
	 * Set idGrupo
	 *
	 * @param integer $idGrupo        	
	 * @return ResultadoWS
	 */
	public function setIdGrupo($idGrupo) {
		$this->idGrupo = $idGrupo;
		
		return $this;
	}
	
	/**
	 * Get idGrupo
	 *
	 * @return integer
	 */
	public function getIdGrupo() {
		return $this->idGrupo;
	}
	
	/**
	 * Set nombreGrupo
	 *
	 * @param string $nombreGrupo        	
	 * @return ResultadoWS
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
	 * Set idSubgrupo
	 *
	 * @param integer $idSubgrupo        	
	 * @return ResultadoWS
	 */
	public function setIdSubgrupo($idSubgrupo) {
		$this->idSubgrupo = $idSubgrupo;
		
		return $this;
	}
	
	/**
	 * Get idSubgrupo
	 *
	 * @return integer
	 */
	public function getIdSubgrupo() {
		return $this->idSubgrupo;
	}
	
	/**
	 * Set nombrePieza
	 *
	 * @param string $nombrePieza        	
	 * @return ResultadoWS
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
	 * Set decisionFinalCumple
	 *
	 * @param boolean $decisionFinalCumple        	
	 * @return ResultadoWS
	 */
	public function setDecisionFinalCumple($decisionFinalCumple) {
		$this->decisionFinalCumple = $decisionFinalCumple;
		
		return $this;
	}
	
	/**
	 * Get decisionFinalCumple
	 *
	 * @return boolean
	 */
	public function getDecisionFinalCumple() {
		return $this->decisionFinalCumple;
	}
	
	/**
	 * Set decisionCorrecta
	 *
	 * @param integer $decisionCorrecta        	
	 * @return ResultadoWS
	 */
	public function setDecisionCorrecta($decisionCorrecta) {
		$this->decisionCorrecta = $decisionCorrecta;
		
		return $this;
	}
	
	/**
	 * Get decisionCorrecta
	 *
	 * @return integer
	 */
	public function getDecisionCorrecta() {
		return $this->decisionCorrecta;
	}
	
	/**
	 * Metodo toString
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getIdSubgrupo () . ' - ' . $this->getDecisionCorrecta ();
	}
}
