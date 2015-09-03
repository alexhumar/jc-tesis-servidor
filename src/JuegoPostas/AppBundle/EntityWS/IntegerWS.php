<?php

namespace JuegoPostas\AppBundle\EntityWS;

use BeSimple\SoapBundle\ServiceDefinition\Annotation as Soap;

class IntegerWS {
	
	/**
	 * @Soap\ComplexType("int")
	 */
	private $valorInteger;
	
	/**
	 * Constructor
	 */
	public function __construct($int) {
		$this->valorInteger = $int;
	}
	
	/**
	 * Get valorInteger
	 *
	 * @return int
	 */
	public function getValorInteger() {
		return $this->valorInteger;
	}
	
	/**
	 * Set valorInteger
	 *
	 * @param int $valorInteger        	
	 * @return IntegerWS
	 */
	public function setValorInteger($valorInteger) {
		$this->valorInteger = $valorInteger;
		return $this;
	}
	
	/**
	 * Metodo toString
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getValorInteger ();
	}
}
