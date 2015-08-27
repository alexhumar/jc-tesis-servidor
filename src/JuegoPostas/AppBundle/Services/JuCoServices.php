<?php
namespace JuegoPostas\AppBundle\Services;

use JuegoPostas\AppBundle\Services\ReposManager;
use JuegoPostas\AppBundle\EntityWS\SubgrupoWS;
use JuegoPostas\AppBundle\EntityWS\PoiWS;

class JuCoServices {
	
	protected $reposManager;
	
	public function __construct(ReposManager $reposManager)
	{
		$this->reposManager = $reposManager;
	}
	
	private function getReposManager()
	{
		return $this->reposManager;
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
	
	private function getRespuestaRepo() {
		return $this->getReposManager()->getRespuestaRepo();
	}
	
	/**
	 * Metodo de logueo al sistema cliente mediante el nombre de subgrupo.
	 * @param string $nombreSubgrupo
	 * @return integer
	 */
	public function login($nombreSubgrupo) {
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->findOneByNombre($nombreSubgrupo);
		(null !== $subgrupo) ? $estado = $subgrupo->getId() : $estado = -1;
		
		return $estado;
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
			die;$poiWS = new PoiWS(-1, -1, -1);
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
				$pregunta->setId($consulta->getId()); //Alex - MODIFICACION necesaria para que desde android se le pase el idConsulta al guardarRespuesta
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
	 * Retorna las respuestas a la consulta que hizo el subgrupo que se recibe como parametro
	 * @param integer $idSubgrupo
	 * @return array
	 */
	public function existenRespuestas($idsubgrupo) {
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->find($idSubgrupo);
		$respuestas = array();
		if($subgrupo) {
			$consultaRealizada = $this->getConsultaRepo()->consultaDeSubgrupo($subgrupo);
			if($consultaRealizada) { //puede venir null si no realizo consultas alguna. Este chequeo esta bien dejarlo.
				$respuestas = $this->getRespuestaRepo()->respuestasAConsulta($consultaRealizada);
				foreach ($respuestas as $respuesta) {
					$respuestas[] = new RespuestaWS($respuesta->getAcuerdoPropuesta(),
							$respuesta->getJustificacion(),
							$respuesta->getSubgrupoConsultado()->getId());
				}
			}
		}
			
		return $respuestas;
	}
	
	/**
	 * Guarda la respuesta a una consulta con los datos que se reciben como parametro
	 * @param integer $idConsulta
	 * @param integer $idSubgrupoConsultado
	 * @param integer $acuerdo
	 * @param string $justificacion
	 * @return integer
	 */
	public function guardarRespuesta($idConsulta, $idSubgrupoConsultado, $acuerdo, $justificacion) {
		//Pasarle el $idConsulta es algo que tenemos que agregar en Android.
		$consultaRespo = $this->getConsultaRepo();
		$consulta = $consultaRepo->find($idConsulta);
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupoConsultado = $subgrupoRepo->find($idSubgrupoConsultado);
		$resultado = 0;
		if ($consulta and $subgrupoConsultado) { //Solo si encontro ambos puedo generar la respuesta. Este chequeo dejarlo.
			$acuerdoConPropuesta = ($acuerdo == 1);
			$respuesta = new Respuesta();
			$respuesta->setAcuerdoPropuesta($acuerdoConPropuesta);
			$respuesta->setJustificacion($justificacion);
			$respuesta->setConsulta($consulta);
			$respuesta->setSubgrupoConsultado($subgrupoConsultado);
			$em = $this->getReposManager()->getEntityManager();
			$em->persist($respuesta);
			$em->flush();
			$resultado = 1;
		}
			
		return $resultado;
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
	 * Retorna los resultados de cada subgrupo del juego respecto a su decision sobre la pieza asociada
	 * @param integer $idSubgrupo
	 * @return array
	 */
	public function getResultadoFinal($idSubgrupo) { //Alex - chequear si eliminar o dejar el parametro
		//REVISARLO TRANQUILO
		$grupoRepo = $this->getGrupoRepo();
		$subgrupoRepo = $this->getSubgrupoRepo();
		$grupos = $grupoRepo->findAll();
		$resultados = array();
		foreach ($grupos as $grupo) {
			$subgrupos = $subgrupoRepo->getSubgruposDeGrupo($grupo);
			foreach ($subgrupos as $subgrupo) {
				$posta = $this->getPostaRepo()->getPostaDeSubgrupo($subgrupo);
				if($posta) {
					$pieza = $posta->getPoi()->getPiezaARecolectar();
					$decisionFinal = $posta->getDecisionFinal();
					$decisionCorrecta = ($decisionFinal->getCumpleConsigna() == $pieza->getCumpleConsigna()) ? 1 : 0;
					$resultado = new ResultadoWS($grupo->getId(),
							$grupo->getNombre(),
							$subgrupo->getId(),
							$pieza->getNombre(),
							$decisionFinal->getCumpleConsigna(),
							$decisionCorrecta); //Indica si lo que respondio el subgrupo esta bien (1) o mal (0)
							$resultados[] = $resultado;
				}
			}
		}
			
		return $resultados;
	}
}