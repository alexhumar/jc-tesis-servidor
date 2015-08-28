<?php
namespace JuegoPostas\AppBundle\Services;

use JuegoPostas\AppBundle\Services\ReposManager;
use JuegoPostas\AppBundle\EntityWS\SubgrupoWS;
use JuegoPostas\AppBundle\EntityWS\PoiWS;
use JuegoPostas\AppBundle\EntityWS\IntegerWS;

use BeSimple\SoapBundle\ServiceDefinition\Annotation as Soap;
use Symfony\Component\DependencyInjection\ContainerAware;

class JuCoServices extends ContainerAware{
	
	private function getReposManager()
	{
		return $this->container->get("repos_manager");
	}
	
	private function getSubgrupoRepo() {
		return $this->getReposManager()->getSubgrupoRepo();
	}
	
	private function getPostaRepo() {
		return $this->getReposManager()->getPostaRepo();
	}
	
	private function getEstadoSubgrupoRepo() {
		return $this->getReposManager()->getEstadoSubgrupoRepo();
	}
	
	private function getConsultaRepo() {
		return $this->getReposManager()->getConsultaRepo();
	}
	
	/**
	 * Metodo de logueo al sistema cliente mediante el nombre de subgrupo.
	 * @param string $nombreSubgrupo
	 * @return integer
	 * @Soap\Method("login")
     * @Soap\Param("nombreSubgrupo", phpType = "string")
     * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\IntegerWS")
	 */
	public function login($nombreSubgrupo) {
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->findOneByNombre($nombreSubgrupo);
		(null !== $subgrupo) ? $estado = $subgrupo->getId() : $estado = -1;
		return new IntegerWS($estado);
	}
	
	/**
	 * Retorna el punto inicial del subgrupo que se recibe como parametro.
	 * @param integer $idSubgrupo
	 * @return object
	 */
	public function getPuntoInicial($idSubgrupo) {
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->find($idSubgrupo);
		/*$poiWS = new PoiWS(-1, -1, -1);
		if (null !== $subgrupo) {
			$posta = $this->getPostaRepo()->getPostaDeSubgrupo($subgrupo);
			if (null !== $posta) {
				$poi = $posta->getPoi();
				if (null !== $poi) {
					$poiWS = new PoiWS($poi->getId(), $poi->getCoordenadaX(), $poi->getCoordenadaY());
				}
			}
		}*/
		try {
			$posta = $this->getPostaRepo()->getPostaDeSubgrupo($subgrupo);
			$poi = $posta->getPoi();
			$poiWS = new PoiWS($poi->getId(), $poi->getCoordenadaX(), $poi->getCoordenadaY());
		} catch(\Exception $e) {
			die("hola");$poiWS = new PoiWS(-1, -1, -1);
		}
		
		return $poiWS;
	}
	
	/**
	 * Retorna la pieza a recolectar asociada al subgrupo que se recibe como parametro.
	 * @param integer $idSubgrupo
	 * @return object
	 */
	public function getPieza($idSubgrupo) {
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->find($idSubgrupo);
		//if (null !== $subgrupo) {
		if ($subgrupo) {
			$posta = $this->getPostaRepo()->getPostaDeSubgrupo($subgrupo);
			if ($posta) {
				$poi = $posta->getPoi();
				if ($poi) {
					$pieza = $poi->getPiezaARecolectar();
					$piezaWS = new PiezaWS($pieza->getId(), $pieza->getNombre(), $pieza->getDescripcion(), new PoiWS($poi->getId(),$poi->getCoordenadaX(),$poi->getCoordenadaY()));
				}
			}
		}
			
		return $piezaWS;
	}
	
	/**
	 * Cambia el estado del subgrupo que se recibe como parametro y retorna la consigna asociada.
	 * @param integer $idSubgrupo
	 * @param integer $idEstado
	 * @return object
	 */
	public function cambiarEstadoSubgrupo($idSubgrupo, $idEstado) {
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->find($idSubgrupo);
		//Constructor que recibe: $id, $nombre, $descripcion, $nombreGrupo
		$consignaWS = new ConsignaWS(-1,"","","");
		if ($subgrupo) {
			$estadoSubgrupo = $this->getEstadoSubgrupoRepo()->find($idEstado);
			if ($estadoSubgrupo) {
				$subgrupo->setEstado($estadoSubgrupo);
				$this->getReposManager()->getEntityManager()->flush(); //Habria que revisar a ver si esto funciona.
				//Tanto el grupo como la consigna deberian estar seteadas. La comprobacion por null de cada cosa no corresponderia.
				$grupo = $subgrupo->getGrupo();
				$consigna = $grupo->getConsigna();
				$consignaWS = new ConsignaWS($consigna->getId(), $consigna->getNombre(), $consigna->getDescripcion(), $grupo->getNombre());
			}
		}
	
		return $consignaWS;
	}
	
