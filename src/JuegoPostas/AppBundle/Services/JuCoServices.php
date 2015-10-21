<?php
namespace JuegoPostas\AppBundle\Services;

use JuegoPostas\AppBundle\EntityWS\SubgrupoWS;
use JuegoPostas\AppBundle\EntityWS\PoiWS;
use JuegoPostas\AppBundle\EntityWS\IntegerWS;
use JuegoPostas\AppBundle\EntityWS\PiezaWS;
use JuegoPostas\AppBundle\EntityWS\ConsignaWS;
use JuegoPostas\AppBundle\EntityWS\PreguntaWS;
use JuegoPostas\AppBundle\EntityWS\RespuestaWS;
use JuegoPostas\AppBundle\EntityWS\ResultadoWS;

use JuegoPostas\AppBundle\Entity\Decision;
use JuegoPostas\AppBundle\Entity\Consulta;
use JuegoPostas\AppBundle\Entity\Respuesta;

use BeSimple\SoapBundle\ServiceDefinition\Annotation as Soap;
use Symfony\Component\DependencyInjection\ContainerAware;

class JuCoServices extends ContainerAware {
	
	//private $reposManager;
	
	private function getReposManager()
	{
		return $this->container->get('repos_manager');
		//return $this->reposManager;
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
	
	private function getGrupoRepo() {
		return $this->getReposManager()->getGrupoRepo();
	}
	
	/*public function __construct($reposManager) {
		$this->reposManager = $reposManager;
	}*/
	
	/**
	 * Metodo de logueo al sistema cliente mediante el nombre de subgrupo.
	 * @Soap\Method("login")
     * @Soap\Param("nombreSubgrupo", phpType = "string")
     * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\IntegerWS")
	 */
	public function login($nombreSubgrupo) {
		//Probado
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->findOneByNombre($nombreSubgrupo);
		$subgrupo ? $estado = $subgrupo->getId() : $estado = -1;
		
		return new IntegerWS($estado);
	}
	
	/**
	 * Retorna el punto inicial y el punto siguiente del subgrupo que se recibe como parametro.
	 * @Soap\Method("getPuntoInicial")
	 * @Soap\Param("idSubgrupo", phpType = "int")
	 * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\PoiWS[]")
	 */
	public function getPuntoInicial($idSubgrupo) {
		//Probado
		$idxPostaSubgrupo = 0;
		$idxPostaSiguiente = 1;
		
		$subgrupoRepo = $this->getSubgrupoRepo();
		//Aca se va a guardar el POI inicial del subgrupo
		$poisWS[$idxPostaSubgrupo] = new PoiWS(-1, -1, -1);
		//Aca se va a guardar el POI siguiente del subgrupo
		$poisWS[$idxPostaSiguiente] = new PoiWS(-1, -1, -1);
		if ($subgrupo = $subgrupoRepo->find($idSubgrupo)) {
			if ($posta = $this->getPostaRepo()->getPostaDeSubgrupo($subgrupo)) {
				if ($poi = $posta->getPoi()) {
					$poisWS[$idxPostaSubgrupo] = new PoiWS($poi->getId(), $poi->getCoordenadaX(), $poi->getCoordenadaY());
					if ($postaSiguiente = $posta->getPostaSiguiente()) {
						if ($poi = $postaSiguiente->getPoi()) {
							$poisWS[$idxPostaSiguiente] = new PoiWS($poi->getId(), $poi->getCoordenadaX(), $poi->getCoordenadaY());
						}
					}
				}
			}
		}
		
		return $poisWS;
	}
	
	/**
	 * Retorna la pieza a recolectar asociada al subgrupo que se recibe como parametro.
	 * @Soap\Method("getPieza")
	 * @Soap\Param("idSubgrupo", phpType = "int")
	 * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\PiezaWS")
	 */
	public function getPieza($idSubgrupo) {
		//Probado
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->find($idSubgrupo);
		$piezaWS = new PiezaWS(-1, "", "", new PoiWS(-1, -1, -1));
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
	 * @Soap\Method("cambiarEstadoSubgrupo")
	 * @Soap\Param("idSubgrupo", phpType = "int")
	 * @Soap\Param("idEstado", phpType = "int")
	 * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\ConsignaWS")
	 */
	public function cambiarEstadoSubgrupo($idSubgrupo, $idEstado) {
		//Probado
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->find($idSubgrupo);
		$consignaWS = new ConsignaWS(-1,"","","");
		if ($subgrupo) {
			$estadoSubgrupo = $this->getEstadoSubgrupoRepo()->find($idEstado);
			if ($estadoSubgrupo) {
				$subgrupo->setEstado($estadoSubgrupo);
				$this->getReposManager()->getEntityManager()->flush();
				//Tanto el grupo como la consigna deberian estar seteados. La comprobacion por null de cada uno no corresponderia.
				$grupo = $subgrupo->getGrupo();
				$consigna = $grupo->getConsigna();
				$consignaWS = new ConsignaWS($consigna->getId(), $consigna->getNombre(), $consigna->getDescripcion(), $grupo->getNombre());
			}
		}
	
		return $consignaWS;
	}
	
	/**
	 * Crea la decision final para la posta del subgrupo o la consulta asociada a la posta segun el contenido de $decisionFinal. Retorna idSubgrupo si todo salio bien, -1 caso contrario.
	 * @Soap\Method("tomarDecision")
	 * @Soap\Param("idSubgrupo", phpType = "int")
	 * @Soap\Param("cumple", phpType = "int")
	 * @Soap\Param("justificacion", phpType = "string")
	 * @Soap\Param("decisionFinal", phpType = "int")
	 * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\IntegerWS")
	 */
	public function tomarDecision($idSubgrupo, $cumple, $justificacion, $decisionFinal) {
		//Probado
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
					
				if ($esDecisionFinal) {
					if (!$posta->getDecisionFinal()) { //Si no se seteo la decision final previamente.
						$posta->setDecisionFinal($decision);
						$em->flush();
					}
				} else {
					$consulta = new Consulta();
					$consulta->setPosta($posta);
					$consulta->setDecisionParcial($decision);
					$em->persist($consulta);
					$em->flush();
				}
				
				$resultado = $idSubgrupo;
			}
		}
			
		return new IntegerWS($resultado);
	}
	
