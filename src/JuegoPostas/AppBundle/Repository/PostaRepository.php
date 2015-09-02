<?php
namespace JuegoPostas\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class PostaRepository extends EntityRepository
{
	
	/** 
	 * Retorna la posta que tiene asignada un determinado subgrupo
	 * 
	 **/
	public function getPostaDeSubgrupo($subgrupo)
	{
		try {
			$qbPosta = $this->createQueryBuilder('posta');
			
			return $qbPosta
				->select('posta')
				->join('posta.subgrupo', 'subgrupo')
				->where($qbPosta->expr()->eq('subgrupo', ':subgrupo'))
				->setParameter('subgrupo', $subgrupo)
				->getQuery()
				->getSingleResult(); //getSingleResult arroja una exepcion si la consulta no devuelve resultado
		} catch (NoResultException $e) {
			return null;
		}
	}
	
}