	/**
	 * Crea la decision final para la posta del subgrupo o la consulta asociada a la posta segun el contenido de $decisionFinal. Retorna idSubgrupo si todo salio bien, -1 caso contrario.
	 * @param integer $idSubgrupo
	 * @param integer $cumple
	 * @param string $justificacion
	 * @param integer $decisionFinal
	 * @return integer
	 */
	public function tomarDecision($idSubgrupo, $cumple, $justificacion, $decisionFinal) {
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->find($idSubgrupo);
		$resultado = -1;
			
		if ($subgrupo) {
			$posta = $this->getPostaRepo()->getPostaDeSubgrupo($subgrupo);
			if ($posta) {
				$esDecisionFinal = ($decisionFinal == 1);
				$cumpleConsigna = ($cumple == 1);
					
				$decision = new Decision();
				$decision->setJustificacion($justificacion);
				$decision->setCumpleConsigna($cumpleConsigna);
				$em = $this->getReposManager()->getEntityManager();
				$em->persist($decision);
				//$em->flush();
					
				if ($esDecisionFinal) {
					$posta->setDecisionFinal($decision);
				} else {
					$consulta = new Consulta();
					$consulta->setPosta($posta);
					$consulta->setDecisionParcial($decision);
					$em->persist($consulta);
					//$em->flush();
				}
				$em->flush();
				$resultado = $idSubgrupo;
			}
		}
			
		return $resultado;
	}
	
	/**
	 * Retorna 1 si la posta asociada al subgrupo tiene seteada la decision final. 0 caso contrario.
	 * @param integer $idSubgrupo
	 * @return integer
	 */
	public function finJuegoSubgrupo($idSubgrupo) {
		//Alex - Estaria faltando chequear que el subgrupo haya activado al subgrupo siguiente, en caso que no sea el ultimo del camino.
		$subgrupoRepo = $this->getReposManager()->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->find($idSubgrupo);
		$resultado = 0;
		if($subgrupo) {
			$posta = $this->getPostaRepo()->getPostaDeSubgrupo($subgrupo);
			if($posta) {
				//Si esta seteada la decision final...
				if (null !== $posta->getDecisionFinal()) $resultado = 1;
			}
		}
			
		return $resultado;
	}
	
	/**
	 * Retorna 1 si todos los subgrupos llegaron al estado pasado como parametro. 0 caso contrario.
	 * @param integer $idEstado
	 * @return integer
	 */
	public function esperarEstadoSubgrupos($idEstado) {
		//No le veo mucho sentido todavia a esto pero lo dejo por las dudas.
		$estadoSubgrupoRepo = $this->getReposManager()->getEstadoSubgrupoRepo();
		$subgrupoRepo = $this->getReposManager()->getSubgrupoRepo();
		$estadoSubgrupo = $estadoSubgrupoRepo->find($idEstado);
		$resultado = 1;
		//Deberia implementarse, retornando un solo objeto (similar al getPostaDeSubgrupo).
		//Si la consulta devuelve uno, quiere decir que al menos un subgrupo no está en el estado pasado como parametro.
		$subgrupo = $subgrupoRepo->subgrupoEnEstadoDistintoDe($estadoSubgrupo);
		if ($subgrupo) $resultado = 0;
			
		return resultado;
	}
	
	/**
	 * Retorna una sola consulta sin responder que no sea del subgrupo pasado como parametro.
	 * @param integer $idSubgrupo
	 * @return object
	 */
	public function existePreguntaSinResponder($idSubgrupo) {
		$subgrupoRepo = $this->getReposManager()->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->find($idSubgrupo);
		$pregunta = new PreguntaWS();
		$pregunta->setIdSubgrupoConsultado(-1);
		if($subgrupo) {
			$consultaRepo = $this->getReposManager()->getConsultaRepo();
			$consulta = $consultaRepo->consultaSinRespuestaDeSubgrupoDistintoA($subgrupo);
			if($consulta) {
				$pieza = $consulta->getPosta()->getPoi()->getPiezaARecolectar(); //Ninguno de estos objetos deberian ser null en este punto.
				$decisionParcial = $consulta->getDecisionParcial();
				$pregunta->setNombrePieza($pieza->getNombre());
				$pregunta->setDescripcionPieza($pieza->getDescripcion());
				$pregunta->setCumple($decisionParcial->getCumpleConsigna());
				$pregunta->setJustificacion($decisionParcial->getJustificacion());
				$pregunta->setIdSubgrupoConsultado($idSubgrupo); //Esto todavia no lo tengo super claro. A que subgrupo se refiere??
			}
		}
			
		return $pregunta;
	}
	
	/**
	 * Retorna los subgrupos del grupo al que pertenece el subgrupo que se recibe como parametro
	 * @param integer $idSubgrupo
	 * @return array
	 */
	public function getSubgrupos($idSubgrupo) {
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->find($idSubgrupo);
		$subgruposWS = array();
		if (null !== $subgrupo) {
			$subgrupos = $subgrupoRepo->getSubgruposDeGrupo($subgrupo->getGrupo());
			foreach ($subgrupos as $s) {
				$subgruposWS[] = new SubgrupoWS($s->getId(), $s->getNombre());
			}
		}
		
		return $subgruposWS;
	}
	
	/**
	 * Servicio de prueba - Retorna un string fijo de prueba
	 * @param integer $idSubgrupo
	 * @return string
	 */
	public function getString($idSubgrupo) {
		
		return 'String fijo de prueba';
	}
	
}