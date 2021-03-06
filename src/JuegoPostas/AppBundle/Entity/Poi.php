<?php

namespace JuegoPostas\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Oh\GoogleMapFormTypeBundle\Validator\Constraints as OhAssert;

/**
 * Poi
 *
 * @ORM\Table(name="poi")
 * @ORM\Entity
 */
class Poi {
	/**
	 *
	 * @var integer @ORM\Column(name="id", type="integer")
	 *      @ORM\Id
	 *      @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 *
	 * @var float @ORM\Column(name="coordenada_x", type="float", precision=18, scale=2, nullable=false)
	 */
	private $coordenadaX;
	
	/**
	 *
	 * @var float @ORM\Column(name="coordenada_y", type="float", precision=18, scale=2, nullable=false)
	 */
	private $coordenadaY;
	
	/**
	 *
	 * @var \JuegoPostas\AppBundle\Entity\PiezaARecolectar @ORM\OneToOne(targetEntity="JuegoPostas\AppBundle\Entity\PiezaARecolectar")
	 *      @ORM\JoinColumns({
	 *      @ORM\JoinColumn(name="id_pieza", referencedColumnName="id")
	 *      })
	 */
	private $piezaARecolectar;
	
	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Set coordenadaX
	 *
	 * @param float $coordenadaX        	
	 * @return Poi
	 */
	public function setCoordenadaX($coordenadaX) {
		$this->coordenadaX = $coordenadaX;
		
		return $this;
	}
	
	/**
	 * Get coordenadaX
	 *
	 * @return float
	 */
	public function getCoordenadaX() {
		return $this->coordenadaX;
	}
	
	/**
	 * Set coordenadaY
	 *
	 * @param float $coordenadaY        	
	 * @return Poi
	 */
	public function setCoordenadaY($coordenadaY) {
		$this->coordenadaY = $coordenadaY;
		
		return $this;
	}
	
	/**
	 * Get coordenadaY
	 *
	 * @return float
	 */
	public function getCoordenadaY() {
		return $this->coordenadaY;
	}
	
	/**
	 * Set piezaARecolectar
	 *
	 * @param \JuegoPostas\AppBundle\Entity\PiezaARecolectar $piezaARecolectar        	
	 * @return Poi
	 */
	public function setPiezaARecolectar(\JuegoPostas\AppBundle\Entity\PiezaARecolectar $piezaARecolectar = null) {
		$this->piezaARecolectar = $piezaARecolectar;
		
		return $this;
	}
	
	/**
	 * Get piezaARecolectar
	 *
	 * @return \JuegoPostas\AppBundle\Entity\PiezaARecolectar
	 */
	public function getPiezaARecolectar() {
		return $this->piezaARecolectar;
	}
	
	// *** CODIGO NECESARIO PARA HACER ANDAR EL BUNDLE DE GOOGLE MAPS
	public function setLatLng($latlng) {
		$this->setCoordenadaY ( $latlng ['lat'] );
		$this->setCoordenadaX ( $latlng ['lng'] );
		return $this;
	}
	
	/**
	 * @Assert\NotBlank()
	 * @OhAssert\LatLng()
	 */
	public function getLatLng() {
		return array (
				'lat' => $this->getCoordenadaY (),
				'lng' => $this->getCoordenadaX () 
		);
	}
	
	/**
	 * Metodo toString
	 *
	 * @return string
	 */
	public function __toString() {
		return 'CoordX: ' . strval ( $this->getCoordenadaX () ) . ' CoordY: ' . strval ( $this->getCoordenadaY () );
	}
	
	/*
	 * Metodo toArray
	 *
	 * @return array
	 */
	public function toArray($deep = true) {
		$array = get_object_vars ( $this );
		$array ['piezaARecolectar'] = $this->piezaARecolectar->toArray ();
		return $array;
	}
}