	/**
	 * Retorna 1 si la posta asociada al subgrupo tiene seteada la decision final. 0 caso contrario.
	 * @Soap\Method("finJuegoSubgrupo")
	 * @Soap\Param("idSubgrupo", phpType = "int")
	 * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\IntegerWS")
	 */
	public function finJuegoSubgrupo($idSubgrupo) {
		//Alex - Estaria faltando chequear que el subgrupo haya activado al subgrupo siguiente, en caso que no sea el ultimo del camino.
		//Podria, en caso que no sea el ultimo del camino (tenga posta siguiente), chequear que el subgrupo de esa posta este jugando. Quiere decir que lo activo.
		//Habria que ver si ese razonamiento sirve.
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->find($idSubgrupo);
		$resultado = 0;
		if($subgrupo) {
			$posta = $this->getPostaRepo()->getPostaDeSubgrupo($subgrupo);
			if($posta) {
				//Si esta seteada la decision final.
				if ($posta->getDecisionFinal()) $resultado = 1;
			}
		}
			
		return new IntegerWS($resultado);
	}
	
	/**
	 * Retorna 1 si todos los subgrupos llegaron al estado pasado como parametro. 0 caso contrario.
	 * @Soap\Method("esperarEstadoSubgrupos")
	 * @Soap\Param("idEstado", phpType = "int")
	 * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\IntegerWS")
	 */
	public function esperarEstadoSubgrupos($idEstado) {
		//Probado
		$estadoSubgrupoRepo = $this->getEstadoSubgrupoRepo();
		$subgrupoRepo = $this->getSubgrupoRepo();
		$estadoSubgrupo = $estadoSubgrupoRepo->find($idEstado);
		$resultado = -1;
		if ($estadoSubgrupo) {
			//Si $subgrupo no es null, quiere decir que al menos un subgrupo no está en el estado pasado como parametro.
			$subgrupo = $subgrupoRepo->subgrupoEnEstadoDistintoDe($estadoSubgrupo);
			$subgrupo ? $resultado = 0 : $resultado = 1;
		}
			
		return new IntegerWS($resultado);
	}
	
	/**
	 * Retorna una sola consulta sin responder que no sea del subgrupo pasado como parametro, pero que esta en su mismo grupo.
	 * @Soap\Method("existePreguntaSinResponder")
	 * @Soap\Param("idSubgrupo", phpType = "int")
	 * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\PreguntaWS")
	 */
	public function existePreguntaSinResponder($idSubgrupo) {
		//Probado
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->find($idSubgrupo);
		$pregunta = new PreguntaWS(-1, "","", false, "", -1);
		if($subgrupo) {
			$consultaRepo = $this->getConsultaRepo();
			$consulta = $consultaRepo->consultaSinRespuestaDeSubgrupoDistintoA($subgrupo);
			if($consulta) {
				if($consulta->getPosta()) {
					if($consulta->getPosta()->getPoi()) {
						if($consulta->getPosta()->getPoi()->getPiezaARecolectar()) {
							if ($consulta->getDecisionParcial()) {
								$pieza = $consulta->getPosta()->getPoi()->getPiezaARecolectar();
								$decisionParcial = $consulta->getDecisionParcial();
								$pregunta = new PreguntaWS(
										$consulta->getId(), //Alex - MODIFICACION necesaria para que desde android se le pase el idConsulta al guardarRespuesta
										$pieza->getNombre(),
										$pieza->getDescripcion(),
										$decisionParcial->getCumpleConsigna(),
										$decisionParcial->getJustificacion(),
										$idSubgrupo //Esto todavia no lo tengo super claro. A que subgrupo se refiere??
								);
							}
						}
					}
				}
			}
		}
			
		return $pregunta;
	}
	
