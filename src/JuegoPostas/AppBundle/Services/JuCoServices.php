<?php
namespace JuegoPostas\AppBundle\Services;

use JuegoPostas\AppBundle\Services\ReposManager;

class JuCoServices {
	
	protected $reposManager;
	
	public function __construct(ReposManager $reposManager)
	{
		$this->reposManager = $reposManager;
	}
	
	public function getReposManager()
	{
		return $this->reposManager;
	}
	
	/**
	 * Retorna los subgrupos del grupo al que pertenece el subgrupo que se recibe como parametro
	 * @param integer $idSubgrupo
	 * @return array
	 */
	public function getSubgrupos($idSubgrupo) {
		$subgrupoRepo = $this->getReposManager()->getSubgrupoRepo();
		$subgrupoActual = $subgrupoRepo->find($idSubgrupo);
		$subgrupos = $subgrupoRepo->getSubgruposDeGrupo($subgrupoActual->getGrupo());
		
		return $subgrupos;
	}
	
	/**
	 * Retorna los subgrupos del grupo al que pertenece el subgrupo que se recibe como parametro
	 * @param string $idSubgrupo
	 * @return string
	 */
	public function getHolahola($idSubgrupo) {
	
		return 'Hola hola';
	}
	
}