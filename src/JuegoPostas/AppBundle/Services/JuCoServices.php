<?php
namespace JuegoPostas\AppBundle\Services;

use JuegoPostas\AppBundle\Services\ReposManager;
use JuegoPostas\AppBundle\EntityWS\SubgrupoWS;
use JuegoPostas\AppBundle\EntityWS\PoiWS;
use Symfony\Component\Debug\Exception\FatalErrorException;

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
	
	/**
	 * Metodo de logueo al sistema cliente mediante el nombre de subgrupo
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
	 * Retorna el punto inicial del subgrupo que se recibe como parametro
	 * @param integer $idSubgrupo
	 * @return object
	 */
	public function getPuntoInicial($idSubgrupo) {
		$subgrupoRepo = $this->getSubgrupoRepo();
		$subgrupo = $subgrupoRepo->find($idSubgrupo);
		$poiWS = new PoiWS(-1, -1, -1);
		if (null !== $subgrupo) {
			$posta = $this->getPostaRepo()->getPostaDeSubgrupo($subgrupo);
			if (null !== $posta) {
				$poi = $posta->getPoi();
				if (null !== $poi) {
					$poiWS = new PoiWS($poi->getId(), $poi->getCoordenadaX(), $poi->getCoordenadaY());
				}
			}
		}
		
		return $poiWS;
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