	/**
	 * Retorna las respuestas a la consulta que hizo el subgrupo que se recibe como parametro.
	 * @Soap\Method("existenRespuestas")
	 * @Soap\Param("idSubgrupo", phpType = "int")
	 * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\RespuestaWS[]")
	 */
	public function existenRespuestas($idSubgrupo) {
		//Probado
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->find($idSubgrupo);
		$respuestasResultado = array();
		if($subgrupo) {
			$consultaRealizada = $this->getConsultaRepo()->consultaDeSubgrupo($subgrupo);
			if($consultaRealizada) {
				$respuestasAConsulta = $this->getRespuestaRepo()->respuestasAConsulta($consultaRealizada);
				foreach ($respuestasAConsulta as $respuesta) {
					$respuestasResultado[] = new RespuestaWS(
													$respuesta->getId(),
													$respuesta->getAcuerdoPropuesta(),
													$respuesta->getJustificacion(),
													$respuesta->getSubgrupoConsultado()->getId()
											);
				}
			}
		}
			
		return $respuestasResultado;
	}
	
	/**
	 * Guarda la respuesta a una consulta con los datos que se reciben como parametro.
	 * @Soap\Method("guardarRespuesta")
	 * @Soap\Param("idConsulta", phpType = "int")
	 * @Soap\Param("idSubgrupoConsultado", phpType = "int")
	 * @Soap\Param("acuerdo", phpType = "int")
	 * @Soap\Param("justificacion", phpType = "string")
	 * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\IntegerWS")
	 */
	public function guardarRespuesta($idConsulta, $idSubgrupoConsultado, $acuerdo, $justificacion) {
		//Probado
		//Pasarle el $idConsulta es algo que tenemos que agregar en Android.
		$consultaRepo = $this->getConsultaRepo();
		$consulta = $consultaRepo->find($idConsulta);
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupoConsultado = $subgrupoRepo->find($idSubgrupoConsultado);
		$resultado = 0;
		if ($consulta and $subgrupoConsultado) { //Solo si encontro ambos puedo generar la respuesta.
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
			
		return new IntegerWS($resultado);
	}
	
	/**
	 * Retorna los subgrupos del grupo al que pertenece el subgrupo que se recibe como parametro.
	 * @Soap\Method("getSubgrupos")
	 * @Soap\Param("idSubgrupo", phpType = "int")
	 * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\SubgrupoWS[]")
	 */
	public function getSubgrupos($idSubgrupo) {
		//Probado
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->find($idSubgrupo);
		$subgruposWS = array();
		if ($subgrupo) {
			$subgrupos = $subgrupoRepo->getSubgruposDeGrupo($subgrupo->getGrupo());
			foreach ($subgrupos as $s) {
				$subgruposWS[] = new SubgrupoWS($s->getId(), $s->getNombre());
			}
		}
	
		return $subgruposWS;
	}
	
	/**
	 * Retorna los resultados de cada subgrupo del juego respecto a su decision sobre la pieza asociada.
	 * @Soap\Method("getResultadoFinal")
	 * @Soap\Param("idSubgrupo", phpType = "int")
	 * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\ResultadoWS[]")
	 */
	public function getResultadoFinal($idSubgrupo) { //Alex - chequear si eliminar o dejar el parametro
		//Probado
		$grupoRepo = $this->getGrupoRepo();
		$subgrupoRepo = $this->getSubgrupoRepo();
		$postaRepo = $this->getPostaRepo();
		$grupos = $grupoRepo->findAll();
		$resultados = array();
		foreach ($grupos as $grupo) {
			$subgrupos = $subgrupoRepo->getSubgruposDeGrupo($grupo);
			foreach ($subgrupos as $subgrupo) {
				$posta = $postaRepo->getPostaDeSubgrupo($subgrupo);
				if ($posta) {
					if ($posta->getPoi()) { //Si la posta tiene un poi asociado.
						if ($posta->getPoi()->getPiezaARecolectar()) { //Si el poi de la posta tiene una pieza asociada.
							if ($posta->getDecisionFinal()) { //Si se ha tomado una decision final sobre la posta.
								$pieza = $posta->getPoi()->getPiezaARecolectar();
								$decisionFinal = $posta->getDecisionFinal();
								$decisionCorrecta = ($decisionFinal->getCumpleConsigna() == $pieza->getCumpleConsigna()) ? 1 : 0;
								$resultado = new ResultadoWS(
										$grupo->getId(),
										$grupo->getNombre(),
										$subgrupo->getId(),
										$pieza->getNombre(),
										$decisionFinal->getCumpleConsigna(),
										$decisionCorrecta //Indica si lo que respondio el subgrupo esta bien (1) o mal (0)
								);
								$resultados[] = $resultado;
							}
						}
					}
				}
			}
		}
			
		return $resultados;
	}
}