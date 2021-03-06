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
	
	const ESTADO_FINAL = 4;
	
// 	private $reposManager;
	
	private function getReposManager()
	{
		return $this->container->get('repos_manager');
// 		return $this->reposManager;
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
	
// 	public function __construct($reposManager) {
// 		$this->reposManager = $reposManager;
// 	}
	
	/**
	 * Metodo de logueo al sistema cliente mediante el nombre de subgrupo.
	 * @Soap\Method("login")
     * @Soap\Param("nombreSubgrupo", phpType = "string")
     * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\IntegerWS")
	 */
	public function login($nombreSubgrupo) {
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
	 * Cambia el estado del subgrupo que se recibe como parametro.
	 * @Soap\Method("cambiarEstadoSubgrupo")
	 * @Soap\Param("idSubgrupo", phpType = "int")
	 * @Soap\Param("idEstado", phpType = "int")
	 * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\IntegerWS")
	 */
	public function cambiarEstadoSubgrupo($idSubgrupo, $idEstado) {
		$resultado = 0;
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->find($idSubgrupo);
		if ($subgrupo) {
			$estadoSubgrupo = $this->getEstadoSubgrupoRepo()->find($idEstado);
			if ($estadoSubgrupo) {
				$subgrupo->setEstado($estadoSubgrupo);
				$this->getReposManager()->getEntityManager()->flush();
				$resultado = 1;
			}
		}
		
		return new IntegerWS($resultado);
	}
	
	/**
	 * Retorna la consigna asociada al grupo del subgrupo.
	 * @Soap\Method("getConsigna")
	 * @Soap\Param("idSubgrupo", phpType = "int")
	 * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\ConsignaWS")
	 */
	public function getConsigna($idSubgrupo) {
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->find($idSubgrupo);
		$consignaWS = new ConsignaWS(-1,"","","");
		if ($subgrupo) {
			//Tanto el grupo como la consigna deberian estar seteados. La comprobacion por null de cada uno no corresponderia.
			$grupo = $subgrupo->getGrupo();
			$consigna = $grupo->getConsigna();
			$consignaWS = new ConsignaWS($consigna->getId(), $consigna->getNombre(), $consigna->getDescripcion(), $grupo->getNombre());
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
		$subgrupoRepo = $this->getSubgrupoRepo();
		$consultaRepo = $this->getConsultaRepo();
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
					//No dejo crear dos consultas para la misma posta en la base de datos.
					if(!$consultaRepo->findBy(array('posta' => $posta))){
						$consulta = new Consulta();
						$consulta->setPosta($posta);
						$consulta->setDecisionParcial($decision);
						$em->persist($consulta);
						$em->flush();
					}					
				}				
				$resultado = $idSubgrupo;
			}
		}
		
		return new IntegerWS($resultado);
	}
	
	/**
	 * Retorna 1 si todos los subgrupos del grupo llegaron al estado pasado como parametro. 0 caso contrario.
	 * @Soap\Method("esperarEstadoSubgrupos")
	 * @Soap\Param("idEstado", phpType = "int")
	 * @Soap\Param("idSubgrupo", phpType = "int")
	 * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\IntegerWS")
	 */
	public function esperarEstadoSubgrupos($idEstado, $idSubgrupo) {
		$estadoSubgrupoRepo = $this->getEstadoSubgrupoRepo();
		$subgrupoRepo = $this->getSubgrupoRepo();
		$grupoRepo = $this->getGrupoRepo();	
		$estadoSubgrupo = $estadoSubgrupoRepo->find($idEstado);
		$grupo = ($idSubgrupo && ($subgrupo = $subgrupoRepo->find($idSubgrupo))) ? $subgrupo->getGrupo() : null;
		$resultado = -1;
		if ($estadoSubgrupo && (($idSubgrupo != null && $grupo != null) || ($idSubgrupo == null))) {
			//Si $subgrupo no es null, quiere decir que al menos un subgrupo no est� en el estado pasado como parametro.
			$subgrupo = $subgrupoRepo->subgrupoEnEstadoDistintoDe($estadoSubgrupo, $grupo);
			$subgrupo ? $resultado = 0 : $resultado = 1;
		}
		
		return new IntegerWS($resultado);
	}
	
	/**
	 * Retorna 1 si todos los subgrupos llegaron al estado final. 0 caso contrario.
	 * @Soap\Method("esperarEstadoFinal")
	 * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\IntegerWS")
	 */
	public function esperarEstadoFinal() {
		return $this->esperarEstadoSubgrupos(self::ESTADO_FINAL, null);
	}
	
	/**
	 * Retorna una sola consulta sin responder por y que no sea del subgrupo pasado como parametro, pero que esta en su mismo grupo.
	 * @Soap\Method("existePreguntaSinResponder")
	 * @Soap\Param("idSubgrupo", phpType = "int")
	 * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\PreguntaWS")
	 */
	public function existePreguntaSinResponder($idSubgrupo) {
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
										$consulta->getId(), //Para que desde android se le pase el idConsulta al guardarRespuesta
										$pieza->getNombre(),
										$pieza->getDescripcion(),
										($decisionParcial->getCumpleConsigna() ? 1 : 0),
										$decisionParcial->getJustificacion(),
										$idSubgrupo
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
													$respuesta->getAcuerdoPropuesta() ? 1 : 0,
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
	 * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\ResultadoWS[]")
	 */
	public function getResultadoFinal() {
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
										($decisionFinal->getCumpleConsigna()) ? 1 : 0, //Indica si respondio que Si (1) o que No (2)
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
	
	/**
	 * Retorna 1 si el subgrupo es el actual de su camino. 0 caso contrario.
	 * @Soap\Method("esSubgrupoActual")
	 * @Soap\Param("idSubgrupo", phpType = "int")
	 * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\IntegerWS")
	 */
	public function esSubgrupoActual($idSubgrupo) {
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->find($idSubgrupo);
		$resultado = 0;
		if($subgrupo) {
			if ($camino = $subgrupo->getGrupo()->getCamino()){
				if ($idPosta = $camino->getidPostaActual()){
					if ($posta = $this->getPostaRepo()->find($idPosta)){
						$resultado = ($posta->getSubgrupo()->getId() == $idSubgrupo) ? 1 : 0;
					}
				}
			}
		}
		
		return new IntegerWS($resultado);
	}
	
	/**
	 * Setea como posta actual la posta siguiente a la del subgrupo que se recibe como parametro. Retorna 1 si existe, 0 si es el subgrupo final.
	 * @Soap\Method("setPostaActual")
	 * @Soap\Param("idSubgrupo", phpType = "int")
	 * @Soap\Result(phpType = "JuegoPostas\AppBundle\EntityWS\IntegerWS")
	 */
	public function setPostaActual($idSubgrupo) {
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->find($idSubgrupo);
		$resultado = 0;
		if($subgrupo) {
			if ($posta = $this->getPostaRepo()->getPostaDeSubgrupo($subgrupo)){
				if($camino = $subgrupo->getGrupo()->getCamino()){
					if ($postaSiguiente = $posta->getPostaSiguiente()){
						$idPostaSiguiente = $postaSiguiente->getId();
						$resultado = 1;
					}else{
						$idPostaSiguiente = $camino->getPrimerPosta()->getId();
					}
					$camino->setIdPostaActual($idPostaSiguiente);
					$this->getReposManager()->getEntityManager()->flush();
				}
			}
		}
		
		return new IntegerWS($resultado);
	}
}