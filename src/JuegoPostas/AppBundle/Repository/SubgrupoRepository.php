<?php
namespace JuegoPostas\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class SubgrupoRepository extends EntityRepository
{
	
	/*Retorna los subgrupos de un determinado grupo*/
	public function getSubgruposDeGrupo($grupo) {
		
		$qbSubgrupo =  $this->createQueryBuilder('subgrupo');
		
		return $qbSubgrupo
			->select('subgrupo')
			->join('subgrupo.grupo', 'grupo')
			->where($qbSubgrupo->expr()->eq('grupo', ':grupo'))
			->setParameter('grupo', $grupo)
			->orderBy('subgrupo.id')
			->getQuery()
			->getResult();
	}
	
	/*Retorna el primer subgrupo cuyo estado no sea igual al recibido como parametro*/
	public function subgrupoEnEstadoDistintoDe($estadoSubgrupo) {		
		try {
			$qbSubgrupo = $this->createQueryBuilder('subgrupo');
			
			return $qbSubgrupo
				->select('subgrupo')
				->join('subgrupo.estado', 'estado')
				->where($qbSubgrupo->expr()->neq('estado', ':estado'))
				->setParameter('estado', $estadoSubgrupo)
				->getQuery()
				->setMaxResults(1) //Para evitar que getSingleResult arroje una NoUniqueResultException en caso que haya mas de un resultado
				->getSingleResult(); //getSingleResult arroja una exepcion si la consulta no devuelve resultado
		} catch (NoResultException $e) {
			return null;
		}
	}
	
}