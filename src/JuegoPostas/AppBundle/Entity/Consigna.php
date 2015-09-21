<?php

namespace JuegoPostas\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Consigna
 *
 * @ORM\Table(name="consigna")
 * @ORM\Entity
 */
class Consigna {
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
	 * @var string @ORM\Column(name="descripcion", type="text", nullable=false)
	 */
	private $descripcion;
	
	/**
	 * @ORM\OneToMany(targetEntity="JuegoPostas\AppBundle\Entity\PiezaARecolectar", mappedBy="consigna", cascade={"persist"})
	 */
	private $piezasARecolectar;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->piezasARecolectar = new ArrayCollection ();
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
	 * @return Consigna
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
	 * @return Consigna
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
	 * Add piezaARecolectar
	 *
	 * @param JuegoPostas\AppBundle\Entity\PiezaARecolectar $pieza        	
	 */
	public function addPiezasARecolectar(\JuegoPostas\AppBundle\Entity\PiezaARecolectar $pieza) {
		$pieza->setConsigna ( $this );
		
		$this->piezasARecolectar->add ( $pieza );
	}
	
	/**
	 * Remove piezaARecolectar
	 *
	 * @param \JuegoPostas\AppBundle\Entity\PiezaARecolectar $pieza        	
	 */
	public function removePiezasARecolectar(\JuegoPostas\AppBundle\Entity\PiezaARecolectar $pieza) {
		$this->piezasARecolectar->removeElement ( $pieza );
		$pieza->setConsigna ( null );
	}
	
	/**
	 * Set piezasARecolectar
	 *
	 * @return Doctrine\Common\Collections\Collection
	 */
	public function setPiezasARecolectar($piezas) {
		if (count ( $piezas ) > 0) {
			foreach ( $piezas as $p ) {
				$this->addPiezaARecolectar ( $p );
			}
		}
		
		return $this;
	}
	
	/**
	 * Get piezasARecolectar
	 *
	 * @return Doctrine\Common\Collections\Collection
	 */
	public function getPiezasARecolectar() {
		return $this->piezasARecolectar;
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
		$array ['piezasARecolectar'] = ($deep) ? array_map ( function ($p) {
			return $p->toArray ( false );
		}, $this->piezasARecolectar->toArray () ) : $this->piezasARecolectar->count ();
		return $array;
	}
}
